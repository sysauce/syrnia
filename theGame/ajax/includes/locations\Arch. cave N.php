<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This area contains a lot of tents and digging archeologists, it's unknown what they are digging for, but you can give it a try too.<BR>";
$output.="<a href='' onclick=\"locationText('work', 'other');return false;\">Dig using your spade</a>";


}
}
?>