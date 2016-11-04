<?
if(defined('AZtopGame35Heyam') && $S_MODLOGIN==1){



echo"<b>Department staff list</b><br/>";


	echo"Listing staff from: ";
	if($S_staffRights['chatMod']){
	 	echo"Chat ";
		$where.=" OR chatMod=1";
	}
	if($S_staffRights['multiMod']){
	 	echo"Multi ";
		$where.=" OR multiMod=1";
	}
	if($S_staffRights['forumMod']){
		 echo"Forum ";
		$where.=" OR forumMod=1";
	}
	if($S_staffRights['bugsMod']){
	 echo"Bugs ";
		$where.=" OR bugsMod=1";
	}
	echo" department(s)<br />";
	
	
	echo"<br /><table cellpadding=5>";
	echo"<tr><td><b>Name</b></td><td><b>Status</b></td><td><b>Last mod login</b></td>";
	echo"</tr>";
	

	
	
  	$sql = "SELECT username, isOnline, lastOnline, onDuty, chatMod FROM staffrights WHERE isOnline=1 && ( 0 $where ) ";
	$resultaat = mysqli_query($mysqli, $sql); 
	while ($record = mysqli_fetch_object($resultaat))
	{
	    echo"<tr>";
		if($record->isOnline){
			echo"<td><font color=green>$record->username</font> ";
			echo"</td><td>";
		if($record->chatMod==1){
			if($record->onDuty==1){
				echo"<font color=green>On Duty</font>";
			}else{
				echo"<font color=red>Not on duty</font>";
			}
		}
		echo"</td>";
				
		}else{	echo"<td><font color=red>$record->username</font></td><td></td>";		}
		
		if($record->username!='M2H'){		 
			if($record->lastOnline==0){
				echo"<td>never</td>";
			}else{
				echo"<td>".date("Y-m-d H:i", $record->lastOnline)."</td>";
			}		
		}
		
	    
	}
	echo"</table>";
} 
?>