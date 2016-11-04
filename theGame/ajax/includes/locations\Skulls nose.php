<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<A href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
$output.="<a href='' onclick=\"locationText('pub');return false;\"><font color=white>Greenbeard Saloon</a><BR>";
$output.="<a href='' onclick=\"locationText('stock');return false;\"><font color=white>Stockhouse</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='jail'){
	 $output.="Got nothing left? you can <a href='' onclick=\"locationText('work', 'other');return false;\">clean</a> the cells for 2 gold pieces per minute.<BR><BR>";
	include('textincludes/jail.php');
}elseif($action=='pub'){
## PUB

		if($var1=='buy'){
		 	$buy=$var2;
		 	$cost=0;
			if($buy=='Beer'){$cost=6; $much=3;}
			elseif($buy=='Keg of rum'){$cost=50; $much=1;}

			if($cost>0){
			 	if(payGold($S_user, $cost)==1){
					addItem($S_user, $buy, $much, 'cooked food', '', '', 1);
					$output.="Here's your $buy!<BR>";
				}
			}
		}
		$output.="<BR>Drinks:<BR>";
		$output.="-<a href='' onclick=\"locationText('$action','buy', 'Beer');return false;\">Buy</a> 3 beers (6 gold)<BR>";
		$output.="-<a href='' onclick=\"locationText('$action','buy', 'Keg of rum');return false;\">Buy</a> a Keg of rum (50 gold)<BR>";
		$output.="<BR>";
		$output.="You can try recruit pirates in this pub, <a href='' onclick=\"locationText('work', 'train','stock','stock');return false;\">recruit</a>.<BR>";
		$output.="Or start a <a href='' onclick=\"fighting('Skulls nose');return false;\">barfight</a>...<BR>";


##EINDE PUB
}elseif($action=='stock'){ ## STOCKS
####################################
$saql = "SELECT ID, leader, text,kicklimit, newattack, attackisland FROM sides WHERE location='$S_location' LIMIT 1";
    $resultaaat = mysqli_query($mysqli, $saql);
     while ($record = mysqli_fetch_object($resultaaat))
	 {
		  $island=$record->attackisland;
		  $S_sideid=$record->ID;
		  $leader=$record->leader;
		  $text=$record->text;
		  $kicklimit=$record->kicklimit;
		  $newattack=$record->newattack;
		  if($newattack>0){$newattack=1; $attmins=ceil(($record->newattack-time())/60);}
	  }



if($kicklimit<$timee OR $leader=='' && $newattack<>1){
    if($kicklimit > 0)
    {
		$sql = "INSERT INTO messages (username, sendby, message, time, topic)
		  VALUES ('$leader', '<B>Syrnia</B>', 'Arrr matey...<BR>The pirates mutinied, you did not attack enough. A new pirate leader has been chosen! ', '$timee', 'Mutiny')";
		mysqli_query($mysqli, $sql) or die("DIE 1");
    }

    $saql = "SELECT U.username FROM users U LEFT JOIN stats S ON U.username = S.username WHERE U.side='Pirate' && U.username<>'$leader' AND loggedin > ($timee - 604800) ORDER BY fame asc LIMIT 1";
    $resultaaat = mysqli_query($mysqli, $saql);
    while ($record = mysqli_fetch_object($resultaaat)) { $leader=$record->username; }
    $kicklim=time()+1209600;
    mysqli_query($mysqli, "UPDATE sides SET leader='$leader', kicklimit='$kicklim'  WHERE ID='$S_sideid' LIMIT 1") or die("UPd' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
    $sql = "INSERT INTO messages (username, sendby, message, time, topic)
        VALUES ('$leader', '<B>Syrnia</B>', 'Arrr matey...<BR>The pirates have elected you as their new leader..organize an attack and loot as much gold as you can!', '$timee', 'Promotion')";
    mysqli_query($mysqli, $sql) or die("DIE 2");
    $output.="<B>WE GOT A NEW PIRATE LEADER $leader!</B><BR>";
} else { $hours=ceil(($kicklimit-$timee)/3600);
		$output.="Pirate general $leader has got $hours hours left to attack until pirates mutiny.<BR>";
}

########################
### LAUNCH ATTACK
##########################
if($attmins<0 && $newattack){

$i=1;

$rand = rand(1,100);

//15% chance to send Captain Keelhail
//Changed to 100% for better chance of pirates succeeding
$sendCaptain = $rand <= ($timee < 1313535600 || true ? 100 : 15) ? true : false;
$sendCaptainCity = "";

if($island=='Dearn and Mezno islands')
{
    $rand = rand(1,2);

    //Keep this port free for the captain
    if($sendCaptain && $rand == 1)
    {
        $sendCaptainCity = "Port Dazar";
    }
    else
    {
        $locations[$i++]="Port Dazar";
    }

	$locations[$i++]="Kinam";
	$locations[$i++]="Aunna";
	$locations[$i++]="Nabb mines";
	$locations[$i++]="Unera";
	$locations[$i++]="Lemo woods";
	$locations[$i++]="Deep Lemo woods";

    //Keep this port free for the captain
    if($sendCaptain && $rand == 2)
    {
        $sendCaptainCity = "Xanso";
    }
    else
    {
        $locations[$i++]="Xanso";
    }
 	$locations[$i++]="Berian";
	$locations[$i++]="Mentan";
	$locations[$i++]="Franer Mines";
}
else if($island=='Dearn and Webbers islands')
{
    $rand = rand(1,2);

    //Keep this port free for the captain
    if($sendCaptain && $rand == 1)
    {
        $sendCaptainCity = "Port Dazar";
    }
    else
    {
        $locations[$i++]="Port Dazar";
    }
	$locations[$i++]="Kinam";
	$locations[$i++]="Aunna";
	$locations[$i++]="Nabb mines";
	$locations[$i++]="Unera";
	$locations[$i++]="Lemo woods";
	$locations[$i++]="Deep Lemo woods";

    //Keep this port free for the captain
    if($sendCaptain && $rand == 2)
    {
        $sendCaptainCity = "Web haven";
    }
    else
    {
        $locations[$i++]="Web haven";
    }
	$locations[$i++]="Silk woods";
	$locations[$i++]="Webbed forest";
	$locations[$i++]="Sorer mines";
	$locations[$i++]="Sorer lair";
}
else if($island=='Mezno and Webbers islands')
{
    $rand = rand(1,2);

	//Keep this port free for the captain
    if($sendCaptain && $rand == 1)
    {
        $sendCaptainCity = "Xanso";
    }
    else
    {
        $locations[$i++]="Xanso";
    }
 	$locations[$i++]="Berian";
	$locations[$i++]="Mentan";
	$locations[$i++]="Franer Mines";

	//Keep this port free for the captain
    if($sendCaptain && $rand == 2)
    {
        $sendCaptainCity = "Web haven";
    }
    else
    {
        $locations[$i++]="Web haven";
    }
	$locations[$i++]="Silk woods";
	$locations[$i++]="Webbed forest";
	$locations[$i++]="Sorer mines";
	$locations[$i++]="Sorer lair";
}
else if($island=='Dearn, Mezno and Webbers islands')
{
    $rand = rand(1,3);

	//Keep this port free for the captain
    if($sendCaptain && $rand == 1)
    {
        $sendCaptainCity = "Port Dazar";
    }
    else
    {
        $locations[$i++]="Port Dazar";
    }
	$locations[$i++]="Kinam";
	$locations[$i++]="Aunna";
	$locations[$i++]="Nabb mines";
	$locations[$i++]="Unera";
	$locations[$i++]="Lemo woods";
	$locations[$i++]="Deep Lemo woods";

	//Keep this port free for the captain
    if($sendCaptain && $rand == 2)
    {
        $sendCaptainCity = "Xanso";
    }
    else
    {
        $locations[$i++]="Xanso";
    }
 	$locations[$i++]="Berian";
	$locations[$i++]="Mentan";
	$locations[$i++]="Franer Mines";

	//Keep this port free for the captain
    if($sendCaptain && $rand == 3)
    {
        $sendCaptainCity = "Web haven";
    }
    else
    {
        $locations[$i++]="Web haven";
    }
	$locations[$i++]="Silk woods";
	$locations[$i++]="Webbed forest";
	$locations[$i++]="Sorer mines";
	$locations[$i++]="Sorer lair";
}

$cities = $i - 1;

//$output .= "array_count_values: " . $cities . " <br/>";

/*for($i=1; $i <= $cities; $i++)
{
    $output .= $locations[$i] . "<br/>";
}*/

$randUnique = array(); // This holds an array of used random numbers

while($loc1==false OR $loc2==false OR $loc3==false OR $loc4==false OR $loc5==false OR $loc6==false OR $loc7==false){

	$rand=rand(1, $cities);

	if (in_array($rand, $randUnique)){ // If current random number is in the used list, do nothing.

	} else { // Else pick and save the location

		$randUnique[] = $rand;

		if($locations[$rand])
        {
			if($loc1==false)
            {
				$loc1 = $locations[$rand];
			}
            else if($loc2==false)
            {
				$loc2 = $locations[$rand];
			}
            else if($loc3==false)
            {
				$loc3 = $locations[$rand];
			}
            else if($loc4==false)
            {
				$loc4 = $locations[$rand];
			}
            else if($loc5==false)
            {
				$loc5 = $locations[$rand];
			}
            else if($loc6==false)
            {
				$loc6 = $locations[$rand];
			}
            else
            {
				$loc7 = $locations[$rand];
			} // if
		} // if
	} // if
} // while

$count = 0;
$saql = "SELECT much FROM sidesstock WHERE name='Brigantine' && sideid='$S_sideid' LIMIT 1";
    $resultaaat = mysqli_query($mysqli, $saql);
     while ($record = mysqli_fetch_object($resultaaat)) { $much=$record->much; }
$boatcap=$much*500;
$tot=0; $dreadmuch=0; $piratemuch=0; $keelhailmuch=0; $roughneckmuch=0; $peglegmuch=0; $buccaneermuch=0; $hookedmuch=0;
$saql = "SELECT much, name FROM sidesstock WHERE type='creature' && sideid='$S_sideid'";
    $resultaaat = mysqli_query($mysqli, $saql);  $muchp='';
     while ($record = mysqli_fetch_object($resultaaat)) {
if(($tot+$record->much)>$boatcap){ $much=$boatcap-$tot;} else{$much=$record->much;}

if($much > 0)
{
    $count++;
}

if($record->name=='Hooked pirate'){ $hookedmuch=$much; }
else if($record->name=='Buccaneer'){ $buccaneermuch=$much; }
else if($record->name=='Pegleg'){ $peglegmuch=$much; }
else if($record->name=='Roughneck'){ $roughneckmuch=$much; }
else if($record->name=='Keelhails pirate'){ $keelhailmuch=$much; }
else if($record->name=='Dread pirate'){ $dreadmuch=$much; }
else if($record->name=='Pirate'){ $piratemuch=$much; }
$tot=$tot+$much;
}

$lessboats=ceil($tot/500);
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$lessboats'  WHERE name='Brigantine' && sideid='$S_sideid' LIMIT 1") or die("234");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$piratemuch'  WHERE name='Pirate' && sideid='$S_sideid' LIMIT 1") or die("342UPd' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$dreadmuch'  WHERE name='Dread pirate' && sideid='$S_sideid' LIMIT 1") or die("345UPd' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$keelhailmuch'  WHERE name='Keelhails pirate' && sideid='$S_sideid' LIMIT 1") or die("UP654654d' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$roughneckmuch'  WHERE name='Roughneck' && sideid='$S_sideid' LIMIT 1") or die("UP654654d' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$peglegmuch'  WHERE name='Pegleg' && sideid='$S_sideid' LIMIT 1") or die("UP654654d' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$buccaneermuch'  WHERE name='Buccaneer' && sideid='$S_sideid' LIMIT 1") or die("UP654654d' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$hookedmuch'  WHERE name='Hooked pirate' && sideid='$S_sideid' LIMIT 1") or die("UP654654d' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
mysqli_query($mysqli, "UPDATE sides SET newattack='', attackisland='', totalinvasions=$count, failed=0 WHERE ID='$S_sideid' LIMIT 1") or die("U4564Pd' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");

$monster1='Pirate'; $monstermuch1=$piratemuch;
$monster2='Dread pirate';  $monstermuch2=$dreadmuch;
$monster3='Keelhails pirate'; $monstermuch3=$keelhailmuch;
$monster4='Roughneck'; $monstermuch4=$roughneckmuch;
$monster5='Pegleg'; $monstermuch5=$peglegmuch;
$monster6='Buccaneer'; $monstermuch6=$buccaneermuch;
$monster7='Hooked pirate'; $monstermuch7=$hookedmuch;

$time1=time()+($monstermuch1*8 < 3600 ? 3600 : $monstermuch1*8);
$time2=time()+($monstermuch2*8 < 3600 ? 3600 : $monstermuch2*8);
$time3=time()+($monstermuch3*8 < 3600 ? 3600 : $monstermuch3*8);
$time4=time()+($monstermuch4*8 < 3600 ? 3600 : $monstermuch4*8);//+(rand(0,15)*60);
$time5=time()+($monstermuch5*8 < 3600 ? 3600 : $monstermuch5*8);//+(rand(0,20)*60);
$time6=time()+($monstermuch6*10 < 3600 ? 3600 : $monstermuch6*10);//+(rand(0,25)*60);
$time7=time()+($monstermuch7*12 < 3600 ? 3600 : $monstermuch7*12);//+(rand(0,30)*60);
$totalattackers=$monstermuch1+$monstermuch2+$monstermuch3+$monstermuch4+$monstermuch5+$monstermuch6+$monstermuch7; $locs='';

if($monstermuch1>0){
      $sql = "DELETE FROM locations WHERE location='$loc1'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc1'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
	$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
	 VALUES ('$loc1', '$monster1', '$monstermuch1', '$time1', 'invasion', 'Pirate')";
	mysqli_query($mysqli, $saaql) or die("EROR");
	 $locs=$loc1;
	 $output.="$monstermuch1 $monster1 are attacking $loc1.<br/>";
 }

if($monstermuch2>0){
      $sql = "DELETE FROM locations WHERE location='$loc2'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc2'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc2', '$monster2', '$monstermuch2', '$time2', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs, $loc2";
  $output.="$monstermuch2 $monster2 are attacking $loc2.<br/>";
 }

if($monstermuch3>0){
      $sql = "DELETE FROM locations WHERE location='$loc3'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc3'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc3', '$monster3', '$monstermuch3', '$time3', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs, $loc3";
$output.="$monstermuch3 $monster3 are attacking $loc3.<br/>";
 }

 if($monstermuch4>0){
      $sql = "DELETE FROM locations WHERE location='$loc4'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc4'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc4', '$monster4', '$monstermuch4', '$time4', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs, $loc4";
  $output.="$monstermuch4 $monster4 are attacking $loc4.<br/>";
 }

 if($monstermuch5>0){
      $sql = "DELETE FROM locations WHERE location='$loc5'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc5'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc5', '$monster5', '$monstermuch5', '$time5', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs, $loc5";
  $output.="$monstermuch5 $monster5 are attacking $loc5.<br/>";
 }

 if($monstermuch6>0){
      $sql = "DELETE FROM locations WHERE location='$loc6'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc6'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc6', '$monster6', '$monstermuch6', '$time6', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs, $loc6";
  $output.="$monstermuch6 $monster6 are attacking $loc6.<br/>";
 }

 if($monstermuch7>0){
      $sql = "DELETE FROM locations WHERE location='$loc7'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
      $sql = "DELETE FROM invasions WHERE location='$loc7'";
      mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
$saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, side)
 VALUES ('$loc7', '$monster7', '$monstermuch7', '$time7', 'invasion', 'Pirate')";
mysqli_query($mysqli, $saaql) or die("EROR");
 $locs="$locs and $loc7";
  $output.="$monstermuch7 $monster7 are attacking $loc7.<br/>";
 }


### ADD CHAT MESSAGE
$SystemMessage=1;
$BoldSystemMessage=1;
$chatMessage="$totalattackers pirates are attacking: $locs";
$channel=6;
include_once('../../currentRunningVersion.php');

include(GAMEPATH."scripts/chat/addchat.php");
### EINDE CHAT MESSAGE

if($sendCaptain)
{
    $sql = "SELECT hp FROM monsters WHERE name='Captain Keelhail' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $hishp = floor($record->hp * 1.1 + 3);
    }

    $sql = "DELETE FROM partyfight WHERE location='$sendCaptainCity' LIMIT 1";
    mysqli_query($mysqli, $sql) or die("error repor32443t this bug pleaseMESSAGE");

    $saaql = "INSERT INTO partyfight (location, monster, hp) VALUES ('$sendCaptainCity', 'Captain Keelhail', '$hishp')";
    mysqli_query($mysqli, $saaql) or die("ERO3R");

    ### ADD CHAT MESSAGE
    $SystemMessage=1;
    $BoldSystemMessage=1;
    $chatMessage="Captain Keelhail has also decided to join this attack personally!";
    $channel=6;
    include_once('../../currentRunningVersion.php');

    include(GAMEPATH."scripts/chat/addchat.php");
    ### EINDE CHAT MESSAGE
}

$output.="<br/><B>$totalattackers pirates are attacking: $locs." . ($sendCaptain ? "<br/>Captain Keelhail has also decided to join this attack personally!" : "") . "</B><br/><br/>";


 }
