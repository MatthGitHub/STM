
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

$pagos = "SELECT * FROM tipo_pago";
$ejecuto_tipo_pagos = mysqli_query($db,$pagos);
$titulo = 'Nuevo Canon';
$mensaje = false;



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['btn_canon'])){
	
	$txt_nombre = test_input($_POST['txt_nombre']);
	$txt_apellido = test_input($_POST['txt_apellido']);
	$profesion = $_POST['txt_fk_id_profesion'];
	$txt_identificador = test_input($_POST['txt_fk_id_persona']);
	$nombre_profesion = $_POST['txt_nombre_profesion'];

}


if (isset($_POST['guardar_canon'])){
	
		if($_POST['vigencia_check']=="")
		{
			$vigencia_check=0;
		}else{
			$vigencia_check=1;
		}

		$id = $_POST['id_canon'];
		$fecha_cobro = fecha_normal_mysql($_POST['txt_fecha_cobro']);
		$nro_recibo = $_POST['txt_nro_recibo'];
		$importe = $_POST['txt_importe'];
		$observaciones = $_POST['txt_observacion'];
		$tipo_pago = $_POST['select_tipo_pago'];
		$vigencia_desde = $_POST['txt_vigencia_desde'];
		$vigencia_hasta = $_POST['txt_vigencia_hasta'];
		
		$persona_id = $_POST['id_persona'];
		$profesion_id = $_POST['id_profesion'];

		
		/*if($vigencia_desde == "")
		{
			$vigencia_desde = 'NULL';
		}else{
			$vigencia_desde = fecha_normal_mysql($_POST['txt_vigencia_desde']);

		}

		if($vigencia_hasta == "")
		{
			$vigencia_hasta = 'NULL';
		}else{
			$vigencia_hasta = fecha_normal_mysql($_POST['txt_vigencia_hasta']);

		}*/

		//echo 'desde '.$vigencia_desde;
		//echo ' / hasta '.$vigencia_hasta;

		//SI EL CAMPO ID_CANON NO VIENE VACIO, ES UN REGISTRO PARA MODIFICAR
		if ($id!=''){
			
			$id_canon_actualizar = $_POST['id_canon'];
				
			//$sql = "UPDATE `canones` SET `fecha_cobro`='$fecha_cobro',`nro_recibo`='$nro_recibo',`importe`='$importe',`observaciones`='$observaciones',`fk_tipo_pago`='$tipo_pago',`vigencia_desde`='$vigencia_desde',`vigencia_hasta`='$vigencia_hasta' WHERE id_canon = '$id_canon_actualizar'";


			 $sql = "UPDATE `canones` SET `fecha_cobro`='$fecha_cobro',`nro_recibo`='$nro_recibo',`importe`='$importe',`observaciones`='$observaciones',`fk_tipo_pago`='$tipo_pago',`vigencia_desde`=";
		   
		    if ($vigencia_desde == "" or $vigencia_check == 0){
		        $sql .= "NULL,`vigencia_hasta`=";
		    }
		    else {
		    	
		    	$vigencia_desde = fecha_normal_mysql($_POST['txt_vigencia_desde']);

		        $sql .= " '$vigencia_desde',`vigencia_hasta`=";
		    }

		    if ($vigencia_hasta == "" or $vigencia_check == 0){
		        $sql .= "NULL WHERE id_canon = '$id_canon_actualizar'";
		    }
		    else {
		    	$vigencia_hasta = fecha_normal_mysql($_POST['txt_vigencia_hasta']);

		        $sql .= " '$vigencia_hasta' WHERE id_canon = '$id_canon_actualizar'";
		    }
			

		   //echo '      - SQL-> '.$sql;
			
			$output.="Canon actualizado correctamente";
		
		//SI VIENE VACIO, INSERTA UN NUEVO CANON
		}else {

		    $sql = "INSERT INTO `canones`(`fecha_cobro`, `nro_recibo`, `importe`, `observaciones`, `fk_tipo_pago`, `vigencia_desde`, `vigencia_hasta`, `fk_id_persona`, `fk_id_profesion`) VALUES ('$fecha_cobro','$nro_recibo','$importe','$observaciones','$tipo_pago',";
		   
		    if ($vigencia_desde == "" or $vigencia_check == 0){
		        $sql .= "NULL,";
		    }
		    else {
		    	$vigencia_desde = fecha_normal_mysql($_POST['txt_vigencia_desde']);

		        $sql .= " '$vigencia_desde',";
		    }

		    if ($vigencia_hasta == "" or $vigencia_check == 0){
		        $sql .= "NULL,'$persona_id','$profesion_id')";
		    }
		    else {
		    	$vigencia_hasta = fecha_normal_mysql($_POST['txt_vigencia_hasta']);

		        $sql .= " '$vigencia_hasta','$persona_id','$profesion_id')";
		    }
			

		   // echo '      - SQL-> '.$sql;

			//$sql = "INSERT INTO `canones`(`fecha_cobro`, `nro_recibo`, `importe`, `observaciones`, `fk_tipo_pago`, `vigencia_desde`, `vigencia_hasta`, `fk_id_persona`, `fk_id_profesion`) VALUES ('$fecha_cobro','$nro_recibo','$importe','$observaciones','$tipo_pago','$vigencia_desde','$vigencia_hasta','$persona_id','$profesion_id')";
			
			$output.="Canon guardado correctamente";
			
		
		}
		
		$ejecuto = mysqli_query($db,$sql);
	
		if ($ejecuto){

			auditar($_SESSION['id'],$sql);

				echo "<script>";
				echo "alert('$output');";
				echo "window.location = 'canones.php';";
				echo "</script>";
		}else{
			$mensaje = false;
		}
			
	}	

