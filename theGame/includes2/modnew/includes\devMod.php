<?
if(defined('AZtopGame35Heyam') && $SENIOR_OR_SUPERVISOR && ($S_user=='M2H' || $S_user=='Hazgod')  ){

$ip=$_SERVER['REMOTE_ADDR'];

echo " <a href=?page=$page&p=drop>Drops</a> - " .
	"<a href=?page=$page&p=prices>Prices</a> -  " .
	"<a href=?page=$page&p=dropping>Drop party</a> -  " .
	"<a href=?page=$page&p=group>Group quest progress</a> -  " .
	"<a href=?page=$page&p=move>Move player</a>" .
	"<HR>";

##############3
##### DROPS
if($p=='drop'){

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

    $dumplevel.="<tr><Td align=center>$record->combat <Td>$record->name ";
    echo"<tr><Td align=center>$record->combat <Td>";  echo"<a href=?page=$page&p=drop&list=$record->ID>";  echo"$record->name</a> (ID:$record->ID)  [$exp (+$record->exp) exp]"; }
echo"</table>";
echo"<textarea>$dumplevel</textarea>";






#################
#### PRICES
}
else if($p=='prices')
{

if($pid){ mysqli_query($mysqli,"UPDATE items SET sellprice='$sellprice' WHERE name='$pid'") or die("error --> 544343");  }
echo"<table>";
$resultaaaat = mysqli_query($mysqli,"SELECT * FROM items GROUP BY name ORDER BY type asc, sellprice asc");
    while ($record = mysqli_fetch_object($resultaaaat)) {
echo"<tr><td>$record->name <td><form action='' method=post><input type=hidden name=pid value='$record->name'><input type=text name=sellprice size=4 value=$record->sellprice><input type=submit value=ok></form>";
}
echo"</table>";


#############
##DROPPING
}
else if($p=='dropping')
{
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
#############
##GROUP
}
else if($p=='group'){


	if(!$questID)
	{
		$questID = 1;
	}
	
	echo "<form action='' method=post><input type='hidden' name='search' value='1'>" .
		"Group quest: <select name='questID'>";

	$resultaaat = mysqli_query($mysqli, "SELECT DISTINCT (questID), quest FROM  `groupquestslist` ORDER BY questID ASC");
    while ($rec = mysqli_fetch_object($resultaaat))
	{
    	echo "<option value='$rec->questID'" . ($rec->questID == $questID ? " selected='selected'" : "") . ">$rec->quest</option>";
	}

	echo "</select>";

	echo "<br/>Group quest: <select name='subID'><option value='0'>All stages</option>";
		
	$resultaaat = mysqli_query($mysqli, "SELECT subID, gathername, gathermuch, gathered FROM  `groupquestslist` WHERE questID = '$questID' ORDER BY subID ASC");
	while ($rec = mysqli_fetch_object($resultaaat))
	{
		echo "<option value='$rec->subID'>$rec->subID: $rec->gathername ($rec->gathered/$rec->gathermuch)</option>";
	}

	echo "</select>";

	echo "<br/><input type=submit value=search></form>";
	if($search && $questID)
	{
		echo "<br/>";
		$resultaaat = mysqli_query($mysqli, "SELECT subID, username, SUM(amount) AS totalAmount" .
			" FROM `groupquestresults`" .
			" WHERE questID = '$questID'" .
			($subID ? " AND subID = $subID" : "") .
			" GROUP BY username" .
			" ORDER BY totalAmount DESC");
		while ($rec = mysqli_fetch_object($resultaaat))
		{
			echo "$rec->username: $rec->totalAmount<br/>";
		}
	}

## / GROUP
#############
##move
}
else if($p=='move'){

echo "<table><form action='' method=post>";
	echo "<tr><td><b>Username</b></td><td><input type=text  name=dropUser></tr>";
	echo "<tr><td><b>Location</b></td><td><input type=text  name=location></tr>";
	echo "<tr><td></td><td><input type=submit value=move></tr>";
	echo"</form></table>";

	if(strlen($dropUser)>=3 && strlen($location)>=3)
	{
		$sql = "SELECT locationName as location FROM locationinfo WHERE locationName = '$location'";
		$resultaat = mysqli_query($mysqli, $sql);
		if($record = mysqli_fetch_object($resultaat))
		{
			mysqli_query($mysqli,"UPDATE users SET location = '$location', work='', worktime='', dump='', dump2='' WHERE username='$dropUser' LIMIT 1") or die("ert113");
			echo"Moved $dropUser to $location";
		}
		else
		{
			echo"Invalid location";
		}
	}
	else
	{
		echo"Need a username and location";
	}

## / MOVE
}



}
?>