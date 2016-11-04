<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
	$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
	$output.="<a href='' onclick=\"locationText('work', 'mining', 'Silver');return false;\"><font color=white>Mine Silver</a><BR>";
	$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='tradingpost'){
	include('textincludes/trading.php');
}else{
	$output.="This place is pretty far from any of the big populated towns, but is still popular because of its silver mines and the trading post.";
}

}
}
?>