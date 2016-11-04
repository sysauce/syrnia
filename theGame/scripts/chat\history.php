<?php
header("Content-Type: text/html;charset=utf-8");

require_once('../../../currentRunningVersion.php');


if(isset($_REQUEST['chatChannel'])){
	$chatChannelArray = explode(",", $_REQUEST['chatChannel']);
} else {
	$chatChannelArray = array("0","1","2");
}

if(isset($_REQUEST['chatType'])){
	$chatType = $_REQUEST['chatType'];
}

// What session vars do we need?
session_start();

unset($S_user);
if(isset($_SESSION['S_user'])){
	$S_user = $_SESSION['S_user'];
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>RPG Syrnia - Chat History</title>
	<style type="text/css">
	body {
		background-color:#333333;
		color:#ffffff;
		font-family: verdana ;
		font-size:11px;
	}
	a {
		color:#ff0000;
	}
	</style>
	</head>
<body>
<p>You must be logged in to view chat history.</p>
</body>
</html>
<?php
die;
}

unset($clantag);
if(isset($_SESSION['S_clantag'])){
	$clantag = $_SESSION['S_clantag'];
}

unset($S_side);
if(isset($_SESSION['S_side'])){
	$S_side = $_SESSION['S_side'];
}

unset($S_staffRights);
if(isset($_SESSION['S_MODLOGIN']) && $_SESSION['S_MODLOGIN']==1){
	if(isset($_SESSION['S_staffRights'])){
		$S_staffRights = $_SESSION['S_staffRights'];
	}
}

unset($status);
if(isset($_SESSION['S_chatTag'])){
	$status = $_SESSION['S_chatTag'];
}

$theIgnoreList='';
if($chatType=='whisper'){
	require_once("../../includes/db.inc.php");

	$sql = "SELECT ignoreList FROM options WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$theIgnoreList = explode(',', addslashes($record->ignoreList));
	}
}

