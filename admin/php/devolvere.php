<?php
include("dbconfig.php");
$fin=$_POST["fin"];

$estatus="En proceso";
$fecha = date('d-m-Y H:i:s');
$cambiofecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'd-m-Y' , $cambiofecha );

$cambiohora = strtotime ( '+30 minute' , strtotime ( $fecha ) ) ;
$nuevahora = date ( 'H:i:s', $cambiohora );


$modificar = mysqli_query ($mysql, "UPDATE ventas SET horapago='".$nuevahora."',estatus = '".$estatus."', pago='".$nuevafecha."' WHERE ventasID='".$fin."' ");
  
  if ($modificar == true) {
    echo "1";
}

else {
    echo "Error al modificar";
}

?>