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
	<!--script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script-->

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

    <script type="text/javascript">

		function set_focus()
		{
			document.getElementById("txt_nombre").focus();
			alert("focus propietario nombre");
			return (false);
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

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Fecha Habilitación* </span>
                                <div class='input-group date' id='divMiCalendarioHabilitacion'>
                                    <input name="txt_fecha_habilitacion" type='text' id="txt_fecha_habilitacion" class="form-control" value="<?php echo $fecha_habilitacion;?>"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-times-o fa-fw"></i> Fecha Vencimiento* </span>
                                <div class='input-group date' id='divMiCalendarioVencimiento'>
                                    <input name="txt_fecha_vencimiento" type='text' id="txt_fecha_vencimiento" class="form-control" value="<?php echo $fecha_vencimiento;?>"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                        </div>

							                   
							         
<script type="text/javascript">

$('#divMiCalendarioHabilitacion').datetimepicker({
      format: 'DD-MM-YYYY'
    });

$('#divMiCalendarioVencimiento').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>

	</body>
</html>