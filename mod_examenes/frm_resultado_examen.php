<?php  

include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');

$db= Conexion();

//SELECCIONO TIPOS DE EXAMENES

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$id_examen = $_POST['txt_id_examen'];
	$tipo_examen = $_POST['txt_tipo_examen'];

	$nombre = $_POST['txt_nombre'];
	$apellido = $_POST['txt_apellido'];
	$documento = $_POST['txt_documento'];

	$examen = buscar_examen($id_examen);

	//Lleno los campos

	 while ($row = mysqli_fetch_assoc($examen)) 
	 {
 	 	$fecha_solicitud = fecha_mysql_normal($row['fecha_solicitud']);
	 	$fecha_examen = fecha_mysql_normal($row['fecha_examen']);
	 	$hora_examen = $row['hora_examen'];
	 	$resultado = $row['resultado'];
	 	$observaciones = $row['observaciones'];
	 }


}

$output='';
$mensaje=false;

if(isset($_POST['btn_modificar'])) {

 	$examen = $_POST['txt_id_examen'];

 	$resultado = $_POST['select_resultado'];
 	
 	$observaciones = $_POST['txt_observaciones'];	


	$query = "UPDATE `tup_examenes` SET `resultado`='$resultado',
	`observaciones`='$observaciones'
	WHERE id_examen ='$examen'";

	$modificar = mysqli_query($db,$query);

	if($modificar){
	
		$output.="Resultado registrado correctamente";
	
		echo "<script>";
	    echo "alert('$output');";
    	echo "window.location = 'examenes.php';";
    	echo "</script>";
	
	}else{
		$mensaje = true;
		$output.="Error al registrar el resultado";
	}

}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/logo.png" sizes="16x16">
    <title>Sistema Turismo MSCB</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
	<!--script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script-->

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">

</head>


<body onLoad="document.form1.txt_resultado.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
					<div class="panel panel-default">
						<div class="panel-body">

									<?php 
									
									if ($mensaje==true){
										echo "<div class='alert alert-warning'>
  											<strong>Error!</strong> $output.
											</div>";
									 
									}
									
									?>
									<h4 class="text-center"><img src="../images/resultado_examen.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

									<h3 class="text-center bg-info">Registrar Resultado</h3>

									<div class="col-md-6 col-md-offset">
									<h4 class="text-center bg-info">Datos Persona</h4>
                                    <h4>Nombre y Apellido : <?php echo '<strong>'.$nombre.' '.$apellido.'</strong>'; ?></h4>
                                    <h4>Documento : <?php echo '<strong>'.$documento.'</strong>'; ?></h4>
                                   
                                    <h4 class="text-center bg-info">Datos del Exámen</h4>
                                    <h4>Fecha de solicitud : <?php echo '<strong>'.$fecha_solicitud.'</strong>'; ?></h4>
                                    <h4>Fecha de exámen : <?php echo '<strong>'.$fecha_examen.'</strong>'; ?></h4>
                                    <h4>Hora de exámen : <?php echo '<strong>'.$hora_examen.'</strong>';?></h4>
                                    <h4>Tipo de exámen : <?php echo '<strong>'.$tipo_examen.'</strong>' ;?></h4>
                                 									
										
									</div>
									
									<div class="col-md-6 col-md-offset">
                                    
	                                   <div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Resultado </span>
												<div class="col-xs-15 selectContainer">
	                                            <select class="form-control" name="select_resultado">
													<option value="Aprobado">APROBADO</option>
	                                                <option value="Desaprobado">DESAPROBADO</option>
	                                                <option value="Ausente">AUSENTE</option>
	                                                  
												</select>
													<input type="hidden" name="resultado" value="<?php echo $resultado;?>"/>
												</div>
											</div>
										</div>
	                                            
	                                    <div class="form-group">
	                   						<span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
	                   						<textarea class="form-control" rows="3" id="txt_observaciones" name="txt_observaciones" onKeyPress="return tabular(event,this)" ><?php echo $observaciones; ?></textarea>

                   							<input type="hidden" name="txt_id_examen" value="<?php echo $id_examen; ?>">
	                					</div>
	                                    
	                                            	
											<input type="submit" name="btn_modificar" class="btn btn-success form-control" value="GUARDAR"/>
									</div>
								</div>
						</div>
						
				</form>
			</div></div>
		</div>
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
	</div>

	</body>
    
    <script type="text/javascript">

$('#divMiCalendarioHabilitacion').datetimepicker({
      format: 'DD-MM-YYYY'
    });

$('#divMiCalendarioVencimiento').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>
    
</html>