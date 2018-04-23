 <?php
@session_start();
require_once '../class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$username = $_SESSION['userSession'];
$de = trim($_POST['de']);
$a = trim($_POST['a']);
$sdb = trim($_POST['sdb']);
$vef = trim($_POST['vef']);
$user = trim($_POST['user']);
$banco = trim($_POST['banco']);
$moneda1 = trim($_POST['moneda1']);
$moneda2 = trim($_POST['moneda2']);
$vef1 = trim($_POST['vef1']);
$vef2 = trim($_POST['vef2']);
$vef3 = trim($_POST['vef3']);

  function generarCodigo($longitud) {
 $key = '';
 $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
 $max = strlen($pattern)-1;
 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
 return $key;
}

$memo= generarCodigo(10);

?>
    <script type="text/javascript"> 

$(document).ready(function(){   

    $("#steemit").on( "click", function() {
      $('#venta2').show(); //muestro mediante id
      $('#venta').hide(); //oculto mediante id
      $('#steemit').hide(); //oculto mediante id
      $('#steemconnect').hide(); //oculto mediante id
      $('#transferir').hide(); //oculto mediante id
     });
    $("#steemconnect").on( "click", function() {
      $('#venta').show(); //oculto mediante id
      $('#venta2').hide(); //oculto mediante clase
      $('#steemconnect').show(); //oculto mediante id
      $('#steemit').show(); //oculto mediante id
      $('#transferir').hide(); //oculto mediante id
    });

        $("#venta").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        
        $.ajax({
            type:"POST",
            url:"php/final.php",
            data:datos,
            beforeSend:function(){
                
            },
            success:function(r){

              if(r == 0){
               
              }
              
              else{
                location.href =r;
              }
                  
                return r;
            },
            error:function(){
                alert("Error al Enviar");
            }
        });       
      });

        $("#venta2").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        
        $.ajax({
            type:"POST",
            url:"php/final2.php",
            data:datos,
            beforeSend:function(){

            },
            success:function(r){

              if(r == 0){
               
              }
              
              else{
                location.href =r;
              }
                  
                return r;
            },
            error:function(){
                alert("Error al Enviar");
            }
        });       
      });

        $("#atras").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        $.ajax({
            type:"POST",
            url:"php/sbanco.php",
            data:datos,
            beforeSend:function(){

            },
            success:function(r){
                    $("#area").html(r);
                return r;
            },
            error:function(){
                alert("Error al Enviar");
            }
        });      
      }); 

    }); 

    </script>
  <body>    
                 
        <div class="contenedor11">
           <div class="animated fadeInLeftBig  col-center ">
            <div id="transferir">
            <center><h2>Transferir usando:</h2></center>
            <div class="form-group " id="se2">
              <br><br>
              <input type="submit" class="btn btn-large myBtn5555" id="steemconnect"  name="button" value="Steem Connect"/>
              <input type="submit" name="button" id="steemit" class="btn btn-large myBtn555" value="Steemit"/>
              <br>
              <br><br>
            </div>              
            </div>
              <form id="venta" style="display:none">
                <h3>Coloque su usuario </h3>
                <div class="form-group " id="se">
                    <div><br>
                     <label id="regular">@</label>
                      <input type="text" name="username" class="middled form-control" placeholder="Introduce tu usuario de steemit sin el @" id="steemuser" required>
                      <button type="submit" onclick="this.onclick=function(){this.disabled = true}" class="btn btn-large continuaropcion" >Continuar</button>
                      <input type="hidden" name="de" value="<?php echo $de; ?> ">
                      <input type="hidden" name="a" value="<?php echo $a; ?> ">
                      <input type="hidden" name="sdb" value="<?php echo $sdb; ?> ">
                      <input type="hidden" name="vef" value="<?php echo $vef; ?> ">
                      <input type="hidden" name="user" value="<?php echo $user; ?> ">
                      <input type="hidden" name="banco" value="<?php echo $banco; ?> ">
                      <input type="hidden" name="memo" value="<?php echo $memo; ?> ">
                    </div>
                      <br><br>
                </div>
              </form>

              <form id="venta2" style="display:none">
                <h3>Coloque su usuario</h3>
                <div class="form-group " id="se">
                    <div><br>
                      <center>
                      <label id="regular">@</label>
                      <input type="text" name="username" class="middled2 form-control" placeholder="Introduce tu usuario de steemit sin el @" id="steemuser" required>
                      <button type="submit" onclick="this.onclick=function(){this.disabled = true}" class="btn btn-large continuaropcion" id="myBtnsteemit">Continuar</button>
                      <input type="hidden" name="de" value="<?php echo $de; ?> ">
                      <input type="hidden" name="a" value="<?php echo $a; ?> ">
                      <input type="hidden" name="sdb" value="<?php echo $sdb; ?> ">
                      <input type="hidden" name="vef" value="<?php echo $vef; ?> ">
                      <input type="hidden" name="user" value="<?php echo $user; ?> ">
                      <input type="hidden" name="banco" value="<?php echo $banco; ?> ">
                      <input type="hidden" name="memo" value="<?php echo $memo; ?> ">
                    </center>
                    </div>
                    <br><br>
                </div>
              </form>

                <div class="form-group " id="cuadrosteemit" style="display:none">
                      <div class="datos">
                       <h5>Transfiere <strong><?php echo $sdb;?>
                       </strong> a <strong>@orinoco</strong></h5>
                       <h5>Copia este memo: <strong><?php echo $memo ;?></strong></h5>
                      </div>
                      <center>
                      <input type="hidden" name="username" value="<?php echo $username; ?> ">
                      <input type="hidden" name="de" value="<?php echo $de; ?> ">
                      <input type="hidden" name="a" value="<?php echo $a; ?> ">
                      <input type="hidden" name="sdb" value="<?php echo $sdb; ?> ">
                      <input type="hidden" name="vef" value="<?php echo $vef; ?> ">
                      <input type="hidden" name="user" value="<?php echo $user; ?> ">
                      <input type="hidden" name="banco" value="<?php echo $banco; ?> ">
                      <input type="hidden" name="memo" value="<?php echo $memo; ?> ">
                    </center>
                    </div>

              <form id="atras" type="hidden"> <button type="submit" class="btn btn-warning" >
                Atras
                  <input type="hidden" name="de" value="<?php echo $de; ?> ">
                      <input type="hidden" name="a" value="<?php echo $a; ?> ">
                      <input type="hidden" name="sdb" value="<?php echo $sdb; ?> ">
                      <input type="hidden" name="vef" value="<?php echo $vef; ?> ">
                      <input type="hidden" name="user" value="<?php echo $user; ?> ">
                      <input type="hidden" name="moneda1" value="<?php echo $moneda1; ?> ">
                      <input type="hidden" name="moneda2" value="<?php echo $moneda2; ?> ">
                      <input type="hidden" name="vef1" value="<?php echo $vef1; ?> ">
                      <input type="hidden" name="vef2" value="<?php echo $vef2; ?> ">
                      <input type="hidden" name="vef3" value="<?php echo $vef3; ?> ">
                </button>
              </form>
          </div>
        </div>
   



  </body>
