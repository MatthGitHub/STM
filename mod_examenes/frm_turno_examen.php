
<?php

include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include '../inc/conexion.php';
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

//TRAIGO TIPOS DE EXAMENES

$id = $_POST['txt_identificador'];

//CONSULTO LOS EXAMENS CORRESPONDIENTES A LA PROFESION DE LA PERSONA 
$examenes = "SELECT a.id_tipo_examen,a.nombre_tipo_examen,a.fk_id_profesion FROM tipos_examenes a, personas_profesiones b
WHERE b.fk_id_profesion = a.fk_id_profesion AND b.fk_id_persona = '$id'";
$ejecuto_examenes = mysqli_query($db,$examenes);


$id = $_POST['txt_identificador'];
$txt_nombre = $_POST['txt_nombre'];
$txt_apellido = $_POST['txt_apellido'];
$txt_documento = $_POST['txt_documento'];
$txt_calle = $_POST['txt_calle'];
$txt_nro = $_POST['txt_numero_calle'];
$txt_barrio = $_POST['txt_barrio'];
$txt_piso = $_POST['txt_piso'];
$txt_dpto = $_POST['txt_departamento'];

//DATOS TURNO

$fecha_solicitud = $_POST['txt_fecha_solicitud'];
$fecha_de_solicitud = fecha_normal_mysql($fecha_solicitud);
$fecha_examen = $_POST['txt_fecha_examen'];
$fecha_de_examen = fecha_normal_mysql($fecha_examen);
$hora_examen = $_POST['txt_hora'];
$tipo_examen = $_POST['select_examen'];
$observaciones = $_POST['txt_observacion'];

$mensaje = false;

if(isset($_POST['guardar_turno'])) {
	
	//CONSULTO LA PROFESION DE ACUERDO AL TIPO DE EXAMEN QUE SE ELIGE.
	$busco_profesion = "SELECT DISTINCT a.id_profesion,a.nombre_profesion,b.id_tipo_examen,b.nombre_tipo_examen FROM profesiones a
INNER JOIN tipos_examenes b ON b.fk_id_profesion = a.id_profesion
WHERE id_tipo_examen = '$tipo_examen'";
	$ejecuto_buscar_profesion  =  mysqli_query($db,$busco_profesion);
	
	while($resul = mysqli_fetch_assoc($ejecuto_buscar_profesion)){
		
		$id_profesion = $resul['id_profesion'];
	
	}
	
	//GUARDO NUEVO TURNO
	$sql = "INSERT INTO `tup_examenes`(`fecha_solicitud`,`fecha_examen`,`hora_examen`,`observaciones`, `tipo_examen`, `fk_id_persona`,`fk_id_profesion`) VALUES ('$fecha_de_solicitud','$fecha_de_examen','$hora_examen','$observaciones','$tipo_examen','$id','$id_profesion')";
	$ejecuto = mysqli_query($db,$sql);
	
	if ($ejecuto){

		auditar($_SESSION['id'],$sql);
		
		$output.="Turno guardado correctamente";
	
			echo "<script>";
			echo "alert('$output');";
			echo "window.location = 'examenes.php';";
			echo "</script>";
	}else{
		$mensaje = false;
	}


}
mysqli_close($db);

?>

