<?php
//GAMEURL, SERVERURL etc.
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");


$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$timee = time();



$todaysNightfall= mktime(0,0,0,date(m),date(d),date(Y));
$fullday= $todaysNightfall + 3600*24;

$tot=0;

if($maand){
	$resultaat = mysqli_query($mysqli, "SELECT
	DATE_FORMAT( FROM_UNIXTIME(time), '%Y-%m-%d') ymd,
	COUNT(*) as totPayments,
	SUM(donationAmount) as totAm
	FROM donations
	GROUP BY ymd order by time DESC Limit 90 ");     
}else{
	$resultaat = mysqli_query($mysqli, "SELECT
	DATE_FORMAT( FROM_UNIXTIME(time), '%Y-%m') ymd,
	COUNT(*) as totPayments,
	SUM(donationAmount) as totAm
	FROM donations
	GROUP BY ymd order by time DESC Limit 12 ");    
	
}
while ($record = mysqli_fetch_object($resultaat))
{		
	$earned = $record->totAm;
	$avgPayment = round(($earned/$record->totPayments)*100)/100;
	$tot += $earned;
	echo"$record->ymd\t$earned\t$record->totPayments\t$avgPayment\t$tot\n";
}



?>