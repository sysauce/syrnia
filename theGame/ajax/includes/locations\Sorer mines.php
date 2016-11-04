<?
if(defined('AZtopGame35Heyam')){
 
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Coal');return false;\"><font color=white>Mine Coal</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

$output.="The spiders come here often to lay eggs. As you look at the mining tunnels you see spider hatchlings crawl out and head to their lair.";


}
}
?>