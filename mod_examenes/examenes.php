<?php  
date_default_timezone_set("America/Argentina/Buenos_Aires");
include '../inc/conexion.php';
include '../lib/funciones.php';

$db= Conexion();

//SELECCIONO TIPOS DE EXAMENES

$examenes = "SELECT * FROM tipos_examenes";
$ejecuto_examenes = mysqli_query($db,$examenes);

$buscar = $_POST['txt_buscar'];

//LONGITUD DE BUSQUEDA

$long_buscar = strlen($buscar);

if (!empty($_POST['txt_buscar'])) {
    
    $sql = "SELECT `tup_examenes`.*,DATE_FORMAT(`tup_examenes`.`hora_examen`, '%H:%I'),`personas`.`apellido`, `personas`.`nombre`,`personas`.`identificador`, `personas`.`documento`,`tipos_examenes`.`nombre_tipo_examen`,`tipos_examenes`.`id_tipo_examen`
    FROM `tup_examenes`
INNER JOIN `personas` ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
where `personas`.DOCUMENTO like '%$buscar%' or `personas`.APELLIDO like '%$buscar%' order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen` 
";
   
}elseif(empty($_POST['txt_buscar'])){
	
	$sql = "SELECT `tup_examenes`.*,`personas`.`apellido`, `personas`.`nombre`,`personas`.`identificador`, `personas`.`documento`,`tipos_examenes`.`nombre_tipo_examen`,`tipos_examenes`.`id_tipo_examen`
FROM `tup_examenes`
INNER JOIN `personas` ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen`";
    
}else{
	
	$sql = "SELECT `tup_examenes`.*,`personas`.`apellido`, `personas`.`nombre`,`personas`.`identificador`, `personas`.`documento`,`tipos_examenes`.`nombre_tipo_examen`,`tipos_examenes`.`id_tipo_examen` 
  FROM `tup_examenes`
INNER JOIN `personas` ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen`  limit 10";

}
 $ejecuto = mysqli_query($db,$sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../images/logo.png" sizes="16x16">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Turismo MSCB</title>

   <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
    <script src="../js/jquery.min.js"></script>  
   
    
</head>

<script>
function validar(){
	
	//Almacenamos los valores
	nombre=$('#txt_buscar').val();
	
   //Comprobamos la longitud de caracteres
	if (nombre.length>4){
		return true;
	}
	else {
		alert('Minimo 5 caracteres');
		return false;
		
	}

}
</script>



<body>

    <div class="container">
        <br>
            <?php include("../inc/menu.php"); ?>

         <div class="row">
                <div class="col-lg-3">
                <br>
                <h4 class="text-center"><img src="../images/buscar_examen.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

                    <h4 class="text-center bg-info">Buscar Exámen</h4>
                </div>
                <div class="col-lg-6">
                
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validar();" id="formjquery" name="buscar"><br>
                        <input class="form-control" name="txt_buscar" id="txt_buscar" value="<?php if (isset($_POST['txt_buscar'])){echo $buscar;} ?>" required="required" placeholder="Buscar por número de documento o apellido"><br>
                        <input class="btn btn-success" type="submit" value="Buscar" onSubmit="return validar();"> 
                    </form>
                </div>
                <div></div>
                <!-- /.col-lg-12 -->
        </div>
            <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Profesionales
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <div id="employee_table"></div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>DOCUMENTO</th>
                                    <th>FECHA EXAMEN</th>
                                    <th>HORA EXAMEN</th>
                                    <th>TIPO EXAMEN</th>
                                    <th>RESULTADO</th>
                                    <th>Observaciones</th>
                                    <th></th>
                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    while ($row = mysqli_fetch_assoc($ejecuto)) {
										
										
										
                                       
                                ?>
                                
                                <tr class="odd gradeX">
                                
                                    <td><?php echo $row['nombre'].' '.$row['apellido']; ?></td>
                                    <td class="center"><?php echo $row['documento'];?></td>
                                    <td class="center"><?php echo fecha_mysql_normal($row['fecha_examen']);?></td>
                                    <td class="center"><?php echo $row['hora_examen'];?></td>
                                    <td class="center"><?php echo $row['nombre_tipo_examen'];?></td>
                                    <td class="center"><?php echo $row['resultado'];?></td>
                                    <td class="center"><?php echo $row['observaciones'];?></td>
                                    
                                    <td><form action="modificar_turno_examen.php" method="POST">
                                    <input type="hidden" name="txt_identificador" value="<?php echo $row['identificador']; ?>" />
                                    <input type="hidden" name="txt_id_examen" value="<?php echo $row['id_examen']; ?>" />
                                    <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre']; ?>" />
                                    <input type="hidden" name="txt_apellido" value="<?php echo $row['apellido']; ?>" />
                                    <input type="hidden" name="txt_documento" value="<?php echo $row['documento']; ?>" />
                                    <input type="hidden" name="txt_fecha_examen" value="<?php echo $row['fecha_examen']; ?>" />
                                    <input type="hidden" name="txt_hora_examen" value="<?php echo $row['hora_examen']; ?>" />
                                    <input type="hidden" name="txt_tipo_examen" value="<?php echo $row['nombre_tipo_examen']; ?>" />
                                    <input type="hidden" name="txt_observaciones" value="<?php echo $row['observaciones']; ?>" />
                                    <input type="hidden" name="txt_id_tipo_examen" value="<?php echo $row['id_tipo_examen']; ?>" />
                                    
                                    <?php if($row['resultado'] == "")
                                    {?>
                                        <input type="submit" name="btn_modificar" onclick="return confirm('¿Desea MODIFICAR el turno?');" value="Modificar TURNO" class="btn btn-success btn-xs"></form>
                                    <?php
                                    }else{?>
                                       <input type="submit" name="btn_modificar" onclick="return confirm('¿Desea MODIFICAR el turno?');" value="Modificar TURNO" class="btn btn-success btn-xs" disabled="disabled"></form>
                                   <?php }?>

                                      </td>

                                     <td><form action="frm_resultado_examen.php" method="POST">
                                    <input type="hidden" name="txt_id_examen" value="<?php echo $row['id_examen']; ?>" />
                                    <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre']; ?>" />
                                    <input type="hidden" name="txt_apellido" value="<?php echo $row['apellido']; ?>" />
                                    <input type="hidden" name="txt_documento" value="<?php echo $row['documento']; ?>" />
                                    <input type="hidden" name="txt_fecha_examen" value="<?php echo $row['fecha_examen']; ?>" />
                                    <input type="hidden" name="txt_hora_examen" value="<?php echo $row['hora_examen']; ?>" />
                                    <input type="hidden" name="txt_tipo_examen" value="<?php echo $row['nombre_tipo_examen']; ?>" />
                                    <input type="hidden" name="txt_observaciones" value="<?php echo $row['observaciones']; ?>" />
                                    <input type="submit" name="btn_resultado" value="Registrar RESULTADO" class="btn btn-table">
                                    </form></td>
                                    
                                
                                </tr>
                                

                                <?php } ?>
                                
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                       
                    </div>  <!-- /.panel-body -->
                </div>  <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div> <!-- /.row -->

        <div class="panel-footer">
                <p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
        </div>

    </div><!-- container -->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

	
    

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
		responsive : true,
        "language": {
            "url": "../inc/spanish.json"
        	}
    	} );
	} );
   
  </script>
  
  
  <!-- JS DATEPICKER MODAL -->
  
  
  


  
  

  
</body>

</html>

<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Nueva Habilitación</h4>  
                </div>  
                <div class="modal-body" id="detalles">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Modificar turno examen</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha solicitud </span>
                                <div class='input-group date' id='calendario1'>
                                    <input name="txt_fecha_solicitud" type='text' id="txt_fecha_solicitud" class="form-control"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha examen </span>
                                <div class='input-group date' id='calendario2'>
                                    <input name="txt_fecha_examen" type='text' id="txt_fecha_examen" class="form-control"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                        </div>

                    
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Hora exámen </span>
                                <input name="txt_hora" type='text' id="txt_hora" class="form-control"/>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"> Tipo exámen </span>
                                
                                    <select class="form-control" name="select_examen" id="select_examen"> 
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
                           <textarea class="form-control" rows="3" id="txt_observaciones" name="txt_observaciones" onKeyPress="return tabular(event,this)"></textarea>
                        </div>
						
                        
                        <!--DATOS PERSONA PROFESIONAL -->
                       
                        <input type="hidden" name="employee_id" id="employee_id" />  
                          <br>
                        <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" /> 
                            
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>  
                </div>  
           </div>  
      </div>  
 </div> 



 <script> 




 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      });  
      $(document).on('click', '.edit_data', function(){  
           var employee_id = $(this).attr("id");  
           $.ajax({  
                url:"fetch_examen.php",  
                method:"POST",  
                data:{employee_id:employee_id},  
                dataType:"json",  
                success:function(data){  
          					$('#txt_fecha_solicitud').val(data.fecha_solicitud);
          					$('#txt_fecha_examen').val(data.fecha_examen);
          					$('#txt_hora').val(data.hora_examen);   					
          					$('#select_examen').val(data.tipo_examen);
                    $('#txt_observaciones').val(data.observaciones);			
                    $('#employee_id').val(data.id_examen);  
                    $('#insert').val("Actualizar");  
                    $('#add_data_Modal').modal('show');  
                }  
           });  
      });  
      $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#txt_fecha_solicitud').val() == "")  
           {  
                alert("Selecciona una fecha de solicitud.");  
           }  
           else if($('#txt_fecha_examen').val() == '')  
           {  
                alert("Seleccione una fecha de exámen.");  
           }  
           else if($('#txt_hora').val() == '')  
           {  
                alert("Selecciona una hora.");  
           }  
           else if($('#age').val() == '')  
           {  
                alert("Age is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"actualizar_examen.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Guardando...");  
                     },  
                     success:function(data){  
                          $('#insert_form')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#employee_table').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', '.view_data', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"select.php",  
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#detalles').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });  
 });  

 


 </script>
