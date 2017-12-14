<?php
include ('../inc/conexion.php');


 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      $db= Conexion();  
      $query = "SELECT * FROM canones WHERE id_canon = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($db, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
                <tr>  
                     <td width="30%"><label>Observaciones</label></td>  
                     <td width="70%">'.$row["observaciones"].'</td>  
                </tr>
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>