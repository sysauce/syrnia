<?
if(defined('AZtopGame35Heyam') && ($S_staffRights['chatMod']==1 || $S_staffRights['multiMod']) ){


$time=time()+9;
$datum=strftime( "%d-%m-%Y", $time);

$resultaaat = mysqli_query($mysqli, "SELECT ID FROM reports WHERE handled=0");
$reportCount = mysqli_num_rows($resultaaat);

echo"<ul>";
echo"<li><a href=?page=$page&>Main tools</a><br />";
echo"<li><a href=?page=$page&reports=1>Reports</a> ($reportCount)<br />";
echo"<li><a href=?page=$page&chatlog=1>Check old chat logs</a><br />";
echo"<li><a href=?page=$page&showall=1>Show all muted, jailed and forumbanned players</a><br />";
echo"<li><a href=?page=$page&crimes=1>Check a players crimes</a><br />";
echo"<li><a href=?page=$page&forum=1>Chat department forum</a><br />";
echo"<li><a href=?page=$page&chatOptions=duty>Change duty status</a><br />";

echo"</ul>";
echo"<hr>";

echo"<script type=\"text/javascript\">
function enableAreaByTickbox(ennableOrDisableMe){
	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
}

//function enableAreaByArea(ennableOrDisableMe, tickb){
//	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
//	$(tickb).checked=!$(tickb).checked;
//}
</script>";


$modChatMessage[0]="Warning: this subject is no longer appropriate for chat, please move it along.";
$modChatMessage[1]="Warning: Trade ads must be 15 minutes apart.";
$modChatMessage[2]="Warning: Shop/forum ads must be 1 hour apart.";
$modChatMessage[3]="Warning: Please do not recruit in chat more than once an hour.";
$modChatMessage[4]="Warning: Please do not recruit in this chat channel.";
$modChatMessage[5]="Warning: Please do not spam chat.";
$modChatMessage[6]="Warning: English language only in chat, please.";
$modChatMessage[7]="Warning: Game help chat is only for game related question, it is not for general conversation.";
$modChatMessage[8]="Warning: Game help chat is only for game related question, it is not for general conversation, final warning.";
$modChatMessage[9]="Warning: Please take this argument off the chat room.";
$modChatMessage[10]="Warning: Please take this argument off the chat room, final warning.";
$modChatMessage[11]="Please do not ask for or give personal information in chat.";
$modChatMessage[12]="Warning: Trade chat is only for in-game trading purposes, it is not for general conversation.";
$modChatMessage[13]="Warning: Trade chat is only for in-game trading purposes, it is not for general conversation, final warning.";
$modChatMessage[14]="Sorry, ignore my previous message please.";


//Fixed chat messages
if($chatadd && $modChatMessage[$chatMessageNr] && ($whisperName OR is_numeric($chatChannel) )  ){
	$moderator=1;
	$chatMessage=$modChatMessage[$chatMessageNr];

	if($whisperName){
 		$whisperTo="$whisperName";
 		$channel="W";
 	}else{
 		$channel="$chatChannel";
 	}
	include("../../scripts/chat/addchat.php");
	echo"<B><font color=green>Added chat message</font></B><br /><br />";
//Custom chat message
}else if($chataddCustom && $chatMessage && is_numeric($chatChannel)  ){
	$moderator=1;
	$channel="$chatChannel";
	modlog($S_user,'Chat message', "$chatChannel [ $chatMessage ]", 0, $timee, $S_user, $S_realIP, 0);
	include("../../scripts/chat/addchat.php");
	echo"<B><font color=green>Added chat message</font></B><br /><br />";


}





if($closeReport){
	mysqli_query($mysqli, "UPDATE reports SET handled=1, lastOpened='$timee', lastOpenedBy='$S_user' WHERE ID='$closeReport'") or die("10error --> 5443zxc43");

}


if($chatOptions=='duty'){
	echo"At the moment the duty status only works on reports: you will not be assigned chat reports if your listed as off duty (check departments page for an overview of active mods.<br />";
	echo"<br />";

	if($updateDuty==1){
			mysqli_query($mysqli, "UPDATE staffrights SET onDuty='$dutystatus' WHERE username='$S_user' LIMIT 1") or die("10error --> 5443zxc43");

	}

		$sql = "SELECT onDuty FROM staffrights WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$duty=$record->onDuty;
	}
	if($duty==1){
		echo"<b>You are currently ON duty</b><br /><br />";
	}else{
		echo"<b>You are currently OFF duty</b><br /><br />";
	}


	echo"<form action='' method=post>
	<input type=hidden name=updateDuty value=1>
	<select name=dutystatus>
	<option value=1>On duty
	<option value=0" . ($duty==1 ? " selected=selected" : "") . ">Off duty
	</select>
	<input type=submit value=Change>
	</form>";

##### Reports
}else if($reports==1){

	if($reportID){
		$sql = "SELECT lastOpenedBy, ID, lastOpened, reportReason, abuser, channels, reportedBy, reportTime, handled FROM reports WHERE ID='$reportID' LIMIT 1";
   		$resultaat = mysqli_query($mysqli, $sql);
    	while ($record = mysqli_fetch_object($resultaat))
		{
			$reportHour=date("H", $record->reportTime);
			$reportMinute=date("i", $record->reportTime);

			if($record->handled==1){
				echo"<h2><font color=red><b>This report has been closed by $record->lastOpenedBy</b></font></h2>";
			}else{

				$timeout=$timee-120;
				if($record->lastOpenedBy==$S_user OR $record->lastOpened<$timeout){
					echo"<font color=green><b>Only you are looking at this report at the moment</b></font><br />";
					mysqli_query($mysqli, "UPDATE reports SET lastOpened='$timee', lastOpenedBy='$S_user' WHERE ID='$reportID'") or die("10error --> 5443zxc43");
				}else{
					echo"<h2><font color=red><b>$record->lastOpenedBy is looking at this! (he/she opened it first)</b></font></h2>";
				}
			}

			echo"<h3><b>Report $record->ID:</b></h3>";
			echo"<table><tr><td>Against:</td><td><b>$record->abuser</b></td></tr>";
			echo"<tr><td>Filed by: </td><td><b>$record->reportedBy</b></td></tr>";
			echo"<tr><td>Time: </td><td><b>".date("d-m-Y H:i", $record->reportTime)."</b></td></tr>";
			echo"</table><br />";

			echo"<b>Reason:</b>";
			echo"<hr /><div style=\"border: 1pt black ; background-color: #CDDDA0;overflow: auto; width: 90%; height: 150px;\">";

			echo"<i>$record->reportReason</i></div>";



			function filterHours($chatline){

				global $reportHour;
				$lastHour=($reportHour-1);
				//Do NOT take alst hour from THIS log: //if($lastHour<0){ $lastHour="23";}//
				if($lastHour<10){ $lastHour="0$lastHour";}

				if(strpos($chatline, " $reportHour:") OR ($reportMinute<=10 && strpos($chatline, " $lastHour:"))){
					return $chatline;
				}else{
					return false;
				}
			}


			$list = explode(',', $record->channels);
			foreach($list as $index => $chatFile){
				if(!$chatFile){
					continue;
				}
				$filename=$chatFile;

				echo"<hr />Chat log: <b>".str_replace("chatlogs/", '', str_replace(".php", '', str_replace(CHATLOGPATH, "", $filename)))."</b><br /><div style=\"border: 1pt black ; background-color: #CBBDA0;overflow: auto; width: 90%; height: 250px;\">";

				if(file_exists($filename)){

					// $file = $FULLPATH."chatlogs/".date("Y_m_d").".php";
					 if (!$file_handle = fopen($filename,"r")) { echo "Error open<br/>"; }
					 if (!$file_contents = fread($file_handle, filesize($filename))) { echo "Error reading.<br/>"; }
					 $file_contents=stripslashes($file_contents);
					 fclose($file_handle);

					$chatHistory = explode("\n", $file_contents); // turn string to array
					array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
					$chatHistory = array_reverse($chatHistory);
					$chatHistory = array_filter($chatHistory, "filterHours"); // filter by channel number
					//array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
					$file_contents = implode("\n", $chatHistory); // turn array back into a string
					echo nl2br($file_contents);

	 			}else{
	 				echo"Error, file not found in report ID $record->ID<br />";
	 			}
				echo"</div><br />";
			}


			echo"<table width=100%><tr valign=top><td>";

			echo"<a href=\"?page=chat&closeReport=$reportID&reports=\"><b>Close, take no action at all</b></a>";

				echo"</td><td>";


		echo"<a href=\"?page=chat&closeReport=$reportID&reports=&checkPlayer=$record->abuser&reportID=$reportID\"><b>Close, go to punishments</b></a>";
		echo"<small>Make sure you know how you want to punish before closing the report.</small><br />";

			echo"</td></tr></table>";

		}

	}else{

		echo"Open report ID:<form action='' method='POST'><input type=text size=4 name=reportID><input type=submit value=open></form>";

		echo"<table cellpadding=5>";
		echo"<tr><td><b>Date</b></td><td><b>Abuser</b></td><td><b>Reported by</b></td><td><b>Status</b></td></tr>";
		$timeout=$timee-120;
		$sql = "SELECT lastOpenedBy, ID, lastOpened, abuser, reportedBy, reportTime FROM reports WHERE handled=0  ORDER BY ID ASC";
   		$resultaat = mysqli_query($mysqli, $sql);
    	while ($record = mysqli_fetch_object($resultaat))
		{
			echo"<tr><td>".date("d-m-Y H:i", $record->reportTime)."</td><td><a href=?page=$page&reports=1&reportID=$record->ID>$record->abuser</a></td><td>$record->reportedBy</td><td>";
			if($record->lastOpenedBy==$S_user){
				echo"<font color=red><b>You</b> are assigned to this report</font>";
			}else if($record->lastOpened<$timeout){
				echo"<font color=orange>Unassigned, someone ?</font>";
			}else{
				echo"<font color=green>$record->lastOpenedBy is assigned OR looking at it</font>";
			}
			echo"</td></tr>";
		}
		echo"</table>";
	}


##### CRIMES
}else if($crimes==1){
echo"<form action='' method=post>
Player <input type=tekst name=check><input type=submit value=check> </form>";

if($check){
echo"Checking $check:<br />";

   $sql = "SELECT timer, time, action,moderator, reason FROM zmods WHERE username='$check' ORDER BY ID DESC";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    if($record->time>0){  $timepje = date("d-m-Y H:i", $record->time);  }else{ $timepje=''; }

    $seconds=$record->timer;
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

	    if($record->action!='warn'){
		 echo"$timepje - <B>$record->action for $left.</B><br />";
	    }else{
		 echo"$timepje - <B>$record->action</B><br />";
		}
		echo"Reason <u>$record->reason</u>. By mod: $record->moderator<br />
	    <br />";
    }
}
#######
##### SHOWALL
}elseif($showall==1){
#MUTED PLAYERS
echo"<HR>
<B>Muted players in chat:</B><br /><table>";
   $sql = "SELECT username, chat FROM stats WHERE chat>$time order by chat asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->chat-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
} echo"</table>";


