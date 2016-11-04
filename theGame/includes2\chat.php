<?php
//GAMEURL, SERVERURL etc.
require_once ("../../currentRunningVersion.php");

header("Content-Type: text/html;charset=utf-8");
session_start();

$S_user=$_SESSION['S_user'];
$S_lastrefresh=$_SESSION['S_lastrefresh'];
$S_drunk=$_SESSION['S_drunk'];
$S_debug=$_SESSION['S_debug'];
$S_modchat=$_SESSION['S_modchat'];
$S_modforum=$_SESSION['S_modforum'];
$S_lastrefresh=$_SESSION['S_lastrefresh'];
if (!defined('GAMEPATH'))
{
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/?hackattempt");
    exit();
}

// Require generic functions.
require_once(GAMEPATH . "includes/db.inc.php");

if (mysqli_connect_errno())
{
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/?dberror");
    exit();
}
define('AZtopGame35Heyam', true );

$timee=time();
$datum = date("d-m-Y H:i");



if(!$S_user){
	header( "Location: ./index.php?page=logout&why=$why&p=$S_user&error=noUser" );
	exit();
}

if($S_user=='M2H' || $S_user=='Edwin'){
	$DEBUG=1;
}



//Center stuff
	$sql = "SELECT loggedin, lastaction,chat,inventoryheight FROM stats WHERE username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$lastaction=$record->lastaction;
		$chatstatus=$record->chat;
		$inventoryheight=$record->inventoryheight;
	}

	$sql = "SELECT chatHeight, disableChatFloat,disableImages,reduceSkillImageSizes FROM options WHERE username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$chatHeightOption=$record->chatHeight;
		$disableChatFloat=$record->disableChatFloat;
		$disableImages=$record->disableImages;
		$reduceSkillImageSizes=$record->reduceSkillImageSizes;
	}


//End center

//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
//<html lang="en">
?>
<html lang="en">
<head>
  	<title>Syrnia, the online textbased RPG</title>
  	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/lib/prototype.js"; ?>" type="text/javascript"></script>

	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/effects.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/dragdrop.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/controls.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/slider.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/sound.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/unittest.js"; ?>" type="text/javascript"></script>


	<script src="<?php echo GAMEURL."scriptaculous-js-1.8.3/src/scriptaculous.js"; ?>" type="text/javascript"></script>

	<?
		echo"<script src=\"".GAMEURL."scripts/itemScripts_D.php\" language=\"JavaScript\" type=\"text/javascript\"></script>";
	?>

	<script src="<?php echo GAMEURL."scripts/centerContentScripts.php";?>" language=\"JavaScript\" type="text/javascript"></script>
	<script src="<?php echo GAMEURL."scripts/chatScript.php";?>" language=\"JavaScript\" type="text/javascript"></script><script type="text/javascript">
		function disableSelection(target){
		if (typeof target.onselectstart!="undefined")
			target.onselectstart=function(){return false}
		else if (typeof target.style.MozUserSelect!="undefined")
			target.style.MozUserSelect="none"
		else
			target.onmousedown=function(){return false}
			target.style.cursor = "default"
		}
		//Globals
		var showPVPDropList = false;
		var droppedItemsCount = 0;
		var updatingTrade=0;
		var JSdump1=0;
		var JSdump2=0;
		<?
		if($S_disableDragDrop){
			echo"var disableDragDrop=$S_disableDragDrop;";
		}else{
			echo"var disableDragDrop=0;";
		}
		?>
	</script>
<?php
echo"<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"PUBLIC\">
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
.centerTD {
 color: white;
}
#useItemArea {
	color:white;
}
.leftTD {
 color: #000000;
}
.rightTD {
 color: #000000;
}
.wearDisplayTD {
 color: #FFFFFF;
}
.useArea {
 color: #FFFFFF;
}
.Moven {
	border : 0px solid #000000;
	color : #ffffff;
	font-size : 30px;
	font-family : Verdana;
	font-weight: bold;
}
div.pvpCombatLog {
  border-width: 1px;
  border-color: #666666;
  border-style: dashed;
}
body{
 	height:100%;
 	width:100%;
    background-color:#000;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
}

#frmChat{
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
}
.popup {
  	border-width: 1px;
  	border-color: #666666;
  	border-style: solid;
 	background-color: black;
	position: absolute;
	left: 300px;
	top: 200px;
	width: 250px;
	visibility: hidden;
	z-index: 999;
}
.popupTitle {
 	background-color: #333333;
}
.popupMessage {
  	width: 95%;
 	margin-left: auto;
	margin-right: auto;
}
#chatHolder{
 	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	z-index: 500;
}
#fixedChatHolder{
 	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	position:absolute;
	z-index: 500;
}


