<?php
session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
	$admin_home->redirect('admin/home-admin.php');
}

try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE estatus=:uid ORDER BY solicitud");
  $stmt->execute(array(":uid"=>'Cancelado' ));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}
?>

<script type="text/javascript">
      $(document).ready(function(){

      $(".detalles").submit(function(){
        event.preventDefault();
        var datos=$(this).serialize();

        $.ajax({
            type:"POST",
            url:"php/edetalles.php",
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


    <div class="content-wrapper">
    <div class="container animated bounceInDown " >
    <div id="area">
          <center id="up"><h2>Transacciones Eliminadas</h2></center>
           <div id="contenedor-transacciones">
           
                
                  
              <div class="tbody">
               <table class=" table-striped">
                <thead>
                    <tr>
                        <th class="title">Solicitud</th>
                        <th class="title">Hora</th>
                        <th class="title">Eliminada</th>
                        <th class="title">Hora</th>
                        <th class="title">Memo</th>
                        <th class="title">Usuario</th>
                        <th class="title">Banco</th>
                        <th class="title">Steemit</th>
                        <th class="title">Detalles</th>
                    </tr>
                </thead>
              <tbody >
                 <?php
                foreach ($rows as $row) {
               

                try {
                  $stmt = $admin_home->runQuery("SELECT * FROM banco WHERE bancoID=:bank");
                  $stmt->execute(array(":bank"=>$row['banco']));
                  $ro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch(PDOException $exe) {
                    echo "Ocurrió un error<br>";
                    echo $exe->getMessage();
                    exit;
                }
                foreach ($ro as $roll) {

                   try {
                            $stmt = $admin_home->runQuery("SELECT * FROM tbl_users WHERE userID=:user");
                            $stmt->execute(array(":user"=>$row['usuario']));
                            $rowan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch(PDOException $exe) {
                              echo "Ocurrió un error<br>";
                              echo $exe->getMessage();
                              exit;
                          }

                           foreach ($rowan as $roly) {
              ?>
                  <tr>
                    <td class="jj"><?php echo $row['solicitud'];?></td>
                    <td class="jj"><?php echo $row['horasolicitud'];?></td>
                    <td class="jj"><?php echo $row['pago'];?></td>
                    <td class="jj"><?php echo $row['horapago'];?></td>
                    <td class="jj"><?php echo $row['memo'];?></td>
                    <td class="jj"><?php echo $roly['nombre'];?>&nbsp;<?php echo $roly['apellido'];?></td>
                    <td class="jj"><?php echo $roll['banco'];?></td>
                    <td class="jj"><?php echo "@".$row['steemuser'];?></td>
                   
                    <td class="jj"><form class="detalles"><input type="hidden" name="memo" value="<?php echo $row['memo'];?>"><button type="submit" style="background: none;border: 0;color: inherit;color:blue;cursor: pointer;">Ver detalles</button> </form></td>
                  </tr>
                  <?php
                      }
                    }
                        
                  }

                  ?>
                  
                  </tbody>
                  </table>
            </div>
                  
          </div>
        </div>
      </div>
    </div>