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
$deno = $_POST['deno'];
$cedula = $_POST['cedula'];
$banco = $_POST['banco'];
$tipobanco = $_POST['tipobanco'];
$nrocuenta = $_POST['nrocuenta'];


if($userID=="" || $userID < 1){

	echo "0";
}
else{
	$stmt = $user_home->runQuery("INSERT INTO banco (userID,nombre,user_email,banco,bancotipo,nrocuenta,denominacion,cedula) VALUES('$userID','$nombre','$user_email','$banco','$tipobanco','$nrocuenta','$deno','$cedula')");
	$stmt->execute(array(":uid"=>$userID,":nombre"=>$nombre,":user_email"=>$user_email,":cedula"=>$cedula,":banco"=>$banco,":tipobanco"=>$tipobanco,":nrocuenta"=>$nrocuenta));
	
	echo"1"	;
}
?>