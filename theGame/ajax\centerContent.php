<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");

$timee=$time=time();
define('AZtopGame35Heyam', true );
if(!$_SESSION['S_user']){
	echo"window.location=\"index.php?page=logout&error=noUser&from=cC\";";
  	exit();
}

//update last active
if($var1 && $var1!='botCheck' && $var1!='periodUpdate'){
	$S_lastactive=$timee;
}else if($_SESSION['S_lastactive']<($timee-(3600*2))){
	echo"window.location=\"index.php?page=logout&error=inactive\";";
  	exit();
}

//Do we need to add all session vars ?
$S_user=$_SESSION['S_user'];
//$S_clantag=$_SESSION['S_clantag'];
$S_side=$_SESSION['S_side'];
$S_donation=$_SESSION['S_donation'];

if($S_donation<100 && !$_SESSION['tempPointsFix']){
    $S_donation = $S_donation*100;
    $_SESSION['tempPointsFix']=1;
}

// Require generic functions.
require_once("../includes/db.inc.php");
require_once("includes/functions.php");

if (mysqli_connect_errno())
{
    exit();
}
/////////////////////////////////////////


function updatePlayers(){
	global $S_location, $S_user, $mysqli, $S_mapNumber, $S_clantag, $S_alliedclans, $S_alliedplayers;

	//$output.="clearPlayerList();";

	//if($showoff==1){$rule=" && users.password<>'' " ;}else{$rule=' && online=1' ; }
	  $players=0;

	if($S_mapNumber==3 || $S_mapNumber==14){//PVP

	     $sql = "SELECT users.username, hp, tag, level FROM users LEFT JOIN clans ON clans.username=users.username WHERE location='$S_location' ORDER BY username asc";
	    $resultaat = mysqli_query($mysqli, $sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
		 	$players++;
		 	if($record->tag){	$tag="[$record->tag]";	 }else{		$tag='';	}
			if($record->username=='M2H'){
					//Do Nothing
					$players--;
			}else if($S_user==$record->username){
				$onlineList.="addPlayer2(\"$record->username\", \"$tag\", 2, '$record->hp', '$record->level')+";
			}else if($record->tag==$S_clantag && $S_clantag){
				$onlineList.="addPlayer2(\"$record->username\", \"$tag\", 3, '$record->hp', '$record->level')+";
			}else if((strlen($record->tag) > 0 && in_array(strtolower($record->tag), $S_alliedclans)) || in_array(strtolower($record->username), $S_alliedplayers)){
				$onlineList.="addPlayer2(\"$record->username\", \"$tag\", 4, '$record->hp', '$record->level')+";
			}else{
				$onlineList.="addPlayer2(\"$record->username\", \"$tag\", 1, '$record->hp', '$record->level')+";
			}
		}

	}else{ //NOT in pvp

			$sql = "SELECT users.username, tag FROM users LEFT JOIN clans ON clans.username=users.username WHERE location='$S_location' && online=1 && work NOT IN ('move','sail') ORDER BY username asc";
		    $resultaat = mysqli_query($mysqli, $sql);
			while ($record = mysqli_fetch_object($resultaat))
			{
			 	if($record->username=='M2H'){
			 	 	$players--;
					//Do Nothing
				}else {
				 	$players++;
				 	if($record->tag){	$tag="[$record->tag]";	 }else{  $tag='';	}
					$onlineList.="addPlayer2(\"$record->username\", \"$tag\")+";
				}
			}
	}//pvp / or not

	$output.="if(\$('centerPlayerList')){\$('centerPlayerList').innerHTML=$onlineList'';}";
	//$output.="$onlineList";
	$output.="if(\$('playerAmount')){\$('playerAmount').innerHTML=\"<small>($players players)</small>\";}";
	return"$output";
}





