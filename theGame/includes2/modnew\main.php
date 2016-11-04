<?
$S_user=''; $S_staffRights=''; $S_MODLOGIN='';
require_once("../../includes/db.inc.php");
include_once('../../../currentRunningVersion.php');
if (mysqli_connect_errno())
{
    exit();
}
session_start();
$timee=$time=time();
define('AZtopGame35Heyam', true );
$datum = date("d-m-Y H:i");

//Functions
include('../../ajax/includes/functions.php');

function modlog($player, $action, $reason, $timer, $timee, $moderator, $modip, $reportID){
	 global $mysqli;
	 $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP, reportID)
         VALUES ('$player', '$action', '$reason', '$timer', '$timee', '$moderator', '$modip', '$reportID')";
      mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
}




if($S_user && is_array($S_staffRights) && $S_staffRights['canLoginToTools']==1){ ## USER EN MODD



if($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor'] || $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor'] || $S_staffRights['leadmod']){
  	$SENIOR_OR_SUPERVISOR=1;
}else{
 	$SENIOR_OR_SUPERVISOR=0;
}



if($neem==date(H) ){

 	// Lets check if the user is a Mod?
    $S_staffRights = "";
    $resulteaat = mysqli_query($mysqli,
        "SELECT freeDonation, canLoginToTools, guideModRights, eventModRights, chatMod, chatSeniormod, chatSupervisor ,forumMod ,	forumSeniormod ,	forumSupervisor, 	bugsMod ,generalChatAccess,	bugsSeniormod ,	bugsSupervisor, 	multiMod ,	multiSeniormod ,	multiSupervisor,manualEditRights, leadmod FROM staffrights WHERE username='$S_user' LIMIT 1");
    while ($rec = mysqli_fetch_object($resulteaat))
    {
        $S_staffRights['generalChatAccess'] = $rec->generalChatAccess;
        $S_staffRights['canLoginToTools'] = $rec->canLoginToTools;
        $S_staffRights['guideModRights'] = $rec->guideModRights;
        $S_staffRights['eventModRights'] = $rec->eventModRights;
        $S_staffRights['chatMod'] = $rec->chatMod;
        $S_staffRights['chatSeniormod'] = $rec->chatSeniormod;
        $S_staffRights['chatSupervisor'] = $rec->chatSupervisor;
        $S_staffRights['forumMod'] = $rec->forumMod;
        $S_staffRights['forumSeniormod'] = $rec->forumSeniormod;
        $S_staffRights['forumSupervisor'] = $rec->forumSupervisor;
        $S_staffRights['bugsMod'] = $rec->bugsMod;
        $S_staffRights['bugsSeniormod'] = $rec->bugsSeniormod;
        $S_staffRights['bugsSupervisor'] = $rec->bugsSupervisor;
        $S_staffRights['multiMod'] = $rec->multiMod;
        $S_staffRights['multiSeniormod'] = $rec->multiSeniormod;
        $S_staffRights['multiSupervisor'] = $rec->multiSupervisor;
        $S_staffRights['manualEditRights'] = $rec->manualEditRights;
		$S_staffRights['leadmod'] = $rec->leadmod;


    }
    $_SESSION["S_staffRights"] = $S_staffRights;

	$S_MODLOGIN=1;
	$_SESSION["S_MODLOGIN"] = $S_MODLOGIN;

	mysqli_query($mysqli, "UPDATE staffrights SET lastOnline='$timee', isOnline=1 WHERE username='$S_user' LIMIT 1") or die("e2rro43r2 --> 1  $mute][$mutetime");


		echo"<script language=\"JavaScript\">
		window.opener.updateCenterContents('reloadChatChannels');
		</script>";

	if($S_user!='M2H'){
		if($S_staffRights['chatMod'] && (!$SENIOR_OR_SUPERVISOR OR $S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor']  )   ){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user has logged in to Mod Tools.";  $channel=98;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['forumMod'] && (!$SENIOR_OR_SUPERVISOR OR $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  )   ){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user has logged in to Mod Tools.";  $channel=97;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['bugsMod'] && (!$SENIOR_OR_SUPERVISOR OR $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor']  ) ){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user has logged in to Mod Tools.";  $channel=96;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['multiMod'] && (!$SENIOR_OR_SUPERVISOR OR $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor']  ) ){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user has logged in to Mod Tools.";  $channel=95;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if(!$channel){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user has logged in to Mod Tools (Not in any department!)";  $channel=90;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
	}else{
		### ADD CHAT MESSAGE
		$SystemMessage=1;
		$chatMessage="$S_user has logged in to Mod Tools.";  $channel=90;
		include("../../scripts/chat/addchat.php");
		### EINDE CHAT MESSAGE
	}

}else if($do=='logout'){
 	mysqli_query($mysqli, "UPDATE staffrights SET isOnline=0 WHERE username='$S_user' LIMIT 1") or die("e2rro43r2 --> 1  $mute][$mutetime");

	if($S_user!='M2H'){
		if($S_staffRights['chatMod']){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user  has logged out of Mod Tools.";  $channel=98;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['forumMod']){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user  has logged out of Mod Tools.";  $channel=97;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['bugsMod']){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user  has logged out of Mod Tools.";  $channel=96;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if($S_staffRights['multiMod']){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user  has logged out of Mod Tools.";  $channel=95;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
		if(!$channel){
			### ADD CHAT MESSAGE
			$SystemMessage=1;
			$chatMessage="$S_user  has logged out of Mod Tools (Not in any department!)";  $channel=90;
			include("../../scripts/chat/addchat.php");
			### EINDE CHAT MESSAGE
		}
	}else{
		### ADD CHAT MESSAGE
		$SystemMessage=1;
		$chatMessage="$S_user  has logged out of Mod Tools.";  $channel=90;
		include("../../scripts/chat/addchat.php");
		### EINDE CHAT MESSAGE
	}

	$S_MODLOGIN='';
	$_SESSION["S_MODLOGIN"] = $S_MODLOGIN;
}




if($S_MODLOGIN){


if($S_staffRights['manualEditRights']==1){

			################
	## CRAZY STUFF VAN FCEDITOR
	####################
		if ( isset( $_POST ) )
   $postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
   $postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	$postedValue =  stripslashes( $value );

	if($sForm=='page'){ $page=$postedValue; }
	elseif($sForm=='manual'){ $manual=$postedValue; }
	else{$inhoudMANUAL=$postedValue;   }

}
#  $page  $tekst
#echo"$page-$tekst";
###########


}


echo"
<html>
<HEAD><TITLE>Syrnia MOD</TITLE>
<style type=\"text/css\">
      TABLE{
      font-size:13px;
      word-spacing:0.4px;
       font-family: verdana ;
      }
      body {
      font-family: verdana ;
        word-spacing:0.4px;
      font-size:13px;
      }
      .form {
	      border : 1px solid #000000;
	      background-color : #FFFFFF;
	      color : #000000;
	      font-size : 9px;
	      font-family : Verdana;
	      font-weight: bold;
      }
      </style>
 <META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"PUBLIC\">
 <META NAME=\"ROBOTS\" CONTENT=\"noindex,nofollow\">
   	<script src=\"".GAMEURL."scriptaculous-js-1.8.3/lib/prototype.js\" type=\"text/javascript\"></script>
	<script src=\"".GAMEURL."scriptaculous-js-1.8.3/src/scriptaculous.js\" type=\"text/javascript\"></script>
</HEAD><body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 link=blue alink=blue vlink=blue>
<table width=100% height=100% cellpadding=10 cellspacing=0>
<tr><td height=114 background=mod.jpg>
<tr valign=top><td bgcolor=E2D3B2><B>You make Syrnia possible so it can entertain hundreds of people every day, thank <u>you</u>!</B><BR>";

 if($page==''){ echo"<font color=red>Please ensure your Syrnia password is unguessable and don't use it anywhere else!<br/>
 Also make sure it's not related to any hobby of yours as people can guess it.</font>";}

echo"<table width=100%><tr valign=top><td width=60><img src=gn1.jpg align=left><td width=10>";

echo"<td><ul>";
if($S_staffRights['chatMod'] || $S_staffRights['multiMod']){ echo"<li><a href=?page=chat><small>Chat mod options</small></a><BR>"; }
if($S_staffRights['forumMod'] || $S_staffRights['multiMod']){ echo"<li><a href=?page=forumMod><small>Forum mod options</small></a><BR>"; }
if($S_staffRights['bugsMod']){ echo"<li><a href=?page=bugMod><small>Bug mod options</small></a><BR>"; }
if($S_user=='M2H' || $S_user=='Hazgod'){ echo"<li><a href=?page=devMod><small>Dev options</small></a><BR>"; }
if($S_staffRights['multiMod'] || $S_staffRights['leadmod']==1 ){ echo"<li><a href=?page=multi><small>Multi mod options</small></a><BR>"; }
if($S_staffRights['eventModRights']){ echo"<li><a href=?page=eventstools><small>Events/tools mod options</small></a><BR>"; }
if($S_staffRights['manualEditRights']){ echo"<li><a href=?page=manuals><small>Manuals</small></a><BR>"; }

echo"</ul></td>";

echo"<td><ul>";
	if($SENIOR_OR_SUPERVISOR && ($S_user=='M2H' OR $S_user=='edwin') ){ echo"<li><a href=?page=m2h><small>M2H</small></a><BR>"; }
	if($S_staffRights['guideModRights']){ echo"<li><a href=?page=playerguides><small>Player Guides</small></a><BR><br />"; }

	if($SENIOR_OR_SUPERVISOR || $S_staffRights['multiMod']){ echo"<li><a href=?page=messages><small>Player messages</small></a><BR>";  }
	if($SENIOR_OR_SUPERVISOR){ echo"<li><a href=?page=log><small>Mod log</small></a><BR>";  }
	if($SENIOR_OR_SUPERVISOR){ echo"<li><a href=?page=staff><small>Complete staff list</small></a><BR>";  }
	if($SENIOR_OR_SUPERVISOR){ echo"<li><a href=?page=sstools><small>General S&S tools</small></a><BR>";  }
	if($SENIOR_OR_SUPERVISOR){ echo"<li><a href=?page=onlinelist><small>Users online</small></a><BR>"; }
	if($SENIOR_OR_SUPERVISOR){ echo"<li><a href=?page=oldforum><small>S&S mod forum</small></a><BR>"; }
echo"</ul></td>";

echo"<td><ul>";

echo"<li><a href=?page=tickets><small>Tickets</small></a><BR>";
echo"<li><a href=?page=forum><small>General mod forum</small></a><BR>";
echo"<li><a href=?page=dep_Staff><small>Department(s) staff list</small></a><BR>";
echo"<br /><li><a href=?do=logout><small>Logout</small></a><BR>";
echo"</ul></td>";

echo"<td width=10><td width=60><img src=gn2.jpg align=left></td></tr></table><hr />";

if($page==''){$page='chat';}
if($page=='oldforum'){$page='forum'; $oldforum=1;}
if($page=='multi'  OR $page=='onlinelist' OR $page=='dep_Staff'  OR $page=='forum' OR $page=='bugMod'  OR $page=='forumMod' OR $page=='messages'  OR $page=='tickets' OR $page=='log' OR $page=='playerguides' OR $page=='bugs' OR $page=='sstools'  OR $page=='chat' OR $page=='m2h' OR $page=='manuals' OR $page=='eventstools' OR $page=='forum' OR $page=='staff' OR $page=='devMod'){
	include("includes/$page.php");
}


echo"</table>";

}else{

	echo"<br /><br />
	<br /><center>
	<form action='' method=post><input type=password name=neem>
	<input type=submit value='ok'>
	</form>
	</center>";

}


}else{## USER EN MOD
	exit();
}
?>