<?
if(defined('AZtopGame35Heyam') && $S_user){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
if(date("Y-m-d")<='2013-02-01')
{
	$output.="<a href='' onclick=\"locationText('partyIslandFix');return false;\"><font color=white>Party island fix</a><BR><br/>";
}
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<br />";

/*$sql = "SELECT II.name FROM items_inventory II
    LEFT JOIN item_types T ON T.name = II.type
    LEFT JOIN items I ON I.name = II.name
    WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
$output.= getRawsForCooking();

} elseif($locationshow=='LocationText'){


if($action=='sail'){

	include('textincludes/sailing.php');

}
else if($action=='partyIslandFix')
{
	if(date("Y-m-d")<'2013-02-01')
	{
		$resultaat = mysqli_query($mysqli, "SELECT username FROM votes WHERE username='$S_user' && datum='PIFix2012' LIMIT 1");
		$aantal = mysqli_num_rows($resultaat);
		if($aantal==1)
		{
			$output.="You already teleported, remember?<BR>";
		}
		else
		{
			if($var1=='')
			{
				$output.="Where do you want to go?<BR>";

				if($S_side == 'Pirate')
				{
					$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Crab nest');return false;\">Crab nest</a><BR>";
				}
				else
				{
					$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Port Senyn');return false;\">Port Senyn</a><BR>";
				}
				
				$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Penteza');return false;\">Penteza</a><BR>";
				$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Heerchey docks');return false;\">Heerchey docks</a><BR>";
				
				if($magicl>=5)
				{
					$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Kanzo');return false;\">Kanzo</a><BR>";
					$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Thabis');return false;\">Thabis</a><BR>";
				}
			}
			else if($var1 && $var2=='')
			{
				if(($S_side == 'Pirate' && $var1=='Crab nest') ||
					($S_side != 'Pirate' && $var1=='Port Senyn') ||
					$var1=='Penteza' || $var1=='Heerchey docks' ||
					($magicl>=5 && ($var1=='Kanzo' || $var1=='Thabis')))
				{
					$output.="You will be moved to <b>$var1</b>. Are you sure?<BR><br/>";
					$output.="<a href='' onclick=\"locationText('partyIslandFix', '$var1', 'yes');return false;\">Yes, take me to $var1</a><BR>";
				}
			}
			else if($var2=='yes')
			{
				if(($S_side == 'Pirate' && $var1=='Crab nest') ||
					($S_side != 'Pirate' && $var1=='Port Senyn') ||
					$var1=='Penteza' || $var1=='Heerchey docks' ||
					($magicl>=5 && ($var1=='Kanzo' || $var1=='Thabis')))
				{
					mysqli_query($mysqli, "UPDATE users SET location = '$var1' WHERE username='$S_user'") or die("error --> 1113");
					
					$sql = "INSERT INTO votes (datum, username, site) VALUES ('PIFix2012', '$S_user', '$S_realIP')";
					mysqli_query($mysqli, $sql) or die("erroraa report this bug");
					
					include('includes/mapData.php');
					echo"updateCenterContents('loadLayout', 1);";
					exit();
				}
			}
		}
	}
}
else{

$output.="As you step off the boat onto a small beach you see a few fires with people cooking around them. Off in the distance you see the dense jungle ";
$output.="that covers most of the island. Large stone walls stand out near the middle of the island.";
$output.=" In the sea breeze you notice the smell of roses along with the normal smells you expect.<br/><br/>";




	/*
if($_SESSION['S_side']=='Pirate'){ $to='Crab nest';} else{$to='Xanso';}
if($action=='sail' && $var1){
		mysqli_query($mysqli,"UPDATE users SET work='move', worktime=($timee+60), dump='$to', dump2='0' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
	$output.="You are entering the ship!<BR>";
 	echo"updateCenterContents('move', '$to');";
} else{
 	$output.="Because there are a lot of people coming and going to this island you can always catch a boat back.<br/>";
	$output.="Do you want to return to $to ?<BR><a href='' onclick=\"locationText('sail', 'yes');return false;\">Yes, leave</a>";
}
*/


  	$questID=13;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(1)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}
}

}
}
?>