<?php
// username= $S_user;

//The titles show explain the functions
//Examples are listed below the functions

function parseQuestText($text, $action){
	global $S_user, $p, $S_heshe, $quest;

	$text = str_replace ('$user' , "$S_user", "$text");
	$text = str_replace ('$p' , "$p", "$text"); #voor links
	$text = str_replace ('$Sheshe' , "$S_heshe", "$text");
	$text = str_replace ('$quest' , "$quest", "$text");
	if($action){
		$text = str_replace ("'quest'," , "'$action',", "$text");
	}
	$text = str_replace ('
' , "", "$text");
	$text=stripslashes($text);

	return $text;
}



function finishedQuest($questID){
	return stristr($_SESSION['S_questscompleted'], "[$questID]")==true;
}

function doingQuest($questID, $subID = null){
	if($subID===null){
		return stristr($_SESSION['S_quests'], "$questID(")==true;
	}
	return stristr($_SESSION['S_quests'], "$questID($subID)")==true;
}

function groupQuestActive($location, $type)
{
 	global $mysqli;

	$sql = "SELECT * FROM `groupquestslist` WHERE location = '$location'" .
        ($type ? " AND (gathername = '$type' OR killtype = '$type')" : "") .
        " AND (killed < kills OR gathered < gathermuch) ORDER BY subID ASC LIMIT 1";

    $resultset = mysqli_query($mysqli, $sql);
    if($record = mysqli_fetch_object($resultset))
    {
		return true;//$record->kills - $record->killed + $record->gathermuch - $record->gathered > 0;
	}

    return false;
}

function groupQuestStageComplete($questID)
{
 	global $mysqli;

	$sql = "SELECT subID FROM `groupquestslist` WHERE questID = $questID" .
        " AND (killed >= kills AND gathered >= gathermuch) ORDER BY subID DESC LIMIT 1";

    $resultset = mysqli_query($mysqli, $sql);
    if($record = mysqli_fetch_object($resultset))
    {
		return $record->subID;
	}

    return 0;
}

function groupQuestParticipation($questID, $maxSubID)
{
    global $mysqli;
 	global $S_user;

	$sql = "SELECT SUM(amount) AS amount" .
        " FROM  `groupquestresults`" .
        " WHERE username =  '$S_user'" .
        " AND questID = $questID" .
        " AND subID <= $maxSubID";

    $resultset = mysqli_query($mysqli, $sql);
    if($record = mysqli_fetch_object($resultset))
    {
        if($record->amount > 0)
        {
            return $record->amount;
        }
	}

    return 0;
}

function reportError($usert, $text){
 	$timee=time();

 	global $mysqli;
 	global $S_user;
 	if(!$S_user){
 		$user=$usert;
 	}
	 $saaql = "INSERT INTO bugreports (username, text, time, type)
	 	VALUES ('$user', '$text', '$timee', 'functions')";
		mysqli_query($mysqli,$saaql) or die("Func Item add error 2, please report !");

}

function bonusExp($skill, $exp)
{
    if(date("Y-m-")=='2012-02-' && $exp < 1000 && $skill != 'thieving' && $skill != 'magic' && $skill != 'farming')
    {
        $exp = ceil($exp*1.2);
    }

    return $exp;
}

function addExp($levelArray, $skill, $exp){
	if($exp<0 || !is_numeric($exp)){
		reportError($username, "invalid AddExp - $levelArray, $skill, $exp ".$_SERVER["REQUEST_URI"] );
	}

	$levelArray[$skill]['exp']+=$exp;

	if($levelArray[$skill]['nextLevel']<=$exp){
		$levelArray[$skill]['level']=floor(pow($levelArray[$skill]['exp'], 1/3.507655116));
		$levelArray[$skill]['nextLevel']=ceil(exp( 3.507655116001 * log($levelArray[$skill]['level']+1) ))-$levelArray[$skill]['exp'];
		echo"levelUp('$skill', " . ($levelArray[$skill]['level']) . ");";
		if($skill=='health' || $skill=='attack' || $skill=='defence' || $skill=='strength'){
			$level=floor($levelArray['attack']['level']/3+$levelArray['defence']['level']/3+$levelArray['strength']['level']/3+$levelArray['health']['level']/5);
			echo"$('statsCombatLevelText').innerHTML=\"$level\";";
		}
		if($skill=='health'){
			$maxhp=floor($levelArray['health']['level']*1.1+3);
			echo"$('statsMaxHPText').innerHTML=\"$maxhp\";";
		}
	}else{
		$levelArray[$skill]['nextLevel']-=$exp;
	}

	return $levelArray;
}


function addItem($username, $itemName, $itemMuch, $itemType, $itemUpgrade, $itemUpgradeMuch, $updateJavaScript){
 	if($itemMuch<1 || !is_numeric($itemMuch)){
		reportError($username, "itemMuch in addItem less than 1 - $username, $itemName, $itemMuch, $itemType, $itemUpgrade, $itemUpgradeMuch, $updateJavaScript".$_SERVER["REQUEST_URI"] );
	}
 	global $mysqli;
	$resultaat = mysqli_query($mysqli,"SELECT ID FROM items_inventory WHERE username='$username' && name='$itemName' && itemupgrade='$itemUpgrade'  && upgrademuch='$itemUpgradeMuch' LIMIT 1");
   	while ($rec = mysqli_fetch_object($resultaat))
	{
		$itemIDIfExcists=$rec->ID;
	}
   	if($itemIDIfExcists){
   	  	$sqla = "UPDATE items_inventory SET much=much+'$itemMuch' WHERE ID='$itemIDIfExcists' LIMIT 1";
      	mysqli_query($mysqli,$sqla) or die("Func Item add error 1, please report !");
   	}else{
   		$saaql = "INSERT INTO items_inventory (username, much, type, name, itemupgrade, upgrademuch)
	 	VALUES ('$username', '$itemMuch', '$itemType', '$itemName', '$itemUpgrade', '$itemUpgradeMuch')";
		mysqli_query($mysqli,$saaql) or die("Func Item add error 2, please report !");
		$itemIDIfExcists=mysqli_insert_id($mysqli);
	}

	if($updateJavaScript==1){

		if($itemUpgradeMuch>0){$plus="+"; }else{ $plus=''; }
		if($itemUpgrade){
		  	$upg=" [$plus$itemUpgradeMuch $itemUpgrade]";
		 	$upg2="images/ingame/$itemUpgrade.jpg";
		}else{
			$upg=''; $upg2='';
		}
		$title="$itemName$upg";

		echo "addItemToContainer('playerInventory', 'itemI_$itemIDIfExcists', '$title', '$itemMuch', '$upg2');";
	}

	return $itemIDIfExcists;

}//addItem($S_user, 'Bronze legs', 1, legs);
	//addItem($S_user, 'Bronze legs', 1, legs, 'Armour', 5, 1);


function itemAmount($S_user, $itemName, $itemType, $itemUpgrade, $itemUpgradeMuch){
   global $mysqli;
   $sqal = "SELECT much FROM items_inventory WHERE username='$S_user' && name='$itemName' && itemupgrade='$itemUpgrade'  && upgrademuch='$itemUpgradeMuch' LIMIT 1";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat)) {
		return $record->much;
	}
	return 0;
}//itemAmount($S_user, 'Bronze legs', legs);
//itemAmount($S_user, 'Bronze legs', legs, 'Armour', 5);


