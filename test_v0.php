
<?php

$NUMPERPAGE = 3; // max. number of items to display per page
$this_page = "/Highburry_Media/test_v1.php";
    // initialising the api call
    $ch=curl_init();
    $api_url= "https://dealer.carmag.co.za/api.php?getlistings=1";
    curl_setopt($ch,CURLOPT_URL,$api_url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $resp=curl_exec($ch);
    if($error=curl_error($ch)){
    echo $error;
    }else{
          $products= json_decode($resp,true);
         
          // print_r($products);
          $all_products = array($products);

          // print_r($all_products[0]);
          foreach ($all_products as $product) {
              // echo $product;
              // print_r($product);
              
          }

          // getting the total parent 
          foreach ($all_products as $product_ITEM) {
            // echo $product_ITEM;
            $B=count($product_ITEM);
            echo "number parent variable ".$B."<br/> ";
          
        }

        // number is children array
        $all_d = $product_ITEM['listings'] ;
        $index_array = count($all_d);
        echo " number of children variable under Index[0] : ".$index_array."<br/><br/>";
        


        
        // #############################################
        
        
    }
    curl_close($ch);
    
?>




<?PHP
  
  // creating and conditioning page
  if(!isset($_GET['page']) || !$page = intval($_GET['page'])) {
    $page = 1;
  }

  // extra variables to append to navigation links (optional)
  $linkextra = [];
  if(isset($_GET['var1']) && $var1 = $_GET['var1']) { 
    $linkextra[] = "var1=" . urlencode($var1);
    
  }
  $linkextra = implode("&amp;", $linkextra);
  if($linkextra) {
    $linkextra .= "&amp;";
  }

  // build array containing links to all pages
  $tmp = [];
  for($p=1, $c=0; $c < $index_array; $p++, $c += $NUMPERPAGE) {
    if($page == $p) {

      // current page shown as bold, no link
      $tmp[] = "<b>{$p}</b>";
    } else {
      $tmp[] = "<a href=\"{$this_page}?{$linkextra}page={$p}\">{$p}</a>";
    }
  }

  // thin out the links (optional)
  for($i = count($tmp) - 3; $c > 1; $c--) {
    if(abs($page - $c - 1) > 2) {
      unset($tmp[$c]);
    }
  }

  // display page navigation iff data covers more than one page
  if(count($tmp) > 1) {
    echo "<p>";

    if($page > 1) {

      // display 'Prev' link
      echo "<a href=\"{$this_page}?{$linkextra}page=" . ($page - 1) . "\">&laquo; Prev</a> | ";
    } else {
      echo "Page ";
    }

    $lastlink = 0;
    foreach($tmp as $i => $link) {
      if($i > $lastlink + 1) {
        echo " ... "; // where one or more links have been omitted
      } elseif($i) {
        echo " | ";
      }
      echo $link;
      $lastlink = $i;
    }

    if($page <= $lastlink) {
      // display 'Next' link
      echo " | <a href=\"{$this_page}?{$linkextra}page=" . ($page + 1) . "\">Next &raquo;</a>";
    }

    echo "</p>\n\n";
  }


  // #############################################################
  //  DATA TO BE DISPLAY TO THE PAGE
  // #############################################################


  // $data = new \ArrayIterator($data); // NOT needed if $data is already an Iterator!
  $data = new \ArrayIterator($all_d); // NOT needed if $data is already an Iterator!
  $it = new \LimitIterator($data, ($page - 1) * $NUMPERPAGE,$NUMPERPAGE );
  try {
    $it->rewind();
    // echo $it;
    foreach($it as $row) {
      $id=$row['id'];
      $make=$row['make'];
      $model=$row['model'];
      $image=$row['image1'];

           
         
      // echo $id;   
      // echo "/car make:  ".$id."<br/>"; 
      
      // display record
      echo "<table>";
      echo"
                  <tr>
                    <div>
                      <td>Car id : $id</td>
                      <td>Car Make : $make</td>
                      <td>Car Model: $model</td>
                    </div>
                    <br/>
                    <div>
                    <td><img src='$image' ></td>
                    </div>
                    
                  </tr>
                  
              " ;
      echo "<table>";

    };
    
  } catch(\OutOfBoundsException $e) {
    echo "Error: Caught OutOfBoundsException";
    
  }

  

  
?>
    
