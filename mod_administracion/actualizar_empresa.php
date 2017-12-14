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
      $nombre = $_POST["txt_nombre_actualizar"];  
	  $cuit = $_POST["txt_cuit_actualizar"];
	  $email = $_POST["txt_email_actualizar"];
      
    
      if($_POST["employee_id"] != '')  
      {  
        $query = "  
        UPDATE tup_empresas   
        SET nombre_empresa='$nombre',
		cuit_empresa='$cuit',
		email_empresa='$email'
        WHERE id_empresa='".$_POST["employee_id"]."'";  
        
           
      }  
      
      if(mysqli_query($db, $query))  
      {  
        auditar($_SESSION['id'],$query);
        $output.="Dato actualizado correctamente";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'empresas.php';";
        echo "</script>";
      }else{

        $output.="Error al actualizar!";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'empresas.php';";
        echo "</script>";
      }  
      //echo $output;  
 }  
 ?>
 