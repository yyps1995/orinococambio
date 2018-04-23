<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$userID = $_POST['userID'];
$nombre = $_POST['nombre'];
$user_email = $_POST['user_email'];
$exchanger = $_POST['exchanger'];
$cuenta = $_POST['cuenta'];
$direccion_monedero = $_POST['direccion_monedero'];
$deno = "N/A";
$cedula = "N/A";


if($userID=="" || $userID < 1){

	echo "0";
}
else{
	$stmt = $user_home->runQuery("INSERT INTO banco (userID,nombre,user_email,banco,bancotipo,nrocuenta,denominacion,cedula) VALUES('$userID','$nombre','$user_email','$exchanger','$cuenta','$direccion_monedero','$deno','$cedula')");
	$stmt->execute(array(":uid"=>$userID,":nombre"=>$nombre,":user_email"=>$user_email,":banco"=>$exchanger,":tipobanco"=>$cuenta,":nrocuenta"=>$direccion_monedero,":cedula"=>$cedula));
	echo"1"	;
}
?>