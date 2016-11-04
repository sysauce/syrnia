<?php

session_start();
$link="clan.php?p=forum";
$smileyPath="../..";

$sql = "SELECT name, tag, pw, changeforum  FROM clans WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$clan=$record->name; $pw=$record->pw; $clantag=$record->tag; $changeforum=$record->changeforum;  }

 if($clan=='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrnia'){ $S_user=''; exit(); }

$color888='888888';
$color777='777777';
$color666='666666';
$color555='555555';


if($S_user && $clan && defined('AZgaatEU')){

//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");

$datum = date("d-m-Y H:i");
$time=time();
$moderator=0;
if($changeforum==1 OR $pw){$moderator=1;}


if($action=='search' && $S_donation>=2000){##
################# SEARCH
echo" <center><a href=$link>Back to forum overview</a><BR><BR><B>Search</B><BR>
<form action='' method=post>
<input type=text name=searchQ><input type=submit value=Search></form><HR>";

if(strlen($searchQ)>=3){
echo"You search got the following results:<BR><table>";
$sql = "SELECT message, username,topic, datum FROM forummessages WHERE clan='$clan' && message like '%$searchQ%' order by ID desc LIMIT 50";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {


$sl = "SELECT topic,categorie,locked FROM forumtopics WHERE clan='$clan' && ID='$record->topic' LIMIT 1";
$resultat = mysqli_query($mysqli,$sl);
while ($rec = mysqli_fetch_object($resultat)) {
$topic=stripslashes($rec->topic); $topic = substr ("$topic", 0, 50);
if($rec->locked==1){$locky="<img src=../../layout/lock.gif>"; } else{ $locky=''; }
echo"<tr><Td bgcolor=#444 align=left>$locky<a href=$link&action=viewtopic&topic=$record->topic&cat=$rec->categorie>$topic</a>
<Td bgcolor=888888>$record->username<Td bgcolor=777777>$record->datum";
  }
}
echo"</table></center>";
} # SEARCH
}elseif($action=='viewcat'){##
######################### VIEW CATEGORIE
$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie);}
if($categorie){
$trail = "<center><B><a href=$link>Forum</a> -> $categorie</B></center>";
echo"$trail<BR><a href=$link&action=addmes&cat=$cat>Add a topic</a><Table width=100%>
<tr><Td bgcolor=#444 align=right><B>Topic</b><Td bgcolor=777777><B>Author</b><Td bgcolor=555555><B>Date</b><Td bgcolor=#444><B>Last reply</b><Td bgcolor=222222><B>Reply's</b>";

$sql = "SELECT ID, topic, datum, username, lastreply, sticky, locked FROM forumtopics WHERE clan='$clan' && categorie='$cat' ORDER BY lastreply desc";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$topic=stripslashes($record->topic); $topic = substr ("$topic", 0, 50);

$resultaaat = mysqli_query($mysqli,"SELECT clan FROM forummessages WHERE topic=$record->ID && clan='$clan'");
$aantal = mysqli_num_rows($resultaaat); $aantal=$aantal-1; if($aantal<0){$aantal=0; }
$lastreply=round((time()-$record->lastreply)/60);
$lastreplyhours=floor((time()-$record->lastreply)/3600);
$lastreplyminutes=$lastreply-($lastreplyhours*60);


if($record->locked==1){$locky="<img src=../../layout/lock.gif>"; } else{ $locky=''; }
if($record->sticky==1){
	echo"<tr><Td bgcolor=#444 align=left>";
	echo"<img src=../../layout/sticky.gif>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat><B>$topic</B></a>";
	if($record->lastreply>$S_previouslogintime){echo" <font color=red><small>new</small></font>";}
	echo"<Td bgcolor=$color888>$record->username<Td bgcolor=$color777>$record->datum<Td bgcolor=$color666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=$color555>$aantal";
 } else{
	$newEntry="<tr><Td bgcolor=#444 align=left>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat><B>$topic</B></a>";
	if($record->lastreply>$S_previouslogintime){
	 	$newEntry.=" <font color=red><small>new</small></font>";
	}
	$newEntry.="<Td bgcolor=$color888>$record->username<Td bgcolor=$color777>$record->datum<Td bgcolor=$color666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=$color555>$aantal";
	$dumpie="$dumpie$newEntry";
}

/*
if($record->locked==1){$locky="<img src=../layout/lock.gif>"; } else{ $locky=''; }
if($record->sticky==1){
echo"<tr><Td bgcolor=#444 align=left>
<img src=../layout/sticky.gif>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat>$topic</a>
<Td bgcolor=888888>$record->username<Td bgcolor=777777>$record->datum<Td bgcolor=666666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=555555>$aantal";
 } else{
$dumpie="<tr><Td bgcolor=#444 align=left>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat>$topic</a>
<Td bgcolor=888888>$record->username<Td bgcolor=777777>$record->datum<Td bgcolor=666666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=555555>$aantal$dumpie";
}
*/
}
echo"$dumpie";
if($aantal=='a' && $dumpie=='' && $lastreply==''){echo"</table>There are no topics posted yet.<BR>"; } else { echo"</table><a href=$link&action=addmes&cat=$cat>Add a topic</a><br/><br/>$trail"; }


} else { echo"Wrong link 1"; }
}elseif($action=='viewtopic'){##
######################### VIEW TOPIC
if($moderator==1 && $lock==2 OR $lock==1  && $moderator==1){
if($lock==2){$lock=0;}
$sql = "UPDATE forumtopics SET locked='$lock' WHERE ID='$topic' && clan='$clan' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");
echo"<B>Un/Locked</B><BR>";
}
if($moderator==1 && $sticky==2 OR $sticky==1 && $moderator==1){
if($sticky==2){$sticky=0;}
$sql = "UPDATE forumtopics SET sticky='$sticky' WHERE ID='$topic' && clan='$clan' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  2111111");
echo"<B>Un/Stickied</B><BR>";
}
$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie);}
$sql = "SELECT locked,topic,sticky FROM forumtopics WHERE clan='$clan' && ID='$topic'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$topicnaam=stripslashes($record->topic); $locked=$record->locked; $stickied=$record->sticky; }
if($topicnaam){
$trail = "<center><a href=$link>Forum</a> -> <a href=$link&action=viewcat&cat=$cat>$categorie</a> -> <B>$topicnaam</B>";
echo"$trail<BR><BR>";
if($moderator==1){
if($locked==0){echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&lock=1>Lock this</a> -";
}else{echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&lock=2>Unlock this</a> -";  }
if($stickied==0){echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&sticky=1>Sticky this</a>";
}else{echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&sticky=2>Unsticky this</a>";  }
echo"<BR><Br>";
}
if($locked==0){ echo"<a href=$link&action=addreply&cat=$cat&topic=$topic>Add a reply</a>"; } else { echo"<B>This topic has been closed.</b>"; }

$resultaaat = mysqli_query($mysqli, "SELECT ID FROM forummessages WHERE clan='$clan' && topic='$topic'");
$replies = mysqli_num_rows($resultaaat);
if ($replies > 25 or $start > 0) { ## MEER PAGES ?

    $pages = ceil($replies / 25);
    $page = 1;
    echo "<br /><br /><B>Pages: ";
    while ($page <= $pages) {
        if ($page > 1) {
            echo "-";
        }
        if(($start+25)/25!=$page){echo " <a href=$link&topic=$topic&cat=$cat&action=$action&start=" . (($page - 1) * 25) . ">";}
		echo"$page";
		if(($start+25)/25!=$page){echo"</a> ";}
        $page++;
    }
    echo "</b><br /><br />";
}


echo "<table width=100%>";
$a = 0;
if ($start && is_numeric($start)) {
    $start = $start;
} else {
    $start = 0;
}
$sql = "SELECT ID, datum, username, message, signature, avatar FROM forummessages WHERE clan='$clan' && topic='$topic' ORDER BY ID ASC LIMIT $start, 25";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {

	 $message=stripslashes($record->message);

	//BB code
	$message = preg_replace ('/'.'\[table\](.*?)\[\/table\]'.'/s', '<table class="innerTable">$1</table>', $message);
	$message = preg_replace ('/'.'\[tr\](.*?)\[\/tr\]'.'/s', '<tr>$1</tr>', $message);
	$message = preg_replace ('/'.'\[th\](.*?)\[\/th\]'.'/s', '<th>$1</th>', $message);
	$message = preg_replace ('/'.'\[td\](.*?)\[\/td\]'.'/s', '<td>$1</td>', $message);
	$message = preg_replace ('/'.'<table class="innerTable"><br \/>'.'/s', '<table class="innerTable">', $message);
	$message = preg_replace ('/'.'<\/table><br \/>'.'/s', '</table>', $message);
	$message = preg_replace ('/'.'<tr><br \/>'.'/s', '<tr>', $message);
	$message = preg_replace ('/'.'<\/tr><br \/>'.'/s', '</tr>', $message);
	$message = preg_replace ('/'.'<th><br \/>'.'/s', '<th>', $message);
	$message = preg_replace ('/'.'<\/th><br \/>'.'/s', '</th>', $message);
	$message = preg_replace ('/'.'<td><br \/>'.'/s', '<td>', $message);
	$message = preg_replace ('/'.'<\/td><br \/>'.'/s', '</td>', $message);
	$message = preg_replace ('/'.'\[b\](.*?)\[\/b\]'.'/', '<strong>$1</strong>', $message);
	$message = preg_replace ('/'.'\[u\](.*?)\[\/u\]'.'/', '<u>$1</u>', $message);
	$message = preg_replace ('/'.'\[i\](.*?)\[\/i\]'.'/', '<i>$1</i>', $message);
	$message = preg_replace ('/'.'\[ul\](.*?)\[\/ul\]'.'/s', '<ul>$1</ul>', $message);
	$message = preg_replace ('/'.'\[ol\](.*?)\[\/ol\]'.'/s', '<ol>$1</ol>', $message);
	$message = preg_replace ('/'.'\[li\](.*?)\[\/li\]'.'/', '<li>$1</li>', $message);
	$message = preg_replace ('/'.'\[strike\](.*?)\[\/strike\]'.'/', '<strike>$1</strike>', $message);


	$sqal = "SELECT pw, changeforum, posts FROM clans WHERE username='$record->username' LIMIT 1";
	$resultaaat = mysqli_query($mysqli,$sqal);
	while ($recoord = mysqli_fetch_object($resultaaat)) { $mode=''; if($recoord->pw OR $recoord->changeforum==1){$mode="<BR>Moderator";}
	$posts="$recoord->posts posts";}

	$siggy=''; $avva='';
	if($record->signature){ $siggy="<HR>".($record->signature); }
	if($record->avatar){ $avva="<img src=\"../../images/avatars/$record->username$record->avatar\" width=96 height=96><BR>"; }
	if($record->username==$S_user OR $moderator==1){$del="<a href='$link&action=del&message=$record->ID&cat=$cat' onclick=\"return confirm('Are you sure you want to delete?')\"><p align=right>Delete</a>"; } else{$del='';}
	if($record->username==$S_user OR $moderator==1){$edit="<a href=$link&action=edit&message=$record->ID&cat=$cat>Edit</a>"; } else{$edit='';}
	echo"<tr valign=top><Td bgcolor=#444 align=left width=120>$record->username<BR>$record->datum<BR>$posts$mode$avva<BR>$edit<br>$del<Td bgcolor=666666>$message$siggy";

}
 echo "</table>";
if ($replies >= 25 or $start > 0) { ## MEER PAGES ?
    $pages = ceil($replies / 25);
    $page = 1;
    echo "<B>Pages: ";
    while ($page <= $pages) {
        if ($page > 1) {
            echo "-";
        }
        if(($start+25)/25!=$page){echo " <a href=$link&topic=$topic&cat=$cat&action=$action&start=" . (($page - 1) * 25) . ">";}
		echo"$page";
		if(($start+25)/25!=$page){echo"</a> ";}
        $page++;
    }
    echo "</b><br /><br />";
}

if($locked==0){ echo"<a href=$link&action=addreply&cat=$cat&topic=$topic>Add a reply</a><br/><br/>$trail"; } else { echo"<B>This topic has been closed.</b>"; }



} else { echo"Wrong link #2"; }
}elseif($action=='addmes'){##
######################### ADD TOPIC
$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$categorie=$record->categorie;}
if($categorie){

$topic = str_replace ("  " , " ", "$topic");
$topic2 = str_replace (" " , "", "$topic");
$message2 = str_replace (" " , "", "$message");
if((strlen($topic)>1) && (strlen($topic2)>1) && $message && (strlen($message2)>1)){
$topic = htmlentities(trim($topic));
$message = htmlentities(trim($message));
$message = nl2br($message);
$bericht=$message;
include('../includes/forumsmileys.php');
$message=$bericht;
$sql = "INSERT INTO forumtopics (username, datum, lastreply, topic, clan, categorie)
VALUES ('$S_user', '$datum', '$time', '$topic', '$clan', '$cat')";
mysqli_query($mysqli,$sql) or die("error report this bug please33 6fds634243 msg  $cat-$clan-$topic ");

$sql = "UPDATE clans SET posts=posts+1 WHERE username='$S_user' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");

$sql = "SELECT ID FROM forumtopics WHERE username='$S_user' && clan='$clan' && datum='$datum' ORDER BY ID DESC LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$TOPID=$record->ID;}

$signature=''; $avatar='';
$sql = "SELECT signature, avatar FROM donators WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$signature=addslashes($record->signature); $avatar=$record->avatar;}
$sql = "INSERT INTO forummessages (username, datum, topic, clan, message, signature, avatar)
VALUES ('$S_user', '$datum', '$TOPID', '$clan', '$message', '$signature', '$avatar')";
mysqli_query($mysqli,$sql) or die("error report this bug please33 da66324 msg");

echo"You message has been posted successfully, <a href=$link&action=viewtopic&topic=$TOPID&cat=$cat>click here to view it</a>.";
echo"<script type=\"text/javascript\">window.location=\"$link&action=viewtopic&topic=$TOPID&cat=$cat\";</script>";

} else {
echo"<a href=$link&action=viewcat&cat=$cat>Cancel, return to category</a><BR><BR>Adding a topic to category: <B>$categorie</B>.<BR>
<form action='' method=post>
<table><tr valign=top><td>Topic<Td><input type=text name=topic>
<tr valign=top><td>Message<td><textarea name=message cols=40 rows=20>".htmlentities(trim(stripslashes($message)))."</textarea>
<tr><td><td><input type=submit value=Submit></form>";
}

} else { echo"Wrong link 3"; }
}elseif($action=='addreply'){##
######################### ADD REPLY
$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie);}
$sql = "SELECT topic, locked FROM forumtopics WHERE clan='$clan' && ID='$topic'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) { $topicnaam=stripslashes($record->topic); if($record->locked==1){$topicnaam='';}}
if($topicnaam){

if($message){
$message = htmlentities(trim($message));
$message = nl2br($message);
$bericht=$message;
include('../includes/forumsmileys.php');
$message=$bericht;

$signature=''; $avatar='';
$sql = "SELECT signature, avatar FROM donators WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$signature=addslashes($record->signature); $avatar=$record->avatar;}
$sql = "INSERT INTO forummessages (username, datum, topic, clan, message, signature, avatar)
VALUES ('$S_user', '$datum', '$topic', '$clan', '$message', '$signature', '$avatar')";
mysqli_query($mysqli,$sql) or die("error report this bug please33 626dsfd msg");

$sql = "UPDATE clans SET posts=posts+1 WHERE username='$S_user' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");

$sql = "UPDATE forumtopics SET lastreply='$time' WHERE ID='$topic' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");

