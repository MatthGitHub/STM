
<?php
include '../inc/conexion.php';
include("../mod_sql/sql.php");
include('../inc/sesion.php');

$db= Conexion();
$sql = "SELECT * FROM profesiones";
$ejecuto = mysqli_query($db,$sql);
$mensaje = false;
if (isset($_POST['guardar'])) {

	$nombre=htmlentities($_POST['txt_nombre']);
	$nombre_profesion = mysqli_real_escape_string($db,$nombre);


	$query = "INSERT INTO profesiones (nombre_profesion) VALUES ('$nombre_profesion')";
	$ejecutar = mysqli_query($db,$query);

	if ($ejecuto) {

    auditar($_SESSION['id'],$query);

		header("location:profesiones.php");
	}else{
		$mensaje = true;

	}

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

		<script src="../vendor/js/jquery.min.js"></script>
		<link rel="stylesheet" href="../vendor/css/bootstrap.min.css"/>



</head>


<body>

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->

				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
					<h4 class="text-center bg-info">Cargar profesiones</h4>
						<div class="row">
							<div class="col-md-9 col-md-offset">
								<div class="form-group">
                                <?php

								if($mensaje==true) {
									echo "	<div class='alert alert-danger'>
  <strong>Error al guardar la profesión.
</div>";
								}

								?>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre profesión</span>
										<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" value="<?php echo $txt_nombre;?>" required="required" placeholder="Ingrese el nombre"/>
									</div>
								</div>
              </div>
							<div class="col-md-3 col-md-offset">

								<div class="form-group">
									<input type="submit" value="Guardar" name="guardar" class="btn btn-success col-xs-12">
								</div>
							</div>
						</div>
             <br><br>
						<div class="row">
							<div class="col-md-12 col-md-offset">
							<div id="employee_table"></div>
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>

                                        <th>EDITAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php



                                        while ($row = mysqli_fetch_assoc($ejecuto)) {



                                    ?>

                                    <tr class="odd gradeX">

                                        <td><?php echo $row['nombre_profesion']; ?></td>

                                        <td><input type="button" name="edit" value="Editar" id="<?php echo $row["id_profesion"]; ?>" class="btn btn-info btn-xs edit_data" /></td>


                                    </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
							</div>

						</div><!-- FIN ROW -->




				</form>





		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
		</div>

	</body>

	<!-- /#wrapper -->

    <!-- jQuery -->


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

</html>

<div id="dataModal" class="modal fade">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Employee Details</h4>
                </div>
                <div class="modal-body" id="detalles">
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
           </div>
      </div>
 </div>
 <div id="add_data_Modal" class="modal fade">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Actualizar Datos</h4>
                </div>
                <div class="modal-body">
                     <form method="post" id="insert_form">
                          <label>Editar profesión</label>
                          <input type="text" name="txt_nombre_actualizar" id="txt_nombre_actualizar" class="form-control" />
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
                url:"fetch_profesion.php",
                method:"POST",
                data:{employee_id:employee_id},
                dataType:"json",
                success:function(data){
                     $('#txt_nombre_actualizar').val(data.nombre_profesion);
                     $('#employee_id').val(data.id_profesion);
                     $('#insert').val("Actualizar");
                     $('#add_data_Modal').modal('show');
                }
           });
      });
      $('#insert_form').on("submit", function(event){
           event.preventDefault();
           if($('#txt_nombre_actualizar').val() == "")
           {
                alert("Ingrese el tipo");
           }
           else if($('#address').val() == '')
           {
                alert("Address is required");
           }
           else if($('#designation').val() == '')
           {
                alert("Designation is required");
           }
           else if($('#age').val() == '')
           {
                alert("Age is required");
           }
           else
           {
                $.ajax({
                     url:"actualizar_profesion.php",
                     method:"POST",
                     data:$('#insert_form').serialize(),
                     beforeSend:function(){
                          $('#insert').val("Actualizando...");
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
