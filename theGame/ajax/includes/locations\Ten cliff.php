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

} elseif($locationshow=='LocationText'){

if($action=='smith'){
	$output.="Select something to smith<BR><BR>";

	include("textincludes/smithing.php");

} else {
$output.="The cliffs surrounding the town have been home to the mighty smiths of Skull island for many generations.  They are always welcoming new aspiring smiths to learn from the best by letting everyone use their furnaces and anvils.";
}

}
}
?>