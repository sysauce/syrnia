<?
if(defined('AZtopGame35Heyam') && $_SESSION['S_user']){

$halloween = isHalloween();
$xmas = isXmas();

$output.="<center>";

function UpdateSkillEvent($exp, $S_location, $S_user)
{
	global $mysqli, $SKILLEVENT_LEFT;
	$exp = ceil($exp * 1.25);
	mysqli_query($mysqli, "UPDATE locations SET monstersmuch=monstersmuch-1 WHERE location='$S_location' LIMIT 1") or die("err1or --> 1fgg");

	mysqli_query($mysqli, "UPDATE invasions SET kills=kills+1 WHERE location='$S_location' && username='$S_user' LIMIT 1") or die("err1or --> 123111");

    $SKILLEVENT_LEFT = $SKILLEVENT_LEFT - 1;

	return $exp;
}

function updateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $gathered)
{
	global $mysqli, $GROUPQUEST_LEFT;
	//$exp = ceil($exp * 1.25);
	mysqli_query($mysqli, "UPDATE groupquestslist SET gathered = gathered + $gathered WHERE location='$S_location' AND questID = $groupQuestID AND subID = $groupQuestSubID LIMIT 1") or die("err1or --> 1fgg");

	mysqli_query($mysqli, "INSERT INTO groupquestresults (questID, subID, location, username, amount) VALUES ($groupQuestID, $groupQuestSubID, '$S_location', '$S_user', $gathered)" .
        " ON DUPLICATE KEY UPDATE amount = amount + $gathered") or die("err1or --> 123111");

    $GROUPQUEST_LEFT = $GROUPQUEST_LEFT - 1;
}

function randomBoneTool()
{
    switch(rand(1,8))
    {
        case 1:
            return "Bone pickaxe";
            break;

        case 2:
            return "Bone hatchet";
            break;

        case 3:
            return "Bone hammer";
            break;

        case 4:
            return "Bone fishing rod";
            break;

        case 5:
            return "Bone cauldron";
            break;

        case 6:
            return "Bone lockpick";
            break;

        case 7:
            return "Bone spade";
            break;

        case 8:
            return "Bone tinderbox";
            break;
    }
}

function randomStockingMaterial()
{
    $colour = getXmasStockingColour();
    //$decorationColour = getXmasStockingDecorationColour($colour);

    switch(rand(1,6))
    {
        case 1:
            return "Santa patch";
            break;

        case 2:
            return "Snowman patch";
            break;

        case 3:
            return "Rudolph patch";
            break;

        case 4:
            return "$colour christmas sock";
            break;

        case 5:
            return "Stocking decorations " . date("Y");
            break;

        case 6:
            return "White rabbit fur";
            break;
    }
}

$timee=time();
$time=0;
$specialGemChance = false;

if($var1=='pvp'){
	$work=$var3;
	$type=$var4;
	$type2=$var5;
}else{
	$work=$var1;
	$type=$var2;
	$type2=$var3;
	$type3=$var4;
}

require_once("../../currentRunningVersion.php");
require_once('includes/levels.php'); //All exp/levels are loaded.
require_once('includes/functions.php'); // To be able to use some handy functions (mainly inventory))
$exp='';
$minTime = 29;


    $resultt = mysqli_query($mysqli,  "SELECT * FROM groupquestslist WHERE gathermuch-gathered>0 && location='$S_location' ORDER BY questID ASC, subID ASC LIMIT 1");
    $aana = mysqli_num_rows($resultt);

    if($aana>=1)
    {
        $sql = "SELECT * FROM groupquestslist WHERE gathermuch-gathered>0" .
            //" && location='$S_location'" .
            " ORDER BY questID ASC, subID ASC";
        $resultaat = mysqli_query($mysqli, $sql);
        $currentQuest = 0;
        $aana = 0;
        while ($record = mysqli_fetch_object($resultaat))
        {
            if($record->questID != $currentQuest)
            {
                $currentQuest = $record->questID;
                if($record->location == $S_location && $record->gathermuch - $record->gathered > 0)
                {
                    $groupQuest = true;
                    $groupQuestID = $record->questID;
                    $groupQuestSubID = $record->subID;
                    $groupQuestTotal = $record->gathermuch;
                    $GROUPQUEST_LEFT = $record->gathermuch - $record->gathered;
                    $groupQuestCompleteText = $record->succestekst;
                    $work = "other";
                    $type = $record->gathername;
                    $aana = 1;

                    /*$resultaaat = mysqli_query($mysqli, "SELECT username FROM invasions WHERE username='$S_user' && location='$S_location' LIMIT 1");
                    $aantal = mysqli_num_rows($resultaaat);
                    if ($aantal == 0)
                    {
                        $saql = "INSERT INTO invasions (eventID, username, location)
                        VALUES ('$eventID', '$S_user', '$S_location')";
                        mysqli_query($mysqli, $saql) or die("erroraa [tYhg] reportz this bug");
                    }*/
                }
            }
        }
    }
    else
    {
        $resultt = mysqli_query($mysqli,  "SELECT ID FROM locations WHERE monstersmuch>0 && (type='invasion' || type='skillevent' ) && location='$S_location' && startTime<'$timee' LIMIT 1");
        $aana = mysqli_num_rows($resultt);

        if($aana>=1){
            $sql = "SELECT ID, dump,monsters, monstersmuch, itemtype FROM locations WHERE location='$S_location' && startTime<'$timee' &&  type='skillevent' && monstersmuch>0 LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                if($work=='skillevent' || ($work==$record->dump && $type==$record->monsters))
                {
                    $skillevent=1;
                    $eventID= $record->ID;
                    $work=$record->dump;
                    $type=$record->monsters;
                    $type2=$record->itemtype;
                    $SKILLEVENT_LEFT = $record->monstersmuch;

                    $resultaaat = mysqli_query($mysqli, "SELECT username FROM invasions WHERE username='$S_user' && location='$S_location' LIMIT 1");
                    $aantal = mysqli_num_rows($resultaaat);
                    if ($aantal == 0)
                    {
                        $saql = "INSERT INTO invasions (eventID, username, location)
                        VALUES ('$eventID', '$S_user', '$S_location')";
                        mysqli_query($mysqli, $saql) or die("erroraa [tYhg] reportz this bug");
                    }
                }
            }
        }
        else
        {
            if(strpos($S_location, "rch. cave 4.") == 1 || strpos($S_location, "rch. cave 5.") == 1)
            {
                $sql = "SELECT ID, dump, monsters, monstersmuch, itemtype FROM locations WHERE location='$S_location' && startTime='0' && type='resource' && monstersmuch>0";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    if($type==$record->monsters)
                    {
                        $spawnEvent = 1;
                        $spawnType = $record->monsters;
                        $spawnLeft = $record->monstersmuch;
                    }
                }
            }
        }
    }

if($aana==0 || $skillevent==1 || $groupQuest){ #### INVASION!!

    $worktimeuser='';
    $sql = "SELECT work, worktime, location, dump,dump2,dump3, online FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $workuser=$record->work;
        $worktimeuser=$record->worktime;
        $S_location=$record->location;
        $dumptype=$record->dump;
        $dumptype2=$record->dump2;
        $dumptype3=$record->dump3;
        $online=$record->online;
    }

    if($online==0){
        $S_user='';
        $work='';
        echo "You are not online any more! Please relogin.<br />";
        exit();
    }


if($workuser!=$work OR $type!=$dumptype){
 	$worktimeuser='';
}else if($work=='plant'){
	if($type2!=$dumptype2){
		$worktimeuser='';
	}
}else if($work=='smithing'){
	if($type=='upgrade' && ($type2!=$dumptype2  OR $type3!=$dumptype3) ){
		$worktimeuser='';
	}

}else if($type=='clancompound'){
	if($type2!=$dumptype2){
		$worktimeuser='';
	}
}

$worktime=time();
##### WORK CHECK

//Sleep if timer is too fast
if($worktimeuser){
	$timeleft=$worktimeuser-$worktime;
	if($timeleft>0 && $timeleft<=2){
		sleep($timeleft); //Delay until work IS done
		$worktime=time();
	}
}

$check='';

