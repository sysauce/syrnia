<?
if(defined('AZtopGame35Heyam') && $S_staffRights['eventModRights']==1){

echo"<br/><center>";
echo"<a href=?page=eventstools>Events<a/> -";
echo"<a href=?page=eventstools&view=tools>Tools<a/> - ";
echo"<a href=?page=eventstools&view=skillevents>Skill events<a/> - ";
echo"<a href=?page=eventstools&view=presets>Event presets<a/>";



echo"</center><br/>";

function VarIsOK($var){
	if($var == htmlentities($var) && $var == addslashes($var)){
		return true;
	}
	return false;
}

 ################ SKILL EVENTS
if($view=='skillevents'){


	echo"<center><B>Skill event tools</B><BR>";


if($locationM && $monsters && $monstermuch && $minsleft && $combination && $skillevent==1){
 $resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$locationM' && (rewarded=0)  LIMIT 1");
  $aantal = mysqli_num_rows($resultaat);
  if($aantal==0 ){
  	$eventdescription = htmlentities($eventdescription);
  	if(VarIsOK($dump) &&  VarIsOK($monsters) &&  VarIsOK($itemtype) ){
	 	if($uur && $minuut && $maand && $dag && $jaar){
	 		if($monsters==' ') $monsters='';
			$startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);
			$sql = "DELETE FROM invasions WHERE location='$locationM'";
			mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
			$sql = "DELETE FROM locations WHERE location='$locationM'";
			mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
			$timeee=$startTime+$minsleft*60;
			$saaql = "INSERT INTO locations (location, dump, monsters,itemtype, monstersmuch, invasiontime, type, startTime, eventdescription,combination)
			VALUES ('$locationM', '$dump', '$monsters','$itemtype', '$monstermuch', '$timeee', 'skillevent', '$startTime', '$eventdescription', '$combination')";
			mysqli_query($mysqli, $saaql) or die("EROR");
			echo"Skill event launched!!!<BR>";
			modlog($S_user,'event', "launched skillevent at $locationM, $monstermuch $monsters", 0, $timee, $S_user, $S_realIP, 0 );
	}else{ echo"<B>WRONG TIME, NO SKILL EVENT ADDED</B>"; }
	}else{ echo"<B>WRONG INPUT</B>"; }

}else{ echo"<font color=red><b>ERROR: THERES ALREADY AN EVENT ON THAT LOCATION!</b></font>";}
}


	$sqal = "SELECT locationName as location FROM locationinfo WHERE mapNumber>=1 && mapNumber!=14 && mapNumber!=3 order by locationName asc";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
	{
	 	$resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$record->location' && (rewarded=0)  LIMIT 1");
	  	$aantal = mysqli_num_rows($resultaat);
	  	if($aantal==0){
            if($record->location == 'Arch. cave 3')
            {
                for($i = 1; $i <= 25; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else if($record->location == 'Lost caves')
            {
                for($i = 1; $i <= 10; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else
            {
                $locationList.="<option value='$record->location'>$record->location";
            }
		}
	}



	echo"<form action='' method=post>
	<input type=hidden name=skillevent value=1>
	<input type=hidden name=dump value='mining'>
	<Table>
	<tr><td></td><td><b>MINING</b>
	<tr valign=top><td>Description <td><textarea name='eventdescription' rows=3 cols=60></textarea>
	<tr><td>  Location <td><Select name=locationM>";
	echo $locationList;
	echo"</select>
	<tr><td>Type<td><Select name=monsters>
	<option value=\"Tin ore\">Tin ore</option>
	<option value=\"Copper ore\">Copper ore</option>
	<option value=\"Iron ore\">Iron ore</option>
	<option value=\"Coal\">Coal</option>
	<option value=\"Silver\">Silver</option>
	<option value=\"Gold ore\">Gold ore</option>
	<option value=\"Platina ore\">Platina ore</option>
	<option value=\"Syriet ore\">Syriet ore</option>
	<option value=\"Obsidian ore\">Obsidian ore</option>
	</select>
	<tr><td>How much?<td><input type=text name=monstermuch value=100>
	<tr><td>Reward per item<td><input type=text name=combination value=1>
	<Tr><td>Minutes until it multiplies<td><input type=text name=minsleft value=60000>
	<tr><td>Start date<td>";
	echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
	<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
	echo"<tr><td><td><input type=submit></table>
	</form><BR><BR><HR>";


	echo"<form action='' method=post>
	<input type=hidden name=skillevent value=1>
	<input type=hidden name=dump value='fishing'>
	<Table>
	<tr><td></td><td><b>FISHING</b>
	<tr valign=top><td>Description <td><textarea name='eventdescription' rows=3 cols=60></textarea>
	<tr><td>  Location <td><Select name=locationM>";
	echo $locationList;
	echo"</select>
	<tr><td>Type<td><Select name=monsters>
	<option value=\" \">Net&Rod</option>
	<option value=\"Sloop\">Sloop</option>
	<option value=\"Boat\">Boat</option>
	<option value=\"Trawler\">Trawler</option>
	<option value=\"Small fishing boat\">Small fishing boat</option>
	<option value=\"Canoe\">Canoe</option>
	</select>
	<tr><td>How much?<td><input type=text name=monstermuch value=100>
	<tr><td>Reward per item<td><input type=text name=combination value=1>
	<Tr><td>Minutes until it multiplies<td><input type=text name=minsleft value=60000>
	<tr><td>Start date<td>";
	echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
	<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
	echo"<tr><td><td><input type=submit></table>
	</form><BR><BR><HR>";


		echo"<form action='' method=post>
	<input type=hidden name=skillevent value=1>
	<input type=hidden name=dump value='woodcutting'>
	<Table>
	<tr><td></td><td><b>WOODCUTTING</b>
	<tr valign=top><td>Description <td><textarea name='eventdescription' rows=3 cols=60></textarea>
	<tr><td>  Location <td><Select name=locationM>";
	echo $locationList;
	echo"</select>
	<tr><td>Type<td><Select name=monsters>
	<option value=\"Isri\">Isri woodcutting</option>
	<option value=\"Lemo woods\">Lemo woods woodcutting</option>
	<option value=\"Unera\">Unera woodcutting</option>
	<option value=\"Avinin\">Avinin woodcutting</option>
	<option value=\"Penteza forest\">Penteza forest woodcutting</option>
	<option value=\"Aloria\">Aloria woodcutting</option>
	<option value=\"Khaya\">Khaya woodcutting</option>
	<option value=\"Ammon\">Ammon woodcutting</option>
	<option value=\"Festival forest\">Festival forest woodcutting</option>
	</select>
	<tr><td>How much?<td><input type=text name=monstermuch value=100>
	<tr><td>Reward per item<td><input type=text name=combination value=1>
	<Tr><td>Minutes until it multiplies<td><input type=text name=minsleft value=60000>
	<tr><td>Start date<td>";
	echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
	<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
	echo"<tr><td><td><input type=submit></table>
	</form><BR><BR><HR>";


		echo"<form action='' method=post>
	<input type=hidden name=skillevent value=1>
	<input type=hidden name=dump value='smelting'>
	<Table>
	<tr><td></td><td><b>SMELTING</b>
	<tr valign=top><td>Description <td><textarea name='eventdescription' rows=3 cols=60></textarea>
	<tr><td>  Location <td><Select name=locationM>";
	echo $locationList;
	echo"</select>
	<tr><td>Type<td><Select name=monsters>
	<option value=\"Bronze bars\">Bronze bars</option>
	<option value=\"Iron bars\">Iron bars</option>
	<option value=\"Steel bars\">Steel bars</option>
	<option value=\"Silver bars\">Silver bars</option>
	<option value=\"Gold bars\">Gold bars</option>
	<option value=\"Platina bars\">Platina bars</option>
	<option value=\"Syriet bars\">Syriet bars</option>
	<option value=\"Obsidian bars\">Obsidian bars</option>

	</select>
	<tr><td>How much?<td><input type=text name=monstermuch value=100>
	<tr><td>Reward per item<td><input type=text name=combination value=1>
	<Tr><td>Minutes until it multiplies<td><input type=text name=minsleft value=60000>
	<tr><td>Start date<td>";
	echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
	<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
	echo"<tr><td><td><input type=submit></table>
	</form><BR><BR><HR>";


	echo"<form action='' method=post>
	<input type=hidden name=skillevent value=1>
	<input type=hidden name=dump value='cooking'>
	<Table>
	<tr><td></td><td><b>COOKING</b>
	<tr valign=top><td>Description <td><textarea name='eventdescription' rows=3 cols=60></textarea>
	<tr><td>  Location <td><Select name=locationM>";
	echo $locationList;
	echo"</select>
	<tr><td>Type<td><Select name=monsters>
	<option value=\"Shrimps\">Shrimps</option>
	<option value=\"Frog\">Frog</option>
	<option value=\"Sardine\">Sardine</option>
	<option value=\"Herring\">Herring</option>
	<option value=\"Catfish\">Catfish</option>
	<option value=\"Mackerel\">Mackerel</option>
	<option value=\"Queen spider meat\">Queen spider meat</option>
	<option value=\"Trouts\">Trouts</option>
	<option value=\"Cod\">Cod</option>
	<option value=\"Pike\">Pike</option>
	<option value=\"Salmon\">Salmon</option>
	<option value=\"Tuna\">Tuna</option>
	<option value=\"Giant catfish\">Giant catfish</option>
	<option value=\"Lobster\">Lobster</option>
	<option value=\"Bass\">Bass</option>
	<option value=\"Swordfish\">Swordfish</option>
	<option value=\"Saurus meat\">Saurus meat</option>
	<option value=\"Shark\">Shark</option>
	<option value=\"Parrotfish\">Parrotfish</option>
	<option value=\"Eel\">Eel</option>
	<option value=\"Snapper\">Snapper</option>
	<option value=\"Crab\">Crab</option>
	<option value=\"Grouper\">Grouper</option>
	</select>
	<tr><td>How much?<td><input type=text name=monstermuch value=100>
	<tr><td>Reward per item<td><input type=text name=combination value=1>
	<Tr><td>Minutes until it multiplies<td><input type=text name=minsleft value=60000>
	<tr><td>Start date<td>";
	echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
	<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
	echo"<tr><td><td><input type=submit></table>
	</form><BR><BR><HR>";

 ################ TOOLS
}else if($view=='tools'){
	if($checky){
		$aant=0;
		$resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name FROM items_inventory WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>INVE:</B> $record->mucho $record->name<BR>";
		}
		$resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name FROM items_dropped WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>DROPPED:</B> $record->mucho $record->name<BR>";
		}
		$resultaaaat = mysqli_query($mysqli, "SELECT count(ID) as mucho,name FROM items_wearing WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>WEARING:</B> $record->mucho $record->name<BR>";
		}
	    $resultaaaat = mysqli_query("SELECT sum(much) as mucho,name FROM shops WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>SHOP:</B> $record->mucho $record->name<BR>";
		}
	    $resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name FROM houses WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>HOUS:</B> $record->mucho $record->name<BR>";
		}
		$resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name FROM shops WHERE name = '$checky' GROUP BY name asc");
	    while ($record = mysqli_fetch_object($resultaaaat)) {
		 	$aant=$aant+$record->mucho; //echo"<B>HOUS:</B> $record->mucho $record->name<BR>";
		}
	    $resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name  FROM auctions WHERE name = '$checky' GROUP BY name asc");
 	    while ($record = mysqli_fetch_object($resultaaaat)) {
		  	$aant=$aant+$record->mucho; //echo"<B>AUCT:</B> $record->mucho $record->name<BR>";
		}
	    $resultaaaat = mysqli_query($mysqli, "SELECT sum(much) as mucho,name  FROM clanbuildingsitems WHERE name = '$checky' GROUP BY name asc");
 	    while ($record = mysqli_fetch_object($resultaaaat)) {
		  	$aant=$aant+$record->mucho; //echo"<B>AUCT:</B> $record->mucho $record->name<BR>";
		}

	    echo"<b>$aant $checky in houses, inventory, auction, shops and clan stock.</b><BR>";
	}
	    echo"<b>How much is in game of...</b><form action='' method=post><input type=text name=checky><input type=submit value=check></form><BR>";


}else if($view=='presets'){
	##Preset events
	echo"<center><B>Preset events</B><BR>";
	
	
	
}else if($forum==1){
	$eventforum=1;
	include('forum.php');

}else{
    ################ EVENTS


if($deleteEventID){
    $sql = "DELETE FROM locations WHERE ID='$deleteEventID' LIMIT 1";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
	  modlog($S_user,'event', "deleted event #$deleteEventID", 0, $timee, $S_user, $S_realIP, 0 );

}


echo"<center><B>Invasion tools</B><BR>";
if((($locationM && $monster && $monstermuch && $minsleft) || $groupfight) && $invasion==1){

    $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE (monsters>0 OR rewarded=0) && location='$locationM'");
    $currentInvasion = mysqli_num_rows($resultaat);

    $resultaat = mysqli_query($mysqli, "SELECT ID FROM partyfight WHERE hp > 0 && location='$locationM'");
    $currentGroupFight = mysqli_num_rows($resultaat);

    if($groupfight)
    {
        if($currentInvasion == 0 && $currentGroupFight == 0)
        {
            $saaql = "DELETE FROM partyfight WHERE location = '$locationM';";
            //echo $saaql . "<br/><br/>";
            mysqli_query($mysqli, $saaql) or die("EROR");

            $saaql = "INSERT INTO partyfight (location, monster, hp) VALUES ('$locationM', '$monster', (SELECT FLOOR(hp  * 1.1 + 3) FROM monsters WHERE name = '$monster'))";
            //echo $saaql . "<br/><br/>";
            mysqli_query($mysqli, $saaql) or die("EROR");
            echo"Invasion launched!!!<BR>";
            modlog($S_user,'event', "launched group fight invasion at $locationM, $monster", 0, $timee, $S_user, $S_realIP, 0 );
        }
        else
        {
            echo"<font color=red><b>ERROR: THERES ALREADY A COMBAT EVENT AT THAT LOCATION!</b></font>";
        }
    }
    else
    {
        if($currentInvasion == 0 && $currentGroupFight == 0)
        {
            if($uur && $minuut && $maand && $dag && $jaar)
            {
        $startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);
        $sql = "DELETE FROM invasions WHERE location='$locationM'";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
        $sql = "DELETE FROM locations WHERE location='$locationM'";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
        $timeee=$startTime+$minsleft*60;
        $saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, startTime)
            VALUES ('$locationM', '$monster', '$monstermuch', '$timeee', 'invasion', '$startTime')";
        mysqli_query($mysqli, $saaql) or die("EROR");
        echo"Invasion launched!!!<BR>";
        modlog($S_user,'event', "launched invasion at $locationM, $monstermuch $monster", 0, $timee, $S_user, $S_realIP, 0 );
            }
            else
            {
                echo"<B>WRONG TIME, NO INVASION ADDED</B>";
            }
        }
        else
        {
            echo "<font color=red><b>ERROR: THERES ALREADY AN EVENT ON THAT LOCATION!</b></font>";}
        }
    }
	$sqal = "SELECT locationName as location FROM locationinfo WHERE mapNumber>=1 && mapNumber!=14 && mapNumber!=3 order by locationName asc";
    $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
	{
	 	$resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$record->location' && (rewarded=0)  LIMIT 1");
	  	$aantal = mysqli_num_rows($resultaat);
	  	if($aantal==0)
        {
            if($record->location == 'Arch. cave 3')
            {
                for($i = 1; $i <= 20; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else if($record->location == 'Lost caves')
            {
                for($i = 1; $i <= 10; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else
            {
                $locationList.="<option value='$record->location'>$record->location";
            }
		}
	}

echo"<Table><tr><td><form action='' method=post><input type=hidden name=invasion value=1>
Location <td><Select name=locationM>";
echo $locationList;
echo"</select>
<tr><td>Monster name<td><Select name=monster>";
$where = "";
if(isHalloween() || date("-m-d")=='-10-29')
{
    $where = " OR specialEvent = 'Halloween'";
}
else if(isXmas() || date("-m-d")=='-12-23')
{
    $where = " OR specialEvent = 'Christmas'";
}
else if(isEaster())
{
    $where = " OR specialEvent = 'Easter'";
}

$sqal = "SELECT combat, name FROM monsters WHERE specialEvent = ''$where ORDER BY name asc";
$resultaaaat = mysqli_query($mysqli, $sqal);
while ($record = mysqli_fetch_object($resultaaaat))
{
	echo"<option value=\"$record->name\">$record->name ($record->combat)</option>";
}
echo"</select>
<tr><td>How much monsters?<td><input type=text name=monstermuch>
<tr><td>Group fight?<td><input type=checkbox name=groupfight value=1>
<Tr><td>Minutes until they multiply<td><input type=text name=minsleft value=60000>
<tr><td>Start date<td>";
echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
echo"<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";


//ADD CHEST
if($locationM && $monster && $monstersmuch && $invasiontime && $chest==1){
  $resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$locationM' && (rewarded=0)  LIMIT 1");
  $aantal = mysqli_num_rows($resultaat);
  if($aantal==0){
	if($uur && $minuut && $maand && $dag && $jaar){
	$startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);
	$itemtype='';
	$sqal = "SELECT type, name FROM items WHERE name='$monster' LIMIT 1";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat)) {$itemtype=$record->type; $monster=$record->name; }
	if($itemtype){
      $sql = "DELETE FROM invasions WHERE location='$locationM'";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
      $sql = "DELETE FROM locations WHERE location='$locationM'";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
$combination=rand(1,$invasiontime);
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, itemtype, combination, startTime)
 VALUES ('$locationM', '$monster', '$monstersmuch', '$invasiontime', 'chest', '$itemtype', '$combination', '$startTime')";
mysqli_query($mysqli, $saaql) or die("EROR");
echo"Chest launched!!!<BR>";
modlog($S_user,'event', "launched chest at $locationM [$monster] $monstersmuch combinations", 0, $timee, $S_user, $S_realIP, 0 );
}else{ echo"<B>WRONG ITEM NAME, NO CHEST ADDED</B>"; }
}else{ echo"<B>WRONG TIME, NO CHEST ADDED</B>"; }
}else{ echo"<font color=red><b>ERROR: THERES ALREADY AN EVENT ON THAT LOCATION!</b></font>";}

	$sqal = "SELECT locationName as location FROM locationinfo WHERE mapNumber>=1 && mapNumber!=14 && mapNumber!=3 order by locationName asc";
    $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
	{
	 	$resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$record->location' && (rewarded=0)  LIMIT 1");
	  	$aantal = mysqli_num_rows($resultaat);
	  	if($aantal==0)
        {
            if($record->location == 'Arch. cave 3')
            {
                for($i = 1; $i <= 20; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else if($record->location == 'Lost caves')
            {
                for($i = 1; $i <= 10; $i++)
                {
                    $locationList.="<option value='$record->location.$i'>$record->location.$i";
                }
            }
            else
            {
                $locationList.="<option value='$record->location'>$record->location";
            }
		}
	}
}


echo"<b>Chest:</b><Table><tr><td><form action='' method=post><input type=hidden name=chest value=1>
Location <td><Select name=locationM>";
echo $locationList;
echo"</select>
<tr><td>Item name (No gold)<td><input type=text name=monster>
<tr><td>How much ?<td><input type=text name=monstersmuch>
<Tr><td>Chest combinations<td><input type=text name=invasiontime>
<tr><td>Start date<td>";
echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
echo"<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";




if($locationM && $monsters && $monstersmuch && $invasiontime && $contest==1 ){
  $resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$locationM' && (rewarded=0)  LIMIT 1");
  $aantal = mysqli_num_rows($resultaat);
  if($aantal==0){
 	if($uur && $minuut && $maand && $dag && $jaar){
	$startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);

			$itemtype='';  $itemexcists='';
		$sqal = "SELECT type, name FROM items WHERE name='$monsters' LIMIT 1";
	   $resultaaaat = mysqli_query($mysqli, $sqal);
	    while ($record = mysqli_fetch_object($resultaaaat)) {$itemexcists=1; $itemtype=$record->type; $monsters=$record->name; 	}
		if($itemexcists==1){
	      $sql = "DELETE FROM invasions WHERE location='$locationM'";
	      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
	      $sql = "DELETE FROM locations WHERE location='$locationM'";
	      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
	$invasiontime=$startTime+$invasiontime*3600;
	$combinations=$combinations*100;
	$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, itemtype, combination, dump, startTime)
	 VALUES ('$locationM', '$monsters', '$monstersmuch', '$invasiontime', 'contest', '$itemtype', '$combinations', '$dump', '$startTime')";
	mysqli_query($mysqli, $saaql) or die("EROR");
	echo"Contest launched!!!<BR>";
	modlog($S_user,'event', "launched contest at $locationM, $monstermuch-$monster-$dump", 0, $timee, $S_user, $S_realIP, 0 );
	}else{ echo"<B>WRONG ITEM NAME [$monsters], CONTEST NOT STARTED</B>"; }
	}else{ echo"<B>WRONG TIME, NO COLLECTION EVENT ADDED</B>"; }
	}else{ echo"<font color=red><b>ERROR: THERES ALREADY AN EVENT ON THAT LOCATION!</b></font>";}
}


