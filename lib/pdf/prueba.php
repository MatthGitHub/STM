<?php
//--------------------------------Inicio de sesion------------------------

//--------------------------------Fin inicio de sesion------------------------

//Coneccion a la base de datos------------------------------------------------
include("../funciones.php");
require_once("class.ezpdf.php");
$link=conectarse_doscuatrotres();
//----------------------------------------------------------------------------


//Configuración de página-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('../fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuración de página-----------------


$query="
DROP TABLE IF EXISTS tmp_profesionales_guias;

create table tmp_profesionales_guias as 
SELECT HA.nro_habilitacion, PE.identificador, PE.apellido, PE.telefono, PE.email, PR.nombre_profesion tipo_guia, 
PP.chofer, PP.embarcacion, HA.fecha_hasta vigencia
FROM tup_habilitaciones HA, personas PE, personas_profesiones PP, profesiones PR
WHERE  /*HA.fk_id_persona = '' and */
HA.fk_id_persona = PE.identificador
and HA.fk_id_persona = PP.fk_id_persona
and PP.fk_id_profesion = PR.id_profesion
and PR.nombre_profesion like 'guia%'
and HA.fk_id_profesion = PR.id_profesion
order by PE.apellido, nro_habilitacion;

select TMP.*, GROUP_CONCAT(I.descripcion_idioma) as Idiomas from tmp_profesionales_guias TMP, tup_idiomas_personas IP, tup_idiomas I
where IP.fk_id_idioma = I.id_idioma
and TMP.identificador = IP.fk_id_persona 
group by TMP.identificador, TMP.nro_habilitacion;
";

$recordset=mysqli_query($link,$query);


//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mysqli_fetch_assoc($recordset)) {
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));

}

$titles = array(
	'nro_habilitacion'=>' <b>Habilitacion</b>',
	'apellido'=>' <b>Apellido</b>',
	'telefono'=>'<b>Telefono</b>',
	'email'=>'<b>email</b>',
	'tipo_guia'=>' <b>Tipo gruia</b>',
	'chofer'=>' <b>Chofer</b>',
	'embarcacion'=>' <b>Embarcacion</b>',
	'vigencia'=>' <b>Vigencia</b>',
	'Idiomas'=>' <b>Idiomas</b>',

);

$options = array(

              //  'shadeCol'=>array(0.9,0.9,0.9),

                'xOrientation'=>'center',

                'width'=>500

            );

// Fin armado de matrices-----------------------------------








//Titulo
$txttit= "Listado de Guías actualizado a ".date("d/m/Y")." ".date("H:i:s");
$pdf->ezText($txttit, 12);

//Imagen
//df->ezImage("../../images/escudobrc.gif",0,200, 'none','left');


$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>