if($skillevent==1){
	$check=1;
}else if($work=='plant'){ ## PLANTING

	$check=1;

}elseif($work=='pick'){ ## PICKING

	$check=1;

}elseif($work=='constructing'){ #CONSTRUCTING

	 $check=1;

}elseif($work=='woodcutting'){ #WOODCUTTING

	if($S_location=='Isri' OR $S_location=='Tutorial 5'){$check=1; }
	elseif($S_location=='Festival forest' && date("m")==12){$check=1; }
	elseif($S_location=='Bonewood' OR $S_location=='Unera'){$check=1; }
	elseif($S_location=='Aloria' && stristr($_SESSION['S_questscompleted'], "[12]")  ){$check=1;}
	elseif($S_location=='Lemo woods'){$check=1;}
	elseif($S_location=='Penteza forest'){$check=1;}
	elseif($S_location=='The Outlands 89' OR $S_location=='The Outlands 52' OR $S_location=='The Outlands 21'){$check=1;}
	elseif($S_location=='Avinin'){$check=1;}
	elseif($S_location=='Jungles edge'){$check=1;}
	elseif($S_location=='Webbed forest' OR $S_location=='Silk woods'){$check=1;}
	elseif(($S_location=='Ammon' && finishedQuest(22)) OR $S_location=='Khaya'){$check=1;}

}elseif($work=='fishing'){  #FISHING

	 if(($S_location=='Web haven' OR $S_location=='Lisim' OR $S_location=='Tutorial 4') && $type=='' ){ $check=1; }
	 elseif(($S_location=='Holiday lake') && $type=='' && date("m")==12 ){ $check=1; }
	 else if($S_location=='Barnacle bay' OR $S_location=='The singing river' && $type==''){ $check=1; }
	 else if(($S_location=='The Outlands 34' OR $S_location=='The Outlands 18' OR $S_location=='The Outlands 17' OR $S_location=='Ogre lake') && $type==''){ $check=1; }
	 elseif($S_location=='Port Dazar'){ if($type=='Sloop'){ $check=1;} }
	 elseif($S_location=='Port Senyn' OR $S_location=='Barnacle bay'){ if($type=='Small fishing boat'){ $check=1;} }
	 elseif($S_location=='The Outlands 62' OR $S_location=='Heerchey docks'){ if($type=='Boat'){ $check=1;} }
	 elseif($S_location=='Eylsian docks'){ if($type=='Small fishing boat' OR $type=='Trawler'){ $check=1;} }
	 elseif($S_location=='Port Calviny'){ if($type=='Small fishing boat' OR $type=='Sloop'){ $check=1;} }
	 elseif($S_location=='Thabis' && date(z)%2 == 0){ if($type=='Canoe'){ $check=1;} }

 }elseif($work=='mining'){ # MINING

	 if($S_location=='Rynir Mines'){ if($type=='Iron ore' OR $type=='Copper ore' OR $type=='Tin ore'){ $check=1;}
	 }elseif($S_location=='Tutorial 2'){ if($type=='Copper ore' OR $type=='Tin ore'){ $check=1;} }
	 else if($S_location=='Hawk mountain' OR ($S_location=='Ancestral mountains' && stristr($_SESSION['S_questscompleted'], "[8]")<>'')){ if($type=='Iron ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 79'){ if($type=='Iron ore'){ $check=1;} }
	 elseif($S_location=='Nabb mines'){if($type=='Coal' OR $type=='Tin ore'){ $check=1;} }
	 elseif($S_location=='Sorer mines'){if($type=='Coal' OR $type=='Iron ore'){ $check=1;} }
	 elseif($S_location=='Mt. Vertor'){  if($type=='Coal'){ $check=1;} }
	 elseif($S_location=='Franer mines'){  if($type=='Silver'){ $check=1;} }
	 elseif($S_location=='Eckwal'){  if($type=='Coal' OR $type=='Iron ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 96'){  if($type=='Coal'){ $check=1;} }
	 elseif($S_location=='The Outlands 54' OR ($S_location=='The Outlands 4')){  if($type=='Copper ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 1' OR $S_location=='The Outlands 44'){  if($type=='Tin ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 78' || $S_location=='Abydos'){  if($type=='Platina ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 66'){  if($type=='Obsidian ore'){ $check=1;} }
	 elseif($S_location=='The Outlands 49'){  if($type=='Syriet ore'){ $check=1;} }
	 elseif($S_location=='Ogre mine'){  if($type=='Gold ore'){ $check=1;} }
	 elseif($S_location=='Rose mines'){if($type=='Coal' OR $type=='Iron ore' OR $type=='Silver'){ $check=1;} }

}elseif($work=='cooking'){ # COOKING

	if($S_location=='Harith' OR $S_location=='Web haven' OR $S_location=='Tutorial 6' OR $S_location=='Toothen' OR $S_location=='Burning beach'){$check=1;}
	elseif(($S_location=='Penteza' OR $S_location=='Wingmere'  )&& $cookingl>=20){$check=1;}
	elseif($S_location=='Croy' && $cookingl>=50){$check=1;}
 	elseif($S_location=='The Outlands 37' OR $S_location=='The Outlands 16'){$check=1;}
	elseif($S_location=='Desert arena 1' OR $S_location=='Desert arena 3'){$check=1;}
 	elseif($S_location=='Thabis' && $cookingl>=80)
    {
        if(($type<>'Parrotfish' && $type<>'Eel' && $type<>'Snapper' && $type<>'Crab' && $type<>'Grouper') || date(z)%2 == 1)
        {
            $check=1;
        }
    }
	 elseif($type2=='stock'){$check=1; }

}elseif($work=='smelting'){ # SMELTING

	 if(($S_location=='Endarx' OR $S_location=='Ten cliff') && ($type=='Iron bars' OR $type=='Bronze bars')){$check=1;}
	 elseif(($S_location=='Kinam' OR $S_location=='Web haven') && ($type=='Iron bars' OR $type=='Bronze bars' OR $type=='Steel bars')){$check=1;}
	 elseif(($S_location=='The Outlands 3'  OR $S_location=='Tutorial 3') && $type=='Bronze bars'){$check=1;}
	 elseif($S_location=='The Outlands 42' && ($type=='Iron bars' OR $type=='Bronze bars')){$check=1;}
	 elseif($S_location=='The Outlands 59' && ($type=='Iron bars' OR $type=='Steel bars')){$check=1;}
	 elseif($S_location=='Arch. cave 4.7' && ($type=='Iron bars' OR $type=='Steel bars' OR $type=='Gold bars' OR (($type=='Platina bars' OR $type=='Syriet bars') && (date("w")==0 OR date("w")==6 OR date("w")==5 OR date("w")==3))   )){$check=1;}
	 elseif($S_location=='Mt. Flag' && ($type=='Iron bars' OR $type=='Steel bars' OR $type=='Gold bars') && (date("H")%(date("d")%3+2+date("W")%2))==0){$check=1;}
	 elseif($S_location=='Lava lake' && ($type=='Silver bars')){$check=1;}
	 elseif($S_location=='Beset' && ($type=='Obsidian bars' || $type=='Syriet bars')){$check=1;}
	 elseif($S_location=='Arch. cave 5.13' && ($type=='Platina bars' OR $type=='Syriet bars' OR (($type=='Obsidian bars' OR $type=='Puranium bars') && (true OR date("w")==3 OR date("w")==6))   )){$check=1;}
	 elseif($type2=='stock'){$check=1; }

}elseif($work=='smithing'){ # SMITHING

	 if($S_location=='Endarx' OR $S_location=='Web haven' OR $S_location=='Ogre camp' OR $S_location=='Ten cliff'){$check=1;}
	 elseif($S_location=='The Outlands 92' || $S_location=='The Outlands 29'){$check=1;}
	 elseif($S_location=='Aunna' OR $S_location=='Tutorial 3' OR $S_location=='Beset' OR $S_location=='Castle Rose'){$check=1;}

}elseif($work=='school'){  #SCHOOL
    if($S_location=='Rile'){if($type=='constructing' && $constructingl<10 OR $type=='trading' && $tradingl<10){  $check=1;}
    }elseif($S_location=='Hooks edge'){if($type=='constructing' && $constructingl<=40 OR $type=='trading' && $tradingl<=40){  $check=1;}
    }elseif($S_location=='Unera'){if($type=='constructing' && $constructingl>=10 && $constructingl<25 OR $type=='trading' && $tradingl>=10 && $tradingl<25){  $check=1;}
    }elseif($S_location=='Xanso'){if($type=='constructing' && $constructingl>=25 && $constructingl<40 OR $type=='trading' && $tradingl>=25 && $tradingl<40){  $check=1;}
    }elseif($S_location=='Kanzo'){if($type=='constructing' && $constructingl>=40 && $constructingl<50 OR $type=='trading' && $tradingl>=40 && $tradingl<50){  $check=1;}
    }elseif($S_location=='Maadi'){if($type=='constructing' && $constructingl>=50 && $constructingl<75 OR $type=='trading' && $tradingl>=50 && $tradingl<75){  $check=1;}
 }

}elseif($work=='train'){  #TRAIN

	 if($S_location=='Skulls nose'){ $check=1;}

}elseif($work=='lockpicking'){  #lockpicking

	 $check=1;

}elseif($work=='other'){ ##  OTHER QUESTS ETC

	$check=1;

}


### STOCKARY (PIRATES)
if($type2=='stock'){ $S_sideid='';
   $sql = "SELECT ID, newattack FROM sides WHERE location='$S_location' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $S_sideid=$record->ID; if($newattack>0){ $S_sideid='';} }
### RARE
}else if($type2=='rare'){
   $sql = "SELECT ID FROM locations WHERE location='$S_location' && monsters='$type' && monstersmuch>0 && type='resource' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $check=1; }
}



##### ITEM CHECK && TIJD STUFF
if($check==1){
$workers=0;
if($work<>'smithing' && $work!='smelting' && $work!='cooking' && $work!='woodcutting' && $work!='farming' && $type != 'clancompound'){
	 $resultt = mysqli_query($mysqli,  "SELECT username FROM users WHERE location='$S_location' && online=1 && work='$work' && dump='$type' && username!='$S_user' && botcheck=0");
	   $aantl = mysqli_num_rows($resultt);
	$workers=$aantl;
}
else if($type == 'clancompound')
{
    $resultt = mysqli_query($mysqli,  "SELECT U.username FROM users U JOIN clans C ON C.username = U.username WHERE U.location = '$S_location' && U.online = 1 && U.work='$work' && U.username != '$S_user' && C.tag = '$S_clantag' && U.botcheck=0");
    $aantl = mysqli_num_rows($resultt);
	$workers=$aantl;
}
else
{
 	$resultt = mysqli_query($mysqli,  "SELECT username FROM users WHERE location='$S_location' && online=1 && work='$work' && username!='$S_user' && botcheck=0");
    $aantl = mysqli_num_rows($resultt);
	$workers=$aantl;
}
$workersTime=$workers;

//No crowding on party island
if($S_location == 'Port party' || $S_location == 'Syrnia celebration center' || $S_location == 'Festival forest' || $S_location == 'Holiday lake')
{
    $workersTime = 0;
}
if($workersTime>15){$workersTime=15;} ##CAP OP WORKERS


################
## WOODCUTTING
################
if($work=='woodcutting'){

	$werktijd=20;

   	$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat)){  $werktool=$record->name;}
    $werktijd=60;

    $seeds=rand(1,1000); $get='';  ## SEEDS STUKJE
    if(stristr($S_location, "Outlands")<>''){ $seeds=rand(1,200);  }
    if(($skillevent==1 && $type == 'Isri') || ($skillevent==0 && ($S_location=='Isri' OR $S_location=='Webbed forest' OR $S_location=='Tutorial 5' OR $S_location=='Jungles edge' OR $S_location=='Bonewood' OR  $S_location=='The Outlands 21' OR $S_location=='The Outlands 89'))){

		 $werktijd=50;  $exp=15;

        if($seeds<=30){ $get="Radish seeds";  $much=rand(1,15);
  	    }elseif($seeds<=60){ $get="Carrot seeds";  $much=rand(1,14);
        }elseif($seeds<=75){ $get="Beet seeds";  $much=rand(1,13);   }
    }
    elseif((($skillevent==1 && $type == 'Lemo woods') || ($skillevent==0 && ($S_location=='Lemo woods' OR $S_location=='Silk woods'))) && $woodcuttingl>=15){

	 	$werktijd=75; $exp=22;
        if($seeds<=45){ $get="Cabbage seeds";  $much=rand(1,12);
	    }elseif($seeds<=75){ $get="Onion seeds";  $much=rand(1,11);
	    }elseif($seeds<=90){ $get="Beet seeds";  $much=rand(1,14);}

	 }
     elseif((($skillevent==1 && $type == 'Unera') || ($skillevent==0 && $S_location=='Unera')) && $woodcuttingl>=25){ $werktijd=100; $exp=30;
         if($seeds<=40){ $get="Grain seeds";  $much=rand(1,10);
	    }elseif($seeds<=66){ $get="Tomato seeds";  $much=rand(1,9);
	    }elseif($seeds<=75){ $get="Corn seeds";  $much=rand(1,8);   }
	    }
    elseif((($skillevent==1 && ($type == 'Penteza forest' || $type == 'Avinin')) || ($skillevent==0 && ($S_location=='Penteza forest' OR $S_location=='Avinin'))) && $woodcuttingl>=40){

        $werktijd=180;  $exp=65;
        if($seeds<=35){ $get="Grain seeds";  $much=rand(1,10);
	    }elseif($seeds<=55){ $get="Strawberry seeds";  $much=rand(1,9);
	    }elseif($seeds<=75){ $get="Green pepper seeds";  $much=rand(1,8);   }
	    }
	 elseif((($skillevent==1 && $type == 'Aloria') || ($skillevent==0 && ($S_location=='Aloria' || $S_location=='The Outlands 52'))) && $woodcuttingl>=55){

        $specialGemChance = 1;
        $werktijd=330;  $exp=130;
        if($seeds<=35){ $get="Spinach seeds";  $much=rand(1,8);
	    }elseif($seeds<=55){ $get="Eggplant seeds";  $much=rand(1,7);
	    }elseif($seeds<=75){ $get="Green pepper seeds";  $much=rand(1,9);
	    }elseif($seeds<=90){ $get="Pumpkin seeds";  $much=rand(1,5);
	    }elseif($seeds<=100){ $get="Apple seeds";  $much=rand(1,3);
		}
	}elseif((($skillevent==1 && $type == 'Khaya') || ($skillevent==0 && $S_location=='Khaya')) && $woodcuttingl>=75){

        $specialGemChance = 0.95;
        $werktijd=700;  $exp=275;
        if($seeds<=25){ $get="Pear seeds";  $much=rand(1,4);
	    }elseif($seeds<=45){ $get="Broccoli seeds";  $much=rand(1,4);
	    }elseif($seeds<=60){ $get="Peach seeds";  $much=rand(1,4);
	    }elseif($seeds<=75){ $get="Orange seeds";  $much=rand(1,4);
		}
	}elseif((($skillevent==1 && $type == 'Ammon') || ($skillevent==0 && $S_location=='Ammon')) && $woodcuttingl>=100){

        $specialGemChance = 0.9;
        $werktijd=1000;  $exp=400;
        if($seeds<=25){ $get="Pineapple seeds";  $much=rand(1,4);
	    }elseif($seeds<=45){ $get="Watermelon seeds";  $much=rand(1,4);
	    }elseif($seeds<=60){ $get="Vervefruit seeds";  $much=rand(1,4);
	    }elseif($seeds<=75){ $get="Fruit of life seeds";  $much=rand(1,4);
		}
	}elseif(($skillevent==1 && $type == 'Festival forest') || ($skillevent==0 && $S_location=='Festival forest')){ ## XMAS TREE
 		$werktijd=79; $exp=20;

 		if($seeds<=20){ $get="Spinach seeds";  $much=rand(1,8);
	    }elseif($seeds<=40){ $get="Eggplant seeds";  $much=rand(1,7);
	    }elseif($seeds<=60){ $get="Strawberry seeds";  $much=rand(1,9);
	    }elseif($seeds<=80){ $get="Green pepper seeds";  $much=rand(1,8);
		}elseif($seeds<=100){ $get="Corn seeds";  $much=rand(1,10);
		}elseif($seeds<=110){ $get="Radish seeds";  $much=rand(1,15);
  	    }elseif($seeds<=120){ $get="Carrot seeds";  $much=rand(1,14);
        }elseif($seeds<=130){ $get="Beet seeds";  $much=rand(1,13);
	    }elseif($seeds<=150){ $get="Cabbage seeds";  $much=rand(1,12);
	    }elseif($seeds<=170){ $get="Onion seeds";  $much=rand(1,11);
	    }elseif($seeds<=180){ $get="Pumpkin seeds";  $much=rand(1,7);
	    }elseif($seeds<=190){ $get="Apple seeds";  $much=rand(1,7);
		}

 	}else{
	  $check=0;
	} ### SEEDS GET BOVEN MAAR ONDER PAS ADD VANWEGE SECURITY


       $durability='';
if($werktool=='Bronze hatchet'){ $tooloff=100;   $durability=900;
}elseif($werktool=='Iron hatchet'){ $tooloff=98;  $durability=1000;
}elseif($werktool=='Ogre hatchet'){ $tooloff=96; 	$durability=1250;
}elseif($werktool=='Lizard machette'){ $tooloff=96;   $durability=1250;
}elseif($werktool=='Steel hatchet'){ $tooloff=96;  	$durability=1250;
}elseif($werktool=='Elven hatchet'){ $tooloff=94;  	$durability=1500;
}elseif($werktool=='Silver hatchet'){ $tooloff=92;  $durability=2000;
}elseif($werktool=='Gold hatchet'){ $tooloff=90;  	$durability=2250;
}elseif($werktool=='Platina hatchet'){ $tooloff=86; $durability=2500;
}elseif($werktool=='Bone hatchet'){ $tooloff=84; $durability=10000;
}elseif($werktool=='Syriet hatchet'){ $tooloff=83;  $durability=2750;
}elseif($werktool=='Obsidian hatchet'){ $tooloff=81;  $durability=3000;
}elseif($werktool=='Puranium hatchet'){ $tooloff=78;  $durability=3500;
} else { $check=0; }
//if($S_location<>'Festival forest'){
	$time=ceil(($tooloff/100)*$werktijd*(((1-(pow($woodcuttingl, 0.7728)+($woodcuttingl/5))/100))))+$workersTime*2;
//}
if($S_location=='Festival forest' && $xmas)
{
	$time=60;
}
if($time<29){$time=29;}





if($workuser && $worktimeuser && $check!=0){
if($worktime>=$worktimeuser){



$status = "";
if($S_location=='Festival forest' && $xmas){ ## XMAS TREE
	 $check=1;  $exp=20;
	 if(rand(1,50)==1){ ### XMAS TREE
		$status="<font color=yellow>You cut a perfect christmas tree!</font><br />";
		addItem($S_user, 'Christmas tree', 1, 'tree', '', '', 1);

      }
}## EINDE XMAS TREE


 	if($get){ ### SEEDS GET
		$status.="<font color=yellow>Looks like an animal hid some seeds in the tree, you got $much $get.</font><br />";
		addItem($S_user, $get, $much, 'seeds', '', '', 1);
	} ## EINDE SEEDS GET

	if($skillevent==1){
		$exp = UpdateSkillEvent($exp, $S_location, $S_user);
		if($SKILLEVENT_LEFT<1) $time=0;
	}
    else if($spawnEvent)
    {
        $spawnLeft = $spawnLeft - 1;
        if($spawnLeft<1) { $time=0; }
    }

$exp = bonusExp("woodcutting", $exp);
mysqli_query($mysqli, "UPDATE users SET woodcutting=woodcutting+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("err1or --234> 11 [dre]]");
$levelArray=addExp($levelArray, 'woodcutting', $exp);


$break=rand(1,$durability);
if($break==1 && $durability &&  stristr($S_location, "Tutorial")==''  ){ #NIET OP TUT ISLAND
    if(removeDurability($werktool, $S_user))
    {
        $output.="<font color=red>Your $werktool broke, you can only continue woodcutting if you have another hatchet.</font><br />";
        $time=0;
		$specialGemChance = 0;
    }
}


## WOOD
$woodg=rand(1,100); $wood=0; $chest=""; $chesttype="";
if(($skillevent==1 && $type == 'Isri') || ($skillevent==0 && ($S_location=='Webbed forest' OR $S_location=='Isri' OR $S_location=='Tutorial 5'  OR $S_location=='Jungles edge' OR $S_location=='Bonewood'  OR  $S_location=='The Outlands 21' OR $S_location=='The Outlands 89'))){
	if($woodg<=20){$wood=2;
	}else{ $wood=1; $chest="Small chest"; $chesttype="open"; }
} elseif(($skillevent==1 && $type == 'Lemo woods') || ($skillevent==0 && ($S_location=='Lemo woods' OR $S_location=='Silk woods'))){
	if($woodg<=30){$wood=1; $chest="Small chest"; $chesttype="open";
	}elseif($woodg>30 && $woodg<=90) { $wood=2;
	}else{ $wood=3;   }
} elseif(($skillevent==1 && $type == 'Unera') || ($skillevent==0 && ($S_location=='Unera' OR $S_location=='Avinin'))){
	if($woodg<=20){$wood=1; if($S_location=='Unera') { $chest="Small chest"; $chesttype="open"; } else { $chest="Locked toolbox"; $chesttype="locked"; }
	}elseif($woodg>20 && $woodg<=70) { $wood=2;
	}else{ $wood=3;   }
} elseif(($skillevent==1 && $type == 'Penteza forest') || ($skillevent==0 && $S_location=='Penteza forest')){
	if($woodg<=20){$wood=2; $chest="Locked toolbox"; $chesttype="locked";
	}elseif($woodg>20 && $woodg<=35) { $wood=3;
	}elseif($woodg>35 && $woodg<=80) { $wood=4;
	}else{ $wood=6;   }
} elseif(($skillevent==1 && $type == 'Aloria') || ($skillevent==0 && ($S_location=='Aloria' || $S_location=='The Outlands 52'))){
	if($woodg<=20){$wood=2; $chest="Locked moldy chest"; $chesttype="locked";
	}elseif($woodg<=60) { $wood=3;
	}elseif($woodg<=80) { $wood=5;
	}elseif($woodg<=99) { $wood=6;
	}else{ $wood=10;   }
} elseif(($skillevent==1 && $type == 'Khaya') || ($skillevent==0 && $S_location=='Khaya')){
	if($woodg<=20){$wood=4; $chest="Locked ancient chest"; $chesttype="locked";
	}elseif($woodg<=60) { $wood=5;
	}elseif($woodg<=70) { $wood=6;
	}elseif($woodg<=80) { $wood=7;
	}elseif($woodg<=85) { $wood=8;
	}elseif($woodg<=95) { $wood=9;
	}elseif($woodg<=99) { $wood=15;
	}else{ $wood=3;   }
} elseif(($skillevent==1 && $type == 'Ammon') || ($skillevent==0 && $S_location=='Ammon')){
	if($woodg<=20){$wood=6; $chest=(rand(1,3) == 1 ? "Locked sarcophagus" : "Locked ancient chest"); $chesttype="locked";
	}elseif($woodg<=60) { $wood=8;
	}elseif($woodg<=70) { $wood=10;
	}elseif($woodg<=80) { $wood=12;
	}elseif($woodg<=85) { $wood=14;
	}elseif($woodg<=95) { $wood=15;
	}elseif($woodg<=99) { $wood=20;
	}else{ $wood=5;   }
}elseif(($skillevent==1 && $type == 'Festival forest') || ($skillevent==0 && $S_location=='Festival forest')){
	$wood=1; $chest="Small chest"; $chesttype="open";
} else{
 	$wood=0; $output.="ERROR";
}
if($wood > 1){$status="$status<font color=yellow>You were able to collect $wood logs from this tree.</font><br />";}
### EINDE WOOD


if($chest!=''){ ## CHEST
$givechest=rand(1,1000);
$get='';
if($givechest==1 || $givechest==3 || $givechest==4){ $get="$chest"; $gettype="$chesttype"; $much=1;}
elseif($givechest==2){ $get="";  $much=0; $wood=0;  $status="<font color=yellow>You cut down a hollow tree, you got no wood.</font><br />"; }
elseif($givechest==5 && $S_location=='Ammon'){ $get="Carnelian"; $gettype='gem'; $much=1;}
else if($halloween && $givechest == 6)
{
    $much=1;
    $get = randomBoneTool();
    $gettype = $get == 'Bone cauldron' ? "shield" : "hand";
}
else if($xmas && $givechest == 6)
{
    $much=1;
    $get = randomStockingMaterial();
    $gettype = "other";
}

if($get){
 	$wood=0;
	$status="<font color=yellow>You cut down a hollow tree, a $get was hidden inside it!</font><br />";
	addItem($S_user, $get, 1, $gettype, '', '', 1);
}


} ## CHEST

    if($specialGemChance > 0)
    {
        $averageWoodcutters = 400;
        $specialGemChance = ceil(((30/$time)*(2000*$averageWoodcutters))*$specialGemChance);

        /*if(stristr($S_location, "utlands") === true)
        {
            $specialGemChance = ceil($specialGemChance / 2);
        }*/

		if(date("Y-m-d H:i:s") > '2013-04-01 00:00:00')
		{
			$gemcatch = rand(1, $specialGemChance);
		}
		else
		{
			$gemcatch = 0;
		}

        if($gemcatch==1)
        {
            $status="$status<B>While woodcutting, you found a rare <font color=yellow>Jade gem</font>!</b><br />";
            addItem($S_user, "Jade", 1, "gem", '', '', 1);
        }
    }

if($wood>0){
addItem($S_user, 'Wood', $wood, 'item', '', '', 1);
}


}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }

}

}


############
# EINDE WOODCUTTING
############
################
## FISHING
################
}elseif($work=='fishing'){

	$fishItemType='food'; //Default (can be overwritten, e.g. red striped fish)

   	$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat))
	{
		$tool=$record->name;
	}

$toolTimeReduction=1;
    //NO boat fishing:
if($type==''){

  $resultaat = mysqli_query($mysqli,  "SELECT username FROM items_wearing WHERE type != 'trophy' AND (name='Net' OR name='Rod' OR name LIKE '% fishing rod') && username='$S_user' LIMIT 1");
   $aantal = mysqli_num_rows($resultaat);
if($aantal<>1){$check=0;}




//The only location where there is no net AND rod fishing
if($S_location=='The singing river' && ($tool=='Rod' || strpos($tool, " fishing rod") > 0)){ $check=0; $time=0; $tool='';  }
if($S_location=='Holiday lake' && $tool!='Rod' && strpos($tool, " fishing rod") === false){ $check=0; $time=0; $tool='';  }

if($tool == "Bone fishing rod")
{
    $toolTimeReduction = 0.95;
}

$begtime=9999;
## ROD MACKEREL HERRING  SARDINE
if(($tool=='Rod' || strpos($tool, " fishing rod") > 0) && $fishingl>=5){
 	$rand=rand(1,3);   $begtime=61;

 	if($S_location=='Holiday lake' && rand(1,35)==1){

        $vang="Striped " . strtolower(getXmasFishColour()) . " fish";
        $exp=15; $fishItemType='food uncookable';
	}else if($rand==1 && $fishingl>=16){ $vang="Mackerel";   $exp=20;
	}else if($rand==2 && $fishingl>=10){ $vang="Herring";   $exp=17;
	} else {  $vang="Sardine";    $exp=14;    }
## NET  SHRIMPS  TROUTS
}else if($tool=='Net'){  $begtime=65;
	if($S_location=='The singing river'){
	       $rand=rand(1,4);
		   if($rand==1 && $fishingl>=35){ $vang="Giant catfish";   $exp=35;
		   }elseif($rand==2 && $fishingl>=10){ $vang="Catfish";   $exp=30;
		   }elseif($rand==3 && $fishingl>=5){ $vang="Piranha";   $exp=20;
		   }else{ $vang="Frog";   $exp=12; }

	}else{
	 	$rand=rand(1,3);
		if($rand==1 && $fishingl>=20){ $vang="Trouts";   $exp=30;
		/*}elseif($S_location=='Holiday lake' && rand(1,5)==1){
			if(rand(1,3)==1){
				$vang="Tinsel"; $exp=10; $fishItemType='rare';
			}else{
				$vang="Red bauble"; $exp=10; $fishItemType='rare';
			}*/
		//}elseif($S_location=='Holiday lake' && rand(1,5)==1){
		//	$vang="Striped blue fish"; $exp=15; $fishItemType='food uncookable';
		} else {  $vang="Shrimps"; $exp=10;      }
	}
##NIKS
} else{ $check=0; $aantal=0;  }

} else{
## BOAT FISHY

if($type=='Trawler' && $fishingl>=50){
	$tool=''; // No hand tool
    $specialGemChance = 1;
    $minTime = 90 - ($fishingl >= 170 ? $fishingl - 170 : 0);
    if($minTime < 44)
    {
        $minTime = 44;
    }
	$rand=rand(1,3);   $begtime=450;
	if($rand==1 && $fishingl>=76){ $vang="Shark";   $exp=350;
	} else {  $vang="Swordfish";    $exp=275;     }

}elseif($type=='Boat' && $fishingl>=46){
	$tool=''; // No hand tool
	$vang=Bass;  $exp=125;  $begtime=249;
}elseif($type=='Sloop' && $fishingl>=35){
	$tool=''; // No hand tool
	$begtime=150;
	$rand=rand(1,3);
	if($rand==1 && $fishingl>=40){ $vang="Lobster";   $exp=75;
	} else {  $vang="Tuna";    $exp=64;       }
}elseif($type=='Small fishing boat' && $fishingl>=23){
	$tool=''; // No hand tool
	$rand=rand(1,3);    $begtime=117;
	if($rand==1 && $fishingl>=30){ $vang="Salmon";   $exp=57;
	}elseif($rand==2 && $fishingl>=25){ $vang="Pike";   $exp=50;
	} else {  $vang="Cod";    $exp=40;          }
}elseif($type=='Canoe' && $fishingl>=100){
    $specialGemChance = 0.9;
    $minTime = 59;
	if($tool=='Net'){
        if($type2 == "Net" || $type2 == "")
        {
            $type2 = "Net";
            $begtime=900;
            $rand=rand(1,2);
            if($rand==1 && $fishingl>=160){ $vang="Crab";   $exp=1100; }
            else if($fishingl>=120) {  $vang="Eel";    $exp=600; }
        }
        else
        {
            $exp=0; $check=0;
        }
	}else if($tool=='Rod' || strpos($tool, " fishing rod") > 0){
        if($type2 == "Rod" || $type2 == "")
        {
            $type2 = "Rod";
            if($tool == "Bone fishing rod")
            {
                $toolTimeReduction = 0.95;
            }
            $begtime=900;
            $rand=rand(1,3);
            if($rand==1 && $fishingl>=180){ $vang="Grouper";   $exp=1500; }
            else if($rand==2 && $fishingl>=140) {  $vang="Snapper";    $exp=1000; }
            else if($fishingl>=100){ $vang="Parrotfish";    $exp=500; }
        }
        else
        {
            $exp=0; $check=0;
        }
	}
}else{
	$exp=0; $check=0;
}





if($exp==''){$check=0; $worktimeuser='';}

 $sql = "SELECT name FROM items_inventory WHERE name='$type' && type='boat' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $boaty=$record->name;}
if($boaty==''){$check=0; $aantal=0; $exp=0; }


}

if($begtime < 600)
{
    $time=ceil($begtime*(((1-(pow($fishingl, 0.7728)+($fishingl/5))/100)))*$toolTimeReduction)+$workersTime*2;
}
else
{
    $time=ceil($begtime*(((1-(pow($fishingl, 0.67)+($fishingl/5))/100)))*$toolTimeReduction)+$workersTime*2;
}
if($time<$minTime){$time=$minTime;}

if($S_location=='Holiday lake'){
 	//if($tool<>'Net'){$check=0; }
	$time=90;
}

if($workuser && $worktimeuser && $exp>0 && $check!=0){
if($worktime>=$worktimeuser){

if($tool=='Net' OR $tool=='Rod' || strpos($tool, " fishing rod") > 0){
	if($status=='')
    {
		$break=rand(1, $tool == 'Bone fishing rod' ? 10000 : 500);
		if($break==1 && stristr($S_location, "Tutorial")=='')
        { #NIET OP TUT ISLAND
		 	if(removeDurability($tool, $S_user))
            {
                $output.="<font color=red>Your $tool broke. ";

                if($tool == 'Bone fishing rod')
                {
                    $tool = "Fishing rod";
                }

                $output .= "To continue fishing you need another $tool.</font><br />";
                $time=0;
				$specialGemChance = 0;
            }
		}
	}
}

$status=" ";
$shoecat=rand(1,500);

    if($shoecat==1){
        $catch=rand(1,100);
        if($halloween && $S_location!='Thabis' && $catch<=10){ $catch = randomBoneTool(); $catchtype = $catch == 'Bone cauldron' ? "shield" : "hand"; }
        if($xmas && $S_location!='Thabis' && $catch<=10){ $catch = randomStockingMaterial(); $catchtype = "other"; }
        //else if($S_location=='Thabis' && $catch<=15 && ($type=='Net')){  $catch="Lapis";  $catchtype='gem'; }
        else if($catch<=30 && ($boaty OR $type=='Net')){  $catch="Small chest";  $catchtype='open'; }
        else if($catch<=60 && ($boaty OR $type=='Net')){  $catch="Locked toolbox";  $catchtype='locked'; }
        else if($catch<=75 && ($boaty)){  $catch="Locked small chest";  $catchtype='locked'; }
        else{  $catch="Leather boots"; $catchtype='shoes'; }

         $status="<B>While fishing, you caught a <font color=yellow>$catch</font>!</b><br />";

        addItem($S_user, $catch, 1, $catchtype, '', '', 1);
    }
    else if($specialGemChance > 0)
    {
        $averageFishers = 400;
        $specialGemChance = ceil(((30/$time)*(2000*$averageFishers))*$specialGemChance);

        /*if(stristr($S_location, "utlands") === true)
        {
            $specialGemChance = ceil($specialGemChance / 2);
        }
        else if(stristr($S_location, "rch. cave") === true)
        {
            $specialGemChance = ceil($specialGemChance / 2);
        }*/

		if(date("Y-m-d H:i:s") > '2013-01-01 00:00:00')
		{
			$gemcatch = rand(1, $specialGemChance);
		}
		else
		{
			$gemcatch = 0;
		}

        if($gemcatch==1)
        {
            $status="$status<B>While fishing, you found a rare <font color=yellow>Lapis gem</font>!</b><br />";
            addItem($S_user, "Lapis", 1, "gem", '', '', 1);
        }
    }

	if($skillevent==1){
		$exp = UpdateSkillEvent($exp, $S_location, $S_user);
		if($SKILLEVENT_LEFT<1) $time=0;
	}
    else if($spawnEvent)
    {
        $spawnLeft = $spawnLeft - 1;
        if($spawnLeft<1) { $time=0; }
    }

$exp = bonusExp("fishing", $exp);
mysqli_query($mysqli, "UPDATE users SET fishing=fishing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --> Fish [45f]");
$levelArray=addExp($levelArray, 'fishing', $exp);
addItem($S_user, $vang, 1, $fishItemType, '', '', 1);


}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}


############
# EINDE FISHING
############
################
## MINING
################
}elseif($work=='mining'){

   $sql = "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $tool=$record->name;}
    $durability='';
if($tool=='Bronze pickaxe'){ $minespeed=1; 		$durability=750;	}
elseif($tool=='Iron pickaxe' && $miningl>=10){  $minespeed=0.97; 	$durability=750;}
elseif($tool=='Ogre pickaxe' && $miningl>=1){   $minespeed=0.94; 	$durability=1000;}
elseif($tool=='Steel pickaxe' && $miningl>=25){  $minespeed=0.94; $durability=1000;}
elseif($tool=='Silver pickaxe' && $miningl>=40){  $minespeed=0.90; $durability=1000;}
elseif($tool=='Koban pickaxe' && $miningl>=30){   $minespeed=0.89; $durability=2000;	}
elseif($tool=='Elven pickaxe' && $miningl>=35){  $minespeed=0.89;	$durability=1500; }
elseif($tool=='Gold pickaxe' && $miningl>=55){   $minespeed=0.85; $durability=1750;	}
elseif($tool=='Platina pickaxe' && $miningl>=70){  $minespeed=0.83; $durability=2500; }
elseif($tool=='Bone pickaxe' && $miningl>=75){  $minespeed=0.81; $durability=10000; }
elseif($tool=='Syriet pickaxe' && $miningl>=85){   $minespeed=0.80; $durability=2750;}
elseif($tool=='Obsidian pickaxe' && $miningl>=100){   $minespeed=0.78; $durability=3000;}
elseif($tool=='Puranium pickaxe' && $miningl>=120){   $minespeed=0.75; $durability=3500;}
else{$check=0; }

if($status==''){ //wHY ?
}else{ $check=0; }


    if($type=='Tin ore'){ $begtime=60; $exp=15;} #15 pm
    elseif($type=='Copper ore'){ $begtime=60; $exp=15; }
    elseif($type=='Iron ore' && $miningl>=10){ $begtime=80; $exp=22;}
    elseif($type=='Coal' && $miningl>=25){ $begtime=100; $exp=37;}
    elseif($type=='Silver' && $miningl>=40){ $begtime=135; $exp=60;}
    elseif($type=='Gold ore' && $miningl>=55){ $begtime=330; $exp=155; $specialGemChance = 1; }
    elseif($type=='Platina ore' && $miningl>=70)
    {
        $minTime = 90 - ($miningl >= 170 ? $miningl - 170 : 0);
        if($minTime < 29)
        {
            $minTime = 29;
        }
        $begtime=600; $exp=310; $specialGemChance = 0.95;
    }
    elseif($type=='Syriet ore' && $miningl>=85)
    {
        $minTime = 100 - ($miningl >= 190 ? $miningl - 190 : 0);
        if($minTime < 29)
        {
            $minTime = 29;
        }
		if($skillevent && $minTime < 59)
		{
			$minTime = $minTime = 59;
		}
        $begtime=800; $exp=1000; $specialGemChance = 0.9;
    }   # 45 pm
    elseif($type=='Obsidian ore' && $miningl>=100)
    {
        $minTime = 90 - ($miningl >= 257 ? $miningl - 257 : 0);
        if($minTime < 59)
        {
            $minTime = 59;
        }
		if($skillevent && $minTime < 119)
		{
			$minTime = $minTime = 119;
		}
        $begtime=1500; $exp=3000; $specialGemChance = 0.85;
    }   # 45 pm
    elseif($type=='Puranium ore' && $miningl>=120)
    {
        $minTime = 90 - ($miningl >= 257 ? $miningl - 257 : 0);
        if($minTime < 74)
        {
            $minTime = 74;
        }
		if($skillevent && $minTime < 149)
		{
			$minTime = $minTime = 149;
		}
        $begtime=2000; $exp=5000; $specialGemChance = 0.8;
    }   # 45 pm
    else{ $check=0; }


if($begtime < 800)
{
    $time=ceil($begtime*(((1-(pow($miningl, 0.7728)+($miningl/5))/100)*$minespeed)));
}
else if($begtime < 1500)
{
    $time=ceil($begtime*(((1-(pow($miningl, 0.73)+($miningl/5))/100)*$minespeed)));
}
else
{
    $time=ceil($begtime*(((1-(pow($miningl, 0.67)+($miningl/5))/100)*$minespeed)));
}

if($S_location=='Abydos')
{
	$time*=1.5;
}

$time = ceil($time+($workersTime*2));

if($time<$minTime){$time=$minTime;}



$neededd=$time+$worktimeuser;

if($workuser && $worktimeuser && $check==1){
if($worktime>=$worktimeuser){

	$break=rand(1,$durability);
	if($break==1 && $durability && stristr($S_location, "Tutorial")=='')
    { # NIET OP TUT ISLAND
	 	if(removeDurability($tool, $S_user))
        {
            $output.="<font color=red>Your $tool broke, you can only continue mining if you have another pickaxe.</font><br />";
            $time=0;
			$specialGemChance = 0;
        }
	}

	$pos1 = stristr($S_location, "utlands");
	if($S_location=='Abydos'){	$gemcatch=0; //Never any gems
	}else if($pos1 === false){ $gemcatch=rand(1,700); //Normal
	}else{  $gemcatch=rand(1,150); } //Outlands

    $status = "";

	if($gemcatch==1){
		$gem=rand(1,33);
        $gettype = 'gem';
        if($halloween && $gem > 20){$gem = randomBoneTool(); $gettype = $gem == 'Bone cauldron' ? "shield" : "hand"; }
        if($xmas && $gem > 20){$gem = randomStockingMaterial(); $gettype = "other"; }
        else if($gem==1){$gem='Diamond'; }
        else if($gem==2 OR $gem==3){ $gem='Garnet'; }
        else if($gem==4 OR $gem==5){ $gem='Spar'; }
        else if($gem==6 OR $gem==7 OR $gem==8){ $gem='Diaspore'; }
        else if($gem==9 OR $gem==10 OR $gem==11){ $gem='Beryl'; }
        else if($gem==12 OR $gem==13 OR $gem==14 OR $gem==15){ $gem='Quartz'; }
        else if($gem==16 OR $gem==17 OR $gem==18 OR $gem==19 OR $gem==20){ $gem='Avril'; }
        else if($gem==21 OR $gem==22 OR $gem==23 OR $gem==24 OR $gem==25 OR $gem==26){ $gem='Moonstone'; }
        else if($gem==27 OR $gem==28 OR $gem==29 OR $gem==30 OR $gem==31 OR $gem==32 OR $gem==33) { $gem='Amber'; }

		$status="<B>While mining, you found a <font color=yellow>$gem" . ($gettype == 'gem' ? " gem" : "") . "</font>!</b><br />";

		addItem($S_user, $gem, 1, $gettype, '', '', 1);
	}


	if($S_location=='Abydos' && $miningl>=85){
		$upper=225-$miningl;
		if($upper<=100){$upper=100;}
		$gemcatch=rand(1,$upper);
		if($gemcatch==1){
			$get=rand(1,10);
		 	if($get>7 && $miningl>=100){ $item='Obsidian ore';  }
		 	else{ $item='Syriet ore'; }
			$status="<B>While mining, you found a rare <font color=yellow>$item</font>!</b><br />";
			addItem($S_user, $item, 1, 'ore', '', '', 1);
		}
	}

    if($specialGemChance > 0)
    {
        $averageMiners = 400;
        $specialGemChance = ceil(((30/$time)*(2000*$averageMiners))*$specialGemChance);

        /*if(stristr($S_location, "utlands") === true)
        {
            $specialGemChance = ceil($specialGemChance / 2);
        }
        if(stristr($S_location, "rch. cave") === true)
        {
            $specialGemChance = ceil($specialGemChance / 2);
        }*/

		if(date("Y-m-d H:i:s") > '2013-03-01 00:00:00')
		{
			$gemcatch = rand(1, $specialGemChance);
		}
		else
		{
			$gemcatch = 0;
		}

        if($gemcatch==1)
        {
            $status="$status<B>While mining, you found a rare <font color=yellow>Serendibite gem</font>!</b><br />";
            addItem($S_user, "Serendibite", 1, "gem", '', '', 1);
        }
    }

	if($skillevent==1){
		$exp = UpdateSkillEvent($exp, $S_location, $S_user);
		if($SKILLEVENT_LEFT<1) $time=0;
	}
    else if($spawnEvent)
    {
        $spawnLeft = $spawnLeft - 1;
        if($spawnLeft<1) { $time=0; }
    }

    $exp = bonusExp("mining", $exp);
	mysqli_query($mysqli, "UPDATE users SET mining=mining+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --> f12");
	$levelArray=addExp($levelArray, 'mining', $exp);
	if($type2=='rare'){ mysqli_query($mysqli, "UPDATE locations SET monstersmuch=monstersmuch-1 WHERE location='$S_location' && type='resource' && monsters='$type' && monstersmuch>0 LIMIT 1") or die("error --> f12");      }

	addItem($S_user, $type, 1, 'ore', '', '', 1);

}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}


############
# EINDE Mining
############
################
## COOKING
################
}elseif($work=='cooking'){


	$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='shield' && name LIKE'% cauldron' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat))
	{
		$tool=$record->name;
	}

    $durability='';
	if($tool=='Bronze cauldron'){ 						$panSpeedBonus=0.98; 	$durability=750;	}
	elseif($tool=='Iron cauldron' && $cookingl>=10){  	$panSpeedBonus=0.96; 	$durability=750;}
	elseif($tool=='Steel cauldron' && $cookingl>=25){  	$panSpeedBonus=0.94; 	$durability=1000;}
	elseif($tool=='Silver cauldron' && $cookingl>=40){  	$panSpeedBonus=0.92; 	$durability=1000;}
	elseif($tool=='Gold cauldron' && $cookingl>=55){   	$panSpeedBonus=0.90; 	$durability=1750;	}
	elseif($tool=='Witch cauldron' && $cookingl>=60){   	$panSpeedBonus=0.89; 	$durability=5000;	}
	elseif($tool=='Platina cauldron' && $cookingl>=70){  	$panSpeedBonus=0.88; 	$durability=2500; }
	elseif($tool=='Bone cauldron' && $cookingl>=75){  	$panSpeedBonus=0.88; 	$durability=10000; }
	elseif($tool=='Syriet cauldron' && $cookingl>=85){   	$panSpeedBonus=0.86;	$durability=2750;}
	elseif($tool=='Obsidian cauldron' && $cookingl>=100){	$panSpeedBonus=0.84; 	$durability=3000;}
	elseif($tool=='Puranium cauldron' && $cookingl>=120){	$panSpeedBonus=0.81; 	$durability=3500;}
	else{ $panSpeedBonus=1; $tool=''; }

    $tinderbox = "";
   	$resultaat = mysqli_query($mysqli,  "SELECT name FROM items_wearing WHERE type != 'trophy' AND name LIKE '%Tinderbox' && username='$S_user' LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat))
	{
		$tinderbox=$record->name;
	}

    if($tinderbox == 'Bone tinderbox')
    {
        $panSpeedBonus *= 0.95;
        $tinderboxDurability = 10000;
    }
    else
    {
        $tinderboxDurability = 1000;
    }

	if($tinderbox == "" && ($S_location<>'The Outlands 37' && $S_location<>'The Outlands 16' && $S_location<>'Desert arena 1' && $S_location<>'Desert arena 3')){$check=0; }
	if($type=='Shrimps' && $cookingl>=1){ $reqCookLevel=1; $begtime=30; $exp=7;}     #15 pm
	elseif($type=='Frog'  && $cookingl>=1){ $reqCookLevel=1; $begtime=32; $exp=8; }
	elseif($type=='Sardine'  && $cookingl>=4){ $reqCookLevel=4; $begtime=40; $exp=14; }
	elseif($type=='Piranha'  && $cookingl>=5){ $reqCookLevel=5; $begtime=45; $exp=15; }
	elseif($type=='Herring'  && $cookingl>=9){ $reqCookLevel=9; $begtime=50; $exp=17; }
	elseif($type=='Catfish'  && $cookingl>=10){ $reqCookLevel=10; $begtime=55; $exp=19; }  //19/45  --> 19/40
	elseif($type=='Mackerel'  && $cookingl>=14){ $reqCookLevel=14; $begtime=60; $exp=20; }
	elseif($type=='Queen spider meat'  && $cookingl>=15){ $reqCookLevel=15; $begtime=65; $exp=25; }
	elseif($type=='Trouts'  && $cookingl>=19){ $reqCookLevel=19; $begtime=70; $exp=23; }
	elseif($type=='Cod'  && $cookingl>=20){ $reqCookLevel=20; $begtime=80; $exp=30; }
	elseif($type=='Pike'  && $cookingl>=20){ $reqCookLevel=20; $begtime=90; $exp=37; }
	elseif($type=='Salmon'  && $cookingl>=25){ $reqCookLevel=25 ; $begtime=100; $exp=40; }
	elseif($type=='Tuna'  && $cookingl>=30){ $reqCookLevel=30; $begtime=110; $exp=59; }   //59/115     59/120
	elseif($type=='Giant catfish'  && $cookingl>=35){ $reqCookLevel=35  ; $begtime=115; $exp=63; }
	elseif($type=='Lobster'  && $cookingl>=40){ $reqCookLevel=40; $begtime=130; $exp=66; }   //0.50 xp/sec
	elseif($type=='Bass'  && $cookingl>=43){ $reqCookLevel=43; $begtime=270; $exp=150; }  //0.55 xp/sec
	elseif($type=='Swordfish'  && $cookingl>=45)
    {
        $minTime = 90 - ($cookingl >= 160 ? $cookingl - 160 : 0);
        if($minTime < 44)
        {
            $minTime = 44;
        }
        $reqCookLevel=45 ; $begtime=500; $exp=280;
    } //0,56 xp/sec
	elseif($type=='Saurus meat'  && $cookingl>=50){ $reqCookLevel=50 ; $begtime=121; $exp=180; } //1.48 xp/sec
	elseif($type=='Platina dragon meat'  && $cookingl>=70){ $reqCookLevel=70 ; $begtime=180; $exp=240; }
	elseif($type=='Shark'  && $cookingl>=80)
    {
        $minTime = 90 - ($cookingl >= 160 ? $cookingl - 160 : 0);
        if($minTime < 44)
        {
            $minTime = 44;
        }
        $reqCookLevel=80; $begtime=660; $exp=400;
    }  //0,60
	elseif($type=='Syriet dragon meat'  && $cookingl>=85){ $reqCookLevel=85 ; $begtime=240; $exp=300; }
	elseif($type=='Obsidian dragon meat'  && $cookingl>=100){ $reqCookLevel=100 ; $begtime=300; $exp=360; }
	elseif($type=='Parrotfish'  && $cookingl>=100)
    {
        $minTime = 45;
        $reqCookLevel=80; $begtime=700; $exp=500;
    }  //0,60
	elseif($type=='Eel'  && $cookingl>=115)
    {
        $minTime = 45;
        $reqCookLevel=115; $begtime=750; $exp=600;
    }  //0,60
	elseif($type=='Snapper'  && $cookingl>=130)
    {
        $minTime = 59;
        $reqCookLevel=130; $begtime=800; $exp=1000;
    }  //0,60
	elseif($type=='Crab'  && $cookingl>=150)
    {
        $minTime = 59;
        $reqCookLevel=150; $begtime=850; $exp=1100;
    }  //0,60
	elseif($type=='Grouper'  && $cookingl>=165)
    {
        $minTime = 100 - ($cookingl >= 245 ? floor(($cookingl - 245)/2) : 0);
        if($minTime < 79)
        {
            $minTime = 79;
        }
        $reqCookLevel=165; $begtime=900; $exp=1550;
    }  //0,60

	else{ $check=0; }

	$requireItem="Wood";
	$nowood=0;
	if(($S_location=='Penteza') && rand(1,4)==1){$nowood=1;}
	else if(($S_location=='Croy') && rand(1,5)==1){$nowood=1;}
	else if(($S_location=='Thabis')){$requireItem="Coal";}

    if($begtime < 700)
    {
        $time=ceil($begtime*(((1-(pow($cookingl, 0.7728)+($cookingl/5))/100)))*$panSpeedBonus)+$workersTime*2;
    }
    else if($begtime < 800)
    {
        $time=ceil($begtime*(((1-(pow($cookingl, 0.73)+($cookingl/5))/100)))*$panSpeedBonus)+$workersTime*2;
    }
    else
    {
        $time=ceil($begtime*(((1-(pow($cookingl, 0.67)+($cookingl/5))/100)))*$panSpeedBonus)+$workersTime*2;
    }

    if($time<$minTime){$time=$minTime;}

if($type2=='stock'){
   $sql = "SELECT much FROM sidesstock WHERE type='food' && name='$type' && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much=$record->much;}
if($much<1){$time=0; }
}else{
   $sql = "SELECT much FROM items_inventory WHERE type='food' && name='$type' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much=$record->much;}
if($much<1){$time=0; }
}

if($type2=='stock'){
   $sql = "SELECT much FROM sidesstock WHERE name='$requireItem' && much>0 && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $muchwood=$record->much;}
}elseif($S_location<>'The Outlands 37' && $S_location<>'The Outlands 16' && $S_location<>'Desert arena 1' && $S_location<>'Desert arena 3'){
   $sql = "SELECT much FROM items_inventory WHERE name='$requireItem' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $muchwood=$record->much;}
}

if($muchwood>0 OR $S_location=='The Outlands 37' OR $S_location=='The Outlands 16' OR $S_location=='Desert arena 1' OR $S_location=='Desert arena 3'){

if($workuser && $worktimeuser && $check==1 && $time>0){
if($worktime>=$worktimeuser)
{
 	if($tool && $durability)
    {
	 	$break=rand(1,$durability);
 		if($break==1)
        {
 			if(removeDurability($tool, $S_user))
            {
                echo "messagePopup('Your $tool broke, you can continue cooking without it.', 'Durability');";
                $output.="<font color=red>Your $tool broke, you can continue cooking without it.</font><br />";
            }
		}
	}

 	if($tinderbox && $tinderboxDurability)
    {
	 	$break=rand(1,$tinderboxDurability);
 		if($break==1)
        {
 			if(removeDurability($tinderbox, $S_user))
            {
                $output.="<font color=red>Your $tinderbox broke, you can only continue cooking if you have another tinderbox.</font><br />";
                $time=0;
            }
		}
	}


	/*$kook="Cooked";
	$kooker=round(rand(0,($cookingl*4+5)));
	if($kooker<$exp){$kook="Burnt"; $exp=1;}
	*/

	//Burn rate Formula
	$kook="Cooked";
	$levelsTeveel=$cookingl-$reqCookLevel;

	$levelTeveel1=($levelsTeveel*3); //Voegt max 30% toe
	if($levelTeveel1>=30){$levelTeveel1=30;}
	$levelTeveel2=($levelsTeveel*1); //Voegt max 34% toe
	if($levelTeveel2>=34){$levelTeveel2=34;}
	$succesKans=35+$levelTeveel1+$levelTeveel2; //minstens 35%  Hier nog max 65%...daarna MAX 99% na de tweede plus
	if(rand(1,100)>=$succesKans){
		$kook="Burnt"; $exp=1;
	}


	if($skillevent==1){
		$exp = UpdateSkillEvent($exp, $S_location, $S_user);
	    //never happensif(mysql_affected_rows()==0){	    }
	}

    $exp = bonusExp("cooking", $exp);
	mysqli_query($mysqli, "UPDATE users SET cooking=cooking+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -->r 12");
	$levelArray=addExp($levelArray, 'cooking', $exp);
	if($type2=='stock'){
	 	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-1 WHERE  name='$requireItem' && sideid='$S_sideid'  LIMIT 1") or die("error --> g12");   #SIDE
		$muchwood--;
	}elseif($S_location<>'The Outlands 37' && $S_location<>'The Outlands 16' && stristr($S_location, "esert arena") === false && $nowood<>1 ){
	 	removeItem($S_user, $requireItem, 1, '', '', 1);
		 $muchwood--;
	}

	if($type2=='stock'){ #SIDE
	  	$sql = "SELECT score FROM sidesstock WHERE name='$type' && sideid='$S_sideid' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 mysqli_query($mysqli, "UPDATE stats SET sidescore=sidescore+'$record->score' WHERE username='$S_user' LIMIT 1") or die("error --> 74731");
		 }
		mysqli_query($mysqli, "UPDATE sidesstock SET much=much-1 WHERE  type='food' && name='$type' && much>0 && sideid='$S_sideid'  LIMIT 1") or die("123");
		mysqli_query($mysqli, "UPDATE sidesstock SET much=much+1 WHERE name='$kook $type' && sideid='$S_sideid' LIMIT 1") or die("error --> 31");
	} else{ #SIDE ELSE
		$much--;
		removeItem($S_user, $type, 1, '', '', 1);
		$itemType=strtolower("$kook food");
		addItem($S_user, "$kook $type", 1, $itemType, '', '', 1);
	}#SIDE

}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}
} else{ $time=0; }#eind wood

