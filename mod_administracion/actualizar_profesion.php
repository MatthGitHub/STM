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
      $nombre_profesion = $_POST["txt_nombre_actualizar"];  
      
    
      if($_POST["employee_id"] != '')  
      {  
        $query = "  
        UPDATE profesiones   
        SET nombre_profesion='$nombre_profesion'
        WHERE id_profesion='".$_POST["employee_id"]."'";  
        
           
      }  
      
      if(mysqli_query($db, $query))  
      {  
        auditar($_SESSION['id'],$query);
        $output.="Dato actualizado correctamente";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'profesiones.php';";
        echo "</script>";
      }else{

        $output.="Error al actualizar!";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'profesiones.php';";
        echo "</script>";
      }  
      //echo $output;  
 }  
 ?>
 