echo"<b>Contest:</b><Table><tr><td><form action='' method=post><input type=hidden name=contest value=1>
Location <td><Select name=locationM>";
echo $locationList;
echo"</select>
<tr><td>What item to collect (no gold)<td><input type=text name=monsters>
<tr><td>How many hours to collect from start ?<td><input type=text name=invasiontime>
<Tr><td>Combinations: 10 is 1000 combinations (1.00-10.00 1000)<td><input type=text name=combinations>
<Tr><td>Gold reward for N. 1 ?<td><input type=text name=monstersmuch>
<Tr><td>Meter/Weight<td><input type=text name=dump>
<tr><td>Start date<td>";
echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
echo"<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";


/*
///Add item
if($useradditem && is_numeric($muchadditem) && $muchadditem>0 && $nameadditem){
	if($nameadditem=="gold"){
		echo"adding...";
		getGold($useradditem, $muchadditem);
		modlog($S_user,'event', "added $muchadditem gold to $useradditem", 0, $timee, $S_user, $Sreal_IP, 0 );
		echo"Gold added!<BR>";
	}else{
		$itemtype='';
		$sqal = "SELECT type, name FROM items WHERE name='$nameadditem' LIMIT 1";
	   $resultaaaat = mysqli_query($mysqli, $sqal);
	    while ($record = mysqli_fetch_object($resultaaaat)) {$itemtype=$record->type; $itemname=$record->name; }
		if($itemtype && $itemname){
			echo"adding...";
			addItem($useradditem, $itemname, $muchadditem, $itemtype, '', '', 0);
			modlog($S_user,'event', "added item to $useradditem ($muchadditem $itemname)", 0, $timee, $S_user, $Sreal_IP, 0 );
			echo"Item added!<BR>";
		}else{ echo"<B>WRONG ITEM NAME, NO ITEM ADDED</B>"; }
	}

}
echo"<B>Add item/gold</b>:
<Table><tr><td>
<form action='' method=post>
<input type=hidden name=additem value=1>
<Tr><td>Username<td><input type=text name=useradditem>
<tr><td>Item name (OR \"gold\" for cash)<td><input type=text name=nameadditem>
<tr><td>How much ?<td><input type=text name=muchadditem>
<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";
*/