echo"You reply has been posted successfully, <a href=$link&action=viewtopic&topic=$topic&cat=$cat>click here to view it</a>.";
echo"<script type=\"text/javascript\">window.location=\"$link&action=viewtopic&topic=$topic&cat=$cat\";</script>";

} else {
echo"<a href=$link&action=viewtopic&topic=$topic&cat=$cat>Cancel, return to the topic.</a><BR><BR>Adding a reply to: <B>$topicnaam</B>.<BR>
<form action='' method=post>
<table><tr valign=top><td>Message<td><textarea name=message cols=40 rows=20></textarea>
<tr><td><td><input type=submit value=Submit></form>";
}

} else { echo"Wrong link 4"; }
}elseif($action=='del'){##
######################### DELETE MESSAGE / TOPIC
$IDmes='';
$sql = "SELECT topic, username FROM forummessages WHERE clan='$clan' && ID='$message'";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) { $auth=$record->username; $IDmes=stripslashes($record->topic);}
if($IDmes && $auth==$S_user OR $moderator==1 && $IDmes){


$resultaaat = mysqli_query($mysqli,"SELECT topic FROM forummessages WHERE topic=$IDmes && clan='$clan' && ID<$message");
$aantal = mysqli_num_rows($resultaaat);
if($aantal==0){
 $sql = "DELETE FROM forummessages WHERE topic='$IDmes' && clan='$clan'";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
       $sql = "DELETE FROM forumtopics WHERE ID='$IDmes' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
echo"Your topic has been deleted.<BR><a href=$link&action=viewcat&cat=$cat>Click here to return to the category overview</a>";
echo"<script type=\"text/javascript\">window.location=\"$link&action=viewcat&cat=$cat\";</script>";


} else{
  $sql = "DELETE FROM forummessages WHERE ID='$message' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
echo"Your message has been deleted.<BR><a href=$link&action=viewtopic&topic=$IDmes&cat=$cat>Click here to return to the topic.</a>";
echo"<script type=\"text/javascript\">window.location=\"$link&action=viewtopic&topic=$IDmes&cat=$cat\";</script>";

}

} else { echo"Wrong link 5"; }
}elseif($action=='edit'){##
######################### EDIT MESSAGE / TOPIC
$IDmes='';
$sql = "SELECT topic, message, username FROM forummessages WHERE clan='$clan' && ID='$message'";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) { $auth=$record->username; $messagee=stripslashes($record->message);$IDmes=stripslashes($record->topic);}
if($IDmes && $auth==$S_user OR $moderator==1 && $IDmes){
if($messageed){
$messageed = htmlentities(trim($messageed));
$messageed = nl2br($messageed);
$messageed="$messageed<br /><br />

<small><i>Edited on $datum</i></small>";
$bericht=$messageed;
include('../includes/forumsmileys.php');
$messageed=$bericht;
$sql = "UPDATE forummessages SET message='$messageed' WHERE clan='$clan' && ID='$message' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
$sql = "UPDATE forumtopics SET lastreply='$time' WHERE ID='$IDmes' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
echo"You have edited successfully, <a href=$link&action=viewtopic&topic=$IDmes&cat=$cat>click here to view it</a>.";
echo"<script type=\"text/javascript\">window.location=\"$link&action=viewtopic&topic=$IDmes&cat=$cat\";</script>";

} else {     $messagee = str_replace ("<br />" , "", "$messagee");  $messagee = str_replace ("<i>" , "", "$messagee"); $messagee = str_replace ("</i>" , "", "$messagee");
$messagee = str_replace (".gif>" , "", "$messagee");
$messagee = str_replace ("<img src=$smileyPath/layout/smilies/" , "", "$messagee");
$messagee = str_replace ("<small>" , "", "$messagee");
$messagee = str_replace ("</small>" , "", "$messagee");

echo"<a href=$link&topic=$IDmes&cat=$cat&action=viewtopic>Cancel, return to topic.</a><BR><BR>Editing your post.<BR>
<form action='' method=post>
<table><tr valign=top><td>Message<td><textarea name=messageed cols=40 rows=20>$messagee</textarea>
<tr><td><td><input type=submit value=Submit></form>";
}
} else { echo"Wrong link 6"; }
} else{##
######### FORUM OVERVIEW
if($moderator==1 && $cato && $desco){
	$cato = htmlentities(trim($cato));
	$desco = htmlentities(trim($desco));
	$cato2 = str_replace (" " , "", "$cato");
	if(strlen($cato2)>=1){
		$sql = "INSERT INTO forumcats (clan, categorie, description)
		VALUES ('$clan', '$cato', '$desco')";
		mysqli_query($mysqli,$sql) or die("error report this bug please33 sdffds66 msg");
		echo"Category $cato added.<BR>";
	}else{
		echo"The category was not added, as it had an invalid name.<BR>";
	}

}
if($moderator==1 && $delcat>0){
       $sql = "DELETE FROM forumcats WHERE ID='$delcat' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
	$sql = "SELECT ID FROM forumtopics WHERE categorie='$delcat' && clan='$clan'";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat)) {
	 $sqla = "DELETE FROM forummessages WHERE topic='$record->ID' && clan='$clan'";
	      mysqli_query($mysqli,$sqla) or die("error report this bug pleaseMESSAGE");
	}
	$sqla = "DELETE FROM forumtopics WHERE categorie='$delcat' && clan='$clan'";
	      mysqli_query($mysqli,$sqla) or die("error report this bug pleaseMESSAGE");
	echo"<B>Category deleted</B><BR>";
}

