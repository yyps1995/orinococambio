<?php
session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/home-admin.php');
}


try {
  $stmt = $admin_home->runQuery("SELECT * FROM tbl_users ");
  $stmt->execute(array(":uid"=>'Finalizado'));
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

    <div id="area">
      <div class="content-wrapper">
        <div class="contanier animated bounceInDown " >
          <div class="row">

                  

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h4>Usuarios</h4></strong>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Detalles</th>
                      </tr>
                    </thead>
                    <tbody id="recargar">
                       <?php
                        foreach ($rows as $row) {
                        ?>
                      <tr>
                        <td><?php echo $row['nombre'];?></td>
                        <td><?php echo $row['apellido'];?></td>
                        <td><?php echo $row['user_email'];?></td>
                        <td><?php echo $row['telefono'];?></td>
                        <td>Ver más</td>
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
      </div>
    </div>

    <script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    
    <script src="../assets/js/lib/data-table/datatables-init.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#recargar').load('usuarios.php');//actualizas el div
   }, 1000 );
});
    </script>