if($chatmsg && ($channel==0 OR $channel==6)){
	### CHAT
	$moderator=1;
	$SystemMessage=1;
	$BoldSystemMessage=1;
	$chatMessage="$chatmsg";
	$channel=$channel;
	include("../../scripts/chat/addchat.php");
	echo"<b>Added chat</b><br />";
	### CHAT
}




echo"Say something italic in chat:<BR>
<form action='' method=post>
<select name=channel>
<option value=0>All
<option value=6>Pirate
</select>
<input type=text name=chatmsg size=50>
<input type=submit>
</form><HR>";





//ADD COLLECT
if($locationM && $collectReason && $totalRequired && $collect==1){
  $resultaat = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE location='$locationM' && (rewarded=0)  LIMIT 1");
  $aantal = mysqli_num_rows($resultaat);
  if($aantal==0){
 	if($uur && $minuut && $maand && $dag && $jaar){
	$startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);

	$sqal = "SELECT type, name FROM items WHERE name='collectItem' LIMIT 1";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat)) {$OKItem=1; }
	if($OKItem!=1){
	      $sql = "DELETE FROM invasions WHERE location='$locationM'";
	      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
	      $sql = "DELETE FROM locations WHERE location='$locationM'";
	      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");

		$saaql = "INSERT INTO locations (location, monsters, type, combination, dump, startTime)
		 VALUES ('$locationM', '$collectReason',  'collect', '$totalRequired', '$collectItem', '$startTime')";
		mysqli_query($mysqli, $saaql) or die("EROR");
		echo"Collection launched!!!<BR>";
		modlog($S_user,'event', "launched collection event at $locationM", 0, $timee, $S_user, $S_realIP, 0 );
}else{ echo"<B>WRONG ITEM NAME, NO COLLECTION EVENT ADDED</B>"; }
}else{ echo"<B>WRONG TIME, CONTEST NOT STARTED</B>"; }
}else{ echo"<font color=red><b>ERROR: THERES ALREADY AN EVENT ON THAT LOCATION!</b></font>";}
}


