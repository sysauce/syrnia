<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Platina ore');return false;\"><font color=white>Mine Platina ore</a><BR>";

$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Per Ankh</a><BR>";


$output.="<br />";

} elseif($locationshow=='LocationText'){

if($action=='shop'){
	### SHOPCODE
	if($tradingl>=25){
		include('textincludes/shop.php');
	}else{
		$output.="<i>You need trading level 25+ to enter Per Ankh.</i><br />";	
	}

}else{
	$output.=" The catacombs give off a dark blueish glow as travellers enter the tunnel. The scrolls at the entrance state other rare ore may be found for those skillful enough to find them.<br />";
	$output.="<br />";
}

}
}
?>