<?php
session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('https://orinococambio.com/admin/home-admin.php');
}


try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE estatus=:uid ORDER BY STR_TO_DATE(solicitud,'%d-%m-%Y') DESC");
  $stmt->execute(array(":uid"=>'Finalizado'));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurri贸 un error<br>";
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
            url:"php/rdetalles.php",
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
        
          <center id="up"><h2>Transacciones Realizadas</h2></center>
           <div id="contenedor-transacciones">
           
            <div class="tbody">
                   <table class=" table-striped">
                <thead>
                    <tr>
                        <th class="title">Solicitud</th>
                        <th class="title">Hora S</th>
                        <th class="title">Pago</th>
                        <th class="title">Hora P</th>
                        <th class="title">Memo</th>
                        <th class="title">Recibido</th>
                        <th class="title">Pagado</th>
                        <th class="title">Usuario</th>
                        <th class="title">Banco</th>
                        <th class="title">Steemit</th>
                        <th class="title">Detalles</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($rows as $row) {
                ?>
                    <tr>
                        <td class="jj"><?php echo $row['solicitud'];?></td>
                        <td class="jj"><?php echo $row['horasolicitud'];?></td>
                        <td class="jj"><?php echo $row['pago'];?></td>
                        <td class="jj"><?php echo $row['horapago'];?></td>
                        <td class="jj"><?php echo $row['memo'];?></td>
                        <td class="jj"><?php echo $row['cantidad']?>&nbsp;<?php echo $row['moneda'];?></td>
                        <td class="jj"><?php echo $row['bolivares'];?>&nbsp;<?php echo $row['cambio'];?></td>
                        
                        <?php
                         try {
                            $stmt = $admin_home->runQuery("SELECT * FROM tbl_users WHERE userID=:user");
                            $stmt->execute(array(":user"=>$row['usuario']));
                            $rowan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch(PDOException $exe) {
                              echo "Ocurri贸 un error<br>";
                              echo $exe->getMessage();
                              exit;
                          }

                           foreach ($rowan as $roly) {
                        ?>
                          <td class="jj"><?php echo $roly['nombre'];?>&nbsp;<?php echo $roly['apellido'];?></td>
                        <?php
                          }

                              try {
                            $stmt = $admin_home->runQuery("SELECT * FROM banco WHERE bancoID=:bank");
                            $stmt->execute(array(":bank"=>$row['banco']));
                            $ro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch(PDOException $exe) {
                              echo "Ocurri贸 un error<br>";
                              echo $exe->getMessage();
                              exit;
                          }
                          foreach ($ro as $roll) {
                         
                        ?>
                        
                          <td class="jj"><?php echo $roll['banco'];?>, <?php echo $roll['nombre'];?></td>
                         <?php
                          }

                        ?>

                        <td class="jj"><?php echo "@".$row['steemuser'];?></td>
                        <td class="jj"><form class="detalles"><input type="hidden" name="memo" value="<?php echo $row['memo'];?>"><button type="submit" style="background: none;border: 0;color: inherit;color:blue;cursor: pointer;">Ver detalles</button> </form></td>
                    </tr>
                    
           
                  <?php
                  }

                  ?>

           </tbody>
            </table>

              
            </div>
          </div>
        </div>
      </div>
    </div>

    
 