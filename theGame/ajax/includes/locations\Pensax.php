<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR>";
$output.="<A href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<A href='' onclick=\"locationText('auction');return false;\"><font color=white>'Cave' of trades</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='auction'){
include('textincludes/auction.php');

}elseif($action=='tradingpost'){

 if($tradingl>=10){
	include('textincludes/trading.php');
}else{
  $output.="To encourage the tradecraft, only experienced traders are allowed to trade here.<br/>";
  $output.="Come back after some training!<br/>";
}


} else {
	$output.="Exrolia became an island where all were welcome, the warriors, their families and livestock.";
	$output.=" Therefore trading is done here on the island as it is convenient to all who have to travel from afar.";
	$output.="More than a few widows live in Pensax as it is safer for them here, their loved ones having died in the arena.<br/>";
	$output.="Only experienced constructors are allowed to build houses or shops here to make sure Pensax keeps looking good.<br/>";
}

}
}
?>