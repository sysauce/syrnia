<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('mill');return false;\"><font color=white>Bake bread</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){
 
	if($action==='mill'){
		 $output.="Use the well, the mill and bakery to bake bread. You will need to supply your own grain though!<br/>";
	 	$output.="<a href='' onclick=\"locationText('work', 'other', 'bread');return false;\"><font color=white>Bake bread</a> - (1 grain)<BR>";	
	}else{
		$output.="Stanro has built its first mill and everyone is allowed to use it to bake bread.  Using the nearby fires and water wells you got everything you need.";
	}
	
}
}
?>