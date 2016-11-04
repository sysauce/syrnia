<?
if(defined('AZtopGame35Heyam') && $S_user){

$modforum=0;

$page = htmlentities(trim($page));
$forum = htmlentities(trim($forum));


//40+ chars (normal clans are 40 chars)
if($S_staffRights['multiMod']==1 && $multiforum==1){	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaMulti';  $forumTitle='Multi mod forum';
}else if($S_staffRights['bugsMod']==1 && $bugforum==1){	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaBug';  $forumTitle='Bug mod forum';
}else if($S_staffRights['chatMod']==1 && $chatforum==1){	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaChat';  $forumTitle='Chat mod forum';
}else if($S_staffRights['eventMod']==1 && $eventforum==1){	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaEvents'; $forumTitle='Events mod forum';
}else if($S_staffRights['forumMod']==1 && $forumforum==1){	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaForum'; $forumTitle='Forum mod forum';
}else if($SENIOR_OR_SUPERVISOR==1 && ($oldforum==1 || $forum=='oldforum')){ $forum='oldforum';	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrnia'; 	$forumTitle='S&S mod forum';
}else{	$clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaGeneral';  $forumTitle='General mod forum'; }

$link="?page=$page&forum=$forum";

$smileyPath="../../..";


$colwhite='black';
$colback='white';
echo"<br />";


$color222='85704D';

$color444=B19A68;
$color555=CCB794;
$color666=EFD6AD;
$color777=FBEBC2;
$color888=F8DFB6;
$color999=FBF4D6;


$datum = date("d-m-Y H:i");
$time=time();
$moderator=0;
$HTMLEDIT='';

//EVERYONE IS MOD HERE
$status=''; $moderator=1;



if($S_user){
 $time=time();
	$sql = "SELECT forumban FROM stats WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);   $aantal='a';
	while ($record = mysqli_fetch_object($resultaat)) {
	$S_donation=$S_donation;
	if($record->forumban>$time){  $S_user=''; echo"You have got no access to post on the forum because a moderator denied you access for the next ".ceil(($record->forumban-time())/60)." minutes<BR>";}
	}
}

if($action=='search'){##
################# SEARCH
echo" <center><a href=$link>Back to forum overview</a><BR><BR><B><font color=$colwhite size=3>Search</font></B><BR>
<form action='' method=post>
<input type=text name=searchQ><input type=submit value=Search></form><HR></center>";

if(strlen($searchQ)>=3){
echo"<font color=$colwhite>You search got the following results:</font><BR><table cellpadding=5 cellspacing=0>";
$sql = "SELECT message, username,topic, datum FROM forummessages WHERE clan='$clan' && message like '%$searchQ%' group by topic order by ID desc  LIMIT 50";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {


$sl = "SELECT topic,categorie,locked FROM forumtopics WHERE clan='$clan' && ID='$record->topic' LIMIT 1";
$resultat = mysqli_query($mysqli, $sl);
while ($rec = mysqli_fetch_object($resultat)) {
$topic=stripslashes($rec->topic); $topic = substr ("$topic", 0, 50);
if($rec->locked==1){$locky="<img src=../../layout/lock.gif>"; } else{ $locky=''; }
echo"<tr><Td bgcolor=#E2D3B2 align=left>$locky<a href=$link&action=viewtopic&topic=$record->topic&cat=$rec->categorie>$topic</a>
<Td bgcolor=$color888>$record->username<Td bgcolor=$color777>$record->datum";
  }
}
} # SEARCH
echo"</table></center>";
}elseif($action=='viewcat'){##
######################### VIEW CATEGORIE
$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli, $sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie); if( stristr ($categorie, "Mods") && $moderator<>1){$categorie='';}   }
if($categorie){
echo"<center><font color=$colwhite><B><a href=$link>$forumTitle</a> -> $categorie</font></B><BR><BR>";
if($S_user){echo"<a href=$link&action=addmes&cat=$cat>Add a topic</a>"; } else{ echo"Only users can post topics."; }
echo"<Table cellpadding=3>
<tr><Td bgcolor=E2D3B2 align=right><B>Topic</b><Td bgcolor=$color777><B>Author</b><Td bgcolor=$color555><B>Date</b><Td bgcolor=$color444><B>Last reply</b><Td bgcolor=$color222><B>Reply's</b>";

$sql = "SELECT ID, topic, datum, username, lastreply, sticky, locked FROM forumtopics WHERE clan='$clan' && categorie='$cat' ORDER BY lastreply desc";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$topic=stripslashes($record->topic); $topic = substr ("$topic", 0, 50);

$resultaaat = mysqli_query($mysqli, "SELECT clan FROM forummessages WHERE topic=$record->ID && clan='$clan'");
$aantal = mysqli_num_rows($resultaaat); $aantal=$aantal-1; if($aantal<0){$aantal=0; }
$lastreply=round((time()-$record->lastreply)/60);
$lastreplyhours=floor((time()-$record->lastreply)/3600);
$lastreplyminutes=$lastreply-($lastreplyhours*60);


if($record->locked==1){$locky="<img src=../../../layout/lock.gif>"; } else{ $locky=''; }
if($record->sticky==1){
	echo"<tr><Td bgcolor=E2D3B2 align=left>";
	echo"<img src=../../../layout/sticky.gif>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat><B>$topic</B></a>";
	if($record->lastreply>$S_previouslogintime){echo" <font color=red><small>new</small></font>";}
	echo"<Td bgcolor=$color888>$record->username<Td bgcolor=$color777>$record->datum<Td bgcolor=$color666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=$color555>$aantal";
 } else{
	$newEntry="<tr><Td bgcolor=E2D3B2 align=left>$locky<a href=$link&action=viewtopic&topic=$record->ID&cat=$cat><B>$topic</B></a>";
	if($record->lastreply>$S_previouslogintime){
	 	$newEntry.=" <font color=red><small>new</small></font>";
	}
	$newEntry.="<Td bgcolor=$color888>$record->username<Td bgcolor=$color777>$record->datum<Td bgcolor=$color666>$lastreplyhours Hours, $lastreplyminutes Min ago.<Td bgcolor=$color555>$aantal";
	$dumpie="$dumpie$newEntry";
}
}
echo"$dumpie";
if($aantal=='a' && $dumpie=='' && $lastreply==''){echo"</table>There are no topics posted yet.<BR>"; } else { echo"</table>"; }


} else { echo"This forum category does not exist.<br/>"; }
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
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie);   if(stristr ($categorie, "Mods") && $moderator<>1){$topic='';}  }
$sql = "SELECT locked,topic,sticky FROM forumtopics WHERE clan='$clan' && categorie='$cat' && ID='$topic'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat)) {$topicnaam=stripslashes($record->topic); $locked=$record->locked; $stickied=$record->sticky; }
if($topicnaam && $cat){
echo"<center><font color=$colwhite><a href=$link>Forum</a> -> <a href=$link&action=viewcat&cat=$cat>$categorie</a> -> <B>$topicnaam</B></font><BR><BR>";
if($moderator==1){
if($locked==0){echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&lock=1>Lock this</a> -";
}else{echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&lock=2>Unlock this</a> -";  }
if($stickied==0){echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&sticky=1>Sticky this</a>";
}else{echo"<a href=$link&cat=$cat&topic=$topic&action=viewtopic&sticky=2>Unsticky this</a>";  }
echo"<BR><Br>";
}
if($S_user){
if($locked==0){ echo"<a href=$link&action=addreply&cat=$cat&topic=$topic>Add a reply</a>"; } else { echo"<B><font color=$colwhite>This topic has been closed.</font></b>"; }
} else { echo"Only users can reply.<BR>"; }

if($moderator){
	$filterDeleted="";
}else{
	$filterDeleted="deleted=0 &&";
}
$resultaaat = mysqli_query($mysqli, "SELECT ID FROM forummessages WHERE $filterDeleted clan='$clan' && topic='$topic'");
$replies = mysqli_num_rows($resultaaat);
if ($replies > 25 or $start > 0) { ## MEER PAGES ?

    $pages = ceil($replies / 25);
    $page = 1;
    echo "<br /><br /><B><font color=white>Pages</font>: ";
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


echo "<table width=100% cellpadding=3>";
$a = 0;
if ($start && is_numeric($start)) {
    $start = $start;
} else {
    $start = 0;
}

if($moderator){
	$DELETEDREPLIES="";
}else{
	$DELETEDREPLIES = "deleted=0 &&";
}


$sql = "SELECT ID, datum, username, message, clanTag, status, signature, avatar, modEdit, deleted FROM forummessages WHERE $DELETEDREPLIES clan='$clan' && topic='$topic' ORDER BY ID ASC LIMIT $start, 25";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
	$message=stripslashes($record->message);

	//BB code
	$message = preg_replace ('/'.'\[b\](.*?)\[\/b\]'.'/', '<strong>$1</strong>', $message);
	$message = preg_replace ('/'.'\[u\](.*?)\[\/u\]'.'/', '<u>$1</u>', $message);
	$message = preg_replace ('/'.'\[i\](.*?)\[\/i\]'.'/', '<i>$1</i>', $message);
	$message = preg_replace ('/'.'\[ul\](.*?)\[\/ul\]'.'/', '<ul>$1</ul>', $message);
	$message = preg_replace ('/'.'\[ol\](.*?)\[\/ol\]'.'/', '<ol>$1</ol>', $message);
	$message = preg_replace ('/'.'\[li\](.*?)\[\/li\]'.'/', '<li>$1</li>', $message);
	$message = preg_replace ('/'.'\[strike\](.*?)\[\/strike\]'.'/', '<strike>$1</strike>', $message);
	$message = eregi_replace("([^ <>\"\\-]{100})"," \\1 ",$message);

	$mode='';
	if($record->status<>''){$mode="<u>$record->status</U><BR>"; }

	$siggy=''; $avva='';
	if($record->signature){ $siggy="<HR>$record->signature"; }
	if($record->avatar){ $avva="<img src=\"".$rootPath."../../../images/avatars/$record->username$record->avatar\" width=96 height=96><BR>"; }
	if($record->username==$S_user OR $moderator==1){$del="<a href='$link&action=del&message=$record->ID&cat=$cat' onclick=\"return confirm('Are you sure you want to delete?')\"><p align=right>Delete</a>"; } else{$del='';}
	if($record->username==$S_user OR $moderator==1){$edit="<a href=$link&action=edit&message=$record->ID&cat=$cat>Edit</a>"; } else{$edit='';}

	if($record->deleted==1){
		$color="#FF0000";
		$color2="#FF0000";
	}else{
		$color=$color444;
		$color2=$color666;
	}

	echo"<tr valign=top><Td bgcolor=$color align=left width=130><B>$record->username</B>";
	echo"<br />";
	if($record->clanTag){ echo" [$record->clanTag]<br />";}
	if($record->modEdit){

	$modMessage=$record->modEdit;
	$modMessage = preg_replace ('/'.'\[b\](.*?)\[\/b\]'.'/', '<strong>$1</strong>', $modMessage);
	$modMessage = preg_replace ('/'.'\[u\](.*?)\[\/u\]'.'/', '<u>$1</u>', $modMessage);
	$modMessage = preg_replace ('/'.'\[i\](.*?)\[\/i\]'.'/', '<i>$1</i>', $modMessage);
	$modMessage = preg_replace ('/'.'\[ul\](.*?)\[\/ul\]'.'/', '<ul>$1</ul>', $modMessage);
	$modMessage = preg_replace ('/'.'\[ol\](.*?)\[\/ol\]'.'/', '<ol>$1</ol>', $modMessage);
	$modMessage = preg_replace ('/'.'\[li\](.*?)\[\/li\]'.'/', '<li>$1</li>', $modMessage);
	$modMessage = preg_replace ('/'.'\[strike\](.*?)\[\/strike\]'.'/', '<strike>$1</strike>', $modMessage);
	$modMessage = eregi_replace("([^ <>\"\\-]{100})"," \\1 ",$modMessage);

	$modEdit="<br /><br /><div style=\"border: 1px dashed black;padding: 6px; background-color: #b19a68; margin-left: 10px; margin-right: 10px;\"><b>Moderator edit:</b><br />".nl2br($modMessage)."</div>";
	}else{
		$modEdit='';
	}
	echo"$mode$record->datum<BR>$avva<BR>$edit<br>$del<Td align=left bgcolor=$color2>$message $modEdit $siggy </td></tr>";

	if($firstpost<>1 && $S_donation<2500){#ADD

	?><tr></tr></tr></tdr><tr valign=top><Td bgcolor=<?php echo $color444; ?> align=left width=120>Mr. Addy<BR><i><small>Keeping this game free by adding ads to every topic</small></i><Td align=left bgcolor=<?php echo $color666; ?>>
	<center><script type="text/javascript"><!--
	google_ad_client = "pub-8058836226253609";
	google_alternate_color = "E2D3B2";
	google_ad_width = 468;
	google_ad_height = 60;
	google_ad_format = "468x60_as";
	google_ad_type = "text_image";
	google_ad_channel ="8341130291";
	google_color_border = "<?php echo $color444; ?>";
	google_color_bg = "<?php echo $color444; ?>";
	google_color_link = "FF0000";
	google_color_text = "FFFFFF";
	google_color_url = "FFFFFF";
	//--></script>
	<script type="text/javascript"
	  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script></center>
	<?php $firstpost=1;
	}# ADD


}
echo"</tr></table>";

if ($replies >= 25 or $start > 0) { ## MEER PAGES ?
    $pages = ceil($replies / 25);
    $page = 1;
    echo "<B><font color=white>Pages:</font> ";
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

if($S_user){
if($locked==0){ echo"<a href=$link&action=addreply&cat=$cat&topic=$topic>Add a reply</a>"; } else { echo"<B><font color=$colwhite>This topic has been closed.</font></b>"; }
} else { echo"Only users can reply.<BR>"; }

echo"<br /><br /><center><font color=$colwhite><a href=$link>Forum</a> ->  <a href=$link&action=viewcat&cat=$cat>$categorie</a> -> <B>$topicnaam</B></font><br /><br />";

} else { echo"This topic does not exist (anymore)"; }
}elseif($action=='addmes' && $S_user){##
### ADD TOPIC
$sql = "SELECT categorie, locked FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie); $lockedcat=$record->locked; }
if($lockedcat==0 OR $moderator==1){
if($categorie){
$topic = str_replace ("  " , " ", "$topic");
$topic2 = str_replace (" " , "", "$topic");
if((strlen($topic)>1) && (strlen($topic2)>1) && $message){
$topic = htmlentities(trim($topic));
if($HTMLEDIT<>1){$message = htmlentities(trim($message)); }
$message = nl2br($message);
$bericht=$message;
include('../../includes/forumsmileys.php');
$message=$bericht;
$sql = "INSERT INTO forumtopics (username, datum, lastreply, topic, clan, categorie)
VALUES ('$S_user', '$datum', '$time', '$topic', '$clan', '$cat')";
mysqli_query($mysqli, $sql) or die("3454343");

$sql = "UPDATE stats SET posts=posts+1 WHERE username='$S_user' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  23424231");

$sql = "SELECT ID FROM forumtopics WHERE username='$S_user' && clan='$clan' && datum='$datum' ORDER BY ID DESC LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$TOPID=$record->ID;}

$signature=''; $avatar='';
$sql = "SELECT signature, avatar FROM donators WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$signature=addslashes($record->signature); $avatar=$record->avatar;}

$sql = "INSERT INTO forummessages (username, datum, topic, clan, message, status, signature, avatar)
VALUES ('$S_user', '$datum', '$TOPID', '$clan', '$message', '$status', '$signature', '$avatar')";
mysqli_query($mysqli, $sql) or die("error report this bug please33 66 msg FIXTHIS");

echo"<font color=$colwhite>You message has been posted successfully, <a href=$link&action=viewtopic&topic=$TOPID&cat=$cat>click here to view it</a>.</font>";

} else {
echo"<a href=$link&action=viewcat&cat=$cat>Cancel, return to category</a><BR><BR><table cellpadding=5><tr><td bgcolor=#$color666>
Adding a topic to category: <B>$categorie</B>.<BR>
<form action='' method=post>
<table><tr valign=top><td>Topic<Td><input type=text name=topic>
<tr valign=top><td>Message<td><textarea name=message cols=60 rows=20></textarea>
<tr><td><td><input type=submit value=Submit></form></table>
</table>";
}

} else { echo"No link 1"; }
} else{ echo"This category has been closed to post in <a href=$link&action=viewcat&cat=$cat>Return</a>";}
}elseif($action=='addreply' && $S_user){##
######################### ADD REPLY


$sql = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$cat'";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$categorie=stripslashes($record->categorie);}
$sql = "SELECT topic, locked FROM forumtopics WHERE clan='$clan' && ID='$topic'";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $topicnaam=stripslashes($record->topic); if($record->locked==1){$topicnaam='';}}
if($topicnaam &&  (stristr ($categorie, "Mods")==false OR $moderator )){

if($message){
if($HTMLEDIT<>1){$message = htmlentities(trim($message)); }
$message = nl2br($message);
$bericht=$message;
include('../../includes/forumsmileys.php');
$message=$bericht;
$signature='';$avatar='';
$sql = "SELECT signature, avatar FROM donators WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {$signature=addslashes($record->signature); $avatar=$record->avatar;}
$sql = "INSERT INTO forummessages (username, datum, topic, clan, message, status, signature, avatar)
VALUES ('$S_user', '$datum', '$topic', '$clan', '$message', '$status', '$signature', '$avatar')";
mysqli_query($mysqli, $sql) or die("5435334 FIXTHIS");

$sql = "UPDATE stats SET posts=posts+1 WHERE username='$S_user' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  23424231");

$sql = "UPDATE forumtopics SET lastreply='$time' WHERE ID='$topic' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  asd1");

