<?
if(defined('AZtopGame35Heyam') && $SENIOR_OR_SUPERVISOR && ($S_user=='M2H' OR $S_user=='edwin' )  ){



echo"<a href=?page=$page&tool=maps>Maps</a><br />";
echo"<a href=?page=$page&tool=DBcheck>DB check</a><br />";
echo"<a href=?page=$page&tool=type>item TYPE fix</a><br />";

echo"<hr />";


if($tool=='maps'){
	echo"Maps<br />";
		echo"<style type=\"text/css\">
/* style the <dd><a> links physical size and the background image for the hover */
#imap a#paul, #imap a#ringo, #imap a#john, #imap a#george {display:block; width:85px; height:85px; background:transparent url(../images/hover.gif) -100px -100px no-repeat; text-decoration:none; z-index:20;}


</style>";

	$z=500;
	$colorNr=1;
	$lastMap=99;
	
	if($mapOnly){ $where=" WHERE mapNumber='$mapOnly' "; }else{$where='';}
	
	$sql = "SELECT moveToArray, mapNumber,locationName FROM locationinfo $where order by mapNumber asc"; 
	$resultaat = mysqli_query($mysqli, $sql); 
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 if($lastMap!=$record->mapNumber){
		
		echo"<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<b>$lastMap ($record->mapNumber)</b><br />
		<br />";	
		$lastMap=$record->mapNumber;
	}
	
	 $prevTop=0;
	$prevLeft=0;
	$prevWidth=0;
	 	//This code is a move code, and in mapData.php	   
		$locationImage="$record->locationName.jpg";
		if($record->mapNumber=='11'){$locationImage="mapfog.gif";}
		if($record->mapNumber=='12'){$locationImage="mapdark.gif";}
		if($record->mapNumber=='14'){$locationImage="$S_location.gif";}
		if($record->mapNumber=='3' || $record->mapNumber=='4'){$locationImage="$record->locationName.gif";}

		           
$inhoud='';
$moveToArrayData = explode ("|", $record->moveToArray);
for($i=0;$moveToArrayData[$i];$i++){$z++;
	$moveToCoords = explode ("#", $moveToArrayData[$i]);
	
	$mapArea[$record->locationName][$i]['location']=$moveToCoords[4];
	$mapArea[$record->locationName][$i]['travelTime']=$moveToCoords[5];
	
	$mapArea[$record->locationName][$i]['x1']=$moveToCoords[0];  $mapArea[$record->locationName][$i]['x2']=$moveToCoords[2];
	$mapArea[$record->locationName][$i]['y1']=$moveToCoords[1]; $mapArea[$record->locationName][$i]['y2']=$moveToCoords[3]; 
	
	$x1=$moveToCoords[0];
	$y1=$moveToCoords[1];
	$width=$moveToCoords[2]-$x1;
	$height=$moveToCoords[3]-$y1;
	
	$unName=str_replace(' ', 'X', $record->locationName);
	

	 
	echo"<style type=\"text/css\">
#stijl$unName$i{
 	position: relative;
	left:".($x1-$prevWidth)."px;
	top: ".($y1)."px;
	width: ".$width."px;
	height: ".$height."px;
	z-index:500;
}
</style>";

	$prevTop=$y1;
	$prevLeft=$x1;
	$prevWidth+=$width;
	
//$inhoud.="<div class=\"stijl$record->locationName$i\" id=\"stijl$record->locationName$i\"></div>";

	$colorNr++;	
	
	if($colorNr<=1){ $color="greenpixel";
	}else if($colorNr==2){$color="redpixel";
	}else if($colorNr==3){$color="bluepixel";
	}else if($colorNr==4){$color="blackpixel";
	}else if($colorNr>=5){$color="whitepixel"; $colorNr=0;
	}

$inhoud.="<img src='../../../images/$color.gif' class=\"stijl$unName$i\" id=\"stijl$unName$i\" />";
//echo"<table class=\"stijl$i\"><tr><td bgcolor=red width=$width height=$height> </td></tr></table>";				
}

//echo"<table><tr valign=top><td width=160 height=160 background='../../../images/map/$locationImage'>";
//echo $inhoud;	
//echo"</td></tr></table>";
echo" <div style=\"width:160px;height:160px;valign:top;float:left;top;Background: url('../../../images/map/$locationImage');\">";
echo $inhoud;	
echo"</div>";

	}
	
}else if($tool=='type'){
	
	
	echo" 
	<form action='' method=post>
	Item name OR Type <input type=text name=nameOrType><input type=submit name='Submit' avlue='Submit'></form>
	<br />
	";
	if($nameOrType){
		$items=0;
		$sql = "SELECT type, name FROM items WHERE name='$nameOrType' OR type='$nameOrType'";
		$resultaat = mysqli_query($mysqli,$sql);  
		while ($record = mysqli_fetch_object($resultaat))
		{ 
			mysqli_query($mysqli, "UPDATE auctions SET type='$record->type' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE items_inventory SET type='$record->type' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE items_dropped SET type='$record->type' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE houses SET type='$record->type' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE shops SET type='$record->type' WHERE name='$record->name'") or die("error --> 544343");
			$items++;	
		}		
		echo"$items Items [$nameOrType] reset their type.<br />";
	}
	
	echo" 
	<form action='' method=post>
	Rename item, old name: <input type=text name=oldItemName><br />
	Rename item, new name: <input type=text name=newItemName><br />
	
	<input type=submit name='Submit' avlue='Submit'></form>
	<br />
	";
	if($oldItemName && $newItemName){
		$items=0;
		mysqli_query($mysqli, "UPDATE auctions SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE items SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE items_wearing SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE items_inventory SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE items_dropped SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE houses SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE shops SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE questrewards SET rewardname='$newItemName' WHERE rewardname='$oldItemName'") or die("error --> 544343");
		mysqli_query($mysqli, "UPDATE tradingpostitems SET name='$newItemName' WHERE name='$oldItemName'") or die("error --> 544343");

		echo"Renamed <b>$oldItemName</b> to <b>$newItemName</b><br />";
	}
	
	
	
	echo" 
	<br />
	<br />
	Inverse lookup, fix all items/type with this current name:
	<form action='' method=post>
	Item name OR Type <input type=text name=nameOrTypeINV><input type=submit name='Submit' avlue='Submit'></form>
	<br />
	";
	if($nameOrTypeINV){
		echo"<b>Fixing $nameOrTypeINV</b><br />";
		$items=0;
		
		$sql = "SELECT name FROM items_inventory WHERE name='$nameOrTypeINV' OR type='$nameOrTypeINV' group by name";
		$resultaat = mysqli_query($mysqli,$sql);  
		while ($record = mysqli_fetch_object($resultaat))
		{ 
			$result = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$record->name' LIMIT 1");  
			while ($rec = mysqli_fetch_object($result))
			{ 
				$rightType=$rec->type;	
			}
			mysqli_query($mysqli, "UPDATE items_inventory SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			
			mysqli_query($mysqli, "UPDATE items_dropped SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE auctions SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE shops SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			$items++;	
		}	
		
		
		$sql = "SELECT name FROM houses WHERE name='$nameOrTypeINV' OR type='$nameOrTypeINV' group by name";
		$resultaat = mysqli_query($mysqli,$sql);  
		while ($record = mysqli_fetch_object($resultaat))
		{ 
			$result = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$record->name' LIMIT 1");  
			while ($rec = mysqli_fetch_object($result))
			{ 
				$rightType=$rec->type;	
			}
			mysqli_query($mysqli, "UPDATE houses SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			
			mysqli_query($mysqli, "UPDATE items_dropped SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			mysqli_query($mysqli, "UPDATE auctions SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");			
			mysqli_query($mysqli, "UPDATE shops SET type='$rightType' WHERE name='$record->name'") or die("error --> 544343");
			$items++;	
		}
		
			
		echo"$items Items [$nameOrTypeINV] reset their type.<br />";
	}
		
	
	
}else if($tool=='DBcheck'){
	
	echo"<b>Checking DB entries for minor errors:</b><br />";
	
	if($FIX){
		echo"<b>FORCE FIX!</b><br /><br />";		
	}
	
	
	$sql = "SELECT categorie FROM forumtopics GROUP BY categorie";
	$resultaat = mysqli_query($mysqli,$sql);  
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM forumcats WHERE ID='$record->categorie' LIMIT 1");     
   		$aantal = mysqli_num_rows($resultaaat); 
   		if($aantal!=1){
			echo"<font color=red>$record->categorie forum categorie bestaat niet meer !</font><br />";
			if($FIX){
				mysqli_query($mysqli, "DELETE FROM forumtopics WHERE categorie='$record->categorie'") or die("error report");
			}
		}	 
	}
	
	$sql = "SELECT topic FROM forummessages GROUP BY topic";
	$resultaat = mysqli_query($mysqli,$sql);  
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM forumtopics WHERE ID='$record->topic' LIMIT 1");     
   		$aantal = mysqli_num_rows($resultaaat); 
   		if($aantal!=1){
			echo"<font color=red>$record->topic forum topic bestaat niet meer !</font><br />";
			if($FIX){
				mysqli_query($mysqli, "DELETE FROM forummessages WHERE topic='$record->topic'") or die("error report");
			}
		}	 
	}
	
	$sql = "SELECT username FROM items_inventory group by username";
	$resultaat = mysqli_query($mysqli,$sql);  
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$record->username' LIMIT 1");     
   		$aantal = mysqli_num_rows($resultaaat); 
   		if($aantal!=1){
			echo"<font color=red>$record->username user bestaat niet meer, but exists in items DB!</font><br />";
			if($FIX){
				mysqli_query($mysqli, "DELETE FROM items_inventory WHERE username='$record->username'") or die("error report");
			}
		}	 
	}
	
	$sql = "SELECT username FROM items_wearing group by username";
	$resultaat = mysqli_query($mysqli,$sql);  
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$record->username' LIMIT 1");     
   		$aantal = mysqli_num_rows($resultaaat); 
   		if($aantal!=1){
			echo"<font color=red>$record->username user bestaat niet meer, but exists in items DB (wearing item)!</font><br />";
			if($FIX){
				mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username='$record->username'") or die("error report");
			}
		}	 
	}
	
	$sql = "SELECT username FROM clans group by username";
	$resultaat = mysqli_query($mysqli,$sql);  
	while ($record = mysqli_fetch_object($resultaat))
	{ 
	 	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$record->username' LIMIT 1");     
   		$aantal = mysqli_num_rows($resultaaat); 
   		if($aantal!=1){
			echo"<font color=red>$record->username user bestaat niet meer, but exists in clans DB!</font><br />";
			if($FIX){
				mysqli_query($mysqli, "DELETE FROM clans WHERE username='$record->username' LIMIT 1") or die("error report");
			}
		}	 
	}
	
	echo"<font color=green>Done ! If there was no red output, everything is OK.</font><br />";
	echo"<a href=?page=$page&tool=DBcheck&FIX=1>FORCE FIX</a><br />";
	
	
	
}
 else 
{
#### JUNKOR


$ip=$_SERVER['REMOTE_ADDR'];
 






echo" <a href=?page=$page&p=drop>Drops</a>  - <a href=?page=$page&p=prices>Prices</a> -  <a href=?page=$page&p=dropping>Drop party</a> - <a href=?page=$page&p=stats>Stats</a> - <a href=?page=$page&p=donation>Donation</a> - <HR>";


if($p=='stats'){
############
### STATS
########## 
$timey=time()-345600; $NL=0;

$resultaaaat = mysql_query("SELECT donation FROM stats WHERE donation>0 && username<>'m2h' && username<>'darex'");   
    while ($record = mysql_fetch_object($resultaaaat)) { $donations=$donations+$record->donation;}
  echo"$donations euro donated<BR><BR>";
        echo"<HR>";
    $resultaaaat = mysql_query("SELECT work, count(id) as much FROM users where online=1  group by work  order by much desc ");  
    while ($record = mysql_fetch_object($resultaaaat)) { echo"$record->much $record->work<BR>"; }

   echo"<HR>users at islands";
$resultaaaat = mysql_query("SELECT location, mapNumber, count(id) as much FROM users join locationinfo on users.location=locationinfo.locationName where users.online=1 group by mapNumber order by count(id) desc ");   
    while ($record = mysql_fetch_object($resultaaaat)) { echo"$record->much map: $record->mapNumber ($record->location etc.)<BR>"; }
    echo"<HR>";
    
            echo"<HR>users at locations<br /><br />";
$resultaaaat = mysql_query("SELECT location, count(id) as much FROM users where online=1 group by location order by much desc ");   
    while ($record = mysql_fetch_object($resultaaaat)) { echo"$record->much $record->location<BR>"; }
    
 

$resultaaaat = mysql_query("SELECT username FROM users where country='NL' ");   
    while ($record = mysql_fetch_object($resultaaaat)) { 
$resultaaaat = mysql_query("SELECT username FROM stats where lastvalid>$timey");   
    while ($record = mysql_fetch_object($resultaaaat)) { $NL=$NL+1;}
}
echo"$NL nederlanders de laatste 4 dagen.<BR>";
    echo"<HR>";
$resultaaaat = mysql_query("SELECT count(ID) as much, username, password FROM users group by password order by much desc ");   
    while ($record = mysql_fetch_object($resultaaaat)) { if($record->much>1){echo"$record->much $record->username $record->password<BR>";} }
    

    echo"<HR>";


$resultaaaat = mysql_query("SELECT username, online, donation FROM stats order by online desc LIMIT 300");   
    while ($record = mysql_fetch_object($resultaaaat)) { $hours=round($record->online/3600);
$resultaat = mysql_query("SELECT joined FROM users where username='$record->username' LIMIT 100");   
    while ($rec = mysql_fetch_object($resultaat)) { 
$dagen=round((time()-$rec->joined)/86400);
$avg=round($hours/$dagen);
if(strlen($avg)==1){$avg="0$avg"; }
if($donna==''){$donna=1;}
if($record->donation>$donna){$font='<font color=green>'; }else{$font='<font color=red>';}

$txt="$avg $rank $font hours a day -$record->username-$($hours total hours, $dagen days playing)</font><BR>$txt"; } 
 }

$array = explode("<BR>", $txt); 
array_multisort($array, SORT_DESC, $array);
$aantal3 = count($array); 
$i=0;
while($i < $aantal3){ 
echo"$i $array[$i]<BR>";
$i=$i+1;
} 



}elseif($p=='donation'){
############
### Donation
##########

/*
if($text && $donationM && $username){


$Query = mysql_query("SELECT username FROM users WHERE username='$username' LIMIT 1"); 
    $aant = mysql_num_rows($Query); 
if($aant==1){
$saaql = "INSERT INTO messages (username, sendby, message, datum, topic)
 VALUES ('$username', 'M2H', '$text', '$datum', 'Syrnia Donation')";     
mysql_query($saaql) or die("EROR");
mysql_query("UPDATE stats SET donation=donation+$donationM WHERE username='$username' LIMIT 1") or die("error --> 544343");
echo"<B><Font color=green>Donator $username +$donationM euros.</font></B>";
} else{echo"<B><Font color=red>NO SUCH USER !</font></B>";}

}

echo"<form action='' method=post>
Username:<BR>
<input type=text name=username size=10>
Thank text:<BR>
<textarea name=text value=text cols=30 rows=30>Hey,<BR>
I have recieved your donation, thanks a lot for donating !<BR>
Even every small bit of donation helps a lot, your donation was very helpfull to Syrnia.<BR>
I hope you will enjoy your extra in-game features.<BR>
Your account has been upgraded.<BR>
Thanks again,<BR>
Mike - M2H<BR></textarea><BR>
Donation:<BR>
<input type=text name=donationM><BR>
<input type=submit></form>";
*/

##############3
##### DROPS
} elseif($p=='drop'){

if($monsterlevel){
   $sql ="SELECT ID, att, def, str, hp FROM monsters";
   $resultaat = mysqli_query($mysqli, $sql);     
    while ($record = mysqli_fetch_object($resultaat)) {  
$level=floor($record->att/3+$record->def/3+$record->str/3+$record->hp/5);
if($level<1){$level=1;}
mysqli_query($mysqli, "UPDATE monsters SET combat='$level' WHERE ID='$record->ID' LIMIT 1") or die("error --> LEVEL TOTAL"); 
}
echo"UPDATED COMBAT LEVELS";
} 


echo"<a href=?page=$page&p=drop&monsterlevel=1>Update combat levels</a><hr>";
if($list==''){$list=1; }


$resultaaaat = mysqli_query($mysqli,"SELECT name FROM monsters WHERE droplist=$list");  
    while ($record = mysqli_fetch_object($resultaaaat)) { echo"$record->name"; }

echo"<form action='' method=post>Name:<input type=text name=aname size=20>Dropchance<input type=text name=adrop size=4><input type=submit value=add></form>";
if($aname){
$resultaaaat = mysqli_query($mysqli,"SELECT * FROM items WHERE name='$aname' LIMIT 1");  
    while ($record = mysqli_fetch_object($resultaaaat)) { 
mysqli_query($mysqli,"INSERT INTO droplists (itemID, droplist, dropchance,  dropmuch)
VALUES ('$record->ID',  '$list', '$adrop',  1)") or die("error -->  '$record->name', '$record->type', '$list', '$adrop', '$record->sellprice', 1  <--");  
echo"Added<BR>"; }
}

if($bid){ mysqli_query($mysqli,"UPDATE droplists SET dropchance='$proca' WHERE ID=$bid LIMIT 1") or die("error --> 544343");  }
if($did){ if($dropa<1 or $dropa==''){ mysqli_query($mysqli,"DELETE FROM  droplists  WHERE ID=$did LIMIT 1") or die("error --> 544343"); echo"emptied";
 }else{ mysqli_query($mysqli,"UPDATE droplists SET dropmuch='$dropa' WHERE ID=$did LIMIT 1") or die("error --> 544343"); } }



echo"<table><tr bgcolor=333333><Td><font color=white>Name<td><font color=white>Much<td><font color=white>Chance<td><font color=white><B>%<td><Td><font color=white>Kills</tr>";
  

$resultaaaat = mysqli_query($mysqli,"SELECT *, droplists.ID as dropID FROM droplists join items on droplists.itemID=items.ID WHERE droplist=$list ORDER BY dropchance asc");  
    while ($record = mysqli_fetch_object($resultaaaat)) { 
if($dropchance==''){$dropchance=0; }
$proc=($record->dropchance-$dropchance)/1000;
$proc2=$proc+$proc2;
$dropchance=$record->dropchance;
$kills=100/$proc;
echo"<tr bgcolor=999999><td>$record->name<td><form action='' method=post><input type=hidden name=did value=$record->dropID><input type=text name=dropa size=2 value=$record->dropmuch><input type=submit value=k></form>
<Td>$dropchance<Td>$proc<td>$proc2<td>$kills<td><form action='' method=post><input type=hidden name=bid value=$record->dropID><input type=text name=proca size=4 value=$record->dropchance><input type=submit value=ok></form>";
}
$nothing=100000-$dropchance;  $nproc=$nothing/1000;  $proc2=$nproc+$proc2;
echo"<tr bgcolor=999999><td>Nothing<Td><Td>$nothing<Td>$nproc<td>$proc2";

echo"</table>";


echo"<hr><Table><tr><td><B>Combat level</B><td><B>Creature</B>";
   $sql ="SELECT ID, droplist, combat, name,exp FROM monsters ORDER BY combat ASC";
   $resultaat = mysqli_query($mysqli,$sql);     
    while ($record = mysqli_fetch_object($resultaat)) {  
    $exp=round($record->combat*1.68+2.91)+$record->exp;
    
    $dumplevel.="<tr><Td align=center>$record->combat <Td>$record->name
    "; 
    echo"<tr><Td align=center>$record->combat <Td>";  echo"<a href=?page=$page&p=drop&list=$record->ID>";  echo"$record->name</a> (ID:$record->ID)  [$exp (+$record->exp) exp]"; }
echo"</table>";
echo"<textarea>$dumplevel</textarea>";






#################
#### PRICES
} elseif($p=='prices'){

if($pid){ mysql_query("UPDATE items SET sellprice='$sellprice' WHERE name='$pid'") or die("error --> 544343");  }
echo"<table>";
$resultaaaat = mysql_query("SELECT * FROM items GROUP BY name ORDER BY type asc, sellprice asc");  
    while ($record = mysql_fetch_object($resultaaaat)) { 
echo"<tr><td>$record->name <td><form action='' method=post><input type=hidden name=pid value='$record->name'><input type=text name=sellprice size=4 value=$record->sellprice><input type=submit value=ok></form>";
}
echo"</table>";


#############
##DROPPING
} elseif($p=='dropping'){


echo"<form action='' method=post>
Name: <input type=text name=drop>
Much: <input type=text name=much>
<select name=notif>
<option value=1>yes
<option value=0>no</select>
<input type=submit value=drop>

</form>";
if($drop && $much){
echo"Dropping \"$drop\": [SELECT name, type FROM items WHERE name='$drop'  LIMIT 1]<br />";

$resultaaat = mysqli_query($mysqli, "SELECT name, type FROM items WHERE name='$drop'  LIMIT 1");  
    while ($rec = mysqli_fetch_object($resultaaat)) {
    	$drop=$rec->name;
echo"Valid item!<br />";
$nu=0;
while($nu<$much && $nu<25){
$nu=$nu+1;
$resultaat = mysqli_query($mysqli, "SELECT locationName as location FROM locationinfo ORDER BY rand()  LIMIT 1");  
    while ($record = mysqli_fetch_object($resultaat))
	{
	echo"Dropping 1 $drop at $record->location<BR>";	
$time=time()+1200;
  $sql = "INSERT INTO items_dropped (droppedBy, name, much, type, location, droptime) 
  VALUES ('dropped_', '$drop', '1', '$rec->type', '$record->location', '$time')";        
  mysqli_query($mysqli, $sql) or die("erroraa report this bug"); 

}
}



   $resultaat = mysqli_query($mysqli, "SELECT name FROM inventory where wear=2 && name='$drop'");     
   $aantalber = mysqli_num_rows($resultaat); 
echo"There are $aantalber dropped $drop<BR>";

}

}



## / DROPPING
}



### END JUNKOR
}



} 
?>