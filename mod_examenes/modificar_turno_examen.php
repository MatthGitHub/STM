<?php  
include("../lib/funciones.php");

include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');
include('../inc/sesion.php');


$db= Conexion();
$tipo_de_pago  = $_POST['txt_id_tipo_examen'];

//SELECCIONO TIPOS DE EXAMENES

$id = $_POST['txt_identificador'];

//CONSULTO LOS EXAMENES CORRESPONDIENTES A LA PROFESION DE LA PERSONA 
$examenes = "SELECT a.id_tipo_examen,a.nombre_tipo_examen,a.fk_id_profesion FROM tipos_examenes a, personas_profesiones b
WHERE b.fk_id_profesion = a.fk_id_profesion AND b.fk_id_persona = '$id'";
$ejecuto_examenes = mysqli_query($db,$examenes);



if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$id_examen = $_POST['txt_id_examen'];
	$tipo_examen = $_POST['txt_tipo_examen'];

	$nombre = $_POST['txt_nombre'];
	$apellido = $_POST['txt_apellido'];
	$documento = $_POST['txt_documento'];

	$examenes = buscar_examen($id_examen);

	//Lleno los campos

	 while ($row = mysqli_fetch_assoc($examenes)) 
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

if(isset($_POST['btn_modificar']) && $_POST['btn_modificar']=='Modificar') {

	$nombre = $_POST['txt_nombre'];
	$apellido = $_POST['txt_apellido'];
	$documento = $_POST['txt_documento'];
 	$examen = $_POST['id_examen'];
	$nueva_fecha_examen = $_POST['fecha_examen'];
	$nueva_hora_examen = $_POST['hora_examen'];
	$tipo_de_examen = $_POST['select_examen'];
	$observaciones = $_POST['txt_observaciones'];	
	$fecha_examen = fecha_normal_mysql($nueva_fecha_examen);
	$id_tipo_examen = $_POST['txt_id_tipo_examen'];
	
	
	//CONSULTO LA PROFESION DE ACUERDO AL TIPO DE EXAMEN QUE SE ELIGE.
	$busco_profesion = "SELECT DISTINCT a.id_profesion,a.nombre_profesion,b.id_tipo_examen,b.nombre_tipo_examen FROM profesiones a
INNER JOIN tipos_examenes b ON b.fk_id_profesion = a.id_profesion
WHERE id_tipo_examen = '$tipo_de_examen'";
	$ejecuto_buscar_profesion  =  mysqli_query($db,$busco_profesion);
	
	while($resul = mysqli_fetch_assoc($ejecuto_buscar_profesion)){
		
		$id_profesion = $resul['id_profesion'];
	
	}

	$query = "UPDATE `tup_examenes` SET `fecha_examen`='$fecha_examen',
	`hora_examen`='$nueva_hora_examen',
	`observaciones`='$observaciones',
	`tipo_examen`='$tipo_de_examen',
	`fk_id_profesion`='$id_profesion'
	WHERE id_examen ='$examen'";

	$modificar = mysqli_query($db,$query);

	if($modificar){

		auditar($_SESSION['id'],$query);
	
		$output.="Turno modificado correctamente";
	
		echo "<script>";
	    echo "alert('$output');";
    	echo "window.location = 'examenes.php';";
    	echo "</script>";
	
	}else{
		$mensaje = true;
		$output.="Error al modificar el turno";
	}

}
mysqli_close($db);


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
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-clockpicker.min.css">
	<link rel="stylesheet" type="text/css" href="../css/github.min.css">
    
    
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
			
			if (!vacio(document.form1.txt_fecha_vencimiento.value)){
				alert("Seleccione fecha de exámen."); 
				document.form1.txt_fecha_vencimiento.focus();
				return false;
			}
			
			if (!vacio(document.form1.hora_examen.value)){
				alert("Seleccione hora de exámen."); 
				document.form1.hora_examen.focus();
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
					<div class="panel panel-default">
						<div class="panel-body">

									<?php 
									
									if ($mensaje==true){
										echo "<div class='alert alert-warning'>
  											<strong>Error!</strong> $output.
											</div>";
									 
									}
									
									?>
									<h4 class="text-center"><img src="../images/mod_examen.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

									<h3 class="text-center bg-info">Modificar Turno Exámen</h3>

									<div class="col-md-6 col-md-offset">
									<h4 class="text-center bg-info">Datos Persona</h4>
                                    <h4>Nombre y Apellido : <?php echo '<strong>'.$nombre.' '.$apellido.'</strong>'; ?></h4>
                                    <h4>Documento : <?php echo '<strong>'.$documento.'</strong>'; ?></h4>
                                    
                                    <h4 class="text-center bg-info">Datos del turno</h4>
                                    <h4>Fecha de exámen : <?php echo '<strong>'.fecha_mysql_normal($_POST['txt_fecha_examen']).'</strong>'; ?></h4>
                                    <h4>Hora de exámen : <?php echo '<strong>'.$_POST['txt_hora_examen'].'</strong>';?></h4>
                                    <h4>Tipo de exámen : <?php echo '<strong>'.$_POST['txt_tipo_examen'].'</strong>' ;?></h4>
                                    
                                    
									
									</div>
									
									<div class="col-md-6 col-md-offset">
                                    
                                    <div class="form-group">
			                            <div class="input-group">
			                                <span class="input-group-addon"><i class="fa fa-calendar-times-o fa-fw"></i> Fecha Exámen* </span>
			                                <div class='input-group date' id='divMiCalendarioVencimiento'>
			                                    <input name="fecha_examen" type='text' id="txt_fecha_vencimiento" class="form-control" value="<?php echo fecha_mysql_normal($_POST['txt_fecha_examen']); ?>"/>
                                                
			                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
			                                </div>
			                            </div>
			                        </div>
							
									<input name="id_examen" type="hidden" value="<?php echo $_POST['txt_id_examen']; ?>" />
                                    
									<!-- <div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Hora Exámen</span>
											<input name="hora_examen" type="time" class="form-control" id="txt_apellido" value="<?php echo $_POST['txt_hora_examen'];?>"/>
										</div>
									</div> -->
                                    
                                    <div class="form-group">
                                               
                                        <div class="clearfix">
                                        
                                            <div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                                            <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i> Hora Exámen</span>
                                                <input type="text" class="form-control" value="<?php echo $_POST['txt_hora_examen'];?>" name="hora_examen" placeholder="Selecciona una hora">
                                                
                                            </div>
                                           
                                        </div>
                                     </div>
                                    
                                    
	                                
	                                <div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i>Tipo de Exámen </span>
											<select class="form-control" name="select_examen" id="select_tipo_examen"> 
										  <?php 
	                                      
	                                      while ($row1 = mysqli_fetch_assoc($ejecuto_examenes)) {
	                                      
	                                      ?>
	                                      <option value="<?php echo $row1['id_tipo_examen']; ?>"><?php echo $row1['nombre_tipo_examen']; ?></option>
	                                      
	                                      <?php } ?>
	                                    </select>
										</div>
									</div>
                                            
                                    <div class="form-group">
                   						<span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
                   						<textarea class="form-control" rows="3" id="txt_observaciones" name="txt_observaciones" onKeyPress="return tabular(event,this)" ><?php echo $_POST['txt_observaciones']; ?></textarea>
                					</div>
                                            
                                            	
									<input type="submit" name="btn_modificar" class="btn btn-success form-control" value="Modificar" onclick="return validar_frm_alta_propietario()"/>
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

	<script type="text/javascript">

	var id_tipo_examen = '<?php echo $tipo_de_pago; ?>'
	document.getElementById('select_tipo_examen').value = id_tipo_examen;
	
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

    
</html>