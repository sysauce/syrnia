<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<A href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('auction');return false;\"><font color=white>Cave of trading</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='tradingpost'){

	include('textincludes/trading.php');

}elseif($action=='auction'){ ### AUCTION

	include('textincludes/auction.php');

} else {
$output.="The ogres at this location seem more friendly than the other ogres, since they make a profit from trading with humans.<BR>";
$output.="You are free to use the ogre tradingpost.";
}

}

}
?>