<?php 
include '../inc/conexion.php';
include("../mod_sql/sql.php");
include('../inc/sesion.php');
include("../mod_sql/funciones2.php");
$db = Conexion();
 if(!empty($_POST)) 
 {  
      $output = '';  
      $message = '';  
      $nombre_tipo_examen = $_POST["txt_nombre_actualizar"];  
	  $profesion_examen = $_POST["txt_profesion_actualizar"];
      
    
      if($_POST["employee_id"] != '')  
      {  
        $query = "  
        UPDATE tipos_examenes   
        SET nombre_tipo_examen='$nombre_tipo_examen',
		fk_id_profesion='$profesion_examen'
        WHERE id_tipo_examen='".$_POST["employee_id"]."'";  
        
           
      }  
      
      if(mysqli_query($db, $query))  
      {  

        auditar($_SESSION['id'],$query);
        $output.="Dato actualizado correctamente";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'examenes.php';";
        echo "</script>";
      }else{

        $output.="Error al actualizar!";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'pagos.php';";
        echo "</script>";
      }  
      //echo $output;  
 }  
 ?>
 