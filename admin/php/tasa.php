<?php
session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/home-admin.php');
}

try {
  $stmt = $admin_home->runQuery("SELECT * FROM tasas");
  $stmt->execute(array(":uid"=>1));
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurri¨® un error<br>";
    echo $ex->getMessage();
    exit;
}
?>

<script type="text/javascript">
      $(document).ready(function(){
      $("#actualizatasas").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        $.ajax({
            type:"POST",
            url:"admin/php/atasas.php",
            data:datos,
            beforeSend:function(){

                
            },
            success:function(r){
                if(r==1){
                  alert("Actualizado Exitoso");
                  $("#area").load("admin/php/tasa.php");
                }
                else{
                  alert(r);
                }
                    
                return r;
            },
            error:function(){
                alert("Error al Enviar");
            }
        });    
      }); 


      });
    </script>


    <div class="content-wrapper">
    <div class="container animated bounceInDown " >
    <div id="area">
        
          <center id="up"><h2>Tasas</h2></center>
          <?php
                foreach ($row as $rows) {
                ?>
           <div id="tasastyle"> 
           <form id="actualizatasas">  
              <h4>1 SBD es igual a:</h4>
                  <div class="block"><label>Bolivares</label><input type="number" name="sbd1" value="<?php echo $rows['sbdbs'];?>" step="any" min="0" required class="middle form-control"></div>
                  <div class="block"><label>Bitcoin</label><input type="number" name="sbd2" value="<?php echo $rows['sbdbtc'];?>" step="any" min="0" required class="middle form-control"></div>
                  <div class="block"><label>ETH</label><input type="number" name="sbd3" value="<?php echo $rows['sbdeth'];?>" step="any" min="0" required class="middle form-control">  </div><br>
              <h4>1 STEEM es igual a:</h4>
                  <div class="block"><label>Bolivares</label><input type="number" name="steem1" value="<?php echo $rows['steembs'];?>" step="any" min="0" required class="middle form-control"></div>
                 <div class="block"> <label>Bitcoin</label><input type="number" name="steem2" value="<?php echo $rows['steembtc'];?>" step="any" min="0" required class="middle form-control"></div>
                  <div class="block"><label>ETH</label><input type="number" name="steem3" value="<?php echo $rows['steemeth'];?>" step="any" min="0" required class="middle form-control"> </div><br>

                  <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
            
            <?php
                 }
                ?>
            </form>  
        </div>
      </div>
    </div>

    
 