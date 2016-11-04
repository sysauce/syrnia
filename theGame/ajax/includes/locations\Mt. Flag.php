<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR>";
	$output.="<a href='' onclick=\"locationText('smelt');return false;\"><font color=white>Smelting</a><BR>";
	$output.="<br/>";

} elseif($locationshow=='LocationText'){

if($action=='smelt'){
 	if((date("H")%(date("d")%3+2+date("W")%2))==0){
		$output.="The current underground molten movement is close enough to the surface to allow smelting of ores at this time.<br/>";
		$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\"><font color=white>Smelt Iron Bars</a><BR>";
		$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Steel bars');return false;\"><font color=white>Smelt Steel Bars</a><BR>";
		$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Gold bars');return false;\"><font color=white>Smelt Gold Bars</a><BR>";
	}else{
		$output.="The current underground molten movement is not close enough to the surface to allow smelting of ores at this time, please come back later.";
	}
}else{
$output.="Also known as a dangerous place if you want to trust your luck, or smelt your ores.";
}



}
}
?>