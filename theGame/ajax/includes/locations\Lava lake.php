<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Silver bars');return false;\"><font color=white>Smelt silver Bars</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='smith'){
$output.="Select something to smith<BR><BR>";

include("textincludes/smithing.php");

} else {
$output.="This lava lake has been used to smelt powerfull metal for ages.<BR>";
$output.="This is the only place to smelt silver.";
}

}
}
?>