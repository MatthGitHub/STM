
<?php
include("../lib/funciones.php");
include("../mod_sql/sql.php");
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

$tabla_profesiones=buscar_profesiones_persona($txt_identificador);

$tabla_habilitaciones=buscar_habilitaciones_persona($txt_identificador);

$tabla_examenes=buscar_examenes_persona($txt_identificador);

$tabla_canones=buscar_canones_persona($txt_identificador);


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/logo_verde.png" sizes="16x16">
    <title>Sistema Turismo MSCB</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script language='javascript' src="../js/jquery.dataTables.min.js"></script>
<script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">
    
 
	
	<script type="text/JavaScript">
		
		$(document).ready(function() {
			
					
			$('#profesiones').DataTable( {
			  "language": {
					"lengthMenu": "Mostrar _MENU_ registros por página",
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
	    
			
					
		$('#habilitaciones').DataTable( {
		  "language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
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

			  $('#habilitaciones tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						  $('#habilitaciones').DataTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
				} );

		$('#examenes').DataTable( {
		  "language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
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

			  $('#examenes tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						  $('#examenes').DataTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
				} );

			$('#canones').DataTable( {
			  "language": {
					"lengthMenu": "Mostrar _MENU_ registros por página",
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

				  $('#canones tbody').on( 'click', 'tr', function () {
						if ( $(this).hasClass('selected') ) {
							$(this).removeClass('selected');
						}
						else {
							  $('#canones').DataTable.$('tr.selected').removeClass('selected');
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
								<h4 class="text-center"><img src="../images/ficha_profesional.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

								<h3 class="text-center bg-info">Ficha Profesional</h3>
								<h4 class="text-center bg-info">Datos Persona</h4>

								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">	
								
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
											<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre; ?>" disabled="disabled"/>
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
										   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> CUIT/CUIL</span>
										   <input name="txt_cuit" type="text" class="form-control" id="txt_cuit" value="<?php echo $txt_cuit;?>" disabled="disabled"/>
									   </div>
									</div>

									<div class="form-group">
									   <div class="input-group">
										   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> Fecha Nacimiento</span>
										   <input name="txt_fecha_nac" type="text" class="form-control" id="txt_fecha_nac" value="<?php echo $txt_fecha_nac;?>" disabled="disabled"/>
									   </div>
									</div>

									
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono</span>
											<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $txt_telefono;?>" disabled="disabled"/>
										</div>
									</div>
									

									</div>
								</div>
								
								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">

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

								<?php
												 
							 	$idiomas = buscar_idiomas_persona($txt_identificador);
								
								$idiomas_tabla = "";

								while($idioma = mysqli_fetch_array($idiomas))
								{
									$idiomas_tabla = $idiomas_tabla .' - '.$idioma['descripcion_idioma'];
								}

								?> 

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-language fa-fw"></i> Idiomas </span>
										<input name="txt_idiomas" type="text" class="form-control" id="txt_email" value="<?php echo $idiomas_tabla;?>" disabled="disabled"/>
									</div>
								</div>

							 
							</div>
						</div>
					</div>

					<div class="row">
						<div class="panel panel-default">
							<div class="panel-body">
							
							<h4 class="text-center"><img src="../images/photographer.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

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
											<th> Nombre perro </th>		
											<th width="10%"> Observaciones </th>											
										</thead>
										<tbody>
											<?php while($prof = mysqli_fetch_array($tabla_profesiones)){ 										
											?>
											<tr class="success">
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
												
												<td> <?php echo $prof['nombre_perro']; ?> </td>
												<td> <?php echo $prof['observaciones']; ?> </td>
											</tr>
											<?php } ?>
										</tbody>
									</table>				
								</div>	
							</div><!-- Container 1 -->
							</div>
						</div>
					</div> <!-- row -->

				<div class="row">
					<div class="panel panel-default">
						<div class="panel-body">
						
						<h4 class="text-center"><img src="../images/school-material.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
						<h4 class="text-center bg-info">Exámenes</h4>	
						<div class="container">
							<div class="row">	
								<table id="examenes" class="display" cellspacing="0" width="100%">
									<thead>
										<th> Tipo de Exámen </th>	
										<th> Fecha Solicitud </th>
										<th> Fecha Exámen </th>
										<th> Hora Exámen </th>
										<th> Resultado </th>
										<th width="30%"> Observaciones </th>
									</thead>
									<tbody>
										<?php while($exam = mysqli_fetch_array($tabla_examenes)){ 
										?>
										<tr class="success">
											<td> <?php echo $exam['nombre_tipo_examen']; ?> </td>
											<td> <?php echo fecha_normal_mysql($exam['fecha_solicitud']); ?> </td>
											<td> <?php echo fecha_normal_mysql($exam['fecha_examen']); ?> </td>
											<td> <?php echo $exam['hora_examen']; ?> </td>
											<td> <?php echo $exam['resultado']; ?> </td>
											<td> <?php echo $exam['observaciones']; ?> </td>											
										</tr>
										<?php } ?>
									</tbody>
								</table>				
							</div>	
						</div><!-- Container 1 -->
						</div>
					</div>
				</div>


				<div class="row">
					<div class="panel panel-default">
						<div class="panel-body">
						
						<h4 class="text-center"><img src="../images/title.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

						<h4 class="text-center bg-info">Habilitaciones</h4>	
						<div class="container">
							<div class="row">	
								<table id="habilitaciones" class="display" cellspacing="0" width="100%">
									<thead>
										<th> Nro Reg. </th>
										<th> Profesión </th>
										<th> Estado </th>
										<th> Fecha Desde </th>
										<th> Fecha Hasta </th>
										<th> Entregada </th>	
										<th width="30%"> Observaciones </th>													
									</thead>
									<tbody>
										<?php while($hab = mysqli_fetch_array($tabla_habilitaciones)){ 
										?>
										<tr class="success">
											<td> <?php echo $hab['nro_habilitacion']; ?> </td>
											<td> <?php echo $hab['nombre_profesion']; ?> </td>
											<td> <?php echo $hab['estado']; ?> </td>
											<td> <?php echo fecha_normal_mysql($hab['fecha_desde']); ?> </td>
											<td> <?php echo fecha_normal_mysql($hab['fecha_hasta']); ?> </td>

											<td> <?php if($hab['entregada'] == 1)
											{	echo "Sí";
											}else{
												echo "No";
											}?> </td>
											
											<td> <?php echo $hab['observaciones']; ?> </td>
										</tr>
										<?php } ?>
									</tbody>
								</table>				
							</div>	
						</div><!-- Container 1 -->
						</div>
					</div>
				</div>

				<div class="row">
					<div class="panel panel-default">
						<div class="panel-body">
												
						<h4 class="text-center"><img src="../images/canon.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
						<h4 class="text-center bg-info">Canones</h4>	
						<div class="container">
							<div class="row">	
								<table id="canones" class="display" cellspacing="0" width="100%">
									<thead>
										<th> Profesión</th>
										<th> Nro Recibo </th>
										<th> Fecha Cobro </th>
										<th> Importe </th>
										<th> Tipo Pago </th>
										<th> Vigencia Desde </th>
										<th> Vigencia Hasta </th>
										<th width="20%"> Observaciones </th>													
									</thead>
									<tbody>
										<?php while($prof = mysqli_fetch_array($tabla_canones)){ 
										?>
										<tr>
											<td> <?php echo $prof['nombre_profesion']; ?> </td>
											<td> <?php echo $prof['nro_recibo']; ?> </td>
											<td> <?php echo fecha_normal_mysql($prof['fecha_cobro']); ?> </td>
											
											<td> <?php echo $prof['importe']; ?> </td>
											<td> <?php echo $prof['nombre_tipo_pago']; ?> </td>
											<td> <?php echo fecha_normal_mysql($prof['vigencia_desde']); ?> </td>
                                            <td> <?php echo fecha_normal_mysql($prof['vigencia_hasta']); ?> </td>
                                            <td> <?php echo $prof['observaciones']; ?> </td>
										</tr>
										<?php } ?>
									</tbody>
								</table>				
							</div>	
						</div><!-- Container 1 -->
						</div>
					</div>
				</div>

			</form>
		</div> <!-- Container -->
	</div>   <!-- Jumbotron -->
	
	<div class="panel-footer">
		<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
	</div>

</div>   <!-- Container -->


</body>
</html>
