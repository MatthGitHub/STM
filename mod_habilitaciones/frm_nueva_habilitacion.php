
<?php
include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');
include('../inc/sesion.php');

$db= Conexion();
//--------------------------------Inicio de sesion------------------------
/*include("../lib/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}*/
//--------------------------------Fin inicio de sesion------------------------


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nombre_profesion = $_POST['txt_nombre_profesion'];
	$profesion = $_POST['txt_fk_id_profesion'];
	$txt_identificador = test_input($_POST['txt_fk_id_persona']);
	$txt_nombre = test_input($_POST['txt_nombre']);
	$txt_apellido = test_input($_POST['txt_apellido']);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['guardar_habilitacion'])){
	
	$output = '' ;
	$nro_habilitacion = $_POST['txt_nro_habilitacion'];
	$fecha_desde = fecha_normal_mysql($_POST['txt_fecha_desde']);
	$fecha_hasta = fecha_normal_mysql($_POST['txt_fecha_hasta']);
	$observacion = $_POST['txt_observacion'];
	$estado =  $_POST['select_estado'];
	$profesion = $_POST['txt_id_profesion'];
	$txt_identificador = test_input($_POST['txt_identificador']);
	
	
	if($_POST['entregada']=="")
	{
		$entregada=0;
	}else{
		$entregada=1;
	};

	$mensaje = false;
	
		
	$sql = "INSERT INTO `tup_habilitaciones`
	(`nro_habilitacion`, 
	`fecha_desde`, 
	`fecha_hasta`, 
	`entregada`, 
	`observaciones`, 
	`estado`,
	`fk_id_persona`, 
	`fk_id_profesion`) 
	VALUES 
	('$nro_habilitacion',
	'$fecha_desde',
	'$fecha_hasta',
	'$entregada',
	'$observacion',
	'$estado',
	'$txt_identificador',
	'$profesion')";
	
	$guardar_habilitacion = mysqli_query($db,$sql);
	
	if($guardar_habilitacion) {

		auditar($_SESSION['id'],$sql);
	
		$output.="Registro guardado correctamente";

		echo "<script>";
		echo "alert('$output');";
		echo "window.location = 'habilitaciones.php';";
		echo "</script>";
	}
		
	else {
	$mensaje = true;
	$output.=" al guardar la Habilitación";
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

    <script type="text/javascript">

		function validar_frm(f)
		{
			if(document.form1.txt_fecha_desde.value > document.form1.txt_fecha_hasta.value)
			{
				alert('La fecha DESDE de habilitación, no puede ser mayor a la fecha HASTA.');
				return false;
			}
		}
								
    </script>
</head>


<body onLoad="document.form1.txt_nro_habilitacion.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
							
						<div class="row">
							<div class="panel panel-default">
								<div class="panel-body">

									<h4 class="text-center"><img src="../images/nueva_habilitacion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
									
									<div class="panel panel-default">
										<div class="panel-body">

											<?php 
											
											if ($mensaje==true){
												echo "<div class='alert alert-warning'>
		  											<strong>Error!</strong> $output.
													</div>";
											 
											}
											
											?>

											<h3 class="text-center bg-info">Nueva Habilitación</h3>
											<h4 class="text-center bg-info">Datos Persona</h4>

											<div class="col-md-6 col-md-offset">
												<div class="panel panel-default">	
											
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
														<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre; ?>" disabled="disabled"/>
													</div>
												</div>

												</div>
											</div>
											
											<div class="col-md-6 col-md-offset">
												<div class="panel panel-default">
													
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
															<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $txt_apellido;?>" disabled="disabled"/>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
									<h4 class="text-center bg-info">Datos Habilitación</h4>
									
									<div class="col-md-6 col-md-offset">
										<div class="panel panel-default">
											<div class="panel-body">

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Profesión</span>
														<input name="txt_nombre_profesion" type="text" class="form-control" id="txt_nombre_profesion" value="<?php echo $nombre_profesion;?>" disabled="disabled"/>

														<input type="hidden" name="txt_id_profesion" value="<?php echo $profesion; ?>">
												     	<input type="hidden" name="txt_identificador" value="<?php echo $txt_identificador; ?>">
													</div>
												</div>

												 <div class="form-group">
						                            <div class="input-group">
						                              <span class="input-group-addon"><i class="fa fa-asterisk fa-fw"></i> Nº Registro</span><input name="txt_nro_habilitacion" type="number" class="form-control" id="txt_nro_habilitacion" value="<?php echo $nro_habilitacion;?>" required />
						                            </div>
						                        </div>
						                        
					                           	<div class="form-group">
					                           		<div class="input-group">
					                           			<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Estado</span>
																<div class="col-xs-15 selectContainer">
														        <select class="form-control" name="select_estado" required>
																	<option value="" selected="selected"></option>
																	<option value="Alta">ALTA</option>
																	<option value="Renovacion">RENOVACION</option>
														            <option value="Baja">BAJA</option>
														            <option value="Baja_provisoria">BAJA PROVISORIA</option>
																</select>
																</div>
															</div>
														</div>
					                           		</div>
					                           	</div>

						                         <div class="form-group">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Fecha Desde* </span>
						                                <div class='input-group date' id='divMiCalendarioHabilitacion'>
						                                    <input name="txt_fecha_desde" type='text' id="txt_fecha_desde" class="form-control" value="<?php echo $fecha_desde;?>" required />
						                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
						                                </div>
						                            </div>
						                        </div>

						                        <div class="form-group">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar-times-o fa-fw"></i> Fecha Hasta* </span>
						                                <div class='input-group date' id='divMiCalendarioVencimiento'>
						                                    <input name="txt_fecha_hasta" type='text' id="txt_fecha_hasta" class="form-control" value="<?php echo $fecha_hasta;?>" required />
						                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
						                                </div>
						                            </div>
						                        </div>

						                    </div>
						                </div>
						            </div>

									<div class="col-md-6 col-md-offset">
										<div class="panel panel-default">
											<div class="panel-body">							                       

						                        <div class="form-group">
												   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
												   <textarea class="form-control" rows="5" id="txt_observacion" name="txt_observacion" onKeyPress="return tabular(event,this)"><?php echo $observaciones; ?></textarea>
												</div>
												
						                        <input name="guardar_habilitacion" type="submit" class="btn btn-sm btn-primary btn-block" value="GUARDAR" onclick="return validar_frm();"/>

											</div>
										</div>
									</div>

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

<script type="text/javascript">

$('#divMiCalendarioHabilitacion').datetimepicker({
      format: 'DD-MM-YYYY'
    });

$('#divMiCalendarioVencimiento').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>

	</body>
</html>