if($up>0){
$sql = "UPDATE forumcats SET orderid=orderid+1 WHERE clan='$clan' && ID='$up' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
} elseif($down>0){
$sql = "UPDATE forumcats SET orderid=orderid-1 WHERE clan='$clan' && ID='$down' LIMIT 1";
mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
}

echo"<center><B>Forum</B><BR>
<a href=$link&action=search>Search</a> - <a href=\"\" onClick='enterWindow=window.open(\"../../rules.php\",\"\",
                \"width=500,height=350,top=5,left=5,scrollbars=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\"><font color=white>Rules</font></a><table width=100%>";
$sql = "SELECT ID, categorie, description, orderid FROM forumcats WHERE clan='$clan' ORDER BY orderid desc";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {
$cat=stripslashes($record->categorie);
$descr=stripslashes($record->description);
echo"<tr><Td bgcolor=#444 align=right><a href=$link&action=viewcat&cat=$record->ID>$cat</a>
<Tr><td><Td bgcolor=#444>$descr";
if($moderator==1){ echo"<a href=$link&up=$record->ID>Up</a> - <a href=$link&down=$record->ID>Down</a> ($record->orderid)"; }
}










echo"</table><B>Last 20 reply's grouped by topic</B><BR><Table>";

$sqal = "SELECT ID, topic, categorie FROM forumtopics WHERE  clan='$clan' ORDER by lastreply desc LIMIT 20";
$resultaaat = mysqli_query($mysqli,$sqal);
while ($rec = mysqli_fetch_object($resultaaat)) {
	$sql = "SELECT topic, username FROM forummessages WHERE clan='$clan' && topic='$rec->ID' ORDER BY ID DESC LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat)) {
		$sqaal = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$rec->categorie' LIMIT 1";
		$resultaaaat = mysqli_query($mysqli,$sqaal);
		while ($reco = mysqli_fetch_object($resultaaaat)) {
		$topic=stripslashes($rec->topic); $topic = substr ("$topic", 0, 50);
		$category=$reco->categorie; }
		echo"<tr bgcolor=$backcategory><td>$category<td>-><td><a href=$link&action=viewtopic&topic=$record->topic&cat=$rec->categorie>$topic<Td>-<Td>$record->username</a>";
	}
}
echo"</table>";

if($moderator==1){

echo"<HR>
<B>Add an category:</b><BR>";
echo"<form action='' method=post>
Category: <input type=text name=cato size=10>Description<input type=text name=desco sixe=30><input type=submit value=Add></form>
<HR>
<B>Delete a category:</b><BR><form action='' method=POST><select name=delcat>";
$sql = "SELECT ID, categorie FROM forumcats WHERE clan='$clan'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) { $categorie=stripslashes($record->categorie);
echo"<option value=$record->ID>-$categorie";
}
echo"</select><input type=submit value=delete></form>";





}


} ## FORUM OVERVIEW



} # LOGGED IN
?>