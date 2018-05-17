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
              $sql = "WHERE `vid` = 'glossary' AND name REGEXP '^[0-9]'";
            }else{
              $sql = "WHERE `vid` = 'glossary' AND `name` LIKE '$page%' ORDER BY name asc";
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

            $result = getSQLData("SELECT * FROM `taxonomy_term_field_data` $sql");
            foreach ($result as $item){

                $title = $item -> name;

                $myArray = explode(',', $title);
                $firstName = isset($myArray[1]) ? $myArray[1] : "";
                $lastName = isset($myArray[0]) ? $myArray[0] : "";

                $fullName = trim("$firstName $lastName");


                $info = getSQLData("SELECT * FROM `node_field_data` WHERE `title` = '$fullName'");

                $type = isset($info[0] -> type) ? $info[0] -> type : 'article';

                $nid = isset($info[0] -> nid) ? $info[0] -> nid  : '#';

                $summary = $item -> description__value;

                $tid = $item -> tid;

                // $content .=
                // "<li style='border:none; margin-bottom: 40px;'>
                //    <a type='$type' style='".( $type == 'bio' ? '' : 'color: #232323;' )."' href='/node/$nid'><h3 class='title'>$title</h3></a>
                //    <div class='body'>$summary</div>
                // </li>";
                if($type == 'bio'){
                  $content .= "<li style='border:none; margin-bottom: 40px;'>
                                 <a type='$type' href='/node/$nid'><h3 class='title'>$title</h3></a>
                                 <div class='body'>$summary</div>
                              </li>";
                }else{
                  $content .= "<li style='border:none; margin-bottom: 40px;'>
                                 <h3 class='title'>$title</h3>
                                 <div class='body'>$summary</div>
                              </li>";
                }
           }


           if((strlen($content)) < 1){
             $content .= "<h5> There is no result for $page. </h5>";
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
