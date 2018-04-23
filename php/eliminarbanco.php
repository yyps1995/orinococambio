<?php
session_start();
require_once '../class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$id= $_POST['id'];


$eliminar= mysqli_query($mysql,"DELETE FROM banco WHERE bancoID='".htmlentities($id)."' ");

if($eliminar== true){
	echo "1";
}

else{
	echo "0";
}

?>
