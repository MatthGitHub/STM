<?php
//--------------------------------Inicio de sesion------------------------

//--------------------------------Fin inicio de sesion------------------------

include("../../lib/funciones.php");
require_once("class.ezpdf.php");


//Configuraci�n de p�gina-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('../fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuraci�n de p�gina-----------------




$txttit= "Hola Mundo ";


 


$pdf->ezText($txttit, 12);

$pdf->ezImage("../../images/escudobrc.gif",0,200, 'none','left');


//$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>