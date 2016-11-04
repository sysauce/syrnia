<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="Rows and rows of timber can be found throughout the edges of this town.  The wood is ideal for ship-building, and most of the pirate ships built at the harbor is made from Bonewood's forests.";


}
}
?>