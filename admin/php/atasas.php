<?php
include("dbconfig.php");

$sbd1=$_POST["sbd1"];
$sbd2=$_POST["sbd2"];
$sbd3=$_POST["sbd3"];
$steem1=$_POST["steem1"];
$steem2=$_POST["steem2"];
$steem3=$_POST["steem3"];
$tasas="1";


$modificar = mysqli_query ($mysql, "UPDATE tasas SET sbdbs = '".$sbd1."', sbdbtc = '".$sbd2."', sbdeth = '".$sbd3."', steembs ='".$steem1."', steembtc = '".$steem2."', steemeth = '".$steem3."' WHERE tasasID='".$tasas."' ");
  
  if ($modificar == true) {
    echo "1";
}

else {
    echo "<p class='msj'>Error</p>";
}

?>