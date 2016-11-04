<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>$S_location market</a><BR>";
$output.="<A href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<A href='' onclick=\"locationText('school');return false;\"><font color=white>Hook university</a><BR><BR>";

} elseif($locationshow=='LocationText'){

if($action=='shop'){
	$output.="Welcome to the Hooks edge market<BR>Suit yourself!<BR>";

	include('textincludes/shop.php');


}elseif($action=='school'){

	$output.="<B>Welcome to the school.<BR><BR>";

	if($constructingl<=40){ $output.="<a href='' onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>"; } else { $output.="You can't learn any more about constructing in here.<BR>"; }
	if($tradingl<=40){ $output.="<a href='' onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>"; } else { $output.="You can't learn any more about trading in here.<BR>"; }

}elseif($action=='tradingpost'){
	include('textincludes/trading.php');
} else {
	$output.=" Hooks edge is the oldest city of Skull island, populated by all of the retired pirate seadogs.  These wise pirates can teach many lessons at Hook University located here.  An old trading post can also be found here. ";
}

}
}
?>