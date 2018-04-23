 <?php
@session_start();
require_once '../class.user.php';
date_default_timezone_set("UTC");

$user_home = new USER();

if(!$user_home->is_logged_in())
{
  $user_home->redirect('index.php');
}

try {
  $stmt = $user_home->runQuery("SELECT * FROM tasas ");
  $stmt->execute(array(":uid"=>1));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo "Ocurrió un error<br>";
    echo $ex->getMessage();
    exit;
}


$de = trim($_POST['de']);
$a = trim($_POST['a']);
$sdb = trim($_POST['sdb']);
$vef = trim($_POST['vef']);
$user = trim($_POST['user']);
$banco = trim($_POST['banco']);
$username = trim($_POST['username']);
$pago="Pendiente";
$estatus="En proceso";

$fecha = date('d-m-Y H:i:s');
$cambiofecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'd-m-Y' , $cambiofecha );

$cambiohora = strtotime ( '-4hour' , strtotime ( $fecha ) ) ;
$nuevahora = date ( 'H:i:s', $cambiohora );
$memo = trim($_POST['memo']);


foreach ($rows as $row) {

	if($de == "1" && $a== "1"){
		$verify=$sdb*$row['sbdbs'];
		$tasa=$row['sbdbs'];
	}

	if($de == "1" && $a== "2"){
		$verify=$sdb*$row['sbdbtc'];
		$tasa=$row['sbdbtc'];
	}
	if($de == "1" && $a== "3"){
		$verify=$sdb*$row['sbdeth'];
		$tasa=$row['sbdeth'];
	}
	if($de == "2" && $a== "1"){
		$verify=$sdb*$row['steembs'];
		$tasa=$row['steembs'];
	}
	if($de == "2" && $a== "2"){
		$verify=$sdb*$row['steembtc'];
		$tasa=$a*$row['steembtc'];
	}
	if($de == "2" && $a== "3"){
		$verify=$sdb*$row['steemeth'];
		$tasa=$row['steemeth'];
	}
}

/*if($verify == $vef){

}*/
if($de == "1"){
	$from="SBD";
}
else if($de == "2"){
	$from="STEEM";
}
if($a == "1"){

	$to="Bs";
}
else if($a == "2"){
	$to="BTC";
}

else if($a == "3"){
	$to="ETH";
}


	$stmt = $user_home->runQuery('INSERT INTO ventas(solicitud,horasolicitud, pago, moneda, cantidad, cambio, tasa, bolivares, banco, estatus, usuario, memo, steemuser ) VALUES("'.htmlentities($nuevafecha).'","'.htmlentities($nuevahora).'","'.htmlentities($pago).'","'.htmlentities($from).'","'.htmlentities($sdb).'", "'.htmlentities($to).'","'.htmlentities($tasa).'", "'.htmlentities($verify).'", "'.htmlentities($banco).'", "'.htmlentities($estatus).'" , :user, "'.htmlentities($memo).'", "'.htmlentities($username).'")');
	$stmt->execute(array(":user"=>$user));

	if($from == "SBD"){
         
		echo "php/steemit.php?de=$de&memo=$memo&sdb=$sdb&vef=$vef&user=$user&banco=$banco&username=$username&a=$a";
	}
	else if($from == "STEEM"){
		echo "php/steemit.php?de=$de&memo=$memo&sdb=$sdb&vef=$vef&user=$user&banco=$banco&username=$username&a=$a";
	}

	else{
		echo("ERROR");
	}
?>