if(rand(1,3)==1){
	//Execute this now and then.. but isn't always required
	$resultaat = mysqli_query($mysqli,"SELECT lastvalid, lastaction FROM stats WHERE username='$S_user' LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$lastvalid=$record->lastvalid;
		$lastaction=$record->lastaction;
	}
	$resultaat = mysqli_query($mysqli,"SELECT  botcheck, work, worktime FROM users WHERE username='$S_user' LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat))
	{
 		$botcheck=$record->botcheck;
 	}
	$onlineTime=($timee-$lastaction);
	mysqli_query($mysqli, "UPDATE stats SET lastaction='$timee', online=online+'$onlineTime' WHERE username='$S_user' LIMIT 1") or die("error --> 544");

	if($botcheck==0){

		if($S_donation>=10000 && $_SESSION['S_botcheckinterval']==1200){ 		$limit=1200;
		//}else if($S_donation>=7500){ 	$limit=1200; 	}
		}else if($S_donation>=1000 && $_SESSION['S_botcheckinterval']==1000){ 	$limit=1000;
		}else{					  	$limit=900;
		}
		//For donators; allow them to choose the 'normal' interval as donator option ONLY for fighting
        //May as well just make the check above. If they have the donation amount for increased bot length and have it selected...
		//if(($_SESSION['S_botcheckinterval']==900 || $_SESSION['S_botcheckinterval']==1000 || $_SESSION['S_botcheckinterval']==1200)){ $limit=$_SESSION['S_botcheckinterval']; }

		if(($S_mapNumber==3 OR $S_mapNumber==14) && $var1!='work'){
			$limit=$limit*2;
		}
		if($S_mapNumber==0){//Tutorial
			$limit=$limit*2;
		}
		if(($lastvalid+$limit)<$timee){
			if($S_donation>=1750){
			 	$nr=rand(100,999);
			}else{
				$nr=rand(1000,9999);
			}
			mysqli_query($mysqli,"UPDATE users SET botcheck='$nr' WHERE username='$S_user' LIMIT 1") or die("ert113");

		}
	}
	//End "execute"
}


$sql = "SELECT  botcheck, work, worktime FROM users WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
 	$botcheck=$record->botcheck;

 	//Setoption, reloadchatchannel will not be overwritten by botcheck
 	if(($var1!='useItem' || $record->work=='jail')  && $var1!='periodUpdate' && $var1!='bugReport' && $var1!='setOption' && $var1!='reloadChatChannels' && ($var1!='periodUpdate' OR $botcheck>0)){
		if($record->work=='jail' && $record->worktime>$timee){
			$var1='jail';
			$jailtime=$record->worktime;
		}else if($botcheck>0){
		 	if($var1!='botCheck'){
				$var1='botCheck'; $var2=''; $var3='';
			}
		}else if($record->work=='fight'){
			$var1='fighting';
		}else if($record->work=='move' ){// Was it OK to remove this: " && $var1!='loadLayout' " ?
			$var1='move';
		}
	}
}




if($var1=='botCheck' && $botcheck==0){
	$var1=='loadLayout';
}

