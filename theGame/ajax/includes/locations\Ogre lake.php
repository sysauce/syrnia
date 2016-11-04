<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Fish</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="This seems like a good place to fish, you can see a lot of fish swimming in the lake.";



}
}
?>