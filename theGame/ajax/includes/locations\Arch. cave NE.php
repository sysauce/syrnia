<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This cave system contains a lot of black and grey bats, McGoogin wouldn't mind if you kill a few. <a href='' onclick=\"fighting('$S_location');return false;\">Fight some bats</a>";



}
}
?>