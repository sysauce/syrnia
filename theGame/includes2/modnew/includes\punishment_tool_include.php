<?
if(defined('AZtopGame35Heyam') && $S_staffRights['canLoginToTools']==1){


		echo"<h3><b>Options for: $checkPlayer</b></h3>";


		if($addPunish==1){
		 	$punishments='';
		 	$pReason=htmlentities(trim($pReason));
			$pReason=nl2br($pReason);

			$timec=time()-120;

			$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM zmods WHERE username='$checkPlayer' && time>'$timec' LIMIT 1");
			$recentModActionsOnPlayer = mysqli_num_rows($resultaaat);
			if($override || $recentModActionsOnPlayer<=0){

			if($muteOption==1 && ($S_staffRights['chatMod']==1 || $S_staffRights['multiMod'] || $SENIOR_OR_SUPERVISOR==1)){
			 $punishments.="You have been muted.<br />";
			 $timer=$muteTimer;
			 $mute=$checkPlayer;

				if($muteDuur=='min'){$timer=$timer*60;
				}elseif($muteDuur=='hour'){$timer=$timer*60*60;
				}else{ $timer=$timer*60*60*24; }
				$muteReason=htmlentities(trim($muteReason));
				modlog($checkPlayer,'mute', $muteReason, $timer, $timee, $S_user, $S_realIP, $reportID);
				echo"<B>Muted $mute for $timer seconds</B><br />";
				$timer=$timer+time();
				mysqli_query($mysqli, "UPDATE stats SET chat='$timer' WHERE username='$mute' LIMIT 1") or die("e2rro43r2 --> 1  $mute][$mutetime");
			}
			if ($forumOption==1 && ($S_staffRights['forumMod']==1 || $S_staffRights['multiMod'] || $SENIOR_OR_SUPERVISOR==1)) {
			 $punishments.="You have been forum banned.<br />";
			 $timer=$forumTimer;
			 $forum=$checkPlayer;

				if($forumDuur=='min'){$timer=$timer*60;
				}elseif($forumDuur=='hour'){$timer=$timer*60*60;
				}else{ $timer=$timer*60*60*24; }
				$forumReason=htmlentities(trim($forumReason));
				modlog($checkPlayer,'forumban', $forumReason, $timer, $timee, $S_user, $S_realIP, $reportID );
				echo"<B>FORUM BANNED $forum for $timer seconds</B><br />";

				$timer=$timer+time();
				mysqli_query($mysqli, "UPDATE stats SET forumban='$timer' WHERE username='$forum'   LIMIT 1") or die("error4322 --> 1");
			}
			if ($jailOption==1 && ($S_staffRights['multiMod']==1 || $SENIOR_OR_SUPERVISOR==1)) {
			 $punishments.="You have been jailed.<br />";
			 	$timer=$jailTimer;
			 	$jail=$checkPlayer;
			 	if($jailDuur=='min'){$timer=$timer*60;
				}elseif($jailDuur=='hour'){$timer=$timer*60*60;
				}else{ $timer=$timer*60*60*24; }
				$jailReason=htmlentities(trim($jailReason));
				 modlog($checkPlayer,'jailed', $jailReason, $timer, $timee, $S_user, $S_realIP, $reportID );
				echo"<B>JAILED '$jail' for $timer seconds!</B><br />";

				$timer=$timer+time();

				   $sql = "SELECT worktime, work, worktime, side, dump2 FROM users WHERE  username='$jail' && password<>''  LIMIT 1";
				   $resultaat = mysqli_query($mysqli, $sql);
				    while ($record = mysqli_fetch_object($resultaat))
					{
					 	if($record->work=='jail' && $record->worktime>$timer && $record->dump2<>'Misbehaviour'){
					  		$timer=$record->worktime;
							echo"#$jail is not jailed on the time u set, because he was already jailed for a longer period! #";
						}
					}
				    mysqli_query($mysqli, "UPDATE users SET work='jail', worktime='$timer', dump2='Misbehaviour' WHERE username='$jail' LIMIT 1") or die("err42or2 --> 1");
				}

				//if($punishments==''){
				//	$punishments="Send you a warning.<br />";
				//}

				if($messageReason==1){
					$sql = "INSERT INTO messages (username, sendby, message, topic, time)
					  VALUES ('$checkPlayer', '<B>Syrnia</B>', 'Dear $checkPlayer,<br />
					  <br />
					  $punishments
					  <br />
					  A message from a moderator:<br />
					  <u>$pReason</u><br />', 'Moderation', '$timee')";
					mysqli_query($mysqli, $sql) or die("error report6");
					echo"<B>He/She has received a message, and a chat whisper.</B><br />";
					modlog($checkPlayer,'messaged', $pReason, '0', $timee, $S_user, $S_realIP, $reportID );

					$moderator=1;
					$chatMessage="Dear $checkPlayer, you have received a message from a moderator, please check your messages.";
					$channel=W;
					$whisperTo=strtolower($checkPlayer);
					include("../../scripts/chat/addchat.php");

				}else{
					echo"<B>No message has been sent to him/her (also no chat whisper!)</B><br />";
				}

				if($modNote==1){
				 	$modNoteText=htmlentities(trim($modNoteText));
					modlog($checkPlayer,'note', $modNoteText, '0', $timee, $S_user, $S_realIP, $reportID );
				}

				}else{
					//Needs override to happen
				$askingOverride=1;
				echo"<h1><font color=green>Uh </font><font color=blue> oh, </font> <font color=yellow> a conflict!</font></h1>
				<B><font color=red>This player has already been punished in the last 120 seconds</font></b><br />
				Please verify if you should still add your punishments/actions/messages, if so press the button below.<br/>";
				echo"<form action='' method=post>

				<input type=hidden name=addPunish  value=\"$addPunish\">
				<input type=hidden name=checkPlayer  value=\"$checkPlayer\">
				<input type=hidden name=override  value=\"$override\">

				<input type=hidden name=muteOption  value=\"$muteOption\">
				<input type=hidden name=muteTimer  value=\"$muteTimer\">
				<input type=hidden name=muteDuur  value=\"$muteDuur\">
				<input type=hidden name=muteReason  value=\"$muteReason\">

				<input type=hidden name=forumOption  value=\"$forumOption\">
				<input type=hidden name=forumTimer  value=\"$forumTimer\">
				<input type=hidden name=forumDuur  value=\"$forumDuur\">
				<input type=hidden name=forumReason  value=\"$forumReason\">

				<input type=hidden name=jailOption  value=\"$jailOption\">
				<input type=hidden name=jailDuur  value=\"$jailDuur\">
				<input type=hidden name=jailTimer  value=\"$jailTimer\">
				<input type=hidden name=jailReason  value=\"$jailReason\">

				<input type=hidden name=messageReason  value=\"$messageReason\">
				<input type=hidden name=modNoteText  value=\"$modNoteText\">
				<input type=hidden name=modNote  value=\"$modNote\">
				<input type=hidden name=pReason  value=\"$pReason\">

				<input type=hidden name=reportID  value=\"$reportID\">

				<input type=hidden name=override  value=\"1\">


				<input type=submit value=\"Yes I'm sure\">
				</form>";

				}


		}

		echo"<b>Report of $checkPlayer:</b> (last 50 messages)<br/>";
		echo"<hr /><div style=\"border: 1pt black ; background-color: #CBBDA0;overflow: auto; width: 90%; height: 250px;\">";

			$sql = "SELECT timer, time, action,moderator, reason, reportID FROM zmods WHERE username='$checkPlayer'" .
                ($S_user != 'M2H' && $S_user != 'Hazgod' && $S_user != 'SYRAID' && $S_user != 'Redhood' ? " AND action != 'Cheat log'" : "") . " ORDER BY ID DESC LIMIT 50";
		   	$resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
			    if($record->time>0){  $timepje = date("d-m-Y H:i", $record->time);  }else{ $timepje=''; }

			    $seconds=$record->timer;
			    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
			    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
			    }else{ $left=ceil(($seconds)/60)." minutes"; }

			    if($record->action=='mute' || $record->action=='muted'  || $record->action=='jailed' || $record->action=='jail' || $record->action=='forumban'){
				 	echo"$timepje - <B>$record->action for $left.</B>";
			    }else{
				 	echo"$timepje - <B>$record->action</B>";
				}
				if($record->reportID){
					echo" <a href=?page=chat&reports=1&reportID=$record->reportID>Report $record->reportID</a>";
				}
				echo"<br />";
				echo"Message: <u>$record->reason</u><br />
				<small>By mod: $record->moderator</small><br />";
			    echo"<br />";
		    }
		echo"<br /><br /><br /></div><hr />";

		if($askingOverride!=1){

		echo"<form action='' method=post><input type=hidden name=addPunish value=1>
		<input type=hidden name=reportID  value=\"$reportID\">
		<input type=hidden name=checkPlayer value=\"$checkPlayer\">
		<table>
		<tr valign=top><td><b>Action</b></td><td><b>Enable</b></td>
		<td>
		<b>Time</b><td><b>Time</b></td>
		<td><b>Reason</b> (mods only)
		</td></tr>";

		if($S_staffRights['chatMod']==1 || $S_staffRights['multiMod'] || $SENIOR_OR_SUPERVISOR==1){
		echo"<tr valign=top><td>Mute</td><td><input type=checkbox onclick=\"enableAreaByTickbox('muteReason');enableAreaByTickbox('muteTool1');enableAreaByTickbox('muteTool2');\" name=muteOption value=1></td>
		<td>
		<input  class=input type=text size=2 name=muteTimer id='muteTool1' disabled  value=15><td><select disabled id='muteTool2' name=muteDuur>
		<option value=min>Minutes<option value=hour>Hours<option value=days>Days
		</select></td><td>
		<input type=text name=muteReason disabled id=muteReason size=50>
		</td></tr>";
		}

		if($S_staffRights['forumMod']==1 || $S_staffRights['multiMod'] || $SENIOR_OR_SUPERVISOR==1){
		echo"<tr valign=top><td>Forumban</td><td><input type=checkbox name=forumOption onclick=\"enableAreaByTickbox('forumReason');enableAreaByTickbox('forumTool1');enableAreaByTickbox('forumTool2');\"  value=1></td>
		<td>
		<input  class=input type=text size=2 name=forumTimer id='forumTool1' disabled value=1><td><select disabled  id='forumTool2' name=forumDuur>
		<option value=min>Minutes<option value=hour selected>Hours<option value=days>Days
		</select></td><td>
		<input type=text name=forumReason id=forumReason disabled size=50>
		</td></tr>";
		}

		if($S_staffRights['multiMod']==1 || $SENIOR_OR_SUPERVISOR==1){
		echo"<tr valign=top><td>Jail</td><td><input type=checkbox onclick=\"enableAreaByTickbox('jailReason');enableAreaByTickbox('jailTool1');enableAreaByTickbox('jailTool2');\"  name=jailOption value=1></td>
		<td>
		<input  class=input type=text size=2 name=jailTimer disabled id='jailTool1' value=1><td><select disabled id='jailTool2' name=jailDuur>
		<option value=min>Minutes<option value=hour>Hours<option value=days selected>Days
		</select></td><td>
		<input type=text name=jailReason id=jailReason disabled size=50>
		</td></tr>";
		}

		echo"
		</table>
		<hr />
		<b>Player message</b><br />
		Send the reason in a message to the player: <input  type=checkbox name=messageReason id=messageReason checked onclick=\"enableAreaByTickbox('pReason');\"  value=1> <a href='#' onclick='enterWindow=window.open(\"defaultMessages.php\",\"DefaultMessages\",\"width=400,height=500,top=5,left=5,scrollbars=yes,resizable=yes\");return false;'>Default messages<a> (This also sends whisper)<br/>
		<textarea name=pReason id=pReason rows=6 cols=70></textarea><br />
		<hr />
		<b>Mod note</b><br />
		Add a note to the history of this player <input  type=checkbox name=modNote id=modNote onclick=\"enableAreaByTickbox('modNoteText');\" value=1><br/>
		<textarea name=modNoteText id=modNoteText rows=3 cols=70></textarea><br />";


	echo"<script type=\"text/javascript\">
	//Nasty fix for Chrome (beta chrome..)
 	setTimeout(\"enableAreaByTickbox('modNoteText')\", 100);
 	</script>";

		echo"<input type=submit value='Send'></form>";

		echo"<br /><br />";

		}

}
?>