########################
### EINDE OF LAUNCH ATTACK
##########################

$resultaaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && monstersmuch>0 LIMIT 1");
$aantal = mysqli_num_rows($resultaaat);
if($aantal>0){$newattack=1;}


if($var1=='leader' && $S_user==$leader){

	$output.="<a href='' onclick=\"locationText('stock', 'leader', 'message');return false;\">Change stockhouse message</a><BR>";
	if($newattack<>1){ $output.="<a href='' onclick=\"locationText('stock', 'leader', 'attack');return false;\">Attack affairs</a><BR>"; } else{ $output.="Attack affairs- Attacking $island in $attmins minutes.<BR>"; }
	$output.="<a href='' onclick=\"locationText('stock', 'leader', 'requests');return false;\">Change stock requests</a><BR>";
	$output.="<a href='' onclick=\"locationText('stock');return false;\">Back to stockhouse</a><BR>";
	$output.= "<BR><BR>";

	if($var2==message){

		if($var3){
			$newtext=htmlentities(trim($var3));
			//$newtekst = nl2br($newtext);
			$newtext = str_replace("\n", "\\n", $newtext);
			mysqli_query($mysqli, "UPDATE sides SET text='$newtext' WHERE ID='$S_sideid' LIMIT 1") or die("e33333333rr22or --> 1 $much--$get aaa");
			$output.="[$newtext] You have successfully spread a new order!<BR>";
		} else{

		 $text=str_replace('
', "\\n", $text);

			$output.="Change the stockhouse message:<BR><BR>";
			$output.="<textarea cols=20 rows=10 id=newPText>$text</textarea><BR>";
			$output.="<input type=submit value=Add onclick=\"locationText('stock', 'leader', 'message', $('newPText').value);return false;\">";
		}
	}elseif($var2=='requests'){ #REQ

		if(is_numeric($var3) && is_numeric($var4)){
			mysqli_query($mysqli, "UPDATE sidesstock SET request='$var4'  WHERE ID='$var3' && sideid='$S_sideid' LIMIT 1") or die("e33333333rr22or --> 1 $much--$get aaa");
			$output.="Updated request.<BR>";
		}

		$output.="<table><tr><td>Name<td>Stock<td>Needed<td>Requested";
		$saql = "SELECT ID, name, much, request, (request-much) as nognodig FROM sidesstock WHERE sideid='$S_sideid' ORDER BY type ASC";
		    $resultaaat = mysqli_query($mysqli, $saql);
		     while ($record = mysqli_fetch_object($resultaaat)) { $nognodig=$record->nognodig; if($nognodig<0 OR $nognodig>1000000){$nognodig=0;} else{ $nognodig="<B>$nognodig</B>"; }
		$output.="<tr><td>$record->name<td>$record->much<td>$nognodig<td><form onsubmit=\"locationText('stock', 'leader', 'requests', $record->ID, $('reqPEdit$record->ID').value);return false;\"><input type=text id=reqPEdit$record->ID value=$record->request class=input>";
		$output.="<input type=submit value=edit class=button></form>"; }
		$output.="</table>";

	} elseif($var2=='attack' && $newattack!=1){

		$attisland=$var3;

		$saql = "SELECT much FROM sidesstock WHERE type='creature' && sideid='$S_sideid'";
		    $resultaaat = mysqli_query($mysqli, $saql);  $muchp='';
		     while ($record = mysqli_fetch_object($resultaaat)) { $muchp=$muchp+$record->much; }

		$saql = "SELECT much FROM sidesstock WHERE name='Brigantine' && sideid='$S_sideid' LIMIT 1";
		    $resultaaat = mysqli_query($mysqli, $saql);
		     while ($record = mysqli_fetch_object($resultaaat)) { $much=$record->much; }

		$boatcap=$much*500;
		$output.="You have got $much boats capable to transport $boatcap pirates, you have got $muchp pirates ready to attack.<BR>";

		if($muchp>=500){
		//	if($att!=1){
		//		$output.="<a href=?p=stock&action=leader&option=attack&att=1>Attack</a>";
		//	}else{

				if($attisland){

					$hours=rand(1,12);  $hourtime=time()+$hours*3600;
					$kicklim=time()+1209600;
					mysqli_query($mysqli, "UPDATE sides SET kicklimit='$kicklim', newattack='$hourtime', attackisland='$attisland' WHERE ID='$S_sideid' LIMIT 1") or die("UPd' LIMIT 1  e33333333rr22or --> 1 $much--$get aaa");
					$output.="All pirates are preparing for the attack, we will attack within $hours hours.<BR>";

						### ADD CHAT MESSAGE
						$SystemMessage=1;
						$BoldSystemMessage=1;
						//$chatMessage="We are preparing an attack, we will attack $attisland in $hours hours.";
                        $chatMessage = "The signal has been given! Pirate forces have been assembled and will launch an attack soon. ARRR";
						$channel=6;
						include_once('../../currentRunningVersion.php');

						include(GAMEPATH."scripts/chat/addchat.php");
						### EINDE CHAT MESSAGE


				}else{
					$output.="Attack island <select id=Pattisland>" .
                        "<option value='Dearn and Mezno islands'>Dearn and Mezno islands</option>" .
                        "<option value='Dearn and Webbers islands'>Dearn and Webbers islands</option>" .
                        "<option value='Mezno and Webbers islands'>Mezno and Webbers islands</option>" .
                        "<option value='Dearn, Mezno and Webbers islands'>Dearn, Mezno and Webbers islands</option></select>";
					$output.="<input type=submit value=Attack  onclick=\"locationText('stock', 'leader', 'attack', $('Pattisland').value);return false;\">";
				}#ISLAND

			//}
		}


	}

} else { #LEADER

$saql = "SELECT monsters, monstersmuch, invasiontime,location  FROM locations WHERE side='Pirate' && monstersmuch>0 ";
    $resultaaat = mysqli_query($mysqli, $saql);
     while ($record = mysqli_fetch_object($resultaaat)) {
		  $timeleft=ceil(($record->invasiontime-time())/60);
		 $output.="<font color=red>We are currently attacking $record->location with $record->monsters.<br />There are $record->monstersmuch left";
		if($timeleft>0 && $record->monstersmuch>0){
	 		$output.=" and we have $timeleft minutes left until we capture.";
		} elseif($record->monstersmuch>0){
	 		$output.=", we have captured this location!";
		}
		$output.="</font><BR><BR>";
	 }



if($leader==$S_user){ $output.="<a href='' onclick=\"locationText('stock', 'leader');return false;\">Control the stockhouse</a><BR><BR>";}
$output.="Arrr matey, help us by collecting all the resources we need for the next attack!<BR>";
$output.="Our current leader $leader has set some requests on various resources.<BR>";
$output.="It'd be nice if we got all of the requested items.<BR>";
$output.="The more you help building up the stock, the more you will be credited after the next successful attack.<BR>";
$output.="<BR>";
$output.="The last message of $leader:<BR>";
$text=str_replace('
', "<br />", $text);
$text=str_replace('\n', "<br />", $text);
$text=str_replace('\\n', "<br />", $text);
$text=str_replace('\\\\n', "<br />", $text);
$output.="<i>$text</i><BR><BR>";

$output.="<center>";

if($var1=='addItem'){
	$prodid=$var2;
	$addprod=round($var3);
}
if($addprod>=1 && $prodid && $newattack<>1){### ADD

	$saql = "SELECT name, score FROM sidesstock WHERE ID='$prodid' && sideid='$S_sideid' && type<>'creature' LIMIT 1";
	$resultaaat = mysqli_query($mysqli, $saql);
	while ($record = mysqli_fetch_object($resultaaat)) { $name=$record->name;  $score=$record->score;}

	$saql = "SELECT much FROM items_inventory WHERE name='$name' && username='$S_user' && itemupgrade=''   LIMIT 1";
	$resultaaat = mysqli_query($mysqli, $saql);
	while ($record = mysqli_fetch_object($resultaaat)) { $much=$record->much;}

	if($addprod>$much){ $addprod=$much; }

	if($addprod>0 && is_numeric($addprod) && $much){
		$score=$score*$addprod;
		mysqli_query($mysqli, "UPDATE stats SET sidescore=sidescore+'$score' WHERE username='$S_user' LIMIT 1") or die("111111111 $much--$get aaa");
		removeItem($S_user, $name, $addprod, '', '', 1);
		mysqli_query($mysqli, "UPDATE sidesstock SET much=much+'$addprod' WHERE name='$name' && sideid='$S_sideid' LIMIT 1") or die("e33333333rr22or --> 1 $much--$get aaa");
		$output.="<B>You added $addprod $name to the stock!<BR></B>";
	}
} ## ADD

if($newattack==1){

 	$output.="<B>We are attacking $island islands " . ($leader==$S_user ? "in $attmins minutes" : "soon") . ", therefore you cannot access the stockhouse at the moment.<BR></B>";
}

$output.="<Table width=450 bgcolor=999999 border=1>"; $crea='';
$output.="<tr bgcolor=333333><tr><td><td><B>Resources & other materials</B><Td><B>Add<td><B>Current<td><B>Requested";

$remoteStock = "<table class='innerTable'>";
$remoteStockPirates = "";
$currentType = "";

$saql = "SELECT ID,name, cast(request-much as signed) as nognodig, request, much, type,worklink FROM sidesstock WHERE sideid='$S_sideid' order by type ASC, nognodig desc";
    $resultaaat = mysqli_query($mysqli, $saql);
     while ($record = mysqli_fetch_object($resultaaat)) {
		if($record->type=='creature'){
			$nognodig=$record->nognodig; if($nognodig<0 OR $nognodig>1000000){$nognodig=0;} else{ $nognodig="<B>$nognodig</B>"; }
			$crea="$crea<tr><td width=45><Td>".($record->name)."s<td>$record->much<td>$nognodig";

            if($currentType != $record->type)
            {
                $currentType = $record->type;
                $remoteStockPirates .= "<tr style='border: 0px !important;'><th colspan=4 style='border: 0px !important;'><br/>Pirates" .
                    "</td></tr><tr><th>Item</th><th>Current</th><th>Requested</th><th>Remaining</th></tr>";
            }

            $remoteStockPirates .= "<tr><td>$record->name</td><td>$record->much</td><td>$record->request</td><td>$nognodig</td></tr>";
		} else{
			if($record->worklink && $newattack!=1 && ($record->request/**1.25*/)>$record->much){
				if(strstr($record->type, "food")){$what="Cook"; }
				elseif(strstr($record->type, "boat")){$what="Build"; }
				elseif(strstr($record->type, "ore")){$what="Smelt"; }
				$link="<a href='' onclick=\"locationText($record->worklink);return false;\">$what</a>";
			}else{
			 	$link='';
			}
			$nognodig=$record->nognodig;
			if($nognodig<0 OR $nognodig>1000000){
			 	$nognodig=0;
			} else{
			 	$nognodig="<b>$nognodig</b>";
			}
			$output.="<tr><td width=45><img src=\"images/inventory/$record->name.gif\" border=1><Td>$record->name $link<td width=10>";
			if($newattack<>1 && ($record->request/**1.25*/)>$record->much){
			 	$output.="<form onsubmit=\"locationText('stock', 'addItem', '$record->ID',$('addprod$record->ID').value);return false;\"><input type=text size=1 id='addprod$record->ID' class=input>";
				$output.="<input type=submit value=add class=button></form>";
			}
			$output.="<td width=25>$record->much<td width=25>$nognodig";

            if($currentType != $record->type)
            {
                $currentType = $record->type;
                $remoteStock .= "<tr style='border: 0px !important;'><th colspan=4 style='border: 0px !important;'><br/>" . ucfirst($record->type) .
                    "</td></tr><tr><th>Item</th><th>Current</th><th>Requested</th><th>Remaining</th></tr>";
            }

            $remoteStock .= "<tr><td>$record->name</td><td>$record->much</td><td>$record->request</td><td>$nognodig</td></tr>";
		}
}

$remoteStock .= "$remoteStockPirates</table>";

$remoteStock = str_replace("'", "''", $remoteStock);


mysqli_query($mysqli, "UPDATE forummessages SET message='" . $remoteStock . "' WHERE ID IN (1298661, 1274898) AND username = 'Captain Keelhail'") or die("111111111 $much--$get aaa");
mysqli_query($mysqli, "UPDATE forumtopics SET lastreply='$time' WHERE ID IN (202286, 205922) AND username = 'Captain Keelhail'") or die("111111111 $much--$get aaa");

$output.="<tr bgcolor=333333><tr><td><td><B>Pirates</B><Td><B>Current<td><B>Requested";
$output.="$crea";
$output.="</table>";
//$output.= "<br/><br/>UPDATE forummessages SET message='" . str_replace("<", "&lt;", $remoteStock) . "' WHERE topic IN (202286) LIMIT 1<br/><br/>";
$output.="</center>";

}#leader

}else{
$output.="Skulls nose is the largest city on Skull Island, and the home town of Pirate Keelhail.  Many aspiring pirates come here to see if they have what it takes to become a full-fledged pirate.  The popular Greenbeard Saloon is also located here, where bar fights are a daily routine.  The Skull Island jail is also found here, almost always at full capacity from the lawless pirate who inhabit the island.  The noisest place on the island is the stockhouse, where pirates prepare for their next plundering adventure. ";
}


}
}
?>