echo"<b>Collection event(NO REWARDS!):</b><Table><tr><td><form action='' method=post><input type=hidden name=collect value=1>
Location <td><Select name=locationM>";
echo $locationList;
echo"</select>
<tr><td>Collection reason<td><input type=text name=collectReason>
<Tr><td>Collect item<td><input type=text name=collectItem>
<Tr><td>Total required<td><input type=text name=totalRequired value=10000>
<tr><td>Start date<td>";
echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
echo"<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";

if($minLevel > 0 && $maxLevel > 0 && $battlemage==1)
{
    if($uur && $minuut && $maand && $dag && $jaar)
    {
        $startTime=mktime($uur, $minuut, 0, $maand, $dag, $jaar);

        $saaql = "INSERT INTO arena (time, started, winner, players, minLevel, maxLevel)
             VALUES ('$startTime', 0, '', 0, '$minLevel', '$maxLevel')";
            mysqli_query($mysqli, $saaql) or die("EROR");
            echo"Battlemage Added!!!<BR>";
            modlog($S_user,'event', "Added battlemage", 0, $timee, $S_user, $S_realIP, 0 );
    }
    else
    {
        echo"<B>WRONG TIME, BATTLEMAGE NOT ADDED</B>";
    }
}

echo"<b>Battlemage:</b><Table><tr><td><form action='' method=post><input type=hidden name=battlemage value=1>
<tr><td>Min level<td><input type=text name=minLevel>
<Tr><td>Max level<td><input type=text name=maxLevel>
<tr><td>Date<td>";
echo"<input type=text size=1 name=uur value=".date(H).">:<input type=text  size=1 name=minuut value=".date(i)."><br />
<input type=text  size=1 name=dag value=".date(d).">-<input type=text  size=1 name=maand value=".date(m).">-<input type=text  size=2 name=jaar value=".date(Y)."><br />";
echo"<tr><td><td><input type=submit></table>
</form><BR><BR>";

