<?php
session_start();
require_once 'class.user.admin.php';
$admin_login = new ADMIN();

if($admin_login->is_logged_in()!="")
{
  $admin_login->redirect('../admin/home-admin.php');
}

if(isset($_POST['btn-login-admin']))
{
  $useradmin = trim($_POST['useradmin']);
  $passadmin = trim($_POST['passadmin']);
  
  if($admin_login->login($useradmin,$passadmin))
  {
    $admin_login->redirect('../admin/home-admin.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">
<style type="text/css">
body{
  background-color: #f2f0ef;
}

      .botoniniciar{
        border-radius: 7px;
        background-color: #d35400;
        font-size: 17px;
        font-weight: bolder;
        color: #fff;
        font-family: tahoma;
        width: 100%;
        padding: 3% 0% 3% 0%;
      }

.col-center{
  float: none;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

#manipular{
 margin-top:  20% !important;
 border-radius: 15px;
 box-shadow:  0px 0px 10px rgb(196, 195, 194);
}
#img1{
  margin-top: -2%;
  margin-left: -15%;
  width: 10%;
}
#img2{
  margin-top: -2%;
  margin-left: 1%;
  width: 30%;
}
#head{
  border-bottom: solid 1px rgba(196, 195, 194, 0.5);
  width: 111.5%;
  margin-left: -6%;
  padding-bottom: 3%;
}
#bajar{
  margin-top: 3%;
  text-align: center;
}

</style>
</head>

<body>
  <div class="container">
    <div class="card card-login mx-auto mt-5" id="manipular">
      <div class="card-body">
 <form class="form-signin" method="post">
            <?php
                  if(isset($_GET['error']))
              {
                ?>
                      <div class='alert alert-success'>
                  <button class='close' data-dismiss='alert'>&times;</button>
                  <strong>Datos equivocados!!</strong> 
                </div>
                      <?php
              }
              ?>
            <center id="head">
              <img src="../img/COLIBRI P.png" id="img1">
            <img src="../img/orinoco.png" id="img2">
              
            </center>
            
        <h2 class="form-signin-heading" id="bajar">Iniciar Sesion</h2><hr />
           <div class="form-group">
              <input type="text" class="form-control" name="useradmin" placeholder="Usuario">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="exampleInputPassword1" name="passadmin" placeholder="Contraseña">
            </div>
            <center>
               <button class="btn btn-large botoniniciar" type="submit" name="btn-login-admin">Entrar</button><br><br>
            </center>
          </form>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
