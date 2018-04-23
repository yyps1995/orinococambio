<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$usteemit = $_POST['usteemit'];
$udiscord = $_POST['udiscord'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$banco = $_POST['banco'];
$tipobanco = $_POST['tipobanco'];
$nrocuenta = $_POST['nrocuenta'];
$cedula = $_POST['cedula'];
$telefono = $_POST['telefono'];

$stmt = $user_home->runQuery("UPDATE tbl_users SET userName = '$usteemit', udiscord = '$udiscord', nombre = '$nombre', apellido = '$apellido', banco = '$banco', bancotipo = '$tipobanco', nrocuenta = '$nrocuenta', cedula = '$cedula', telefono = '$telefono'  WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$user_home->redirect('user_datos.php');
?>