#chatContent{
 	overflow:auto;
	background-color: black;
	height: 500px;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	width: 100%;
    word-wrap: break-word;
}


";
	/*//
		position: absolute;
	bottom: 0;
	left: 203px;
	right: -171px;
	*/

	//this fixed the flashy scrolling for FF
	//body > div#chatHolder {
//     /* used by Netscape6+/Mozilla, Opera 5+, Konqueror, Safari, OmniWeb 4.5+, ICEbrowser */
//     position: fixed;
//}

	if($S_staffRights['canLoginToTools']==1 OR $S_chatTag=='Mod' OR $S_chatTag=='Admin' OR $S_chatTag=='Guide') {
		echo".GuideChat
		{
			color: #FF99CC;
		}";
	}
	if($S_staffRights['chatMod']==1 || $S_staffRights['forumMod']==1 || $S_staffRights['multiMod']==1) {
		echo".ModChat
		{
		   /*  COLOR: #8300FE; */
			color: #DE3163;
		}";
		echo".ModChatAlt
		{
			color: #B20537;
		}";
		//#99
		echo".ModChatAlt2
		{
			color: #9B30FF;
		}";
	}



echo"
</style>";

?>
<!--[if !IE]>-->
<style type="text/css">
#chatHolderDisabled{
 	position: absolute;
	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	z-index: 500;
	left:204px;
	right: 170px;
}
</style>
<!--<![endif]-->
<!--[if IE]>
<style type="text/css">
#chatHolderDisabled{
	position: absolute;
	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	z-index: 500;
	left:204px;
	right: 170px;
	width:100%;
}
</style>
<![endif]-->
<?
echo"</head>";

$onload="updateChat();";

$onload2 = "";

echo"<body onload=\"$onload $onload2\" background=\"layout/layout".$S_layout."_BG.jpg\" alink=#FF0000 link=#FF0000 text=#FFFFFF vlink=#FF0000 topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0>";

 ////BEGIN CHAT
?>
<div class="chatContent" id="chatContent">
	<font color=orange>Welcome to Syrnia <?php echo"$S_user"; ?>! The chat is loading.</font>
</div>
<div style="background-color: black; width:100%; height:20px; border: 0px;overflow:visible">
	<form onsubmit="postChatMessage();return false;" id="frmChat">
	<?
	echo"<select class=input id=\"chatChannel\" id=chatChannel>";
		echo"<option value=5>5 Game help</option>";
	echo"</select>";
	?>
	<input class=input id="chatMessage" maxlength=150 name="chatMessage" size=35 style="visibility:visible;"  type="text" />
	<input class=input type=submit value=Send>
	<a href=index.php?page=manual&m=begin target=_Blank><font color=white>Manual</font></a>
	<a href="<?php echo SERVERURL; ?>/rules.php" onClick='enterWindow=window.open("<?php echo SERVERURL; ?>/rules.php","","width=600,height=600,top=5,left=5,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Rules</a>
	<a href="<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat" onClick='enterWindow=window.open("<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat","","width=200,height=390,top=250,left=500,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Options</a>

<?
echo" <a href=".GAMEURL."scripts/chat/history.php target=_Blank>History</a>";
echo" <a href=\"".GAMEURL."includes2/report.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/report.php?hideMenu=1&p=chat\",\"\",\"width=350,height=400,top=250,left=500,scrollbars=yes\"); return false' onmouseover=\"window.status='Report'; return true;\" onmouseout=\"window.status=''; return true;\">Report</a></form>";
echo"</div>";
////END CHAT



/////////////////////////////////////////////
//Setup all ajax stuff via this script, just once
echo"<script type=\"text/javascript\" src=\"".GAMEURL."/scripts/setupMainscreen.php?".($timee/100)."\"></script>
<script type=\"text/javascript\">;";

	echo"if (screen.width>1024){
		//Enlarge charbar width for higher resolutions... everyone should use 1024+ ;)
		\$('chatMessage').size=60;
	}";

	if($DEBUG==1){
		echo"var DEBUGMODE=1;";
	}else{
		echo"var DEBUGMODE=0;";
	}
	echo"setTimeout(\"updateCenterContents('loadLayout', 1);\",500);";

	echo"
	updateCenterContents('reloadChatChannels');
	new Draggable('messagePopup',{scroll:window,handle:'popupTitle',revert:function(element){return false;}});
	setTimeout(\"periodUpdater();\",300000);";
	echo"</script>";

echo"</body>";
echo"</html>"
?>