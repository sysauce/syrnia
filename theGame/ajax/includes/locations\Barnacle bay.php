<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
	$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Fish</a><BR>";
	
	  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Small fishing boat' LIMIT 1"; 
	   $resultaat = mysqli_query($mysqli, $sql);     
	    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'fishing', 'Small fishing boat');return false;\"><font color=white>Fish with Small fishing boat </a><BR>"; }
	
	$output.="<BR>";
	
	    

} elseif($locationshow=='LocationText'){


	$output.="With countless sunken ships covering the sea floor around Barnacle bay, the fishing spots are numerous and plentiful.";
	  


}
}
?>