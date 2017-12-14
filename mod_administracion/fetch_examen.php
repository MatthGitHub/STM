<?php  
 //fetch.php  
include '../inc/conexion.php';
include("../mod_sql/sql.php");
$db = Conexion();  
if(isset($_POST["employee_id"]))  
{  
  $query = "SELECT * FROM tipos_examenes WHERE id_tipo_examen = '".$_POST["employee_id"]."'";  
  $result = mysqli_query($db, $query);  
  $row = mysqli_fetch_array($result);  
  echo json_encode($row);  
}  
?>