echo"<font color=$colwhite>You reply has been posted successfully, <a href=$link&action=viewtopic&topic=$topic&cat=$cat>click here to view it</a>.</font>";

} else {
echo"
<a href=$link&action=viewtopic&topic=$topic&cat=$cat>Cancel, return to the topic.</a><BR><BR>
<table cellpadding=5><tr><td bgcolor=#$color666>
Adding a reply to: <B>$topicnaam</B>.<BR>

<form action='' method=post>
<table><tr valign=top><td>Message<td><textarea name=message cols=60 rows=20></textarea>
<tr><td><td><input type=submit value=Submit></form>
</font>";
}

} else { echo"no link 2"; }
}elseif($action=='del' && $S_user){##
######################### DELETE MESSAGE / TOPIC


$IDmes='';
$sql = "SELECT topic, username FROM forummessages WHERE clan='$clan' && ID='$message'";
$resultaat = mysqli_query($mysqli, $sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) { $auth=$record->username; $IDmes=stripslashes($record->topic);}
if($IDmes && $auth==$S_user OR $moderator==1 && $IDmes){

$sql = "UPDATE stats SET posts=posts-1 WHERE username='$auth' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  asd1");

$resultaaat = mysqli_query($mysqli, "SELECT topic FROM forummessages WHERE topic=$IDmes && clan='$clan' && ID<$message");
$aantal = mysqli_num_rows($resultaaat);
if($aantal==0){
 $sql = "DELETE FROM forummessages WHERE topic='$IDmes' && clan='$clan'";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
       $sql = "DELETE FROM forumtopics WHERE ID='$IDmes' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
echo"<font color=white>Your topic has been deleted.</font><BR><a href=$link&action=viewcat&cat=$cat>Click here to return to the category overview</a>";
} else{
  $sql = "DELETE FROM forummessages WHERE ID='$message' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
echo"<font color=white>Your message has been deleted.</font><BR><a href=$link&action=viewtopic&topic=$IDmes&cat=$cat>Click here to return to the topic.</a>";
}

} else { echo"ERROR"; }
}elseif($action=='edit' && $S_user){##
######################### EDIT MESSAGE / TOPIC




$IDmes='';
$sql = "SELECT topic, message, username, modEdit FROM forummessages WHERE deleted=0 && clan='$clan' && ID='$message'";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat))
{
	$auth=$record->username; $messagee=stripslashes($record->message);$IDmes=stripslashes($record->topic); $modEditDBText=$record->modEdit;
}
$resultaat = mysqli_query($mysqli,"SELECT topic FROM forumtopics WHERE clan='$clan' && ID='$IDmes'");
while ($record = mysqli_fetch_object($resultaat))
{
	$topicnaam=stripslashes($record->topic);
}

