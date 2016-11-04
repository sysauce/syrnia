<?php
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


    if (DEBUGMODE){
		echo "<div id=\"testWarning\" style=\"position:fixed;top: 0; background-color: red;color: black; width: 100%\" onclick=\"document.getElementById('testWarning').style.display='none'\"><b><center>YOU ARE USING THE LIVE TEST VERSION OF SYRNIA <small>(Click to close)</small></center></b></div>";
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
<link type=\"text/css\" rel=\"stylesheet\" href=\"style$S_layout.css\">
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
 	position: absolute;
 	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			-1px;
	z-index: 500;
	left:204px;
	right: 172px;
}
#fixedChatHolder{
 	overflow:visible;
	padding-bottom:		0px;
	padding-top:		0px;
	margin-bottom:		0px;
	margin-top:			0px;
	position:absolute;
	z-index: 500;
	left:204px;
	right: 171px;
}


#chatContent{
 	overflow:auto;
	background-color: black;
	height: ".$chatHeightOption."px;
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







if($chatstatus==2){
	$onload="chatSwitch(1);";
}else{
 	$onload="updateChat();";
}

$onload2 = " iDMO('playerInventory'); iWB();";
//$onload2 = "";

echo"<body onload=\"$onload $onload2\" background=\"layout/layout".$S_layout."_BG.jpg\" alink=#FF0000 link=#FF0000 text=#FFFFFF vlink=#FF0000 topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0>";

///BEGIN_LEFTFRAME
echo"<table width=100% height=100% border=0 cellpadding=0 cellspacing=0>";
echo"<tr valign=top><td width=203 align=center valign=top class=\"leftTD\">";

//Begin-Inventory






	$height=225;
	if($inventoryheight>0){$height=$inventoryheight; }

	if($S_disableDragDrop==1){
	 	echo"<div id=\"useItemArea\"></div><div id=\"playerInventory\" style=\"text-align: left;background-color: black;color: white;width:200px;height:".$height."px; border: 0px;overflow:auto\"><font color=white>The game is loading, if this message is not gone after waiting for a while, then there's a problem with your internet browser. Please <a href=\"".GAMEURL."../tickets.php\" target=_blank>contact us</a> for help.</font></div>";
	 }else{
		echo"<table width=185 border=1 cellpadding=0 cellspacing=0>";
		echo"<tr valign=top><td id=\"useItemArea\" width=185 height=35 bgcolor=#330000 align=center valign=middle>Drag an item to this area to use or equip it.</td></tr>
		<tr valign=top><td id=\"playerInventory\" width=185 height=$height bgcolor=#000000><font color=white>The game is loading, if this message is not gone after waiting for a while, then there's a problem with your internet browser. Please <a href=\"".GAMEURL."../tickets.php\" target=_blank>contact us</a> for help.</font></td></tr>
		</table>";
	}


echo "<div id='inventoryStats' style='color: white; text-align: center;'></div>";


//End-inventory

echo"<a href='' onClick='enterWindow=window.open(\"".GAMEURL."includes2/support.php\",\"Support\",
                \"width=850,height=500,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'\">
<font color=white><B>How to <font color=red>support Syrnia</font></B> ?</font></a>";


echo"<table width=187 border=0 cellpadding=0 cellspacing=0 class=\"leftTD\">
<tr><td background=layout/top.gif width=187 height=14 align=center></TD></TR>
<tr><td width=187 height=13><a href=\"".GAMEURL."includes2/options.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/options.php\",\"Options\",
                \"width=500,height=600,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img border=0 src='layout/options.gif'><a></TD></TR>
<tr><td width=187 height=16><a href=\"".GAMEURL."includes2/messages.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/messages.php\",\"\",\"width=600,height=600,top=5,left=5,scrollbars=yes,resizable=yes\"); return false;'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img border=0 src='layout/messages.gif'></a></TD></TR>";

					 echo"<tr><td background=layout/mess.gif height=0 width=187 align=center><div id=messagesCounter></div></TD></TR>";
					 echo($S_donation >= 2500 ? "<tr><td background=layout/mess.gif height=0 width=187 align=center><div><a href=\"".GAMEURL."includes2/events.php\"
                onClick='enterWindow=window.open(\"".GAMEURL."includes2/events.php\",\"\",\"width=600,height=600,top=5,left=5,scrollbars=yes,resizable=yes\"); return false;'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\" style='text-decoration: none;'><span id='eventCounter' style='color: black;'></span></a></div></TD></TR>" : "");

