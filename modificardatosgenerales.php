<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];


$stmt = $user_home->runQuery("UPDATE tbl_users SET nombre = '$nombre', apellido = '$apellido', user_email = '$email', telefono = '$telefono'  WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$user_home->redirect('datosgenerales.php');
?>