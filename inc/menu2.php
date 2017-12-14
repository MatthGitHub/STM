
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
						<li><a href="../mod_profesionales/personas.php">Nuevo Profesional</a></li>
						<li><a href="../mod_personas/frm_buscar_propietario.php">Buscar Profesional</a></li>
					</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text-o fa-fw"></i> Exámenes<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						
						  <li><a href="../mod_animales/frm_alta_animal.php">Registrar Turno Exámen</a></li>
						  <li><a href="../mod_animales/frm_buscar_ejemplar.php">Buscar Exámen</a></li>
							
						</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-id-card-o fa-fw"></i> Habilitaciones<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						
						  <li><a href="../mod_animales/frm_alta_animal.php">Nueva Habilitación</a></li>
						  <li><a href="../mod_animales/frm_buscar_ejemplar.php">Buscar Habilitación</a></li>
							
						</ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-usd fa-fw"></i> Canones<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						
						  <li><a href="../mod_animales/frm_alta_animal.php">Cargar Canon</a></li>
						  <li><a href="../mod_animales/frm_buscar_ejemplar.php">Buscar Canon</a></li>
							
						</ul>
				  </li>
				  
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-database fa-fw"></i> Administración<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../mod_administracion/nuevo_tipo_pago.php">Nuevo Tipo Pago</a></li>
						<li><a href="../mod_administracion/nueva_profesion.php">Nueva Profesion</a></li>
						<li><a href="../mod_administracion/nuevo_lugar_trabajo.php">Nuevo Lugar de Trabajo</a></li>
					  </ul>
				</li>

		  </ul>
		  <ul class="nav navbar-nav navbar-right">

			<li><a><i class="fa fa-user-circle-o fa-fw"></i> <?php echo $_SESSION['usuario']; ?> </a></li>
			<li><a><i class="fa fa-calendar-o fa-fw"></i>
			<?php
			// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
			date_default_timezone_set('UTC');
			//Imprimimos la fecha actual dandole un formato
			echo date("d / m / Y");
			?></a></li>
			<li><a href="../../../inc/menu_principal.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
		  </ul>
	  </div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>
