<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR>";
//$output.="<a href='' onclick=\"locationText('train');return false;\"><font color=white>Combat training</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


if($action=='train'){

	$output.="Welcome, warrior, to Ketil's combat training!!<BR>";
	$output.="We offer free training to all advanced warriors.<BR>";
	$output.="You can tell us what you want to train your fighting on, then we will open up a cage with your selected enemy which you can train on!<BR>";
	$output.="<BR>";

	$output.="<form onsubmit=\"fighting($('fightCage').value);return false;\"><select id='fightCage' class=input>";
	$output.="<option value='Oviraptor'>Oviraptor (Level 22)";
	$output.="<option value='Hadrosaurus'>Hadrosaurus (Level 24)";
	$output.="<option value='Grey bat'>Grey bat (Level 27)";
	$output.="</select>";
	$output.="<input type=submit value=Fight class=button></form>";

}else{
	//$output.="You have finally arrived! Train hard here for your fate depends on it.<BR>";
	$output.="Welcome, warrior, to Ketils combat training!<BR>";
	$output.="We offer free training to all warriors.<BR>";
	$output.="You can tell us what you want to train your fighting on, then we will open up a cage with your selected enemy which you can train against!<BR>";
	$output.="<BR>";

    $output.="Oviraptor (Level 22) <form onsubmit=\"fighting('Oviraptor');return false;\"><input type=submit value=Fight class=button></form><br />";
	$output.="Hadrosaurus (Level 24) <form onsubmit=\"fighting('Hadrosaurus');return false;\"><input type=submit value=Fight class=button></form><br />";
	$output.="Grey bat (Level 27) <form  onsubmit=\"fighting('Grey bat');return false;\"><input type=submit value=Fight class=button></form><br />";
}




}
}
?>