function removeItem($S_user, $itemName, $itemMuch, $itemUpgrade, $itemUpgradeMuch, $updateJavaScript) {
   if($itemMuch<1 || !is_numeric($itemMuch) ){
		reportError($S_user, "itemMuch in remove less than 1: ($S_user, $itemName, $itemMuch, $itemUpgrade, $itemUpgradeMuch, $updateJavaScript) ".$_SERVER["REQUEST_URI"]);
	}
	global $mysqli;

   	$resultaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE username='$S_user' && name='$itemName' && much<='$itemMuch' && itemupgrade='$itemUpgrade'  && upgrademuch='$itemUpgradeMuch' LIMIT 1");
   	$delete = mysqli_num_rows($resultaat);
	if($delete>=1){
		$sqla = "DELETE FROM items_inventory WHERE username='$S_user' && name='$itemName' && itemupgrade='$itemUpgrade'  && upgrademuch='$itemUpgradeMuch' LIMIT 1";
    	mysqli_query($mysqli, $sqla) or die("Func Item r error 3, please report !");
	}else{
   		$sqla = "UPDATE items_inventory SET much=much-'$itemMuch' WHERE username='$S_user' && name='$itemName' && itemupgrade='$itemUpgrade'  && upgrademuch='$itemUpgradeMuch' LIMIT 1";
    	mysqli_query($mysqli, $sqla) or die("Func Item r error 3, please report !");
	}

    if($updateJavaScript==1){
     	if($itemUpgradeMuch>0){$plus="+"; }else{ $plus=''; }
		if($itemUpgrade){
		  	$upg=" [$plus$itemUpgradeMuch $itemUpgrade]";
		 	$upg2="images/ingame/$itemUpgrade.jpg";
		}else{
			$upg=''; $upg2='';
		}
		$title="$itemName$upg";
		echo "removeItemFromContainer('playerInventory', '$title', '$itemMuch');";
	}
}//removeItem('Bronze legs', 1);
// removeItem('Bronze legs', 1, 'Armour', 5);