if($IDmes && $auth==$S_user OR $moderator==1 && $IDmes){
if($messageed){
	if($HTMLEDIT<>1){$messageed = htmlentities(trim($messageed)); }
	$messageed = nl2br($messageed);

	$bericht=$messageed;
	include('../../includes/forumsmileys.php');
	$messageed=$bericht;


	if($moderator==1){
		$modEditNote = htmlentities(trim($modEditNote));
		$modEditTopic = htmlentities(trim($modEditTopic));
		$sql = "UPDATE forummessages SET message='$messageed', modEdit='$modEditNote' WHERE clan='$clan' && ID='$message' LIMIT 1";
		if(strlen($modEditTopic)>=3 && $modEditTopic!=$topicnaam){
			mysqli_query($mysqli,"UPDATE forumtopics SET topic='$modEditTopic' WHERE clan='$clan' && ID='$IDmes' LIMIT 1") or die("error report this bug please  asd1");
		}
	}else{
	 $messageed="$messageed<br /><br />

<small><i>Edited on $datum</i></small>";
		$sql = "UPDATE forummessages SET message='$messageed', clanTag='$S_clantag' WHERE clan='$clan' && ID='$message' LIMIT 1";
	}
	mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
	//$sql = "UPDATE forumtopics SET lastreply='$time' WHERE ID='$IDmes' LIMIT 1";
	//mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");
	echo"<font color=white><b>You have edited successfully, <a href=$link&action=viewtopic&topic=$IDmes&cat=$cat>click here to view it</a>.</b></font>";
	echo"<script type=\"text/javascript\">window.location=\"$link&action=viewtopic&topic=$IDmes&cat=$cat\";</script>";
} else {
	$messagee = str_replace ("<br />" , "", "$messagee");
	$messagee = str_replace ("<i>" , "", "$messagee"); $messagee = str_replace ("</i>" , "", "$messagee");
	$messagee = str_replace (".gif>" , "", "$messagee");
	$messagee = str_replace ("<img src=".$rootPath."layout/smilies/" , "", "$messagee");
	$messagee = str_replace ("<small>" , "", "$messagee");
	$messagee = str_replace ("</small>" , "", "$messagee");

	echo"<a href=$link&topic=$IDmes&cat=$cat&action=viewtopic>Cancel, return to topic.</a><BR><BR>
	<table cellpadding=5><tr><td bgcolor=#$color666>
	Editing your post.<BR>
	<form action='' method=post>
	<table>";

	if($moderator==1){
		echo"<tr valign=top><td>Title<td><textarea name=modEditTopic cols=74 rows=1>$topicnaam</textarea>";
	}

	echo "<tr valign=top><td>Message<td><textarea name=messageed cols=74 rows=20>$messagee</textarea>";

	if($moderator==1){
		echo"<tr valign=top><td>Mod edit note<br />
		<small>Max 250 chars</small><td><textarea name=modEditNote cols=74 rows=3>$modEditDBText</textarea>";
	}

	echo"<tr><td><td><input type=submit value=Submit></form>
	</table>

	</table>";
}
} else { echo"You cannot edit this message"; }
} else{##

######### FORUM OVERVIEW
###########################
if($moderator==1 && $cato && $desco){

$cato = htmlentities(trim($cato));
$desco = htmlentities(trim($desco));
$sql = "INSERT INTO forumcats (clan, categorie, description)
VALUES ('$clan', '$cato', '$desco')";
mysqli_query($mysqli, $sql) or die("76755");
echo"Category $cato added.<BR>";

}
if($moderator==1 && $delcat>0){
       $sql = "DELETE FROM forumcats WHERE ID='$delcat' && clan='$clan' LIMIT 1";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
$sql = "SELECT ID FROM forumtopics WHERE categorie='$delcat' && clan='$clan'";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {
 $sqla = "DELETE FROM forummessages WHERE topic='$record->ID' && clan='$clan'";
      mysqli_query($mysqli, $sqla) or die("error report this bug pleaseMESSAGE");
}
$sqla = "DELETE FROM forumtopics WHERE categorie='$delcat' && clan='$clan'";
      mysqli_query($mysqli, $sqla) or die("error report this bug pleaseMESSAGE");
echo"<B>Category deleted</B><BR>";
}

if($up>0){
$sql = "UPDATE forumcats SET orderid=orderid+1 WHERE clan='$clan' && ID='$up' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  asd1");
} elseif($down>0){
$sql = "UPDATE forumcats SET orderid=orderid-1 WHERE clan='$clan' && ID='$down' LIMIT 1";
mysqli_query($mysqli, $sql) or die("error report this bug please  asd1");
}