#JAILED PLAYERS
echo"<HR>
<B>Jailed players:</B><br /><Table>";
   $sql = "SELECT username, worktime FROM users WHERE work='jail' && worktime>$time && dump2='Misbehaviour' order by worktime asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->worktime-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
}echo"</table>";

#FORUMBANNED PLAYERS
echo"<HR>
<B>Forumbanned players:</B><br /><Table>";
   $sql = "SELECT username, forumban FROM stats WHERE forumban>$time ORDER BY forumban asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->forumban-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
} echo"</table>";

## DELETION
echo"<HR>
<B>Players pending deletion:</B><br />";
echo"Bastards freezed: (will be deleted due to inactivity)<table>";
$resultaat = mysqli_query($mysqli, "SELECT username FROM users where work='freezed' ORDER BY username asc");
    while ($rec = mysqli_fetch_object($resultaat)) {  echo"<tr><td>$rec->username<td>"; }
echo"</table><hr>";


}elseif($chatlog){

	echo"<b>Look up chat history</b>";
	echo"<form action='' method=post>
	<table>
	<tr><td>Year<td><input type=text name=yyy value=".date(Y).">
	<tr><td>Month:<td><input type=text name=mmm value=".date(n).">
	<tr><td>Day:<td><input type=text name=ddd value=".date(j).">
	<tr><td>Type:<td><select name=type onchange=\"document.getElementById('regionID').style.display = this.value == 'region' ? '' : 'none'; document.getElementById('whisper').style.display = this.value == 'whisper' ? '' : 'none';\">
	<option value=whisper>whisper
	<option value=guide>guide
	<option value=mod>mod
	<option value=help>help
	<option value=pirate>pirate
	<option value=world>world
	<option value=trade>trade
	<option value=region" . ($type == "region" ? " selected='selected'" : "") . ">region
	</select>
	<tr id='regionID'" . ($type == "region" ? "" : " style='display: none;'") . "><td>Region:<td><select name=regionID>
	<option value=19" . ($regionID == 19 ? " selected='selected'" : "") . ">Anasco
	<option value=10" . ($regionID == 10 ? " selected='selected'" : "") . ">Arch 1
	<option value=11" . ($regionID == 11 ? " selected='selected'" : "") . ">Arch 2
	<option value=12" . ($regionID == 12 ? " selected='selected'" : "") . ">Arch 3
	<option value=13" . ($regionID == 13 ? " selected='selected'" : "") . ">Arch 4
	<option value=21" . ($regionID == 21 ? " selected='selected'" : "") . ">Arch 5
	<option value=2" . ($regionID == 2 ? " selected='selected'" : "") . ">Dearn
	<option value=14" . ($regionID == 14 ? " selected='selected'" : "") . ">Desert arena
	<option value=6" . ($regionID == 6 ? " selected='selected'" : "") . ">Elven
	<option value=17" . ($regionID == 17 ? " selected='selected'" : "") . ">Exrollia
	<option value=9" . ($regionID == 9 ? " selected='selected'" : "") . ">Heerchey
	<option value=15" . ($regionID == 15 ? " selected='selected'" : "") . ">Kanzo
	<option value=20" . ($regionID == 20 ? " selected='selected'" : "") . ">Lost caves
	<option value=4" . ($regionID == 4 ? " selected='selected'" : "") . ">Mezno
	<option value=5" . ($regionID == 5 ? " selected='selected'" : "") . ">Ogre
	<option value=8" . ($regionID == 8 ? " selected='selected'" : "") . ">Party
	<option value=1" . ($regionID == 1 ? " selected='selected'" : "") . ">Remer
	<option value=16" . ($regionID == 16 ? " selected='selected'" : "") . ">Serpenthelm
	<option value=7" . ($regionID == 7 ? " selected='selected'" : "") . ">Skull
	<option value=3" . ($regionID == 3 ? " selected='selected'" : "") . ">The Outlands
	<option value=18" . ($regionID == 18 ? " selected='selected'" : "") . ">Webbers
	</select>
	<tr id='whisper'" . ($type == "whisper" || !$type ? "" : " style='display: none;'") . "><td>Username:<td><input type=text name=type2>
	<tr><td><td><input type=submit value='Check'>
	</table>
	</form>";

	if($yyy && $mmm){

		if($type == 'region')
		{
			$type2 = $regionID;
		}
		echo"<a href=\"mod_readchatlog.php?yyy=$yyy&mmm=$mmm&ddd=$ddd&type=$type&type2=$type2\" target=_blank>Read the <b>".htmlentities($type)."</b> chatlog here</a>";
	}


} else{


	$checkPlayer=htmlentities(trim($checkPlayer));
	if($checkPlayer){
	  	$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$checkPlayer' LIMIT 1");
		$playerExcists = mysqli_num_rows($resultaaat);
	}
	if($playerExcists==1){

		include('includes/punishment_tool_include.php');

	}else if($forum==1){
		$chatforum=1;
	 	include('forum.php');

	}else{



	 	echo"<b>Enter a players username to use the punishment/warn tools</b><br/><br />";
		if($playerExcists=='0'){
			echo"<font color=red>That player does not exist!</font><br/>";
		}
		echo"<table><form action='' method=post><input type=hidden name=punishment value=1>";
		echo"<tr><td>Username<td><input type=text name=checkPlayer value=\"$checkPlayer\"><td><input type=submit value='continue'></td></tr>";
		echo"<form action='' method=post>";
		echo"</form></table><br /><br />";



		echo"<B>Add a public chat warning</B><br /><br />
		<form action='' method=post>
		<input type=hidden name=chatadd value=1>
		<select name=chatChannel>
		<option value=1>1 Region(YOUR current region)</option>
		<option value=2>2 World</option>
		<option value=4>4 Trade</option>
		<option value=5>5 Help</option>
		<option value=6>6 Pirate</option>
		<option value=89>89 Guide</option>
		</select><br />
		<select name=chatMessageNr>";
		for($i=0;$modChatMessage[$i];$i++){
			echo"<option value=$i>".$modChatMessage[$i]."</option>";
		}
		echo"</select><input type=submit value='Add warning'>
		</form><br />";


		echo"<B>Add a whisper chat warning</B><br /><br />
		<form action='' method=post>
		<input type=hidden name=chatadd value=1>
		Username: <input type=text name=whisperName><br />
		<select name=chatMessageNr>";
		for($i=0;$modChatMessage[$i];$i++){
			echo"<option value=$i>".$modChatMessage[$i]."</option>";
		}
		echo"</select><input type=submit value='Whisper warning'>
		</form>";


		echo"<B>Add a <u>custom</u> chat message</B><br /><br />
		<form action='' method=post>
		<input type=hidden name=chataddCustom value=1>
		<select name=chatChannel>
		<option value=1>1 Region(YOUR current region)</option>
		<option value=2>2 World</option>
		<option value=4>4 Trade</option>
		<option value=5>5 Help</option>
		<option value=6>6 Pirate</option>
		<option value=89>89 Guide</option>
		</select><br />
		<input type=text name=chatMessage>
		<input type=submit value='Add warning'>
		</form><br />";



	}


}









}
?>