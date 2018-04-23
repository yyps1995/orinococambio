<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
  $reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
  $unombre = trim($_POST['txtnombre']);
  $uapellido = trim($_POST['txtapellido']);
  $email = trim($_POST['txtemail']);
  $upass = trim($_POST['txtpass']);
  $code = md5(uniqid(rand()));
  $telefono = trim($_POST['telefono']);
  


  if ($_POST['txtpass']!= $_POST['txtpass2'])
 {
    $msg2 = "
          <div class='col l6 card green white-text'>
          <strong>¡Lo sentimos!</strong>  Las contraseñas no coinciden
        </div>
        ";
 }
 else{
  $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE user_email=:email_id");
  $stmt->execute(array(":email_id"=>$email));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if($stmt->rowCount() > 0)
  {
    $msg2 = "
          <div class='col l6 card green white-text'>
           El correo ya existe, por favor coloque otro
        </div>
        ";
  }
  else{
  
    if($reg_user->register($unombre,$uapellido,$email,$upass,$code,$telefono))
    {     
      $id = $reg_user->lasdID();    
      $key = base64_encode($id);
      $id = $key;
      
      $message = "          
            Hola $unombre
            <br /><br />
            Bienvenidq@ a Orinoco<br/>
            Para completar el registro, solo presiona el siguiente link<br/>
            <br /><br />
            <a href='http://orinococambio.com/verify.php?id=$id&code=$code'>Activa tu cuenta aqui!!</a>
            <br /><br />
            Gracias.";
            
      $subject = "Confirmar Registro";
            
      if($reg_user->send_mail($email,$message,$subject)==true) {
        $msg = "
          <div class='alert alert-success'>
            <strong>Felicidades!</strong>  Hemos enviado un correo a $email.
                    Porfavor presion en el link de corfirmacion en su correo para crear su cuenta.
                    En caso de no ubicar el correo, revise en el apartado de 'Correo no deseado' o 'Spam'. 
            </div>
          ";

      }
      else{
        $msg = "<div class='alert alert-success' style='color:red'>Hubo un error, intente registrar de nuevo.</div>";
        $eliminar= mysqli_query($mysql,"DELETE FROM tbl_users WHERE user_email='".htmlentities($email)."' ");
      }
    }
    else
    {
      echo "Lo siento, Query no ejecutado...";
    }   
  
  }
 }
}

