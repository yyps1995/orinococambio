<?php
session_start();
require_once 'class.user.admin.php';
$admin = new ADMIN();

if(!$admin->is_logged_in())
{
	$admin->redirect('admin/login-admin.php');
}

if($admin->is_logged_in()!="")
{
	$admin->logout();	
	$admin->redirect('admin/login-admin.php');
}
?>