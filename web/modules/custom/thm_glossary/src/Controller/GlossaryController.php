<?php
namespace Drupal\thm_glossary\Controller;


$link = \Drupal::service('database');


class GlossaryController {

      public function glossary(){
            $content = '';
            $alphabet = array('num', 'A','B','C','D','E','F','G','H','I','J','K','L',
            'M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            $page = isset($_GET['page']) ?  $_GET['page'] : 'A';
            $sql ="";
            if ($page == 'num'){
              $sql = "WHERE title REGEXP '^[0-9]'";
            }else{
              $sql = "WHERE (`type` = 'bio' AND field_last_name_value LIKE '$page%')
              OR (`type` != 'bio' AND title LIKE '$page%')  ORDER BY sort asc";
            }

            function trunc($string, $limit, $break=".", $pad="...")
            {
              // return with no change if string is shorter than $limit
              if(strlen($string) <= $limit) return $string;

              // is $break present between $limit and the end of the string?
              if(false !== ($breakpoint = strpos($string, $break, $limit))) {
                if($breakpoint < strlen($string) - 1) {
                  $string = substr($string, 0, $breakpoint) . $pad;
                }
              }

              return $string;
            }
            function getSQLData($sql){
               $query = db_query($sql);
               $data = $query -> fetchAll();
               return $data;
            }
        //
           $result = getSQLData("SELECT *, IF(`type` <> 'bio', title, field_last_name_value) as sort, node_field_data.nid as link
            FROM `node_field_data`
            LEFT JOIN `node__body` ON node_field_data.nid = node__body.entity_id
            LEFT JOIN `node__field_last_name` ON node_field_data.nid = node__field_last_name.entity_id
            lEFT JOIN `node__field_first_name` ON node_field_data.nid = node__field_first_name.entity_id
            LEFT JOIN `node__field_middle_name` ON node_field_data.nid = node__field_middle_name.entity_id
            LEFT JOIN `node__field_member_info` ON node_field_data.nid = node__field_member_info.entity_id
            LEFT JOIN (SELECT field_timeline_intro_value, node__field_timeline_entry.entity_id as nid FROM `node__field_timeline_entry`
            JOIN `paragraph__field_timeline_intro` ON  node__field_timeline_entry.field_timeline_entry_target_id = paragraph__field_timeline_intro.entity_id) AS timeline_data
            ON node_field_data.nid = timeline_data.nid $sql");
            foreach ($result as $item){
                $title  = $item -> title;
                $lastName = $item -> field_last_name_value;
                $firstName = $item -> field_first_name_value;
                $middleName = $item -> field_middle_name_value;
                $member_info_target_id = $item -> field_member_info_target_id;
                $timeline_intro_value = $item -> field_timeline_intro_value;
                $bundle = $item -> type;
                $link = $item -> link;
                if ($firstName != NULL && $lastName != NULL)  {
                  $title = $lastName . ", " . $firstName . " " . $middleName;
                }
                $body = $item -> body_value;
                $summary = '<p>'. trunc($body, 300) .'</p>';
                if($member_info_target_id != NULL)
                {
                  $result = getSQLData("SELECT field_bio_value FROM `paragraph__field_bio` WHERE `entity_id` = $member_info_target_id");
                  if(!empty($result)){
                      $body = $result[0] -> field_bio_value;
                      $summary = trunc($body, 300);
                  }
                }
                if($timeline_intro_value != NULL){
                  $body = strip_tags ($timeline_intro_value);
                  $summary = trunc($body, 300);
                }

              $content .=
              "<li style='border:none; margin-bottom: 40px;'>
                 <a type='$bundle' style='".( $bundle != 'bio' ? 'color: #232323;': '' )."'  href='/node/$link'><h3 class='title'>$title</h3></a>
                 <div class='body'>$summary</div>
              </li>";
           }



        return array(
         '#theme' => 'glossary',
         '#title' => 'TEST',
         '#resultsCount' => '',
         '#markup' => "",
         '#content' => $content,
         '#pages' => $alphabet,
         '#currentPage' => $page,
        );
      }
}

?>
