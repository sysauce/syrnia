<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Valera</a><BR>";
$output.="<a href='' onclick=\"locationText('traininggrounds');return false;\"><font color=white>Training Grounds</a><BR>";
$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Mule Stables</a><BR>";
$output.="<a href='' onclick=\"locationText('friddik');return false;\"><font color=white>Visit Derek Friddik</a><br />";
$output.="<BR>";

}else if($locationshow=='LocationText'){

if($action=='traininggrounds'){

	$output.="Welcome, warrior, to the Valera training grounds!<BR>";
	$output.="We offer free training to all beginner warriors.<BR>";
	$output.="You can tell us what you want to train your fighting on, then we will open up a cage with your selected enemy which you can train on!<BR>";
	$output.="<BR>";

	//Keep showing this until 1,5 AND 6 are done.
	if(stristr($_SESSION['S_questscompleted'], "[1]")===false || stristr($_SESSION['S_questscompleted'], "[5]")===false || stristr($_SESSION['S_questscompleted'], "[6]")===false){
		if(stristr($_SESSION['S_questscompleted'], "[1]")===false && stristr($_SESSION['S_quests'], "1(1)]"))
		{
			$output.="Go to the Outlands 82 and collect the knights equipment.<BR>";
		}
		else
		{
			$output.="You find a warrior sobbing at the training grounds...<a href='' onclick=\"locationText('quest', 'Valera Knight');return false;\">talk to him</a>.<BR>";
		}
	}

	if($level<6){
	$output.="<BR><b>A guard runs at you and tells you:</b> \"<font color=red>Warning!</font> I would advise you to buy some good armour and weaponry from a smith before fighting, since your combat level is only $level and your weapon power is not that high yet ($powerst) <BR>You will be taking a huge risk fighting the monsters right now!\"<BR>";
	$output.="<B>Note: When you die you lose all of the items in your inventory!</B><BR><BR>";
	}

	if($level>=10){ $output.="<BR>I won't let you fight rats anymore, that's no challenge for you!<BR>"; }



	if($level<10){ $output.="Rat (Level 1) <form onsubmit=\"fighting('Rat');return false;\"><input type=submit value=Fight class=button></form><br />"; }
	$output.="Giant Spider (Level 2) <form onsubmit=\"fighting('Giant spider');return false;\"><input type=submit value=Fight class=button></form><br />";
	$output.="Gnome (Level 4) <form  onsubmit=\"fighting('Gnome');return false;\"><input type=submit value=Fight class=button></form><br />";


}elseif($action=='friddik'){

	include('textincludes/friddik.php');

}elseif($action=='quest'){
	//Do quest 1,5 or 6
	$questID=1;

 	$resultaaat = mysqli_query($mysqli,  "SELECT username FROM quests WHERE questID='1' && completed=1 && username='$S_user' LIMIT 1");
   	$aantal = mysqli_num_rows($resultaaat);
	if($aantal==1){
		$questID='5';

 		$resultaaat = mysqli_query($mysqli,  "SELECT username FROM quests WHERE questID='5' && completed=1 && username='$S_user' LIMIT 1");
	  	$aantal = mysqli_num_rows($resultaaat);
		if($aantal==1){ $questID='6'; }
	}

	include('textincludes/quests.php');


}elseif($action=='shop'){

	$output.="Welcome to the mule stables, these Mule's will carry all of your equipment and speed up your travelling!<BR><BR>";
	include('textincludes/shop.php');


} else {
	$output.="Welcome to Valera!<BR><BR>";
	$output.="This is the town where you can train your fighting skills and visit the stables.<br>";
	$output.="The training ground is very popular, because this is the only way to prove yourself as a great fighter!<br>";
	$output.="The stables are very famous, and are the best stables of Syrnia! Have fun in Valera!.<BR>";
	$output.="<BR>";
}

}
}
?>