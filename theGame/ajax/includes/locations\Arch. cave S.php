<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This cave system contains dangerous white bats, they seem to be the strongest bats around here. <a href='' onclick=\"fighting('$S_location');return false;\">Fight white bats</a>";



}
}
?>