if($S_donation>=3250){
echo"<tr><td width=187 height=14><a href=\"".GAMEURL."includes2/notes.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/notes.php\",\"\",
                \"width=750,height=550,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'><img border=0 src='layout/journal.gif'></a></TD></TR>";
}
echo"<tr><td width=187 height=14><a href=\"".GAMEURL."includes2/quests.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/quests.php\",\"Quests\",\"width=750,height=550,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'><img border=0 src='layout/quests.gif'></a></TD></TR>
<tr><td width=187 height=14><a href=\"".GAMEURL."mainincludes/forum.php?pop=yes\" onClick='enterWindow=window.open(\"".GAMEURL."mainincludes/forum.php?pop=yes\",\"\",
                \"width=750,height=500,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img border=0 src='layout/forumb.gif'></TD></TR>
<tr><td width=187 height=13><a href=\"".GAMEURL."includes2/clan.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/clan.php\",\"\",
                \"width=850,height=550,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img border=0 src='layout/clan.gif'></a></TD></TR>
                <tr><td width=187 height=6 background=layout/mess.gif></TD></TR>
<tr><td width=187 height=14><a href=index.php?page=logout target=_top><img border=0 src=layout/logout.gif></a></TD></TR>";
echo" <tr><td background=layout/bottomSmaller.gif width=187 height=268 align=center valign=top>";

/////////////////////
//// WEARSTATS


echo"<br/>
<table class=\"wearDisplayTD\" id=\"wearDisplayTD\" cellpadding=1 border=0>
	<tr align=right valign=bottom>
		<td width=45 height=45></td>
		<td width=45 height=45 bgcolor=333333 id='displayHelm'></td>
		<td width=45 height=45 id='displayTrophy'></td>
	</tr>
	<tr align=right valign=bottom>
		<td width=45 height=45 bgcolor=333333 id='displayShield'></td>
		<td width=45 height=45 bgcolor=333333 id='displayBody'></td>
		<td width=45 height=45 bgcolor=333333 id='displayHand'></td>
	</tr>
	<tr align=right valign=bottom>
		<td width=45 height=45 ></td>
		<td width=45 height=45 bgcolor=333333 id='displayLegs'></td>
		<td width=45 height=45 bgcolor=333333 id='displayGloves'></td>
	</tr>
	<tr align=right valign=bottom>
		<td width=45 height=45 bgcolor=333333 id='displayHorse'></td>
		<td width=45 height=45 bgcolor=333333 id='displayShoes'></td>
		<td width=45 height=45 ></td>
	</tr>
</table>
<table cellpadding=0 cellspacing=0 class=\"leftTD\">
	<tr><td><b>Armour:</b></td><td id='displayArmour'></td></tr>
	<tr><td><b>Aim:</b></td><td id='displayAim'></td></tr>
	<tr><td><b>Power:</b></td><td id='displayPower'></td></tr>
	<tr><td><b>Travel:</b></td><td id='displayTravelTime'></td></tr>
</table>";


echo"</td></tr>
</table>";





///END_LEFTFRAME
echo"</td><td width=1 bgcolor=000000></td><td bgcolor=#151515 CLASS=\"centerTD\">";
/////////////////////////////////////////
///####################################
//Begin-CENTER


echo"<div id=\"messagePopup\" class=\"popup\">
<div id=\"popupTitle\" class=\"popupTitle\"></div>
<br />
<div id=\"popupMessage\" class=\"popupMessage\"></div>
<div id=\"popupClose\"><center><br /><a href='' onclick=\"$('messagePopup').style.visibility='hidden';return false;\">Close</a></center></div>
</div>";

echo"<table width=100% border=0 cellpadding=0 cellspacing=0 class='centerTable'>"; //height=100%

echo"<tr valign=top><td id='centerContent'>";




