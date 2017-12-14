<?php  

include '../inc/conexion.php';
include '../lib/funciones.php';

$db= Conexion();

$buscar = $_POST['txt_buscar'];


//LONGITUD DE BUSQUEDA

$long_buscar = strlen($buscar);

if (!empty($_POST['txt_buscar'])) {
    
    $sql = "SELECT `tup_examenes`.*,`personas`.`apellido`, `personas`.`nombre`, `personas`.`documento`,`tipos_examenes`.`nombre_tipo_examen` FROM `tup_examenes`
INNER JOIN `personas`
ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
WHERE `tup_examenes`.`fecha_examen`=DATE(NOW()) AND (`personas`.DOCUMENTO like '%$buscar%' or `personas`.APELLIDO like '%$buscar%') order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen` 
";

 $ejecuto = mysqli_query($db,$sql);
   
}elseif(empty($_POST['txt_buscar'])){
	
	$sql = "SELECT `tup_examenes`.*,`personas`.`apellido`, `personas`.`nombre`, `personas`.`documento` ,`tipos_examenes`.`nombre_tipo_examen` FROM `tup_examenes`
INNER JOIN `personas`
ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
WHERE `tup_examenes`.`fecha_examen`=DATE(NOW())
order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen`";

$ejecuto = mysqli_query($db,$sql);
    
}else{
	
	$sql = "SELECT `tup_examenes`.*,`personas`.`apellido`, `personas`.`nombre`, `personas`.`documento` ,`tipos_examenes`.`nombre_tipo_examen` FROM `tup_examenes`
INNER JOIN `personas`
ON `tup_examenes`.`fk_id_persona` = `personas`.`identificador`
INNER JOIN `tipos_examenes` ON `tipos_examenes`.`id_tipo_examen` = `tup_examenes`.`tipo_examen`
WHERE `tup_examenes`.`fecha_examen`=DATE(NOW())
order by `tup_examenes`.`fecha_examen`,`tup_examenes`.`hora_examen` limit 10";
$ejecuto = mysqli_query($db,$sql);

}


if(isset($_POST['btn_ausente']))
{
    $examen = $_POST['txt_id_examen'];

    $resultado = "Ausente"; 


    $query = "UPDATE `tup_examenes` SET `resultado`='$resultado'
    WHERE id_examen ='$examen'";

    $modificar = mysqli_query($db,$query);

    if($modificar){
    
        $output.="Ausencia registrada correctamente";
    
        echo "<script>";
        echo "alert('$output');";
        echo "window.location = 'turnos_hoy.php';";
        echo "</script>";
    
    }else{
        $mensaje = true;
        $output.="Error al registrar la ausenciao";
    }
}

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


   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
                <h4 class="text-center"><img src="../images/hoy.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

                    <h4 class="text-center bg-info">Turnos Exámenes HOY</h4>
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
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>DOCUMENTO</th>
                                    <th>FECHA EXAMEN</th>
                                    <th>HORA EXAMEN</th>
                                    <th>TIPO EXAMEN</th>
                                    <th>AUSENTE</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    while ($row = mysqli_fetch_assoc($ejecuto)) {
                                       
                                ?>
                                
                                <tr class="odd gradeX">
                                
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['apellido']; ?></td>
                                    <td class="center"><?php echo $row['documento'];?></td>
                                    <td class="center"><?php echo fecha_mysql_normal($row['fecha_examen']);?></td>
                                    <td class="center"><?php echo $row['hora_examen'];?></td>
                                    <td class="center"><?php echo $row['nombre_tipo_examen'];?></td>
                                    <td>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                    <?php if($row['resultado'] != "")
                                    {?>
                                        <input type="submit" name="btn_ausente" value="AUSENTE" class="btn btn-table" disabled="disabled">
                                    <?php }
                                    else{?>
                                        <input type="hidden" name="txt_id_examen" value="<?php echo $row['id_examen']; ?>" />
                                        <input type="submit" name="btn_ausente" value="AUSENTE" class="btn btn-table" onclick="return confirm('¿Desea registrar la AUSENCIA?');">
                                   <?php }?>

                                    </form>
                                    </td>
                                    
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