function getGold($S_user, $much){
	global $mysqli;
	if($much>=0 && is_numeric($much)){
   	   	$sqla = "UPDATE users SET gold=gold+'$much' WHERE username='$S_user' LIMIT 1";
      	mysqli_query($mysqli, $sqla) or die("Func Item p error 4.556, please report !");
		echo"$('statsGoldText').innerHTML=parseInt($('statsGoldText').innerHTML)+parseInt($much);";
		return 1;
	}else{
		return 2;
	}
}

function hasGold($S_user){
	global $mysqli;
   	$sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		return $record->gold;
	}
	return 0;
}

function payGold($S_user, $much){
 	if($much<0 || !is_numeric($much)){
		reportError($S_user, "paygold is less than 0 ! in functions.php  $S_user - $much".$_SERVER["REQUEST_URI"]);
	}
	global $mysqli;
	if($much>=0 && is_numeric($much)){
	    $resultaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$S_user' && gold>='$much' LIMIT 1");
   		$canpay = mysqli_num_rows($resultaat);
   		if($canpay==1){
   	   		$sqla = "UPDATE users SET gold=gold-'$much' WHERE username='$S_user' LIMIT 1";
      		mysqli_query($mysqli, $sqla) or die("Func Item p error 4.5, please report !");
			echo"$('statsGoldText').innerHTML=parseInt($('statsGoldText').innerHTML)-parseInt($much);";
			return 1;
		}else{
			return -1;
		}
	}else{
		return 2;
	}
}

function payGoldNoEcho($S_user, $much){
 	if($much<0 || !is_numeric($much)){
		reportError($S_user, "paygold is less than 0 ! in functions.php  $S_user - $much".$_SERVER["REQUEST_URI"]);
	}
	global $mysqli;
	if($much>=0 && is_numeric($much)){
	    $resultaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$S_user' && gold>='$much' LIMIT 1");
   		$canpay = mysqli_num_rows($resultaat);
   		if($canpay==1){
   	   		$sqla = "UPDATE users SET gold=gold-'$much' WHERE username='$S_user' LIMIT 1";
      		mysqli_query($mysqli, $sqla) or die("Func Item p error 4.6, please report !");
			return 1;
		}else{
			return -1;
		}
	}else{
		return 2;
	}
}
// payGold($S_user, 100);
//return 1=OK, return 0=not enough cash, return 2=Invalid input.



function removeDurability($itemName, $S_user){
	global $mysqli;
	//////////////////
	 	$sql = "SELECT ID, name, itemupgrade, upgrademuch, type FROM items_wearing WHERE name='$itemName' && username='$S_user' LIMIT 1";
		$resultaat = mysqli_query($mysqli, $sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
            //echo "unwearItem('$record->type');";
			if($record->itemupgrade=='Durability' && $record->upgrademuch>=1){  ##DURABILITY
				if($record->upgrademuch>=1){
                    echo "messagePopup('Your $record->name was damaged, the durabilty bonus was reduced by one.', 'Durability');";
					mysqli_query($mysqli, "UPDATE items_wearing SET upgrademuch=upgrademuch-1 WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this  BREAK buAGE");
                    include_once('includes/wearstats.php');
                    wearStats($S_user, 1);
				//}else if($record->upgrademuch==1){
				//		mysqli_query($mysqli, "UPDATE items_wearing SET upgrademuch=0, itemupgrade='' WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this  BREAK buAGE");
					}else{
						mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this  BREAK buAGE");
                        echo "unwearItem('$record->type');";
                        return 1;
					}
			}else{ #NO DURAB
				mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$record->ID' LIMIT 1") or die("error report this BREAK bug pleaseMESSAGE");
                echo "unwearItem('$record->type');";
				return 1;
			}
	 }
	 return 0;
 }