############
# EINDE COOKING
############
################
## SMITHING
################
}elseif($work=='smithing'){

$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user'  && name like '% hammer' LIMIT 1");
while ($record = mysqli_fetch_object($resultaat)) {  $werktool=$record->name;}
if(!$werktool){$check=0;   }


$durability='';
if($werktool=='Bronze hammer'){ $tooloff=1;   $durability=900;
}elseif($werktool=='Iron hammer' && $smithingl>=10){ $tooloff=0.98;  $durability=1000;
}elseif($werktool=='Steel hammer'  && $smithingl>=25){ $tooloff=0.96;  	$durability=1250;
}elseif($werktool=='Silver hammer'  && $smithingl>=40){ $tooloff=0.94;  $durability=2000;
}elseif($werktool=='Gold hammer' && $smithingl>=55){ $tooloff=0.92;  	$durability=2250;
}elseif($werktool=='Platina hammer' && $smithingl>=70){ $tooloff=0.90; $durability=2500;
}elseif($werktool=='Bone hammer' && $smithingl>=75){ $tooloff=0.89; $durability=10000;
}elseif($werktool=='Syriet hammer' && $smithingl>=85){ $tooloff=0.88;  $durability=2750;
}elseif($werktool=='Obsidian hammer' && $smithingl>=100){ $tooloff=0.86;  $durability=3000;
}elseif($werktool=='Puranium hammer' && $smithingl>=120){ $tooloff=0.83;  $durability=3500;
} else { $check=0;   }


if($type=='upgrade'){
	//$type2==upgrade
	//$type3==item

	//+1 15		+2   25		+3   40		+4   60		+5   80
	$upgrades[1]['upgradeType']="Durability";
	$upgrades[1]['upgradeMuch']=1;
	$upgrades[1]['upgradeLevel']=15;
	$upgrades[1]['upgradeCost1name']="Soft spider silk";
	$upgrades[1]['upgradeCost1much']=1;
	$upgrades[1]['upgradeCost2name']='';
	$upgrades[1]['upgradeCost2much']='';
	$upgrades[1]['upgradeEXP']='75';
	$upgrades[1]['upgradeBasetime']='120';

	$upgrades[2]['upgradeType']="Durability";
	$upgrades[2]['upgradeMuch']=2;
	$upgrades[2]['upgradeLevel']=30;
	$upgrades[2]['upgradeCost1name']="Hardened spider silk";
	$upgrades[2]['upgradeCost1much']=1;
	$upgrades[2]['upgradeCost2name']='';
	$upgrades[2]['upgradeCost2much']='';
	$upgrades[2]['upgradeEXP']='150';
	$upgrades[2]['upgradeBasetime']='160';

	$itemIDToUpgrade=$type3;
	$upgradeID=$type2;

	//Check level & upgrade
	if($upgrades[$upgradeID]['upgradeLevel'] && $upgrades[$upgradeID]['upgradeLevel']>$smithingl){
		exit();
	}

	$needed=$upgrades[$upgradeID]['upgradeCost1name'];
	$neededmuch=$upgrades[$upgradeID]['upgradeCost1much'];

	$needed2=$upgrades[$upgradeID]['upgradeCost2name'];
	$neededmuch2=$upgrades[$upgradeID]['upgradeCost2much'];

	if($check==1){
		$check=0;
		//Check if the enchanted/upgrade item is OK
		$sql = "SELECT ID,  name, much, type FROM items_inventory WHERE username='$S_user' && itemupgrade='' && ID='$itemIDToUpgrade' AND name NOT LIKE 'Dragon%' LIMIT 1";
		$resultaat = mysqli_query($mysqli, $sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
		  if($record->type=='shoes' OR $record->type=='hand' OR $record->type=='helm' OR $record->type=='legs' OR $record->type=='gloves' OR $record->type=='body' OR $record->type=='shield'){
				$check=1;
			}
		}
	}

	$exp=$upgrades[$upgradeID]['upgradeEXP'];
	$begtime=$upgrades[$upgradeID]['upgradeBasetime'];

}else{


if($type=='Bronze pickaxe' && $smithingl>=-5){   $typee='hand'; $exp=5; $needed='Bronze bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #5
elseif($type=='Bronze cauldron' && $smithingl>=-5){    $typee='shield';  $exp=5; $needed='Bronze bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze safe' && $smithingl>=-5){    $typee='safe';  $exp=5; $needed='Bronze bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze dagger' && $smithingl>=-5){    $typee='hand';  $exp=5; $needed='Bronze bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze hatchet' && $smithingl>=-5){    $typee='hand';  $exp=5; $needed='Bronze bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Bronze hammer' && $smithingl>=-4){    $typee='hand';  $exp=5; $needed='Bronze bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Bronze sabatons' && $smithingl>=-4){    $typee='shoes';  $exp=5; $needed='Bronze bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze short sword' && $smithingl>=-3){    $typee='hand';  $exp=6; $needed='Bronze bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze medium helm' && $smithingl>=-3){    $typee='helm';  $exp=6; $needed='Bronze bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze scimitar' && $smithingl>=-2){    $typee='hand';  $exp=6; $needed='Bronze bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze small shield' && $smithingl>=-2){    $typee='shield';  $exp=6; $needed='Bronze bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Bronze mace' && $smithingl>=-1){    $typee='hand';  $exp=7; $needed='Bronze bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Bronze hands' && $smithingl>=0){    $typee='gloves';  $exp=7; $needed='Bronze bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze long sword' && $smithingl>=1){    $typee='hand';  $exp=7; $needed='Bronze bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze medium shield' && $smithingl>=2){    $typee='shield';  $exp=8; $needed='Bronze bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Bronze chainmail' && $smithingl>=3){    $typee='body';  $exp=8; $needed='Bronze bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze legs' && $smithingl>=4){    $typee='legs';  $exp=9; $needed='Bronze bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze large helm' && $smithingl>=5){    $typee='helm';  $exp=9; $needed='Bronze bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze axe' && $smithingl>=6){    $typee='hand';  $exp=9; $needed='Bronze bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze large shield' && $smithingl>=7){    $typee='shield';  $exp=9; $needed='Bronze bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Bronze two handed sword' && $smithingl>=8){    $typee='hand';  $exp=9; $needed='Bronze bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Bronze plate' && $smithingl>=9){    $typee='body';  $exp=10; $needed='Bronze bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #10    50

elseif($type=='Iron pickaxe' && $smithingl>=10){   $typee='hand'; $exp=10; $needed='Iron bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #13
elseif($type=='Iron cauldron' && $smithingl>=10){    $typee='shield';  $exp=10; $needed='Iron bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron safe' && $smithingl>=10){    $typee='safe';  $exp=10; $needed='Iron bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron dagger' && $smithingl>=10){    $typee='hand';  $exp=10; $needed='Iron bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron hatchet' && $smithingl>=10){    $typee='hand';  $exp=10; $needed='Iron bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Iron hammer' && $smithingl>=11){    $typee='hand';  $exp=11; $needed='Iron bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Iron sabatons' && $smithingl>=11){    $typee='shoes';  $exp=11; $needed='Iron bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron short sword' && $smithingl>=12){    $typee='hand';  $exp=12; $needed='Iron bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron medium helm' && $smithingl>=12){    $typee='helm';  $exp=12; $needed='Iron bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron scimitar' && $smithingl>=13){    $typee='hand';  $exp=13; $needed='Iron bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron small shield' && $smithingl>=13){    $typee='shield';  $exp=13; $needed='Iron bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Iron mace' && $smithingl>=14){    $typee='hand';  $exp=14; $needed='Iron bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Iron hands' && $smithingl>=15){    $typee='gloves';  $exp=14; $needed='Iron bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron long sword' && $smithingl>=16){    $typee='hand';  $exp=15; $needed='Iron bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron medium shield' && $smithingl>=17){    $typee='shield';  $exp=15; $needed='Iron bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Iron chainmail' && $smithingl>=18){    $typee='body';  $exp=15; $needed='Iron bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron legs' && $smithingl>=19){    $typee='legs';  $exp=16; $needed='Iron bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron large helm' && $smithingl>=20){    $typee='helm';  $exp=16; $needed='Iron bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron axe' && $smithingl>=21){    $typee='hand';  $exp=16; $needed='Iron bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron large shield' && $smithingl>=22){    $typee='shield';  $exp=17; $needed='Iron bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Iron two handed sword' && $smithingl>=23){    $typee='hand';  $exp=17; $needed='Iron bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Iron plate' && $smithingl>=24){    $typee='body';  $exp=18; $needed='Iron bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #18     60

elseif($type=='Steel pickaxe' && $smithingl>=25){   $typee='hand'; $exp=15; $needed='Steel bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #20
elseif($type=='Steel cauldron' && $smithingl>=25){    $typee='shield';  $exp=15; $needed='Steel bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel safe' && $smithingl>=25){    $typee='safe';  $exp=15; $needed='Steel bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel dagger' && $smithingl>=25){    $typee='hand';  $exp=15; $needed='Steel bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel hatchet' && $smithingl>=25){    $typee='hand';  $exp=15; $needed='Steel bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Steel hammer' && $smithingl>=26){    $typee='hand';  $exp=16; $needed='Steel bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Steel sabatons' && $smithingl>=26){    $typee='shoes';  $exp=16; $needed='Steel bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel short sword' && $smithingl>=27){    $typee='hand';  $exp=17; $needed='Steel bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel medium helm' && $smithingl>=27){    $typee='helm';  $exp=17; $needed='Steel bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel scimitar' && $smithingl>=28){    $typee='hand';  $exp=18; $needed='Steel bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel small shield' && $smithingl>=28){    $typee='shield';  $exp=18; $needed='Steel bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Steel mace' && $smithingl>=29){    $typee='hand';  $exp=18; $needed='Steel bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Steel hands' && $smithingl>=30){    $typee='gloves';  $exp=19; $needed='Steel bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel long sword' && $smithingl>=31){    $typee='hand';  $exp=19; $needed='Steel bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel medium shield' && $smithingl>=32){    $typee='shield';  $exp=20; $needed='Steel bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Steel chainmail' && $smithingl>=33){    $typee='body';  $exp=20; $needed='Steel bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel legs' && $smithingl>=34){    $typee='legs';  $exp=21; $needed='Steel bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel large helm' && $smithingl>=35){    $typee='helm';  $exp=21; $needed='Steel bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel axe' && $smithingl>=36){    $typee='hand';  $exp=21; $needed='Steel bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel large shield' && $smithingl>=37){    $typee='shield';  $exp=22; $needed='Steel bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Steel two handed sword' && $smithingl>=38){    $typee='hand';  $exp=22; $needed='Steel bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Steel plate' && $smithingl>=39){    $typee='body';  $exp=23; $needed='Steel bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #23     70

elseif($type=='Silver pickaxe' && $smithingl>=40){   $typee='hand'; $exp=24; $needed='Silver bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #28
elseif($type=='Silver cauldron' && $smithingl>=40){    $typee='shield';  $exp=24; $needed='Silver bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver safe' && $smithingl>=40){    $typee='safe';  $exp=24; $needed='Silver bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver dagger' && $smithingl>=40){    $typee='hand';  $exp=24; $needed='Silver bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver hatchet' && $smithingl>=40){    $typee='hand';  $exp=24; $needed='Silver bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Silver hammer' && $smithingl>=41){    $typee='hand';  $exp=24; $needed='Silver bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Silver sabatons' && $smithingl>=41){    $typee='shoes';  $exp=24; $needed='Silver bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver short sword' && $smithingl>=42){    $typee='hand';  $exp=25; $needed='Silver bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver medium helm' && $smithingl>=42){    $typee='helm';  $exp=25; $needed='Silver bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver scimitar' && $smithingl>=43){    $typee='hand';  $exp=26; $needed='Silver bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver small shield' && $smithingl>=43){    $typee='shield';  $exp=26; $needed='Silver bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Silver mace' && $smithingl>=44){    $typee='hand';  $exp=26; $needed='Silver bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Silver hands' && $smithingl>=45){    $typee='gloves';  $exp=27; $needed='Silver bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver long sword' && $smithingl>=46){    $typee='hand';  $exp=27; $needed='Silver bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver medium shield' && $smithingl>=47){    $typee='shield';  $exp=28; $needed='Silver bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Silver chainmail' && $smithingl>=48){    $typee='body';  $exp=29; $needed='Silver bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver legs' && $smithingl>=49){    $typee='legs';  $exp=29; $needed='Silver bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver large helm' && $smithingl>=50){    $typee='helm';  $exp=30; $needed='Silver bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver axe' && $smithingl>=51){    $typee='hand';  $exp=30; $needed='Silver bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver large shield' && $smithingl>=52){    $typee='shield';  $exp=31; $needed='Silver bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Silver two handed sword' && $smithingl>=53){    $typee='hand';  $exp=31; $needed='Silver bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Silver plate' && $smithingl>=54){    $typee='body';  $exp=32; $needed='Silver bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #32    80

elseif($type=='Gold pickaxe' && $smithingl>=55){   $typee='hand'; $exp=120; $needed='Gold bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #32 - 37
elseif($type=='Gold cauldron' && $smithingl>=55){    $typee='shield';  $exp=120; $needed='Gold bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold safe' && $smithingl>=55){    $typee='safe';  $exp=120; $needed='Gold bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold dagger' && $smithingl>=55){    $typee='hand';  $exp=120; $needed='Gold bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold hatchet' && $smithingl>=55){    $typee='hand';  $exp=120; $needed='Gold bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Gold hammer' && $smithingl>=56){    $typee='hand';  $exp=124; $needed='Gold bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Gold sabatons' && $smithingl>=56){    $typee='shoes';  $exp=124; $needed='Gold bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold short sword' && $smithingl>=57){    $typee='hand';  $exp=125; $needed='Gold bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold medium helm' && $smithingl>=57){    $typee='helm';  $exp=125; $needed='Gold bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold scimitar' && $smithingl>=58){    $typee='hand';  $exp=127; $needed='Gold bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold small shield' && $smithingl>=58){    $typee='shield';  $exp=127; $needed='Gold bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Gold mace' && $smithingl>=59){    $typee='hand';  $exp=128; $needed='Gold bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Gold hands' && $smithingl>=60){    $typee='gloves';  $exp=129; $needed='Gold bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold long sword' && $smithingl>=61){    $typee='hand';  $exp=130; $needed='Gold bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold medium shield' && $smithingl>=62){    $typee='shield';  $exp=131; $needed='Gold bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Gold chainmail' && $smithingl>=63){    $typee='body';  $exp=132; $needed='Gold bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold legs' && $smithingl>=64){    $typee='legs';  $exp=133; $needed='Gold bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold large helm' && $smithingl>=65){    $typee='helm';  $exp=134; $needed='Gold bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold axe' && $smithingl>=66){    $typee='hand';  $exp=135; $needed='Gold bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold large shield' && $smithingl>=67){    $typee='shield';  $exp=136; $needed='Gold bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Gold two handed sword' && $smithingl>=68){    $typee='hand';  $exp=137; $needed='Gold bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Gold plate' && $smithingl>=69){    $typee='body';  $exp=138; $needed='Gold bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #36  42       90

elseif($type=='Platina pickaxe' && $smithingl>=70){   $typee='hand'; $exp=150; $needed='Platina bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #54
elseif($type=='Platina cauldron' && $smithingl>=70){    $typee='shield';  $exp=150; $needed='Platina bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina safe' && $smithingl>=70){    $typee='safe';  $exp=150; $needed='Platina bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina dagger' && $smithingl>=70){    $typee='hand';  $exp=150; $needed='Platina bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina hatchet' && $smithingl>=70){    $typee='hand';  $exp=150; $needed='Platina bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Platina hammer' && $smithingl>=71){    $typee='hand';  $exp=154; $needed='Platina bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Platina sabatons' && $smithingl>=71){    $typee='shoes';  $exp=154; $needed='Platina bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina short sword' && $smithingl>=72){    $typee='hand';  $exp=158; $needed='Platina bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina medium helm' && $smithingl>=72){    $typee='helm';  $exp=158; $needed='Platina bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina scimitar' && $smithingl>=73){    $typee='hand';  $exp=163; $needed='Platina bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina small shield' && $smithingl>=73){    $typee='shield';  $exp=163; $needed='Platina bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Platina mace' && $smithingl>=74){    $typee='hand';  $exp=166; $needed='Platina bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Platina hands' && $smithingl>=75){    $typee='gloves';  $exp=168; $needed='Platina bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina long sword' && $smithingl>=76){    $typee='hand';  $exp=170; $needed='Platina bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina medium shield' && $smithingl>=77){    $typee='shield';  $exp=172; $needed='Platina bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Platina chainmail' && $smithingl>=78){    $typee='body';  $exp=176; $needed='Platina bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina legs' && $smithingl>=79){    $typee='legs';  $exp=178; $needed='Platina bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina large helm' && $smithingl>=80){    $typee='helm';  $exp=180; $needed='Platina bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina axe' && $smithingl>=81){    $typee='hand';  $exp=182; $needed='Platina bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina large shield' && $smithingl>=82){    $typee='shield';  $exp=185; $needed='Platina bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Platina two handed sword' && $smithingl>=83){    $typee='hand';  $exp=188; $needed='Platina bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Platina plate' && $smithingl>=84){    $typee='body';  $exp=190; $needed='Platina bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   } #60       110

elseif($type=='Syriet pickaxe' && $smithingl>=85){   $typee='hand'; $exp=200; $needed='Syriet bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #40 80
elseif($type=='Syriet cauldron' && $smithingl>=85){    $typee='shield';  $exp=200; $needed='Syriet bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet safe' && $smithingl>=85){    $typee='safe';  $exp=200; $needed='Syriet bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet dagger' && $smithingl>=85){    $typee='hand';  $exp=200; $needed='Syriet bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet hatchet' && $smithingl>=85){    $typee='hand';  $exp=200; $needed='Syriet bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Syriet hammer' && $smithingl>=86){    $typee='hand';  $exp=210; $needed='Syriet bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Syriet sabatons' && $smithingl>=86){    $typee='shoes';  $exp=210; $needed='Syriet bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet short sword' && $smithingl>=87){    $typee='hand';  $exp=225; $needed='Syriet bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet medium helm' && $smithingl>=87){    $typee='helm';  $exp=225; $needed='Syriet bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet scimitar' && $smithingl>=88){    $typee='hand';  $exp=240; $needed='Syriet bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet small shield' && $smithingl>=88){    $typee='shield';  $exp=240; $needed='Syriet bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Syriet mace' && $smithingl>=89){    $typee='hand';  $exp=255; $needed='Syriet bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Syriet hands' && $smithingl>=90){    $typee='gloves';  $exp=270; $needed='Syriet bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet long sword' && $smithingl>=91){    $typee='hand';  $exp=285; $needed='Syriet bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet medium shield' && $smithingl>=92){    $typee='shield';  $exp=300; $needed='Syriet bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Syriet chainmail' && $smithingl>=93){    $typee='body';  $exp=315; $needed='Syriet bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet legs' && $smithingl>=94){    $typee='legs';  $exp=330; $needed='Syriet bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet large helm' && $smithingl>=95){    $typee='helm';  $exp=345; $needed='Syriet bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet axe' && $smithingl>=96){    $typee='hand';  $exp=360; $needed='Syriet bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet large shield' && $smithingl>=97){    $typee='shield';  $exp=375; $needed='Syriet bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Syriet two handed sword' && $smithingl>=98){    $typee='hand';  $exp=390; $needed='Syriet bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Syriet plate' && $smithingl>=99){    $typee='body';  $exp=405; $needed='Syriet bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   }  #45  150

elseif($type=='Obsidian pickaxe' && $smithingl>=100){   $typee='hand'; $exp=600; $needed='Obsidian bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #40 80
elseif($type=='Obsidian cauldron' && $smithingl>=100){    $typee='shield';  $exp=600; $needed='Obsidian bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian safe' && $smithingl>=100){    $typee='safe';  $exp=600; $needed='Obsidian bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian dagger' && $smithingl>=100){    $typee='hand';  $exp=600; $needed='Obsidian bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian hatchet' && $smithingl>=100){    $typee='hand';  $exp=600; $needed='Obsidian bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Obsidian hammer' && $smithingl>=101){    $typee='hand';  $exp=700; $needed='Obsidian bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Obsidian sabatons' && $smithingl>=101){    $typee='shoes';  $exp=700; $needed='Obsidian bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian short sword' && $smithingl>=102){    $typee='hand';  $exp=750; $needed='Obsidian bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian medium helm' && $smithingl>=102){    $typee='helm';  $exp=750; $needed='Obsidian bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian scimitar' && $smithingl>=103){    $typee='hand';  $exp=800; $needed='Obsidian bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian small shield' && $smithingl>=103){    $typee='shield';  $exp=800; $needed='Obsidian bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Obsidian mace' && $smithingl>=104){    $typee='hand';  $exp=850; $needed='Obsidian bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Obsidian hands' && $smithingl>=105){    $typee='gloves';  $exp=900; $needed='Obsidian bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian long sword' && $smithingl>=106){    $typee='hand';  $exp=950; $needed='Obsidian bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian medium shield' && $smithingl>=107){    $typee='shield';  $exp=1000; $needed='Obsidian bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Obsidian chainmail' && $smithingl>=108){    $typee='body';  $exp=1050; $needed='Obsidian bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian legs' && $smithingl>=109){    $typee='legs';  $exp=1100; $needed='Obsidian bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian large helm' && $smithingl>=110){    $typee='helm';  $exp=1150; $needed='Obsidian bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian axe' && $smithingl>=111){    $typee='hand';  $exp=1200; $needed='Obsidian bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian large shield' && $smithingl>=112){    $typee='shield';  $exp=1250; $needed='Obsidian bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Obsidian two handed sword' && $smithingl>=113){    $typee='hand';  $exp=1300; $needed='Obsidian bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Obsidian plate' && $smithingl>=114){    $typee='body';  $exp=1350; $needed='Obsidian bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   }  #45  150

elseif($type=='Puranium pickaxe' && $smithingl>=120){   $typee='hand'; $exp=1500; $needed='Puranium bars'; $neededmuch=1;     $needed2='Wood'; $neededmuch2=1; } #40 80
elseif($type=='Puranium cauldron' && $smithingl>=120){    $typee='shield';  $exp=1500; $needed='Puranium bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium safe' && $smithingl>=120){    $typee='safe';  $exp=1500; $needed='Puranium bars';  $neededmuch=6;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium dagger' && $smithingl>=120){    $typee='hand';  $exp=1500; $needed='Puranium bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium hatchet' && $smithingl>=120){    $typee='hand';  $exp=1500; $needed='Puranium bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Puranium hammer' && $smithingl>=122){    $typee='hand';  $exp=1600; $needed='Puranium bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Puranium sabatons' && $smithingl>=122){    $typee='shoes';  $exp=1600; $needed='Puranium bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium short sword' && $smithingl>=124){    $typee='hand';  $exp=1650; $needed='Puranium bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium medium helm' && $smithingl>=124){    $typee='helm';  $exp=1650; $needed='Puranium bars';  $neededmuch=1;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium scimitar' && $smithingl>=126){    $typee='hand';  $exp=1700; $needed='Puranium bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium small shield' && $smithingl>=126){    $typee='shield';  $exp=1700; $needed='Puranium bars';  $neededmuch=1;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Puranium mace' && $smithingl>=128){    $typee='hand';  $exp=1750; $needed='Puranium bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Puranium hands' && $smithingl>=130){    $typee='gloves';  $exp=1800; $needed='Puranium bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium long sword' && $smithingl>=132){    $typee='hand';  $exp=1850; $needed='Puranium bars';  $neededmuch=2;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium medium shield' && $smithingl>=134){    $typee='shield';  $exp=1900; $needed='Puranium bars';  $neededmuch=2;   $needed2='Wood'; $neededmuch2=2;   }
elseif($type=='Puranium chainmail' && $smithingl>=136){    $typee='body';  $exp=1950; $needed='Puranium bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium legs' && $smithingl>=138){    $typee='legs';  $exp=2000; $needed='Puranium bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium large helm' && $smithingl>=140){    $typee='helm';  $exp=2050; $needed='Puranium bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium axe' && $smithingl>=142){    $typee='hand';  $exp=2100; $needed='Puranium bars';  $neededmuch=3;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium large shield' && $smithingl>=144){    $typee='shield';  $exp=2150; $needed='Puranium bars';  $neededmuch=3;   $needed2='Wood'; $neededmuch2=1;   }
elseif($type=='Puranium two handed sword' && $smithingl>=146){    $typee='hand';  $exp=2200; $needed='Puranium bars';  $neededmuch=4;   $needed2=''; $neededmuch2=0;   }
elseif($type=='Puranium plate' && $smithingl>=148){    $typee='body';  $exp=2250; $needed='Puranium bars';  $neededmuch=5;   $needed2=''; $neededmuch2=0;   }  #45  150


else{ $check=0;  $output.="Unknown smithing item!"; }

$exp=round(($exp*$neededmuch)/4 + ($neededmuch2*2));
if($needed=='Bronze bars'){ $begtime=50; }
elseif($needed=='Iron bars'){ $begtime=60; }
elseif($needed=='Steel bars'){ $begtime=70; }
elseif($needed=='Silver bars'){ $begtime=80; }
elseif($needed=='Gold bars'){ $begtime=90; }
elseif($needed=='Platina bars'){ $begtime=110; }
elseif($needed=='Syriet bars'){ $begtime=150; }
elseif($needed=='Obsidian bars'){ $begtime=200; }
elseif($needed=='Puranium bars'){ $begtime=300; }

}

$time=ceil($tooloff*$begtime*(((1-(pow($smithingl, 0.7728)+($smithingl/5))/100))))+$workersTime*5;
if($time<29){$time=29;}

   $sql = "SELECT much FROM items_inventory WHERE name='$needed'  && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much=$record->much;}
if($much<$neededmuch){$time=0;  }

if($needed2){
   $sql = "SELECT much FROM items_inventory WHERE name='$needed2'  && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much2=$record->much;}
if($much2<$neededmuch2){$time=0;  }
}


if($workuser && $worktimeuser && $check==1 && $time>0){

if($status==''){
	$break=rand(1,$durability);
  if($break==1 && stristr($S_location, "Tutorial")==''){ #NIET OPT TUT ISLAND
 		if(removeDurability($werktool, $S_user))
		{
            $output.="<br /><font color=red><b>Your $werktool broke. To continue smithing you  need another hammer.</b></font><br /><br />";
            $time=0;
        }
 	}
}

if($worktime>=$worktimeuser && $check==1 && $time>0){

    $exp = bonusExp("smithing", $exp);
mysqli_query($mysqli, "UPDATE users SET smithing=smithing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -->d 122112");
$levelArray=addExp($levelArray, 'smithing', $exp);
removeItem($S_user, $needed, $neededmuch, '', '', 1);
$much-=$neededmuch;

if($needed2){
 	removeItem($S_user, $needed2, $neededmuch2, '', '', 1);
 	$much2-=$neededmuch2;
}

if($type=='upgrade'){

	$sql = "SELECT ID,  name, much, type FROM items_inventory WHERE username='$S_user' && itemupgrade='' && ID='$itemIDToUpgrade' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	  	if($record->type=='shoes' OR $record->type=='hand' OR $record->type=='helm' OR $record->type=='legs' OR $record->type=='gloves' OR $record->type=='body' OR $record->type=='shield'){

			addItem($S_user, $record->name, 1, $record->type, $upgrades[$upgradeID]['upgradeType'], $upgrades[$upgradeID]['upgradeMuch'], 1);
			$status="You successfully upgraded the <b>$record->name</b> with +".$upgrades[$upgradeID]['upgradeMuch']." ".$upgrades[$upgradeID]['upgradeType'].", you gained <b>$exp</b> smithing experience.<br /<br />";
		    removeItem($S_user, $record->name, 1, '', '', 1);
			$time=0;

		}
	}

}else{

	$upgrade=''; $upgrademuch='';
	if(rand(1,200)==1){  $upgrade='Durability'; $upgrademuch=1;
	}elseif(rand(1,400)==1){  $upgrade='Durability'; $upgrademuch=2;
	}elseif(rand(1,750)==1){  $upgrade='Durability'; $upgrademuch=3;
	}elseif(rand(1,1250)==1){  $upgrade='Durability'; $upgrademuch=4;
	}
	if($upgrade){ $output.="<br /><B>The $type was perfectly smithed; it is " . ($upgrademuch+1) . " times as durable!</B><br />"; }

	addItem($S_user, $type, 1, $typee, $upgrade, $upgrademuch, 1);

}

$break=rand(1,$durability);
if($break==1 && $durability &&  stristr($S_location, "Tutorial")==''  ){ #NIET OP TUT ISLAND
 	if(removeDurability($werktool, $S_user))
    {
        $output.="<font color=red>Your $werktool broke, you can only continue smithing if you have another hammer.</font><br />";
        $time=0;
    }
}

//Enough for next ?
if($much2<$neededmuch2 || $much<$neededmuch){
	$time=0;
}

}else{
 	if($time>0){
		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }
	}
}
}

############
# EINDE SMITHING
############
################
## SMELTING
################
}elseif($work=='smelting'){


if($type=='Bronze bars'){ 						$begtime=30; 	$exp=5; 	$needed1='Copper ore'; 	$needed2='Tin ore';	$needed3=''; 	$needed1much=1;  $needed2much=1;	$needed3much=0; } #10
elseif($type=='Iron bars' && $smithingl>=10){ 	$begtime=35; 	$exp=6; 	$needed1='Iron ore'; 	$needed2='';  		$needed3='';	$needed1much=1;  $needed2much=0; 	$needed3much=0;}
elseif($type=='Steel bars' && $smithingl>=25){ 	$begtime=40; 	$exp=10;	$needed1='Iron ore'; 	$needed2='Coal';  	$needed3='';	$needed1much=1;  $needed2much=1; 	$needed3much=0;}
elseif($type=='Silver bars' && $smithingl>=40){ $begtime=50; 	$exp=15; 	$needed1='Silver'; 		$needed2='';  		$needed3='';	$needed1much=2;  $needed2much=0; 	$needed3much=0;}
elseif($type=='Gold bars' && $smithingl>=55){ 	$begtime=790; 	$exp=250; 	$needed1='Gold ore'; 	$needed2='';  		$needed3='';	$needed1much=10; $needed2much=0; 	$needed3much=0;}
elseif($type=='Platina bars' && $smithingl>=70){$begtime=800; 	$exp=300; 	$needed1='Platina ore'; $needed2='Gold ore'; $needed3='Coal'; 	$needed1much=8;  $needed2much=6; 	$needed3much=4;}
elseif($type=='Syriet bars' && $smithingl>=85){ $begtime=850; 	$exp=400; 	$needed1='Syriet ore'; 	$needed2='Silver'; $needed3='Coal'; $needed1much=1; $needed2much=6; 	$needed3much=8;} #30
elseif($type=='Obsidian bars' && $smithingl>=100){ $begtime=950; 	$exp=5000; 	$needed1='Obsidian ore'; $needed2='Syriet ore'; $needed3='Platina ore'; $needed1much=1; $needed2much=5; $needed3much=15; } #30
elseif($type=='Puranium bars' && $smithingl>=120){ $begtime=1200; 	$exp=8000; 	$needed1='Puranium ore'; $needed2='Obsidian ore'; $needed3='Silver'; $needed1much=1; $needed2much=5; $needed3much=10; }

else{ $check=0; }

//$time=ceil($begtime*(((1-(pow($smithingl, 0.7728)+($smithingl/5))/100))))+$workersTime*2;

if($begtime < 1000)
{
    $time=ceil($begtime*(((1-(pow($smithingl, 0.7728)+($smithingl/5))/100))))+$workersTime*2;
}
else if($begtime < 1200)
{
    $time=ceil($begtime*(((1-(pow($smithingl, 0.73)+($smithingl/5))/100))))+$workersTime*2;
}
else
{
    $time=ceil($begtime*(((1-(pow($smithingl, 0.67)+($smithingl/5))/100))))+$workersTime*2;
}

if($time<29){$time=29;}

$much1 = 0;
$much2 = 0;
$much3 = 0;
if($type2=='stock'){ ## STOCK
   $sql = "SELECT much FROM sidesstock WHERE name='$needed1' && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much1=$record->much;}
	if($much1<$needed1much){$time=0;}
	if($needed2){
	   $sql = "SELECT much FROM sidesstock WHERE name='$needed2' && sideid='$S_sideid' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {  $much2=$record->much;}
	if($much2<$needed2much){$time=0; }
	}
	if($needed3){
	   $sql = "SELECT much FROM sidesstock WHERE name='$needed3' && sideid='$S_sideid' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {  $much3=$record->much;}
	if($much3<$needed3much){$time=0; }
	}
}else{ ### GEEN STOCK
   $sql = "SELECT much FROM items_inventory WHERE name='$needed1' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $much1=$record->much;}
	if($much1<$needed1much){$time=0; }
	if($needed2){
        $sql = "SELECT much FROM items_inventory WHERE name='$needed2' && username='$S_user' LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat)) {  $much2=$record->much;}
        if($much2<$needed2much){ $time=0; }
	}
	if($needed3){
	   $sql = "SELECT much FROM items_inventory WHERE name='$needed3' && username='$S_user' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {  $much3=$record->much;}
	if($much3<$needed3much){$time=0; }
	}
}


if($workuser && $worktimeuser && $check==1 && $time>0){
if($worktime>=$worktimeuser && $needed1much>0){
	if($skillevent==1){
		$exp = UpdateSkillEvent($exp, $S_location, $S_user);
	    //never happensif(mysql_affected_rows()==0){	    }
	}

    $exp = bonusExp("smithing", $exp);
	mysqli_query($mysqli, "UPDATE users SET smithing=smithing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -a-> 12");
	$levelArray=addExp($levelArray, 'smithing', $exp);
	if($type2=='stock'){ #SIDE
	  $sql = "SELECT score FROM sidesstock WHERE name='$type' && sideid='$S_sideid' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {  mysqli_query($mysqli, "UPDATE stats SET sidescore=sidescore+'$record->score' WHERE username='$S_user' LIMIT 1") or die("error --> 74731");    }
		mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$needed1much' WHERE  name='$needed1' && much>0 && sideid='$S_sideid'  LIMIT 1") or die("123");
		if($needed2){mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$needed2much' WHERE  name='$needed2' && much>0 && sideid='$S_sideid'  LIMIT 1") or die("123"); }
		if($needed3){mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$needed3much' WHERE  name='$needed3' && much>0 && sideid='$S_sideid'  LIMIT 1") or die("123"); }
		mysqli_query($mysqli, "UPDATE sidesstock SET much=much+1 WHERE name='$type' && sideid='$S_sideid' LIMIT 1") or die("error --> 31");
	} else{ #SIDE ELSE
		removeItem($S_user, $needed1, $needed1much, '', '', 1);

		if($needed2){
		 	removeItem($S_user, $needed2, $needed2much, '', '', 1);
		}
		if($needed3){
		 	removeItem($S_user, $needed3, $needed3much, '', '', 1);
		}

		addItem($S_user, $type, 1, 'bars', '', '', 1);

	}
	if($much1){
		$much1-=$needed1much;
	}
	if($much2){
		$much2-=$needed2much;
	}
	if($much1){
		$much3-=$needed3much;
	}
}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}

############
# EINDE SMELTING
############
################
## SCHOOL
################
}elseif($work=='school'){


if($type=='constructing'){ $time=60; $exp=20; $cost=round($constructingl/4+1); }
elseif($type=='trading'){ $time=60; $exp=20; $cost=round($tradingl/4+1); }
else{ $check=0; }


$time=$time+$workersTime*5;

   $sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $gold=$record->gold;}
if($gold<$cost){$time=0; }

if($workuser=='school' && $worktimeuser && $check==1 && $time>0){
	if($worktime>=$worktimeuser){
        $exp = bonusExp($type, $exp);
		mysqli_query($mysqli, "UPDATE users SET $type=$type+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --fd> 12");
		$levelArray=addExp($levelArray, $type, $exp);
		payGold($S_user, $cost);
	}else{
		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }
	}
}

############
# EINDE SCHOOL
############
################
## CONSTRUCTING
################
}else if($work=='constructing'){

$toolTimeReduction=1;

if($type == 'clancompound')
{
    $resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type != 'trophy' AND name LIKE '% hammer' && username='$S_user' LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat)) {  $werktool=$record->name;}
	if(!$werktool){$check=0; $output.="Equip a hammer! "; }

	$durability='';
	if($werktool=='Bronze hammer'){ $toolTimeReduction=1;   $durability=900;
	}elseif($werktool=='Iron hammer' && $constructingl>=10){ $toolTimeReduction=0.98;  $durability=1000;
	}elseif($werktool=='Steel hammer' && $constructingl>=25){ $toolTimeReduction=0.96;  	$durability=1250;
	}elseif($werktool=='Silver hammer' && $constructingl>=40){ $toolTimeReduction=0.94;  $durability=2000;
	}elseif($werktool=='Gold hammer' && $constructingl>=55){ $toolTimeReduction=0.92;  	$durability=2250;
	}elseif($werktool=='Platina hammer' && $constructingl>=70){ $toolTimeReduction=0.90; $durability=2500;
	}elseif($werktool=='Bone hammer' && $constructingl>=75){ $toolTimeReduction=0.89; $durability=10000;
	}elseif($werktool=='Syriet hammer' && $constructingl>=85){ $toolTimeReduction=0.88;  $durability=2750;
	}elseif($werktool=='Obsidian hammer' && $constructingl>=100 ){ $toolTimeReduction=0.85;  $durability=3000;
	}elseif($werktool=='Puranium hammer' && $constructingl>=120 ){ $toolTimeReduction=0.82;  $durability=3500;
	}else{ $check=0; $output.="You do not have the right construction level to use this hammer for construction.<br />"; }

    if($check)
    {
        $needed = $type2;
        $neededmuch = 0;
        $totalAdded = 0;
        $totalRemaining = 0;
        $underConstruction = false;
        $stockhouseID = 0;
        $currentSlots = 0;
        $sql = "SELECT * FROM clanbuildings WHERE location = '$S_location' AND tag = '$S_clantag'";
        //$output .=  "$sql<br/>";
        $resultset = mysqli_query($mysqli,$sql);
        if($record = mysqli_fetch_object($resultset))
        {
            $stockhouseID = $record->ID;
            $currentSlots = $record->slots;
            $underConstruction = $record->underConstruction;
            if($underConstruction)
            {
                $sql = "SELECT * FROM clanbuildingsresources WHERE clanbuildingID = $stockhouseID AND resource = '$type2'";
                //echo "$sql<br/>";
                $resultset = mysqli_query($mysqli,$sql);
                if($resources = mysqli_fetch_object($resultset))
                {
                    if($resources->required - $resources->added > 0)
                    {
                        $totalAdded = $resources->added;
                        $totalRemaining = $resources->required - $resources->added;

                        if($constructingl < 10)
                        {
                            $neededmuch = 5;
                            $exp = 40;
                        }
                        else if($constructingl < 25)
                        {
                            $neededmuch = 5;
                            $exp = 60;
                        }
                        else if($constructingl < 40)
                        {
                            $neededmuch = 10;
                            $exp = 80;
                        }
                        else if($constructingl < 55)
                        {
                            $neededmuch = 15;
                            $exp = 100;
                        }
                        else if($constructingl < 70)
                        {
                            $neededmuch = 20;
                            $exp = 120;
                        }
                        else if($constructingl < 85)
                        {
                            $neededmuch = 25;
                            $exp = 140;
                        }
                        else if($constructingl < 100)
                        {
                            $neededmuch = 30;
                            $exp = 160;
                        }
                        else if($constructingl < 120)
                        {
                            $neededmuch = 35;
                            $exp = 180;
                        }
                        else
                        {
                            $neededmuch = 40;
                            $exp = 200;
                        }

                        if($totalRemaining < $neededmuch)
                        {
                            $neededmuch = $totalRemaining;
                        }
                    }
                    else
                    {
                        $check = 0;
                    }
                }
                else
                {
                    $check = 0;
                }
            }
            else
            {
                $check = 0;
            }
        }
        $sql = "SELECT much FROM items_inventory WHERE name='$needed' && username='$S_user' LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat))
        {
            $much=$record->much;
        }

        if($neededmuch == 0)
        {
            $status = "The compound doesn't need any more $needed.";
            $time = 0;
            $exp = 0;
        }
        else if($much < $neededmuch)
        {
            $time = 0;
            $exp = 0;
        }
        else
        {
            $time = 180;
        }

        if($workuser && $worktimeuser && $check==1 && $time>0)
        {
            if($worktime>=$worktimeuser)
            {
                $break=rand(1,5000);
                if($werktool && $break==1 && stristr($S_location, "Tutorial")=='')
                { #NIET OPT TUT ISLAND
                    if(removeDurability($werktool, $S_user))
                    {
                        $output.="<font color=red>Your $werktool broke.</font><br />";
                    }
                }

                $much -= $neededmuch;
                $totalAdded += $neededmuch;
                $totalRemaining -= $neededmuch;
                if($much == 0)
                {
                    $time = 0;
                }
                removeItem($S_user, "$needed", $neededmuch, '', '', 1);
                mysqli_query($mysqli, "UPDATE clanbuildingsresources SET added = added+$neededmuch WHERE clanbuildingID  = $stockhouseID AND resource = '$needed' LIMIT 1") or die("hhh6442");
                $status="<font color=yellow><b>You have added some $needed to the clan stockhouse!</b></font>";

                $exp = bonusExp("constructing", $exp);
                mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("g22112");
                $levelArray=addExp($levelArray, 'constructing', $exp);

                if($totalRemaining == 0)
                {
                    //We can check if the compound is complete
                    $sql = "SELECT * FROM clanbuildingsresources WHERE clanbuildingID = $stockhouseID AND (required - added) > 0";
                    $resultset = mysqli_query($mysqli,$sql);
                    $newSlots = $currentSlots;
                    if(mysqli_num_rows($resultset) == 0)
                    {
                        switch($currentSlots)
                        {
                            case 0:
                                $newSlots = 50000;
                                break;

                            case 50000:
                                $newSlots = 100000;
                                break;

                            case 100000:
                                $newSlots = 150000;
                                break;

                            case 150000:
                                $newSlots = 250000;
                                break;

                            case 250000:
                                $newSlots = 500000;
                                break;

                            case 500000:
                                $newSlots = 750000;
                                break;

                            case 750000:
                                $newSlots = 1000000;
                                break;
                        }
                        $sql = "UPDATE clanbuildings SET underConstruction = false, slots = $newSlots WHERE ID = $stockhouseID";
                        mysqli_query($mysqli,$sql) or die("erroraa report this bug");

                        $sql = "DELETE FROM clanbuildingsresources WHERE clanbuildingID = $stockhouseID";
                        mysqli_query($mysqli,$sql) or die("erroraa report this bug");

                        $underConstruction = false;

                        # ADD CLAN CHAT MESSAGE
                        $SystemMessage = 1;
                        $chatMessage = "Our stockhouse at $S_location has been upgraded to $newSlots slots!";
                        $channel = 3;
                        include (GAMEPATH . "/scripts/chat/addchat.php");
                    }
                }
            }
            else
            {
                $time=$worktimeuser-$timee;
                if($time<=10)
                {
                    $time=10;
                }
            }
        }
    }
}
else
{
    if($type=='farmland'){
    $resultaat = mysqli_query($mysqli,  "SELECT username FROM items_wearing WHERE type != 'trophy' AND name LIKE '%Spade' && username='$S_user' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
	if($aantal<>1){$check=0; $output.="Equip a spade!"; }
}else{
	$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type != 'trophy' AND name LIKE '% hammer' && username='$S_user' LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat)) {  $werktool=$record->name;}
	if(!$werktool){$check=0; $output.="Equip a hammer!"; }

	$durability='';
	if($werktool=='Bronze hammer'){ $toolTimeReduction=1;   $durability=900;
	}elseif($werktool=='Iron hammer' && $constructingl>=10){ $toolTimeReduction=0.98;  $durability=1000;
	}elseif($werktool=='Steel hammer' && $constructingl>=25){ $toolTimeReduction=0.96;  	$durability=1250;
	}elseif($werktool=='Silver hammer' && $constructingl>=40){ $toolTimeReduction=0.94;  $durability=2000;
	}elseif($werktool=='Gold hammer' && $constructingl>=55){ $toolTimeReduction=0.92;  	$durability=2250;
	}elseif($werktool=='Platina hammer' && $constructingl>=70){ $toolTimeReduction=0.90; $durability=2500;
	}elseif($werktool=='Bone hammer' && $constructingl>=75){ $toolTimeReduction=0.89; $durability=10000;
	}elseif($werktool=='Syriet hammer' && $constructingl>=85){ $toolTimeReduction=0.88;  $durability=2750;
	}elseif($werktool=='Obsidian hammer' && $constructingl>=100 ){ $toolTimeReduction=0.85;  $durability=3000;
	}elseif($werktool=='Puranium hammer' && $constructingl>=120 ){ $toolTimeReduction=0.82;  $durability=3500;
	} else { $check=0; $output.="You do not have the right construction level to use this hammer for construction.<br />"; }

}

if($S_mapNumber==1 OR $S_mapNumber==2 OR $S_mapNumber==4 OR $S_mapNumber==6 OR $S_mapNumber==7 OR $S_mapNumber==10 OR $S_mapNumber==15  OR $S_mapNumber==16 OR $S_mapNumber==19 OR ($S_location=='Pensax' && ($constructingl>=10 || $type=='farmland')) ){

}else{
 	$check=0;
 }

if($type=='house250' && $constructingl>=1){ $begtime=500; $typee='house'; $slots=250; $exp=20;  $needed='Wood'; $neededmuch=250;     $needed2=''; $neededmuch2=0;}
elseif($type=='house500' && $constructingl>=1){ $begtime=500; $typee='house'; $slots=500; $exp=40;  $needed='Wood'; $neededmuch=750;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop100' && $constructingl>=5){ $begtime=400; $typee='shop'; $slots=100; $exp=30;  $needed='Wood'; $neededmuch=500;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop250' && $constructingl>=6){ $begtime=550; $typee='shop'; $slots=250; $exp=50;  $needed='Wood'; $neededmuch=750;     $needed2=''; $neededmuch2=0;}
elseif($type=='house1500' && $constructingl>=10){ $begtime=600; $typee='house'; $slots=1500; $exp=60;  $needed='Wood'; $neededmuch=2500;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop500' && $constructingl>=12){ $begtime=650; $typee='shop'; $slots=500; $exp=70;  $needed='Wood'; $neededmuch=1000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop750' && $constructingl>=15){ $begtime=725; $typee='shop'; $slots=750; $exp=80;  $needed='Wood'; $neededmuch=1250;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop1000' && $constructingl>=18){ $begtime=750; $typee='shop'; $slots=1000; $exp=90;  $needed='Wood'; $neededmuch=1500;     $needed2=''; $neededmuch2=0;}
elseif($type=='house3000' && $constructingl>=20){ $begtime=775; $typee='house'; $slots=3000; $exp=100;  $needed='Wood'; $neededmuch=5000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop1500' && $constructingl>=23){ $begtime=800; $typee='shop'; $slots=1500; $exp=110;  $needed='Wood'; $neededmuch=2000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house5000' && $constructingl>=25){ $begtime=825; $typee='house'; $slots=5000; $exp=120;  $needed='Wood'; $neededmuch=10000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop2000' && $constructingl>=26){ $begtime=850; $typee='shop'; $slots=2000; $exp=130;  $needed='Wood'; $neededmuch=4000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop2500' && $constructingl>=30){ $begtime=900; $typee='shop'; $slots=2500; $exp=140;  $needed='Wood'; $neededmuch=5000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house10000' && $constructingl>=35){ $begtime=950; $typee='house'; $slots=10000; $exp=140;  $needed='Wood'; $neededmuch=15000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop5000' && $constructingl>=40){ $begtime=950; $typee='shop'; $slots=5000; $exp=150;  $needed='Wood'; $neededmuch=7500;     $needed2=''; $neededmuch2=0;}
elseif($type=='house25000' && $constructingl>=45){ $begtime=1000; $typee='house'; $slots=25000; $exp=160;  $needed='Wood'; $neededmuch=20000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop10000' && $constructingl>=50){ $begtime=1000; $typee='shop'; $slots=10000; $exp=170;  $needed='Wood'; $neededmuch=15000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house50000' && $constructingl>=55){ $begtime=1050; $typee='house'; $slots=50000; $exp=180;  $needed='Wood'; $neededmuch=30000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop20000' && $constructingl>=60){ $begtime=1050; $typee='shop'; $slots=20000; $exp=190;  $needed='Wood'; $neededmuch=30000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house75000' && $constructingl>=65){ $begtime=1075; $typee='house'; $slots=75000; $exp=200;  $needed='Wood'; $neededmuch=45000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop30000' && $constructingl>=70){ $begtime=1075; $typee='shop'; $slots=30000; $exp=210;  $needed='Wood'; $neededmuch=40000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house100000' && $constructingl>=75){ $begtime=1100; $typee='house'; $slots=100000; $exp=220;  $needed='Wood'; $neededmuch=60000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop40000' && $constructingl>=80){ $begtime=1100; $typee='shop'; $slots=40000; $exp=230;  $needed='Wood'; $neededmuch=50000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house150000' && $constructingl>=85){ $begtime=1150; $typee='house'; $slots=150000; $exp=240;  $needed='Wood'; $neededmuch=90000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop50000' && $constructingl>=90){ $begtime=1150; $typee='shop'; $slots=50000; $exp=250;  $needed='Wood'; $neededmuch=55000;     $needed2=''; $neededmuch2=0;}
elseif($type=='house250000' && $constructingl>=95){ $begtime=1200; $typee='house'; $slots=250000; $exp=260;  $needed='Wood'; $neededmuch=150000;     $needed2=''; $neededmuch2=0;}
elseif($type=='shop100000' && $constructingl>=99){ $begtime=1200; $typee='shop'; $slots=100000; $exp=270;  $needed='Wood'; $neededmuch=100000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Brigantine' && $constructingl>=15 && $type2=='stock' && $S_sideid>0){ $begtime=300; $typee='boat'; $slots=0; $exp=100;  $needed='Wood'; $neededmuch=3000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Small fishing boat' && $constructingl>=20){ $begtime=700; $typee='boat'; $slots=0; $exp=100;  $needed='Wood'; $neededmuch=2000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Sloop' && $constructingl>=35){ $begtime=925; $typee='boat'; $slots=0; $exp=150;  $needed='Wood'; $neededmuch=5000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Boat' && $constructingl>=42){ $begtime=975; $typee='boat'; $slots=0; $exp=170;  $needed='Wood'; $neededmuch=10000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Trawler' && $constructingl>=50){ $begtime=1000; $typee='boat'; $slots=0; $exp=180;  $needed='Wood'; $neededmuch=15000;     $needed2=''; $neededmuch2=0;}
elseif($type=='Canoe' && $constructingl>=55){ $begtime=1050; $typee='boat'; $slots=0; $exp=210;  $needed='Wood'; $neededmuch=18000;     $needed2=''; $neededmuch2=0;}
elseif($type=='farmland'){

	 $slots='';
	 $sql = "SELECT farmslots FROM buildings WHERE type='house' && username='$S_user' && location='$S_location' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $slots=$record->farmslots; if($slots<25){$slots=25; } else { $slots=$slots*2; }
	$begtime=$slots; $typee='farmland'; $exp=$slots/10;  $needed='Gold'; $neededmuch=$slots*30;     $needed2=''; $neededmuch2=0;
	      }
	$output.="<br />Preparing the farmland to be able to hold $slots crops.<br />Buying this new land costs you $neededmuch gold.<br />";
	if($slots>900 OR $slots==''){$check=0; }

}elseif($type=='houseupgrade' ){

	$slots='';   $sql = "SELECT slots FROM buildings WHERE type='house' && username='$S_user' && location='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$slots=$record->slots*2;
		$begtime=ceil($slots/10);
		$typee='houseupgrade';
		$exp=$slots/10;
		$needed='Wood';
		$neededmuch=$slots*2;
	}
	$output.="<br />Upgrading your house.<br />You need $neededmuch wood to upgrade your house to $slots slots.<br />";
	if($slots>$constructingl*1000 OR $slots<50){$check=0; }

}elseif($type=='shopupgrade' ){

	$slots='';   $sql = "SELECT slots FROM buildings WHERE type='shop' && username='$S_user' && location='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	$slots=$record->slots*2;
	$begtime=ceil($slots/10);
	$typee='shopupgrade';
	$exp=$slots/10;
	$needed='Wood';
	$neededmuch=$slots*3;
	}
	$output.="<br />Upgrading your shop.<br />You need $neededmuch wood to upgrade your shop to $slots slots.<br />";
	if($slots>$constructingl*1000 OR $slots<50){$check=0; }

}else{
 	$check=0;
}


$exp=round($neededmuch/20+$begtime/100);
$time=ceil($begtime*$toolTimeReduction*(((1-(pow($constructingl, 0.7728)+($constructingl/5))/100))))+$workersTime*5;
if($time<29){$time=29;}

if($needed=='Gold'){
  $sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $much=$record->gold;
	}
}else if($type2=='stock'){
   $sql = "SELECT much FROM sidesstock WHERE name='$needed' && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $much=$record->much;
	}

	$sql = "SELECT much, request FROM sidesstock WHERE name='$type' && sideid='$S_sideid'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {
		if($record->much>=$record->request){
		 $check=0; $time=0; $exp=0;
		}else{
			$stockRequestsMore=$record->request-$record->much;
		}
	}

}else{
   $sql = "SELECT much FROM items_inventory WHERE name='$needed' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $much=$record->much;
	}
}

if($much<$neededmuch){
 	$time=0;
}

if($needed2){
   $sql = "SELECT much FROM items_inventory WHERE name='$needed2' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$much2=$record->much;
	}
	if($much2<$neededmuch2){$time=0; }
}

$need=$time+$worktimeuser;

if($typee=='shop' || $typee=='house'){
 	$resultaat = mysqli_query($mysqli,  "SELECT username FROM buildings WHERE location='$S_location' && type='$typee' && username='$S_user' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
	if($aantal==1){ $time=0; }

	$constructionName="$slots slot $typee";
}else{
	$constructionName="$type";
}

if($workuser && $worktimeuser && $check==1 && $time>0){
if($worktime>=$worktimeuser){

	$break=rand(1,400);
  	if($werktool && $break==1 && stristr($S_location, "Tutorial")==''){ #NIET OPT TUT ISLAND
 		if(removeDurability($werktool, $S_user))
        {
            $output.="<font color=red>Your $werktool broke.</font><br />";
        }
 	}


if($typee=='shop'){
### SHOP
 $resultaat = mysqli_query($mysqli,  "SELECT username FROM buildings WHERE location='$S_location' && type='$typee' && username='$S_user' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
if($aantal==1){ $time=0; } else {
   $sql = "INSERT INTO buildings (username, type, slots, location)
         VALUES ('$S_user', '$typee', '$slots', '$S_location')";
      mysqli_query($mysqli, $sql) or die("erroraa report this bug");

      $exp = bonusExp("constructing", $exp);
mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -hg-> 122112");
$levelArray=addExp($levelArray, 'constructing', $exp);
removeItem($S_user, $needed, $neededmuch, '', '', 1);
if($needed2){
 	removeItem($S_user, $needed2, $neededmuch2, '', '', 1);
}
$status="<font color=yellow><b>Your new $slots slot $typee has been built!</b></font>";
$time=0;

}
} elseif($typee=='house'){
#### HOUSE
 $resultaat = mysqli_query($mysqli,  "SELECT username FROM buildings WHERE location='$S_location' && type='$typee' && username='$S_user' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
if($aantal==1){
	$status="<font color=red>You may only control 1 $typee in every location.</font><br /><br />"; $time=0;
} else {
   $sql = "INSERT INTO buildings (username, type, slots, location)
         VALUES ('$S_user', '$typee', '$slots', '$S_location')";
      mysqli_query($mysqli, $sql) or die("erroraa report this bug");

      $exp = bonusExp("constructing", $exp);
	mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -b-> 122112");
	$levelArray=addExp($levelArray, 'constructing', $exp);
	removeItem($S_user, $needed, $neededmuch, '', '', 1);
	if($needed2){ removeItem($S_user, $needed2, $neededmuch2, '', '', 1); }

	$status="<font color=yellow><b>Your new $slots slot $typee has been built!</b></font>";
	$time=0;

}
} elseif($typee=='farmland'){
#### FARMLAND HOUSE
 	payGold($S_user, $neededmuch);
	mysqli_query($mysqli, "UPDATE buildings SET farmslots='$slots' WHERE type='house' && location='$S_location' && username='$S_user'  LIMIT 1") or die("hhh6442");

$status="<font color=yellow><b>You have bought and prepared your new farmland capable of harvesting $slots crops.</b></font>";
$time=0;

} elseif($typee=='houseupgrade'){
#### HOUSE UPGRADE
removeItem($S_user, 'Wood', $neededmuch, '', '', 1);
mysqli_query($mysqli, "UPDATE buildings SET slots='$slots' WHERE type='house' && location='$S_location' && username='$S_user'  LIMIT 1") or die("hhh6442");
$status="<font color=yellow><b>You have upgraded your house to $slots house slots!</b></font>";

$exp = bonusExp("constructing", $exp);
mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("g22112");
$levelArray=addExp($levelArray, 'constructing', $exp);
$time=0;
} elseif($typee=='shopupgrade'){
#### SHOP UPGRADE
removeItem($S_user, 'Wood', $neededmuch, '', '', 1);
mysqli_query($mysqli, "UPDATE buildings SET slots='$slots' WHERE type='shop' && location='$S_location' && username='$S_user'  LIMIT 1") or die("hhh6442");
$status="<font color=yellow><b>You have upgraded your shop to $slots slots!</b></font>";

$exp = bonusExp("constructing", $exp);
mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("g22112");
$levelArray=addExp($levelArray, 'constructing', $exp);
$time=0;
} else{
### ANDERS

$status="<font color=yellow><b>You have built a $type!</b></font>";

if($type2=='stock'){ #STOCK (BOAST)
   $sql = "SELECT score FROM sidesstock WHERE name='$type' && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 mysqli_query($mysqli, "UPDATE stats SET sidescore=sidescore+'$record->score' WHERE username='$S_user' LIMIT 1") or die("error --> 74731");
	}
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much+1 WHERE name='$type' && sideid='$S_sideid' LIMIT 1") or die("error --> 74731");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-'$neededmuch' WHERE  name='$needed' && much>0 && sideid='$S_sideid'  LIMIT 1") or die("yd243232");

    $exp = bonusExp("constructing", $exp);
	mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("g22112");
	$levelArray=addExp($levelArray, 'constructing', $exp);

} else{ #NOT STOCK (BOATS)

addItem($S_user, $type, 1, $typee, '', '', 1);


removeItem($S_user, $needed, $neededmuch, '', '', 1);
if($needed2){
	removeItem($S_user, $needed2, $neededmuch2, '', '', 1);
}

$exp = bonusExp("constructing", $exp);
mysqli_query($mysqli, "UPDATE users SET constructing=constructing+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("g22112");
$levelArray=addExp($levelArray, 'constructing', $exp);
}
}#EINDE Boats
 mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='', dump3='', online=1 WHERE username='$S_user' LIMIT 1") or die("ert113");
$much=$much-$neededmuch;
}else{

		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }

}
}
}

############
# EINDE CONSTRUCTING
############
################
## PLANTING
################
}elseif($work=='plant'){

	$farmingSeeds[1]['name']="Radish seeds";
	$farmingSeeds[1]['harvestName']="Radishes";
	$farmingSeeds[1]['harvestTime']=(rand((86400*0.5),(86400*1)));
	$farmingSeeds[1]['exp']=1;
	$farmingSeeds[1]['level']=1;

	$farmingSeeds[2]['name']="Beet seeds";
	$farmingSeeds[2]['harvestName']="Beet";
	$farmingSeeds[2]['harvestTime']=(rand((86400*0.5),(86400*0.7)));
	$farmingSeeds[2]['exp']=1;
	$farmingSeeds[2]['level']=2;

	$farmingSeeds[3]['name']="Carrot seeds";
	$farmingSeeds[3]['harvestName']="Carrots";
	$farmingSeeds[3]['harvestTime']=(rand((86400*0.75),(86400*1.5)));
	$farmingSeeds[3]['exp']=2;
	$farmingSeeds[3]['level']=4;

	$farmingSeeds[4]['name']="Cabbage seeds";
	$farmingSeeds[4]['harvestName']="Cabbage";
	$farmingSeeds[4]['harvestTime']=(rand((86400*1),(86400*1.5)));
	$farmingSeeds[4]['exp']=3;
	$farmingSeeds[4]['level']=7;

	$farmingSeeds[5]['name']="Onion seeds";
	$farmingSeeds[5]['harvestName']="Onion";
	$farmingSeeds[5]['harvestTime']=(rand((86400*1),(86400*1.75)));
	$farmingSeeds[5]['exp']=5;
	$farmingSeeds[5]['level']=11;

	$farmingSeeds[6]['name']="Grain seeds";
	$farmingSeeds[6]['harvestName']="Grain";
	$farmingSeeds[6]['harvestTime']=(rand((86400*1),(86400*2)));
	$farmingSeeds[6]['exp']=7;
	$farmingSeeds[6]['level']=14;

	$farmingSeeds[7]['name']="Tomato seeds";
	$farmingSeeds[7]['harvestName']="Tomato";
	$farmingSeeds[7]['harvestTime']=(rand((86400*1.5),(86400*2.25)));
	$farmingSeeds[7]['exp']=9;
	$farmingSeeds[7]['level']=17;

	$farmingSeeds[8]['name']="Corn seeds";
	$farmingSeeds[8]['harvestName']="Corn";
	$farmingSeeds[8]['harvestTime']=(rand((86400*1.75),(86400*2.5)));
	$farmingSeeds[8]['exp']=13;
	$farmingSeeds[8]['level']=20;

	$farmingSeeds[9]['name']="Strawberry seeds";
	$farmingSeeds[9]['harvestName']="Strawberry";
	$farmingSeeds[9]['harvestTime']=(rand((86400*2),(86400*3)));
	$farmingSeeds[9]['exp']=17;
	$farmingSeeds[9]['level']=25;

	$farmingSeeds[10]['name']="Green pepper seeds";
	$farmingSeeds[10]['harvestName']="Green pepper";
	$farmingSeeds[10]['harvestTime']=(rand((86400*2.5),(86400*3)));
	$farmingSeeds[10]['exp']=19;
	$farmingSeeds[10]['level']=29;

	$farmingSeeds[11]['name']="Spinach seeds";
	$farmingSeeds[11]['harvestName']="Spinach";
	$farmingSeeds[11]['harvestTime']=(rand((86400*1),(86400*3.5)));
	$farmingSeeds[11]['exp']=23;
	$farmingSeeds[11]['level']=34;

	$farmingSeeds[12]['name']="Eggplant seeds";
	$farmingSeeds[12]['harvestName']="Eggplant";
	$farmingSeeds[12]['harvestTime']=(rand((86400*2),(86400*4)));
	$farmingSeeds[12]['exp']=27;
	$farmingSeeds[12]['level']=39;

	$farmingSeeds[13]['name']="Cucumber seeds";
	$farmingSeeds[13]['harvestName']="Cucumber";
	$farmingSeeds[13]['harvestTime']=(rand((86400*3),(86400*4.5)));
	$farmingSeeds[13]['exp']=31;
	$farmingSeeds[13]['level']=43;

	$farmingSeeds[14]['name']="Pumpkin seeds";
	$farmingSeeds[14]['harvestName']="Pumpkin";
	$farmingSeeds[14]['harvestTime']=(rand((86400*3.5),(86400*5)));
	$farmingSeeds[14]['exp']=35;
	$farmingSeeds[14]['level']=48;

	$farmingSeeds[15]['name']="Apple seeds";
	$farmingSeeds[15]['harvestName']="Apple";
	$farmingSeeds[15]['harvestTime']=(rand((86400*3),(86400*5)));
	$farmingSeeds[15]['exp']=38;
	$farmingSeeds[15]['level']=52;

	$farmingSeeds[16]['name']="Pear seeds";
	$farmingSeeds[16]['harvestName']="Pear";
	$farmingSeeds[16]['harvestTime']=(rand((86400*2),(86400*5)));
	$farmingSeeds[16]['exp']=42;
	$farmingSeeds[16]['level']=57;

	$farmingSeeds[17]['name']="Broccoli seeds";
	$farmingSeeds[17]['harvestName']="Broccoli";
	$farmingSeeds[17]['harvestTime']=(rand((86400*2),(86400*5.5)));
	$farmingSeeds[17]['exp']=45;
	$farmingSeeds[17]['level']=63;

	$farmingSeeds[18]['name']="Peach seeds";
	$farmingSeeds[18]['harvestName']="Peach";
	$farmingSeeds[18]['harvestTime']=(rand((86400*2),(86400*6)));
	$farmingSeeds[18]['exp']=48;
	$farmingSeeds[18]['level']=66;

	$farmingSeeds[19]['name']="Orange seeds";
	$farmingSeeds[19]['harvestName']="Orange";
	$farmingSeeds[19]['harvestTime']=(rand((86400*4),(86400*4.5)));
	$farmingSeeds[19]['exp']=51;
	$farmingSeeds[19]['level']=71;

	$farmingSeeds[20]['name']="Plum seeds";
	$farmingSeeds[20]['harvestName']="Plum";
	$farmingSeeds[20]['harvestTime']=(rand((86400*3),(86400*3.5)));
	$farmingSeeds[20]['exp']=54;
	$farmingSeeds[20]['level']=78;

	$farmingSeeds[21]['name']="Avocado seeds";
	$farmingSeeds[21]['harvestName']="Avocado";
	$farmingSeeds[21]['harvestTime']=(rand((86400*5),(86400*5.5)));
	$farmingSeeds[21]['exp']=57;
	$farmingSeeds[21]['level']=84;

	$farmingSeeds[22]['name']="Pineapple seeds";
	$farmingSeeds[22]['harvestName']="Pineapple";
	$farmingSeeds[22]['harvestTime']=(rand((86400*1),(86400*7)));
	$farmingSeeds[22]['exp']=61;
	$farmingSeeds[22]['level']=89;

	$farmingSeeds[23]['name']="Watermelon seeds";
	$farmingSeeds[23]['harvestName']="Watermelon";
	$farmingSeeds[23]['harvestTime']=(rand((86400*5.9),(86400*6.1)));
	$farmingSeeds[23]['exp']=64;
	$farmingSeeds[23]['level']=92;

	$farmingSeeds[24]['name']="Vervefruit seeds";
	$farmingSeeds[24]['harvestName']="Vervefruit";
	$farmingSeeds[24]['harvestTime']=(rand((86400*5),(86400*7)));
	$farmingSeeds[24]['exp']=70;
	$farmingSeeds[24]['level']=97;

	$farmingSeeds[25]['name']="Fruit of life seeds";
	$farmingSeeds[25]['harvestName']="Fruit of life";
	$farmingSeeds[25]['harvestTime']=(rand((86400*6),(86400*7)));
	$farmingSeeds[25]['exp']=100;
	$farmingSeeds[25]['level']=100;

	$exp=0;
	$much=$type2;
	$seedsname='';
  	$sqla = "SELECT ID, name, much FROM items_inventory WHERE type='seeds' && ID='$type' && username='$S_user' LIMIT 1";
   	$resultaaat = mysqli_query($mysqli, $sqla);
   	while ($record = mysqli_fetch_object($resultaaat))
   	{
    	$seedsname=$record->name;
		if($much>$record->much){$much=$record->much;}
   	}

	if(!$seedsname){$check=0; }

	$seedNr='';
	for($i=1;$farmingSeeds[$i]['name'];$i++){
	 	if($farmingSeeds[$i]['name']==$seedsname){
			$seedNr=$i;
			break;
		}
	}
	if($farmingl<$farmingSeeds[$i]['level'] || !$seedNr){
	 	$check=0;
	}

	$sqla = "SELECT ID, farmslots FROM buildings WHERE type='house' && location='$S_location' && username='$S_user' LIMIT 1";
   	$resultaaat = mysqli_query($mysqli, $sqla);
   	while ($record = mysqli_fetch_object($resultaaat)) { $houseid=$record->ID;  $farmslots=$record->farmslots;}

	if($much>$farmslots){
		$much=$farmslots;
	}

	$freefarmslots=$farmslots;
	$aasql = "SELECT seedsmuch FROM farms WHERE building='$houseid'";
	$resultaaaaat = mysqli_query($mysqli, $aasql);
	while ($reco = mysqli_fetch_object($resultaaaaat)) { $freefarmslots=$freefarmslots-$reco->seedsmuch; }
	if($much>$freefarmslots OR $freefarmslots<1){$much=$freefarmslots;  }


	if($much<=0){
		$check=0;
	}

	$begtime=$much*5;
	$time=ceil($begtime*(((1-(pow($farmingl, 0.7728)+($farmingl/5))/100))));

	if($time<29){$time=29;}




if($workuser && $worktimeuser && $check==1 ){
 if($worktime>=$worktimeuser){

  $sqla = "SELECT ID, name, much FROM items_inventory WHERE type='seeds' && ID='$type' && username='$S_user' LIMIT 1";
   $resultaaat = mysqli_query($mysqli, $sqla);
   while ($record = mysqli_fetch_object($resultaaat))
   {

	if($much>$record->much){$much=$record->much;}

	$freefarmslots=$farmslots;
	 $aasql = "SELECT seedsmuch FROM farms WHERE building='$houseid'";
	   $resultaaaaat = mysqli_query($mysqli, $aasql);
	   while ($reco = mysqli_fetch_object($resultaaaaat)) { $freefarmslots=$freefarmslots-$reco->seedsmuch; }
	if($much>$freefarmslots OR $freefarmslots<1){$much=$freefarmslots; $output.="<B><br /><br />You ran out of farmland space.</B><br />";  }
	if(rand(1,30)==1){
		$dump=round(rand(($much*0.05),($much*0.2)));
		if($dump<1){$dump=''; }
	}else if(rand(1,30)==1){
		$dump=-1*round(rand(($much*0.05),($much*0.2)));
		if($much+$dump<=1){$dump=''; }
	}



	$exp=round($much* $farmingSeeds[$i]['exp'] );
	$seedstime=$farmingSeeds[$i]['harvestTime']+time();
	$seeds=$farmingSeeds[$i]['harvestName'];


	if($much>0 && $seeds){
		 removeItem($S_user, $record->name, $much, '', '', 1);

		$sql = "INSERT INTO farms (building, seeds, seedsmuch, seedstime, dump)
		         VALUES ('$houseid', '$seeds', '$much', '$seedstime', '$dump')";
		      mysqli_query($mysqli, $sql) or die("erroraa report this bug");

		$output.="<br /><br /><B>You have planted your $much seeds!</B><br />";
		$output.="<a href='' onclick=\"locationText('houses', 'farm');return false;\"><font color=yellow>Return to the farm page</font></a><br />"; $time=0;
	} else { $time=0;}
}

mysqli_query($mysqli, "UPDATE users SET work='', dump='', dump2='', dump3='', farming=farming+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --fd> 12");
$levelArray=addExp($levelArray, 'farming', $exp);
}else{
	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}

############
# EINDE PLANTING
############
################
## PICKING
################
}elseif($work=='pick'){
	$a=0;
	$sqla = "SELECT building, seeds, seedstime, seedsmuch, dump FROM farms WHERE seedstime<'$timee' && ID='$type' LIMIT 1";
   	$resultaaat = mysqli_query($mysqli, $sqla);
   	while ($record = mysqli_fetch_object($resultaaat))
   	{
   		$dump=$record->dump; $building=$record->building; $seedsname=$record->seeds; $a=1; $much=$record->seedsmuch;
   	}
   	if($a<>1){$check=0; }
	$begtime=$much*5;
	$time=ceil($begtime*(((1-(pow($farmingl, 0.7728)+($farmingl/5))/100))));
	if($time<29){$time=29;}
	$a=0;
	$sqla = "SELECT username FROM buildings WHERE ID=$building && username='$S_user'";
   	$resultaaat = mysqli_query($mysqli, $sqla);
   	while ($record = mysqli_fetch_object($resultaaat)) { $a=1;}if($a<>1){$check=0; }




if($workuser && $worktimeuser && $check==1){
if($worktime>=$worktimeuser){
      $sql = "DELETE FROM farms WHERE ID='$type' LIMIT 1";
      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
if($dump=='fail'){
	$exp=round($much/2);
	$output.="<br /><br /><B>You have thrown away your failed crops, but you did gain $exp farming experience.</B><br />";
	$output.="<a href='' onclick=\"locationText('houses', 'farm');return false;\"><font color=red>Return to the farm page</a><br />"; $time=0;
} else{
	if($dump>0){
		$much=$much+$dump; $dump="You had more crop than expected! You found $dump more $seedsname than you planned to harvest.<br />";
	}else if($dump<0){
		$much=$much+$dump; $dump="Some of your crops were mysteriously missing! You found ".($dump*-1)." fewer $seedsname than you expected to harvest.<br />";
	}
	$exp=round($much);
	$output.="<br /><br /><B>$dump You have harvested your crop, you gained $exp farming experience.</B><br />";
	$output.="<a href='' onclick=\"locationText('houses', 'farm');return false;\"><font color=yellow>Return to the farm page</a><br />"; $time=0;

	$type='cooked food';
	if($seedsname=='Grain'){$type='resources'; }
	addItem($S_user, $seedsname, $much, $type, '', '', 1);
}
mysqli_query($mysqli, "UPDATE users SET work='', dump='', dump2='', dump3='', farming=farming+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --fd> 12");
$levelArray=addExp($levelArray, 'farming', $exp);
}else{
 	$time=$worktimeuser-$timee;
	if($time<=10){ $time=10; }
}
}

############
# EINDE PICKING
############
################
## TRAINING
################
}elseif($work=='train' && $type2=='stock'){

   $sql = "SELECT much,name FROM sidesstock WHERE (name LIKE 'Cooked %' OR name LIKE '% bars') && sideid='$S_sideid'";
   //$output .= "$sql <br/><br/>";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {
        //$output .= $record->name . ": " . $record->much . "<br/>";
		if($record->name=='Cooked Herring'){$cookedherring=$record->much;}
		elseif($record->name=='Cooked Mackerel'){$cookedmackerel=$record->much;}
		elseif($record->name=='Cooked Cod'){$cookedcod=$record->much;}
		elseif($record->name=='Cooked Pike'){$cookedpike=$record->much;}
		elseif($record->name=='Cooked Salmon'){$cookedsalmon=$record->much;}
		elseif($record->name=='Iron bars'){$ironbars=$record->much;}
		elseif($record->name=='Steel bars'){$steelbars=$record->much;}
		elseif($record->name=='Silver bars'){$silverbars=$record->much;}
		elseif($record->name=='Gold bars'){$goldbars=$record->much;}
		/*elseif($record->name=='Platina bars'){$platinabars=$record->much;}
		elseif($record->name=='Syriet bars'){$syrietbars=$record->much;}
		elseif($record->name=='Obsidian bars'){$obsidianbars=$record->much;}*/
	}

$i=8;
$pirateTraining[$i]['pirate']="Pirate";
$pirateTraining[$i]['exp']="1";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="8";
$pirateTraining[$i]['ironbars']="3";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="1";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="0";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="0";

$i=7;
$pirateTraining[$i]['pirate']="Dread pirate";
$pirateTraining[$i]['exp']="3";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="11";
$pirateTraining[$i]['ironbars']="5";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="0";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="1";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="0";

$i=6;
$pirateTraining[$i]['pirate']="Keelhails pirate";
$pirateTraining[$i]['exp']="5";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="21";
$pirateTraining[$i]['ironbars']="10";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="4";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="0";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="0";

$i=5;
$pirateTraining[$i]['pirate']="Roughneck";
$pirateTraining[$i]['exp']="8";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="24";
$pirateTraining[$i]['ironbars']="15";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="0";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="4";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="0";

$i=4;
$pirateTraining[$i]['pirate']="Pegleg";
$pirateTraining[$i]['exp']="11";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="34";
$pirateTraining[$i]['ironbars']="0";
$pirateTraining[$i]['steelbars']="10";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="0";
$pirateTraining[$i]['cookedmackerel']="6";
$pirateTraining[$i]['cookedcod']="0";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="0";

$i=3;
$pirateTraining[$i]['pirate']="Buccaneer";
$pirateTraining[$i]['exp']="14";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="47";
$pirateTraining[$i]['ironbars']="0";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="10";
$pirateTraining[$i]['goldbars']="0";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="0";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="0";
$pirateTraining[$i]['cookedpike']="6";
$pirateTraining[$i]['cookedsalmon']="0";

$i=2;
$pirateTraining[$i]['pirate']="Hooked pirate";
$pirateTraining[$i]['exp']="17";
$pirateTraining[$i]['time']="60";
$pirateTraining[$i]['level']="60";
$pirateTraining[$i]['ironbars']="0";
$pirateTraining[$i]['steelbars']="0";
$pirateTraining[$i]['silverbars']="0";
$pirateTraining[$i]['goldbars']="1";
$pirateTraining[$i]['platinabars']="0";
$pirateTraining[$i]['syrietbars']="0";
$pirateTraining[$i]['obsidianbars']="0";
$pirateTraining[$i]['cookedherring']="0";
$pirateTraining[$i]['cookedmackerel']="0";
$pirateTraining[$i]['cookedcod']="0";
$pirateTraining[$i]['cookedpike']="0";
$pirateTraining[$i]['cookedsalmon']="7";

$time=0;
for($i=2; $pirateTraining[$i]['pirate'] && !$time; $i++)
{
    $pirate=$pirateTraining[$i]['pirate'];
    //$output .= "<br/>i=$i<br/>SELECT ID FROM sidesstock  WHERE name='$pirate' && much>=(request*1.25)&& sideid='$S_sideid' LIMIT 1<br/><br/>";
    $resultaat = mysqli_query($mysqli, "SELECT ID FROM sidesstock  WHERE name='$pirate' && much>=request && sideid='$S_sideid' LIMIT 1");
	$aantal = mysqli_num_rows($resultaat);
	if($aantal!=1)
	{
	  	if($level>=$pirateTraining[$i]['level'] &&
            $ironbars>=$pirateTraining[$i]['ironbars'] &&
            $steelbars>=$pirateTraining[$i]['steelbars'] &&
            $silverbars>=$pirateTraining[$i]['silverbars'] &&
            $goldbars>=$pirateTraining[$i]['goldbars'] &&
            /*$platinabars>=$pirateTraining[$i]['platinabars'] &&
            $syrietbars>=$pirateTraining[$i]['syrietbars'] &&
            $obsidianbars>=$pirateTraining[$i]['obsidianbars'] &&*/
            $cookedherring>=$pirateTraining[$i]['cookedherring'] &&
            $cookedmackerel>=$pirateTraining[$i]['cookedmackerel'] &&
            $cookedcod>=$pirateTraining[$i]['cookedcod'] &&
            $cookedpike>=$pirateTraining[$i]['cookedpike'] &&
            $cookedsalmon>=$pirateTraining[$i]['cookedsalmon'])
        {
            $time=$pirateTraining[$i]['time']; $exp=$pirateTraining[$i]['exp']; $train=$pirateTraining[$i]['pirate'];
            break;
		}
	}
}

if($time<=0 OR !$time){
	$check=0; $time=0;
}

$time=$time+$workersTime*2;


if($workuser && $worktimeuser && $check==1 && $time>0){
if($worktime>=$worktimeuser){

    $exp = bonusExp("pirate", $exp);
mysqli_query($mysqli, "UPDATE users SET attack=attack+'$exp', defence=defence+'$exp', health=health+'$exp', strength=strength+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error -11->r 12");
  $levelArray=addExp($levelArray, 'attack', $exp);
  $levelArray=addExp($levelArray, 'defence', $exp);
  $levelArray=addExp($levelArray, 'health', $exp);
  $levelArray=addExp($levelArray, 'strength', $exp);
$output.="<br />You trained 1 $train!<br />";
$output.="You gained $exp experience in attack, defence, strength and health.<br />";

if($train=='Pirate'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-3 WHERE  name='Iron bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 1g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-1 WHERE  name='Cooked Herring' && sideid='$S_sideid'  LIMIT 1") or die("error --> 2g12");
}elseif($train=='Dread pirate'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-5 WHERE  name='Iron bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 3g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-1 WHERE  name='Cooked Cod' && sideid='$S_sideid'  LIMIT 1") or die("error --> 4g12");
}elseif($train=='Keelhails pirate'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-10 WHERE  name='Iron bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 5g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-4 WHERE  name='Cooked Herring' && sideid='$S_sideid'  LIMIT 1") or die("error --> 6g12");
}elseif($train=='Roughneck'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-15 WHERE  name='Iron bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 5g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-4 WHERE  name='Cooked Cod' && sideid='$S_sideid'  LIMIT 1") or die("error --> 6g12");
}elseif($train=='Pegleg'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-10 WHERE  name='Steel bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 5g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-6 WHERE  name='Cooked Mackerel' && sideid='$S_sideid'  LIMIT 1") or die("error --> 6g12");
}elseif($train=='Buccaneer'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-10 WHERE  name='Silver bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 5g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-6 WHERE  name='Cooked Pike' && sideid='$S_sideid'  LIMIT 1") or die("error --> 6g12");
}elseif($train=='Hooked pirate'){
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-1 WHERE  name='Gold bars' && sideid='$S_sideid'  LIMIT 1") or die("error --> 5g12");
	mysqli_query($mysqli, "UPDATE sidesstock SET much=much-7 WHERE  name='Cooked Salmon' && sideid='$S_sideid'  LIMIT 1") or die("error --> 6g12");
}

  $sql = "SELECT score FROM sidesstock WHERE name='$train' && sideid='$S_sideid' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 mysqli_query($mysqli, "UPDATE stats SET sidescore=sidescore+'$record->score' WHERE username='$S_user' LIMIT 1") or die("error --> 74734341");
	}

mysqli_query($mysqli, "UPDATE sidesstock SET much=much+1 WHERE name='$train' && sideid='$S_sideid' LIMIT 1") or die("error --> 5631");

}else{

		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }
	}
}
### EINDE TRAINING
################
## LOCK PICKING
################
}elseif($work=='lockpicking'){


$resultaat = mysqli_query($mysqli,  "SELECT username, name FROM items_wearing WHERE type != 'trophy' AND name LIKE '%Lockpick' && username='$S_user' LIMIT 1");

$tool = "";
while ($record = mysqli_fetch_object($resultaat))
{
    $tool=$record->name;
}

//$aantal = mysqli_num_rows($resultaat);
//if($aantal<>1)
if($tool == "")
{
    $check=0;
    $status="<font color=yellow><B>You need to equip a lockpick.</B></font><br />";
}
/*else
{

}*/


$sqla = "SELECT name, much FROM items_inventory WHERE ID='$type' && username='$S_user' LIMIT 1";
   $resultaaat = mysqli_query($mysqli, $sqla);
   while ($record = mysqli_fetch_object($resultaaat)) { $opening=$record->name; $muchopen=$record->much;}

		 if($opening=='Locked toolbox'){ 					$time=90; $exp=50; }
	else if($opening=='Locked wooden egg'){ 				$time=90; $exp=100; }
 	else if($opening=='Locked christmas present'){ 			$time=90; $exp=100; }
	else if($opening=='Locked small chest'){ 	$levelr=10; $time=60*2; $exp=75; }
	else if($opening=='Locked moldy chest'){ 	$levelr=15; $time=60*4; $exp=125; }
	else if($opening=='Locked ancient chest'){ 	$levelr=25; $time=60*6; $exp=200; }
 	else if($opening=='Locked sarcophagus'){ 	$levelr=40; $time=60*8; $exp=500; }
 	else if($opening=='Locked christmas present'){ 	$levelr=40; $time=60*8; $exp=500; }
	 else{  $status="<font color=yellow><B>Invalid item to lockpick, please verify you still have the item.</B></font><br />"; $check=0; }

 if($thievingl<$levelr){  $status="<font color=yellow><B>You need level $levelr to lockpick the $opening.</B></font><br />"; $check=0; }

    if($tool == 'Bone lockpick')
    {
        $durability = 10000;
        $toolTimeReduction = 0.95;
    }
    else
    {
        $durability = 1000;
        $toolTimeReduction = 1;
    }

    $time=ceil($time*(((1-(pow($thievingl, 0.7728)+($thievingl/5))/100)))*$toolTimeReduction);

if($time<29){$time=29;}


if($workuser && $worktimeuser && $check==1){

	if($worktime>=$worktimeuser){
		removeItem($S_user, $opening, 1, '', '', 1);
		$status="<font color=yellow><B>You unlocked your $opening and gained $exp thieving experience!</B></font><br />";

        $break=rand(1,$durability);
        if($break==1 && $durability &&  stristr($S_location, "Tutorial")==''  ){ #NIET OP TUT ISLAND
            if(removeDurability($tool, $S_user))
            {
                $output.="<font color=red>Your $tool broke opening the $opening. You can only continue lockpicking if you have another lockpick.</font><br />";
                $time=0;
            }
        }

		$openedItem=str_replace ("Locked ", "", "$opening");
		$openedItem=ucfirst($openedItem);
		if(!$openedItem){//Temp (24-09 can be removed after a month or so)
			$status.="<font color=red><B>Error while lockpicking![$openedItem]</B></font><br />";
		}
		addItem($S_user, $openedItem, 1, 'open', '', '', 1);

		mysqli_query($mysqli, "UPDATE users SET thieving=thieving+'$exp', online=1 WHERE username='$S_user' LIMIT 1") or die("error --fd> 12");
		$levelArray=addExp($levelArray, 'thieving', $exp);
		if($muchopen==1){ $check=0; } # last chest 2 open
	}else{
		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }
	}
}


############
# EINDE LOCK PICKING
############
################
## OTHER QUESTS ETC
################
}elseif($work=='other'){
 	//Vars which are used at these 'skills'
	$tool2=''; $tool=''; $get=''; $getmuch='';
	$getExpSkill=''; $getExpMuch='';
	$cost=''; $costmuch='';

	if($type=='search eggs' && date(n)==4 && date(j)>=7 && date(j)<=8){
		//$getegg['Festival forest']['colour']='Red';
		//$getegg['Festival forest']['chance']=10;

		$getegg['Lisim']['colour']='Green';
		$getegg['Lisim']['chance']=10;
		$getegg['Barnacle bay']['colour']='Green';
		$getegg['Barnacle bay']['chance']=10;

		$getegg['Elven gate']['colour']='Blue';
		$getegg['Elven gate']['chance']=8;

		$getegg['Ogre lake']['colour']='Purple';
		$getegg['Ogre lake']['chance']=1;

		$getegg['Penteza forest']['colour']='Orange';
		$getegg['Penteza forest']['chance']=2;

		$getegg['Xanso']['colour']='Yellow';
		$getegg['Xanso']['chance']=6;
		$getegg['Skulls nose']['colour']='Yellow';
		$getegg['Skulls nose']['chance']=6;

		$getegg['Heerchey manor']['colour']='Pink';
		$getegg['Heerchey manor']['chance']=4;

		$output.="You are searching for easter eggs..<br />";

		if($getegg[$S_location]['colour']){
			if($getegg[$S_location]['chance']>=rand(1,400)){
				$colour=$getegg[$S_location]['colour'];

				$get="$colour easter egg";
				$getmuch=1;
				$gettype='cooked food';
				$time=30;
				$status2="<br /><br /><br /><font color=$colour><B>You found a $get!</B></font><br />";
			}else{
				$status2="<br /><br /><br />You didn't find any egg...but you know there are some out there!</font><br />";
			}
			$getExpSkill='speed'; $getExpMuch='15';
		}else{
			$check=0;
			$output.="There are no eggs here!";
		}

	}
    elseif($S_location=='Beset' && $type=='stoneclear' && doingQuest(18, 1))
    {
		$get='Rocks'; $getmuch=1;
		$time=50;
		$getExpSkill='mining'; $getExpMuch='30';
		$gettype='ore';
		$status2="<br /><br /><br /><font color=white><B>You cleared a rock.</B></font><br />";

		$tool='Pickaxe';
		$tool2='Torch';
	}
    elseif($S_location=='Beset' && $type=='stoneclear2' && doingQuest(22, 1))
    {
		$get='Rocks'; $getmuch=1;
		$time=50;
		$getExpSkill='mining'; $getExpMuch='30';
		$gettype='ore';
		$status2="<br /><br /><br /><font color=white><B>You cleared a rock.</B></font><br />";

		$tool='Pickaxe';
		$tool2='Torch';
	}
    elseif($S_location=='Beset' && $type=='buildbridge' && doingQuest(22, 2))
    {
		$cost='Wood'; $costmuch=1;
		$get=''; $getmuch=0;
		$time=30;
		$getExpSkill='constructing'; $getExpMuch='3';
		$gettype='';
		$status2="<br /><br /><br /><font color=white><B>You're building the bridge.</B></font><br />";

		$tool='Hammer';
	}
    elseif($S_location=='Thabis' && $type=='repairSmokehouse' && doingQuest(20, 1))
    {
		$cost='Wood'; $costmuch=1;
		$get=''; $getmuch=0;
		$time=30;
		$getExpSkill='constructing'; $getExpMuch='2';
		$gettype='';
		$status2="<br /><br /><br /><font color=white><B>You repaired the smokehouse.</B></font><br />";

		$tool='Hammer';
	}
    elseif(($S_location=='Stanro' || $S_location=='Thabis') && $type=='bread')
    {
        $mucho = 0;
        $sql = "SELECT much FROM items_inventory WHERE name='Bread' && username='$S_user'  LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }

        $sql = "SELECT much FROM items_inventory WHERE name='Grain' && username='$S_user'  LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat)) { $much=$record->much; }
        if($much==''){$much=0; }
        if(!$much){$much=0;}
        if($mucho==''){$mucho=0; }
        if(!$mucho){$mucho=0;}

		$get='Bread'; $getmuch=1;
		$cost='Grain'; $costmuch=1;
		$time=45;

        if($much == 0)
        {
            $time = 0;
            $check=0;
        }

		$getExpSkill='cooking'; $getExpMuch='12';
		$gettype='cooked food';
		//$status2="<br /><br /><br /><font color=yellow><B>You baked one loaf of bread.</B></font><br />";
	}
    elseif($S_location=='Thabis'  && $type=='cake' && $cookingl>=100)
    {
		$get='Cake'; $getmuch=1;
		$cost='Grain'; $costmuch=1;
		$cost2='Plum'; $costmuch2=1;
		$time=60;
		$getExpSkill='cooking'; $getExpMuch='50';
		$gettype='cooked food';
		$status2="<br /><br /><br /><font color=yellow><B>You baked one cake.</B></font><br />";

	/*
	}elseif($S_location=='Festival forest' && $PARTYISLAND){
		$get='Blue balloon';
		$getmuch=1;
		$time=300;
		$gettype='hand';
		$status2="<br /><br /><br /><font color=yellow><B>You made a blue balloon</B></font><br />";
	*/
	}
    elseif( ($S_location=='Thabis' && $type=='jail') || $S_location=='Sanfew' OR $S_location=='Skulls nose'){
		$get='gold';
		$getmuch=2;
		$time=60;
		$status2="<br /><br /><br /><B>You got $getmuch gold for cleaning the cells.</B></font><br />";
	}
    elseif($S_location=='Lost caves 10' && $type=='accessAC5_1' && doingQuest(24, 1))
    {
		$get='Rocks'; $getmuch=1;
		$time=45;
		$getExpSkill='mining'; $getExpMuch='30';
		$gettype='ore';
		$status2="<br /><br /><font color=white><B>You cleared a rock.</B></font><br />";

		$tool='Pickaxe';
		$tool2='Torch';
	}
    elseif($S_location=='Lost caves 10' && $type=='accessAC5_2' && doingQuest(24, 1))
    {
		//$cost='Wood'; $costmuch=1;
		$get=''; $getmuch=0;
		$time=45;
		$getExpSkill='constructing'; $getExpMuch='15';
		$gettype='';
		$status2="<br /><br /><font color=white><B>You built a support.</B></font><br />";

		$tool='Hammer';
		$tool2='Torch';
	}
    elseif($S_location=='Kanzo' && $type=='safe1' && doingQuest(26, 1))
    {
		$get=''; $getmuch=0;
		$time=60;
		$getExpSkill='trading'; $getExpMuch='10';
		$gettype='';
		$status2="<br /><font color=white><B>You learned some information about safes.</B></font><br />";
		
		$output.="<br />Trading level: ".$levelArray[$getExpSkill]['level']." (".$levelArray[$getExpSkill]['exp']." exp, ".$levelArray[$getExpSkill]['nextLevel']." for next level)<br />";

		$tool='';
		$tool2='';
	}
    elseif($S_location=='Penteza' && $type=='safe2' && doingQuest(26, 3))
    {
		$get=''; $getmuch=0;
		$time=60;
		$getExpSkill='trading'; $getExpMuch='10';
		$gettype='';
		$status2="<br /><font color=white><B>You learned some information about safes.</B></font><br />";
		
		$output.="<br />Trading level: ".$levelArray[$getExpSkill]['level']." (".$levelArray[$getExpSkill]['exp']." exp, ".$levelArray[$getExpSkill]['nextLevel']." for next level)<br />";

		$tool='';
		$tool2='';
	}
    elseif($S_location=='Heerchey manor' && $type=='safe3' && doingQuest(26, 5))
    {
		$get=''; $getmuch=0;
		$time=60;
		$getExpSkill='trading'; $getExpMuch='10';
		$gettype='';
		$status2="<br /><font color=white><B>You learned some information about safes.</B></font><br />";
		
		$output.="<br />Trading level: ".$levelArray[$getExpSkill]['level']." (".$levelArray[$getExpSkill]['exp']." exp, ".$levelArray[$getExpSkill]['nextLevel']." for next level)<br />";

		$tool='';
		$tool2='';
	}
    elseif($S_location=='Jungles edge' ){

		$rand=rand(1,90);
	  	if($rand<=4){   $get='Spider monkey';  			$gettype='pet'; 	$getmuch=1;
	    }elseif($rand<=7){   $get='Ringtail lemur';  	$gettype='pet'; 	$getmuch=1;
	    }elseif($rand<=9){   $get='Chimp';  			$gettype='pet'; 	$getmuch=1;
	    }elseif($rand<=10){   $get='Golden tamarin';  	$gettype='pet'; 	$getmuch=1;
		}else{	$get=''; 	$getmuch=0;		$gettype=''; }

		$time=60;
		$tool='';
		if($get){$status2="<br /><br /><B>You found a: $get</B><br />";
		}else{$status2="<br /><B>You didn't find a monkey</B><br />";}
		$getExpSkill='speed'; $getExpMuch='10';
	}elseif($S_location=='Arch. cave N'){

        $resultaat = mysqli_query($mysqli,  "SELECT username, name FROM items_wearing WHERE type != 'trophy' AND name LIKE '%Spade' && username='$S_user' LIMIT 1");

        while ($record = mysqli_fetch_object($resultaat))
        {
            $tool=$record->name;
        }

        if($tool == 'Bone spade')
        {
            $durability = 10000;
            $toolTimeReduction = 0.95;
        }
        else
        {
            $toolTimeReduction = 1;
            $durability = 1000;
        }

		$time=ceil(60*$toolTimeReduction);

        $break=rand(1,$durability);
        if($break==1 && $durability && stristr($S_location, "Tutorial")==''  ){ #NIET OP TUT ISLAND
            if(removeDurability($tool, $S_user))
            {
                $output.="<font color=red>Your $tool broke, you can only continue digging if you have another spade.</font><br />";
                $time=0;
            }
        }

        if($time)
        {
            if(rand(1,20)==1 &&  stristr($_SESSION['S_quests'], "8(4)]")<>''){   $get='Diamond shaped glass';  	$gettype='quest'; 	$getmuch=1;
            }elseif(rand(1,60)==1){   $get='Locked moldy chest';  	$gettype='locked'; 	$getmuch=1;
            }elseif(rand(1,30)==1){   $get='Locked toolbox';  	$gettype='locked'; 	$getmuch=1;
            }elseif(rand(1,5)==1){   $get='Broken glass';  	$gettype='junk'; 	$getmuch=1;
            }else{	$get='Rocks'; 	$getmuch=1;		$gettype='ore'; }
            $tool='Spade';
            $status2="<br /><br /><br /><B>You dug up: $get</B><br />";
        }
	}elseif($S_location=='Festival forest' && (date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30' )){

	    if(rand(1,100)==1){   $get='Locked moldy chest';  	$gettype='locked'; 	$getmuch=1;
	    }elseif(rand(1,50)==1){   $get='Skeleton skull';  	$gettype='other'; 	$getmuch=1;
	    }elseif(rand(1,40)==1){   $get='Skeleton body';  	$gettype='other'; 	$getmuch=1;
		}elseif(rand(1,50)==1){   $get='Skeleton leg';  	$gettype='other'; 	$getmuch=1;
	    }elseif(rand(1,50)==1){   $get='Skeleton arm';  	$gettype='other'; 	$getmuch=1;
		}elseif(rand(1,30)==1){   $get='Locked toolbox';  	$gettype='locked'; 	$getmuch=1;
	    }elseif(rand(1,10)==1){   $get='Wood';  	$gettype='wood'; 	$getmuch=1;
		}elseif(rand(1,5)==1){   $get='Tin ore';  	$gettype='ore'; 	$getmuch=1;
		}else{	$get='Rocks'; 	$getmuch=1;		$gettype='ore'; }
		$time=60;
		$tool='Spade';
		$status2="<br /><br /><br /><B>You dug up: $get</B><br />";

	}elseif($S_location=='Port party' && (date("Y-m")=='2009-12' ) ){

	    if(rand(1,40)==1){   $get='Small snowball';  	$gettype='other'; 	$getmuch=1; $status2="<br /><br /><br /><B>You made a small snowball</B><br />";
	    }elseif(rand(1,40)==1){   $get='Big snowball';  	$gettype='other'; 	$getmuch=1; $status2="<br /><br /><br /><B>You made a big snowball</B><br />";
	    }elseif(rand(1,2000)==1){   $get='Santa hat';  	$gettype='helm'; 	$getmuch=1;	$status2="<br /><br /><br /><B>You found a santa hat!</B><br />";
		}elseif(rand(1,100)==1){   $get='Coal';  	$gettype='ore'; 	$getmuch=1;		$status2="<br /><br /><br /><B>You found a piece of coal.</B><br />";
	    }elseif(rand(1,100)==1){   $get='Carrots';  	$gettype='cooked food'; 	$getmuch=1; $status2="<br /><br /><br /><B>You found a carrot!</B><br />";
		}elseif(rand(1,3000)==1){   $get='Diamond';  	$gettype='gem'; 	$getmuch=1;  	$status2="<br /><br /><br /><B><h1>WOW!</h1>You found a diamond!</B><br />";
		}else{ $status2="<br /><br /><br /><B>You've failed to make a good snowball</B><br />";  }
		$time=60;
		$tool='';

	}elseif($S_location=='Port party' && (date("-m")=='-12' ) ){

    $rand = rand(1,1000);
    if($rand < 125)
    {
        $get='Stocking decorations ' . date("Y");  	$gettype='other'; 	$getmuch=1; $status2="<br /><br /><br /><B>You found some $get!</B><br />";
    }
    else if($rand < 150)
    {
        switch(rand(1,3))
        {
            case 1:
                $get='Santa patch';
                break;

            case 2:
                $get='Snowman patch';
                break;

            case 3:
                $get='Rudolph patch';
                break;
        }

        $gettype='other';
        $getmuch=1;
        $status2="<br /><br /><br /><B>You found a $get!</B><br />";
    }
    else if($rand < 175)
    {
        $get= getXmasStockingColour() . ' christmas sock';  	$gettype='other'; 	$getmuch=1; $status2="<br /><br /><br /><B>You found a $get!</B><br />";
    }
    else if(rand(1,2000)==1){   $get='Santa hat';  	$gettype='helm'; 	$getmuch=1;	$status2="<br /><br /><br /><B>You found a santa hat!</B><br />";
    }
    else if(rand(1,100)==1){   $get='Coal';  	$gettype='ore'; 	$getmuch=1;		$status2="<br /><br /><br /><B>You found a piece of coal.</B><br />";
    }
    else if(rand(1,100)==1){   $get='Carrots';  	$gettype='cooked food'; 	$getmuch=1; $status2="<br /><br /><br /><B>You found a carrot!</B><br />";
    }
    else if(rand(1,3000)==1){   $get='Diamond';  	$gettype='gem'; 	$getmuch=1;  	$status2="<br /><br /><br /><B><h1>WOW!</h1>You found a diamond!</B><br />";
    }
    else{ $status2="<br /><br /><br /><B>You failed to find any decorations</B><br />";  }
    $time=60;
    $tool='';

	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestmining' && $groupQuestID > 0)
    {
        $groupQuestSkill = "mining";
        $time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            /*$upper=225-$miningl;
            if($upper<=100){$upper=100;}*/
            $catch=rand(1,5);//$upper);
            if($catch<=1)
            {
                $get=rand(1,25);
                if($get>22 && $miningl>=100){ $item='Obsidian ore';  }
                else if($get>15 && $miningl>=85){ $item='Syriet ore';  }
                else if($get>8 && $miningl>=70){ $item='Platina ore';  }
                else if($miningl>=55){ $item='Gold ore';  }
                else if($miningl>=40){ $item='Silver';  }
                else if($miningl>=25){ $item='Coal';  }
                else if($miningl>=10){ $item='Iron ore';  }
                else { $item= rand(1,3) == 1 ? 'Tin ore' : 'Copper ore';  }

                $status="<B>While mining, you found a <font color=yellow>$item</font>!</b><br />";
                addItem($S_user, $item, 1, 'ore', '', '', 1);
            }

            //$get = "Rocks";
            $get = "";
            $exp = 30;

            $getmuch=1;
            $getExpSkill='mining';
            $getExpMuch="$exp";
            $gettype='ore';
            $status2="<br />$status<font color=white><B>You mined $getmuch Rock, it was added to the stockpile.</B></font><br />";

            updateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

		$tool='Pickaxe';
		$tool2='Torch';
	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestwoodcutting' && $groupQuestID > 0)
    {
        $groupQuestSkill = "woodcutting";
        $time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            $getmuch=1;

            /*$upper=225-$woodcuttingl;
            if($upper<=100){$upper=100;}*/
            $seedcatch=rand(1,100);//$upper);
            $item = false;
            if($seedcatch<=10)
            {
                $get=rand(1,1000); ## SEEDS STUKJE
                if($get > 900 && $woodcuttingl >= 100) //Ammon seeds
                {
                    $seeds=rand(1,75);

                    if($seeds<=25){ $item="Pineapple seeds";  $much=rand(1,4); }
                    elseif($seeds<=45){ $item="Watermelon seeds";  $much=rand(1,4); }
                    elseif($seeds<=60){ $item="Vervefruit seeds";  $much=rand(1,4); }
                    elseif($seeds<=75){ $item="Fruit of life seeds";  $much=rand(1,4); }
                }
                else if($get > 800 && $woodcuttingl >= 75) //Khaya seeds
                {
                    $seeds=rand(1,75);

                    if($seeds<=25){ $item="Pear seeds";  $much=rand(1,4); }
                    elseif($seeds<=45){ $item="Broccoli seeds";  $much=rand(1,4); }
                    elseif($seeds<=60){ $item="Peach seeds";  $much=rand(1,4); }
                    elseif($seeds<=75){ $item="Orange seeds";  $much=rand(1,4); }
                }
                else if($get > 600 && $woodcuttingl >= 55) //Aloria seeds
                {
                    $seeds=rand(1,100);

                    if($seeds<=35){ $item="Spinach seeds";  $much=rand(1,8); }
                    elseif($seeds<=55){ $item="Eggplant seeds";  $much=rand(1,7); }
                    elseif($seeds<=75){ $item="Green pepper seeds";  $much=rand(1,9); }
                    elseif($seeds<=90){ $item="Pumpkin seeds";  $much=rand(1,5); }
                    elseif($seeds<=100){ $item="Apple seeds";  $much=rand(1,3); }
                }
                else if($woodcuttingl >= 40) //Penteza seeds
                {
                    $seeds=rand(1,75);

                    if($seeds<=35){ $item="Corn seeds";  $much=rand(1,10); }
                    elseif($seeds<=55){ $item="Strawberry seeds";  $much=rand(1,9); }
                    elseif($seeds<=75){ $item="Green pepper seeds";  $much=rand(1,8); }
                }
                else if($woodcuttingl >= 25) //Unera seeds
                {
                    $seeds=rand(1,75);

                    if($seeds<=40){ $item="Grain seeds";  $much=rand(1,10); }
                    elseif($seeds<=66){ $item="Tomato seeds";  $much=rand(1,9); }
                    elseif($seeds<=75){ $item="Corn seeds";  $much=rand(1,8); }
                }
                else if($woodcuttingl >= 10) //Unera seeds
                {
                    $seeds=rand(1,90);

                    if($seeds<=45){ $item="Cabbage seeds";  $much=rand(1,12); }
                    elseif($seeds<=75){ $item="Onion seeds";  $much=rand(1,11); }
                    elseif($seeds<=90){ $item="Beet seeds";  $much=rand(1,14); }
                }
                else //Isri seeds
                {
                    $seeds=rand(1,75);

                    if($seeds<=30){ $item="Radish seeds";  $much=rand(1,15); }
                    elseif($seeds<=60){ $item="Carrot seeds";  $much=rand(1,14); }
                    elseif($seeds<=75){ $item="Beet seeds";  $much=rand(1,13); }
                }

                if($item)
                {
                    //$getmuch = 0;
                    $status="<B><font color=yellow>Looks like an animal hid some seeds in the tree, you got $much $item.</font></b><br />";
                    addItem($S_user, $item, $much, 'seeds', '', '', 1);
                }
            }
            else if($seedcatch<=12)
            {
                $get=rand(1,20);

                if($get > 18)
                {
                    $item = "Locked sarcophagus";
                }
                else if($get > 14)
                {
                    $item = "Locked ancient chest";
                }
                else if($get > 8)
                {
                    $item = "Locked moldy chest";
                }
                else
                {
                    $item = "Locked toolbox";
                }

                if($item)
                {
                    $status="<B><font color=yellow>You cut down a hollow tree, a $item was hidden inside it!</font></b><br />";
                    addItem($S_user, $item, 1, 'locked', '', '', 1);
                }
            }

            //$get = "Wood";
            $get = "";
            $exp = 30;

            $getExpSkill='woodcutting';
            $getExpMuch="$exp";
            $gettype='item';
            $status2="<br />$status" . ($getmuch > 0 ? "<font color=white><B>You chopped $getmuch Wood, it was added to the stockpile.</B></font><br />" : "");

            $exp = UpdateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

		$tool='Hatchet';
	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestfishing' && $groupQuestID > 0)
    {
        $groupQuestSkill = "fishing";
		$time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            /*$upper=225-$miningl;
            if($upper<=100){$upper=100;}*/
            $catch=rand(1,100);//$upper);
            if($catch<=20)
            {
                $get=rand(1,25);
                if($get>=20 && $fishingl>=100)
                {
                    $rand = rand(1,5);

                    if($rand==1 && $fishingl>=180)
                    {
                        $item="Grouper";
                    }
                    else if($rand==2 && $fishingl>=160)
                    {
                        $item="Crab";
                    }
                    else if($rand==3 && $fishingl>=140)
                    {
                        $item="Snapper";
                    }
                    else if($rand==4 && $fishingl>=120)
                    {
                        $item="Eel";
                    }
                    else
                    {
                        $item="Parrotfish";
                    }
                }
                else if($get>15 && $fishingl>=50)
                {
                    $rand = rand(1,2);

                    if($rand==1 && $fishingl>=76)
                    {
                        $item="Shark";
                    }
                    else
                    {
                        $item="Swordfish";
                    }
                }
                else if($get>8 && $fishingl>=46)
                {
                    $item="Bass";
                }
                else if($fishingl>=35)
                {
                    $rand = rand(1,2);

                    if($rand==1 && $fishingl>=40)
                    {
                        $item="Lobster";
                    }
                    else
                    {
                        $item="Tuna";
                    }
                }
                else if($fishingl>=23)
                {
                    $rand = rand(1,3);

                    if($rand==1 && $fishingl>=30)
                    {
                        $item="Salmon";
                    }
                    else if($rand==2 && $fishingl>=25)
                    {
                        $item="Pike";
                    }
                    else
                    {
                        $item="Cod";
                    }
                }
                else if($fishingl>=5)
                {
                    $rand = rand(1,3);

                    if($rand==1 && $fishingl>=16)
                    {
                        $item="Mackerel";
                    }
                    else if($rand==2 && $fishingl>=10)
                    {
                        $item="Herring";
                    }
                    else
                    {
                        $item="Sardine";
                    }
                }
                else
                {
                    $item="Shrimps";
                }

                $status="<B>While fishing, you caught an extra <font color=yellow>$item</font>!</b><br />";
                addItem($S_user, $item, 1, 'food', '', '', 1);
            }
            else if($catch<=25)
            {
                $get=rand(1,2);

                if($get > 1)
                {
                    $item = "Locked toolbox";
                    $itemType = "locked";
                }
                else
                {
                    $item = "Leather boots";
                    $itemType = "shoes";
               }

                if($item)
                {
                    $status="<B><font color=yellow>While fishing, you found a $item!</font></b><br />";
                    addItem($S_user, $item, 1, $itemType, '', '', 1);
                }
            }

            //$get = "Rocks";
            $get = "";
            $exp = 30;

            $getmuch=1;
            $getExpSkill='fishing';
            $getExpMuch="$exp";
            $gettype='ore';
            $status2="<br />$status<font color=white><B>You caught $getmuch fish, it was added to the stockpile.</B></font><br />";

            $exp = updateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

		$tool='Net';
	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestsmithing' && $groupQuestID > 0)
    {
        $groupQuestSkill = "smithing";
		$time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            $getmuch=1;

            $get = "";
            $exp = 30;

            $getExpSkill='smithing';
            $getExpMuch="$exp";
            $gettype='item';
            $status2="<br />$status" . ($getmuch > 0 ? "<font color=white><B>You made $getmuch nail" . ($getmuch == 1 ? ". It was" : "s. They were")  . " added to the stockpile.</B></font><br />" : "");

            UpdateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

        $resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaat)){  $werktool=$record->name;}

        if($werktool=='Bronze hammer'){ //$tooloff=1;   $durability=900;
        }elseif($werktool=='Iron hammer' && $smithingl>=10){ //$tooloff=0.98;  $durability=1000;
        }elseif($werktool=='Steel hammer'  && $smithingl>=25){ //$tooloff=0.96;  	$durability=1250;
        }elseif($werktool=='Silver hammer'  && $smithingl>=40){ //$tooloff=0.94;  $durability=2000;
        }elseif($werktool=='Gold hammer' && $smithingl>=55){ //$tooloff=0.92;  	$durability=2250;
        }elseif($werktool=='Platina hammer' && $smithingl>=70){ //$tooloff=0.90; $durability=2500;
        }elseif($werktool=='Bone hammer' && $smithingl>=75){ //$tooloff=0.89; $durability=10000;
        }elseif($werktool=='Syriet hammer' && $smithingl>=85){ //$tooloff=0.88;  $durability=2750;
        }elseif($werktool=='Obsidian hammer' && $smithingl>=100){ //$tooloff=0.86;  $durability=3000;
        }elseif($werktool=='Puranium hammer' && $smithingl>=120){ //$tooloff=0.86;  $durability=3000;
        } else { $check=0;   }

		$tool='Hammer';
		//$tool2='Torch';
	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestcooking' && $groupQuestID > 0)
    {
        $groupQuestSkill = "cooking";
		$time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            $getmuch=1;

            $get = "";
            $exp = 30;

            $getExpSkill='cooking';
            $getExpMuch="$exp";
            $gettype='item';
            $status2="<br />$status" . ($getmuch > 0 ? "<font color=white><B>You cooked $getmuch fish" . ($getmuch == 1 ? "" : "")  . ", it was added to the stockpile.</B></font><br />" : "");

            UpdateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

        $resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaat)){  $werktool=$record->name;}

        if($werktool=='Tinderbox'){ //$tooloff=1;   $durability=900;
        }elseif($werktool=='Bone tinderbox' && $cookingl>=75){ }
        else { $check=0;   }

		$tool='Tinderbox';
		//$tool2='Torch';
	}
    else if(/*stristr($S_location, "Lost caves ") && */$type=='groupquestconstruction' && $groupQuestID > 0)
    {
        $groupQuestSkill = "constructing";
		$time=45;

        if($groupQuest && $workuser && $worktimeuser && $worktime>=$worktimeuser)
        {
            $getmuch=1;

            $get = "";
            $exp = 30;

            $getExpSkill='constructing';
            $getExpMuch="$exp";
            $gettype='item';
            $status2="<br />$status" . ($getmuch > 0 ? "<font color=white><B>You added $getmuch support" . ($getmuch == 1 ? "" : "s")  . ".</B></font><br />" : "");

            UpdateGroupQuest($S_location, $S_user, $groupQuestID, $groupQuestSubID, $getmuch);
            if($GROUPQUEST_LEFT<1)
            {
                $time=0;
            }
        }

        $resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='hand' && username='$S_user' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaat)){  $werktool=$record->name;}

        if($werktool=='Bronze hammer'){ //$tooloff=1;   $durability=900;
        }elseif($werktool=='Iron hammer' && $constructingl>=10){ //$tooloff=0.98;  $durability=1000;
        }elseif($werktool=='Steel hammer'  && $constructingl>=25){ //$tooloff=0.96;  	$durability=1250;
        }elseif($werktool=='Silver hammer'  && $constructingl>=40){ //$tooloff=0.94;  $durability=2000;
        }elseif($werktool=='Gold hammer' && $constructingl>=55){ //$tooloff=0.92;  	$durability=2250;
        }elseif($werktool=='Platina hammer' && $constructingl>=70){ //$tooloff=0.90; $durability=2500;
        }elseif($werktool=='Bone hammer' && $constructingl>=75){ //$tooloff=0.89; $durability=10000;
        }elseif($werktool=='Syriet hammer' && $constructingl>=85){ //$tooloff=0.88;  $durability=2750;
        }elseif($werktool=='Obsidian hammer' && $constructingl>=100){ //$tooloff=0.86;  $durability=3000;
        }elseif($werktool=='Puranium hammer' && $constructingl>=120){ //$tooloff=0.86;  $durability=3000;
        } else { $check=0;   }

		$tool='Hammer';
		$tool2='Torch';
	}
    else
    {
		$output.="Wrong";
	 	$check=0;
	}

	if($tool){
		$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_wearing WHERE type != 'trophy' AND name LIKE '%$tool' && username='$S_user' LIMIT 1");
		$aantal = mysqli_num_rows($resultaat);
		if($aantal<>1){ $check=0; 	$output.="<B>You do not have a $tool</B><br />";}
	}
	if($tool2){
		$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_wearing WHERE type != 'trophy' AND name LIKE '%$tool2'  && username='$S_user' LIMIT 1");
		$aantal = mysqli_num_rows($resultaat);
		if($aantal<>1){ $check=0; 	$output.="<B>You have not got a $tool2</B><br />";}
	}

   	if(!DEBUGMODE && $time<29){$time=29;}

	if($workuser && $worktimeuser && $check==1 ){
	 if( $worktime>=$worktimeuser){


		if($cost && $costmuch>0){
	        $resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory WHERE name='$cost' && much>='$costmuch' && username='$S_user' LIMIT 1");
			$aantal = mysqli_num_rows($resultaat);
			if($aantal==1){
			 	removeItem($S_user, $cost, $costmuch, '', '', 1);
			}else{
	         	$check=0;
			}
		}
		if($cost2 && $costmuch2>0){
	        $resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory WHERE name='$cost2' && much>='$costmuch2' && username='$S_user' LIMIT 1");
			$aantal = mysqli_num_rows($resultaat);
			if($aantal==1){
			 	removeItem($S_user, $cost2, $costmuch2, '', '', 1);
			}else{
	         	$check=0;
			}
		}
		if($check==1)
        {
			if($S_location=='Beset' && $type=='stoneclear' && doingQuest(18, 1)){
		 		$gather='Rocks';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Beset' && $type=='stoneclear2' && doingQuest(22, 1))
            {
		 		$gather='Rocks2';
		 		include ('locations/textincludes/quests.php');
		 	}
            else if($S_location=='Beset' && $type=='buildbridge' && doingQuest(22, 2))
            {
		 		$gather='repair';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Thabis' && $type=='repairSmokehouse' && doingQuest(20, 1))
            {
		 		$gather='repair';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Lost caves 10' && ($type=='accessAC5_1' || $type=='accessAC5_2') && doingQuest(24, 1))
            {
		 		$gather='accessAC5';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Kanzo' && $type=='safe1' && doingQuest(26, 1))
            {
		 		$gather='safe1';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Penteza' && $type=='safe2' && doingQuest(26, 3))
            {
		 		$gather='safe2';
		 		include ('locations/textincludes/quests.php');
	 		}
            else if($S_location=='Heerchey manor' && $type=='safe3' && doingQuest(26, 5))
            {
		 		$gather='safe3';
		 		include ('locations/textincludes/quests.php');
	 		}

			$output.="$status2";
			if($getExpSkill && $getExpMuch>=0 && is_numeric($getExpMuch) && $getExpSkill){
                $exp = bonusExp($getExpSkill, $getExpMuch);
				mysqli_query($mysqli, "UPDATE users SET $getExpSkill=$getExpSkill+'$getExpMuch', online=1 WHERE username='$S_user' LIMIT 1") or die("err2or --> 1");
				$levelArray=addExp($levelArray, $getExpSkill, $getExpMuch);

                if(($S_location=='Stanro' || $S_location=='Thabis' ) && $type=='bread')
                {
                    if($much > 0)
                    {
                        $mucho++;
                        $much--;
                    }

                    if($much == 0)
                    {
                        $time = 0;
                    }
                    //Don't need to do this here, we do it after the image now like everything else with an image
                    /*$output.="You have " . ($mucho+1) . " bread, you have " . ($much-1) . " grain left";
                    $output.="<br />Cooking level: ".$levelArray['cooking']['level']." (".$levelArray['cooking']['exp']." exp, ".$levelArray['cooking']['nextLevel']." for next level)<br />";
                    if($much-1 == 0)
                    {
                        $check=0;
                    }*/
                }
                else if(!$groupQuestSkill)
                {
                    $output.="<br/><small>You gained $getExpMuch $getExpSkill experience.</small><br />";
                }
			}

			if($getmuch>0 && $get){
				if($get=='gold'){
					getGold($S_user, $getmuch);
				}else{
				 	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);

				}
			}
		}
	}else{

		$time=$worktimeuser-$timee;
		if($time<=10){ $time=10; }

	}
	}





}else{

##BEGIN NO WORK
}
} #EINDE CHECK
#### EINDE CHECKS


//Tutorial text
if($S_location=='Tutorial 2' && $miningl>=2){
	$COPPER=0;
	$TIN=0;
   	$resultt = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE name='Copper ore' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultt)) {  $COPPER=$record->much;	}
   	$resultt = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE name='Tin ore' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultt)) {  $TIN=$record->much;		}
    if(($COPPER>=1 && $type=='Copper ore') OR ($type=='Tin ore' && $TIN>=1) )	{
		$output.="<br /><br /><b>You're done!</b><br />You've got what you need, please continue the tutorial by clicking on $S_location at the top-left!<br />";
		$output.="You can also click <a onclick=\"locationText();return false;\" href=\"#\"><font color=\"white\">here</font></a>.<br /><br />";

		$check=0;
		$work='tutorial';
	}
}else if(	($S_location=='Tutorial 6' && $cookingl>=6) OR ($S_location=='Tutorial 5' && $woodcuttingl>=3) OR ($S_location=='Tutorial 3' && $smithingl>=4) OR  ($S_location=='Tutorial 4' && $fishingl>=3)  ){
	$output.="<br /><br /><b>You're done!</b><br />You've got what you need, please continue the tutorial by clicking on $S_location at the top-left!<br />";
		$output.="You can also click <a onclick=\"locationText();return false;\" href=\"#\"><font color=\"white\">here</font></a>.<br /><br />";
$time=0;
	$check=0;
	$work='tutorial';
}
//End Tutorial text


if( stristr($S_location, "Tutorial")==true && $time>0){
	if($totalskill>=100){
	 	$time=60;
	}else{
	  	$time=25;
	}
}



if($skillevent || $spawnEvent)
{
    $freeSlots = ($skillevent ? $SKILLEVENT_LEFT : $spawnLeft) - $workers;
    if ($freeSlots <= 0 && $workers > 0)
    {
        $check = 2;

        $output .= "All " . ($skillevent ? $type : $spawnType) . "s are currently being worked on, so you are unable to join the work.<br/>";
        $output .= "<br />";
        $output .= "You should now wait until the $workers worker" . ($workers == 1 ? "" : "s") . " finish" . ($workers == 1 ? "es" : "") . "...<br />";
        $output .= "<br /><br/><br/>";

        mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='', dump3='', online=1 WHERE username='$S_user' AND work <> 'fight' LIMIT 1") or die("ert113");
    }
}

if($check==1){ #CHECKIE
$worktime=time()+$time;
if($time!=0){
 	mysqli_query($mysqli, "UPDATE users SET work='$work', worktime='$worktime', dump='$type', dump2='$type2', dump3='$type3', online=1 WHERE username='$S_user' LIMIT 1") or die("ert113");
}
#########################
### DISPLAY
#########################

$hour=date(G);
if($hour>=22 OR $hour<=3){$image='night';} #21-3 night      6
elseif($hour<=4 OR $hour>=21){$image='night';} #4-9 morning  6
else{ $image='day'; } #10-20 day   10

if($work=='other')
{
    if($S_location=="Arch. cave N")
    {
        $output.="<img src='images/work/digging.jpg' id=workImage border=1><br />";
    }
    else if($type == "bread")
    {
        $output.="<img src='images/work/baking$image.jpg' id=workImage border=1><br />";

        $output.="You have " . $mucho . " bread, you have " . $much . " grain left.";
        $output.="<br />Cooking level: ".$levelArray['cooking']['level']." (".$levelArray['cooking']['exp']." exp, ".$levelArray['cooking']['nextLevel']." for next level)<br />";
        if($much-1 == 0)
        {
            $check=0;
        }
    }
    else if($groupQuestSkill)
    {
        $output.="<br />" . ucfirst($groupQuestSkill) . " level: ".$levelArray[$groupQuestSkill]['level']." (".$levelArray[$groupQuestSkill]['exp']." exp, ".$levelArray[$groupQuestSkill]['nextLevel']." for next level)<br />";
        if($much-1 == 0)
        {
            $check=0;
        }
    }
}else if($work=='woodcutting' || $work=='lockpicking' || $work=='constructing' || $work=='cooking' || $work=='smithing' || $work=='smelting' || $work=='school' || $work=='mining' || $work=='fishing' || $work=='plant' || $work=='pick'){
	if($work=='plant' || $work=='pick'){
		$workNAME="farming";
	}else if($work=='school'){
		$workNAME="school $type";
	}else{
		$workNAME=$work;
	}

	if($S_mapNumber==3 || $S_mapNumber==14)
    {
        $output.="<br />";
    }
    else
    {
        $output.="<img src='images/work/$workNAME.jpg' id=workImage border=1><br />";
    }

}else{
	$workNAME=$work;
	if($work=='school'){$workNAME="$work$type"; }
	if($work<>'plant' && $work<>'pick' && $work<>'train' && $work<>'lockpicking' && $work<>'other'){
	 	if($S_mapNumber==3 || $S_mapNumber==14)
        {
            $output.="<br />";
        }
        else
        {
            $output.="<img src='images/work/$workNAME$image.jpg' id=workImage border=1><br />";
        }
	}
}

$mucho=0;

if($work=='woodcutting'){

   $sql = "SELECT much FROM items_inventory WHERE name='wood' && username='$S_user'  LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {  $mucho=$record->much; }
	$output.="You have $mucho wood.<br />";
	$output.="$status";
	$output.="Woodcutting level: ".$levelArray['woodcutting']['level']." (".$levelArray['woodcutting']['exp']." exp, ".$levelArray['woodcutting']['nextLevel']." for next level)<br />";

} elseif($work=='fishing'){

	if($status){
	   $sql = "SELECT much FROM items_inventory WHERE name='$vang' && username='$S_user' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {  $mucho=$record->much; }
	$output.="$status You have $mucho $vang.<br />";
	}
	$output.="Fishing level: ".$levelArray['fishing']['level']." (".$levelArray['fishing']['exp']." exp, ".$levelArray['fishing']['nextLevel']." for next level)<br />";

} elseif($work=='mining'){ ###MINING

   $sql = "SELECT much FROM items_inventory WHERE name='$type' && username='$S_user'  LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }
 	$output.="$status You have $mucho $type.<br />";
	$output.="Mining level: ".$levelArray['mining']['level']." (".$levelArray['mining']['exp']." exp, ".$levelArray['mining']['nextLevel']." for next level)<br />";

} elseif($work=='cooking'){ #### COOKING

	if($type2<>'stock'){
	   $sql = "SELECT much FROM items_inventory WHERE name='Cooked $type' && username='$S_user'  LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }
	    if($much==''){$much=0; }
	} else{
	   $sql = "SELECT much FROM sidesstock WHERE name='Cooked $type' && sideid='$S_sideid' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }
	}
	if(!$much){$much=0;}
	if(!$muchwood){$muchwood=0;}
	if($type2=='stock'){ $output.="There is $mucho Cooked $type, $much $type and $muchwood $requireItem in the stockhouse.";
	}else{ $output.="You have $mucho Cooked $type, you have $much $type"; if($S_location<>'The Outlands 16' && $S_location<>'The Outlands 37' && $S_location<>'Desert arena 1' && $S_location<>'Desert arena 3'){$output.=" and $muchwood $requireItem"; } }
	$output.=" left.<br />Cooking level: ".$levelArray['cooking']['level']." (".$levelArray['cooking']['exp']." exp, ".$levelArray['cooking']['nextLevel']." for next level)<br />";

} elseif($work=='smelting'){ ### SMELTING

	if($type2=='stock'){
	   $sql = "SELECT much FROM sidesstock WHERE name='$type' && sideid='$S_sideid' && much>0 LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }
	} else{
	   $sql = "SELECT much FROM items_inventory WHERE name='$type' && username='$S_user'  LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much; }
	}
	if(!$much1){$much1=0;}
	$alo='';
	if($needed3){ $alo=", $much3 $needed3 "; }
	if($needed2){ $alo.=" and $much2 $needed2"; }
	$output.="$status You have $mucho $type, you have $much1 $needed1$alo left.<br />";
	$output.="Smithing level: ".$levelArray['smithing']['level']." (".$levelArray['smithing']['exp']." exp, ".$levelArray['smithing']['nextLevel']." for next level)<br />";

} elseif($work=='plant' && $time>0){

	$output.="You are now planting $much $seedsname.<br />";
	$output.="Farming level: ".$levelArray['farming']['level']." (".$levelArray['farming']['exp']." exp, ".$levelArray['farming']['nextLevel']." for next level)<br />";

} elseif($work=='pick' && $time>0){

	$output.="You are now harvesting your $much $seedsname.<br />";
	$output.="Farming level: ".$levelArray['farming']['level']." (".$levelArray['farming']['exp']." exp, ".$levelArray['farming']['nextLevel']." for next level)<br />";

} elseif($work=='smithing'){

   	$sql = "SELECT much FROM items_inventory WHERE name='$type' && itemupgrade='' && username='$S_user'  LIMIT 1";
   	$resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $mucho=$record->much;}
	if($needed2){ $alo="and $much2 $needed2"; }
	if(!$much){$much=0;}
	$output.="$status";
	if($type=='upgrade'){
		$output.="You have $much $needed $alo left for upgrade(s).<br />";
	}else{
		$output.="You have $mucho $type, you have $much $needed $alo left.<br />";
	}
	$output.="Smithing level: ".$levelArray['smithing']['level']." (".$levelArray['smithing']['exp']." exp, ".$levelArray['smithing']['nextLevel']." for next level)<br />";

} elseif($work=='school'){

	$sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat)) { $gold=$record->gold; }   $output.="You have $gold Gold left to study $type.<br />";
	if($type=='constructing'){ $output.="Constructing level: ".$levelArray['constructing']['level']." (".$levelArray['constructing']['exp']." exp, ".$levelArray['constructing']['nextLevel']." for next level).<br />"; }
	elseif($type=='trading'){ $output.="Trading level: ".$levelArray['trading']['level']." (".$levelArray['trading']['exp']." exp, ".$levelArray['trading']['nextLevel']." for next level).<br />"; }

} elseif($work=='lockpicking'){

	$output.="$status<br />You are now lockpicking a $opening...<br />";
	$output.="Thieving level: ".$levelArray['thieving']['level']." (".$levelArray['thieving']['exp']." exp, ".$levelArray['thieving']['nextLevel']." for next level)<br />";

} elseif($work=='constructing'){

    if($type == 'clancompound')
    {
        if(!$much){$much=0;}
	 	$output.="$status<br />";
	   	if($time>0)
        {
	   		$output.="You are helping to construct the clan stockhouse, you have $much $needed left.<br />";
		}
        if(!$underConstruction)
        {
            $output .= "<b>The work on our clan stockhouse is complete! It now has $newSlots slots</b><br/>";
            $time = 0;
        }
        else if($totalRemaining > 0)
        {
            $output .= "So far we have added $totalAdded $needed to the stockhouse. We still need to add $totalRemaining $needed.<br/>";
        }
        else
        {
            $output .= "We have added all the required $needed! Check back at the stockhouse to see what else is needed.<br/>";
            $time = 0;
        }
		$output.="Constructing level: ".$levelArray['constructing']['level']." (".$levelArray['constructing']['exp']." exp, ".$levelArray['constructing']['nextLevel']." for next level)<br />";
    }
	else if($typee=='farmland' OR $typee=='houseupgrade' OR $typee=='shopupgrade'){
		$output.="";
	} else{
	 	if(!$much){$much=0;}
	 	$output.="$status<br />";
	   	if($time>0){
	   		$output.="You are constructing a $constructionName, you have $much wood left.<br />";
		}
		$output.="Constructing level: ".$levelArray['constructing']['level']." (".$levelArray['constructing']['exp']." exp, ".$levelArray['constructing']['nextLevel']." for next level)<br />";
	}
}
if($time>0){
if($work<>'plant' && $work<>'pick' && $work<>'lockpicking'){$output.="There " . ($workers == 1 ? "is" : "are") . " $workers other player" . ($workers == 1 ? "" : "s") . " working here.<br />";}


	## WORKTIME+WORKSTARTED REQUIRED
	$delta=1000;
	$seconden=$time; //($workstarted+$worktime)-time();
	if($seconden<5){$seconden=5;}

	$startedMilisecAgo=0; //(($time-$workstarted)*1000);
	if($startedMilisecAgo<0){$startedMilisecAgo=0;}

	echo"setTimeout(\"locationTextCounter('workCounter', (new Date().getTime()+$seconden*1000), '$timee', 'work', '$work', '$type', '$type2', '$type3');\", 500);";
	$output.="<input type=\"text\" readonly size=\"4\" id='workCounter' class=\"counter\" value='".($seconden)."' title='$timee'>";

	if($skillevent==1)
    {
		$output.="<br /><br /><small>+25% experience boost because of the event ($SKILLEVENT_LEFT left).</small>";
	}
    else if($spawnEvent)
    {
        $output.="<br /><br /><small>$spawnLeft $spawnType remaining.</small>";
    }
	elseif($groupQuest)
    {
		$output.="<br /><br /><small>Progress: " . ($groupQuestTotal-$GROUPQUEST_LEFT) . "/$groupQuestTotal</small>";
	}
} else {  ## STOP WORK

	//This was added 18-06  12:40...any problems ? It should be OK..and prolly fixed some exploiting :O
	mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='', dump3='', online=1 WHERE username='$S_user' LIMIT 1") or die("ert113");

$output.="";
if($work=='constructing'){
    if($type == 'clancompound')
    {
        if($totalRemaining > 0)
        {
            $output.="<b><font color=red>You do not not have enough resources to continue building the clan stockhouse. <br />You need $neededmuch $needed";
            if($needed2){
                $output.=" and $neededmuch2 $needed2";
            }
            $output.="</font></b>";
        }
    }
    else
    {
        $resultaat = mysqli_query($mysqli,  "SELECT username FROM buildings WHERE location='$S_location' && type='$typee' && username='$S_user' LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
        if($aantal>0){
            $output.="<br /><font color=red><B>You have a $typee at this location, you can only control one $typee per location.</b></font>";
        } elseif($status=='') {
            $output.="<b><font color=red>You do not have enough resources to build a $typee.<br />You need $neededmuch $needed";
            if($needed2){
                $output.=" and $neededmuch2 $needed2";
            }
            $output.="</font></b>";
        } else{
            $output.="$status";
        }
    }
} else {
	if($skillevent==1 && $SKILLEVENT_LEFT <= 0){
		$output.="<br /><b>The event has been completed!</b><br />";
	}
	if($spawnEvent){
		$output.="<br /><b>The $spawnType has been cleared!</b><br />";
	}
    else if($work == 'smithing' && $type == 'upgrade')
    {
        if($much > 0)
        {
            $output.="<br /><b>Select another item to upgrade with your $needed $alo</b> <a href='' onclick=\"locationText('smith', 'upgrade', '$upgradeID');return false;\">here</a>.";
        }
        else
        {
            $output.="<br /><b>You have no $needed $alo remaining for upgrades.</b>";
        }
    }
    else if($groupQuest)
    {
		$output.="<br/><b>The event has been completed!</b><br/>";
        # ADD SYSTEM CHAT MESSAGE
        $SystemMessage = 1;
        $BoldSystemMessage=1;
        $chatMessage = "$groupQuestCompleteText";
        $channel = 0;
        $systemOverride = 1;
        include(GAMEPATH . "scripts/chat/addchat.php");
    }
    else if($work<>'plant' && $work<>'pick'){
		$output.="<br /><b>You do not have enough resources left to continue.<br />";
		$output.="Check if you have all the 'ingredients' which you need.</b>";
	}
}


}## EINDE STOP WORK

} else if($check != 2){ # CHECKIE

	$output.="<h2>You can not work</h2><br />";
	mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='', dump3='', online=1 WHERE username='$S_user' AND work <> 'fight' LIMIT 1") or die("ert113");
	if($work=='mining'){
		$output.="Check if you are wearing a pickaxe to mine with.<br />";
		$output.="And check if you have the mining level which is needed to mine $type.";
	}elseif($work=='smithing'){
		$output.="Check if you are wearing a hammer!<br />";
	}elseif($work=='fishing'){
		$output.="Check if you've equiped the right tools (e.g. a Net or a Rod)<br />";
		if($S_location=='The singing river'){
			$output.="You can not fish with a rod at this location.<br />";
		}
	}elseif($work=='farming'){
		$output.="Check if you've got the required level for these seeds.<br />";
	}elseif($work=='cooking'){
		$output.="Check if you are wearing a tinderbox to cook with, and that you've got the required level to cook the specific item.<br />";
	}elseif($work=='constructing'){
		$output.="Check if you are wearing a hammer to construct with.<br />Or if you are preparing farmland, you will need a spade.<br />";
		if($type2=='stock'){
			$output.="Furthermore also check if you are not tryin to exceed the maximum number of requested items.<br />";
		}
	}elseif($work==''){
		$output.="You have not selected any work...<br />";
	} elseif($work=='train'){
		$output.="<br /><br /><br />You could not train any more pirates.<br/>";
	$output.="There are not enough resources left to train any pirates or you cannot train any more pirates because there are already 25% more pirates than requested.<br />";
	} elseif($work=='lockpicking'){
		$output.="<br /><br />$status<br /><B>You cannot lockpick.</B><br />";
		$output.="Check if you are wearing the required lockpicking tools, and check if you have anything left to lockpick.<br />";

	} elseif($work=='tutorial'){

	} else{
		$output.="1) Check if you have the required equipment.<br />";
		$output.="2) Check if you have the required level to use the equipment.<br />";
		$output.="3) Check if you have the required level to do mine/fish/smith this type of ore/fish/bar.<br />";
	}



}//checke

}else{
	$output.="There is an event at this location and therefore you cannot do your daily work.<br />";
	$output.="<a href='' onclick=\"locationText();return false;\">Click here to discover whats going on</a>";
}  ## INVASION


	$output.="</center>";
	$output=str_replace('"', '\"', $output);
	$output=str_replace('\\"', '\"', $output);

	echo"$('LocationContent').innerHTML=\"$output\";";
echo"if(disableImages){\$('workImage').remove();}";




} ## NO USER
?>