<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
$output.="<a href='' onclick=\"locationText('showJail');return false;\"><font color=white>Jail</a><br />";
$output.="<a href='' onclick=\"locationText('friddik');return false;\"><font color=white>Visit Tom Friddik</a><br />";
$output.="<br />";

}else if($locationshow=='LocationText'){

	if($action=='showJail'){
		if($S_location=='Sanfew'){
		 	$output.="Got nothing left? you can <a href='' onclick=\"locationText('work', 'other');return false;\">clean</a> the $S_location cells for 2 gold pieces per minute.<br /><br />";
		}
		include('textincludes/jail.php');
	}elseif($action=='friddik'){
		include('textincludes/friddik.php');
	} else {
		$output.="<center><br />";
		$output.="Sanfew is a peaceful town in the southwest of Syrnia. Although it is peaceful, there is the big jail in Sanfew. ";
		$output.="If you are caught committing a crime, you will be locked up in there, but you aren't a criminal...are you?<br />";
		$output.="<br />";
		$output.="If you're new around here you could start some mining at Rynir Mines northeast of here. ";
		$output.="Or you could fish some shrimp at Lisim to prepare yourself for battle. (Make sure to cook the fish at Harith!) ";
		$output.="</center>";
	}

}


}
?>