function RebuildDropList()
{
    global $mysqli, $S_user, $S_location;
    echo"if(\$('centerDropList')){\$('centerDropList').innerHTML='';";
    //// LOAD ALL DROPPED ITEMS ONCE
    $playerInventoryContents=$playerInventoryEvents='';
    $i =0;
    $sql = "SELECT ID.ID, ID.name, ID.much, ID.type, ID.itemupgrade, ID.upgrademuch FROM items_dropped ID
    LEFT JOIN item_types T ON T.name = ID.type
    LEFT JOIN items I ON I.name = ID.name
    WHERE location='$S_location' && (ID.type!='quest' || droppedBy='$S_user') ORDER BY T.rank < 0 ASC, T.rank = 0 ASC, T.rank ASC, ID.type ASC, I.rank, ID.name ASC, ID.itemupgrade ASC, ID.upgrademuch ASC";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $imagename=str_replace(' ', '%20', $record->name);
        if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
        if($record->itemupgrade){
            $upg=" [$plus$record->upgrademuch $record->itemupgrade]";
            $upg2="'images/ingame/$record->itemupgrade.jpg'";
        }else{
            $upg=''; $upg2='null';
        }
        echo"$('centerDropList').innerHTML+=createItemHTML('itemD_$record->ID', '$record->name$upg', '$record->much', $upg2);";
        $i++;
        $droppedItemsEvents.="disableSelection($('itemD_$record->ID'));";
    }
    //$droppedItemsContents=str_replace('"','\"', $droppedItemsContents);
    //echo"if($('centerDropList')){\$('centerDropList').innerHTML=\"$droppedItemsContents\";";
    echo"$droppedItemsEvents";
    echo"containerClickEvents('centerDropList');";
    echo "recreateSortable('centerDropList');} droppedItemsCount =$i; ";
}

function getRawsForCooking()
{
    global $mysqli, $S_user, $S_location;

    $sql = "SELECT II.name FROM items_inventory II
        LEFT JOIN item_types T ON T.name = II.type
        LEFT JOIN items I ON I.name = II.name
        WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%'" .
        ($S_location <> 'Thabis' || date(z)%2 == 0 ? " AND II.name NOT IN ('Parrotfish', 'Eel', 'Snapper', 'Crab', 'Grouper')" : "") .
        " ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
    $resultaat = mysqli_query($mysqli, $sql);
    $s = "";
    while ($record = mysqli_fetch_object($resultaat))
    {
        $s.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>";
    }
    $s.="<br/>";

    return $s;
}

