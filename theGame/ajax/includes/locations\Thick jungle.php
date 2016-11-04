<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Attack the village</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="Here you can barely move with how thick the brush is here.";
$output.="Seemingly out of nowhere you see huts through the trees and notice it is a village but unfortunately for you it's not of humans. ";


}
}
?>