echo"<center><B><font size=3 color=$colwhite>Forum</font></B><BR>";
if($S_donation>=2000){ echo"<a href=$link&action=search>Search</a> - "; }
echo"
<a href=\"../rules.php\" onClick='enterWindow=window.open(\"../rules.php\",\"Rules\",
                \"width=600,height=600,top=5,left=5,scrollbars=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\">Rules</a>
                <table border=0 cellpadding=0 cellspacing=0 width=100%>";
$sql = "SELECT ID, categorie, description, orderid FROM forumcats WHERE clan='$clan' && categorie NOT LIKE 'Mods%' ORDER BY orderid desc";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {
$cat=stripslashes($record->categorie);
$descr=stripslashes($record->description);

echo"<tr><Td align=right><a href=$link&action=viewcat&cat=$record->ID><font color=$colwhite size=3><B>$cat</B></font></a></td></tr>
<Tr ><td><Td ><font color=$colwhite><B>$descr</B></font>";
if($moderator==1){ echo"<a href=$link&up=$record->ID>Up</a> - <a href=$link&down=$record->ID>Down</a> ($record->orderid)"; }
echo"</td></tr>
";
}

if($moderator==1){
echo"<tr bgcolor=ff0000 height=4><td><td><td>";
$sql = "SELECT ID, categorie, description FROM forumcats WHERE clan='$clan' && categorie LIKE 'Mods%' ORDER BY orderid desc";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) {
echo"<tr><Td align=right><a href=$link&action=viewcat&cat=$record->ID><font color=$colwhite><B>$record->categorie</b></font></a>
<Tr><td><Td> <font color=$colwhite>$record->description";
}
}


