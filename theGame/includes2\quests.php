<?
$S_user='';
  session_start();
//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");


    if($S_user){
define('AZgaatEU', true );
$datum = date("d-m-Y H:i");


echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
body {
	color:#000000;
}
</style>";
?>
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</HEAD>
<?
echo"<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000>

<center><br />
 <Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td>";

  $sql = "SELECT jobname, dump, joblocation, jobdescription, quest, completed, gatherleft, talkto, location, timelimit, jobgive, jobgivemuch, give, givemuch,type, killsleft, killtype, description  FROM quests LEFT JOIN questslist ON quests.questID=questslist.questID && quests.subID=questslist.subID   WHERE username='$S_user'";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
#JOBS
if($record->type==0){
	if($record->jobname=='The Friddik Brothers'){
	 	$action="Go to $record->dump";
		 $action="$record->jobdescription";  $give="$record->jobgivemuch $record->jobgive"; $last='';
	}elseif($record->jobname=='Thieving guild'){
	 	$action="Thieve $record->dump"; $give="-"; $last='Last seen at:';
	}

	$timeleft=floor(($record->timelimit-time())/60);
	if($record->completed==1){
	 	$timeleft='<B>Completed</b>';
	} elseif($timeleft>=0){
	 	 $timeleft2=($record->timelimit-time())-($timeleft*60); $timeleft="$timeleft minutes $timeleft2 seconds";
	} else {
	 	$timeleft="<B>FAILED</B>";
	}
	$jobs="$jobs<tr><td bgcolor=#9B896D><B><font color=black>$record->jobname<td>$action<td>$last $record->joblocation<td>$give<td>$timeleft";
}else{ #QUESTS
	if($record->completed==1){$color="<font color=green>"; $hint='Completed';} else { $color="<font color=red>";
	$hint=$record->description;
	if($record->gatherleft){
			$hint.=" ($record->gatherleft left)";
	}
	if($record->killsleft>0){ $hint="Kill $record->killsleft ".$record->killtype."(s) at $record->location"; } }
	$quests="$quests<tr><td bgcolor=#9B896D><B>$color $record->quest<td><font color=#E2D3B2>$hint";
}


}

if($quests==''){$quests='<tr><td><B>No quests.</b>';}
if($jobs==''){$jobs='<tr><td><B>No jobs.</b>';}
echo"<B><font color=red>Quests</font></b><hr>
<Table>
<tr bgcolor=#78705E><td><B>Quest<td><B>Hint</B>(Highlight the text below to see a hint)
$quests
</table>
<BR><BR>
<B><font color=red>Jobs</font></b><hr>
<table>
<tr bgcolor=#78705E><td><B>Title<td><B>Action<td><B>Location<td><B>Required item<td>Time left
$jobs
</table>";



echo"<BR>

</td></tr></table><br />
</center>
</body>
</html>";

}else{echo"Not logged in.";} # user
?>