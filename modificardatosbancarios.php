<?php
require_once 'class.user.php';
session_start();
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$bancoID = $_POST['bancoID'];
$titular = $_POST['titular'];
$correo = $_POST['correo'];
$deno = $_POST['deno'];
$cedula = $_POST['cedula'];
$banco = $_POST['banco'];
$tipobanco = $_POST['tipobanco'];
$nrocuenta = $_POST['nrocuenta'];


  $stmt = $user_home->runQuery("UPDATE banco SET nombre='$titular', user_email='$correo', banco = '$banco', bancotipo = '$tipobanco', nrocuenta = '$nrocuenta', denominacion = '$deno', cedula = '$cedula' WHERE bancoID=:bancoID");
  $stmt->execute(array(":bancoID"=>$bancoID));
  $user_home->redirect('datosbancarios.php');
?>