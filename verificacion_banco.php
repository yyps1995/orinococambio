<?php
@session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$rowanrow = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
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
      <li>
          <a class="btn btn-large botoniniciar btnn" style="margin: 12px ;" href="home.php">
            Inicio</a>
        </li>
      <li class="nav-item">
          
          <a data-toggle="modal" href="#myModalQuien" style="margin: 12px;" class="btn btn-large botoniniciar btnn " >¿Quienes Somos?</a>
      </li>
      <li >
          <a class="btn btn-large botoniniciar btnn" style="margin: 12px;" data-toggle="modal" href="#myModalayuda">
           ¿Cómo Funciona?</a>
        </li>
        <li >
          <a class="btn btn-large botoniniciar btnn" style="margin: 12px;" href="user_ordenes_venta.php">
            Transacciones</a>
        </li> 
      <li class="nav-item">
        <div class="nav-link dropdown">
          <button class="btn botonuser dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $rowanrow['nombre']; ?>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="datosgenerales.php">Datos Generales</a>
            <a class="dropdown-item" href="datosbancarios.php">Datos Bancarios</a>
            <a class="dropdown-item" id="clave" href="">Cambiar Clave</a>
            <a class="dropdown-item" href="logout.php">Cerrar Sesion</a>
          </div>
        </div>
      </li>
        
    </ul>
  </div>
</nav>

  <div class="content-wrapper">
    <div class="container">
    <div class="col-lg-12 col-center">
          <a class="navbar-brand" href=""><img class=" img-responsive colibri" src="img/LOGO_PRUEBA.png"></a>    
    </div>
    <div id="area">
    <div class="row">
    <div class="animated fadeInLeftBig col-md-5 col-lg-8 col-center contenedor">
    

    <div id="tituloagregarbancomonedero"><h2>Agregar Banco/Monedero</h2></div>
    <br>
    <input type="submit" class="btn btn-large botoniniciar" name="check1" id="check1"  name="button" value="Agregar Banco"/>
    
    <input type="submit" class="btn btn-large botoniniciar" name="check2" id="check2"  name="button" value="Agregar Monedero"/>
    <br><br>
    <?php
            if(isset($_GET['error']))
        { 
      ?>
      <div class='alert alert-success' style="color:red">
            <strong>Error al guardar</strong><br> Intente cerrar sesión y volver a ingresar por favor. 
      </div>
            
      <?php
        }
        else{   
      ?>  
     <div id="content1" style="display: none;">
       <h3 id="firsth3">Ingrese sus datos bancarios</h3>
        <form id="modificar" method="post">
        <div class="form-group">
            <div class="form-group">
              <input name="userID" type="text" class="form-control" value="<?php echo $rowanrow['userID']; ?>" hidden>
            </div>
            <div class="form-group fort">
              <label>Nombre</label>
              <input name="nombre" type="text" class="form-control" required>
            </div>
            <div class="form-group fort">
              <label>Cédula</label>
              <div class="rich">
                <select name="deno" class="form-control" required>
                  <option value="V-">V-</option>
                  <option vale="E-">E-</option>
                  <option value="P-">J-</option>             
                </select>
              </div>
              <input name="cedula"  id="cedula" type="text" maxlength="10" class="form-control" onkeypress="return valida(event)" onBlur="caracteresced()" required>
            </div>
            <div class="form-group fort">
              <label>Correo</label>
              <input name="user_email" type="email" class="form-control" required>
            </div>
              
            <div class="form-group fort">
              <label>Banco</label>
              <select name="banco" class="form-control" required>
                <option value="Banco Bicentenario">Banco Bicentenario</option>
                <option vale="Banco Caroní">Banco Caroní</option>
                <option value="Banco Canarias">Banco Canarias</option>
                <option value="Banco Confederado">Banco Confederado</option>
                <option value="Blolívar Banco">Blolívar Banco</option>
                <option value="Corp Banca">Corp Banca</option>
                <option value="Banco del Caribe">Banco del Caribe</option>
                <option value="Banco de Venezuela">Banco de Venezuela</option>
                <option value="Banpro">Banpro</option>
                <option value="Banco Provincial">Banco Provincial</option>
                <option value="Banco Banesco">Banco Banesco</option>
                <option value="Banco Fondo Común">Banco Fondo Común</option>
                <option value="Banfoandes">Banfoandes</option>
                <option value="Banco Occidental de Descuento">Banco Occidental de Descuento</option>
                <option value="Banco Venezolano de Crédito">Banco Venezolano de Crédito</option>
                <option value="Banco Guayana">Banco Guayana</option>
                <option value="Banco Exterior">Banco Exterior</option>
                <option value="Banco Industrial de Venezuela">Banco Industrial de Venezuela</option>
                <option value="Banco Mercantil">Banco Mercantil</option>
                <option value="Banco Plaza">Banco Plaza</option>
                <option value="Banco Federal">Banco Federal</option>
                <option value="Del Sur">Del Sur</option>
                <option value="Mi Casa">Mi Casa</option>
              </select>
            </div>
            <div class="form-group fort">
              <label>Tipo de Cuenta</label>
              <select name="tipobanco" class="form-control" required>
                <option value="Ahorro">Ahorro</option>
                <option value="Corriente">Corriente</option>
              </select>
            </div>
            <div class="form-group fort">
              <label>Número de Cuenta</label>
              <input name="nrocuenta"  id="nrocuenta" type="text" maxlength="20" class="form-control" onkeypress="return valida(event)" onBlur="caracteres()" required>
            </div>
            
        <center>
            <input name="btn-modificar" type="submit" class="btn botonuser" value="Agregar banco">
        </center>
        <a href="datosbancarios.php" class="btn botonuser" >Atras</a>
     </div>
      </form>      
     </div>
<div id="content2" style="display: none;">
       <h3 id="firsth3">Ingrese sus datos del monedero</h3>
        <form id="modificar2" method="post">
        <div class="form-group">
            <div class="form-group">
              <input name="userID" type="text" class="form-control" value="<?php echo $rowanrow['userID']; ?>" hidden>
            </div>
            <div class="form-group fort">
              <label>Nombre</label>
              <input name="nombre" type="text" class="form-control" required>
            </div>

            <div class="form-group fort">
              <label>Correo</label>
              <input name="user_email" type="email" class="form-control" required>
            </div>

            <div class="form-group fort" hidden="">
              <input value="N/A" name="cedula" type="number" class="form-control" hidden>
            </div>
              
            <div class="form-group fort">
              <label>Exchanger</label>
              <select name="exchanger" class="form-control" required>
                <option value="Localbitcoin">Localbitcoin</option>
                <option value="Bittrex">bittrex</option>
                <option value="Localethereum">Localethereum</option>
                <option value="Bitfinex">Bitfinex</option>
              </select>
            </div>
            <div class="form-group fort">
              <label>Cuenta</label>
              <select name="cuenta" class="form-control" required>
                <option value="Bitcoin">Bitcoin</option>
                <option value="Ethereum">Ethereum</option>
              </select>
            </div>
            <div class="form-group fort">
              <label>Direccion del monedero</label>
              <input name="direccion_monedero" type="text" class="form-control" required>
            </div>
            
        <center>
            <input name="btn-modificar" type="submit" class="btn botonuser" value="Agregar Monedero">
        </center>
        <a href="datosbancarios.php" class="btn botonuser" >Atras</a>
     </div>
      </form>
     </div>
    <?php
        }       
      ?> 
