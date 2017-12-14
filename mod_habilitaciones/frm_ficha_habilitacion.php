
<?php
include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');

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
	$txt_nombre = test_input($_POST['txt_nombre']);
	$txt_apellido = test_input($_POST['txt_apellido']);
	$id_habilitacion = test_input($_POST['txt_id_habilitacion']);

	$habilitacion_profesion = buscar_habilitacion($id_habilitacion);

	//Lleno los campos

	 while ($row = mysqli_fetch_assoc($habilitacion_profesion)) 
	 {
	 	$nro_habilitacion = $row['nro_habilitacion'];
 		$estado =  $row['estado'];
	 	$fecha_habilitacion = fecha_mysql_normal($row['fecha_desde']);
	 	$fecha_vencimiento = fecha_mysql_normal($row['fecha_hasta']);
	 	$entregada = $row['entregada'];
	 	$observaciones = $row['observaciones'];
	 	$nombre_profesion = $row['nombre_profesion'];
	 }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST['cerrar']))
{
	echo "<script>";
	echo "window.location = 'habilitaciones.php';";
	echo "</script>";
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


<body>

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

									<h4 class="text-center"><img src="../images/title.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

									<div class="panel panel-default">
										<div class="panel-body">

											<?php 
											
											if ($mensaje==true){
												echo "<div class='alert alert-warning'>
		  											<strong>Error!</strong> $output.
													</div>";
											 
											}
											
											?>
											<h3 class="text-center bg-info">Ficha Habilitación</h3>
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
													</div>
												</div>

												 <div class="form-group">
						                            <div class="input-group">
						                              <span class="input-group-addon"><i class="fa fa-asterisk fa-fw"></i> Nº Registro</span><input name="txt_nro_habilitacion" type="text" class="form-control" id="txt_nro_habilitacion" value="<?php echo $nro_habilitacion;?>" disabled="disabled"/>
						                            </div>
						                        </div>

						                        <div class="form-group">
						                            <div class="input-group">
						                              <span class="input-group-addon"><i class="fa fa-info fa-fw"></i> Estado</span><input name="txt_estado" type="text" class="form-control" id="txt_estado" value="<?php echo $estado;?>" disabled="disabled"/>
						                            </div>
						                        </div>
						                        
					                            <div class="form-group">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Fecha Desde </span>
						                                
						                                    <input name="txt_fecha_habilitacion" type='text' id="txt_fecha_habilitacion" class="form-control" value="<?php echo $fecha_habilitacion;?>" disabled="disabled"/>
						                                   
						                            </div>
						                        </div>

						                        <div class="form-group">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar-times-o fa-fw"></i> Fecha Hasta </span>
						                                
						                                    <input name="txt_fecha_vencimiento" type='text' id="txt_fecha_vencimiento" class="form-control" value="<?php echo $fecha_vencimiento;?>" disabled="disabled"/>

						                                </div>
						                            </div>
						                        </div>

						                    </div>
						                </div>

									<div class="col-md-6 col-md-offset">
										<div class="panel panel-default">
											<div class="panel-body">							                       

						                        <div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Entregada <input type="checkbox" name="entregada" value="1"  <?php if($entregada == true) echo "checked='checked'"; ?> disabled="disabled"/> </span>
													</div>
												</div>
						                            
						                        <div class="form-group">
												   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
												   <textarea class="form-control" rows="5" id="txt_observacion" name="txt_observacion" onKeyPress="return tabular(event,this)" disabled="disabled"><?php echo $observaciones; ?></textarea>
												</div>

												<input name="cerrar" type="submit" class="btn btn-sm btn-primary" value="CERRAR" />

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

</body>
</html>
