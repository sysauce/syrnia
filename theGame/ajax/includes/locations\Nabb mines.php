<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){
	
	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href=''  onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
	$output.="<a href=''  onclick=\"locationText('work', 'mining', 'Coal');return false;\"><font color=white>Mine Coal</a><BR>";
	$output.="<a href=''  onclick=\"locationText('work', 'mining', 'Tin ore');return false;\"><font color=white>Mine Tin</a><BR>";
	$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="This place has always been abandoned until coal was discovered, nowadays miners from all over the world gather here to mine coal. ";
}
}
?>