echo"</td></tr>";

if(!$disableChatFloat){
	echo"<tr height=".($chatHeightOption+30)."><td height=".($chatHeightOption+30).">";
}else{
	echo"<tr valign=top height=".($chatHeightOption+20)."><td height=".($chatHeightOption+20).">";
}
if($disableChatFloat){
 ////BEGIN CHAT
?>
<div class="chatHolderDisabled" id="chatHolderDisabled">
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
	<input class=input id="chatSend" type=submit value=Send>
	<a href='#' onclick="chatSwitch();return false;" id="chatDisable">Disable Chat</a>
	<a href=index.php?page=manual&m=begin target=_Blank><font color=white>Manual</font></a>
	<a href="<?php echo SERVERURL; ?>/rules.php" onClick='enterWindow=window.open("<?php echo SERVERURL; ?>/rules.php","","width=600,height=600,top=5,left=5,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Rules</a>
	<a href="<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat" onClick='enterWindow=window.open("<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat","","width=200,height=390,top=250,left=500,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Options</a>

<?
echo"<a href=".GAMEURL."scripts/chat/history.php target=_Blank>History</a>";
echo" <a href=\"".GAMEURL."includes2/report.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/report.php?hideMenu=1&p=chat\",\"\",\"width=350,height=400,top=250,left=500,scrollbars=yes\"); return false' onmouseover=\"window.status='Report'; return true;\" onmouseout=\"window.status=''; return true;\">Report</a>";
echo" <a id=popupChat href=\"".GAMEURL."includes2/chat.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/chat.php\",\"\",\"width=750,height=600,top=250,left=500,scrollbars=yes\"); return false' onmouseover=\"window.status='Popup chat'; return true;\" onmouseout=\"window.status=''; return true;\" style=\"visibility: hidden;\">Popup chat</a></form>";
echo"</div>";
echo"</div>";
////END CHAT

}

echo"</td></tr>";

echo"</table>";


////END CENTER
echo"</td><td width=1 bgcolor=000000></td><td width=170 background=layout/layout".$S_layout."_BG.jpg class=\"rightTD\">";
//Begin-right



 echo"<table width=170 border=1>
	<tr><td bgcolor=333333 align=center id=mapContents></td></tr>
	</table><map id=moveMap name=moveMap></map>";



?>
	<!-- Search Google -->
	<center id='googleSearchContainer'>
	<table bgcolor="#000000" >
	<tr><td nowrap="nowrap" valign="top" align="left" height="32">
    <form method="get" action="http://www.google.com/custom" target="google_window"><a href="http://www.google.com/" target=_blank><img src="http://www.google.com/logos/Logo_25blk.gif" border="0" alt="Google" align="middle"></img></a>
	<input type="text" name="q" class=input size="3" maxlength="255" value=""></input>
	<input type="submit" name="sa" class=button value="Search"></input>
	<input type="hidden" name="client" value="pub-8058836226253609"></input>
	<input type="hidden" name="forid" value="1"></input>
	<input type="hidden" name="channel" value="7138009147"></input>
	<input type="hidden" name="ie" value="ISO-8859-1"></input>
	<input type="hidden" name="oe" value="ISO-8859-1"></input>
	<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:333333;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;LH:108;LW:475;L:http://www.syrnia.com/layout/syrnia.jpg;S:http://www.syrnia.com;FORID:1;"></input>
	<input type="hidden" name="hl" value="en"></input></form></td></tr></table>
	</center>
	<!-- Search Google -->
<?


echo"<table width=160 border=0 cellspacing=0 cellpadding=0>
<tr><td bgcolor=333333 align=center height=21><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img src=layout/stats_top.gif alt='Click here to view your stats overview' border=0></a></td></tr>
<tr><td bgcolor=333333 align=center background=layout/stats_body.gif>
<table>
<tr><td align=right><font color=000000><font  id='statsHPText'></font>/<font color=000000 id='statsMaxHPText'></font></font><td align=left><img src=images/heart.gif alt=HP></tr>
<tr><td align=right><font color=000000 id='statsGoldText'></font><td align=left><img src=images/gold_stats.gif alt=Gold ></tr>
<tr><td align=right><font color=000000 id='statsTotalSkillText'></font><td align=left><img src=images/totalskill.gif alt='Total skills'></tr>
<tr><td align=right><font color=000000 id='statsCombatLevelText'></font><td align=left><img src=images/level.gif alt='Combat level'></tr>
<tr><td align=right><font color=000000 id='statsFameText'></font><td align=left><img src=images/famesmall_stats.gif alt='Fame' ></tr>
</table>
<table>";


