<?php
//error_reporting(0);
//--------------------------------Inicio de sesion------------------------
//--------------------------------Fin inicio de sesion------------------------
include("../../../inc/sql.php");


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/turismo_profesionales_logo.png" sizes="16x16">
    <title>Sistema Turismo MSCB</title>

    <!-- Bootstrap -->
		<script src="../js/jquery-1.12.3.js"></script>
		<link href="../css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <br>
	<div class="container">
		<!-- Static navbar -->
		<?php include("../inc/menu.php"); ?>
		<!-- Main component for a primary marketing message or call to action -->
		  <div class="jumbotron">
  	        <h2><img src="../images/turismo_profesionales_logo.png" alt="Municipalidad Bariloche" align="middle" style="margin:0px 0px 0px 0px" height="64" width="64"> Sistema Turismo Profesionales </h2>
			<div class="row">
				<div class="col-lg-5">
					<p>
						<h4 class="text-center bg-info"> Cargas </h4>
					   <a class="btn btn-lg btn-direct" href="../mod_profesionales/personas.php" role="button"><img src="../images/nueva_profesion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Personas - Alta profesión </a>

					   <a class="btn btn-lg btn-direct" href="../mod_examenes/profesionales_examen.php" role="button"><img src="../images/wall-calendar.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Registrar Turno Exámen </a>

					   <a class="btn btn-lg btn-direct" href="../mod_habilitaciones/hab_profesionales.php" role="button"><img src="../images/nueva_habilitacion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Nueva Habilitación </a>

					   <a class="btn btn-lg btn-direct" href="../mod_canones/frm_canon.php" role="button"><img src="../images/nuevo_canon.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Cargar Canon </a>
					</p>
				</div>
				<div class="col-lg-5">
					<p>
						<h4 class="text-center bg-info"> Búsquedas </h4>
				   	   <a class="btn btn-lg btn-direct" href="../mod_profesionales/profesionales.php" role="button"><img src="../images/buscar_profesionales.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Buscar Profesional</a>

				   	   <a class="btn btn-lg btn-direct" href="../mod_examenes/examenes.php" role="button"><img src="../images/buscar_examen.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Buscar Exámen</a>

				   	    <a class="btn btn-lg btn-direct" href="../mod_habilitaciones/habilitaciones.php" role="button"><img src="../images/buscar_habilitacion.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Buscar Habilitación</a>

				   	    <a class="btn btn-lg btn-direct" href="../mod_canones/canones.php" role="button"><img src="../images/buscar_canon.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="32" width="32">	Buscar Canon</a>
					
					</p>

				</div>
			</div>
		  </div> <!-- /jumbotron -->

		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>

	</div> <!-- /container -->
  </body>
</html>
