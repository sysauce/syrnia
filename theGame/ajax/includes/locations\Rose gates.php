<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('gate');return false;\"><font color=white>Speak to the Rose gate guards.</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</font></a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='jail'){

	include('textincludes/jail.php');

}elseif($action=='gate'){

	$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory WHERE name='Rose gate pass' && username='$S_user'  LIMIT 1");
	$aantal = mysqli_num_rows($resultaat);

	if($var1=='buyPass' && $aantal!=1){
		if(payGold($S_user, 500)==1){
		    addItem($S_user, 'Rose gate pass', 1, 'key', '', '', 1);
			$output.="You have bought a Rose gate pass.<BR><BR>"; $pass=0;
		} else{
		 	$output.="You do not have enough gold to buy the Rose gate pass!<BR><BR>";
		}
	}


	if($aantal==1){

		$output.="Rose gate guard: <i>\"Okay, your gate pass is valid, you can go through.\"</i><BR>";
		$output.="<a href='' onclick=\"updateCenterContents('move', 'Castle Rose');return false\">Go to Castle Rose</a>";


	} else {

		$output.="Rose gate guard: <i>\"HALT, because you are not from Rose island you need a Rose gate pass to enter!<BR>You can buy a Rose gate pass for 500 gold.\"</i><BR>";
		$output.="<a href='' onclick=\"locationText('gate', 'buyPass');return false;\">Buy</a> Rose gate pass for 500 gold";

	}

}else{
	$output.="Standing before you are the gates to Castle Rose named after the rose bushes planted to protect the castle back when it was just wooden walls.";

	$questID=16;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(1)]")      )){
		$output.="The lost girl is being trapped by a panther, <a href='' onclick=\"fighting('Lost panther');return false;\">Fight the panther</a>";
	}

}


}
}
?>