if($reduceSkillImageSizes==1){
	$imageResizes=" width=25 height=25 ";
}else{
	$imageResizes='';
}

echo"
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/attack.jpg alt=Attack border=0></a>
<td> <font color=000000><font color=black id='attackLevelText'></font><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/defence.jpg alt=Defence border=0></a><td><font color=000000><font color=black id='defenceLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/strenght.jpg alt=Strength border=0></a><td><font color=000000><font color=black id='strengthLevelText'></font>  <td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/health.jpg alt=Health border=0></a><td><font color=000000><font color=black id='healthLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/mining.jpg alt=Mining border=0></a><td><font color=000000><font color=black id='miningLevelText'></font><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/smithing.jpg alt=Smithing border=0></a><td><font color=000000><font color=black id='smithingLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/fishing.jpg alt=Fishing border=0></a><td> <font color=000000><font color=black id='fishingLevelText'></font><Td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/woodcutting.jpg alt=Woodcutting border=0></a><td><font color=000000><font color=black id='woodcuttingLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/constructing.jpg alt=Constructing border=0></a><td> <font color=000000><font color=black id='constructingLevelText'></p><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/trading.jpg alt=Trading  border=0></a><td> <font color=000000><font color=black id='tradingLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/thieving.jpg alt=Thieving border=0></a><td><font color=000000><font color=black id='thievingLevelText'></p><Td><a href=\"".GAMEURL."includes2/stats.php\" title= Speed onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/speed.jpg alt=Speed border=0></a><td><font color=000000><font color=black id='speedLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" title=Cooking onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/cooking.jpg alt=Cooking border=0></a><td><font color=000000><font color=black id='cookingLevelText'></p><td><a href=\"".GAMEURL."includes2/stats.php\" title=Magic onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/magic.jpg alt=Magic border=0></a><td><font color=000000><font color=black id='magicLevelText'></font>
<tr><td><a href=\"".GAMEURL."includes2/stats.php\" title=Farming onClick='enterWindow=window.open(\"".GAMEURL."includes2/stats.php\",\"\",
                \"width=300,height=450,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><img $imageResizes class=imagestats src=images/skills/skills37/farming.jpg alt=Farming border=0></a><td><font color=000000><font color=black id='farmingLevelText'></font>

</td></tr>
</table>
<tr><td height=20 bgcolor=333333 align=center background=layout/stats_bottom.gif> </td></tr>
</table>";



if($S_staffRights['canLoginToTools']==1){
	echo"<br /><a href=\"".GAMEURL."includes2/modnew/main.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/modnew/main.php\",\"\",
        \"width=700,height=700,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
        onmouseover=\"window.status=''; return true;\"
        onmouseout=\"window.status=''; return true;\"><img src=images/pixel.gif width=100 height=30 border=0 alt=1></a><br />";
}

if($DEBUG==1){
	echo"<div id='DebugContent'></div>";
}




 ///end-right
echo"</td></tr></table>";


