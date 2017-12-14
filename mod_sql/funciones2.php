<?php 


/////////////////// AUDITORIA ///////////////////

function auditar($id_usuario,$operacion) {
	
	$db = Conexion();

	$query="insert into tup_auditorias (fk_id_usuario,query) values ('$id_usuario',\"$operacion\")";
	
	$auditado = mysqli_query($db,$query);

	mysqli_close($db);

	return $auditado;

}



//////////////////BUSCO PERSONA CON PROFESION REPETIDA////////////////////

function persona_profesion_repetida($persona_identificador, $profesion) {
	
	$db = Conexion();
	$sql = "SELECT * FROM `personas_profesiones` WHERE fk_id_persona = '$persona_identificador' AND fk_id_profesion = '$profesion' ";
	$duplicado = mysqli_query($db,$sql);
	$contador = mysqli_num_rows($duplicado);
	
	return $contador;
	
}

function buscar_profesiones_persona($persona_identificador) {
	
	$db = Conexion();
	$sql = "SELECT `personas_profesiones`.`fecha_inicio_actividad`,
			`personas_profesiones`.`chofer`,
			`personas_profesiones`.`embarcacion`,
			`personas_profesiones`.`observaciones`,
			`personas_profesiones`.`nombre_perro` , 
			`profesiones`.`nombre_profesion`,
			`personas_profesiones`.`fk_id_profesion` 
			FROM `personas_profesiones` 
			INNER JOIN `profesiones`
			ON `personas_profesiones`.`fk_id_profesion`=`profesiones`.`id_profesion`
			WHERE `personas_profesiones`.`fk_id_persona` = '$persona_identificador'";
	$profesiones = mysqli_query($db,$sql);
	
	return $profesiones;
	
}

function buscar_profesion_persona($persona_identificador, $fk_id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT `personas_profesiones`.`fecha_inicio_actividad`,
			`personas_profesiones`.`chofer`,
			`personas_profesiones`.`embarcacion`,
			`personas_profesiones`.`observaciones`,
			`personas_profesiones`.`nombre_perro` , 
			`profesiones`.`nombre_profesion`,
			`personas_profesiones`.`fk_id_profesion` 
			FROM `personas_profesiones` 
			INNER JOIN `profesiones`
			ON `personas_profesiones`.`fk_id_profesion`=`profesiones`.`id_profesion`
			WHERE `personas_profesiones`.`fk_id_persona` = '$persona_identificador'
			AND `personas_profesiones`.`fk_id_profesion` = '$fk_id_profesion'";

	$profesion = mysqli_query($db,$sql);
	
	return $profesion;
	
}

function eliminar_profesion($id_profesion, $id_persona, $id_usuario)
{
	$db = Conexion();

	$canones = buscar_canones_profesion($id_persona, $id_profesion);
	$examenes = buscar_examenes_persona_profesion($id_persona, $id_profesion);

	$canon_tiene = mysqli_fetch_assoc($canones);
	$examen_tiene = mysqli_fetch_assoc($examenes);

	if(!$canon_tiene && !$examen_tiene)
	{
		$sql_empresas = "DELETE FROM `tup_empresas_profesionales` WHERE `fk_id_persona` = '$id_persona'
				AND `fk_id_profesional` = '$id_profesion'";

		$eliminada_empresas = mysqli_query($db,$sql_empresas);

		if($eliminada_empresas)
		{

			$sql_lugares = "DELETE FROM `tup_lugares_profesionales` WHERE `fk_id_persona` = '$id_persona'
				AND `fk_id_profesion` = '$id_profesion'";

			$eliminada_lugares = mysqli_query($db,$sql_lugares);

			if($eliminada_lugares)
			{

				$sql_profesion = "DELETE FROM `personas_profesiones` 
				WHERE `fk_id_persona` = '$id_persona'
				AND `fk_id_profesion` = '$id_profesion'";

		
				$eliminada_profesion = mysqli_query($db,$sql_profesion);

				if($eliminada_profesion){
					auditar($id_usuario, $sql_profesion);
				}
		
				mysqli_close($db);
				
				return $eliminada_profesion;

			}else{
				mysqli_close($db);
				return false;
			}
		}else{
			mysqli_close($db);
			return false;
		}	
		
	}else{
		mysqli_close($db);
		return false;
	}

}

