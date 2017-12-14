
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

	$idiomas_persona = buscar_idiomas_persona($txt_identificador);

	

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//GUARDO PROFESION 

if(isset($_POST['guardar_profesion'])){
	
	$output = '' ;
	$profesion = $_POST['select_profesion'];
	$fecha_inicio = fecha_normal_mysql($_POST['txt_fecha_inicio']);
	$lugares_trabajo = $_POST['checkbox_lugares'];
	$nombrePerro = $_POST['txt_nombre_perro'];
	$observacion = $_POST['txt_observacion'];
	$id = $_POST['txt_identificador'];
	$empresas_seleccionadas = $_POST['select_empresas'];
	
	//RECIBO LOS CEHCK SELECCIONADOS DE IDIOMAS
	$idiomas = $_POST['checkbox'];

	if(count($idiomas) > 0){

		//ELIMINO LOS IDIOMAS ASOCIADOS A LA PERSONA
		$sql_del = "DELETE FROM `tup_idiomas_personas` WHERE fk_id_persona = '$id'";
		$ej_sql= mysqli_query($db,$sql_del);
		

		if($_POST['chofer']=="")
		{
			$chofer=0;
		}else{
			$chofer=1;
		};

		if($_POST['embarcacion']=="")
		{
			$embarcacion=0;
			$empresa = '';
		}else{
			$embarcacion=1;
		};

		
		$contador =  persona_profesion_repetida($id,$profesion);
		$mensaje = false;
		
		if ($contador == 0){
			
				$sql = "INSERT INTO `personas_profesiones`(`fk_id_persona`, `fk_id_profesion`, `fecha_inicio_actividad`, `observaciones`, `nombre_perro`, `chofer`,`embarcacion`) 
			VALUES ('$id','$profesion','$fecha_inicio','$observacion','$nombrePerro', '$chofer', '$embarcacion')";
		
			$guardar_profesion = mysqli_query($db,$sql);
		
			if($guardar_profesion) {

				auditar($_SESSION['id'],$sql);

				if(count($lugares_trabajo) > 0)
				{

					for ($i=0;$i<count($lugares_trabajo);$i++)    
					{     
						$sql = "INSERT INTO `tup_lugares_profesionales`(`fk_id_persona`, `fk_id_profesion`, `fk_id_lugar`) VALUES ('$id','$profesion',$lugares_trabajo[$i])";   

						$guardar_lugar = mysqli_query($db,$sql);
						auditar($_SESSION['id'],$sql);
					} 
				}

				
				if(count($empresas_seleccionadas) > 0)
				{
					for ($i=0;$i<count($empresas_seleccionadas);$i++)    
					{     
						if( $empresas_seleccionadas[$i] != ''){
							$sql = "INSERT INTO `tup_empresas_profesionales`(`fk_id_profesional`, `fk_id_persona`, `fk_id_empresa`) VALUES ('$profesion','$id', $empresas_seleccionadas[$i])";   

							$guardar_empresa = mysqli_query($db,$sql);
							auditar($_SESSION['id'],$sql);
						}
					} 
				}
				
				if(count($idiomas) > 0){
					//GUARDO LOS IDIOMAS
					foreach ($idiomas as $idioma) {

					$sql_insert = "INSERT INTO `tup_idiomas_personas`(`fk_id_idioma`, `fk_id_persona`) VALUES ('$idioma','$id')";
				
					$ej_insert = mysqli_query($db,$sql_insert);	

					auditar($_SESSION['id'],$sql_insert);

					/*$query = mysqli_query($db,"SELECT * FROM idiomas WHERE idioma = '$idioma'");

					$row_cnt = mysqli_num_rows($query);*/

					}
				}
			
				

				$output.="Registro guardado correctamente";
		
				echo "<script>";
				echo "alert('$output');";
				echo "window.location = 'profesionales.php';";
				echo "</script>";

				mysqli_close($db);	
			
			}else {
			$mensaje = true;
			$output.=" al guardar la profesión";
			mysqli_close($db);	
			
			
			}		
			
		}else {
			$mensaje = true;
			$output.="Profesión ya asignada";
			mysqli_close($db);	
			
		}
	}else{
		$fecha_inicio = $_POST['txt_fecha_inicio'];
		$mensaje = true;
		$output.="Debe seleccionar al menos un IDIOMA";
	}
	
		
}//ISSET GUARDAR PROFESION

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

		function vacio(q) {  
			for ( i = 0; i < q.length; i++ ) {  
				if ( q.charAt(i) != " " ) {  
					return true  
				}  
			}  
			return false  
		}

		function validar_frm_alta_profesional(f)
		{

			//Formateo la fecha de hoy para compararla contra la de cobro.

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){
			    dd='0'+dd;
			} 
			if(mm<10){
			    mm='0'+mm;
			} 
			var today = dd+'-'+mm+'-'+yyyy;


			if(document.form1.txt_fecha_inicio.value > today)
			{
				alert('La fecha de INICIO de ACTIVIDAD, no puede ser mayor a HOY.');
				return false;
			}

			if((document.form1.embarcacion.checked) && (document.form1.select_empresas.value==""))
			{
				alert('Seleccione Empresa de embarcación.');
				return false;
			}
						
		}

		
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
										<h4 class="text-center"><img src="../images/nuevo_profesional.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

										<h3 class="text-center bg-info">Alta Profesión</h3>
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
										</div>							
									</div>
								
                                
                                
                             <!-- SECCION IDIOMAS -->   
                                
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-language fa-fw"></i> Idiomas</span>
										</div>
										<div class="col-xs-15 selectContainer">
											<?php 

	
													//TODOS LOS IDIOMAS DE LA TABLA
													
													$sql_idioma = "SELECT `id_idioma`, `descripcion_idioma` FROM `tup_idiomas` WHERE NOT id_idioma IN (SELECT fk_id_idioma FROM tup_idiomas_personas WHERE fk_id_persona='$txt_identificador')";
													$ej_idiomas = mysqli_query($db,$sql_idioma);
													
													//IDIOMAS DE LA FICHA
													$sql = mysqli_query($db,"SELECT a.* FROM tup_idiomas a INNER JOIN tup_idiomas_personas b
													on a.id_idioma = b.fk_id_idioma WHERE b.fk_id_persona='$txt_identificador'");
													
													while($row = mysqli_fetch_assoc($sql)){
													
														$c = array($row["id_idioma"]);
														$x = $row["descripcion_idioma"];
													
														if (in_array($x,$c)){
													
															echo "<label class='checkbox-inline'><input name='checkbox[]' type='checkbox' value='$row[id_idioma]' checked='checked' />  ".$row["descripcion_idioma"].'</label>';
													
														}else { 
													
															echo "<label class='checkbox-inline'><input name='checkbox[]' type='checkbox' value='$row[id_idioma]' checked />  ".'<strong>'.$row["descripcion_idioma"].'</strong> </label>';
														}
													}
													
													?>
                                                    
                                                    
                                                    <?php  

														while ($row = mysqli_fetch_assoc($ej_idiomas)) { ?>
														
														<label class="checkbox-inline"><input type="checkbox" name="checkbox[]" value="<?php echo $row['id_idioma']; ?>" />  <?php echo $row['descripcion_idioma']; ?></label>
														
													<?php } ?>
                                                    
                                                    
										</div>
									</div>
								</div>
							</div>
								
                                
                                
							<!-- FIN SECCION IDIOMAS -->   
                            
                            
                            
                    		
							<div class="row">
								<div class="panel panel-default">
									<div class="panel-body">

										<h4 class="text-center bg-info">Datos Profesión</h4>
										
										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">
												<div class="panel-body">

													<div class="form-group">
														<div class="input-group">
                                                        
                                                        <?php 
															
															//PROFESIONES DISPONIBLES PARA LA PERSONA SELECCIONADA
																  
																  $query = "SELECT * FROM `profesiones` WHERE id_profesion not in (select fk_id_profesion from personas_profesiones where fk_id_persona ='$txt_identificador')";
																  $ejecutar = mysqli_query($db,$query);
																  $profesiones_contador = mysqli_num_rows($ejecutar); 
																

																$bloquear_boton_guardar = false;
															
															if ($profesiones_contador==0){
																
																echo "<div class='alert alert-warning'>
  																	<strong>No hay profesiones disponibles para la persona seleccionada.
																</div>";
																$bloquear_boton_guardar = true;
															}															
															?>
                                                        
                                                        
															<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Profesión</span>											
															<div class="col-xs-15 selectContainer">
                                                            
                                                            
																<select class="form-control" name="select_profesion" required>
																  <?php 
																  
																  
																  
																  while($row = mysqli_fetch_assoc($ejecutar)){
																  
																  ?>
                                                                  <option value="<?php echo $row['id_profesion']; ?>"><?php echo $row['nombre_profesion']; ?></option>
                                                                  
                                                                  
                                                                  <?php }?>
																</select>
															</div>
														</div>
													</div>
												

													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Inicio Actividad* </span>
															<div class='input-group date' id='divMiCalendarioActividad'>
																<input name="txt_fecha_inicio" type='text' id="txt_fecha_inicio" class="form-control" value="<?php echo $fecha_inicio;?>" required/>
																<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i>Chofer <input type="checkbox" name="chofer" value="1"  <?php if($chofer == true) echo "checked='checked'"; ?>/> </span>
														</div>
													</div>	

													 <div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i>Embarcación <input type="checkbox" name="embarcacion" value="1"  <?php if($embarcacion == true) echo "checked='checked'"; ?>/>
														
															<i class="fa fa-question-circle-o fa-fw"></i> Empresa</span>
															<div class="col-xs-15 selectContainer">
				                                                <select class="form-control" name="select_empresas" id="select_empresas">
	                                                              <?php 
	                                                              
	                                                              $empresas = buscar_empresas();

	                                                              ?> <option value=""></option>

	                                                              <?php
	                                                              while ($row = mysqli_fetch_assoc($empresas)) {
	                                                              
	                                                              ?>
	                                                              <option value="<?php echo $row['id_empresa']; ?>"><?php echo $row['nombre_empresa']; ?></option>
	                                                              
	                                                              <?php } ?>
				                                                </select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i> Lugar de trabajo</span>
														</div>
														<div class="col-xs-15 selectContainer">
															<?php 

															  $lugares = buscar_lugares();
															  
															  while ($row = mysqli_fetch_assoc($lugares)){
															  
															  ?>			
																<label class="checkbox-inline"><input type="checkbox" name="checkbox_lugares[]" value="<?php echo $row['id_lugar']; ?>" />  <?php echo $row['nombre_lugar']; ?></label>
																
																<?php
																}
																
																?>
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
															<span class="input-group-addon"><i class="fa fa-paw fa-fw"></i> Nombre Perro</span>
															<input name="txt_nombre_perro" type="text" class="form-control" id="txt_nombre_perro" value="<?php echo $nombrePerro;?>" onKeyPress="return tabular(event,this)"/>
														</div>
													</div>

													<div class="form-group">
													   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
													   <textarea class="form-control" rows="6" id="txt_observacion" name="txt_observacion" onKeyPress="return tabular(event,this)"><?php echo $observaciones; ?></textarea>
													   <input type="hidden" name="txt_identificador" value="<?php echo $txt_identificador; ?>">
													</div>

													<input name="guardar_profesion" type="submit" class="btn btn-sm btn-primary btn-block" value="GUARDAR" <?php if($bloquear_boton_guardar==true) { echo "disabled='disabled'";}  ?>  onclick="return validar_frm_alta_profesional();"/>

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
	$('#divMiCalendarioActividad').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>

	</body>
</html>