//RECIBO LOS DATOS DEL CANON PARA MODIFICAR
if(($_POST['modificar_canon'])) {
	
	if(!empty($_POST['modificar_canon'])){
		
		$id_canon = $_POST['txt_id_canon'];
		$fecha_cobro_canon = fecha_mysql_normal($_POST['txt_fecha_cobro_modificar']);
		$nro_recibo_canon = $_POST['txt_nro_recibo_modificar'];
		$importe_canon = $_POST['txt_importe_modificar'];

		if($_POST['txt_fecha_vigencia_desde'] != NULL){
			$vigencia_canon_desde = fecha_mysql_normal($_POST['txt_fecha_vigencia_desde']);
		}else{
			$vigencia_canon_desde = '';
		}

		if($_POST['txt_fecha_vigencia_hasta'] != NULL){
			$vigencia_canon_hasta = fecha_mysql_normal($_POST['txt_fecha_vigencia_hasta']);
		}else{
			$vigencia_canon_hasta = '';
		}
		
		
		$observaciones_canon = $_POST['txt_observaciones_modificar'];
		$id_tipo_pago = $_POST['txt_id_tipo_pago'];
		$txt_identificador = $_POST['txt_id_fk_persona'];
		$profesion = $_POST['txt_id_fk_profesion'];
		$txt_nombre = test_input($_POST['txt_nombre']);
		$txt_apellido = test_input($_POST['txt_apellido']);
		$nombre_profesion = $_POST['txt_nombre_profesion'];
		$titulo = 'Modificar Canon';
		
	
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
	<link rel="icon" type="image/png" href="../images/logo_verde.png" sizes="16x16">
    <title>Sistema Turismo MSCB</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <script>

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
	
		function validar_frm(f)
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


			if(document.form1.txt_fecha_cobro.value > today)
			{
				alert('La fecha de cobro no puede ser mayor a HOY.');
				return false;
			}
						
			if((document.form1.vigencia_check.checked) && ((document.form1.txt_vigencia_desde.value=="") || (document.form1.txt_vigencia_hasta.value=="")))
			{
				alert('Debe indicar las 2 fechas de vigencia.');
				return false;
			}

			if((document.form1.vigencia_check.checked) && (document.form1.txt_vigencia_desde.value > document.form1.txt_vigencia_hasta.value))
			{
				alert('La fecha DESDE de vigencia, no puede ser mayor a la fecha HASTA.');
				return false;
			}
		}

    </script>



</head>


<body onLoad="document.form1.txt_nombre.focus();">
<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>
      		<!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
            	<div class="row">
                    
                    <?php 
                    
                    if(isset($_POST['guardar_turno']) && $mnensaje == false){
                    
                    echo "<div class='alert alert-danger'>
                            <strong>Error al guardar el turno.
                        </div>";
                    
                    }
                    
                    ?>
                    
                    <div class="panel panel-default">
                            <div class="panel-body">
                    <h4 class="text-center"><img src="../images/canon.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

                    	<?php 
                    		if(($_POST['modificar_canon'])) {
                    	?>
                    			<h3 class="text-center bg-info">Modificar Canon</h3>
                    	<?php }else{ ?>

                    			<h3 class="text-center bg-info">Cargar Canon</h3>
                    	<?php } ?>
                    	<h4 class="text-center bg-info">Datos Profesional</h4>
                        
                        					<div class="col-md-4 col-md-offset">
												<div class="panel panel-default">	
											
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
														<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre; ?>" disabled="disabled"/>
													</div>
												</div>

												</div>
											</div>
                                            
                                            
                                            <div class="col-md-4 col-md-offset">
												<div class="panel panel-default">
													
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
															<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $txt_apellido;?>" disabled="disabled"/>
														</div>
													</div>

												</div>
											</div>
                                            
                                            <div class="col-md-4 col-md-offset">
												<div class="panel panel-default">
													
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Profesión</span>
															<input name="" type="text" class="form-control" id="" value="<?php echo $nombre_profesion;?>" disabled="disabled"/>
														</div>
													</div>

												</div>
											</div>
                    
                    
                   	 </div>
                    </div>
                    <div class="panel panel-default">
                            <div class="panel-body">
                    
							<h4 class="text-center bg-info"><?php echo $titulo; ?></h4>
                    
                        
	                            <div class="col-md-6 col-md-offset" align="right">
                                
									
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha cobro</span>
													<div class='input-group date' id='divMiCalendarioSolicitud'>
														<input name="txt_fecha_cobro" type='text' id="txt_fecha_cobro" class="form-control" value="<?php echo $fecha_cobro_canon;?>" placeholder="Seleccione fecha de cobro" required />

														<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
													</div>
											</div>
										</div>
                                        
                                      <input name="id_canon" type='hidden' class="form-control" value="<?php echo $id_canon;?>"/>
                                      <input name="id_persona" type='hidden' class="form-control" value="<?php echo $txt_identificador;?>"/>
                                      <input name="id_profesion" type='hidden' class="form-control" value="<?php echo $profesion;?>"/>
					
                                        <div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Nro Recibo</span>
													<input type="number" name="txt_nro_recibo" class="form-control" placeholder="Ingrese el número de recibo" value="<?php echo $nro_recibo_canon; ?>" required >
											</div>
										</div>
                                        
                                        <div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-money fa-fw"></i> Importe</span>
												<div class="col-xs-15 selectContainer">
													<input type="money" name="txt_importe" class="form-control" placeholder="Ingrese el importe" value="<?php echo $importe_canon; ?>" required >
												</div>
											</div>
										</div>
                                        
                                        <div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Tipo Pago</span>
											<div class="col-xs-15 selectContainer">
                                                <select class="form-control" name="select_tipo_pago" id="select_tipo_pago" required >
                                                              <?php 
                                                              
                                                              while ($row = mysqli_fetch_assoc($ejecuto_tipo_pagos)) {
                                                              
                                                              ?>
                                                              <option value="<?php echo $row['id_tipo_pago']; ?>"><?php echo $row['nombre_tipo_pago']; ?></option>
                                                              
                                                              <?php } ?>
                                                </select>
											</div>
										</div>
									</div>
                                        
								</div>  <!-- FIN COL-LG-6-->   
                                
                                <div class="col-md-6 col-md-offset" align="right">
                              		
                              		<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-question-circle fa-fw"></i> ¿Con vigencia? <input type="checkbox" name="vigencia_check" value="1" <?php if($vigencia == true) echo "checked='checked'"; if($vigencia_canon_desde != '' && $vigencia_canon_hasta != '') echo "checked='checked'"; ?>/> </span>
										</div>
									</div> 
                                        
                                        
                                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Vigencia desde</span>
                                                <div class='input-group date' id='divMiCalendarioVigencia1'>
                                                    <input name="txt_vigencia_desde" type='text' id="txt_vigencia_desde" class="form-control" value="<?php echo $vigencia_canon_desde;?>" placeholder="Seleccione fecha de vigencia"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
												</div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Vigencia hasta</span>
                                                <div class='input-group date' id='divMiCalendarioVigencia2'>
                                                    <input name="txt_vigencia_hasta" type='text' id="txt_vigencia_hasta" class="form-control" value="<?php echo $vigencia_canon_hasta;?>" placeholder="Seleccione fecha de vigencia"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                </div>
                                        </div>
                                    </div>
                                        
                                    <div class="form-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
                                            <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion" onKeyPress="return tabular(event,this)" placeholder="Ingrese alguna observación adicional"><?php echo $observaciones_canon; ?></textarea>
                                    </div>
                                        <input name="guardar_canon" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" onclick="return validar_frm();"/>
                                        
                                      
                                        
                                        
                                         
                              			
                                </div>  <!-- FIN COL-LG-6 -->                              
                            </div>   <!-- FIN PANEL BODY -->   
                        </div> <!-- FIN PANEL DEFAULT-->
                	</div> <!-- FIN ROW -->
                </div><!-- FIN CONTAINER-->
                
             </div><!-- FIN JUMBOTRON-->
	
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
        
	</div><!--FIN CONTAINER PRINCIPAL -->
    </form>

	<script type="text/javascript">
        $('#divMiCalendarioSolicitud').datetimepicker({
          format: 'DD-MM-YYYY'
        });
    
        $('#divMiCalendarioExamen').datetimepicker({
          format: 'DD-MM-YYYY'
        });
        
        $('#divMiCalendarioVigencia1').datetimepicker({
          format: 'DD-MM-YYYY'
        });
        
        $('#divMiCalendarioVigencia2').datetimepicker({
          format: 'DD-MM-YYYY'
        });



    </script>
    
    <script type="text/javascript">
	
	//CODIGO PARA CARGAR EL OPTION VALUE DESDE LA BASE DE DATOS, PARA EL TIPO DE PAGO.
	var id_tipo_pago = '<?php echo $id_tipo_pago; ?>'
	document.getElementById('select_tipo_pago').value = id_tipo_pago;
	
	</script>

</body>
</html>