if(isset($_POST['btn-login']))
{
  $user = trim($_POST['txtuser']);
  $upass = trim($_POST['txtupass']);
  
  if($user_login->logan($user,$upass))
  {
    $user_login->redirect('home.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link href="assets/styles27.css" rel="stylesheet" media="screen">
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

    <div class="content-wrapper">
    <div class="container animated bounceInDown ">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-9 col-center">
          <a class="navbar-brand" href=""><img class="animated fadeInDownBig img-responsive colibri" src="img/LOGO_PRUEBA.png"></a>
        </div>
        <div id="area">
          <div class="animated fadeInDownBig contenedor_reg col-center">
          <div> 
            <?php if(isset($msg)){
              echo $msg; 
            } 
             else{

            if(isset($msg2)){
              echo $msg2;
            }   ?>
            <form method="post">
          <h4 class="form-signin-heading">Registro de datos</h4>
          <div class="form-group forty">
              <input type="text" class="form-control " placeholder="Nombre" name="txtnombre" required="">
          </div>
          <div class="form-group forty">
              <input type="text" class="form-control " placeholder="Apellido" name="txtapellido" required="">
          </div>
          <div class="form-group forty">
              <input type="email" class="form-control" placeholder="Email" name="txtemail" required />
          </div>
          <div class="form-group forty">
              <input name="telefono"  id="telefono" type="text" placeholder="Teléfono" maxlength="11" class="form-control" onkeypress="return valida(event)" onBlur="caracteres()" required>
            </div>
          <div class="form-group forty">
              <input type="password" class="form-control " placeholder="Contraseña" name="txtpass" required />
          </div>
          <div class="form-group forty">
              <input type="password" class="form-control " placeholder="Repetir Contraseña" name="txtpass2" required />
          </div>
            
         
              <hr>
            <p>Al hacer click en "Registrarse", aceptas las <a style="color:#d35400" data-toggle="modal" href="#myModalCondiciones">condiciones</a> y confirmas que leiste nuestra <a style="color:#d35400"  data-toggle="modal" href="#myModalPoliticas">politica de datos</a></p>

                <hr>
                <button class="btn btn-large botoniniciar" type="submit" name="btn-signup">Registrarse</button>  
            </form>
        <?php 
            }      
        ?>
          </div>
        </div>
      </div>
    </div>
    </div>



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

    <!-- Modal Politicas-->
  <div class="modal fade" id="myModalPoliticas" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content text-justify">
        <div class="modal-header col-center">
          <h4>Politica de Datos!</h4>
        </div>
        <div class="modal-body">
          <p>Para la contratación de los servicios ofrecidos por el sitio Web es necesario que el Usuario, proporcione previamente a Orinoco.com. (ORINOCO) a través del mismo sitio Web ciertos datos confidenciales de carácter personal (en adelante, los "Datos Personales"), que ORINOCO tratará automatizadamente e incorporará a un fichero automatizado, que en su caso estará registrado, con las finalidades que en cada caso correspondan. Todas estas circunstancias serán previa y debidamente advertidas por ORINOCO  a los Usuarios, en los casos y en la forma en que ello resulta legalmente exigible. ORINOCO  garantiza que ha adoptado las medidas oportunas de seguridad en sus instalaciones, sistemas y ficheros. Asimismo, ORINOCO garantiza la confidencialidad de los Datos Personales.</p>
          <p>Los Datos Personales serán información confidencial y su acceso, así como la publicación, reproducción, divulgación, difusión, comunicación pública y transmisión de dicha información, requerirá la autorización previa de las personas naturales o jurídicas de que se trate. ORINOCO  no vende ni alquila los Datos Personales de los Usuarios. No obstante lo anterior, ORINOCO  revelará a las autoridades públicas competentes los Datos Personales y cualquier otra información que esté en su poder o sea accesible a través de sus sistemas y sea requerida de conformidad con las disposiciones legales y reglamentarias aplicables al caso, en cuyo caso se obliga a informar a El Usuario acerca de tal solicitud a la brevedad posible. El Usuario garantiza y responde, en cualquier caso, de la veracidad, exactitud, vigencia y autenticidad de los Datos Personales facilitados, y se compromete a mantenerlos debidamente actualizados.</p>
          <p>Por otra parte, con ocasión al uso del sitio Web, ORINOCO mantiene un seguimiento de las direcciones IP de los hosts con fines de administración y seguridad del sistema. También será revisado el tráfico de la página rastreando las vistas de la página que nos permite planear crecimiento (por ejemplo, agregando nuevos servidores).</p>
          <p>En definitiva toda la información y comunicación circulada entre el Usuario y el sitio Web se encuentra protegida por los privilegios y garantías a los que aluden los artículos 48 y 60 de la Constitución de la República Bolivariana de Venezuela.</p>
          <p>Vínculos externos: Esta página tiene vínculos (links) con otras páginas. ORINOCO a través de su sitio Web no es responsable por la confidencialidad o contenido de tales páginas Web. Si el Usuario accede a esos otros sitios Web ORINOCO no se hace responsable de las prácticas y políticas de confidencialidad adoptadas por tales proveedores.</p>
        </div>
      </div>
    </div>
  </div>

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
      function caracteres(){
            var input = document.getElementById('telefono');
            if(input.value.length < 11) {
              alert('El teléfono debe contener 11 números');
               $("input[name=telefono]").css({border: "solid 1px red"});
            }
          }
          function valida(e){
              tecla = (document.all) ? e.keyCode : e.which;

              //Tecla de retroceso para borrar, siempre la permite
              if (tecla==8){
                  return true;
              }
                  
              // Patron de entrada, en este caso solo acepta numeros
              patron =/[0-9]/;
              tecla_final = String.fromCharCode(tecla);
              return patron.test(tecla_final);
          }
     
    </script>
  </body>
</html>