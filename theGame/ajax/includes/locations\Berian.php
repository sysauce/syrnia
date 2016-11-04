<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
	$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight in the mountains</a><BR>";
	$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="It looks like this mountain contains many different agressive creatures, watch your step!";

}

}
?>