if(!$disableChatFloat){
////BEGIN CHAT
?>
<div class="chatHolder" id="chatHolder">
<div class="chatContent" id="chatContent">
	<font color=orange>Welcome to Syrnia <?php echo"$S_user"; ?>! The chat is loading.</font>
</div>
<div style="background-color: black; width:100%; height:28; border: 0px;overflow:visible">
	<form onsubmit="postChatMessage();return false;" id="frmChat">
	<?
	echo"<select class=input id=\"chatChannel\" id=chatChannel>";
	echo"<option value=5>5 Game help</option>";
	echo"</select>";
	?>
	<input class=input id="chatMessage" maxlength=150 name="chatMessage" size=35 style="visibility:visible;"  type="text" />
	<input class=input id="chatSend" type=submit value=send>
	<a href='#' onclick="chatSwitch();return false;" id="chatDisable">Disable Chat</a>
	<a href=index.php?page=manual&m=begin target=_Blank><font color=white>Manual</font></a>
	<a href="<?php echo SERVERURL; ?>/rules.php" onClick='enterWindow=window.open("<?php echo SERVERURL; ?>/rules.php","","width=600,height=600,top=5,left=5,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Rules</a>
	<a href="<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat" onClick='enterWindow=window.open("<?php echo GAMEURL; ?>includes2/options.php?hideMenu=1&p=chat","","width=250,height=390,top=250,left=400,scrollbars=yes"); return false' onmouseover="window.status=''; return true;" onmouseout="window.status=''; return true;">Options</a>

<?
echo" <a href=".GAMEURL."scripts/chat/history.php target=_Blank>History</a>";
echo" <a href=\"".GAMEURL."includes2/report.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/report.php?hideMenu=1&p=chat\",\"\",\"width=350,height=400,top=250,left=500,scrollbars=yes\"); return false' onmouseover=\"window.status='Report'; return true;\" onmouseout=\"window.status=''; return true;\">Report</a>";
echo" <a id=popupChat href=\"".GAMEURL."includes2/chat.php\" onClick='enterWindow=window.open(\"".GAMEURL."includes2/chat.php\",\"\",\"width=750,height=600,top=250,left=500,scrollbars=yes\"); return false' onmouseover=\"window.status='Popup chat'; return true;\" onmouseout=\"window.status=''; return true;\" style=\"visibility: hidden;\">Popup chat</a>";
echo"</form></div>";
echo"</div>";
////END CHAT

echo"<script type=\"text/javascript\">
if (window.addEventListener){
	window.addEventListener(\"load\", staticbar, false)
}else if (window.attachEvent){
	window.attachEvent(\"onload\", staticbar)
}else if (document.getElementById){
	window.onload=staticbar
}
</script>";
}


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
	echo"var disableImages=$disableImages;";
	echo"setTimeout(\"updateCenterContents('loadLayout', 1);\",500);";

	if($S_disableDragDrop!=1){
		echo"Droppables.add('wearDisplayTD', {onDrop:function(){  if(lastMovedItemParent.id=='playerInventory'){	useItemNew();	}	}	}	);";
		echo"Droppables.add('useItemArea', {onDrop:function(){  if(lastMovedItemParent.id=='playerInventory'){	useItemNew();	}	}   }	);";
	}

	echo"$('playerInventory').innerHTML='';";
	//echo"setTimeout(\"";
	include('ajax/rebuildInventory.php');
	//echo"\", 2000);";

	if($S_mapNumber==3 || $S_mapNumber==14){
		$_SESSION['S_lastPVPupdate']=$timee-3600;
        $_SESSION['S_lastPVPID']=0;
		echo"if(\$('combatLog')!=null){\$('combatLog').innerHTML=\"\";\$('combatLog').title=\"$timee\";}";
		echo"setTimeout(\"pvpLog('$timee');\", 1000);";
	}
	echo"
	updateCenterContents('reloadChatChannels');
	new Draggable('messagePopup',{scroll:window,handle:'popupTitle',revert:function(element){return false;}});
	setTimeout(\"periodUpdater();\",300000);
	Event.observe('displayHelm', 'mousedown', function(e){ unwearItem('helm'); });
	Event.observe('displayHand', 'mousedown', function(e){ unwearItem('hand'); });
	Event.observe('displayBody', 'mousedown', function(e){ unwearItem('body'); });
	Event.observe('displayShield', 'mousedown', function(e){ unwearItem('shield'); });
	Event.observe('displayLegs', 'mousedown', function(e){ unwearItem('legs'); });
	Event.observe('displayHorse', 'mousedown', function(e){ unwearItem('horse'); });
	Event.observe('displayShoes', 'mousedown', function(e){ unwearItem('shoes'); });
	Event.observe('displayGloves', 'mousedown', function(e){ unwearItem('gloves'); });";
	echo"</script>";

echo"</body>";
echo"</html>"
?>