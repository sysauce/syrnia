<?
if(defined('AZtopGame35Heyam') && ($SENIOR_OR_SUPERVISOR==1)){


echo "<a href=?page=$page&action=editshops>Edit shop descriptions/title</a><br />";
echo "<a href=?page=$page&action=modtags>Mod tag</a><br />";


if($action=='editshops'){
	
	echo "<form action='' method=post>";
	echo "Search for shop owner:<input type=text name=shopOwner>";
	echo "<input type=submit value=search>";
	echo"</form>";
	
	$shopOwner = htmlentities($shopOwner);
	if($shopOwner){
			if(is_numeric($shopID) && $shopID>=1){
				echo"<b>Showing shop #$shopID of $shopOwner.</b><br />";
				
				if($editShopTitle){
					$editShopTitle = htmlentities(trim($editShopTitle));
					$editShopText = htmlentities(trim($editShopText));
					$editShopText= nl2br($editShopText);
	
					mysqli_query($mysqli, "UPDATE buildings SET tekst='$editShopText', titel='$editShopTitle' WHERE ID='$shopID' LIMIT 1") or die("2erro1r --> 54ad4343");							echo"Edited shop!<br />";
					modlog($shopOwner,'shop', "Changed title and/or description of [$shopOwner]s shop (Shop #$shopID)", '', $timee, $S_user, $S_realIP );
				}
				
				$resultaat = mysqli_query($mysqli,"SELECT ID,location, titel, tekst FROM buildings WHERE ID='$shopID' LIMIT 1");  
				while ($record = mysqli_fetch_object($resultaat))
				{
					$shoptitel=stripslashes($record->titel);
					$shoptekst=str_replace("<br />", "",stripslashes($record->tekst));
		
					echo "<table><form action='' method=post>";
					echo "<tr><td><b>Title</b></td><td><input type=text value=\"$shoptitel\" name=editShopTitle></tr>";
					echo "<tr valign=top><td><b>Text</b><td> <textarea rows=8 cols=50 name=editShopText>$shoptekst</textarea></tr>";
					echo "<tr><td></td><td><input type=submit value=edit></tr>";
					echo"</form></table>";
				}
					
			}else{
				echo"<b>Showing shops of $shopOwner</b>.<Br />";	
				$resultaat = mysqli_query($mysqli,"SELECT ID,location, titel FROM buildings WHERE username='$shopOwner' ORDER BY location ASC");  
				while ($record = mysqli_fetch_object($resultaat))
				{
					echo"#$record->ID - <a href=\"?page=$page&action=$action&shopOwner=$shopOwner&shopID=$record->ID\">$record->location</a> - $record->titel.<br />";
				}						
			}
	}
	
}else if($action=='modtags'){
	
	if($changeUser){
		$sql = "SELECT chatTag FROM staffrights JOIN users_junk on users_junk.username=staffrights.username WHERE canLoginToTools=1 && staffrights.username='$changeUser' ";
		$resultaat = mysqli_query($mysqli, $sql); 
		while ($record = mysqli_fetch_object($resultaat))
		{
			if($record->chatTag){
				mysqli_query($mysqli, "UPDATE users_junk SET chatTag='' WHERE username='$changeUser' LIMIT 1") or die("2erro1r --> 54ad4343");
			}else{
				mysqli_query($mysqli, "UPDATE users_junk SET chatTag='Mod' WHERE username='$changeUser' LIMIT 1") or die("2erro1r --> 54ad4343");
			}
			echo"Changed tag for $changeUser<br /><br />";
			modlog($S_user,'mod', "$S_user changed the mod tag of $changeUser", '', $timee, $S_user, $S_realIP );
			
		}
	}
	
		
		
	echo "<table>";
	$sql = "SELECT staffrights.username as usern, chatTag FROM staffrights JOIN users_junk on users_junk.username=staffrights.username WHERE canLoginToTools=1 ";
	$resultaat = mysqli_query($mysqli, $sql); 
	while ($record = mysqli_fetch_object($resultaat))
	{
		if($record->chatTag=='Mod' || $record->chatTag==''){
			echo "<tr><td>$record->usern</td><td>$record->chatTag</td><td><a href=\"?page=$page&action=modtags&changeUser=$record->usern\">change</a></td></tr>";
		}
	}
	echo "</table>";
	
}



}
?>