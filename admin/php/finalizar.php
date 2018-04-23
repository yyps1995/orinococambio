<?php
session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();
$reg_admin = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/login-admin.php');
}

$stmt = $admin_home->runQuery("SELECT * FROM admin WHERE adminID=:adminID");
$stmt->execute(array(":adminID"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$fin=$_POST["fin"];
$ref=$_POST["ref"];
$banco=$_POST["banco"];

$estatus="Finalizado";
$fecha = date('d-m-Y H:i:s');
$cambiofecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'd-m-Y' , $cambiofecha );

$cambiohora = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
$nuevahora = date ( 'H:i:s', $cambiohora );


try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE ventasID=:uid");
  $stmt->execute(array(":uid"=>$fin));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}

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


$message = '    <span>Estimado '.$roly["nombre"].'&nbsp;'.$roly["apellido"].'. </span>  <br>

      <span>Se le informa que su tranzacción de cambio de <strong>'.$row["cantidad"].'&nbsp;'.$row["moneda"].'</strong> a sido finalizada exitosamente. Su memo es:<strong> '.$row["memo"].'</strong>. </span> <br>

       <span>Fueron transferidos <strong>'.$row["bolivares"].'&nbsp;'.$row["cambio"].'</strong> a su cuenta del '.$roll["banco"].' de número:  '.$roll["nrocuenta"].'. </span>  <br>

       <span>La transferencia fué realizada desde el '.$banco.' y el número de operación es: <strong>'.$ref.'</strong>.</span><br><br>

       <span>Para más información sobre la transferencia, visite el apartado de "Transacciones" en orinococambio.com </span>

       <div><h3>Gracias por preferir a Orinoco </h3></div>

            ';
      
    
      $subject = "Informe de Pago";
      $email= $roly["user_email"];

    if($reg_admin->send_mail($email,$message,$subject)==true){
      $modificar = mysqli_query ($mysql, "UPDATE ventas SET horapago='".$nuevahora."',estatus = '".$estatus."', pago='".$nuevafecha."', referencia='".$ref."', desde='".$banco."' WHERE ventasID='".$fin."' ");
  
      if ($modificar == true) {
          echo "1";
          $admin_home->redirect('https://orinococambio.com/admin/php/transacciones2.php');

      }

      else {
          echo "Error al Guardar.";
      }

    }
    else{
      echo "Error al enviar el correo";
    }

        }
            }  
          }

?>