function checkGroupFight()
{
    global $mysqli, $S_user, $S_location;

    $sql = "SELECT P.monster, P.hp, FLOOR(M.hp  * 1.1 + 3) AS maxHP, M.maxlv, M.combat FROM partyfight P
        LEFT JOIN monsters M ON M.name = P.monster
        WHERE P.location='$S_location' && P.hp > 0 LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    $s = "<br/><br/>";
    while ($record = mysqli_fetch_object($resultaat))
	{
        $sql = "SELECT smithing,mining,fishing,cooking,strength,attack,defence,health,hp,speed,trading,thieving,constructing,woodcutting,cooking,magic,farming,fame,level,totalskill FROM users WHERE username='$S_user' LIMIT 1";
        $resultset = mysqli_query($mysqli, $sql);
        while ($rec = mysqli_fetch_object($resultset))
        {
            $skills= array('mining','smithing','constructing','fishing','cooking','farming','thieving',
                'magic','speed','strength','defence','attack','health','trading','woodcutting');

            for($i=0;$skills[$i];$i++){
                $exp=$rec->$skills[$i];
                $level=floor(pow($exp, 1/3.507655116));
                $levelArray[$skills[$i]]['exp']=$exp;
                $levelArray[$skills[$i]]['level']=$level;
                $levelArray[$skills[$i]]['nextLevel']=ceil(exp( 3.507655116 * log($level+1) ))-$exp;
            }

            $level=floor($levelArray['attack']['level']/3+$levelArray['defence']['level']/3+$levelArray['strength']['level']/3+$levelArray['health']['level']/5);
        }

        if($record->maxlv == 0 || $level <= $record->maxlv)
        {
            $allowJoin = true;
            if($record->hp < floor($record->maxHP / (strpos($S_location, "Arch. cave 4.") == 0 && ($record->monster == 'Waranerus' || $record->monster == 'Honurus') ? 4 : 2)))
            {
                //The creature is half dead, so check how many people are fighting it
                $timee = time();
                $resultt = mysqli_query($mysqli, "SELECT username FROM users WHERE location='$S_location' && dump3>($timee-180) && worktime='$record->monster' && work='fight'");
                $aantl = mysqli_num_rows($resultt);
                $crowding = $crowdingEffect = $aantl;
                if($crowdingEffect < 0)
                {
                    $crowding = $crowdingEffect = 0;
                }

                if($crowding > 0)
                {
                    //Someone is fighting it so don't allow them to join
                    $allowJoin = false;
                }
            }

            if($allowJoin)
            {
                $s.="<BR>You see a very strong monster at this location, if you gather a group you might be able to kill it.<BR>";
                $s.="<a href='' onclick=\"fighting('$record->monster', 0, 1);return false;\">Fight</a> the <B>$record->monster</B> $record->combat (" . $record->maxHP . "hp)<BR>";
            }
            else
            {
                $s.="<BR>You see a very strong monster at this location, it is locked in a fierce battle so you are unable to join at this time.<BR>";
            }
        }
        else
        {
            $s .= "<BR>You see a very strong monster at this location, but there seems to be a strong spell preventing you from fighting it.<BR>";
        }
	}

    return $s;
}

function isHalloween()
{
    return //(DEBUGMODE && (date("Y-m-d")=='2011-10-29' AND date("H") >= 13)) OR
        //$_SERVER['HTTP_HOST'] == "dev2.syrnia.com" OR
        ((date("-m-d")=='-10-30')// AND date("H") >= 18)
        OR date("-m-d")=='-10-31'
        OR date("-m-d")=='-11-01');
}

function isXmas()
{
    return //(DEBUGMODE && (date("Y-m-d")=='2011-12-23'/* AND date("H") >= 13*/)) OR
        //$_SERVER['HTTP_HOST'] == "dev2.syrnia.com" OR
        ((date("-m-d")=='-12-24')// AND date("H") >= 18)
        OR date("-m-d")=='-12-25'
        OR date("-m-d")=='-12-26');
}

function isEaster()
{
    $easter = date("d", easter_date()) + 1 - 1;
    $day = date("d") + 1 - 1;
    return //(DEBUGMODE && (date("Y-m-d")=='2011-12-23'/* AND date("H") >= 13*/)) OR
        //$_SERVER['HTTP_HOST'] == "dev2.syrnia.com" OR
        (date("-m-") == '-04-' && (($day == $easter-1)// AND date("H") >= 18)
        OR $day == $easter
        OR $day == $easter+1));
}

function getXmasFishColour()
{
    //2011 is the first year with rotating colours so we should be on #3, which is green first year
    $year = date("Y") - 2008;
    return getXmasColour($year);
}

function getXmasStockingColour()
{
    $year = date("Y") - 2010;
    return getXmasColour($year);
}

function getXmasColour($year)
{
    while($year > 11)
    {
        $year -= 11;
    }

    $colour = "Red";

    switch($year)
    {
        case 1:
            $colour = "Red";
            break;

        case 2:
            $colour = "Blue";
            break;

        case 3:
            $colour = "Green";
            break;

        case 4:
            $colour = "Purple";
            break;

        case 5:
            $colour = "Yellow";
            break;
    }

    return $colour;
}

