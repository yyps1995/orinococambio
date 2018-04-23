<?php
session_start();
require_once '../class.user.admin.php';

$memo=$_POST["memo"];

$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
	$admin_home->redirect('admin/home-admin.php');
}



try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE memo=:uid");
  $stmt->execute(array(":uid"=>$memo));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}


echo'<script type="text/javascript">
      $(document).ready(function(){

      $("#devolver").submit(function(event){
        event.preventDefault();
        var datos=$(this).serialize();
        var confirmar=confirm("¿Seguro de que desea devolver esta transacción a Pendientes?");
      if (confirmar){
        $(".donut").show();
        $("#cancela").addClass( "disabled" );
        $.ajax({
            type:"POST",
            url:"php/devolver.php",
            data:datos,
            beforeSend:function(){

                
            },
            success:function(r){
                if(r==1){
                  $("#area").load("php/transaccionesrealizadas.php");
                }
                else{
                  alert(r);
                  $(".donut").hide();
                  $("#cancela").removeClass( "disabled" );
                }
                    
                return r;
            },
            error:function(){
                alert("Error al Enviar");
                $(".donut").hide();
                  $("#cancela").removeClass( "disabled" );
            }
        });
      }    
      }); 

        $("#vuelta").submit(function(){
          event.preventDefault();
          $("#area").load("php/transaccionesrealizadas.php");
           
        }); 
      });
    </script>';

    foreach ($rows as $row) {
               

                try {
                  $stmt = $admin_home->runQuery("SELECT * FROM banco WHERE bancoID=:bank");
                  $stmt->execute(array(":bank"=>$row["banco"]));
                  $ro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch(PDOException $exe) {
                    echo "Ocurrió un error<br>";
                    echo $exe->getMessage();
                    exit;
                }
                foreach ($ro as $roll) {

                   try {
                            $stmt = $admin_home->runQuery("SELECT * FROM tbl_users WHERE userID=:user");
                            $stmt->execute(array(":user"=>$row["usuario"]));
                            $rowan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch(PDOException $exe) {
                              echo "Ocurrió un error<br>";
                              echo $exe->getMessage();
                              exit;
                          }

                           foreach ($rowan as $roly) {

  echo'<div class="content-wrapper">
    <div class="container animated bounceInDown " >
    <div id="area">
          
           <center>
           <div id="contenedor-detalles">
              
              <div class="tbody">
               <table>
              <tbody >
              	<tr>
              		<center><h2>'.$roly["nombre"].'&nbsp;'.$roly["apellido"].'</h2>('.$roly["telefono"].')</center><br>
              	</tr>
              	
                  <tr>
                    <th class="title" scope="row"><h6>Solicitud:</h6></th>
                    <td  >'.$row["solicitud"].'</td>

                    

                     <th class="title " scope="row"><h6>Banco:</h6></th>
                    <td class="">'.$roll["banco"].'</td>

                  </tr>
                  <tr>
                    <th class="title" scope="row"><h6>Hora:</h6></th>
                    <td  >'.$row["horasolicitud"].'</td>

                    <th class="title" scope="row"><h6>Tipo de cuenta:</h6></th>
                    <td >'.$roll["bancotipo"].'</td>
                    
                  </tr>
                  <tr>
                    
                    <th class="title" scope="row"><h6>Pago:</h6></th>
                    <td>'.$row["pago"].'</td>

                    <th class="title" scope="row"><h6>Numero de cuenta:</h6></th>
                    <td >'.$roll["nrocuenta"].'</td>

                  </tr>
                  <tr>
                    
                    <th class="title" scope="row"><h6>Hora:</h6></th>
                    <td  >'.$row["horapago"].'</td>

                    <th class="title" scope="row"><h6>Nombre del titular:</h6></th>
                    <td >'.$roll["nombre"].'</td>

                  </tr>
                  <tr>

                    <th class="title" scope="row"><h6>Memo:</h6></th>
                    <td >'.$row["memo"].'</td>

                    <th class="title" scope="row"><h6>Cédula:</h6></th>
                    <td >'.$roll["denominacion"].$roll["cedula"].'</td>
                        
                  </tr>     
                  <tr>

                    <th class="title" scope="row"><h6>Estatus:</h6></th>
                    <td >'.$row["estatus"].'</td>
                        
                    <th class="title" scope="row"><h6>E-mail:</h6></th>
                    <td >'.$roll["user_email"].'</td>

                  </tr> 
                  <tr> 

                    <th class="title" scope="row"><h6>Recibido:</h6></th>
                    <td > '.$row["cantidad"].'&nbsp;'.$row["moneda"].'</td>  

                    <th class="title" scope="row"></th>
                        <td ></td>

                  </tr> 
                  <tr> 

                    <th class="title" scope="row"><h6>Tasa:</h6></th>
                        <td >'.$row["tasa"].'</td>

                    <th class="title" scope="row"></th>
                        <td ></td>

                  </tr> 

                    <div id="transfer">
                    	<h4 class="al">Transferido:</h4>
                   		<h4 class="al">'.$row["bolivares"].'&nbsp;'.$row["cambio"].'</h4><br>
                    </div> 
                    <div id="trans">	
                      <h4 class="al">Steemit:</h4>
                      <h4 class="al">@'.$row["steemuser"].'</h4>
                    </div> 
                     
                  </tbody>
            
                  </table>

                  
                  <div id="reference">
                      <h4 class="al">N. Ope:</h4>
                      <h4 class="al">'.$row["referencia"].'</h4><br>
                    </div> 
                    <div id="lado"> 
                      <h4 class="al">'.$row["desde"].'</h4>
                    </div>      
                        
                  <div id="botones">
                        
                      <form id="devolver" class="al"><input type="hidden" name="fin" value=" '.$row["ventasID"].'"><button type="submit" id="cancela" class="btn btn-danger">Devolver a Pendientes</button></form>
                  <div>
	               <div class="donut"></div>               
	                
            </div> 
          </div>
          </center>
          <div id="vuelta">
	                <form id="volver"><button type="submit" class="btn btn-outline-warning" id="bancoveri" style="border:solid 2px grey;color:grey;">Volver</button></form>
	                <div>
        </div>
      </div>
    </div>';

      }
                    }
                        
                  }

    ?>