function checkChatChannel($chatLine){

	global $chatChannelArray, $status, $S_side, $clantag, $S_staffRights, $S_mapNumber, $theIgnoreList;

	if(substr($chatLine,1,2) == 99){
		$chatChannelNum = 99;
	}else if(substr($chatLine,1,2) == 98){
		$chatChannelNum = 98;
	}else if(substr($chatLine,1,2) == 97){
		$chatChannelNum = 97;
	}else if(substr($chatLine,1,2) == 96){
		$chatChannelNum = 96;
	}else if(substr($chatLine,1,2) == 95){
		$chatChannelNum = 95;
	}else if(substr($chatLine,1,2) == 90){
		$chatChannelNum = 90;
	} elseif(substr($chatLine,1,2) == 89){
		$chatChannelNum = 89;
	} else {
		$chatChannelNum = substr($chatLine,1,1);
	}

	//echo("<!-- Quit looking at my source! $chatChannelNum $chatChannelArray[0] -->\n");

	if(in_array($chatChannelNum, $chatChannelArray) || $chatChannelNum == 0){

		if($chatChannelNum == 99){
		 	if($S_staffRights['generalChatAccess'] == 1 ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 98){
		 	if($S_staffRights['chatMod'] == 1 ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 97){
		 	if($S_staffRights['forumMod'] == 1 ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 96){
		 	if($S_staffRights['bugsMod'] == 1 ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 95){
		 	if($S_staffRights['multiMod'] == 1 ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 90){
		 	if( ($S_staffRights['chatSeniormod'] || $S_staffRights['leadmod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  || $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor']) ){
				return $chatLine;
			} else{
				return false;
			}
		}

		if($chatChannelNum == 89){
		 	if($S_staffRights['chatMod'] == 1  || $S_staffRights['guideModRights']==1 || $status == 'Guide'){
				return $chatLine;
			} else{
				return false;
			}
		}


		if($chatChannelNum == 9){
			return false;
		}

		if($chatChannelNum == 3){
			$strpos = strpos($chatLine, "<!--C-->");
			$clanTagLen = $strpos - 4;
			$chatClanTag = substr($chatLine, 3, $clanTagLen);
			if($chatClanTag == $clantag){
				return $chatLine;
			} else {
				return false;
			}
		}



		if($chatChannelNum == 6 && (isset($S_side) || $S_staffRights['chatMod'] == 1)){
			if(substr($chatLine, 3, 8) == "<!--P-->" || ($S_staffRights['chatMod'] == 1 && $_REQUEST['type'] == "pirate")){
				$chatChannelSide = "Pirate";
			} elseif(substr($chatLine, 3, 8) == "<!--E-->" || ($S_staffRights['chatMod'] == 1 && $_REQUEST['type'] == "elf")){
				$chatChannelSide = "Elf";
			}
			if($chatChannelSide == $S_side || $S_staffRights['chatMod'] == 1){
				return $chatLine;
			} else {
				return false;
			}
		} elseif($chatChannelNum == 6 && !isset($S_side)){
			return false;
		}

		if($chatChannelNum=='W')
		{
			for($i=0;$theIgnoreList[$i];$i++){
				if(strpos($chatLine, "<strong><u>".$theIgnoreList[$i]) OR strpos($chatLine, "<strong>".$theIgnoreList[$i]) ){
					return false;
				}
			}



		/*	if($playerName=strstr($chatLine, '</u></strong>')){//Donator
				$playerName=strstr($playerName, '<strong><u>');
			}else{
				$playerName=strstr($chatLine, '</strong>', true);
				$playerName=strstr($playerName, '<strong>');
			}

			echo "[$playerName]";

			return array_search('green', $theIgnoreList);

			//<strong><u>edwin</u></strong><em>
			*/
		}

		return $chatLine;
	} else {
		return false;
	}
}

function formatChatChannel(&$chatLine, $chatLineKey){

	global $S_side, $clantag, $S_mapNumber, $chatChannel;


	if(substr($chatLine,1,2) == 99){
		$chatChannelNum = 99;
	}else if(substr($chatLine,1,2) == 98){
		$chatChannelNum = 98;
	}else if(substr($chatLine,1,2) == 97){
		$chatChannelNum = 97;
	}else if(substr($chatLine,1,2) == 96){
		$chatChannelNum = 96;
	}else if(substr($chatLine,1,2) == 95){
		$chatChannelNum = 95;
	}else if(substr($chatLine,1,2) == 90){
		$chatChannelNum = 90;
	} elseif(substr($chatLine,1,2) == 89){
		$chatChannelNum = 89;
	} else {
		$chatChannelNum = substr($chatLine,1,1);
	}

	// Remember to take the rest of these hacks out tomorrow.
	//$chatLine = substr($chatLine,0,strlen($chatLine)-4);
	$chatLine = str_replace("<br>", "", $chatLine);
	$chatLine = str_replace("<br />", "", $chatLine);

	switch($chatChannelNum){
		case '0':
			$chatLine = "<span class=\"SystemChat\">$chatLine</span><br />";
			break;
		case '2':
			$chatLine = "<span class=\"WorldChat\">$chatLine</span><br />";
			break;
		case '4':
			$chatLine = "<span class=\"TradeChat\">$chatLine</span><br />";
			break;
		case '3':
			$chanClanTag = "[3_$clantag]";
			$chatLine = str_replace($chanClanTag, "[3]", $chatLine);
			$chatLine = "<span class=\"ClanChat\">$chatLine</span><br />";
			break;
		case '6':
			$chatLine = "<span class=\"$S_side" . "Chat\">$chatLine</span><br />";
			break;
		case '5':
			$chatLine = "<span class=\"GameHelp\">$chatLine</span><br />";
			break;
		case '1':
			$chanTag = "[1_$S_mapNumber]";
			$chatLine = str_replace($chanTag, "[1]", $chatLine);
			$chatLine = "<span class=\"RegionChat\">$chatLine</span><br />";
			break;
		case 89:
			$chatLine = "<span class=\"GuideChat\">$chatLine</span><br />";
			break;
		case 90:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		case 95:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		case 96:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		case 97:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		case 98:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		case 99:
			$chatLine = "<span class=\"ModChat\">$chatLine</span><br />";
			break;
		default:
			if($chatChannel=='W'){
				$chatLine = "<span class=\"WhisperChat\">$chatLine</span><br />";
			}else{
				$chatLine = "<!-- Error - Switch Default  -->";
			}
			break;
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>RPG Syrnia - Chat History</title>
	<link type="text/css" rel="stylesheet" href="<?php echo SERVERURL."style$S_layout"; ?>.css">
	<style type="text/css">
	body {
		background-color:#333333;
		color:#ffffff;
		font-family: verdana ;
		font-size:11px;
	}
	a:link {
		color:#ff0000;
	}
	a:visited {
		color:#ff0000;
	}


<?php
if (isset($clantag)){
?>
	.ClanChat
	{
		color: #00FF00;
	}
<?php
}
if (isset($S_side)){
echo ("\t.$S_side" . "Chat\n");
?>
	{
		color: orange;
	}
<?php
}
?>

<?php
if((isset($S_staffRights) && ($S_staffRights['guideModRights'] == 1 || $S_staffRights['chatMod'] == 1)) || $S_chatTag == 'Guide'){
?>
	.GuideChat
	{
		color: #FF99CC;
	}
<?php
}
?>
<?php
if(isset($S_staffRights) && $S_staffRights['canLoginToTools'] == 1){
?>
	.ModChat
	{
		color: #DE3163;
	}
<?php
}
?>
	</style>
</head>
<body>
You can filter Chat History by clicking one of the following links:<br />
		<a style="color: #00FFFF" href="./history.php?chatChannel=W&amp;chatType=whisper">W: Whispers</a>
		<a style="color: #FFFFFF" href="./history.php">1: Region Chat</a>
		<a style="color: #dcc290" href="./history.php?chatChannel=2&amp;chatType=world">2: World Chat</a>

<?php
if(isset($clantag)){
		echo("\t\t<a style=\"color: #00FF00\" href=\"./history.php?chatChannel=3&amp;chatType=clan\">3: Clan Chat</a>\n");
}

?>
		<a style="color: #0099CC" href="./history.php?chatChannel=4&amp;chatType=trade">4: Trade Chat</a>
		<a style="color: #FFFF66" href="./history.php?chatChannel=5&amp;chatType=help">5: Help Chat</a>

<?php

if(isset($S_side)){

	if(strtolower($S_side) == "pirate" || $S_staffRights['chatMod'] == 1){
		echo("\t\t<a style=\"color: orange\" href=\"./history.php?chatChannel=6&amp;chatType=pirate\">6: Pirate Chat</a>\n");
	}
	//if(strtolower($S_side) == "elf" || ( $S_staffRights['chatMod'] == 1 && $S_user == "SaucyWhopper")){
	//	echo($S_username);
	//	echo("\t\t<a style=\"color: orange\" href=\"./history.php?chatChannel=6&amp;chatType=elf\">6: Elf Chat (Coming Soon!)</a>\n");
	//}

}

?>

<?php
if((isset($S_staffRights) && ($S_staffRights['guideModRights'] == 1 || $S_staffRights['chatMod'] == 1)) || $S_chatTag == 'Guide'){
echo("\t\t<a style=\"color: #FF99CC\" href=\"./history.php?chatChannel=89&amp;chatType=guide\">89: Guide Chat</a>\n");
}
?>
<?php
if(isset($S_staffRights) && $S_staffRights['generalChatAccess'] == 1){
	echo("\t\t<a style=\"color: #9B30FF\" href=\"./history.php?chatChannel=99&amp;chatType=mod\">99: Mod-General</a>\n");
}
if(isset($S_staffRights) && $S_staffRights['chatMod'] == 1){
	echo("\t\t<a style=\"color: #DE3163\" href=\"./history.php?chatChannel=98&amp;chatType=mod\">98: Mod-Chat</a>\n");
}
if(isset($S_staffRights) && $S_staffRights['forumMod'] == 1){
	echo("\t\t<a style=\"color: #DE3163\" href=\"./history.php?chatChannel=97&amp;chatType=mod\">97: Mod-Forum</a>\n");
}
if(isset($S_staffRights) && $S_staffRights['bugsMod'] == 1){
	echo("\t\t<a style=\"color: #DE3163\" href=\"./history.php?chatChannel=96&amp;chatType=mod\">96: Mod-Bugs</a>\n");
}
if(isset($S_staffRights) && $S_staffRights['multiMod'] == 1){
	echo("\t\t<a style=\"color: #DE3163\" href=\"./history.php?chatChannel=95&amp;chatType=mod\">95: Mod-Multi</a>\n");
}
if(isset($S_staffRights) && ($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  || $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor'])){
	echo("\t\t<a style=\"color: #DE3163\" href=\"./history.php?chatChannel=90&amp;chatType=mod\">90: Mod-S&S</a>\n");
}

	echo"<br /><br />";

	$MAXCHATHISTORYLINES=150;
	if($S_donation>=5500){ //Doubles lines
		$MAXCHATHISTORYLINES*=2;
	}


if(!$chatChannel && !$chatTest){

   	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>1: Region Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}?&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500)
  	{
    	echo("<em><strong>1: Region Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>1: Region Chat</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/region/".$S_mapNumber."_". date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/region/".$S_mapNumber."_". date("Y_m_d") . ".php";
  	}



	if (file_exists($file) && $file_handle = fopen($file,"r")) {
	if (fseek($file_handle, -512000, SEEK_END) != 0) { echo "<!-- Cannot seek.<br /> -->\n"; }
	if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
	fclose($file_handle);
	$file_contents=stripslashes($file_contents);
	$chatHistory = explode("\n", $file_contents); // turn string to array
	//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
	$chatHistory = array_reverse($chatHistory);
	//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
	$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
	while(count($chatHistory) > $MAXCHATHISTORYLINES) {
		array_pop($chatHistory);
	}
	array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
	$file_contents = implode("\n", $chatHistory); // turn array back into a string
	echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}



} elseif ($chatChannel == W) {


  	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>W: Whispers</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500)
  	{
    	echo("<em><strong>W: Whispers</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>W: Whispers</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/whisper/". date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1)  ."/".strtolower($S_user)."_" .  date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/whisper/". date("Y_m_d") ."/".strtolower($S_user)."_" . date("Y_m_d") . ".php";
  	}

	if (file_exists($file) && $file_handle = fopen($file,"r")) {
	if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
	fclose($file_handle);
	//$file_contents=substr ("$file_contents", 0,30000);
	$file_contents=stripslashes($file_contents);
	$chatHistory = explode("\n", $file_contents); // turn string to array
	$chatHistory = array_reverse($chatHistory);
	//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
	$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
	while(count($chatHistory) > $MAXCHATHISTORYLINES) {
		array_pop($chatHistory);
	}
	array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
	$file_contents = implode("\n", $chatHistory); // turn array back into a string
	echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} else if ($chatChannel == 2) {

  	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>2: World Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500)
  	{
    	echo("<em><strong>2: World Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>2: World Chat</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/world/" . date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/world/" . date("Y_m_d") . ".php";
  	}

	if (file_exists($file) && $file_handle = fopen($file,"r")) {
	if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
	fclose($file_handle);
	//$file_contents=substr ("$file_contents", 0,30000);
	$file_contents=stripslashes($file_contents);
	$chatHistory = explode("\n", $file_contents); // turn string to array
	$chatHistory = array_reverse($chatHistory);
	//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
	$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
	while(count($chatHistory) > $MAXCHATHISTORYLINES) {
		array_pop($chatHistory);
	}
	array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
	$file_contents = implode("\n", $chatHistory); // turn array back into a string
	echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}
} else if ($chatChannel == 4) {


  	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>4: Trade Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500){
    	echo("<em><strong>4: Trade Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>4: Trade Chat</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/trade/" . date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/trade/" . date("Y_m_d") . ".php";
  	}


	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,30000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		$chatHistory = array_reverse($chatHistory);
		//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}


} else if ($chatChannel == 3 && isset($_SESSION['S_clantag'])) {

if(!$_SESSION['S_clantag']){
	echo"You are not in a clan at the moment.<br />";
}else{
	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>3: Clan Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500){
    	echo("<em><strong>3: Clan Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>3: Clan Chat</strong></em><br />\n<br />\n");
  	}

  $clantagSplit = str_split($clantag);
  $clantagASCII = array();
  for($ord = 0; $ord < count($clantagSplit); $ord++)
  {
    $clantagASCII[$ord] = ord($clantagSplit[$ord]);
  }

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
  		$clantagDIR = CHATLOGPATH . "chatlogs/clan/" . date("Y_m_"). ((date(d)-1) < 10 ? "0" : "") . (date(d)-1)  . "/";
		$file = $clantagDIR . implode("_", $clantagASCII) . ".php";
 	} else {
    	$clantagDIR = CHATLOGPATH . "chatlogs/clan/" . date("Y_m_d") . "/";
  		$file = $clantagDIR . implode("_", $clantagASCII) . ".php";
  	}

	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (fseek($file_handle, -512000, SEEK_END) != 0) { echo "<!-- Cannot seek.<br /> -->\n"; }
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		//array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}
}

} elseif ($chatChannel == 6 && ($S_side || $S_staffRights['chatMod'] == 1) ) {


  	if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>6: Pirate Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500){
    	echo("<em><strong>6: Pirate Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>6: Pirate Chat</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/pirate/" . date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/pirate/" . date("Y_m_d") . ".php";
  	}

	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,30000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		 echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} elseif ($chatChannel == 5) {


    if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>5: Game Help</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500){
    	echo("<em><strong>5: Game Help</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>5: Game Help</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/help/" . date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/help/" . date("Y_m_d") . ".php";
  	}

	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,30000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} elseif ($chatChannel == 89 && ((($S_staffRights['guideModRights'] == 1 || $S_staffRights['chatMod'] == 1)) || $S_chatTag=='Guide')) {


     if(!isset($_REQUEST['day']) && $S_donation>=7500)
  	{
  		echo("<em><strong>89: Guide Chat</strong></em> - <em><a href=\"{$_SERVER['REQUEST_URI']}&amp;day=-1\">Yesterday</a></em><br />\n<br />\n");
  	} elseif($_REQUEST['day'] == -1 && $S_donation>=7500){
    	echo("<em><strong>89: Guide Chat</strong></em> - Yesterday<br />\n<br />\n");
  	} else {
  		echo("<em><strong>89: Guide Chat</strong></em><br />\n<br />\n");
  	}

	if($_REQUEST['day'] == -1  && $S_donation>=7500)
  	{
    	$file = CHATLOGPATH."chatlogs/guide/" . date("Y_m_") . ((date(d)-1) < 10 ? "0" : "") . (date(d)-1) . ".php";
 	} else {
    	$file = CHATLOGPATH."chatlogs/guide/" . date("Y_m_d") . ".php";
  	}


	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}
} elseif ($chatChannel == 99 && ($S_staffRights['generalChatAccess']==1)) {

	echo("<em><strong>99: Mod-General</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} elseif ($chatChannel == 98 && ($S_staffRights['chatMod']==1)) {

	echo("<em><strong>98: Mod-Chat</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod_chat/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		 echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}
} elseif ($chatChannel == 97 && ($S_staffRights['forumMod']==1)) {

	echo("<em><strong>97: Mod-Forum</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod_forum/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}
} elseif ($chatChannel == 96 && ($S_staffRights['bugsMod']==1)) {

	echo("<em><strong>96: Mod-Bugs</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod_bugs/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} elseif ($chatChannel == 95 && ($S_staffRights['multiMod']==1)) {

	echo("<em><strong>95: Mod-Multi</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod_multi/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n";
	}

} elseif ($chatChannel == 90 && ($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  || $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor'])  ) {

	echo("<em><strong>90: Mod-Seniors&Supervisors</strong></em><br />\n<br />\n");
	$file = CHATLOGPATH."chatlogs/mod_SS/".date("Y_m_d").".php";
	if (file_exists($file) && $file_handle = fopen($file,"r")) {
		if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
		fclose($file_handle);
		//$file_contents=substr ("$file_contents", 0,4000);
		$file_contents=stripslashes($file_contents);
		$chatHistory = explode("\n", $file_contents); // turn string to array
		array_pop($chatHistory);  // remove last line cause it's sometimes screwed up
		$chatHistory = array_reverse($chatHistory);
		$chatHistory = array_filter($chatHistory, "checkChatChannel"); // filter by channel number
		while(count($chatHistory) > $MAXCHATHISTORYLINES) {
			array_pop($chatHistory);
		}
		array_walk($chatHistory, "formatChatChannel"); // walk the array running each line through colourChatChannel
		$file_contents = implode("\n", $chatHistory); // turn array back into a string
		echo($file_contents);
	}else{
		 echo "Cannot open file.If no one has spoken since 00:00 game time this message is normal.<br />\n<br />\n";
	}

} else { // Uh oh :-P

	//echo("Uh oh. You naughty hackers.<br />\n<br />\n");

}

?>

</body>
</html>