/*
 * Standard colour is gold, override for colours where gold doesn't work
 */
function getXmasStockingDecorationColour($colour)
{
    if($colour == "Yellow")
    {
        //return "Black";
    }

    return "Gold";
}

function trickOrTreat()
{
    global $mysqli, $S_user, $S_location, $var1;

    $event="halloween" . date("Y");

    $sql = "SELECT joined FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }

    $resultaat = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$S_user' LIMIT 1" );
    while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }

    if($memberfor>=2)
    {
        $resultaat = mysqli_query($mysqli, "SELECT username FROM votes WHERE username='$S_user' && datum='$event' LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
        if($aantal==1)
        {
            $output.="You've already recieved your Trick or Treat, come back next year.<br/>";
        }
        else
        {
            if($var1 == 'givepresent')
            {
                $get=rand(1,3);
                if($get==1)
                {
                    $get=rand(1,3);
                    if($get==1)
                    {
                        $get="Cooked Frog"; $gettype="cooked food"; $getmuch=50;
                    }
                    else if($get==2)
                    {
                        $get="Rocks"; $gettype="ore"; $getmuch=200;
                    }
                    else if($get==3)
                    {
                        $get="Mule"; $gettype="horse"; $getmuch=5;
                    }
                    $output.="Ouch...<B>Trick!</B><br/>";
                }
                else
                {
                    $get=rand(1,7);
                    if($get==1)
                    {
                        $get="Amber"; $gettype="gem"; $getmuch=1;
                    }
                    else if($get==2)
                    {
                        $get="Platina cauldron"; $gettype="shield"; $getmuch=1;
                    }
                    else if($get==3)
                    {
                        $get="Locked toolbox"; $gettype="locked"; $getmuch=4;
                    }
                    else if($get==4)
                    {
                        $get="White horse"; $gettype="horse"; $getmuch=1;
                    }
                    else if($get==5)
                    {
                        $get="Syriet ore"; $gettype="ore"; $getmuch=1;
                    }
                    else if($get==6)
                    {
                        $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=25;
                    }
                    else if($get==7)
                    {
                        $get="Pumpkin"; $gettype="cooked food"; $getmuch=50;
                    }
                    $output.="Great...<B>Treat!</B><br/>";
                }

                $sql = "INSERT INTO votes (datum, username, site) VALUES ('$event', '$S_user', '$S_realIP')";
                mysqli_query($mysqli, $sql) or die("erroraa report this bug");

                if($get=='Gold')
                {
                    //getGold($S_user, $getmuch);
                }
                else if($get)
                {
                    $resultaat = mysqli_query($mysqli, "SELECT username FROM items_inventory WHERE name='$get' && itemupgrade='' && username='$S_user' LIMIT 1");
                    $aantal = mysqli_num_rows($resultaat);
                    if($aantal==1)
                    {
                        $sql = "SELECT username FROM items_inventory WHERE name='$get' && itemupgrade='' && username='$S_user' LIMIT 1";
                        mysqli_query($mysqli, "UPDATE items_inventory SET much=much+'$getmuch' WHERE name='$get' && username='$S_user' LIMIT 1") or die("error --> 4a123");
                    }
                    else
                    {
                        $sql = "INSERT INTO items_inventory (username, name, much, type) VALUES ('$S_user', '$get', '$getmuch', '$gettype')";
                        mysqli_query($mysqli, $sql) or die("erroraa report this bug");
                    }
                }

                $output.="<font color=green>Your halloween present is: <font color=red>$getmuch $get!</font></font><BR><BR>";
            }
            else
            {
                $output.="Halloween presents are given here. You can not choose what you get, but beware, you won't like all of the possible presents...<br/>" .
                    "There are tricks and there are treats, which one will you get ?<br/><br/><a href='' onclick=\"locationText('tricktreat', 'givepresent');return false;\">Give me my present</a><br/>";
            }
        }    # NOG NIET GEZETE
    }
    else
    {
        $output.="Sorry, only people who've played for a while are allowed in this event, please come back next time.<br/>";
    }

    return $output;
}

function aOrAn($s)
{
    return preg_match('/^[aeiou]|s\z/i', $s) == 1;
}

if(isXmas())
{
    $PARTYISLAND = true;
}

?>