echo "";


echo "<HR>";




echo"<HR";
echo"<h3>Current events</h3>";
    $sqal = "SELECT ID,monsters,location,dump,monstersmuch,invasiontime,rewarded, type, startTime FROM locations WHERE monstersmuch>0 AND hideInEventList = false ORDER BY startTime ASC";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat)) {
     $invasion.="<tr><td>";
     if($record->type=='skillevent'){#INVASION
			$sec=$record->invasiontime-$time;   if($sec<0){$sec=0; }$invasion.="<font color=red>Skillevent: ".$record->dump." ($record->monsters).  $record->monstersmuch left at $record->location. ($sec sec left)</font> <a href=?page=eventstools&deleteEventID=$record->ID>delete</a><BR>";
		}else if($record->type=='invasion'){#INVASION
			if($record->startTime<$timee){ $totalm=$totalm+$record->monstersmuch;
			}else{	 $totalms=$totalms+$record->monstersmuch;}
			$sec=$record->invasiontime-$time;   if($sec<0){$sec=0; }$invasion.="<font color=red>$record->monstersmuch ".$record->monsters."s left at $record->location. ($sec sec left)</font> <a href=?page=eventstools&deleteEventID=$record->ID>delete</a><BR>";
		}elseif($record->type=='chest' && $record->rewarded<>1){

			$invasion.="<font color=green>$record->invasiontime combinations Chest at $record->location</font> <a href=?page=eventstools&deleteEventID=$record->ID>delete</a><BR>";
		}elseif($record->type=='contest' && $record->rewarded<>1){
			$invasion.="<font color=orange>$record->monsters Contest at $record->location</font> <a href=?page=eventstools&deleteEventID=$record->ID>delete</a><BR>";
		}elseif($record->type=='collect' && $record->rewarded<>1){
			$invasion.="<font color=orange>$record->dump collection at $record->location</font> <a href=?page=eventstools&deleteEventID=$record->ID>delete</a><BR>";
		}else{
		 	if($record->rewarded!=1){
				echo"error $record->type ($record->location)!<br/>";
			}
		}
		if($record->startTime>=$timee){
			$invasion.="<small>(Starting:".date("Y-m-d H:i", $record->startTime).")</small><br/>";
		}
		$invasion.="</tr>";
}

if($invasion){
	echo"<table>$invasion</table>";
	if($totalm>0 OR $totalms>0){
	 	echo"A total of $totalm monsters (+ $totalms scheduled).<BR>";
	}
}else{echo"There are no invasions.<BR>";}




}


}
?>