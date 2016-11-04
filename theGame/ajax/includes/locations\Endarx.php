<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\"><font color=white>Smelt Bronze Bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\"><font color=white>Smelt Iron Bars</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

if($action=='smith'){
$output.="Select something to smith<BR><BR>";

include("textincludes/smithing.php");

} else {
	$output.="Welcome to Endarx!";
	$output.="<br>Feel free to use our anvils like many generations before you did. ";
	$output.="This town has provided anvils for the best smiths of Syrnia!<BR>";
	$output.="Here you can also smelt your ores into bars, which you can use to smith many things, such as: armour, weapons, tools and more...<br>";
	$output.="However, our furnaces can only reach a temperature high enough to smelt bronze and iron bars.<BR>";
	$output.="<BR>";
}

}
}
?>