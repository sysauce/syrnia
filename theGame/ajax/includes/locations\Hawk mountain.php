<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="There is an ancient pirate story about a hawk with metallic wings, which led pirates to this mountain in search for metal to make weapons from. " .
    "Although the hawk has never been seen again, miners always look to the sky whenever they arrive or leave the mine shafts.";


}
}
?>