<?php

require_once '../class.user.php';
$user_home = new USER();

$cactual = trim($_POST['cactual']);
$cnueva = trim($_POST['cnueva']);
$cnueva2 = trim($_POST['cnueva2']);
$user = trim($_POST['usua']);

if ($_POST['cnueva']!= $_POST['cnueva2'])
 {
 	echo "0";
 }
else{
  $pass=md5($cactual);
  $passs=md5($cnueva);
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:user  ");
  $stmt->execute(array(":user"=>$user));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if($stmt->rowCount() > 0)
  {
    if($row['userPass']==$pass)
    {


      $stmt = $user_home->runQuery("UPDATE tbl_users SET userPass = '$passs' WHERE userID='$user'");
      $stmt->execute(array(":user"=>$user));
      
      echo "1";
    }
    else{
    	echo "2";
      
    }
  }
  else{
  	echo "3";
    
  }
          
}   

?>



