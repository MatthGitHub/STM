
<?php
include("../lib/funciones.php");
include("../mod_sql/sql.php");
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
	$txt_identificador = test_input($_POST['txt_identificador']);

}

$tabla_profesiones=buscar_profesiones_persona($txt_identificador);


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST['btn_eliminar']))
{
	$txt_nombre = $_POST['txt_nombre'];
	$txt_apellido = $_POST['txt_apellido'];
	$txt_dni = $_POST['txt_dni'];
	$txt_telefono = $_POST['txt_telefono'];
	$txt_calle = $_POST['txt_calle'];
	$txt_nro = $_POST['txt_numero_calle'];
	$txt_barrio = $_POST['txt_barrio'];
	$txt_piso = $_POST['txt_piso'];
	$txt_dpto = $_POST['txt_departamento'];
	$txt_email = $_POST['txt_email'];

	$id_profesion = $_POST['txt_id_profesion'];
	$id_persona = $_POST['txt_identificador'];

	$eliminado = eliminar_profesion($id_profesion, $id_persona, $_SESSION['id']);

	if($eliminado)
	{
		$output.="Profesión ELIMINADA correctamente";

		echo "<script>";
		echo "alert('$output');";
		echo "window.location = 'profesionales.php';";
		echo "</script>";

		mysqli_close($db);	
	}else {
		$mensaje = true;
		$output.=" al ELIMINAR la profesión";
		mysqli_close($db);	
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
    <script language='javascript' src="../js/jquery.dataTables.min.js"></script>


	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">
	
	<script type="text/JavaScript">
		
		$(document).ready(function() {
			
					
			$('#profesiones').DataTable( {
			  "language": {
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"zeroRecords": "No se encontraron registros",
					"info": "Pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"sSearch":       	"Buscar",
					"oPaginate": {
						"sFirst":    	"Primero",
						"sPrevious": 	"Anterior",
						"sNext":     	"Siguiente",
						"sLast":     	"Ultimo"
					}
				},
				"scrollY":        "500px",
				"scrollCollapse": true,
				"order":[[0,"desc"]]
				  } );

				  $('#profesiones tbody').on( 'click', 'tr', function () {
						if ( $(this).hasClass('selected') ) {
							$(this).removeClass('selected');
						}
						else {
							  $('#profesiones').DataTable.$('tr.selected').removeClass('selected');
							$(this).addClass('selected');
						}
					} );
	      });
		
		</script>

</head>


<body onLoad="document.form1.txt_nombre.focus();">

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
							<form class="form form-signup" role="form">
								<h4 class="text-center"><img src="../images/mod_profesion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

								<h3 class="text-center bg-info">Profesiones Persona</h3>
								<h4 class="text-center bg-info">Datos Persona</h4>

								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">	
								
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
											<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre;?>" disabled="disabled"/>
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
											<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $txt_apellido;?>" disabled="disabled"/>
										</div>
									</div>

									<div class="form-group">
									   <div class="input-group">
										   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> Documento</span>
										   <input name="txt_dni" type="text" class="form-control" id="txt_dni" value="<?php echo $txt_dni;?>" disabled="disabled"/>
									   </div>
									</div>

									<div class="form-group">
									   <div class="input-group">
											<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio</span>
											<input name="txt_calle" type="text" class="form-control" id="txt_calle" value="<?php echo $txt_calle;?>" disabled="disabled"/>
									   </div>
									</div>

									<div class="form-group">
									   <div class="input-group">
											<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> Número</span>
											<input name="txt_nro" type="text" class="form-control" id="txt_nro" value="<?php echo $txt_nro;?>" disabled="disabled"/>
										</div>
									</div>

									

									</div>
								</div>
								
								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">
										<div class="form-group">
										   <div class="input-group">
												<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Barrio</span>
												<input name="txt_barrio" type="text" class="form-control" id="txt_barrio" value="<?php echo $txt_barrio;?>" disabled="disabled"/>
										   </div>
										</div>

										<div class="form-group">
										   <div class="input-group">
												<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Piso</span>
												<input name="txt_piso" type="text" class="form-control" id="txt_piso" value="<?php echo $txt_piso;?>" disabled="disabled"/>
										   </div>
										</div>

										<div class="form-group">
										   <div class="input-group">
												<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Dpto.</span>
												<input name="txt_dpto" type="text" class="form-control" id="txt_dpto" value="<?php echo $txt_dpto;?>" disabled="disabled"/>
										   </div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono</span>
												<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $txt_telefono;?>" disabled="disabled"/>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
												<input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $txt_email;?>" disabled="disabled"/>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="row">
						<div class="panel panel-default">
							<div class="panel-body">
						
							
							<h4 class="text-center bg-info">Profesiones</h4>	
							
							<div class="container">
								<div class="row">	
									<table id="profesiones" class="display" cellspacing="0" width="100%">
										<thead>
											<th> Profesión </th>
											<th> Fecha Inicio </th>									
											<th> Lugar de Trabajo </th>
											<th> Chofer</th>
											<th> Emb. </th>
											<th> Empresa Emb. </th>
											<th> Idiomas </th>
											<th> Nombre perro </th>		
											<th width="10%"> Observaciones </th>	
											<th> </th>										
											<th> </th>
										</thead>
										<tbody>
											<?php while($prof = mysqli_fetch_array($tabla_profesiones))
											{ 										
											?>
											<tr class="odd gradeX">
												<td> <?php echo $prof['nombre_profesion']; ?> </td>
												<td> <?php echo fecha_normal_mysql($prof['fecha_inicio_actividad']); ?> </td>
												<td> <?php
												 
												 	$lugares = buscar_lugares_persona_profesion($txt_identificador, $prof['fk_id_profesion']);
													
													$lugares_tabla = "";

													while($lugar = mysqli_fetch_array($lugares))
													{
														$lugares_tabla = $lugares_tabla .' - '.$lugar['nombre_lugar'];
													}

													echo $lugares_tabla;

												 ?> 
												</td>
												<td>  <?php if($prof['chofer'] == 1)
													{
														echo 'Sí';	
													}else{
														echo 'No';	
													} ?>
														
												</td>
												<td>  <?php if($prof['embarcacion'] == 1)
													{
														echo 'Sí';	
													}else{
														echo 'No';	
													} ?>
														
												</td>
												<td>
												<?php  
													$empresas = buscar_empresas_profesional($txt_identificador, $prof['fk_id_profesion']);
													
													$empresas_tabla = "";

													while($empresa = mysqli_fetch_array($empresas))
													{
														$empresas_tabla = $empresas_tabla .' - '.$empresa['nombre_empresa'];
													}

													echo $empresas_tabla;
												?>
												</td>
												
												<td> <?php
												 
												 	$idiomas = buscar_idiomas_persona($txt_identificador);
													
													$idiomas_tabla = "";

													while($idioma = mysqli_fetch_array($idiomas))
													{
														$idiomas_tabla = $idiomas_tabla .' - '.$idioma['descripcion_idioma'];
													}

													echo $idiomas_tabla;

												 ?> 
												</td>
												<td> <?php echo $prof['nombre_perro']; ?> </td>
												<td> <?php echo $prof['observaciones']; ?> </td>
								
												<td>
												<form action="frm_modificar_profesion.php" method="POST">
				                                    <input type="hidden" name="txt_identificador" value="<?php echo $txt_identificador; ?>">
				                                    <input type="hidden" name="txt_id_profesion" value="<?php echo $prof['fk_id_profesion']; ?>">	
				                                     <input type="hidden" name="txt_nombre" value="<?php echo $txt_nombre; ?>">
				                                      <input type="hidden" name="txt_apellido" value="<?php echo $txt_apellido; ?>">
                           
				                                    				                                   
				                                    <input type="submit" name="modificar" value="Modificar" onclick="return confirm('¿Desea MODIFICAR la profesión?');" class="btn btn-table">
			                                    </form>
			                    
			                                    </td>
			                                    <td> <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			                                    		
			                                    		<input type="submit" name="btn_eliminar" value="Eliminar" onclick="return confirm('¿Desea ELIMINAR la profesión <?php echo $prof['nombre_profesion'];?>?');" class="btn btn-table">
			                                     	
			                                     		<input type="hidden" name="txt_identificador" value="<?php echo $txt_identificador; ?>">
				                                  		<input type="hidden" name="txt_id_profesion" value="<?php echo $prof['fk_id_profesion']; ?>">
				                                  		<input type="hidden" name="txt_nombre" value="<?php echo $txt_nombre; ?>">
				                                        <input type="hidden" name="txt_apellido" value="<?php echo $txt_apellido; ?>">
				                                        <input type="hidden" name="txt_nro" value="<?php echo $txt_nro; ?>">
				                                        <input type="hidden" name="txt_calle" value="<?php echo $txt_calle; ?>">
				                                        <input type="hidden" name="txt_barrio" value="<?php echo $txt_barrio; ?>">
				                                        <input type="hidden" name="txt_piso" value="<?php echo $txt_piso; ?>">
				                                        <input type="hidden" name="txt_dpto" value="<?php echo $txt_dpto; ?>">
				                                        <input type="hidden" name="txt_telefono" value="<?php echo $txt_telefono; ?>">
				                                        <input type="hidden" name="txt_email" value="<?php echo $txt_email; ?>">
				                                        <input type="hidden" name="txt_dni" value="<?php echo $txt_dni; ?>">
				                                  	</form>
				                                </td>
											</tr>
											<?php } ?>
										</tbody>
									</table>				
								</div>	
							</div><!-- Container 1 -->
							</div>
						</div>
					</div> <!-- row -->

				

			</form>
		</div> <!-- Container -->
	</div>   <!-- Jumbotron -->
	
	<div class="panel-footer">
		<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
	</div>

</div>   <!-- Container -->

<script type="text/javascript">
	$('#divMiCalendarioActividad').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>

</body>
</html>