</div>
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
  <center><h4><strong>Por favor siga las instrucciones</strong></h4></center>
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
                            
                            <br><p class="card-text container">● Tu transaccion será enlazada con steemit a través de la página <strong>SteemConnect</strong> y al finalizar, volveras aquí. </p>
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
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">

     $("#check1").on( "click", function() {
      $('#content1').show(); //muestro mediante id
      $('#content2').hide(); //oculto mediante id
      $('#check1').hide(); //oculto mediante id
      $('#check2').hide(); //oculto mediante id
      $('#tituloagregarbancomonedero').hide(); //oculto mediante id    
     });     

     $("#check2").on( "click", function() {
      $('#content2').show(); //muestro mediante id
      $('#content1').hide(); //oculto mediante id
      $('#check1').hide(); //oculto mediante id
      $('#check2').hide(); //oculto mediante id
      $('#tituloagregarbancomonedero').hide(); //oculto mediante id
     }); 

        function caracteres(){
            var input = document.getElementById('nrocuenta');
            if(input.value.length < 20) {
              alert('El número de cuenta debe contener 20 números');
               $("input[name=nrocuenta]").css({border: "solid 1px red"});
            }
          }
        function caracteresced(){
            var input = document.getElementById('cedula');
            if(input.value.length < 7) {
              alert('La cédula debe contener al menos 7 números');
               $("input[name=cedula]").css({border: "solid 1px red"});
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
      $(document).ready(function(){
            $("#btnmodificarbancario").click(function(){
              $("#datosbancariosmodal").modal();

          });
            $("#btnnuevobanco").click(function(){
              $("#nuevacuentamodal").modal();
          });
          
          $("#modificar").submit(function(event){
                  event.preventDefault(); 
                  var datos=$(this).serialize();
                  var inp = document.getElementById('cedula');
                  var input = document.getElementById('nrocuenta');
                  if(inp.value.length < 7) {
                    alert('La cédula debe contener al menos 7 números');
                    $("input[name=cedula]").css({border: "solid 1px red"});
                  }
                  else{
                    if(input.value.length < 20) {
                      alert('El número de cuenta debe contener 20 números');
                      $("input[name=nrocuenta]").css({border: "solid 1px red"});
                    }
                    else{
                      $.ajax({
                          type:"POST",
                          url:"agregar_banco.php",
                          data:datos,
                          beforeSend:function(){
                              $("#desaparecer").animate({left: '150%'}, "slow");
                          },
                          success:function(r){
                            if(r==0){
                              window.location.href ='verificacion_banco.php?error';
                            }
                            else{
                              window.location.href ="datosbancarios.php";

                            }
                                  
                            
                              return r;
                          },
                          error:function(){
                              alert("Error al Enviar");
                          }
                      });
                    }
                  }
              });
          
          
          $("#modificar2").submit(function(event){
                  event.preventDefault(); 
                  var datos=$(this).serialize();
                      $.ajax({
                          type:"POST",
                          url:"agregar_monedero.php",
                          data:datos,
                          beforeSend:function(){
                              $("#desaparecer").animate({left: '150%'}, "slow");
                          },
                          success:function(r){
                            if(r==0){
                              window.location.href ='verificacion_banco.php?error';
                            }
                            else{
                              window.location.href ="datosbancarios.php";

                            }
                                  
                            
                              return r;
                          },
                          error:function(){
                              alert("Error al Enviar");
                          }
                      });
              });

          $("#clave").click(function(event){
                    event.preventDefault(); 
                    $("#area").load("php/cambiarclave2.php");
                });
          }); 
    </script>
  </body>
</html>