if($var1=='bugReport'){

	$sql = "INSERT INTO bugreports (username, time , text, type)
		VALUES ('$S_user', '$timee', '$var2', 'web')";
 mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

}else if($var1=='reloadChatChannels'){

	echo"$('chatChannel').options.length =0;";




	if($S_mapNumber!=0 OR $S_location=="Tutorial 9"){

		echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"1 Region chat\", \"1\");";
		//echo"<option value=1>1 Region chat</option>";
		echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"2 World chat\", \"2\"" . ($S_clantag == "" ? ", true, true" : "") . ");";
		//echo"<option value=2>2 World chat</option>";
		echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"3 Clan chat\", \"3\"" . ($S_clantag == "" ? "" : ", true, true") . ");";
		//echo"<option value=3>3 Clan chat</option>";
		echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"4 Trade chat\", \"4\");";
		//echo"<option value=4>4 Trade chat</option>";

	}
		echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"5 Game help\", \"5\");";
		//echo"<option value=5>5 Game help</option>";

	if($S_mapNumber!=0 OR $S_location=="Tutorial 9"){
		if($S_side=='Pirate'){	echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"6 Pirate chat\", \"6\");";  }
		if($S_chatTag=='Guide' OR $S_chatTag=='Mod' OR $S_chatTag=='Admin'){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"89 Guide chat\", \"89\");";  }

		if($S_MODLOGIN==1){
			if($S_staffRights['generalChatAccess']){ echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"\", \"\");";
			echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"99 Mod-General\", \"99\");"; }
			if($S_staffRights['chatMod']==1){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"98 Chat mods\", \"98\");";  }
			if($S_staffRights['forumMod']==1){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"97 Forum mods\", \"97\");";;  }
			if($S_staffRights['bugsMod']==1){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"96 Bug mods\", \"96\");"; }
			if($S_staffRights['multiMod']==1){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"95 Multi mods\", \"95\");";  }
			if(($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  || $S_staffRights['multiSeniormod'] || $S_staffRights['leadmod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor'])){echo "$('chatChannel').options[$('chatChannel').options.length] = new Option(\"90 S&S mods\", \"90\");";  }
		}




	}
}else if($var1=='jail'){

 	include_once('includes/jail.php');

}else if($var1=='botCheck'){

 	include_once('includes/changeCenterLayout.php');
	echo changeLayout('botCheck', $var2);

}else if($calledBy=='LT'){

	include_once('includes/locationText.php');

}else if($var1=='loadLayout'){

    if($var2 == 'releaseFromJail')
    {
        mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='', dump3='' WHERE username='$S_user' LIMIT 1") or die("ert113");
    }
	include_once('includes/changeCenterLayout.php');
	echo changeLayout('-', '-');

	echo"$('locationTitle').innerHTML=\"$S_location\";";
	echo updatePlayers();
	include_once('includes/locationText.php');

}else if($var1=='showPlayer'){

 	if($S_mapNumber!=0){
 		include_once('includes/changeCenterLayout.php');
		echo changeLayout($var1, $var2);
	}


}else if($var1=='fighting'){

 	$fight=$var2;
 	include_once('includes/fighting.php');

}else if($var1=='useItem'){

 	$sql = "SELECT type,much,name FROM items_inventory WHERE ID='$itemID' && username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$itemType=$record->type;
		$itemMuch=$record->much;
		$itemName=$record->name;
	}
	if($itemType=='shoes' OR $itemType=='hand' OR $itemType=='helm' OR $itemType=='legs' OR $itemType=='gloves' OR $itemType=='body' OR $itemType=='horse' OR $itemType=='shield'){

	 include('wearItem.php');

	}else if($itemType=='cooked food'){

        if(strpos($S_location, "esert arena ") == 1)
        {
            $cheatLogQuery = "'Cheat log', '$S_user has eaten $itemName at $S_location.', 'Cheating $S_user - BM', '" . time() . "', '0'";

            $sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('Hazgod', $cheatLogQuery), ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");

            /*$sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");*/

            $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP, reportID)
                VALUES ('$S_user', 'Cheat log', '$S_user has eaten $itemName at $S_location.', '0', '" . time() . "', 'The Game', '', '0')";
            mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
        }
 		include_once('includes/useFoodItem.php');
 	}else if($itemType=='open'){
 		include_once('includes/useOpenItem.php');
 	}else if($itemType=='magical'){
 		include_once('includes/useMagicItem.php');
 	}else if($itemType=='locked'){
 		 echo"if($('LocationContent') && $('centerCityContents')){locationText('work', 'lockpicking', '$itemID');}";
	}else{
	 	if($itemName){
			echo"messagePopup('You cannot use this item.', '$itemName');";
		}
	}

    if($var3 == 1)  //Simple check, old use item function called direct from a script
    {
        if(mysqli_num_rows(mysqli_query($mysqli,  "SELECT ID FROM zmods WHERE action = 'Cheat log' AND username='$S_user' AND time > " . (time() - (3600 * 24 * 1)) .
            " AND reason LIKE 'Old useItem function used%' AND reason NOT LIKE '%Outland%'")) == 0)
        {
            $cheatLogQuery = "'Cheat log', 'The old useItem function has been called by $S_user at $S_location using $itemName (" . time() . ")', 'Cheating $S_user', '" . time() . "', '0'";

            $sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('Hazgod', $cheatLogQuery), ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");

            /*$sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");*/

            $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP, reportID)
                VALUES ('$S_user', 'Cheat log', 'Old useItem function used at $S_location using $itemName (" . time() . ")', '0', '" . time() . "', 'The Game', '', '0')";
            mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
        }
    }
    else if($var3 == 2) //More advanced, player inventory was activated but mouse was not over it
    {
        if(mysqli_num_rows(mysqli_query($mysqli,  "SELECT ID FROM zmods WHERE action = 'Cheat log' AND username='$S_user' AND time > " . (time() - (3600 * 24 * 1)) .
            " AND reason LIKE 'Old useItem function m2%' AND reason NOT LIKE '%Outland%'")) == 0)
        {
            $cheatLogQuery = "'Cheat log', 'The old useItem function m2 has been called by $S_user at $S_location using $itemName. (" . time() . ")<br/><br/>" . $_SERVER['HTTP_USER_AGENT'] .
                "', 'Cheating $S_user - m2', '" . time() . "', '0'";

            $sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('Hazgod', $cheatLogQuery), ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");

            /*$sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                VALUES ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
            mysqli_query($mysqli, $sql) or die("error report4324426");*/

            $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP, reportID)
                VALUES ('$S_user', 'Cheat log', 'Old useItem function m2 used at $S_location using $itemName (" . time() . ")', '0', '" . time() . "', 'The Game', '', '0')";
            mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
        }
    }

}else if($var1=='thieving'){

 	if($S_mapNumber==3 OR $S_mapNumber==14){
		exit();
	}
 	include_once('includes/thieving.php');
	echo thieve($action, $thieve1, $thieve2);

}else if($var1=='move'){


 	include_once('includes/changeCenterLayout.php');
	echo changeLayout('move', $var2);

}else if($var1==0 && $var2==1){

	$reloadTime=5*60*1000;
	echo updatePlayers(0);
	echo"setTimeout(\"updateCenterContents(0, 1);\",$reloadTime);";


}else if($var1=='pvp'){

 	include_once('includes/pvp.php');


}else if($var1=='setOption'){

 	if($var2=='chat' && $var3>=0 && $var3<=2){
		mysqli_query($mysqli, "UPDATE stats SET chat='$var3' WHERE username='$S_user' && chat<'$timee' LIMIT 1");
	}else if($var2=='fightTrain'){
		if($var3=='attack' OR $var3=='defence' OR $var3=='health' OR $var3=='strength'){
	 	 	mysqli_query($mysqli, "UPDATE users SET train='$var3' WHERE username='$S_user' LIMIT 1") or die("error --> 1");
		}
	}




}else if($var1=='periodUpdate'){

 	include_once('../scripts/setupMainscreen.php');

 	if($_SESSION['S_lastactive']>($timee-900)){
		echo updatePlayers();

		include_once('rebuildInventory.php');

		RebuildDropList();
		echo "recreateSortable('playerInventory');";

		//echo"if(!JSScriptsVersion || JSScriptsVersion<1){	messagePopup(JSScriptsVersion+\"Please refresh the game once: <a href=?$timee>click here</a><br /><br />You're running an older version of Syrnia, because we changed some bits after you logged in. You'll need to refresh to load these changes.<br />'\", \"Refresh\");	}";




 	}

}




?>