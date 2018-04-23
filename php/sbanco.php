 <?php
@session_start();
require_once '../class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

$de = trim($_POST['de']);
$a = trim($_POST['a']);
$moneda1 = trim($_POST['moneda1']);
$moneda2 = trim($_POST['moneda2']);
$vef1 = trim($_POST['vef1']);
$vef2 = trim($_POST['vef2']);
$vef3 = trim($_POST['vef3']);
$user = trim($_POST['user']);


if($de == "1"){

  $sdb=$moneda1;
}
else if($de == "2"){
  $sdb=$moneda2;
}

if($a == "1"){

  $vef=$vef1;
}
else if($a == "2"){
  $vef=$vef2;
}

else if($a == "3"){
  $vef=$vef3;
}


$stmt = $user_home->runQuery("SELECT * FROM banco WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row==0){
   $user_home->redirect('verificacion_banco.php');
}

try {
  $stmt = $user_home->runQuery("SELECT bancoID, banco, nombre FROM banco WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <script type="text/javascript">
      $(document).ready(function(){

        $("#venta").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        
        $.ajax({
            type:"POST",
            url:"php/steemuser.php",
            data:datos,
            beforeSend:function(){
                $("#desaparecer").animate({left: '150%'}, "slow");
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
           <div class="animated fadeInLeftBig  col-center">
              <center><h2>Monedero/Banco donde recibiras el pago  </h2></center>
              <form id="venta">
                <div class="form-group" id="se">
                    <div><br>
                      <select name="banco" id="banco" class="form-control middle lefted" required>
                      <option value="0" disabled="">Seleccionar Banco</option>
                        <?php
                        foreach ($rows as $row) {
                        ?>
                        <option value="<?php echo $row['bancoID']; ?>"><?php echo $row['banco'];?>, <?php echo $row['nombre'];?></option>
                        <?php } ?>
                      </select>
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
                      
                      
                      <a href="verificacion_banco.php" class="btn btn-large botonuser" id="myBtn6">Agregar otro Monedero/Banco</a>
                      
                          <button type="submit" class="btn btn-large botoniniciar" id="myBtn555">Continuar</button>
                    </div>
                </div>
                <a href="home.php" class="btn btn-warning">Atras</a>
              </form>
          </div>
        </div>



  </body>


