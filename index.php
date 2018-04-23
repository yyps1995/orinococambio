<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();
$user_home = new USER();

if($user_login->is_logged_in()!="")
{
  $user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
  $user = trim($_POST['txtuser']);
  $upass = trim($_POST['txtupass']);
  
  if($user_login->login($user,$upass))
  {
    $user_login->redirect('home.php');
  }
}

try {
  $stmt = $user_home->runQuery("SELECT * FROM tasas ");
  $stmt->execute(array(":uid"=>1));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}

foreach ($rows as $row) {
  
  
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="assets/styles31.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" href="img/colibri.ico" type="image/x-icon">
    <link rel="icon" href="img/colibri.ico" type="image/x-icon">

    <title>Orinoco</title>


  </head>
  <body>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a href="" style="margin: 12px;" class="btn btn-large botoniniciar btnn">Inicio</a>
      </li>
      <li class="nav-item">
          
          <a data-toggle="modal" href="#myModalQuien" style="margin: 12px;" class="btn btn-large botoniniciar btnn " >¿Quienes Somos?</a>
      </li>
      <li >
          <a class="btn btn-large botoniniciar btnn" style="margin: 12px;" data-toggle="modal" href="#myModalayuda">
           ¿Cómo Funciona?</a>
        </li>
      <li class="nav-item">
                <a data-toggle="modal" href="#myModal" style="margin: 12px;" class="btn btn-large botoniniciar btnn">Iniciar sesion</a>
      </li>
      <li class="nav-item">
          <a href="signup.php" style="margin: 12px;" class="btn btn-large botoniniciar btnn">Registrarse</a>
      </li>
    </ul>
  </div>
</nav>

    <?php 
    if(isset($_GET['inactive']))
    {
      ?>
      <div class='alert alert-error' style="color:#fff;">
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Lo sentimos!</strong> Esta cuenta no esta activada, dirigite a tu email para acivarla. 
      </div>
            <?php
    }
    ?>
<!-- Modal iniciar sesion 1-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content text-center">
        <div class="modal-body">
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
        <h2 class="form-signin-heading">Iniciar Sesion</h2><hr />
           <div class="form-group">
              <input type="text" class="form-control" id="exampleInputEmail1" name="txtuser" placeholder="Correo electrónico">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="exampleInputPassword1" name="txtupass" placeholder="Contraseña">
            </div>
            <button class="btn btn-large botoniniciar" type="submit" name="btn-login">Entrar</button><br><br>
            <a href="fpass.php" style="color:#d35400;">Olvide mi contraseña</a> ó <a href="signup.php" style="color:#d35400;">Registrarse<br><br></a>
          </form>
        </div>
      </div>
    </div>
  </div>

    <div class="content-wrapper">
    <div class="container animated bounceInDown " >
    <div class="col-sm-12 col-md-12 col-lg-9 col-center">
          <a class="navbar-brand" href=""><img class="img-responsive colibri" src="img/LOGO_PRUEBA.png"></a>
          
    </div>
          <div id="area">
          <div class="contenedor1 col-center">
            

            <h3 style="color:#000000;">Calculadora </h3>
            <div id="se" >

            <div class="right">
                    <select name="de" class="btn default " onclick="mostrar(this.value);" required >
                      <option value="1" name="opc">SBD</option>
                      <option value="2" name="opc" > STEEM</option>
                    </select>
                    <select name="a" class="btn default grey" onclick="mostrar2(this.value);" required>
                      <option value="1" name="opc">Bs</option>
                      <option value="2" name="opc">BTC</option>
                      <option value="3" name="opc">ETH</option>
                    </select>
            </div>
              <div class="form-group" id="sbd" style="display:block;">
              <div class="form-group left">
                <input type="number" class="middle form-control" id="moneda1" name="moneda1" placeholder="SBD" onkeyup="calcular()" step="any" min="0" required value="1">
              </div>
              </div>

              <div class="form-group" id="steem" style="display:none;">
               <div class="form-group left">
                <input type="number" class="middle form-control" id="moneda2" name="moneda2" placeholder="STEEM" onkeyup="calcular()" step="any" min="0" >
              </div>
              </div>


              <div class="form-group" id="bsf" style="display:block;">
              <div class="form-group left">
                <input type="number" class="middle form-control" name="vef1" placeholder="Bs" onkeyup="calcular2()" step="any" min="0" value="<?php echo $row['sbdbs']; ?>"/>
              </div>
              </div>

              <div class="form-group" id="usd" style="display:none;">
              <div class="form-group left">
                <input type="number" class="middle form-control" name="vef2" placeholder="Bitcoin" value="" onkeyup="calcular2()" step="any" min="0"/>
              </div>
              </div>

              <div class="form-group" id="petro" style="display:none;">
              <div class="form-group left">
                <input type="number" class="middle form-control" name="vef3" placeholder="ETH" value="" onkeyup="calcular2()" step="any" min="0"/>
              </div>
              </div>


                <!-- Trigger the modal with a button -->
                <button style="margin: 5px;" type="submit" class="btn btn-large botoniniciar" id="myBtn4" data-toggle="modal" data-target="#myModal">Cambiar</button>


            </div><br>
                 <p><a style="color:#d35400;" id="myBtncondiciones" data-toggle="modal" href="#myModalCondiciones">Terminos y condiciones</a>
            
          </div>
        </div>
      
    </div>
    </div>
    <div class=" animated fadeInLeftBig acom">
      <a href="https://discord.gg/9A2PXF3" target="_blank"><img src="img/DISCORD.png"></a>
      <img src="img/WHATSAPP.png" title="+58 (414)4802324">
    </div>
  </div>
    <br><br>

   <!-- Modal Condiciones-->
  <div class="modal fade" id="myModalCondiciones" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content text-justify" style="padding:2% 3% 0% 3%; width: 90%;">
        <div class="modal-header col-center">
          <h4>CONDICIONES DE SERVICIO</h4>
        </div>
        <div class="modal-body col-justify">
          <p>
          Al generar una orden o servicio  con el equipo Orinoco estás de acuerdo con lo siguiente:<br><br>
          ● En Orinoco <strong>NO</strong> se cobran comisiones. <br> 
          ● Puede registrar órdenes las 24 horas del día, sin embargo, serán procesadas  el mismo día aquellas registradas desde las 7:00 am hasta las 7:00 pm. Las demas órdenes se postergarán para el día siguente.<br>
          ● Operamos directamente a través de Banesco, Provincial, Banco de Venezuela y Mercantil. Si no posee cuenta en ninguno de los anteriores, su dinero se hará efectivo al siguiente día hábil después de las 3:00 pm, de no ser así,  comuníquese inmediatamente con el equipo Orinoco a través de Discord o Whatsapp. <br>
          ● Una vez registrada una orden la tasa no varía  hasta ejecutarse. <br>
          ● Si no se ha realizado el Pago el Usuario tiene la opción de comunicarse con nosotros para cancelar la orden. <br>
          ● Si ocurre un problema en alguna plataforma bancaria se le informará al cliente sobre las distintas opciones de pago.
          </p>
        </div>
          
          <div class="modal-header col-center" style="margin-top: -3%;">
            <h4>CONDICIONES DE USO</h4>
          </div>
        <div class="modal-body col-justify">
          <p>
           <strong>Uso del Sitio Web</strong><br>
           ORINOCO asume que el usuario leyó todas las condiciones del Servicio y Seguridad una vez se inicie el proceso de cambio.<br><br>
           <strong>Política de Contraseñas y Datos</strong><br>
           El Usuario se hace responsable de tratar de forma confidencial y custodiar adecuadamente las contraseñas utilizadas en el Sitio Web, así como también, de toda la información de Cuentas Bancarias registradas.
           
          </p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal Quienes Somos-->
  <div class="modal fade" id="myModalQuien" role="dialog" >
    <div class="modal-dialog modal-lg" >
      <!-- Modal content-->
      <div style="padding:2% 3% 0% 3%; width: 90%;">
       <div id="contenedorsomos" style="width: 130%;margin-left:-10%;"><br>
        <div id="cont">
          <img src="img/COLIBRI P.png" id="colibri" style="width:70%;margin-left:-10%;">
        <h2>¿Quienes Somos?</h2>
        <p class="quien">

            Somos un equipo  que desde sus inicios se ha dedicado siempre a transformar los Frutos de la Creatividad de los Venezolanos y el resto de la comunidad en Su Realidad, apoyándolos a convertir sus SBD ó STEEM a su Moneda Local, BTC y ETH.
        </p>
        <h3>¿Qué Cambiamos?</h3>
        <p class="quien">
            Realizamos Operaciones de Compra de SBD y STEEM a Bolívares, BTC y ETH. Sin embargo, si desea realizar cualquier otra operación puede contactarnos a través de nuestro canal <a href="https://discord.com/9A2PXF3" target="_blank">Discord</a> o Whatsapp (0414-4802324) y evaluaremos su solicitud. 


        </p>
        <h3>¿Cuáles son las Comisiones?</h3>
        <p class="quien">

            En Cauce Orinoco no se Cobran Comisiones por la Operación.

            
        </p>
        <h3>¿Cuál es el Horario de la plataforma?</h3>
        <p class="quien">

            Puedes colocar ordenes las 24 horas del día, ejecutándose para el mismo día todas las órdenes registradas antes de las 7:00 pm (Hora Venezuela).

            
        </p>
        <h3>¿Cuantos tardan los Tiempos de Operación?</h3>
        <p class="quien">
      
            Nuestro proceso está diseñado para tener una duración Máxima de Operación de 15 min. Sin embargo, estamos sujetos a retrasos ocasionados por causas externas, principalmente por fallas en las plataformas bancarias nacionales.

        </p>
        <h3>¿Con cuales Bancos Operamos?</h3>
        <p class="quien">
            Desde Nuestra Plataforma Cambiaria Creemos en la Rapidéz del Servicio, por lo que buscamos Garantizar la Disponibilidad Inmediata de los fondos de nuestros Usuarios, es por ello que contamos con los principales Bancos Nacionales y Monederos:

            
              <table id="lados">
                <tr>
                  <td><img src="img/bancovenezuela.jpg" id="" class="izquier"> </td>
                  <td><img src="img/banesco.png" id="" class="dere"></td>
                </tr>
                <tr>
                  <td><img src="img/mercantil.png" id="" class="izquier"></td>
                  <td><img src="img/provincial.png" id="" class="dere"></td>
                </tr>
                <tr>
                  <td><img src="img/bitcoin.png" id="" class="izquier"></td>
                  <td><img src="img/ethereum.jpg" id="" class="dere"></td>
                </tr>
              </table>
              <br>

        </p>

          </div>
      </div>

        </div>
        </div>
    </div>
      </div>
    </div>
  </div>
  

   <!-- Modal Ayuda-->
  <div class="modal fade" id="myModalayuda" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content text-justify">
        <div class="modal-body">
  <center><h4><strong>Porfavor siga las instrucciones</strong></h4></center>
<!-- Grid row -->
            <div class="row">
                <!-- Grid column -->                
                <div class="col-lg-4 col-md-12 mb-4">
            
                    <!--Card-->
                    <div class="card">
                     

                        <!--Card content-->
                        <div class="card-body text-justify">
                            <!--Title-->
                            <h4 class="card-title indigo-text text-center"><strong><img class="animated pulse infinite" style="width:30%;margin-top:20px;" src="img/1.png"></strong></h4>
                            <br><p class="card-text container text-center"><strong>Selecciona la moneda y coloca el monto a cambiar </strong></p>
                            
                               <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="img/help1.png" alt="photo" class="ayuda" style="margin-top:5px;">
                            <a href="#!">
                                <div class="mask"></div>
                            </a>
                        </div>


                            <!--Text-->

                            <br><p class="card-text container">● Recuerda consultar los <strong>Terminois y Condiciones</strong></p><br>

                            <p class="card-text container"><strong>Nota: En Orinoco no se cobran comisiones adicionales.</strong></p>
                        </div><br><br><br><br>

                    </div>
                    <!--/.Card-->
            
                </div>
                <!-- Grid column -->
<!-- Grid column -->
                <div class="col-lg-4 col-md-12 mb-4">
            
                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body text-justify">
                            <!--Title-->
                            <h4 class="card-title indigo-text text-center"><strong><img class="animated pulse infinite" style="width:30%;margin-top:20px;" src="img/2.png"></strong></h4>
                            <br><p class="card-text container text-center"><strong>Selecciona el banco donde quieres recibir tu pago</strong></p> 

                             <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="img/ayuda2.png" alt="photo" class="ayuda">
                            <a href="#!">
                                <div class="mask"></div>
                            </a>
                        </div>

                            <!--Text-->
                            
                            <br><p class="card-text container">● Si tu banco deseado no esta entre los disponibles, selecciona la opcion de agregar otro banco. </p>
                            <p class="card-text container">● Una vez seleccionado tu banco, procede a hacer click en el botón "Continuar". </p>
                        </div><br><br><br>

                    </div>
                    <!--/.Card-->
            
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-lg-4 col-md-12 mb-4">
            
                    <!--Card-->
                    <div class="card">

                        

                        <!--Card content-->
                        <div class="card-body text-justify">
                            <!--Title-->
                            <h4 class="card-title indigo-text text-center"><strong><img class="animated pulse infinite" style="width:30%;margin-top:20px;" src="img/3.png"></strong></h4>
                            <br><p class="card-text container text-center"> <strong>Introduce tu usuario de steemit</strong></p>

                            <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="img/ayuda3.png" class=" ayuda" alt="photo" >
                            <a href="#!">
                                <div class="mask"></div>
                            </a>
                        </div>

                            <!--Text-->
                            
                            <br><p class="card-text container">● Tu transaccion será enlazada con steemit a través de la página <strong>SteemConnect</strong> y la finalizar, volveras aquí. </p>
                            <p class="card-text container">● La operación sera agregada a "Transacciones" con un estatus de <strong>"En proceso"</strong>. Al efectuarse tu transferencia, el estatus cambiará a <strong>"Finalizado"</strong>.</p>
                        </div>

                    </div>
                    <!--/.Card-->
            
                </div>
                <!-- Grid column -->
          </div>
        </div>
      </div>
    </div>
  </div>



    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/particles.min.js"></script>
    <script type="text/javascript" src="assets/app.js"></script>  
    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript">

      function mostrar(dato){
        if(dato=="1"){
            document.getElementById("sbd").style.display = "block";
            document.getElementById("steem").style.display = "none";
            $('input[name=moneda1]').val("1");
            $('input[name=vef1]').val("<?php echo $row['sbdbs']; ?>");
            $('input[name=vef2]').val("<?php echo $row['sbdbtc']; ?>");
            $('input[name=vef3]').val("<?php echo $row['sbdeth']; ?>");

            $('#moneda2').removeAttr("required");  
        }
        if(dato=="2"){
            document.getElementById("sbd").style.display = "none";
            document.getElementById("steem").style.display = "block";
            $('input[name=moneda2]').val("1");
            $('input[name=vef1]').val("<?php echo $row['steembs']; ?>");
            $('input[name=vef2]').val("<?php echo $row['steembtc']; ?>");
            $('input[name=vef3]').val("<?php echo $row['steemeth']; ?>");

            $('#moneda1').removeAttr("required");
            $('#moneda2').prop("required", true);
    
        }
        
      }
      function mostrar2(dato){
        if(dato=="1"){
            document.getElementById("bsf").style.display = "block";
            document.getElementById("usd").style.display = "none";
            document.getElementById("petro").style.display = "none";
            $('input[name=vef1]').val("");
            $('input[name=moneda1]').val("");
            $('input[name=moneda2]').val("");
           
        }
        if(dato=="2"){
            document.getElementById("bsf").style.display = "none";
            document.getElementById("usd").style.display = "block";
            document.getElementById("petro").style.display = "none";
            $('input[name=vef2]').val("");
            $('input[name=moneda1]').val("");
            $('input[name=moneda2]').val("");
    
        }
        if(dato=="3"){
            document.getElementById("bsf").style.display = "none";
            document.getElementById("usd").style.display = "none";
            document.getElementById("petro").style.display = "block";
            $('input[name=vef3]').val("");
            $('input[name=moneda1]').val("");
            $('input[name=moneda2]').val("");
    
        }
    }

      function calcular(){

        var de= $("select[name=de]").val();
        var a= $("select[name=a]").val();


        

        if(de==1 && a==1){
          var dato= $('input[name=moneda1]').val();
          var resultado= parseFloat(dato)*<?php echo $row['sbdbs']; ?>;
          $('input[name=vef1]').val(resultado); 
        }
        if(de==1 && a==2){
          var dato= $('input[name=moneda1]').val();
          var resultado= parseFloat(dato)*<?php echo $row['sbdbtc']; ?>;
          $('input[name=vef2]').val(resultado); 
        }
        if(de==1 && a==3){
          var dato= $('input[name=moneda1]').val();
          var resultado= parseFloat(dato)*<?php echo $row['sbdeth']; ?>;
          $('input[name=vef3]').val(resultado); 
        }
        if(de==2 && a==1){
          var dato= $('input[name=moneda2]').val();
          var resultado= parseFloat(dato)*<?php echo $row['steembs']; ?>;
          $('input[name=vef1]').val(resultado); 
        }
        if(de==2 && a==2){
          var dato= $('input[name=moneda2]').val();
          var resultado= parseFloat(dato)*<?php echo $row['steembtc']; ?>;
          $('input[name=vef2]').val(resultado); 
        }
        if(de==2 && a==3){
          var dato= $('input[name=moneda2]').val();
          var resultado= parseFloat(dato)*<?php echo $row['steemeth']; ?>;
          $('input[name=vef3]').val(resultado); 
        }

        
      }

      function calcular2(){
        var de= $("select[name=de]").val();
        var a= $("select[name=a]").val();

        if(de==1 && a==1){
          var dato= $('input[name=vef1]').val();
          var resultado= parseFloat(dato)/<?php echo $row['sbdbs']; ?>;
          $('input[name=moneda1]').val(resultado); 
        }
        if(a==1 && de==2){
          var dato= $('input[name=vef1]').val();
          var resultado= parseFloat(dato)/<?php echo $row['steembs']; ?>;
          $('input[name=moneda2]').val(resultado); 
        }
        if(a==2 && de==1){
          var dato= $('input[name=vef2]').val();
          var resultado= parseFloat(dato)/<?php echo $row['sbdbtc']; ?>;
          $('input[name=moneda1]').val(resultado); 
        }
        if(a==2 && de==2){
          var dato= $('input[name=vef2]').val();
          var resultado= parseFloat(dato)/<?php echo $row['steembtc']; ?>;
          $('input[name=moneda2]').val(resultado); 
        }
         if(a==3 && de==1){
          var dato= $('input[name=vef3]').val();
          var resultado= parseFloat(dato)/<?php echo $row['sbdeth']; ?>;
          $('input[name=moneda1]').val(resultado); 
        }
        if(a==3 && de==2){
          var dato= $('input[name=vef3]').val();
          var resultado= parseFloat(dato)/<?php echo $row['steemeth']; ?>;
          $('input[name=moneda2]').val(resultado); 
        }
      }

      $(document).ready(function(){
          $("#myBtn2").click(function(){
              $("#myModal2").modal();
          });
         
            
      });
    </script>
  </body>
</html>