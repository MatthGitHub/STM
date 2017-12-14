<?php include('sesion.php');?>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js"></script>
<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">

<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
	  <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand"><p><img src="../images/escudobrc.gif" alt="Municipalidad Bariloche" align="middle" style="margin:0px 0px 0px 20px"></p></a>
	  </div>
	  <div class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
			<li><a href="../inc/menu_principal.php"><i class="fa fa-home fa-fw"></i>Inicio</a></li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-id-badge fa-fw"></i> Profesionales<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="../mod_profesionales/personas.php">Personas - Alta Profesión</a></li>
						<li><a href="../mod_profesionales/profesionales.php">Buscar Profesional</a></li>
					</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text-o fa-fw"></i> Exámenes<span class="caret"></span></a>
					  <ul class="dropdown-menu">

						  <li><a href="../mod_examenes/profesionales_examen.php">Registrar Turno Exámen</a></li>
						  <li><a href="../mod_examenes/examenes.php">Buscar Exámen</a></li>
						  <li><a href="../mod_examenes/turnos_hoy.php">Ver Turnos para HOY</a></li>

						</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-id-card-o fa-fw"></i> Habilitaciones<span class="caret"></span></a>
					  <ul class="dropdown-menu">

						  <li><a href="../mod_habilitaciones/hab_profesionales.php">Nueva Habilitación</a></li>
						  <li><a href="../mod_habilitaciones/habilitaciones.php">Buscar Habilitación</a></li>

						</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-usd fa-fw"></i> Canones<span class="caret"></span></a>
					  <ul class="dropdown-menu">

						  <li><a href="../mod_canones/can_profesionales.php">Cargar Canon</a></li>
						  <li><a href="../mod_canones/canones.php">Buscar Canon</a></li>

						</ul>
				  </li>

				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-database fa-fw"></i> Administración<span class="caret"></span></a>
					<ul class="dropdown-menu">
                   		<li><a href="../mod_administracion/empresas.php">Nueva Empresa Embarcación</a></li>
                        <li><a href="../mod_administracion/pagos.php">Nuevo Tipo Pago</a></li>
                    	<li><a href="../mod_administracion/profesiones.php">Nuevo Tipo de Profesión</a></li>
                        <li><a href="../mod_administracion/examenes.php">Nuevo Tipo de Exámen</a></li>
						<li><a href="../mod_administracion/lugares_trabajos.php">Nuevo Lugar de Trabajo</a></li>
					  </ul>
				</li>

				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-database fa-fw"></i> Usuarios<span class="caret"></span></a>
					<ul class="dropdown-menu">
                   		<li><a href="../mod_usuario/nuevo_usuario.php">Nuevo usuario</a></li>
                      <li><a href="../mod_usuario/usuarios.php">Listar usuarios</a></li>
					  </ul>
				</li>

		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="../mod_usuario/frm_cambio_clave.php">Cambiar clave</a></li>
			<li><a><i class="fa fa-user-circle-o fa-fw"></i> <?php echo $_SESSION['nombre']; ?> </a></li>
			<li><a><i class="fa fa-calendar-o fa-fw"></i>
			<?php
			// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
			date_default_timezone_set('UTC');
			//Imprimimos la fecha actual dandole un formato
			echo date("d / m / Y");
			?></a></li>
			<li><a href="../index.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
		  </ul>
	  </div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>
