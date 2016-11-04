<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>Rynir Mines</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Tin ore');return false;\"><font color=white>Mine Tin ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Copper ore');return false;\"><font color=white>Mine Copper ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

$output.="<BR>Welcome to the Rynir Mines!<BR><BR>";
$output.="This is the place where the famous mines of Syrnia are.<br>";
$output.="There are a lot of people mining right now, deep under the surface.<br>";
$output.="Why don't you take your pickaxe and join them?<br>";


}
}
?>