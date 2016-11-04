<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$halloween = isHalloween();

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
if(date("Y-m-d")<='2013-02-01' || $magicl < 5)
{
	$output.="<a href='' onclick=\"locationText('partyIslandFix');return false;\"><font color=white>Party island fix</a><BR><br/>";
}
$output.="<a href='' onclick=\"locationText('school');return false;\"><font color=white>University</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
$output.="<A href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('auction');return false;\"><font color=white>Cave of trading</a><BR>";
$output.="<a href='' onclick=\"locationText('magic');return false;\"><font color=white>White Wizards Tower</a><BR>";

//if(date(jn)=='53' OR date(jn)=='13' && $S_user=='M2H'){$output.="<a href=?p=stats><font color=white>Syrnia statistics</a><BR>"; }
if($halloween){
 	$output.="<br/>";
 	$output.="<a href='' onclick=\"locationText('tricktreat');return false;\"><font color=white>Trick or Treat present</a><BR>";
}

$output.="<BR>";



} elseif($locationshow=='LocationText'){

if($action=='jail'){
	include('textincludes/jail.php');

}
else if($action=='partyIslandFix')
{
	if(date("Y-m-d")<'2013-02-01' || $magicl < 5)
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
				
				$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Burning beach');return false;\">Burning beach</a><BR>";
				$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Penteza');return false;\">Penteza</a><BR>";
				$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Heerchey docks');return false;\">Heerchey docks</a><BR>";
				
				if($magicl>=5)
				{
					$output.="<a href='' onclick=\"locationText('partyIslandFix', 'Thabis');return false;\">Thabis</a><BR>";
				}
			}
			else if($var1 && $var2=='')
			{
				if(($S_side == 'Pirate' && $var1=='Crab nest') ||
					($S_side != 'Pirate' && $var1=='Port Senyn') ||
					$var1=='Burning beach' || $var1=='Penteza' || $var1=='Heerchey docks' ||
					($magicl>=5 && $var1=='Thabis'))
				{
					$output.="You will be moved to <b>$var1</b>. Are you sure?<BR><br/>";
					$output.="<a href='' onclick=\"locationText('partyIslandFix', '$var1', 'yes');return false;\">Yes, take me to $var1</a><BR>";
				}
			}
			else if($var2=='yes')
			{
				if(($S_side == 'Pirate' && $var1=='Crab nest') ||
					($S_side != 'Pirate' && $var1=='Port Senyn') ||
					$var1=='Burning beach' || $var1=='Penteza' || $var1=='Heerchey docks' ||
					($magicl>=5 && $var1=='Thabis'))
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
elseif($action=='school'){

	$output.="<B>Welcome to the $location university.<BR><BR>";
	if($constructingl<50 && $constructingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>";
	}elseif($constructingl<40){ $output.="You are not yet experienced enough to learn constructing at this university.<BR>";
	} else { $output.="You can't learn any more about constructing in here, try Maadi instead.<BR>"; }

	if($tradingl<50 && $tradingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>";
	}elseif($tradingl<40){ $output.="You are not yet experienced enough to learn about trading at this university.<BR>";
	} else { $output.="You can't learn any more about trading in here, try Maadi instead.<BR>"; }


}elseif($action=='tradingpost'){
	include('textincludes/trading.php');
}elseif($action=='auction'){ ### AUCTION
	include('textincludes/auction.php');
}elseif($action=='magic'){ # MAGIC
#########################

if($magicl>=20){
 	include('textincludes/magic.php');
} else {
$output.="You have not got enough magical powers yet, otherwise I would like to train you some magic...maybe come back later when you have trained.<BR>";
}


}elseif($action=='tricktreat'){

    $output .= trickOrTreat();

}else{
$output.="Named After the island itself, this town is Famous for the Magical Tower and for its high level in school training. ";
$output.="On some nights during a lightning storm you can see a casted shadow on the tower.";
$output.=" Some say it is the White Wizard, but no one has ever seen him. ";

	$questID=26;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && (stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(1)]")<>'')){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}
	
}



}
}
?>