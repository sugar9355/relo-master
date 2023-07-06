<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"]))  
 {  
      $connect = mysqli_connect("localhost", "fidaride_taxi", "QDsZ;BazhKad", "fidaride_taxi");  
      $output = '';  
      $query = "  
           SELECT * FROM providers  
           WHERE create_date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'  
      ";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
           <table class="table table-bordered">  
                <tr>  
                     <th width="5%">ID</th>  
                     <th width="30%">Customer Name</th>  
                     <th width="43%">Item</th>  
                     <th width="10%">Value</th>  
                     <th width="12%">Order Date</th>  
                </tr>  
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>'. $row["id"] .'</td>  
                          <td>'. $row["firstname"] .'</td>  
                          <td>'. $row["lastname"] .'</td>  
                          <td>'. $row["email"] .'</td>  
                          <td>'. $row["created_at"] .'</td>  
                     </tr>  
                ';  
           }  
      }  
      else  
      {  
           $output .= '  
                <tr>  
                     <td colspan="5">No Order Found</td>  
                </tr>  
           ';  
      }  
      $output .= '</table>';  
      echo $output;  
 }  
 ?>
