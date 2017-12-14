<?php 
include '../inc/conexion.php';
include("../mod_sql/sql.php");
include("../mod_sql/funciones2.php");
include('../inc/sesion.php');
$db = Conexion();
 if(!empty($_POST)) 
 {  
      $output = '';  
      $message = '';  
      $nombre_lugar = $_POST["txt_nombre_actualizar"];  
	  $nro_calle = $_POST["txt_nro_calle_actualizar"];
      
    
      if($_POST["employee_id"] != '')  
      {  
        $query = "  
        UPDATE `tup_lugares_trabajo` SET 												        `nombre_lugar`='$nombre_lugar',
		`nro_calle`='$nro_calle' 
		WHERE id_lugar='".$_POST["employee_id"]."'";  
        
           
      }  
      
      if(mysqli_query($db, $query))  
      {  
        auditar($_SESSION['id'],$query);
        $output.="Dato actualizado correctamente";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'lugares_trabajos.php';";
        echo "</script>";
      }else{

        $output.="Error al actualizar!";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'lugares_trabajos.php';";
        echo "</script>";
      }  
      //echo $output;  
 }  
 ?>
 