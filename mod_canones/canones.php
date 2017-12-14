<?php  

include '../inc/conexion.php';
include '../lib/funciones.php';

$db= Conexion();

$examenes = "SELECT * FROM tipos_examenes";
$ejecuto_examenes = mysqli_query($db,$examenes);

$sql = "SELECT a.*,b.*,c.nombre,c.apellido,d.nombre_profesion FROM canones a, tipo_pago b,personas c,profesiones d
WHERE a.fk_tipo_pago=b.id_tipo_pago and
		a.fk_id_persona=c.identificador and
        a.fk_id_profesion=d.id_profesion";
$ejecuto = mysqli_query($db,$sql);
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
         <div class="col-lg-4"></div>
                <div class="col-lg-3">
                <br>
                <h4 class="text-center"><img src="../images/canon.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

                    <h4 class="text-center bg-info">Canones</h4>
                </div>
                
                
                <!-- /.col-lg-12 -->
        </div>
            <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Canones
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <div id="employee_table"></div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                	<th>PROFESIONAL</th>
                                    <th>PROFESION</th>
                                    <th>FECHA COBRO</th>
                                    <th>NRO RECIBO</th>
                                    <th>IMPORTE</th>
                                    <th>TIPO DE PAGO</th>
                                    <th>VIGENCIA DESDE</th>
                                    <th>VIGENCIA HASTA</th>
                                    <th>OBSERVACIONES</th>
                                    <th></th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    while ($row = mysqli_fetch_assoc($ejecuto)) {
                                       
                                ?>
                                
                                <tr class="odd gradeX">
                                
                                   
                                    <td class="center"><?php echo $row['nombre'].' '.$row['apellido'];?></td>
                                    <td class="center"><?php echo $row['nombre_profesion'];?></td>
                                    <td class="center"><?php echo fecha_mysql_normal($row['fecha_cobro']);?></td>
                                    <td class="center"><?php echo $row['nro_recibo'];?></td>
                                    <td class="center"><?php echo '$ '.$row['importe'];?></td>
                                    <td class="center"><?php echo $row['nombre_tipo_pago'];?></td>
                                    <td class="center"><?php echo fecha_mysql_normal($row['vigencia_desde']);?></td>
                                    <td class="center"><?php echo fecha_mysql_normal($row['vigencia_hasta']);?></td>
                                    <td class="center"><?php echo $row['observaciones'];?></td>
                                    
                                    <td><form action="frm_canon.php" method="POST">
                                    <input type="hidden" name="txt_id_canon" value="<?php echo $row['id_canon']; ?>" />
                                    <input type="hidden" name="txt_fecha_cobro_modificar" value="<?php echo $row['fecha_cobro']; ?>" />
                                    <input type="hidden" name="txt_nro_recibo_modificar" value="<?php echo $row['nro_recibo']; ?>" />
                                    <input type="hidden" name="txt_importe_modificar" value="<?php echo $row['importe']; ?>" />
                                    <input type="hidden" name="txt_observaciones_modificar" value="<?php echo $row['observaciones']; ?>" />
                                    <input type="hidden" name="txt_fecha_vigencia_desde" value="<?php echo $row['vigencia_desde']; ?>" />
                                    <input type="hidden" name="txt_fecha_vigencia_hasta" value="<?php echo $row['vigencia_hasta']; ?>" />
                                    <input type="hidden" name="txt_id_tipo_pago" value="<?php echo $row['id_tipo_pago']; ?>" />
                                    <input type="hidden" name="txt_id_fk_persona" value="<?php echo $row['fk_id_persona']; ?>" />
                                    <input type="hidden" name="txt_id_fk_profesion" value="<?php echo $row['fk_id_profesion']; ?>" />
                                    <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre']; ?>" />
                                    <input type="hidden" name="txt_apellido" value="<?php echo $row['apellido']; ?>" />
                                    <input type="hidden" name="txt_nombre_profesion" value="<?php echo $row['nombre_profesion']; ?>" />
                                    
                                    
                                    
                                    <input type="submit" name="modificar_canon" onclick="return confirm('¿Desea MODIFICAR el CANON?');" value="Modificar" class="btn btn-table" /></form></td>
                                    

                                   
                                
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