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
      $nombre_tipo_pago = $_POST["txt_nombre_actualizar"];  
      
    
      if($_POST["employee_id"] != '')  
      {  
        $query = "  
        UPDATE tipo_pago   
        SET nombre_tipo_pago='$nombre_tipo_pago'
        WHERE id_tipo_pago='".$_POST["employee_id"]."'";  
        
           
      }  
      
      if(mysqli_query($db, $query))  
      {  
        auditar($_SESSION['id'],$query);
        $output.="Dato actualizado correctamente";

        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'pagos.php';";
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
 