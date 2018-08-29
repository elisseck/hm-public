<?php
namespace Drupal\thm_timeline\Controller;


$link = \Drupal::service('database');


class TimeLineController {

    public function timeline() {

        function getSQLData($sql){
           $query = db_query($sql);
           $result = $query -> fetchAll();
           return $result;
        }



        $content = array();
        $pagination = '';
        $sql="";
        $day=null; $month=null; $year=null;


        // Check connection
        if (mysqli_connect_errno()){  echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
           $page_number = isset($_GET['page']) ? $_GET['page'] : '1';
           $page_offset = 20 * ($page_number -1);
           $dateSelector = "";
        if( isset($_GET['day']) || isset($_GET['month']) || isset($_GET['year'])){
            $day = $_GET['day']; $month = $_GET['month']; $year = $_GET['year'];
            //month day year are set
          if( !empty($month) && !empty($day) && !empty($year)){
            $dateSelector = " = '$month/$day/$year'";
          }
          /// month and day are set

          else if (!empty($month) && !empty($day)){
            $dateSelector = "LIKE '$month/$day/%'";

          }
          else if (!empty($month) && !empty($year)){
              $dateSelector = "LIKE '$month/%/$year'";
          }

            //only month is setup
          else if(!empty($year)){
            $dateSelector = "LIKE '%/$year'";
          }

          if (empty($dateSelector)){
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $page = isset($_GET['page']) ? $_GET['page'] : '1';
                isset($_GET['page']) ?  $page = $_GET['page'] : $page = '1';
                $extra = 'timeline?page='.$page;
                header("Location: http://$host$uri/$extra");
                exit;
          }
          else{
             $query= "SELECT @type := 'birth' as type, field_birth_date_value  as date, entity_id as nid
             FROM `node__field_birth_date` WHERE field_birth_date_value $dateSelector
             UNION SELECT  @type := 'death' as type, field_death_date_value  as date,
             entity_id as nid FROM `node__field_death_date` WHERE field_death_date_value $dateSelector
             UNION SELECT @type := 'milestone' as type,
             field_timeline_year_value as date, entity_id as nid FROM `paragraph__field_timeline_year`
             WHERE field_timeline_year_value $dateSelector
             ORDER BY DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d')";

             $limit = "DESC LIMIT 20 OFFSET $page_offset";
             $sql = $query . $limit;


             $resultsCount = getSQLData("SELECT COUNT( * ) as count FROM ($query) AS a")[0] -> count;


          }

        }else{

            $sql = "SELECT @type := 'birth' as type, field_birth_date_value  as date, entity_id as nid
            FROM `node__field_birth_date` WHERE field_birth_date_value <> '?'
            UNION SELECT  @type := 'death' as type, field_death_date_value  as date,
            entity_id as nid FROM `node__field_death_date` WHERE field_death_date_value <> '?'
            UNION SELECT @type := 'milestone' as type, field_timeline_year_value as date, entity_id
            as nid FROM `paragraph__field_timeline_year` WHERE field_timeline_year_value <> '?'
            ORDER BY DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') DESC LIMIT 20 OFFSET $page_offset";
            $resultsCount = getSQLData("SELECT COUNT( * ) as count FROM (SELECT * FROM `node__field_birth_date` WHERE field_birth_date_value <> '?'
            UNION SELECT * FROM `node__field_death_date` WHERE field_death_date_value <> '?') AS a")[0] -> count;

        }


        if(!empty($sql)){
          $rows = getSQLData($sql);

        }


         if ($rows) {
             foreach ($rows as $row) {
               // print_r($row-> type);
                   $nid = $row -> nid;
                   $date = $row -> date;
                   $type = $row -> type;

                   if($type == 'birth' || $type=="death"){
                       $name =  getSQLData("SELECT * from `node_field_data` WHERE `nid` = '$nid'")[0] -> title;
                       $file_id = getSQLData("SELECT * from `node__field_bio_image` WHERE `entity_id` = '$nid'")[0] -> field_bio_image_target_id;
                       $file = getSQLData("SELECT * from `file_managed` WHERE `fid` = '$file_id'")[0] -> uri;
                       $img = str_replace('public://', '', $file);
                       $bio_info = getSQLData("SELECT * from `node__field_description` WHERE `bundle`='bio' AND `entity_id`='$nid'")[0] -> field_description_value;
                       if (strlen($bio_info) >= 150) {
                         $bio = substr($bio_info, 0, strpos(wordwrap($bio_info, 150), "\n"));
                       } else {
                         $bio = substr($bio_info, 0, strpos(wordwrap($bio_info, strlen($bio_info) - 20), "\n"));
                       }
                   }

                   else if($type == "milestone"){
                       $name = "Milestone";
                       $image_id_result = getSQLData("SELECT * from `paragraph__field_timeline_image` where `entity_id` = '$nid'");
                       $image_id = isset($image_id_result[0]) ? $image_id_result[0] -> field_timeline_image_target_id : '';
                       $file = getSQLData("SELECT * from `file_managed` WHERE `fid` = '$image_id'");
                       $img =  isset($file[0]) ? str_replace('public://', '', $file[0] -> uri) : '';
                       $milestone_intro = getSQLData("SELECT * from `paragraph__field_timeline_intro` where `entity_id` = '$nid'")[0] -> field_timeline_intro_value;
                       $bio = substr($milestone_intro, 0, strpos(wordwrap($milestone_intro, 150), "\n"));
                       $nid = getSQLData("SELECT * from `node__field_timeline_entry` where `field_timeline_entry_target_id` = '$nid'")[0] -> entity_id;
                   }

                   $final = array('date' => $date, 'type' => $type, 'nid' => $nid, 'name' => $name, 'img' => $img, 'bio' => $bio);

                   array_push($content, $final);
             }
          }


           function get_paging_info($tot_rows,$pp,$curr_page)
           {
                $pages = ceil($tot_rows / $pp); // calc pages
                $data = array(); // start out array
                $data['si']        = ($curr_page * $pp) - $pp; // what row to start at
                $data['pages']     = $pages;                   // add the pages
                $data['curr_page'] = $curr_page;               // Whats the current page
                return $data; //return the paging data
           }

          function pagination($sql,$page_number, $resultsCount, $day, $month, $year) {
               $paging_info = get_paging_info($resultsCount, 20, $page_number);
               $html ="";
                if($paging_info['curr_page'] > 1) {
                   $prevPage = $paging_info['curr_page'] - 1;
                   $html .= "<li class='pager__item'><a href='?page=$prevPage&year=$year&month=$month&day=$day' title='Page $prevPage'> << </a></li> ";
                }

                $max = 7;
                if($paging_info['curr_page'] < $max)
                $sp = 1;
                elseif($paging_info['curr_page'] >= ($paging_info['pages'] - floor($max / 2)) )
                $sp = $paging_info['pages'] - $max + 1;
                elseif($paging_info['curr_page'] >= $max)
                $sp = $paging_info['curr_page']  - floor($max/2);

                if($paging_info['curr_page'] >= $max) {  $html .= " <li class='pager__item'><a href='?page=1&year=$year&month=$month&day=$day' title='Page 1'>1 ..</a></li>"; }

                for($i = $sp; $i <= ($sp + $max -1);$i++)
                {
                   if($i > $paging_info['pages']) { continue; }
                   if($paging_info['curr_page'] == $i){  $html .= "<li class='pager__item is-active'> <a href=''><span class='bold'>$i</span> </a>";}
                   else{; $html .="<li class='pager__item'><a href='?page=$i&year=$year&month=$month&day=$day' title='Page $i'> $i </a></li>";}
                }


                if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))){
                     $page_info_pages = $paging_info['pages'];
                     $html .= "<li class='pager__item'><a href='?page=$page_info_pages&year=$year&month=$month&day=$day' title='Page $page_info_pages'>.. $page_info_pages </a></li>";
                }

                if($paging_info['curr_page'] < $paging_info['pages']){
                       $nextPage = $paging_info['curr_page'] + 1;
                       $lastPage = $paging_info['pages'];
                       $html .= "<li class='pager__item'><a href='?page=$nextPage&year=$year&month=$month&day=$day' title='Page $nextPage'> >> </a></li>";
                }
                return $html;
            }

          $pagination = pagination($sql, $page_number, $resultsCount, $day, $month, $year);






             return array(
              '#theme' => 'timeline',
              '#title' => 'headline',
              '#resultsCount' => $resultsCount,
              '#markup' => "",
              '#content' => $content,
              '#pages' => $pagination,
             );



    }




}



?>