function buscar_habilitaciones_persona($persona_identificador) {
	
	$db = Conexion();
	$sql = "SELECT `tup_habilitaciones`.*, `profesiones`.nombre_profesion
	FROM `tup_habilitaciones` 
	INNER JOIN `profesiones`
	ON `profesiones`.`id_profesion`=`tup_habilitaciones`.`fk_id_profesion`
	WHERE `tup_habilitaciones`.`fk_id_persona` = '$persona_identificador'";
	$habilitaciones = mysqli_query($db,$sql);
	
	return $habilitaciones;
	
}

function buscar_habilitacion_profesion($persona_identificador, $id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT `tup_habilitaciones`.*, `profesiones`.nombre_profesion
	FROM `tup_habilitaciones` 
	INNER JOIN `profesiones`
	ON `profesiones`.`id_profesion`=`tup_habilitaciones`.`fk_id_profesion`
	WHERE `tup_habilitaciones`.`fk_id_persona` = '$persona_identificador'
	AND `tup_habilitaciones`.`fk_id_profesion` = '$id_profesion'";
	$habilitacion = mysqli_query($db,$sql);
	
	return $habilitacion;
	
}

function buscar_examenes_persona($persona_identificador) {
	
	$db = Conexion();
	$sql = "SELECT `tup_examenes`.*, `tipos_examenes`.`nombre_tipo_examen` 
	FROM `tup_examenes` 
	INNER JOIN `tipos_examenes`
	ON `tup_examenes`.`tipo_examen` = `tipos_examenes`.`id_tipo_examen`
	WHERE `tup_examenes`.`fk_id_persona`='$persona_identificador'";
	
	$examenes = mysqli_query($db,$sql);
	
	return $examenes;
	
}

function buscar_examenes_persona_profesion($persona_identificador, $id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT `tup_examenes`.*, `tipos_examenes`.`nombre_tipo_examen` 
	FROM `tup_examenes` 
	INNER JOIN `tipos_examenes`
	ON `tup_examenes`.`tipo_examen` = `tipos_examenes`.`id_tipo_examen`
	WHERE `tup_examenes`.`fk_id_persona`='$persona_identificador'
	AND `tup_examenes`.`fk_id_profesion`='$id_profesion'";
	
	$examenes = mysqli_query($db,$sql);
	
	return $examenes;
	
}

function buscar_examen($id_examen) {
	
	$db = Conexion();
	$sql = "SELECT * FROM `tup_examenes` WHERE `id_examen` = '$id_examen'";
	
	$examenes = mysqli_query($db,$sql);
	
	return $examenes;
	
}

function buscar_canones_profesion($persona_identificador, $id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT `canones`.*, `profesiones`.nombre_profesion,`tipo_pago`.`nombre_tipo_pago`
	FROM `canones` 
	INNER JOIN `profesiones`
	ON `profesiones`.`id_profesion`=`canones`.`fk_id_profesion`
    INNER JOIN `tipo_pago`
    ON `tipo_pago`.`id_tipo_pago`=`canones`.`fk_tipo_pago`
	WHERE `canones`.`fk_id_persona` = '$persona_identificador'
	AND  `canones`.`fk_id_profesion` = '$id_profesion'";
	$canones = mysqli_query($db,$sql);
	
	return $canones;
	
}

function buscar_canones_persona($persona_identificador) {
	
	$db = Conexion();
	$sql = "SELECT `canones`.*, `profesiones`.nombre_profesion,`tipo_pago`.`nombre_tipo_pago`
	FROM `canones` 
	INNER JOIN `profesiones`
	ON `profesiones`.`id_profesion`=`canones`.`fk_id_profesion`
    INNER JOIN `tipo_pago`
    ON `tipo_pago`.`id_tipo_pago`=`canones`.`fk_tipo_pago`
	WHERE `canones`.`fk_id_persona` = '$persona_identificador'";
	$canones = mysqli_query($db,$sql);
	
	return $canones;
	
}


function buscar_habilitacion($id_habilitacion) {
	
	$db = Conexion();
	$sql = "SELECT `tup_habilitaciones`.*, `profesiones`.nombre_profesion
	FROM `tup_habilitaciones` 
	INNER JOIN `profesiones`
	ON `profesiones`.`id_profesion`=`tup_habilitaciones`.`fk_id_profesion`
	WHERE `tup_habilitaciones`.`id_habilitacion` = '$id_habilitacion'";
	$habilitacion = mysqli_query($db,$sql);
	
	return $habilitacion;
	
}

