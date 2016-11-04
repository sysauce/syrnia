<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<a href='' onclick=\"locationText('floral');return false;\"><font color=white>$S_location's House of Floral</a><BR><BR>";

$output.="<br />";

} elseif($locationshow=='LocationText'){


if($action=='floral'){
	if($tradingl>=25){
		include('textincludes/floral.php');
	}else{
		$output.="<i>You need trading level 25+ to enter this shop!</i><br />";	
	}
	
}else{
	$output.="The enormous green trees seem to stretch endlessly to the sky. It is rumored fruits are plentiful here and the ancient mythical wood give surprises to those who would work here.<br />";
	$output.="<br />";
}


}
}
?>