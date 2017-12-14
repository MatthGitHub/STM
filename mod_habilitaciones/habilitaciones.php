<?php  

include("../lib/funciones.php");
include("../mod_sql/funciones2.php");
include ('../inc/conexion.php');

$db= Conexion();

$buscar = $_POST['txt_buscar'];


//LONGITUD DE BUSQUEDA

$long_buscar = strlen($buscar);

if (!empty($_POST['txt_buscar'])) {
    
    $sql = "SELECT `tup_habilitaciones`.* , `personas`.`apellido`, `personas`.`nombre`,`personas`.`documento`, `profesiones`.`nombre_profesion` FROM `tup_habilitaciones` INNER JOIN `personas` ON `tup_habilitaciones`.`fk_id_persona` = `personas`.`identificador` INNER JOIN `profesiones` ON `tup_habilitaciones`.`fk_id_profesion` = `profesiones`.`id_profesion` WHERE `personas`.`documento` like '%$buscar%' or `personas`.`apellido` like '%$buscar%'";
   
}elseif(empty($_POST['txt_buscar'])){
	
	$sql = "SELECT `tup_habilitaciones`.* , `personas`.`apellido`, `personas`.`nombre`,`personas`.`documento`, `profesiones`.`nombre_profesion` FROM `tup_habilitaciones` INNER JOIN `personas` ON `tup_habilitaciones`.`fk_id_persona` = `personas`.`identificador` INNER JOIN `profesiones` ON `tup_habilitaciones`.`fk_id_profesion` = `profesiones`.`id_profesion` ";
    
}else{
	
	$sql = "SELECT `tup_habilitaciones`.* , `personas`.`apellido`, `personas`.`nombre`,`personas`.`documento`, `profesiones`.`nombre_profesion` FROM `tup_habilitaciones` INNER JOIN `personas` ON `tup_habilitaciones`.`fk_id_persona` = `personas`.`identificador` INNER JOIN `profesiones` ON `tup_habilitaciones`.`fk_id_profesion` = `profesiones`.`id_profesion` limit 10";

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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
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
                <h4 class="text-center"><img src="../images/buscar_habilitacion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
                
                <h4 class="text-center bg-info">Buscar Habilitaciones</h4>

                </div>
                <div class="col-lg-6">
                
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validar();" id="formjquery" name="buscar"><br>
                        <input class="form-control" name="txt_buscar" id="txt_buscar" value="<?php if (isset($_POST['txt_buscar'])){echo $buscar;} ?>" required="required" placeholder="Buscar por número de documento o apellido"><br>
                        <input class="btn btn-success col-xs-12 col-lg-3" type="submit" value="Buscar" onSubmit="return validar();"> 
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
                        Habilitaciones Profesiones
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <div id="employee_table">  </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Nº Reg.</th>
                                    <th>Profesión</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Documento</th> 
                                    <th>Estado</th>
                                    <th>Fecha Hasta</th>
                                    <th>Entregada</th>
                                    <th>Observaciones</th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    while ($row = mysqli_fetch_assoc($ejecuto)) {?>
                                
                                        <tr class="odd gradeX">
                                        
                                            <td><?php echo $row['nro_habilitacion']; ?></td>
                                            <td><?php echo $row['nombre_profesion'];?></td>
                                            <td><?php echo $row['nombre']; ?></td>
                                            <td><?php echo $row['apellido']; ?></td>
                                            <td><?php echo $row['documento'];?></td>
                                            <td><?php echo $row['estado']; ?></td>
                                            <td><?php echo fecha_mysql_normal($row['fecha_hasta']); ?></td>
                                            <td><?php 
                                                if($row['entregada'] ==1)
                                                {
                                                    echo 'Sí';
                                                } else
                                                {
                                                    echo 'No';
                                                }


                                            ?></td>   
                                            <td> <?php echo $hab['observaciones']; ?> </td>                                         

                                            <td><form action="frm_ficha_habilitacion.php" method="POST">
                                              <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre']; ?>">
                                              <input type="hidden" name="txt_apellido" value="<?php echo $row['apellido']; ?>">
                                              <input type="hidden" name="txt_nombre_profesion" value="<?php echo $row['nombre_profesion']; ?>"/>
                                              <input type="hidden" name="txt_id_habilitacion" value="<?php echo $row['id_habilitacion']; ?>"/>
                                             
                                            
                                             <input type="submit" name="ver" value="Ver Ficha" class="btn btn-table">
                                             </form></td>        

                                            <td><form action="frm_modificar_habilitacion.php" method="POST">
                                              <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre']; ?>">
                                              <input type="hidden" name="txt_apellido" value="<?php echo $row['apellido']; ?>">
                                              <input type="hidden" name="txt_nombre_profesion" value="<?php echo $row['nombre_profesion']; ?>"/>
                                              <input type="hidden" name="txt_id_habilitacion" value="<?php echo $row['id_habilitacion']; ?>"/>
                                             
                                            
                                             <input type="submit" name="modificar" value="Modificar" class="btn btn-table">
                                             </form></td>                              
                                        
                                        </tr>
                                <?php  
                                }?>
                                
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

</body>

</html>