echo"</table><br />
<B><font color=$colwhite>Last 25 reply's grouped by topic</font></B><BR><Table cellpadding=3 cellspacing=0>";
$mes=1;

$sqal = "SELECT ID, topic, categorie, lastreply FROM forumtopics WHERE  clan='$clan' ORDER by lastreply desc LIMIT 30";
$resultaaat = mysqli_query($mysqli, $sqal);
while ($rec = mysqli_fetch_object($resultaaat)) {
	$sql = "SELECT topic, username FROM forummessages WHERE clan='$clan' && topic='$rec->ID' ORDER BY ID DESC LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat)) {
		$sqaal = "SELECT categorie FROM forumcats WHERE clan='$clan' && ID='$rec->categorie' LIMIT 1";
		$resultaaaat = mysqli_query($mysqli, $sqaal);
		while ($reco = mysqli_fetch_object($resultaaaat)) {
		$topic=stripslashes($rec->topic); $topic = substr ("$topic", 0, 50);
		if($rec->categorie=='1919'){ $backcategory="#CDBFA1"; }else{  $backcategory="";}
		echo"<tr bgcolor=$backcategory><td>$reco->categorie<td>-><td>";
		if($rec->lastreply>$S_previouslogintime){echo"<font color=red><small>new</small></font> ";}
		echo"<a href=$link&action=viewtopic&topic=$record->topic&cat=$rec->categorie>$topic";
		echo"<Td>-<Td>$record->username</a>";
		}
	}
}
echo"</table>";


if($moderator==1){

echo"<HR>
<B><font color=$colwhite>Add an category:</font></b><BR>";
echo"<font color=$colwhite><form action='' method=post>
Category: <input type=text name=cato size=10>Description<input type=text name=desco sixe=30><input type=submit value=Add></form></font>
<HR>
<B><font color=$colwhite>Delete an category:</font></b><BR><form action='' method=POST><select name=delcat>";
$sql = "SELECT ID, categorie FROM forumcats WHERE clan='$clan' && ID<>1919";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $categorie=stripslashes($record->categorie);
echo"<option value=$record->ID>-$categorie";
}
echo"</select><input type=submit value=delete></form>";





}


} ## FORUM OVERVIEW

}
?>