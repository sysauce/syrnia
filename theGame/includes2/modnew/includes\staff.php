<?
if(defined('AZtopGame35Heyam') && $S_MODLOGIN==1 && $SENIOR_OR_SUPERVISOR==1){


function displayAbility($nummer, $name, $field, $edit, $save){
	global $mysqli;
	
	if($edit)
	{		
		if($save)
		{
			$on = isset($_POST["$name-$field"]) ? 1 : 0;
		
			if(($nummer != $on))
			{
				$sql = "UPDATE staffrights SET $field = $on WHERE username = '$name'";
				//echo "<br/><br/>|$sql|<br/><br/>";
				mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs3 $sql");
				$nummer = $on;
			}
		}
		return "<td><input type='checkbox' name='$name-$field'" . ($nummer==1? " checked='checked'" : "") . " value='1'></td>";
	}
	else
	{
		if($nummer==1)
		{
			return "<td bgcolor=green>Yes</td>";
		}
		else
		{
			return "<td bgcolor=red>No</td>";
		}
	}
}

echo"<b></b><br/>";

if($S_user=='Hazgod')
{
	if($edit)
	{
		echo "<a href=?page=staff><small>View</small></a><br/><br/>";
		
		echo "<form action='?page=staff&edit=1" . ($editFormerMods ? "&editFormerMods=1" : "") . "' method=post><input type='hidden' name='save' value='1'>";
	}
	else
	{
		echo "<a href=?page=staff&edit=1><small>Edit</small></a> | ";
		echo "<a href=?page=staff&edit=1&editFormerMods=1><small>Edit former mods</small></a><br/><br/>";
	}
}

	echo"<table border=1>";
	echo"<tr><td>Name</td><td ><b>Last mod login</b></td>";
	
	echo"<td width=20>can login to mod Tools</td><td width=20>#99 access</td><td width=20>guide Mod</td><td width=20>Events</td><td width=20>chat mod</td><td width=20>chat Senior</td><td width=20>chat Supervisor</td><td width=20>forum mod</td><td width=20>forum senior</td><td width=20>forum supervisor</td><td width=20>bugs mod</td><td width=20>bugs senior</td><td width=20>bugs supervisor</td><td width=20>multi mod</td><td width=20>multi seniormod</td><td width=20>multi supervisor</td><td width=20>Manual editor</td>"; 

	echo"</tr>";
  	$sql = "SELECT canLoginToTools, guideModRights, lastOnline, username, isOnline, eventModRights, chatMod, chatSeniormod, chatSupervisor ,forumMod ,	forumSeniormod ,	forumSupervisor, 	bugsMod ,generalChatAccess,	bugsSeniormod ,	bugsSupervisor, 	multiMod ,	multiSeniormod ,	multiSupervisor,manualEditRights FROM staffrights WHERE canLoginToTools=" . ($editFormerMods ? 0 : 1);
	$resultaat = mysqli_query($mysqli, $sql); 
	while ($record = mysqli_fetch_object($resultaat))
	{
	    echo"<tr>";
		if($record->isOnline){	echo"<td><font color=green>$record->username</font></td>";		
		}else{	echo"<td><font color=red>$record->username</font></td>";		}
		
		
		if($record->lastOnline==0){
			echo"<td>never</td>";
		}else{
			echo"<td>".date("Y-m-d H:i", $record->lastOnline)."</td>";
		}
		
		if($record->username!='M2H')
		{
			echo displayAbility($record->canLoginToTools, $record->username, "canLoginToTools", $edit, $save).
				displayAbility($record->generalChatAccess, $record->username, "generalChatAccess", $edit, $save).
				displayAbility($record->guideModRights, $record->username, "guideModRights", $edit, $save).
				displayAbility($record->eventModRights, $record->username, "eventModRights", $edit, $save).
				displayAbility($record->chatMod, $record->username, "chatMod", $edit, $save).
				displayAbility($record->chatSeniormod, $record->username, "chatSeniormod", $edit, $save).
				displayAbility($record->chatSupervisor, $record->username, "chatSupervisor", $edit, $save).
				displayAbility($record->forumMod, $record->username, "forumMod", $edit, $save).
				displayAbility($record->forumSeniormod, $record->username, "forumSeniormod", $edit, $save).
				displayAbility($record->forumSupervisor, $record->username, "forumSupervisor", $edit, $save).
				displayAbility($record->bugsMod, $record->username, "bugsMod", $edit, $save).
				displayAbility($record->bugsSeniormod, $record->username, "bugsSeniormod", $edit, $save).
				displayAbility($record->bugsSupervisor, $record->username, "bugsSupervisor", $edit, $save).
				displayAbility($record->multiMod, $record->username, "multiMod", $edit, $save).
				displayAbility($record->multiSeniormod, $record->username, "multiSeniormod", $edit, $save).
				displayAbility($record->multiSupervisor, $record->username, "multiSupervisor", $edit, $save).
				displayAbility($record->manualEditRights, $record->username, "manualEditRights", $edit, $save); 
			
		}
		
	    
	}
	echo"</table><br /><br />";
	if($edit)
	{
		echo"<input type=submit value=Save>
			</form>";
	}
	
		
	if($S_staffRights['chatSupervisor'] || $S_staffRights['forumSupervisor'] ||  $S_staffRights['multiSupervisor'] ||  $S_staffRights['bugsSupervisor']){
  		$SUPERVISOR=1;
	}else{
 		$SUPERVISOR=0;
	}
	if($SUPERVISOR || $S_user=='SYRAID'){
		if($S_staffRights['chatSupervisor']){
			$dep="chatMod";
		}else if($S_staffRights['forumSupervisor']){
			$dep="forumMod";
		}else if($S_staffRights['multiSupervisor']){
			$dep="multiMod";
		}else if($S_staffRights['bugsSupervisor']){
			$dep="bugsMod";
		}
  	
		if($addMod){
			$resultaaat = mysqli_query($mysqli, "SELECT ID FROM staffrights WHERE username='$addMod' LIMIT 1");     
			$aant = mysqli_num_rows($resultaaat);
			if($aant==0){
				$sql = "INSERT INTO staffrights (username, insuggestion, suggestedBy, $dep) 
      VALUES ('$addMod', '1', '$S_user,', 1)";
                    mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs3 $sql");
				echo"<b>Suggested adding this person as mod, you need 2 other supervising mods to vote.</b><br />";
			}else{
				echo"<b>This mod already exists!</b><br />";
			}
		}
		echo"<b>Add a mod to your department ($dep's) (also needs 2 votes from other supervisors)</b><br />";
		echo"<form action='' method=post>
		<input type=text name=addMod>
		<input type=submit value=Suggest>
		</form>";
		
	
	
	if($modsName){
		$resultaaat = mysqli_query($mysqli, "SELECT ID FROM staffrights WHERE username='$modsName' && canLoginToTools=0 && suggestedBy LIKE '%$S_user%' LIMIT 1");     
		$aant = mysqli_num_rows($resultaaat);
		if($aant==0){
			$sql = "SELECT ID, suggestedBy FROM staffrights WHERE username='$modsName' && canLoginToTools=0 && suggestedBy NOT LIKE '%$S_user%' LIMIT 1";
			$resultaat = mysqli_query($mysqli, $sql); 
			while ($record = mysqli_fetch_object($resultaat))
			{
				$suggestedBy="$record->suggestedBy $S_user,";
				mysqli_query($mysqli, "UPDATE staffrights SET suggestedBy='$suggestedBy' WHERE ID='$record->ID' LIMIT 1") or  die("err1or --> 1232231");
				if(substr_count($suggestedBy, ',' )>=3){
					mysqli_query($mysqli, "UPDATE staffrights SET canLoginToTools=1,insuggestion=0 WHERE ID='$record->ID' LIMIT 1") or  die("err1or --> 1232231");	
					echo"<font color=green><B>This mod can now login to the mod tools, make sure to introduce him/her (re-open this page to see the updated staff list)</b></font><br />";
				}else{
					echo"<font color=green><B>Your vote has been counted, but this mod needs more vote(s) to be added.</b></font><br />";
				}
			}
			
		}else{
			echo"<font color=red><b>You already voted for him/her</b></font><br />";
		}
	}
	
	echo"<b>Suggested mods</b><br /><table border=1 width=100%>";
	echo"<tr><td>Name</td>";	
	echo"<td width=20>can login to mod Tools</td><td width=20>#99 access</td><td width=20>guide Mod</td><td width=20>Events</td><td width=20>chat mod</td><td width=20>forum mod</td<td width=20>bugs mod</td><td width=20>multi mod</td><td width=20>Manual editor</td><td>Suggested by</td>"; 

	echo"</tr>";
  	$sql = "SELECT canLoginToTools, guideModRights, lastOnline, username, eventModRights, chatMod, forumMod ,	bugsMod ,generalChatAccess,	multiMod ,manualEditRights, suggestedBy FROM staffrights WHERE canLoginToTools=0 && insuggestion=1";
	$resultaat = mysqli_query($mysqli, $sql); 
	while ($record = mysqli_fetch_object($resultaat))
	{
	    echo"<tr>";
		echo"<td>$record->username</td>";		
		echo displayAbility($record->canLoginToTools).displayAbility($record->generalChatAccess).displayAbility($record->guideModRights).displayAbility($record->eventModRights).displayAbility($record->chatMod).displayAbility($record->forumMod).displayAbility($record->bugsMod).displayAbility($record->multiMod).displayAbility($record->manualEditRights); 
		echo"<td>$record->suggestedBy <form action='' method=post><input type=hidden name=modsName value=\"$record->username\"><input type=submit name=VoteMod value=Vote></form></td></tr>";
	}
	echo"</table>";
	
	}#END supervisor only
	
	echo"<br />";
	
	if($S_user=='Hazgod' || $S_user=='M2H'){
		if($removeMod){			
			$sql = "SELECT username FROM staffrights WHERE ID='$removeMod' LIMIT 1";
			$resultaat = mysqli_query($mysqli, $sql); 
			while ($record = mysqli_fetch_object($resultaat))
			{
				mysqli_query($mysqli, "UPDATE staffrights SET canLoginToTools=0 WHERE ID='$removeMod' LIMIT 1") or  die("err1or --> 1232231");
				mysqli_query($mysqli, "UPDATE users_junk SET chatTag='' WHERE username='$rec->username' LIMIT 1") or  die("err1or --> 1232231");		
				echo"<b>Removed login rights!</b><br /><br />";
			}			
			
		}
		echo"<b>Remove mod</b><br /><form action='' method=post><select name='removeMod'><option value=''></option>";
			$sql = "SELECT ID,username FROM staffrights WHERE canLoginToTools=1";
			$resultaat = mysqli_query($mysqli, $sql); 
			while ($record = mysqli_fetch_object($resultaat))
			{
				echo"<option value='$record->ID'>$record->username</option>";				
			}
		echo"</select><input type=submit value='Remove mod login'></form>";
		
	}
}
?>