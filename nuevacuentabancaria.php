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
$apellido = $_POST['apellido'];
$user_email = $_POST['user_email'];
$cedula = $_POST['cedula'];
$banco = $_POST['banco'];
$tipobanco = $_POST['tipobanco'];
$nrocuenta = $_POST['nrocuenta'];

$stmt = $user_home->runQuery("INSERT INTO banco (userID,nombre,apellido,user_email,cedula,banco,bancotipo,nrocuenta) VALUES('$userID','$nombre','$apellido','$user_email','$cedula','$banco','$tipobanco','$nrocuenta')");
$stmt->execute(array(":uid"=>$userID,":nombre"=>$nombre,":apellido"=>$apellido,":user_email"=>$user_email,":cedula"=>$cedula,":banco"=>$banco,":tipobanco"=>$tipobanco,":nrocuenta"=>$nrocuenta));
$user_home->redirect('datosbancarios.php');

?>