<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Coal');return false;\"><font color=white>Mine Coal</a><BR><BR>";

} elseif($locationshow=='LocationText'){


$output.="Mt. Vertor was found by accident. This town, close to Croy, was by an inactive volcano. Despite harsh ";
$output.="times the city tried to help Croy out with their decreasing employment for mining jobs but failed. ";
$output.="This mine is the only active mine left on the island. No one knows who discovered it. The legend says a powerful being ";
$output.="lives deep within the cave. At times you can hear somebody sipping down his final drink of the night, and you can see light from the sparks of pickaxes striking the ore.";




}
}
?>