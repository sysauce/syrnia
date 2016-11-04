<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>                 ";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Patrol</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'other');return false;\"><font color=white>Find monkeys</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="The fast growth of the jungle here makes it a great place to cut some wood or do a patrol for any dangers from the jungle. ";
$output.="With all the monkeys around you could even try to get yourself one, but you need to be quick.<br/>";


}
}
?>