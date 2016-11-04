<?
$S_user=''; $S_donation='';
//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
require_once(GAMEPATH."includes/db.inc.php");
$timee=time();
  session_start();
  define('AZtopGame35Heyam', true );
if($S_user){

echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"PUBLIC\">
<link rel=\"shortcut icon\" href=\"../../favicon.ico\" type=\"image/x-icon\" />
</HEAD>
<style type=\"text/css\">
body {
	color:#000000;
}
</style>
<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000>

<center><br />
 <Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td align=center>";






 echo"<B>Report chat abuse</B><br /><br />You can use this tool for (and only for) reporting chat abuse that has happened within the past 30 minutes.<br /><br />";



$theIgnoreList = array();
    if(isset($_POST['reportList'])){  //<em>(mod)</em>moderator
    	$reportList = substr(htmlentities($_POST['reportList']), 0, 200); //10

		$verifiedList="";
        $theIgnoreListTEMP = explode(',', $reportList);

		foreach($theIgnoreListTEMP as $ignoredPlayerIndex => $ignoredPlayer){
		 	$good=0;
            $sql = "SELECT username FROM users WHERE username='$ignoredPlayer' LIMIT 1";
          	$resultaat = mysqli_query($mysqli,$sql);
          	while ($record = mysqli_fetch_object($resultaat))
		  	{
           		$good=1;
            	$verifiedList=$verifiedList."$record->username,";
        	}
        	if($good!=1 && $ignoredPlayer){
				echo"<font color=red><b>\"$ignoredPlayer\" does not exist, please resolve this (check if there are any spaces at the begin or end of the username).</b></font><br /><br />";
				$verifiedList="";
				break;
			}
        }



    } //if

    if($verifiedList){
    	if($channelW==false && $channel1==false && $channel2==false && $channel3==false && $channel4==false && $channel5==false && $channel6==false){
    		echo"<font color=red><b>You must select at least one channel, please resolve this.</b></font><br /><br />";
			$atLeastOneChannel = 0;
    	}else{
    		$atLeastOneChannel=1;
    	}
    }

    if($verifiedList && $atLeastOneChannel==1){

    	$timeout=time()-300;
    	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM reports WHERE reportedBy='$S_user' && reportTime>$timeout LIMIT 20");
		$aantal = mysqli_num_rows($resultaaat);
		if($aantal<=15){

	    	$channels="";
	    	if($channelW==true){$channels=CHATLOGPATH."chatlogs/whisper/". date("Y_m_d") ."/".strtolower($S_user)."_" . date("Y_m_d") . ".php,".$channels;}
		   	if($channel1==true){$channels=CHATLOGPATH."chatlogs/region/".$S_mapNumber."_" . date("Y_m_d") . ".php,".$channels;}
		   	if($channel2==true){$channels=CHATLOGPATH."chatlogs/world/" . date("Y_m_d") . ".php,".$channels; }
		   	if($channel3==true){

		   				$clantagSplit = str_split($S_clantag);
					  	$clantagASCII = array();
					  	for($ord = 0; $ord < count($clantagSplit); $ord++)
					  	{
					    	$clantagASCII[$ord] = ord($clantagSplit[$ord]);
					  	}
					  	$clantagDIR = CHATLOGPATH . "chatlogs/clan/" . date("Y_m_d") . "/";
					  	$file = $clantagDIR . implode("_", $clantagASCII) . ".php";

				   $channels=$file.",".$channels;
				   }
		   	if($channel4==true){$channels=CHATLOGPATH."chatlogs/trade/" . date("Y_m_d") . ".php,".$channels; }
		   	if($channel5==true){$channels=CHATLOGPATH."chatlogs/help/" . date("Y_m_d") . ".php,".$channels; }
			if($channel6==true && $S_side){$channels=CHATLOGPATH."chatlogs/".strtolower($S_side)."/" . date("Y_m_d") . ".php,".$channels; }

			$theIgnoreList = explode(',', $verifiedList);
			foreach($theIgnoreList as $ignoredPlayerIndex => $ignoredPlayer){
				if(!$ignoredPlayer){
					continue;
				}
				$timeout=time()-600;
				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM reports WHERE abuser='$ignoredPlayer' && channels='$channels' && reportTime>=$timeout && handled=0 LIMIT 1");
	   			$aantal = mysqli_num_rows($resultaaat);
				if($aantal<=0){
					$reportProblem = nl2br(htmlentities($reportProblem));
					$assignedMod='';
					$assignedTime=0;

		          	$resultaat = mysqli_query($mysqli,"SELECT username FROM staffrights WHERE isOnline='1' && onDuty=1 && chatMod=1 && username<>'M2H' ORDER BY RAND() LIMIT 1");
		          	while ($rec = mysqli_fetch_object($resultaat))
				  	{
						$assignedMod=$rec->username;
						$assignedTime=time();

						$SystemMessage=1;
						$chatMessage="$S_user has filed a chat report, you have been assigned to this report. If you do not handle it within 2 minutes another moderator will/can do so.";
						$channel=W;
						$whisperTo=strtolower($assignedMod);
						include("../scripts/chat/addchat.php");
					}


				   	$sql = "INSERT INTO reports (type, reportedBy, abuser, channels, reportReason, reportTime,lastOpened,lastOpenedBy)
							  VALUES ('chat', '$S_user', '$ignoredPlayer', '$channels', '$reportProblem', '$timee', '$assignedTime', '$assignedMod')";
							  mysqli_query($mysqli, $sql) or die("error report6");
				}else{

				}

			}

			echo"<b>Thank you, your report has been added.</b><br /><br />
			The chat moderators will look into it and will do what is necessary. This can be a punishment, a warning or no action at all.<br />";
			echo"<br/>You will receive no further feedback about this report.<br />";


		}else{
			echo"You have added too much reports, and must wait a while before being able to report again.<br />
			This time lock was added to prevent players from spamming reports.<br />
			Please let us know if you were blocked without spamming (via the forums or tickets).<br />";
		}

    }else{

    	echo"<form action='' method='post'>
  		<b>Please enter a comma seperated list of player names to report:</b><br />(no spaces between commas and names e.g. \"Lord Harry,Joe,Bob\"):<br />
  		<br />
  		<textarea name='reportList'  id='reportList' cols=33 rows=1></textarea><br />
	  	<b>Please enter a short and clear description of the problem:</b><br />";
    	echo"<textarea name='reportProblem'   cols=33 rows=4>";
		echo stripslashes(htmlentities($reportProblem));
		echo"</textarea><br />";

	echo"<b>Please select the channels that apply:</b><br /><table><tr><td>";
	echo"<tr><td><input type=checkbox name=channelW value=true> W. Whisper chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel1 value=true> 1. Region chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel2 value=true> 2. World chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel3 value=true> 3. Clan chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel4 value=true> 4. Trade chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel5 value=true> 5. Game help</td></tr>";
	if($S_side){echo"<tr><td><input type=checkbox name=channel6 value=true> 6. Pirate chat</td></tr>"; }
	echo"</table>";

	echo"<input type=submit value='File report'></form><br/>";
	echo"<small>You can be punished for abuse of the report function (including false reports).</small>";


 }





echo"</td></tr></table><br />
</center>
</body>
</html>";
}
?>