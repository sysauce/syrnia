<?
if(defined('AZtopGame35Heyam') && $S_staffRights['guideModRights']){


echo"<b>Add player guide:</b><br/>
<form aciton='' method=post>
Username: <input type=text name=newguide> <input type=submit value=Add>
</form>";

if($newguide){
	mysqli_query($mysqli,"UPDATE users_junk SET chatTag='Guide' WHERE username='$newguide' &&  chatTag='' LIMIT 1") or die("error --> 2435543");
}

if($removeguide){
	mysqli_query($mysqli,"UPDATE users_junk SET chatTag='' WHERE username='$removeguide' &&  chatTag='Guide' LIMIT 1") or die("error --> 2435543");
}

echo"<b>Current chat tags:</b><br/>";

  	$sql = "SELECT username,chatTag FROM users_junk WHERE chatTag!='' order by username asc";
	   $resultaat = mysqli_query($mysqli, $sql); 
	   while ($record = mysqli_fetch_object($resultaat)) {
	    	echo"($record->chatTag) $record->username";
	    	if($record->chatTag=='Guide'){
			echo" (<a href=\"?page=$page&removeguide=$record->username\">remove</a>)";
			}
			echo"<br/>";
	    
	    }

} 
?>