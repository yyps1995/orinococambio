<?php
session_start();
require_once 'class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/login-admin.php');
}

$stmt = $admin_home->runQuery("SELECT * FROM admin WHERE adminID=:adminID");
$stmt->execute(array(":adminID"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$fin=$_POST["fin"];

$estatus="Cancelado";
$fecha = date('d-m-Y H:i:s');
$cambiofecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'd-m-Y' , $cambiofecha );

$cambiohora = strtotime ( '-4hour' , strtotime ( $fecha ) ) ;
$nuevahora = date ( 'H:i:s', $cambiohora );


$modificar = mysqli_query ($mysql, "UPDATE ventas SET horapago='".$nuevahora."',estatus = '".$estatus."', pago='".$nuevafecha."' WHERE ventasID='".$fin."' ");
  
  if ($modificar == true) {
    echo "1";
    $admin_home->redirect('transacciones2.php');
}

else {
    echo "<p class='msj'>Error</p>";
}

?>