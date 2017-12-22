
<?php
//--------------------------------Inicio de sesion------------------------

include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');
include('../inc/sesion.php');

$db= Conexion();

//Cargo barrios
$barrios = sql_buscar_barrios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$txt_nombre = test_input($_POST['txt_nombre']);
	$txt_apellido = test_input($_POST['txt_apellido']);
	$txt_dni = test_input($_POST['txt_documento']);
	$txt_telefono = test_input($_POST['txt_telefono']);
	$txt_calle = test_input($_POST['txt_calle']);
	$txt_nro = test_input($_POST['txt_numero_calle']);
	$txt_barrio = test_input($_POST['txt_barrio']);
	$txt_piso = test_input($_POST['txt_piso']);
	$txt_dpto = test_input($_POST['txt_departamento']);
	$txt_email = test_input($_POST['txt_email']);
	$txt_cuit = test_input($_POST['txt_cuit']);	
	$txt_fecha_nac = fecha_mysql_normal(test_input($_POST['txt_fecha_nac']));
	$txt_identificador = test_input($_POST['txt_identificador']);

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['guardar']))
{
	$id_persona = $_POST['txt_identificador'];
	$nombre = $_POST['txt_nombre'];
	$apellido = $_POST['txt_apellido'];
	$dni = $_POST['txt_dni'];
	$telefono = $_POST['txt_telefono'];
	$calle = $_POST['txt_calle'];
	$numero = $_POST['txt_nro'];
	$barrio = $_POST['select_barrio'];
	$piso = $_POST['txt_piso'];
	$dpto = $_POST['txt_dpto'];
	$email = $_POST['txt_email'];
	$cuit = $_POST['txt_cuit'];
	$fecha_nac = $_POST['txt_fecha_nac'];

	$persona = sql_update_persona($id_persona, $nombre, $apellido, $dni, $telefono, $calle, $numero, $barrio, $piso, $dpto, $email, $cuit, $fecha_nac);

	if (!$persona)
	{
		$errorPersona = true;
	}
	else{

		$successPersona = true;
	}
}

?>

<!DOCTYPE html">
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
	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script>

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">

	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../jscripts/popcalendar.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script>

	<script type="text/JavaScript">

	function set_focus()
	{
		document.getElementById("txt_nombre_propietario").focus();
		alert("focus animal nombre");
		return (false);
	}
	/*
	//---------------------Verificar abandono de la pagina-------------------//
	var bPreguntar = true;

		window.onbeforeunload = preguntarAntesDeSalir;

		function preguntarAntesDeSalir()
		{
		  if (bPreguntar)
			return "";
		}
	//------------------Fin verificar abandono--------------------------//
	*/

	</script>

</head>


<body onLoad="document.formBuscar.txt_nombre.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Modificar Persona</h4>
			<div class="container">
				<form id="form_modificar_persona" name="form_modificar_persona" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

					<?php
					if($successPersona == true){
						echo "
							<div class='alert alert-success-alt alert-dismissable'>
							<span class='glyphicon glyphicon-ok'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>La Persona se modificó correctamente.</div>
						";
						$successPersona = false;
					}elseif($errorPersona == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>Error al modificar la Persona.</div>
						";
						$errorPersona = false;
					}
						?>

					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<form class="form form-signup" role="form">
										<h4 class="text-center"><img src="../images/icons/family.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
										
										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">	
										
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
													<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre; ?>"/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
													<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $txt_apellido;?>"/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
												   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> Documento</span>
												   <input name="txt_dni" type="text" class="form-control" id="txt_dni" value="<?php echo $txt_dni;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
												   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> CUIT/CUIL</span>
												   <input name="txt_cuit" type="text" class="form-control" id="txt_cuit" value="<?php echo $txt_cuit;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
												   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> Fecha Nacimiento</span>
												   <input name="txt_fecha_nac" type="text" class="form-control" id="txt_fecha_nac" value="<?php echo $txt_fecha_nac;?>"/>
											   </div>
											</div>

											
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono</span>
													<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $txt_telefono;?>"/>
												</div>
											</div>
											

											</div>
										</div>
										
										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">

												<div class="form-group">
												   <div class="input-group">
														<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio</span>
														<input name="txt_calle" type="text" class="form-control" id="txt_calle" value="<?php echo $txt_calle;?>"/>
												   </div>
												</div>

												<div class="form-group">
												   <div class="input-group">
														<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> Número</span>
														<input name="txt_nro" type="text" class="form-control" id="txt_nro" value="<?php echo $txt_nro;?>"/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i> Barrio*</span>
														<div class="col-xs-15 selectContainer">
															
															<select class="form-control" id="select_barrio" name="select_barrio"  required>
																<option  selected="selected"> <?php echo $barrio;?> </option>
																<?php
																	while ($row=mysql_fetch_array($barrios))
																	{
																		$id_barrio = ($row['codigo']);

																		$barrio = ($row['concepto']);

																		?>
																	<option value = "<?php echo $barrio; ?>" ><?php echo $barrio;?> </option>
																<?php
																}
																?>

															</select>

														</div>
													</div>
												</div>

												<div class="form-group">
												   <div class="input-group">
														<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Piso</span>
														<input name="txt_piso" type="text" class="form-control" id="txt_piso" value="<?php echo $txt_piso;?>"/>
												   </div>
												</div>

												<div class="form-group">
												   <div class="input-group">
														<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Dpto.</span>
														<input name="txt_dpto" type="text" class="form-control" id="txt_dpto" value="<?php echo $txt_dpto;?>"/>
												   </div>
												</div>


												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
														<input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $txt_email;?>"/>
													</div>
												</div>
											</div>

											</div>
										</div>	
									</form>

									<input id="guardar" name="guardar" type="submit"  class="btn btn-sm btn-primary btn-block" value="GUARDAR CAMBIOS" onclick="return confirm('¿Desea MODIFICAR la persona?');"/>

								</div>
							</div>
						</div>
					</div>
				</form>
			</div><!-- Container 2 -->
		</div> <!-- Jumbotron -->
	</div> <!-- Container -->
</body>
</html>
