<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<a href='' onclick=\"locationText('school');return false;\"><font color=white>University</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
$output.="<BR>";




} elseif($locationshow=='LocationText'){

if($action=='school'){
$output.="<B>Welcome to the Xanso university.</b><BR><BR>";

	if($constructingl<25){
	$output.="You do not have the required constructing level 25 to enter the university.<br>";
	}elseif($constructingl>=25 && $constructingl<40){
	 $output.="<a href='' onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>";
	} else { $output.="You can't learn any more about constructing in here.<BR>"; }
	if($tradingl<25){
	$output.="You do not have the required trading level 25 to enter the university.<br>";
	}elseif($tradingl>=25 && $tradingl<40){
	$output.="<a href='' onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>";
	 } else { $output.="You can't learn any more about trading in here.<BR>"; }

}elseif($action=='shop'){

	$output.="Welcome to the Unera stables, these brown horses are the fastest on this island!<BR><BR>";
	include('textincludes/shop.php');


}elseif($action=='jail'){

	include('textincludes/jail.php');

}elseif($action=='sail'){


include('textincludes/sailing.php');


	$resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && monstersmuch>0 LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
    if($aantal==1  OR $S_user=='M2H'){ ## PIRATES RECRUITEN!

        $output.="<BR><BR>";

		if($var1=='join'){
			$resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE  name='Keg of rum' && username='$S_user' LIMIT 1");
			   $aantal = mysqli_num_rows($resultaat);
			   if($aantal==1){
				$resultaat = mysqli_query($mysqli, "SELECT gold, fame FROM users WHERE username='$S_user' LIMIT 1");
				    while ($record = mysqli_fetch_object($resultaat)) { $fame=$record->fame;}
				$jailT=($fame)*5+30;
				if($jailT>=3600){
					$jailT=3600;
				}
				$workt=time()+$jailT;

				removeItem($S_user, 'Keg of rum', 1, '', '', 1);
				$S_location='Crab nest';
				mysqli_query($mysqli, "UPDATE users SET work='jail', location='Crab nest', worktime='$workt', dump2='Pirate newcomer', dump='', side='Pirate' WHERE username='$S_user' LIMIT 1") or die("err1");
				mysqli_query($mysqli, "DELETE FROM invasions WHERE username='$S_user'") or die("err1");

				mysqli_query($mysqli, "UPDATE users SET fame=0 WHERE username='$S_user' && fame>0 LIMIT 1") or die("err1");
				include('includes/mapData.php');
				$S_side='Pirate';

				echo"updateCenterContents('reloadChatChannels');";
				echo"if(parseInt($('statsFameText').innerHTML)>0){";
				echo"$('statsFameText').innerHTML=0;}";



				$output.="You have joined the pirates.<BR>";
				$output.="The pirates jail all the newcomers, the more famous you were, the more jailtime you'll get.<BR>";
				echo"updateCenterContents('move', 'Crab nest');";

				echo'if($(\'chatChannel\')){$(\'chatChannel\').innerHTML+="<option value=4>4 Pirate chat</option>";}';
			}else{
					$output.="You can not join the pirates because you need to take 1 Keg of rum with you to join them.<BR>";
				}
		} else{
			$output.="The pirates are currently recruiting new members.<BR>";
			$output.="Do you want to join the evil side of Syrnia and plunder all islands?<BR>";
			$output.="<i>Since we are in desperate need of recruits we will let you join if you take 1 Keg of rum with you....</i><br />";
			$output.="After joining the pirates you will not receive any rewards for invasions/events you've just participated in.<br />";
			$output.="<A href='' onclick=\"locationText('sail', 'join', 'pirates');return false;\">Join</a> the pirates.<BR>";
		}

	} # PIRATE RECRUIT



}else{
	$output.="Xanso University has been teaching the most famous traders and constructors for years.<BR>";
	$output.="Only the best of the best are allowed.<BR>";
	$output.="Xanso also contains a jail which holds all thieves of this island.";
}

}
}
?>