<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/logo.png" sizes="16x16">
    <title>Sistema Turismo MSCB</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-clockpicker.min.css">
	<link rel="stylesheet" type="text/css" href="../css/github.min.css">

    
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
   
   <style>
   
   .popover.left {
    margin-left: 300px !important;
}
   
   </style>

    <script type="text/javascript">

		function set_focus()
		{
			document.getElementById("txt_nombre").focus();
			alert("focus propietario nombre");
			return (false);
		}
		
		
		function vacio(q) {  
			for ( i = 0; i < q.length; i++ ) {  
				if ( q.charAt(i) != " " ) {  
					return true  
				}  
			}  
			return false  
		}

		function validar_frm_alta_propietario(f)
		{
			var fk_id_especie = 0;
			var raza = "";
			var flag = false;
			
			if (!vacio(document.form1.txt_fecha_solicitud.value)){
				alert("Seleccione fecha de solicitud."); 
				document.form1.txt_fecha_solicitud.focus();
				return false;
			}
			
			if (!vacio(document.form1.txt_fecha_examen.value)){
				alert("Seleccione fecha de examen."); 
				document.form1.txt_fecha_examen.focus();
				return false;
			}
			
			if (!vacio(document.form1.txt_hora.value)){   
				alert("Seleccione la hora."); 
				document.form1.txt_hora.focus();
				return false;
			}
				
			if (!vacio(document.form1.txt_hora.value)){   
				alert("Seleccione la hora."); 
				document.form1.txt_hora.focus();
				return false;
			}
			
			
			if (!vacio(document.form1.select_examen.value)){
				alert("Seleccione un tipo de examen."); 
				document.form1.select_examen.focus();
				return (false);
			}
			
			//Formateo la fecha de hoy para compararla contra la de solicitud.
			
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


			if(document.form1.txt_fecha_solicitud.value > today)
			{
				alert('La fecha de SOLICITUD no puede ser mayor a HOY.');
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
                <?php 
				
				if(isset($_POST['guardar_turno']) && $mnensaje == false){
				
				echo "<div class='alert alert-danger'>
  <strong>Error al guardar el turno.
</div>";
				
				}
				
				?>
						
							<div class="panel panel-default">
								<div class="panel-body">

									
										<h4 class="text-center"><img src="../images/wall-calendar.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

										<h3 class="text-center bg-info">Registrar Turno Exámen</h3>
										<h4 class="text-center bg-info">Datos Persona</h4>

										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">	
										
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Fecha</span>
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
												   <input name="txt_dni" type="text" class="form-control" id="txt_dni" value="<?php echo $txt_documento;?>" disabled="disabled"/>
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
									
								</div>
							</div>

							<div class="row">
								<div class="panel panel-default">
									<div class="panel-body">
									
										<h4 class="text-center bg-info">Datos Turno</h4>

										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">
												<div class="panel-body">

													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Solicitud</span>
															<div class='input-group date' id='divMiCalendarioSolicitud'>
																<input name="txt_fecha_solicitud" type='text' id="txt_fecha_solicitud" class="form-control" value="<?php echo $fecha_solicitud;?>"/>
																<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Exámen</span>
															<div class='input-group date' id='divMiCalendarioExamen'>
																<input name="txt_fecha_examen" type='text' id="txt_fecha_examen" class="form-control" value="<?php echo $fecha_examen;?>"/>
																<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
															</div>
														</div>
													</div>

													<!-- Ver cómo hace GUSTAVO lo de los TURNOS -->
                                                    
                                                        <div class="form-group">
                                                        
                                                            <div class="clearfix">
                                                            
                                                                <div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                                                                <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i> Hora Exámen</span>
                                                                    <input type="text" class="form-control" value="15:00" name="txt_hora" placeholder="Selecciona una hora">
                                                                    
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
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Tipo Exámen</span>
															<div class="col-xs-15 selectContainer">
																<select class="form-control" name="select_examen">
																  <?php 
																  
																  while ($row = mysqli_fetch_assoc($ejecuto_examenes)) {
																  
																  ?>
                                                                  <option value="<?php echo $row['id_tipo_examen']; ?>"><?php echo $row['nombre_tipo_examen']; ?></option>
                                                                  
                                                                  <?php } ?>
																</select>
															</div>
														</div>
													</div>

													<div class="form-group">
													   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
													   <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion" onKeyPress="return tabular(event,this)"><?php echo $observaciones; ?></textarea>
													</div>
                                                    
                                                   
                                                    
													<input name="txt_identificador" type="hidden" value="<?php echo $id; ?>" />
													<input name="guardar_turno" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" onclick="return validar_frm_alta_propietario();" />
                                                    </form>
                                                   
                                                 
                                                    
                                                    

												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
					</div>
				
			</div> <!-- Container -->
		</div>   <!-- Jumbotron -->
	
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
	</div>   <!-- Container -->

<script type="text/javascript">
	$('#divMiCalendarioSolicitud').datetimepicker({
      format: 'DD-MM-YYYY'
    });

    $('#divMiCalendarioExamen').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>





<script type="text/javascript" src="../js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	default: now
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}
</script>
<script type="text/javascript" src="../js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>



</body>
</html>
