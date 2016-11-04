<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Coal');return false;\"><font color=white>Mine Coal</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Silver');return false;\"><font color=white>Mine Silver</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="Named after the city that uses this mine for it's rich iron and coal veins.";
$output.="The city guards watch carefully to protect the miners here so they can work in peace.";


}
}
?>