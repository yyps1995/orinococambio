<?php
session_start();
require_once '../class.user.admin.php';

$memo=$_POST["memo"];

$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/home-admin.php');
}



try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE memo=:uid");
  $stmt->execute(array(":uid"=>$memo));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurri贸 un error<br>";
    echo $ex->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Admin Orinoco</title>
  <!-- Bootstrap core CSS-->
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin.css" rel="stylesheet">
  <link href="../../assets/admin12.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/animate.min.css">
  <link rel="shortcut icon" href="../../img/colibri.ico" type="image/x-icon">
  <link rel="icon" href="../img/colibri.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/lib/datatable/dataTables.bootstrap.min.css">
  <script type="text/javascript">
    function pregunta(){ 
    if (confirm('¿Estas seguro de eliminar esta transaccion?')){ 
       document.eliminar.submit() 
    } 
} 
  </script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <br>
          <a href="../../index.php"><img class="img-responsive colibri" src="../../img/COLIBRI P.png"></a><br>
          <a href=""><img class="img-responsive orinoco" src="../../img/orinoco.png"></a>
          <a class="nav-link" href="admin/home-admin.php">
            <br>
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Panel Principal</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="transacciones2.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Transacciones pendientes</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="#" id="trealizadas">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Transacciones realizadas</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Realizadas">
          <a class="nav-link" href="#" id="teliminadas">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Transacciones eliminadas</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="#" id="tasas">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Tasas</span>
          </a>
        </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuarios">
          <a class="nav-link" href="#" id="veru">
            <i class="fa fa-fw fa-group"></i>
            <span class="nav-link-text">Usuarios</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Salir</a>
        </li>
      </ul>
    </div>
  </nav>
<?php
    foreach ($rows as $row) {
               

                try {
                  $stmt = $admin_home->runQuery("SELECT * FROM banco WHERE bancoID=:bank");
                  $stmt->execute(array(":bank"=>$row["banco"]));
                  $ro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch(PDOException $exe) {
                    echo "Ocurri贸 un error<br>";
                    echo $exe->getMessage();
                    exit;
                }
                foreach ($ro as $roll) {

                   try {
                            $stmt = $admin_home->runQuery("SELECT * FROM tbl_users WHERE userID=:user");
                            $stmt->execute(array(":user"=>$row["usuario"]));
                            $rowan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch(PDOException $exe) {
                              echo "Ocurri贸 un error<br>";
                              echo $exe->getMessage();
                              exit;
                          }

                           foreach ($rowan as $roly) {

  echo'
     
    <div id="area">
      <div class="content-wrapper">
        <div class="contanier" >
          <div class="row">

             <div class="col-md-12 col-lg-8 col-center">

                <div class="card text-center">
                  <div class="card-header">
                  <h2>
                    '.$roly["nombre"].'&nbsp;'.$roly["apellido"].'</h2>&nbsp;<br><h3>('.$roly["telefono"].')</h3>
                  </h2>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-lg-12 col-center"><h5><br>Tasa: '.$row["tasa"].'<br><br></h5></div>
                        <div class="col-lg-6"><h5>Fecha: '.$row["solicitud"].'</h5></div>
                        <div class="col-lg-6"><h5>Banco: '.$roll["banco"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Hora: '.$row["horasolicitud"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Tipo de cuenta: '.$roll["bancotipo"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Memo: '.$row["memo"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Numero de cuenta: '.$roll["nrocuenta"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Estatus: '.$row["estatus"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Nombre del titular: '.$roll["nombre"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Recibido: '.$row["cantidad"].'&nbsp;'.$row["moneda"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Cedula: '.$roll["denominacion"].$roll["cedula"].'</h5></div>
                        <div class="col-lg-6"><h5><br>E-mail: '.$roll["user_email"].'</h5></div>
                        <div class="col-lg-6"><h5><br>Steemit: @'.$row["steemuser"].'</h5></div>
                     </div>
                  </div>
                  <div class="card-footer text-muted">
                  <div class="col-lg-6 col-center"><h3><br><strong>Transferir:'.$row["bolivares"].'&nbsp;'.$row["cambio"].'</strong></h3></div>
                  <br>
                  <div class="col-lg-6 col-center">
                 <form action="finalizar.php" method="post">
                  <div >
                      <h4 class="al">N. Ref:</h4>
                      <input type="text" class="al middle form-control" name="ref" required><br>
                    </div> 
                    <div>  
                      <h4 class="al">Banco:</h4>
                      <select name="banco" class="al middle form-control" required>
                        <option value="Banco de Venezuela">Venezuela</option>
                        <option value="Banco Provincial">Provincial</option>
                        <option value="Banco Banesco">Banesco</option>
                        <option value="Banco Mercantil">Mercantil</option>
                      </select>
                    </div> 
                    <br>
                  </div>
                  <div class="row">
                     <div class="col-lg-4">
                         <input type="hidden" name="fin" value=" '.$row["ventasID"].'">
                          <button type="submit" class="btn btn-success" class="al">Finalizar</button>
                            </form>
                     </div>
                     <div class="col-lg-4">
                       <form action="transacciones2.php"><button type="submit" class="btn btn-primary" id="bancoveri">Volver</button></form>
                     </div> 
                     <div class="col-lg-4">
                        <form name="eliminar" action="cancelar.php" method="post"><input type="hidden" name="fin" value=" '.$row["ventasID"].'">
                        <input type=button onclick="pregunta()"  value="Eliminar" class="btn btn-danger"> 
                        </form>
                     </div>                  
                    </div>                   
                  </div>
                  
                  </div>
                </div>
                        
              </div>
          </div>
        </div>
      </div>
    </div>

';
?>

   <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Orinoco 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Listo para irte?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Presiona salir si quieres cerrar la sesion.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="admin/logout-admin.php">Salir</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin.min.js"></script>>
    <script type="text/javascript" src="../../js/jquery.js"></script>
        <script src="../../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    
    <script src="../../assets/js/lib/data-table/datatables-init.js"></script>
    <!-- Custom scripts for this page-->
    <!-- Toggle between fixed and static navbar-->
    <script>

    $('#toggleNavPosition').click(function() {
      $('body').toggleClass('fixed-nav');
      $('nav').toggleClass('fixed-top static-top');
    });

    </script>
    <!-- Toggle between dark and light navbar-->
    <script>
    $('#toggleNavColor').click(function() {
      $('nav').toggleClass('navbar-dark navbar-light');
      $('nav').toggleClass('bg-dark bg-light');
      $('body').toggleClass('bg-dark bg-light');
    });

    </script>
  </div>
</body>

</html>
    <?php

      }
                    }
                        
                  }

    ?>




