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
  $stmt->execute(array(":uid"=>'En proceso'));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}
?>

<script type="text/javascript">
      $(document).ready(function(){
      $("#fin").click(function(){
        event.preventDefault();
        var datos=$(this).serialize();
        $.ajax({
            type:"POST",
            url:"admin/php/finalizar.php",
            data:datos,
            beforeSend:function(){

                
            },
            success:function(r){
                if(r==1){
                  $("#area").load("admin/php/transacciones.php");
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
        
          <center id="up"><h2>Transacciones Pendientes</h2></center>
           <div id="contenedor-transacciones">
           
                
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
              <div class="tbody">
               <table >
              <tbody >
                  <tr>
                    <th class="title">Nombre:</th>
                    <td class="jj"><?php echo $roly['nombre'];?>&nbsp;<?php echo $roly['apellido'];?></td>

                    

                     <th class="title"><h6>Banco:</h6></th>
                    <td class="jj"><?php echo $roll['banco'];?>, <?php echo $roll['nombre'];?></td>

                    <th ></th>
                    <td ></td>

                  
                   
                  </tr>
                  <tr>
                    <th class="title"><h6>Fecha:</h6></th>
                    <td><?php echo $row['solicitud'];?></td>

                    <th class="title"><h6>Tipo de cuenta:</h6></th>
                    <td class="jj"><?php echo $roll['bancotipo'];?></td>
                    
                     <th class="title"><h3>Steemit:</h3></th>
                    <td class="jj"><h3>@<?php echo $row['steemuser'];?></h3></td> 
                  </tr>
                  <tr>
                    
                    <th class="title"><h6>Memo:</h6></th>
                    <td class="jj"><?php echo $row['memo'];?></td>

                    <th class="title"><h6>Numero de cuenta:</h6></th>
                    <td class="jj"><?php echo $roll['nrocuenta'];?></td>

                     <th class="title"><h3>Transferir:</h3></th>
                    <td class="jj"> <h3><?php echo $row['bolivares'];?>&nbsp;<?php echo $row['cambio'];?></h3></td>

                  </tr>
                  <tr>
                    
                    <th class="title"><h6>Recibido:</h6></th>
                    <td class="jj"> <?php echo $row['cantidad'];?>&nbsp;<?php echo $row['moneda'];?></td>

                    <th class="title"><h6>Nombre del titular:</h6></th>
                    <td class="jj"><?php echo $roll['nombre'];?></td>

                   
                    <th class="title"></th>
                     <td class="title"></td>

                  </tr>
                    <tr>
                    <th class="title"><h6>Tasa:</h6></th>
                    <td class="jj"><?php echo $row['tasa'];?></td>

                        <th class="title"><h6>Cédula:</h6></th>
                        <td class="jj"><?php echo $roll['cedula'];?></td>

                        <th class="title"></th>
                        <td class="jj"></td>

                     
                    </tr>     
                    <tr>
                        
                        <th class="title"><h6>Estatus:</h6></th>
                        <td class="jj"><?php echo $row['estatus'];?></td>

                        <th class="title"><h6>E-mail:</h6></th>
                        <td class="jj"><?php echo $roll['user_email'];?></td>

                        <th class="title"></th>
                        <td class="jj"></td>

                         
                         <td class="title"><form id="fin"><input type="hidden" name="fin" value="<?php echo $row['ventasID'];?>"><button type="submit" class="btn btn-primary">Finalizar</button></form></td>
                        

                    </tr> 
                  </tbody>
                  </table>
            </div>
                  <?php
                      }
                    }
                        
                  }

                  ?>

              

          </div>
        </div>
      </div>
    </div>

    
 