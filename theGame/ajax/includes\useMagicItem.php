<?
if(defined('AZtopGame35Heyam')){

$OK='';
include('levels.php');

if($magicl<5){
	echo"messagePopup(\"You need to be at least level 5 magic to use this item.\", \"Magic\");";
	exit();
}

$magical=$itemName;
  $sql = "SELECT much FROM items_inventory WHERE name='$magical' && username='$S_user' && type='magical'  LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $OK=1;  $much=$record->much; }
if($OK==1){
	if(stristr ($magical, "teleport orb") && $magicl>=5){

		$teleTo=str_replace (" teleport orb", "", "$magical");

		if($var2!='sure'){
			echo"messagePopup(\"Are you sure you want to use your $magical?<br /><a href='#' onclick=\\\"useItemNew('$itemID', 'sure');$('messagePopup').style.visibility='hidden';return false;\\\">Yes take me to $teleTo!</a><br />\", \"Teleport orb\");";
			exit();
		}


		mysqli_query($mysqli,"UPDATE users SET location='$teleTo', work='', dump='', dump2='', worktime='0' WHERE username='$S_user' LIMIT 1") or die("error --> 4a123");
		include_once('mapData.php');

		echo"removeItemFromContainer('playerInventory', '$magical', '1');";

		//copied from centerContent
		include_once('changeCenterLayout.php');
		echo changeLayout('-', '-');
		echo"$('locationTitle').innerHTML=\"$S_location\";";
		echo updatePlayers();
		include_once('locationText.php');
		//end copied from centerContent


	}
    else if((stristr ($magical, " summoning orb")) && $magicl>=5 && $S_mapNumber!=3 && $S_mapNumber!=8 && $S_mapNumber!=14){

        if($S_mapNumber==1 && ($magical != 'Rat summoning orb' &&
            $magical != 'Giant spider summoning orb' &&
            $magical != 'Gnome summoning orb' &&
            $magical != 'Young eagle summoning orb' &&
            $magical != 'Elder eagle summoning orb'))
        {
            echo"messagePopup(\"You cannot use " . strtolower($magical) . "s on remer.\", \"Magic\");";
            exit();
        }

		if($var2!='sure'){
			echo"messagePopup(\"Are you sure you want to use your $magical?<br /><a href='#' onclick=\\\"useItemNew('$itemID', 'sure');$('messagePopup').style.visibility='hidden';return false;\\\">Use my $magical!</a><br />\", \"Summoning orb\");";
			exit();
		}

		$monsterLimit=0;
		if($S_mapNumber==1){
			$monsterLimit=250;
			$amount=0;
			$sql = "SELECT sum(monstersmuch) as totMonst FROM locations JOIN locationinfo ON locations.location=locationinfo.locationName  WHERE  (locations.type='invasion' || locations.type='skillevent')  && locationinfo.mapNumber=$S_mapNumber";
		   	$resultaat = mysqli_query($mysqli,$sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
				$amount=$record->totMonst;
			}
			if($amount>=500){
				echo"messagePopup(\"You cannot use the summoning orb at this time, this island has too many events going already.\", \"Magic\");";
				exit();
			}
		}


		if($magical=='Rat summoning orb'){	$monster="Rat"; $monstermuch=rand(26,50);	}
		elseif($magical=='Giant spider summoning orb'){	$monster="Giant spider"; $monstermuch=50;	}
		elseif($magical=='Elder eagle summoning orb'){	$monster="Elder eagle"; $monstermuch=50;	}
		elseif($magical=='Gnome summoning orb'){	$monster="Gnome"; $monstermuch=50;	}
		elseif($magical=='Young eagle summoning orb'){	$monster="Young eagle"; $monstermuch=50;	}
		elseif($magical=='Gold scaled gaman summoning orb'){	$monster="Gold scaled gaman"; $monstermuch=10+$magicl;	}
		elseif($magical=='Bonebreaker summoning orb'){	$monster="Rorghark Bonebreaker"; $monstermuch=50+$magicl;	}
		elseif($magical=='Griffin summoning orb'){	$monster="Griffin"; $monstermuch=25+$magicl;	}
		else if($magical=='Christmas creature summoning orb')
        {
            $monster = rand(1,2) == 1 ? "Baby frost giant" : "Frost scaled gaman";
            $monstermuch=50+$magicl;
        }
		else if($magical=='Halloween creature summoning orb')
        {
            $monster = rand(1,2) == 1 ? "Possessed skeleton" : "Skeletal warrior";
            $monstermuch=50+$magicl;
        }


		if($monsterLimit>0 && $monstermuch>$monsterLimit){
			//Limit the max monsters for this invasion on this location
			$monsterLimit=$monstermuch;
		}

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE (monsters>0 OR rewarded=0) && location='$S_location'");
        $currentInvasion = mysqli_num_rows($resultaat);
        $currentGroupFight = 0;
        $currentGroupEvent = 0;

        if($currentInvasion == 0)
        {
            $resultaat = mysqli_query($mysqli, "SELECT ID FROM partyfight WHERE hp > 0 && location='$S_location'");
            $currentGroupFight = mysqli_num_rows($resultaat);

            if($currentGroupFight == 0)
            {
                $resultaat = mysqli_query($mysqli, "SELECT questID FROM groupquestslist WHERE (killed < kills OR gathered < gathermuch) && location='$S_location'");
                $currentGroupEvent = mysqli_num_rows($resultaat);
            }
        }

        if($monstermuch > 0)
        {
            if($currentInvasion == 0 && $currentGroupFight == 0 && $currentGroupEvent == 0)
            {
                $sql = "DELETE FROM locations WHERE location='$S_location'";
                mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
                $sql = "DELETE FROM invasions WHERE location='$S_location'";
                mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
                $saaql = "INSERT INTO locations (location, monsters, monstersmuch,   invasiontime, type, startTime)
                    VALUES ('$S_location', '$monster', '$monstermuch', '0', 'invasion', '$timee')";
                    mysqli_query($mysqli,$saaql) or die("EROR");

                echo"removeItemFromContainer('playerInventory', '$magical', '1');";

                ### ADD CHAT MESSAGE
                $SystemMessage=1;
                $BoldSystemMessage=1;
                $chatMessage="An evil mage summoned $monstermuch ".($monster)."s at $S_location.";
                $channel=1;
                include_once('../../currentRunningVersion.php');

                include(GAMEPATH."scripts/chat/addchat.php");
                ### EINDE CHAT MESSAGE


                //Show events text at current lcoation text
                echo"locationText();";

                echo"$('statsFameText').innerHTML=parseInt($('statsFameText').innerHTML)-5;";
                mysqli_query($mysqli,"UPDATE users SET fame=fame-5 WHERE username='$S_user' LIMIT 1") or die("error --> 1");
                # RAT SUMMON
            }
            else
            { #aantal=0
                echo"messagePopup(\"You cannot use the summoning orb at this time, due to other events at this location.\", \"Magic\");";

                //Dont remove orb
                exit();
            }
        }
        else if((stristr($magical, " group fight summoning orb")))
        {
            if($magical=='Christmas group fight summoning orb')
            {
                $monster = rand(1,2) == 1 ? "Abominable snowman" : "Frost giant";
            }
            else if($magical=='Halloween group fight summoning orb')
            {
                $monster = rand(1,2) == 1 ? "Canlo giant skeleton" : "Skeleton king";
            }

            if($currentInvasion == 0 && $currentGroupFight == 0)
            {
                $sql = "DELETE FROM partyfight WHERE location='$S_location'";
                mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
                $saaql = "INSERT INTO partyfight (location, monster, hp) VALUES ('$S_location', '$monster', (SELECT FLOOR(hp  * 1.1 + 3) FROM monsters WHERE name = '$monster'))";
                mysqli_query($mysqli,$saaql) or die("EROR");

                echo"removeItemFromContainer('playerInventory', '$magical', '1');";

                ### ADD CHAT MESSAGE
                $SystemMessage=1;
                $BoldSystemMessage=1;
                $chatMessage="An evil mage summoned a $monster at $S_location.";
                $channel=1;
                include_once('../../currentRunningVersion.php');

                include(GAMEPATH."scripts/chat/addchat.php");
                ### EINDE CHAT MESSAGE


                //Show events text at current lcoation text
                echo"locationText();";

                echo"$('statsFameText').innerHTML=parseInt($('statsFameText').innerHTML)-5;";
                mysqli_query($mysqli,"UPDATE users SET fame=fame-5 WHERE username='$S_user' LIMIT 1") or die("error --> 1");
                # RAT SUMMON
            }
            else
            { #aantal=0
                echo"messagePopup(\"You cannot use the summoning orb at this time, due to other events at this location.\", \"Magic\");";

                //Dont remove orb
                exit();
            }
        }
	} else{
			$spell=2;
	}

	if($spell!=2){
		if($much<=1){
		      $sql = "DELETE FROM items_inventory WHERE name='$magical' && username='$S_user' && type='magical'";
		      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
		} else{
			mysqli_query($mysqli,"UPDATE items_inventory SET much=much-1 WHERE name='$magical' && username='$S_user' LIMIT 1") or die("error --> 1");
		}
	}
}#OK
} # define
?>