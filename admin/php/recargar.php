 <?php
 session_start();
require_once '../class.user.admin.php';
$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
  $admin_home->redirect('admin/home-admin.php');
}

$stmt = $admin_home->runQuery("SELECT * FROM admin WHERE adminID=:adminID");
$stmt->execute(array(":adminID"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

try {
  $stmt = $admin_home->runQuery("SELECT * FROM ventas WHERE estatus=:uid OR estatus=:esta ORDER BY solicitud");
  $stmt->execute(array(":uid"=>'En proceso', ":esta"=>'Devuelto'));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}


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
              echo '

                  <tr>
                    <td class="jj">'.$roly["nombre"].'<br>'.$roly["apellido"].'</td>
                    <td class="jj">'.$row["solicitud"].'</td>
                    <td class="jj">'.$row["horasolicitud"].'</td>
                    <td class="jj">'.$row["memo"].'</td>
                    <td class="jj">'.$roll["banco"].',<br>'.$roll["nombre"].'</td>
                     <td class="jj">@'.$row["steemuser"].'</td>
                    <td class="jj">'.$row["cantidad"].'&nbsp;'.$row["moneda"].'</td>
                    <td class="jj">'.$row["bolivares"].'&nbsp;'.$row["cambio"].'</td>
                    <td class="jj">'.$row["estatus"].'</td>
                    <td class="jj"><form action="detalles.php" method="post"><input type="hidden" name="memo" value="'.$row["memo"].'"><button type="submit" style="background: none;border: 0;color: inherit;color:blue;cursor: pointer;">Ver detalles</button> </form></td>
                  </tr>
              ';
            
                      }
                    }
                        
                  }

                  ?>
                  
    <script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    
    <script src="../assets/js/lib/data-table/datatables-init.js"></script>