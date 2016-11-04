<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('arena');return false;\"><font color=white>The battlemage</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\"><font color=white>Smelt Bronze Bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\"><font color=white>Smelt Iron Bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Steel bars');return false;\"><font color=white>Smelt Steel Bars</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='tradingpost'){
	include('textincludes/trading.php');
}elseif($action=='arena'){
	include('textincludes/arena.php');
}else{
	$output.="Welcome to Kinam.<BR>";
	$output.="This place was founded by a rich family. They were constructing some new furnaces which are capable of smelting steel bars, and everyone is free to use them.<BR>";
	$output.="Because of the great interest a Trading post has been settled here.<BR>";
	$output.="If this family is going to build more on their location is unknown.";
}


}
}
?>