function buscar_lugares() {
	
	$db = Conexion();
	$sql = "SELECT * FROM tup_lugares_trabajo ORDER BY nombre_lugar ASC";
	
	$lugares = mysqli_query($db,$sql);
	
	mysqli_close($db);

	return $lugares;
	
}

function buscar_lugares_persona_profesion($fk_id_persona, $fk_id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT * FROM `tup_lugares_profesionales` 
			INNER JOIN `tup_lugares_trabajo`
			ON `tup_lugares_profesionales`.`fk_id_lugar` = `tup_lugares_trabajo`.`id_lugar`
			WHERE `tup_lugares_profesionales`.`fk_id_persona` = '$fk_id_persona' AND `tup_lugares_profesionales`.`fk_id_profesion`= '$fk_id_profesion' ORDER BY `tup_lugares_trabajo`.`nombre_lugar` ASC";
	
	$lugares = mysqli_query($db,$sql);
	
	mysqli_close($db);

	return $lugares;
	
}

function buscar_idiomas() {
	
	$db = Conexion();
	$sql = "SELECT * FROM tup_idiomas ORDER BY descripcion_idioma ASC";
	
	$idiomas = mysqli_query($db,$sql);

	mysqli_close($db);
	
	return $idiomas;
	
}

function buscar_idiomas_persona($fk_id_persona) {
	

	$db = Conexion();
	$sql = "SELECT `tup_idiomas`.`id_idioma`, `tup_idiomas`.`descripcion_idioma` FROM `tup_idiomas_personas` 
			INNER JOIN `tup_idiomas`
			ON `tup_idiomas_personas`.`fk_id_idioma` = `tup_idiomas`.`id_idioma`
			WHERE `tup_idiomas_personas`.`fk_id_persona` = '$fk_id_persona' ORDER BY `tup_idiomas`.`descripcion_idioma` ASC";

	$idiomas_persona = mysqli_query($db,$sql);
	
	mysqli_close($db);

	return $idiomas_persona;
	
}

function buscar_actividades() {
	
	$db = Conexion();
	$sql = "SELECT * FROM tup_actividades_aventura ORDER BY descripcion_actividad ASC";
	
	$actividades = mysqli_query($db,$sql);

	mysqli_close($db);
	
	return $actividades;
	
}

function buscar_actividades_persona_profesion($fk_id_persona, $fk_id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT * FROM `tup_actividades_profesional` 
			INNER JOIN `tup_actividades_aventura`
			ON `tup_actividades_profesional`.`fk_id_actividad` = `tup_actividades_aventura`.`id_actividad`
			WHERE `tup_actividades_profesional`.`fk_id_persona` = '$fk_id_persona' AND `tup_actividades_profesional`.`fk_id_profesion`= '$fk_id_profesion' ORDER BY `tup_actividades_aventura`.`descripcion_actividad` ASC";
	
	$actividades = mysqli_query($db,$sql);
	
	mysqli_close($db);

	return $actividades;
	
}

function buscar_empresas() {
	
	$db = Conexion();
	$sql = "SELECT * FROM tup_empresas ORDER BY nombre_empresa ASC";
	
	$empresas = mysqli_query($db,$sql);

	mysqli_close($db);
	
	return $empresas;
	
}

function buscar_empresa($id_empresa) {
	
	$db = Conexion();
	$sql = "SELECT * FROM tup_empresas WHERE id_empresa = '$id_empresa'";
	
	$empresas = mysqli_query($db,$sql);

	mysqli_close($db);
	
	return $empresas;
	
}

function buscar_empresas_profesional($fk_id_persona, $fk_id_profesion) {
	
	$db = Conexion();
	$sql = "SELECT * FROM `tup_empresas` 
			INNER JOIN `tup_empresas_profesionales`
			ON `tup_empresas`.`id_empresa` = `tup_empresas_profesionales`.`fk_id_empresa`
			WHERE `tup_empresas_profesionales`.`fk_id_persona` ='$fk_id_persona'
			AND  `tup_empresas_profesionales`.`fk_id_profesional` ='$fk_id_profesion'";
	
	$empresas = mysqli_query($db,$sql);

	mysqli_close($db);
	
	return $empresas;
	
}
// --------------------- Funciones Utiles --------------------------

function existe_idioma($array, $keySearch)
{
	while ($row = mysqli_fetch_assoc($array))
	{
		if($row['id_idioma'] == $keySearch)
		{
			echo ' id_idioma-> '.$row['id_idioma'] ;
			return true;
		}
	}

    return false;
}




?>