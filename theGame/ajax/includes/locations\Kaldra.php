<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="The ancient fortress of Kaldra has existed since the Empress first founded the kingdom. Long ago, it was conquered by the forces of ";
$output.="darkness unleashed by the evil mage and has become a den of pure evil as they use this place as a base camp to ";
$output.="plan their rampages against the kingdom. In the shadows on a cold dark night, you might be able to hear the screams of the evil mage's dark forces and catch a ";
$output.="glimpse of the Empress seeking her revenge.<br />";
$output.="<br />";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Enter the Fortress (fight)</a><BR>";




}
}
?>