<?php
# $fight should be checked, as any user can input $fight via _GET
#
#
$fight = htmlentities(trim(($fightWhat)));
$all = $fightAll;


require_once ('levels.php');

//TEMP!: Create session var to track group fight times
if(!$S_lastFightAllRound){
	$S_lastFightAllRound=time()-15;
	$_SESSION["S_lastFightAllRound"]= $S_lastFightAllRound;
}


function recordAbuse($username, $type){
	global $mysqli;
	$resultt = mysqli_query($mysqli, "SELECT username FROM bugreports WHERE username='$username' && type='$type' LIMIT 1");
    $aantl = mysqli_num_rows($resultt);
    if($aantl<1){
   		mysqli_query($mysqli, "INSERT INTO bugreports (username, type, text)VALUES ('$username', '$type', '$timee')") or die("error  ");
	} else{
      	mysqli_query($mysqli, "UPDATE bugreports SET time=time+1  WHERE  username='$username' && type='$type' LIMIT 1") or die("err1or --> AGF f");
    }
}

if (defined('AZtopGame35Heyam'))
{
    $invasion = 0;
    $oreblock = 0;
    $hpvoor = $hp;


    $timee = time();
    $rando = 0;

    $sql = "SELECT work, worktime, dump, location, online, botcheck FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        if ($record->work == 'jail' && $record->worktime > $timee)
        {
            exit();
        }

        $onlyforbotdump = $record->dump;
        if ($record->location == 'Lemo woods')
        {
            $fight = 'Lemo woods';
            $rando = 1;
        } elseif ($record->location == 'Deep Lemo woods')
        {
            $fight = 'Deep Lemo woods';
            $rando = 1;
        } elseif ($record->location == 'Exella plain')
        {
            $fight = 'Exella plain';
            $rando = 1;
        } elseif ($record->location == 'Exella mountain')
        {
            if ($fight <> 'Canlo giant')
            {
                $fight = 'Exella mountain';
                $rando = 1;
            }
        } elseif ($record->location == 'Berian')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Ogre outpost')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Ogre town')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Skulls nose')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Arch. cave NE')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Jungles edge' or $record->location == 'Thick jungle')
        {
            $fight = $S_location;
            $rando = 1;
        } elseif ($record->location == 'Arch. cave S')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Kaldra')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Mordor cave')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Sorer lair')
        {
            $fight = $record->location;
            $rando = 1;
        } elseif ($record->location == 'Beset catacombs')
        {
            if ($fight <> 'Sekhmet')
            {
            	$fight = $record->location;
            	$rando = 1;
            }
        }

        //Party island
        elseif ($record->location == 'Holiday lake' && (date("Y-m-d") == '2007-10-31' or date("Y-m-d") == '2007-10-30'))
        {
            $fight = 'Holiday lake';
            $rando = 1;
        } elseif ($record->location == 'Festival forest' && (date("Y-m-d") == '2007-10-31' or date("Y-m-d") == '2007-10-30'))
        {
            $fight = 'Festival forest';
            $rando = 1;
        } elseif ($record->location == 'Syrnia celebration center' && (date("Y-m-d") == '2007-10-31' or date("Y-m-d") == '2007-10-30'))
        {
            $fight = 'Syrnia celebration center';
            $rando = 1;
        }

        $workTop = $record->work;
        $worktimeTop = $record->worktime;

        if ($record->work == 'fight')
        {
            $fight = $record->worktime;
            $rando = 0;
        }
        $dump = $record->dump;
        if ($dump == 'group')
        {
            $group = 1;
        }
        if ($record->online < 1)
        {
            $S_user = '';
            $fight = '';
        }
        if ($record->work == 'stop')
        {
            $aap = 'ok';
            $work = 'stop';
            $worktime = $record->worktime;
        }
    }

    if ($fight == 'group' or $group == 1)
    {
        $dump = 'group';
    }

    $locationfight = $S_location;

    echo "if($('centerDropList')){Sortable.destroy('centerDropList');}";
    echo "if($('houseInventory')){Sortable.destroy('houseInventory');}";

    $output .= "<br /><br /><br /><br /><center><table cellpadding=0 cellspacing=0 width=95%>";
    $output .= "<tr><td width=13 height=13 background=layout/layout3_LB.jpg></td><td background=layout/layout3_B.jpg></td><td width=13 background=layout/layout3_RB.jpg></td></tr>";
    $output .= "<tr><td background=layout/layout3_L.jpg></td><td class=inhoud valign=top align=center>";
    $output .= "<table width=100%><tr><td width=10></td><td align=left valign=top id='LocationContent'><center>";


    $check = 0;
    $enemyhpdump = '';

    $sql = "SELECT dump, dump2, dump3, train, work FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $work = $record->work;

        if ($work != 'fight')
        {
            $dump2 = $dump3 = '';
        } else
        {
            $dump2 = $record->dump2;
            $dump3 = $record->dump3;
        }

        $enemyhpdump = $record->dump;
        $train = $record->train;

        if ($dump && $dump != 'group' && $work != 'stop')
        {
            $group = '';
        } elseif ($dump == 'group')
        {
            $group = 1;
            $dump = 'group';
        }
        if ($record->work <> 'fight')
        {
            $enemyhpdump = '';
            //if($randommonsterattack==1){ $work=''; $fight=''; $group=0;     }
        }
        if (strstr($record->dump2, "attacked you"))
        {
            $locationfight = "%";
            $randommonsterattack = 1;
        } //MOVE RANDOM ATTACK
    }

    if ($train != 'defence' && $train != 'attack' && $train != 'health' && $train != 'strength')
    {
        $train = 'health';
    }


    ### CHECK EN STATS
    if ($fight)
    {

        #### CROWDING CALC
        if ($group == 1)
        {
            $resultt = mysqli_query($mysqli, "SELECT username FROM users WHERE location='$S_location' && dump3>($timee-180) && worktime='$fight' && work='fight'");
            $aantl = mysqli_num_rows($resultt);
            $crowding = $crowdingEffect = $aantl - 1;
            if ($crowdingEffect < 0)
            {
                $crowding = $crowdingEffect = 0;
            }
            $dump3s = 30 + $crowdingEffect;

        } else
        {
            $resultt = mysqli_query($mysqli, "SELECT username FROM users WHERE location='$S_location' && dump3>($timee-120)  && work='fight' AND botcheck = 0");
            $aantl = mysqli_num_rows($resultt);
            $crowding = $aantl - 1;
            if ($crowding < 0)
            {
                $crowding = 0;
            }

            $crowdingEffect = $crowding;
            if ($crowding >= 15)
            {
                $crowdingEffect = 15;
            }
            $dump3s = 10 + $crowdingEffect;

            //TEMP!
            if($all==1 && $S_lastFightAllRound>(time()-9)){//For the 5 sec pauze
            	//This is the fix.. for now..
				$dump3s+=10;
            }

        }


        ### INVASION?
        $sql = "SELECT ID, monsters, type, monstersmuch, invasiontime, side, rewarded FROM locations WHERE location='$S_location' && startTime<'$timee' && (type='invasion' || type='oreblock') && monstersmuch>0 LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat))
        {
        	if($record->type=='invasion' || $record->type=='oreblock'){

                $invasiontime = $record->invasiontime;
	            if($invasiontime == 0 && $record->type=='invasion')
	            {
	                $invasion2late = 1;
	            }
	            $monstersmuch = $record->monstersmuch;
                $side = $record->side;
                $rewarded = $record->rewarded;

                if($record->type=='invasion')
                {
                    $resultaaat = mysqli_query($mysqli, "SELECT username FROM invasions WHERE username='$S_user' && location='$S_location' LIMIT 1");
                    $aantal = mysqli_num_rows($resultaaat);
                    if ($aantal == 0)
                    {
                        $saql = "INSERT INTO invasions (eventID, username, location)
                        VALUES ('$record->ID', '$S_user', '$S_location')";
                        mysqli_query($mysqli, $saql) or die("erroraa [tYhg] reportz this bug");
                    }
                }
                else
                {
                    $oreblock = true;
                }
	            $saql = "SELECT * FROM monsters WHERE name='$record->monsters' LIMIT 1";
	            $resultat = mysqli_query($mysqli, $saql);
	            while ($rec = mysqli_fetch_object($resultat))
	            {
	                $monsterID = $rec->ID;
	                $enemycombat = $rec->combat;
	                $monstername = $rec->name;
	                $enemyhpmax = floor($rec->hp * 1.1 + 3);
	                $enemystrengthl = $rec->str;
	                $enemyattackl = $rec->att;
	                $enemydefencel = $rec->def;
	                $exp = round($rec->combat * 1.68 + 2.91) + floor(pow(($enemycombat / 12), 2)) + $rec->exp;
					$groupCreature = $rec->exp > 0;
	                $droplist = $rec->droplist;
	                $check = 1;
	            }


	            if ($workTop == 'fight' && $worktimeTop != $monstername)
	            {
	                //Kill old monster first
	            } else
	            {
	                $invasion=1;
					if ($workTop != 'fight')
	                {
	                    $fight = $monstername;
	                    $resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username!='$S_user' &&  dump3>($timee-120) &&worktime='$fight' && work='fight' && online=1 && location='$S_location' LIMIT $monstersmuch");
	                    $activeFighters = mysqli_num_rows($resultaaat);
	                    $invasionmonstersAvailable = $monstersmuch - $activeFighters;
	                    if ($invasionmonstersAvailable <= 0)
	                    {
	                        $check = 0;
	                    }
	                }
	            }
            }else{
            	$invasion=2;
            }
        }
        ###

		if($invasion==2 && $worktimeTop != $fight){

			$check = 0;
			$output .= "<br/><br/>There is a skill event running at this location, you are unable to fight the monsters normally residing in this area.<br/>";
            $output .= "<br/>";
            $output .= "<a href='#' onclick=\"updateCenterContents('loadLayout', 1);\"><font color=white><b>Return to $S_location</b></font></a><br/><br/><br/>";

		}else if ($invasion == 1)
        { // "$workTop!='fight'" fix?
            if ($invasionFight != $monsterID && $worktimeTop != $fight)
            {
                $check = 0;
                if($oreblock)
                {
                    $output .= "<br/><br/>There is a group of " . $fight . "s (Level $enemycombat), you are unable to mine the ore here until they are gone.<br/>";
                }
                else
                {
                    $output .= "<br/><br/>There is an invasion of " . $fight . "s (Level $enemycombat), you are unable to fight the monsters normally residing in this area.<br/>";
                }

                if ($invasionmonstersAvailable >= 1)
                {
                    $output .= "<br/>";
                    $output .= "<a href='#' onclick=\"updateCenterContents('loadLayout', 1);\"><font color=white><b>Return to $S_location</b></font></a> or <a href='#' onclick=\"fighting('$fight', 0, '2', '$monsterID');\"><font color=white><b>Fight the " .
                        $fight . "s</b></font></a><br/><br/><br/>";
                } else
                {
                    $output .= "All " . $fight . "s are currently being fought, so you are unable to join the fight.<br/>";
                    $output .= "<br />";
                    $output .= "You should now wait until the $activeFighters fighters finish...<br />";
                    $output .= "<br /><br/><br/>";
                }
            } else
            {
                $invasionFight = $monsterID;
            }
            ##################
            ### GROUP FIGHT
        }
		elseif ($group == 1)
        {
            $sql = "SELECT monster, hp, text FROM partyfight WHERE location='$S_location' LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                $dump2 = str_replace("'", "\\'", $record->text);
                $fight = $record->monster;
                $enemyhpdump = $record->hp;

                $saql = "SELECT  ID, hp, str, att, def, exp, droplist, combat, questID,maxlv FROM monsters WHERE name='$fight' LIMIT 1";
                $resultaaat = mysqli_query($mysqli, $saql);
                while ($rec = mysqli_fetch_object($resultaaat))
                {
                    $monsterID = $rec->ID;
                    $enemycombat = $rec->combat;
                    $enemyhpmax = floor($rec->hp * 1.1 + 3);
                    $enemystrengthl = $rec->str;
                    $enemyattackl = $rec->att;
                    $enemydefencel = $rec->def;
                    $exp = round($rec->combat * 1.68 + 2.91) + floor(pow(($enemycombat / 12), 2)) + $rec->exp;
                    $droplist = $rec->droplist;
                    $check = 1;
                    if ($rec->questID)
                    {
                        $resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE username='$S_user' && killsleft>0 && questID='$rec->questID' LIMIT 1");
                        $aaantal = mysqli_num_rows($resultaaat);
                        if ($aaantal == 0)
                        {
                            $check = 0;
                        }
                    }
                }
                if ($record->maxlv <> 0 && $level > $record->maxlv or $monsterID == '' or $enemyhpdump == 0)
                {
                    $check = 0;
                }
            }
            ##############
            # VAST GESELECTEERD MONSTER
            ##############
        }
		elseif ($rando == 0)
        {
            $sql = "SELECT ID, hp, str, att, def, exp, droplist, combat, questID,maxlv FROM monsters WHERE name='$fight' && locations LIKE '%,$locationfight,%' LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                $monsterID = $record->ID;
                $enemycombat = $record->combat;
                $enemyhpmax = floor($record->hp * 1.1 + 3);
                $enemystrengthl = $record->str;
                $enemyattackl = $record->att;
                $enemydefencel = $record->def;
                $exp = round($record->combat * 1.68 + 2.91) + floor(pow(($enemycombat / 12), 2)) + $record->exp;
				//$groupCreature = $record->exp > 0;
                $droplist = $record->droplist;
                $check = 1;
                if ($record->maxlv <> 0 && $level > $record->maxlv)
                {
                    $check = 0;
                }
                if ($record->questID)
                {
                    $resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE username='$S_user' && killsleft>0 && questID='$record->questID' LIMIT 1");
                    $aaantal = mysqli_num_rows($resultaaat);
                    if ($aaantal == 0)
                    {
                        $check = 0;
                    }
                }


                if ($record->maxlv <> 0 && $level > $record->maxlv or $monsterID == '')
                {
                    $check = 0;
                }
            }
            ###############
            ### RANDOM MONSTER
            ###############
        } else
        {
            $sql = "SELECT ID, hp, str, att, def, exp, droplist, combat, questID,maxlv,name FROM monsters WHERE locations LIKE '%,$S_location,%' && questID='' ORDER BY RAND() LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                $monsterID = $record->ID;
                $enemycombat = $record->combat;
                $fight = $record->name;
                $enemyhpmax = floor($record->hp * 1.1 + 3);
                $enemystrengthl = $record->str;
                $enemyattackl = $record->att;
                $enemydefencel = $record->def;
                $exp = round($record->combat * 1.68 + 2.91) + floor(pow(($enemycombat / 12), 2)); #+$record->exp;
                $droplist = $record->droplist;
                $check = 1;
                if ($record->maxlv <> 0 && $level > $record->maxlv)
                {
                    $check = 0;
                }
            }
        }
        ### EINDE CHECKS EN STATS
        if ($enemyhpdump != '')
        {
            $enemyhp = $enemyhpdump;
        } else
        {
            $enemyhp = $enemyhpmax;
        }
    } #FIGHT!=''

	if($fight=='Sekhmet'){
		$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_wearing WHERE type != 'trophy' AND name='Torch' && username='$S_user' LIMIT 1");
		$torch = mysqli_num_rows($resultaat);
		if($torch!=1){
			$enemystrengthl*=3;
			$enemyattackl*=3;
			$enemydefencel*=3;
		}
	}
	else if(stristr($fight, "flame dragon"))
	{
		$youarmour = $_SESSION['S_armour'];
		$fullarmour = 0 ;
		if($fight == "Platina flame dragon")
		{
			$fullarmour = 123;
			$bonusMetal = "Platina";
		}
		else if($fight == "Syriet flame dragon")
		{
			$fullarmour = 165;
			$bonusMetal = "Syriet";
		}
		else if($fight == "Obsidian flame dragon")
		{
			$fullarmour = 223;
			$bonusMetal = "Obsidian";
		}

		$multiplier1 = ceil($fullarmour*0.8);
		$multiplier2 = ceil($fullarmour*0.65);
		$multiplier3 = ceil($fullarmour*0.5);
		$multiplier4 = ceil($fullarmour*0.3);

		$multiplier = 1;
		if($youarmour < $multiplier4)
		{
			$multiplier = 10;
		}
		else if($youarmour < $multiplier3)
		{
			$multiplier = 4;
		}
		else if($youarmour < $multiplier2)
		{
			$multiplier = 3;
		}
		else if($youarmour < $multiplier1)
		{
			$multiplier = 2;
		}

		$enemystrengthl*=$multiplier;
		$enemyattackl*=$multiplier;
		$enemydefencel*=$multiplier;

		//echo "messagePopup('Your armour: $youarmour - Full required armour: $fullarmour!', 'Armour');";
		//echo "messagePopup('*2 <$multiplier1, 3* <$multiplier2, 4* <$multiplier3, 10* <$multiplier4. Active multiplier: *$multiplier', 'Multiplier');";
	}


    if ($check == 1)
    {
        $fighttijdklopt = 0;
        if ($dump3 && $dump3 <= ($timee) && $work == 'fight')
        { ##TIMECHECK met correctie voor te snel/lag oid

            $fighttijdklopt = 1;
            ### ATTACK CODE
            $monster = 0;
            $youstrlevel = $strengthl;
            if ($monster == 0)
            {
                $youpower = $_SESSION['S_power'];
            } else
            {
                $youpower = $youstrlevel;
            }
            $youattackl = $attackl;
            if ($monster == 0)
            {
                $youaim = $_SESSION['S_aim'];
            } else
            {
                $youaim = $youattackl;
            }
            $hisdef = $enemydefencel;
            if ($monster == 0)
            {
                $hisarmour = $hisdef / 0.6;
            } else
            {
                $hisarmour = $S_armour;
            }

			if(stristr($fight, "flame dragon"))
			{
				if($fight == "Platina flame dragon")
				{
					$bonusMetal = "Platina";
					if($attackl >= 111)
					{
						$youaim += 35;
						$youpower += 40;
					}
					else if($attackl >= 96)
					{
						$youaim += 15;
						$youpower += 20;
					}
				}
				else if($fight == "Syriet flame dragon")
				{
					$bonusMetal = "Syriet";
					if($attackl >= 111)
					{
						$youaim += 20;
						$youpower += 20;
					}
				}
				/*else if($fight == "Obsidian flame dragon")
				{
					$bonusMetal = "Obsidian";
					$bonusMetal = false;
				}
				
				if($bonusMetal)
				{
					$sql = "SELECT ID, name, itemupgrade, upgrademuch, type FROM items_wearing" .
						" WHERE type='hand' && username='$S_user'" .
						" AND name LIKE '%$bonusMetal%'";
					$resultaat = mysqli_query($mysqli, $sql);
					$breakable = "";
					while ($record = mysqli_fetch_object($resultaat))
					{
						//echo "messagePopup('$record->name gets a bonus!', 'Weapon bonus');";
						$youpower = ceil($youpower * 1.5);
						$youaim = ceil($youpower * 1.5);
					}
				}*/
			}

            ## ECHTA CODE, VARS HIERBOVE
            $strengthdam = floor(($youstrlevel + $youpower) * 0.35) + 1; #max damage
            $user1MaxHit = $strengthdam;
            $attackdam = floor(($youattackl + $youaim) * 0.35) + 1; #damage attack level
            $attstrratio = ($attackdam / 2) / $strengthdam * 100; #(normally = 50%)
            if ($attstrratio > 100)
            {
                $attstrratio = 100;
            }
            $hitbelow = rand(0, $attstrratio);
            $hitup = rand($attstrratio, 100);
            $hitpercent = rand($hitbelow, $hitup);
            $hit = round($strengthdam * ($hitpercent / 100));
            $enemydefhit = ($hisdef + $hisarmour * 0.6) * 0.35;
            $enemyattdefratio = ($enemydefhit / 2) / $attackdam * 100;
            if ($enemyattdefratio > 100)
            {
                $enemyattdefratio = 100;
            }
            $blockbelow = rand(($enemyattdefratio / 10), $enemyattdefratio);
            $blockup = rand($enemyattdefratio, (100 - ($enemyattdefratio / 10)));
            $blockpercent = 100 - rand($blockbelow, $blockup);
            $damageuser1 = round($hit * ($blockpercent / 100));
            ### ATTACK CODE ## HP HIERONDER
            # aim : attack =1:1
            # power:str =1:1
            # defence:armour=1:1.66
            $enemyhp = $enemyhp - $damageuser1;
            if ($group == 1)
            {
                mysqli_query($mysqli, "UPDATE partyfight SET hp='$enemyhp' WHERE location='$S_location' && monster='$fight' LIMIT 1") or die("err1or --> 1fgg");
            }

            ## DESTROY ITEM
			if(stristr($fight, "flame dragon"))
			{
				if($fight == "Platina flame dragon")
				{
					$immuneMetal = "Platina";
				}
				else if($fight == "Syriet flame dragon")
				{
					$immuneMetal = "Syriet";
				}
				else if($fight == "Obsidian flame dragon")
				{
					$immuneMetal = "Obsidian";
				}
				$sql = "SELECT ID, name, itemupgrade, upgrademuch, type FROM items_wearing" .
					" WHERE type!='horse' && type!='trophy' && username='$S_user'" .
					" AND name NOT LIKE '%$immuneMetal%' AND name NOT LIKE '%Dragon%' ORDER BY rand() LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
				$breakable = "";
                while ($record = mysqli_fetch_object($resultaat))
                {
					echo "unwearItem('$record->type');";
                    mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this BREAK bug  f42");
					$breakable .= "$record->name, ";

					if($group <> 1)
					{
						$dump2 = "<tr><td><tr><td align=right><td align=center><font color=red>Your $record->name was destroyed while fighting. It was unrepairable and removed from your inventory.</font><Td align=right></td></tr>$dump2";
					}
					else
					{
						$dump2 = "<tr><td><tr><td align=right><td align=center><font color=red><B>$S_user</B>\\'s $record->name was destroyed while fighting.  It was unrepairable and removed from their inventory.</font><Td align=right></td></tr>$dump2";
					}
				}

				/*if($breakable)
				{
					echo "messagePopup('$breakable', 'Can break');";
				}*/
			}
            else if(rand(1, (3600 / $dump3s)) == 1)
            { #1 HOUR destroy checkup
                $sql = "SELECT ID, name, itemupgrade, upgrademuch,type FROM items_wearing WHERE type!='horse' && type!='trophy' && username='$S_user' ORDER BY rand() LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    if (stristr($record->name, 'Bronze'))
                    {
                        $uren = 5;
                    }
                    elseif (stristr($record->name, 'Iron'))
                    {
                        $uren = 6;
                    }
                    elseif (stristr($record->name, 'Steel'))
                    {
                        $uren = 8;
                    }
                    elseif (stristr($record->name, 'Silver'))
                    {
                        $uren = 7;
                    }
                    elseif (stristr($record->name, 'Ogre'))
                    {
                        $uren = 8;
                    }
                    elseif (stristr($record->name, 'Lizard'))
                    {
                        $uren = 8;
                    }
                    elseif (stristr($record->name, 'Bat-hide'))
                    {
                        $uren = 20;
                    }
                    elseif (stristr($record->name, 'Elven'))
                    {
                        $uren = 20;
                    }
                    elseif (stristr($record->name, 'Gold'))
                    {
                        $uren = 30;
                    }
                    elseif (stristr($record->name, 'Koban'))
                    {
                        $uren = 30;
                    }
                    elseif (stristr($record->name, 'Saurus') or stristr($record->name, 'Roodarus') or stristr($record->name, 'Waranerus'))
                    {
                        $uren = 50;
                    }
                    elseif (stristr($record->name, 'Platina'))
                    {
                        $uren = 50;
                    }
                    elseif (stristr($record->name, 'Syriet'))
                    {
                        $uren = 65;
                    }
                    elseif (stristr($record->name, 'Obsidian'))
                    {
                        $uren = 75;
					}
                    elseif (stristr($record->name, 'Puranium'))
                    {
                        $uren = 85;
					}
                    elseif (stristr($record->name, 'Dragon'))
                    {
                        $uren = 1000;
					}
                    elseif (stristr($record->name, 'Samnites') || stristr($record->name, 'Hoplomachi') || stristr($record->name, 'Retiarii') || stristr($record->name, 'Equites') )
                    {
                        $uren = 25;
                    }
                    elseif (stristr($record->name, 'Slamyeord') )
                    {
                        $uren = 35;
                    }
                    elseif ($record->name == 'Pirate cutlass' || $record->name == 'Pirate hook' || $record->name == 'Keelhail golden cutlass')
                    {
                        $uren = 50;
                    }
                    elseif (strpos($record->name, 'Bone ') == 0)
                    {
                        $uren = 30;
                    } else
                    {
                        $uren = 25;
                    }

                    if (rand(1, $uren) == 1)
                    { ##daadwerkelijke destroy

                        if ($record->itemupgrade == 'Durability' && $record->upgrademuch >= 1)
                        {
                            if ($group != 1)
                            {
                                $dump2 = "<tr><td><tr><td align=right><td align=center><font color=red>Your $record->name was damaged, the durabilty bonus was reduced by one.</font><Td align=right></td></tr>$dump2";
                            } else
                            {
                                $dump2 = "<tr><td><tr><td align=right><td align=center><font color=red><B>$S_user</B>\\'s $record->name was damaged. The durability bonus was reduced by one.</font><Td align=right></td></tr>$dump2";
                            }
                            if ($record->upgrademuch > 0)
                            {
                                echo "messagePopup('Your $record->name was damaged, the durabilty bonus was reduced by one.', 'Fighting');";

                                mysqli_query($mysqli, "UPDATE items_wearing SET upgrademuch=upgrademuch-1 WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this [BreK] bug");
                                //Rebuild wear stats
                                include_once ('wearstats.php');
                                wearStats($S_user, 1);
                            } else
                            {
                                mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this  BREAK bug2");
                                echo "unwearItem('$record->type');";
                                $all = 0;
                            }


                        } else
                        { #GEEN DURAB
                            echo "unwearItem('$record->type');";
                            mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$record->ID' && username='$S_user' LIMIT 1") or die("error report this BREAK bug  f42");

                            if ($group <> 1)
                            {
                                $dump2 = "<tr><td><tr><td align=right><td align=center><font color=red>Your $record->name was destroyed while fighting. It was unrepairable and removed from your inventory.</font><Td align=right></td></tr>$dump2";
                            } else
                            {
                                $dump2 = "<tr><td><tr><td align=right><td align=center><font color=red><B>$S_user</B>\\'s $record->name was destroyed while fighting.  It was unrepairable and removed from their inventory.</font><Td align=right></td></tr>$dump2";
                            }

                            $all = 0;
                        } ##
                    } ## DESTROY
                } #MYSQL

            } #DESTROY CHECK
            ### EIDNE DESTROY IYEM

            if ($enemyhp < 1)
            {
                $enemyhp = 0;
            } else
            {
                $strike = (floor(pow($crowding, 1 / 2)));

                if($stike > 3)
                {
                    $strike = 3;
                }

                ## ENEMY STRIKE
                if ($group == 1 && rand(0, $strike) == 0 or $group <> 1)
                {
                    ### ATTACK CODE
                    $monster = 1;
                    $youstrlevel = $enemystrengthl;
                    if ($monster == 0)
                    {
                        $youpower = $S_power;
                    } else
                    {
                        $youpower = $youstrlevel;
                    }
                    $youattackl = $enemyattackl;
                    if ($monster == 0)
                    {
                        $youaim = $S_aim;
                    } else
                    {
                        $youaim = $youattackl;
                    }
                    $hisdef = $defencel;
                    if ($monster == 0)
                    {
                        $hisarmour = $hisdef / 0.6;
                    } else
                    {
                        $hisarmour = $_SESSION['S_armour'];
                    }
                    ## ECHTA CODE, VARS HIERBOVE
                    $strengthdam = floor(($youstrlevel + $youpower) * 0.35) + 1; #max damage
                    $attackdam = floor(($youattackl + $youaim) * 0.35) + 1; #damage attack level
                    $attstrratio = ($attackdam / 2) / $strengthdam * 100; #(normally = 50%)
                    if ($attstrratio > 100)
                    {
                        $attstrratio = 100;
                    }
                    $hitbelow = rand(0, $attstrratio);
                    $hitup = rand($attstrratio, 100);
                    $hitpercent = rand($hitbelow, $hitup);
                    $hit = round($strengthdam * ($hitpercent / 100));
                    $enemydefhit = ($hisdef + $hisarmour * 0.6) * 0.35;
                    $enemyattdefratio = ($enemydefhit / 2) / $attackdam * 100;
                    if ($enemyattdefratio > 100)
                    {
                        $enemyattdefratio = 100;
                    }
                    $blockbelow = rand(($enemyattdefratio / 10), $enemyattdefratio);
                    $blockup = rand($enemyattdefratio, (100 - ($enemyattdefratio / 10)));
                    $blockpercent = 100 - rand($blockbelow, $blockup);
                    $damage_enemy = round($hit * ($blockpercent / 100));

                    ### ATTACK CODE ## HP HIERONDER
                    # aim : attack =1:1
                    # power:str =1:1
                    # defence:armour=1:1.66
                    $hp = $hp - $damage_enemy;
                    if ($hp <= 0)
                    {
                        $hp = 0;
                        echo "$('statsHPText').innerHTML='$maxhp';";
                    } else
                    {
                        echo "$('statsHPText').innerHTML='$hp';";
                    }
                } ## NO STRIKE


                if ($hp < 1)
                {
                    if ($fight == 'Captain Keelhail')
                    {
                        $workt = time() + 900;
                        mysqli_query($mysqli, "UPDATE users SET location='Skulls nose', side='Pirate', hp='$maxhp', work='jail', worktime='$workt', dump='', dump2='You have been kidnapped by pirates...you are preparing to escape the jail.', dump3='' WHERE username='$S_user' LIMIT 1") or
                            die("err1or --> 123s11a");
                        $hp = 0;
                        $output .= "<BR><B><CENTER>Nearly dead, you have been captured by the pirates!</b><BR>";
                        $S_side = 'Pirate';
                    } else
                    {
                        $hp = 0;
                        $droptime = time();
                        if ($S_side == 'Pirate')
                        {
                            $SPAWN = 'Crab nest';
                        } else
                        {
                            $SPAWN = 'Sanfew';
                        }
                        if ($S_user != 'M2H')
                        {
                            mysqli_query($mysqli, "DELETE FROM items_inventory  WHERE username='$S_user' && type='quest'") or die("err1or --> 1dfd1");
                            mysqli_query($mysqli, "DELETE FROM items_wearing  WHERE username='$S_user' && type='quest'") or die("err1or --> 1dfd1");

							$resulta23at = mysqli_query($mysqli, "SELECT ID, name, itemupgrade, upgrademuch,type FROM items_wearing WHERE username='$S_user'");
                            while ($rec0 = mysqli_fetch_object($resulta23at))
                            {
                                $itemType=$rec0->type;

								if($itemType=='trophy'){//Resolve REAL type
									$resultaat3 = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$rec0->name' LIMIT 1");
					    			while ($rec3 = mysqli_fetch_object($resultaat3))
									{
										$itemType=$rec3->type;
									}
								}
								$droppedItems .= " 1 $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
                                $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type,itemupgrade, upgrademuch)
						 VALUES ('1','$S_location', '$timee', '$S_user', '$rec0->name', '$itemType',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
                                mysqli_query($mysqli, $sql) or die("DIE");

                                $sql = "DELETE FROM items_wearing WHERE ID='$rec0->ID' LIMIT 1";
                            	mysqli_query($mysqli, $sql) or die("error report this bug please h63");
                            }

							//Magic protection orb
							$saveItems=0;
                            $resulta23at = mysqli_query($mysqli, "SELECT name,ID, upgrademuch,itemupgrade,upgrademuch FROM items_inventory WHERE username='$S_user' && itemupgrade='protection' ORDER BY upgrademuch DESC LIMIT 1");
                            while ($rec0 = mysqli_fetch_object($resulta23at))
                            {
                            	//	$output.="Got orb! $rec0->ID en $rec0->upgrademuch [UPDATE items_inventory SET much=much-1 WHERE ID='$rec0->ID' LIMIT 1]<br />\n";
                            	$saveItems=$rec0->upgrademuch;
                            	removeItem($S_user, $rec0->name, 1, $rec0->itemupgrade, $rec0->upgrademuch, 0);
                           	}
                           	//$output.="save $saveItems items<br />\n";

                            $resulta23at = mysqli_query($mysqli, "SELECT ID, much,name, itemupgrade, upgrademuch,type FROM items_inventory WHERE username='$S_user' ORDER BY RAND()");
                            while ($rec0 = mysqli_fetch_object($resulta23at))
                            {
                            	if($saveItems>0){
                            		$saveItems--;
								//	$output.="save $rec0->name item!<br />\n";
                            	}else{
                            		//$output.="dropped $rec0->name item!<br />\n";
	                                $droppedItems .= " $rec0->much $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
	                                $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type, itemupgrade, upgrademuch)
							 VALUES ('$rec0->much','$S_location', '$timee', '$S_user', '$rec0->name','$rec0->type',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
	                                mysqli_query($mysqli, $sql) or die("DIE");

	                            	$sql = "DELETE FROM items_inventory WHERE ID='$rec0->ID' LIMIT 1";
	                           		mysqli_query($mysqli, $sql) or die("error report this bug please h63");
                           		}
							}
                        }
                        mysqli_query($mysqli, "UPDATE users SET location='$SPAWN', hp=$maxhp,work='', worktime='', dump='', dump2='', dump3='' WHERE username='$S_user' LIMIT 1") or
                            die("err1or --> 123111");

                        $sql = "DELETE FROM quests WHERE username='$S_user' && completed=0";
                        mysqli_query($mysqli, $sql) or die("error report this bug please h63");

                        $tekst = "RAW_COMBAT_LOG(EXCLUDING LAST ROUND)=$dump2

                LAST_PLAYER_HIT=$damageuser1
                LAST_MONSTER_HIT=$damage_enemy
				DATE OF PLAYERS DEATH=".date("Y-m-d H:i", $dump3)."
				DIED_AT=$S_location
				SPAWNING AT LOCATION=$SPAWN
				ENEMYHPDUMP=$enemyhpdump
				TRAIN=$train
				DROPPED ITEMS:
				$droppedItems";
                        $sqal = "INSERT INTO zlogs (titel, tekst, time)
				         VALUES ('Fight death $S_user - $fight =$datum', '$tekst', '$timee')";
                        mysqli_query($mysqli, $sqal) or die("erroraa report this bug g32");
				
						$groupDeathLocation = $S_location;
                        $S_location = $SPAWN;
                    }
                }

            } #EINDE NEMY STRIKE
            if ($group == 1)
            {
                if ($damageuser1 > 0)
                {
                    $hittext = "<B>$S_user</B> struck and dealt $damageuser1 damage to the $fight.";
                } else
                {
                    $hittext = "<B>$S_user missed</B>";
                }
            } else
            {
                if ($damageuser1 > 0)
                {
                    if ($damageuser1>=2 && ($user1MaxHit * 0.80) <= $damageuser1)
                    {
                        $hittext = "<b>Critical hit:</b> You struck and dealt $damageuser1 damage to the $fight.";
                    } else
                    {
                        $hittext = "You struck and dealt $damageuser1 damage to the $fight.";
                    }
                } else
                {
                    $hittext = "You struck at the $fight, but missed!";
                }
            }

            $text = "<tr><td align=right><b>$damageuser1</b><td align=center>$hittext<Td align=right>$enemyhp/$enemyhpmax <img src=images/heart.gif></td></tr><tr height=10><td> </td></tr>$dump2";


            if($enemyhp == 0)
            { ### MONSTER DIED

				//TEMP!
				if($all==1){
					$S_lastFightAllRound=time();
				}

                if($_SESSION['S_quests'])
                { //Quest

                    $resultaat = mysqli_query($mysqli, "SELECT username FROM quests JOIN questslist ON questslist.questID=quests.questID  WHERE username='$S_user' && " .
                        "(questslist.location='$S_location' OR questslist.location LIKE 'Arch. cave 5%') && questslist.killtype='$fight' && completed=0 LIMIT 1");
                    $aantal = mysqli_num_rows($resultaat);
                    if ($aantal > 0)
                    {
                        include ('includes/locations/textincludes/quests.php');
                    }
                }

                if($invasion)
                { //Invasion atm
                    $exp = ceil($exp * 1.25);
                    if ($monstersmuch == 1)
                    {
                        mysqli_query($mysqli, "UPDATE users SET work='',  worktime='', dump='', dump3='' WHERE work='fighting' && location='$S_location'") or die("error --> 544343 s3");
                    }
                    mysqli_query($mysqli, "UPDATE locations SET monstersmuch=monstersmuch-1 WHERE location='$S_location' AND type IN ('invasion','oreblock') LIMIT 1") or die("err1or --> 1fgg");
                    if(!$oreblock)
                    {
                        mysqli_query($mysqli, "UPDATE invasions SET kills=kills+1 WHERE location='$S_location' && username='$S_user' LIMIT 1") or die("err1or --> 123111");
                    }
                    $monstersmuch -= 1;
                }

                if ($invasion2late == 1)
                { //Invasion multiplied
                    $exp = ceil($exp);
                    if (rand(1, 2) == 1)
                    {
                        $droplist = 0;
                    }
                }

                /*
                $levelsHigher=$level-$enemycombat;
                $levelsLower=$enemycombat-$level;
                if($levelsHigher>=5 && $exp>1){
                $penalty=$levelsHigher-5;
                if($penalty>=10){$penalty=10;}

                $exp=ceil($exp* (1-(0.1*$penalty)) );
                if($exp<1){ $exp=1;}
                }else if($levelsLower>=1){
                $bonus=$levelsLower;
                if($bonus>5){$bonus=5;}
                $exp=ceil($exp* (1+(0.05*$bonus)) );
                }
                */

                //Add exp
                $bonusArmour = "";
                $bonusWeapon = "";
                if($group == 1)
                {
                    $exp = bonusExp("combat", $exp);
                    $exp = $exp / ($crowding + 1);
                    $expeach = round($exp / 4);
                    mysqli_query($mysqli, "UPDATE users SET attack=attack+$expeach, defence=defence+$expeach, strength=strength+$expeach, health=health+$expeach WHERE work='fight' && worktime='$fight' && online=1 && dump3>($timee-120) && location='$S_location'") or
                        die("err1GROUPor --$fight][$hp,$enemyhp]");
                    $levelArray = addExp($levelArray, 'attack', $expeach);
                    $levelArray = addExp($levelArray, 'defence', $expeach);
                    $levelArray = addExp($levelArray, 'strength', $expeach);
                    $levelArray = addExp($levelArray, 'health', $expeach);
                }
                else
                {
                    $exp = bonusExp($train, $exp);
					if($groupCreature)
					{
						$expeach = round($exp / 4);
						mysqli_query($mysqli, "UPDATE users SET attack=attack+$expeach, defence=defence+$expeach, strength=strength+$expeach, health=health+$expeach WHERE username='$S_user'") or
							die("err1GROUPor --$fight][$hp,$enemyhp]");
						$levelArray = addExp($levelArray, 'attack', $expeach);
						$levelArray = addExp($levelArray, 'defence', $expeach);
						$levelArray = addExp($levelArray, 'strength', $expeach);
						$levelArray = addExp($levelArray, 'health', $expeach);
					}
					else
					{
						mysqli_query($mysqli, "UPDATE users SET $train=$train+$exp WHERE username='$S_user'") or die("error report [45x] -->  1sdf1]");
						$levelArray = addExp($levelArray, $train, $exp);
					}

                    $sql = "SELECT name, type,upgrademuch, itemupgrade FROM items_wearing WHERE username='$S_user' AND name LIKE 'Dragon %' AND type <> 'trophy' LIMIT 7";
                    $resultaat = mysqli_query($mysqli,$sql);
                    $dragonArmour = 0;
                    $dragonWeapon = "";
                    while ($record = mysqli_fetch_object($resultaat))
                    {
                        if($record->type=='hand')
                        {
                            $dragonWeapon = $record->name;
                        }
                        else
                        {
                            $dragonArmour++;
                        }
                    }

                    if($dragonArmour)
                    {
                        if($dragonArmour == 6)
                        {
                            $bonus = 0.1;
                        }
                        else
                        {
                            $bonus = 0.015*$dragonArmour;
                        }

                        $bonusExp = ceil($exp*$bonus);

                        mysqli_query($mysqli, "UPDATE users SET defence=defence+$bonusExp WHERE username='$S_user'") or die("error report [45x] -->  1sdf1]");
                        $levelArray = addExp($levelArray, "defence", $bonusExp);
                        $bonusArmour = "<b>You also gained <font color=red>$bonusExp</font> defence experience from your dragon armour!</b><BR>";
                    }
                }


                ### DROP LOOT
                ###########
                if ($droplist > 0)
                {
                    $drop = rand(0, 100000);

                    $questquery = '';
                    if ($_SESSION['S_quests'])
                    { //Create quest array to search items.. NASTY CODE, need new droplist code for quest stuff!
                        $quests = explode("][", $_SESSION['S_quests']);
                        $max = max(array_keys($quests));
                        $i = 0;
                        while ($i <= $max)
                        {
                            $questy = str_replace("[", '', $quests[$i]);
                            $questy = str_replace(']', '', $questy);
                            $questquery = "$questquery OR questdrop='$questy' ";

							$i++;
                        }
                    }

                    $sql = "SELECT items.name as name, dropmuch, items.type as type, itemupgrade as itemupgrade, upgrademuch,questdrop FROM droplists, items WHERE droplists.itemID=items.ID && dropchance>'$drop' && droplist='$monsterID' && (questdrop='' $questquery) ORDER BY dropchance asc LIMIT 1";
                   	$resultaat = mysqli_query($mysqli, $sql);
                    $lootwasquestitem = 0;
                    while ($record = mysqli_fetch_object($resultaat))
                    {
                        $dropnaam = $record->name;
                        if ($record->questdrop)
                        {
                            $lootwasquestitem = $dropnaam;
                        }
                        $dropmuch = $record->dropmuch;
                        $droptype = $record->type;
                        $dropupgrade = $record->itemupgrade;
                        $dropupgrademuch = $record->upgrademuch;
                    }

                    if ($dropnaam)
                    {
                        if ($dropnaam == 'Gold')
                        {
                            if ($group == 1)
                            {
                                //group drop?
                                $dropmuchget = round($dropmuch / ($crowding + 1));
                                $dopmuch = $dropmuchget * $crowding;
                                mysqli_query($mysqli, "UPDATE users SET gold=gold+$dropmuchget WHERE online=1 && dump3>($timee-120)  && worktime='$fight' && location='$S_location'") or
                                    die("err1or --> 11");
                                $droptekst = "The $fight dropped <font color=yellow>$dropmuch Gold</font>!<BR> All warriors got " . $dropmuchget . " gold.";
                            } else
                            {
                                getGold($S_user, $dropmuch);
                                $droptekst = "The $fight dropped <font color=yellow>$dropmuch Gold</font>!<BR>";
                            }
                        } else
                        { #item drop
                            if ($group == 1)
                            {
                                $droptekst = "$S_user got <font color=yellow>$dropmuch $dropnaam</font>!<BR>";
                            } else
                            {
                                $droptekst = "You got <font color=yellow>$dropmuch $dropnaam</font>!<BR>";
                            }

                            $saql = "SELECT type FROM items WHERE name='$dropnaam' LIMIT 1";
                            $resultat = mysqli_query($mysqli, $saql);
                            while ($rec = mysqli_fetch_object($resultat))
                            {
                                $itemType = $record->type;
                            }
                            addItem($S_user, $dropnaam, $dropmuch, $droptype, '', '', 1);


                        } # geen gold drop maar item drop
                    }
                }
                ## END DROP  LOOT

                mysqli_query($mysqli, "UPDATE stats SET monsterkills=monsterkills+1 WHERE username='$S_user' LIMIT 1") or die("err2o22 time   ");
                if ($group == 1)
                {
                    $text = "<tr><td><Td align=center><B>The $fight died. All warriors got <font color=red>$expeach</font> experience in attack, defence, strength and health.</b><BR>$droptekst  $text";
                }
				else
                {
                    //require_once('includes/levels.php'); //All exp/levels are loaded.
                    $nextlevel = ucwords($train) . " level: ".$levelArray[$train]['level']." (".$levelArray[$train]['exp']." exp, ".$levelArray[$train]['nextLevel']." for next level)<br />";
                    if($bonusArmour && $train != "defence")
                    {
                        $bonusArmour .= ucwords("defence") . " level: ".$levelArray["defence"]['level']." (".$levelArray["defence"]['exp']." exp, ".$levelArray["defence"]['nextLevel']." for next level)<br />";
                    }
                    else if($bonusArmour && $train == "defence")
                    {
                        $bonusArmour .= $nextlevel;
                        $nextlevel = "";
                    }
					
					if($groupCreature)
					{
						$text = "<tr><td><Td align=center><B>The $fight died. You got <font color=red>$expeach</font> experience in attack, defence, strength and health.</b><BR>$bonusArmour $droptekst $nextlevel <br/> $text";
					}
					else
					{
						$text = "<tr><td><Td align=center><B>The $fight died. You got <font color=red>$exp</font> $train experience.</b><BR>$bonusArmour $droptekst $nextlevel <br/> $text";
					}
                }
                ### EINDE MONSTER DIED
            } else
            {
                if ($damage_enemy > 0)
                {
                    $hittext = "did $damage_enemy damage.";
                } else
                {
                    $hittext = "missed!";
                }
                if ($group == 1 && $damage_enemy > 0)
                {
                    $text = "<tr><td align=right>$hp/$maxhp <img src=images/heart.gif><Td align=center>The $fight struck at <B>$S_user</B> and $hittext<td align=right><b>$damage_enemy</b> $text";
                } elseif ($group <> 1)
                {
                    $text = "<tr><td align=right>$hp/$maxhp <img src=images/heart.gif><Td align=center>The $fight struck at you and $hittext<td align=right><b>$damage_enemy</b>  $text";
                }
            }

            if($invasion && !$oreblock)
            {
                if($monstersmuch>0 && $invasiontime>$timee){
                    ##### INVASION IS NU EN NOG ONBESLIST
                    //Do nothing here

                }elseif($invasiontime<>0 && $invasiontime<=$timee && $monstersmuch>0){
                    ### INVASION WORD NU GEUPDATE; GEWONNEN DOOR DE MONSTERS

                    mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                        VALUES ('Hazgod', '<B>Syrnia</B>', 'invasion time: $invasiontime<br/>time: $timee<br/>$monstername: $monstersmuch', '$timee', '$S_location Capture')") or die("DIE");

                    mysqli_query($mysqli,"UPDATE locations SET rewarded=2 WHERE location='$S_location' AND rewarded = 0 LIMIT 1") or die("1331LOC3312");

                    if(mysqli_affected_rows($mysqli) == 1)
                    {
                        mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic, status)
                            VALUES ('Hazgod', '<B>Syrnia</B>', 'multiply $monstername', '$timee', '$S_location Multiply', 127)") or die("DIE");

                        $rewarded = 2;
                        $mmuch=$monstersmuch*rand(6,20);
                        mysqli_query($mysqli,"UPDATE locations SET monstersmuch=$mmuch, invasiontime=0 WHERE location='$S_location' LIMIT 1") or die("error --> 544343");

                        ## MOETEN DE PIRATES REWAREDED?
                        if($side=='Pirate'){
                            $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && rewarded=0 LIMIT 1");
                            $aantalOver=0;     $aantalOver = mysqli_num_rows($resultaat);

                            //Is this the last pirate fight ? Then remove the sidescore, which is used for rewarding pirates
                            if($aantalOver==0){
                                $resultaat = mysqli_query($mysqli, "SELECT totalinvasions, failed FROM sides WHERE location='Skulls nose' LIMIT 1");
                                $recrd = mysqli_fetch_object($resultaat);
                                $total = $recrd->totalinvasions;
                                $failed = $recrd->failed;
                                $success = $total - $failed;

                                if($success > $failed)
                                {
                                    $endMessage = "The invasion is over. We successfully captured $success of the $total towns we invaded. This was a great victory!";
                                }
                                else
                                {
                                    $sAEql = "SELECT leader FROM sides WHERE location='Skulls nose' && leader<>''  limit 1";
                                    $resultAEt = mysqli_query($mysqli,$sAEql);
                                    while ($recQ = mysqli_fetch_object($resultAEt)) {
                                        mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                                        VALUES ('$recQ->leader', '<B>Syrnia</B>', 'Arrr matey...<br />Your pirates committed mutiny because a fight was lost....<BR>
                                        You are not the pirate leader anymore.<BR>', '$timee', 'Pirate mutiny')") or die("DIE");
                                        mysqli_query($mysqli,"UPDATE sides SET kicklimit='-1' WHERE location='Skulls nose' LIMIT 1") or die("54353535");

                                        $endMessage = "The invasion is over. We failed to capture $failed of the $total towns we invaded. This was a terrible defeat for $recQ->leader!";
                                    }
                                }
                            }

                            mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic, status)
                                VALUES ('Hazgod', '<B>Syrnia</B>', 'Send capture message $monstername', '$timee', '$S_location Capture messages', 127)") or die("DIE");

                            $seEql = "SELECT username FROM users WHERE side='Pirate'";
                            $resulteEt = mysqli_query($mysqli,$seEql);
                            while ($p = mysqli_fetch_object($resulteEt))
                            {
                                $sEql = "SELECT username, sidescore FROM stats WHERE username='$p->username' LIMIT 1";
                                $resultEt = mysqli_query($mysqli,$sEql);
                                while ($rece = mysqli_fetch_object($resultEt))
                                {

                                    $gold=floor(($rece->sidescore/3)*rand(6,14)/10);
                                    $fame=floor(((($rece->sidescore/3)/10)*rand(8,12)/10)/2);

                                    if($rece->sidescore>0){
                                        $pirateMessage="Arrr matey...<BR>Here is your share of our loot at $S_location:<BR>+$gold gold.<BR><BR>For helping the pirates you got -$fame fame.<BR>";
                                    }else{
                                        $pirateMessage="Arrr matey...<br />We have successfully invaded $S_location, however, because you did not contribute to the invasion you receive no gold and fame.<br />";
                                    }
                                    if($aantalOver==0){
                                        $pirateMessage.="This invasion was the last invasion we have running at the moment.<br /><br/>$endMessage";
                                    }
                                    mysqli_query($mysqli,"UPDATE users SET gold=gold+'$gold',  fame=fame-'$fame' WHERE username='$rece->username' LIMIT 1") or die("error --> 544343 111");
                                    $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                                    VALUES ('$rece->username', '<B>Syrnia</B>', '$pirateMessage', '$timee', 'Pirate attack - $S_location')";
                                    mysqli_query($mysqli,$sql) or die("DIE");
                                }
                            }

                            if($aantalOver==0){
                                mysqli_query($mysqli,"UPDATE stats SET sidescore=0") or die("1331322312");
                            }
                        }#########

                    }

                }elseif($monstersmuch>0 && $invasiontime==0){
                    #### INVASIONS WAS GELUKT VOOR DE VIJAND, KILL ZE , niks speciaals
                    //Do nothing here

                } else{
                        #### INVASIONS IS ALLANG OVER

                    //Moet nog rewarden
                    if($rewarded==0)
                    {
                        mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                            VALUES ('Hazgod', '<B>Syrnia</B>', 'Failed<br/>$monstername: $monstersmuch', '$timee', '$S_location Failed')") or die("DIE");

                        mysqli_query($mysqli,"UPDATE locations SET rewarded=1 WHERE location='$S_location' AND rewarded=0 LIMIT 1") or die("54353535");
                        if(mysqli_affected_rows($mysqli) == 1)
                        {
                            mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic, status)
                                VALUES ('Hazgod', '<B>Syrnia</B>', 'failed rewarded set $monstername', '$timee', '$S_location Failed rewarded', 127)") or die("DIE");

                            $rank='1'; $limin=3; if($side=='Pirate'){ $limin=500;}
                            #### HUMANS KILDE INVASION OP TIJD! MOET DE HIGHSCORE NOG GEMAAKT?
                            $saql = "SELECT username, kills, location FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $limin";
                            $resultat = mysqli_query($mysqli,$saql);
                            while ($recrd = mysqli_fetch_object($resultat))
                            {
                                $fameplus='';
                                if($side=='Pirate')
                                {
                                    $goldreward=ceil(($recrd->kills*2)*rand(7,13)/10);  $fameplus=ceil(($recrd->kills/2)*rand(8,12)/10);  $mestext="The citizens of $recrd->location wanted to thank you for your efforts in freeing the city from the ".$monstername."s. You got $goldreward gold bounty for your kills.<BR>You also got +$fameplus fame for fighting the pirates.";   $XTR2=", fame=fame+$fameplus";
                                }else{
                                    $goldreward=round(($recrd->kills*5)/$rank); $XTR='';  $XTR2='';  $mestext="The citizens of $recrd->location wanted to thank you for your efforts in freeing the city from the ".$monstername."s. You got $goldreward gold bounty for your kills.<BR>";
                                }
                                $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                                VALUES ('$recrd->username', '<B>Syrnia</B>', '$mestext', '$timee', 'Saving $S_location')";
                                $rank=$rank+1;
                                mysqli_query($mysqli,$sql) or die("DIE");
                                mysqli_query($mysqli,"UPDATE users SET gold=gold+$goldreward $XTR2 WHERE username='$recrd->username' LIMIT 1") or die("error --> 5442343");
                            }

                            #### PIRATES
                            if($side=='Pirate')
                            {
                                $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && rewarded=0 LIMIT 1");
                                $aantalOver=0;     $aantalOver = mysqli_num_rows($resultaat);

                                mysqli_query($mysqli,"UPDATE sides SET failed=failed+1 WHERE location='Skulls nose'") or die("1331322312");

                                //Is this the last pirate fight ? Then remove the sidescore, which is used for rewarding pirates
                                if($aantalOver==0)
                                {
                                    mysqli_query($mysqli,"UPDATE stats SET sidescore=0") or die("1331322312");

                                    $resultaat = mysqli_query($mysqli, "SELECT totalinvasions, failed FROM sides WHERE location='Skulls nose' LIMIT 1");
                                    $recrd = mysqli_fetch_object($resultaat);
                                    $total = $recrd->totalinvasions;
                                    $failed = $recrd->failed;
                                    $success = $total - $failed;

                                    if($success > $failed)
                                    {
                                        $endMessage = "The invasion is over. We successfully captured $success of the $total towns we invaded. This was a great victory!";
                                    }
                                    else
                                    {
                                        $sAEql = "SELECT leader FROM sides WHERE location='Skulls nose' && leader<>''  limit 1";
                                        $resultAEt = mysqli_query($mysqli,$sAEql);
                                        while ($recQ = mysqli_fetch_object($resultAEt)) {
                                            mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                                            VALUES ('$recQ->leader', '<B>Syrnia</B>', 'Arrr matey...<br />Your pirates committed mutiny because a fight was lost....<BR>
                                            You are not the pirate leader anymore.<BR>', '$timee', 'Pirate mutiny')") or die("DIE");
                                            mysqli_query($mysqli,"UPDATE sides SET kicklimit='-1' WHERE location='Skulls nose' LIMIT 1") or die("54353535");

                                            $endMessage = "The invasion is over. We failed to capture $failed of the $total towns we invaded. This was a terrible defeat for $recQ->leader!";
                                        }
                                    }
                                }

                                mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic, status)
                                    VALUES ('Hazgod', '<B>Syrnia</B>', 'Send failed message $monstername', '$timee', '$S_location Fail message', 127)") or die("DIE");

                                $resulteEt = mysqli_query($mysqli,"SELECT username FROM users WHERE side='Pirate'");
                                while ($p = mysqli_fetch_object($resulteEt))
                                {
                                    $resultEt = mysqli_query($mysqli,"SELECT username, sidescore FROM stats WHERE username='$p->username' LIMIT 1");
                                    while ($rece = mysqli_fetch_object($resultEt))
                                    {
                                        $pirateMessage="Arrr matey...<br />We have failed to invade $S_location...<br />";

                                        if($aantalOver==0){
                                            $pirateMessage.="This invasion was the last invasion we have running at the moment.<br /><br/>$endMessage";
                                        }else{
                                            $pirateMessage.="We still have one or more invasions running right now!<br />";
                                        }
                                        $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                                        VALUES ('$rece->username', '<B>Syrnia</B>', '$pirateMessage', '$timee', 'Pirate attack - $S_location')";
                                        mysqli_query($mysqli,$sql) or die("DIE");
                                    }
                                }

                            } ## PIRATE
                        }
                    }
                }
            }

            if ($hp == 0)
            {
                mysqli_query($mysqli, "UPDATE stats SET monsterdeaths=monsterdeaths+1 WHERE username='$S_user' LIMIT 1") or die("err2o22 mon   ");
                $text = "<tr><td><Td><B><center>$S_user has died.</b> $text";
                if ($group == 1)
                {
                    mysqli_query($mysqli, "UPDATE partyfight SET text='$text' WHERE monster='$fight' && location='$groupDeathLocation' LIMIT 1") or die("err1or --> PF ! a");
                }
                include ('mapData.php');
                include_once ('rebuildInventory.php');
                //echo"updateCenterContents('loadLayout', 1);";
                include_once ('includes/wearstats.php');
                wearStats($S_user, 1);
                echo "if(\$('lastMovedItem')){\$('lastMovedItem').remove();}";
            }

        } else
        {
            $text = $dump2;
        } ##TIMECHECK

        $perchp = floor(($hp / $maxhp) * 100);
        if ($perchp >= 100)
        {
            $perchp = 100;
        }
        $redperchp = 100 - $perchp;

        if ($fight == 'Bug' or $fight == 'Big bad bug' or $fight == 'Halloween gnome')
        {
            $output .= "<table border=1 cellpadding=10 cellspacing=1><tr><td bgcolor=black><img src='images/enemies/$fight.jpg'></td></tr></table><BR>";
        }
        #$output.="<img src='images/enemies/$fight.jpg'><BR>";
        if ($lootwasquestitem)
        {
            include ('includes/locations/textincludes/quests.php');
        }

        if ($group == 1)
        {
            $output .= "<B>You and $crowding player" . ($crowding == 1 ? "" : "s") . " are attacking a $fight ($enemycombat) at $S_location.</b>";
        } else
        {
            $output .= "<B>You are attacking " . (aOrAn($fight) ? "an" : "a") . " $fight ($enemycombat) at $S_location.</b><BR>";
            $output .= "There " . ($crowding == 1 ? "is 1 person" : "are $crowding people") . " fighting here.<br />";
        }

        $tr1 = '';
        $tr2 = '';
        $tr3 = '';
        $tr4 = '';
        if ($train == 'health')
        {
            $tr1 = selected;
        } elseif ($train == 'strength')
        {
            $tr2 = selected;
        } elseif ($train == 'attack')
        {
            $tr3 = selected;
        } elseif ($train == 'defence')
        {
            $tr4 = selected;
        }

        $output .= "<BR>";


        $output .= "<table><tr><td width=90 align=left>";

        $output .= "<form><table cellpadding=0 cellspacing=0><tr><td><small>Train:</small></td></tr>";
        $output .= "<tr><td align=center><select id=fightTrainingSel class=input onchange=\"updateCenterContentsExtended('setOption', 'fightTrain', $('fightTrainingSel').value);return false;\">";
        $output .= "<option value='health' $tr1>Health<option value='strength' $tr2>Strength<option value='attack' $tr3>Attack<option value='defence' $tr4>Defence";
        $output .= "</select></table></form>";


        $output .= "</td><td width=100 align=center>";

        $output .= "<table cellpadding=0 cellspacing=0 width=100><tr><td bgcolor=red width=100><img width=$perchp height=5 src='images/greenpixel.gif' id='fightHPbar' /></td></tr></table>";
        $output .= "<font id=\"fightingHPText\">$hp</font>/<font id=\"fightingMaxHPText\">$maxhp</font> <img src=images/heart.gif>";
        $output .= "</td><td width=90> ";

        $output .= "</td></tr></table>";

        $output .= "<br />";

        $output .= "<table cellpadding=0 cellspacing=0><tr align=left valign=top><td>";
        $output .= "<div id=\"fightingFoodTop\" style=\"margin-left: auto; margin-right:auto;\">";
        $fooddump = "<div id=\"fightingFoodBottom\" style=\"margin-left: auto; margin-right:auto;\">";
        $sql = "SELECT II.ID, II.name, II.much, II.type FROM items_inventory II
        LEFT JOIN items I ON I.name = II.name
        WHERE II.username='$S_user' && (II.type='cooked food' OR I.type='cooked fish') ORDER BY I.rank ASC, I.name ASC";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat))
        {
            if ($group == '')
            {
                $group = 2;
            }

            $fooddump .= "<div style=\"float:left; width:45; height:45; border: 1px solid grey; background: url('images/inventory/$record->name.gif')\" title=\"$record->name\" id=\"fightFoodBottom$record->ID\" onclick=\"useItemNew('$record->ID', 'F');return false;\"><font color=white>$record->much</font></div>";
            $output .= "<div style=\"float:left; width:45; height:45; border: 1px solid grey; background: url('images/inventory/$record->name.gif')\" title=\"$record->name\" id=\"fightFoodTop$record->ID\" onclick=\"useItemNew('$record->ID', 'F');return false;\"><font color=white>$record->much</font></div>";
        }
        $fooddump .= "</div>";
        $output .= "</div></td></tr></table>";

        $newdump3 = $dump3;
        if ($dump3 <= $timee)
        {
            if ($group == 1)
            {
                $newdump3 = time() + 30 + $crowdingEffect;
            } else
            {
                $newdump3 = time() + 10 + $crowdingEffect;
            }
        }

        if ($dump3 && $dump3 > $timee)
        {
            $dump3s = $dump3 - time();
        }
        if ($enemyhp > 0 && $hp > 0 or $all == 1 && $hp > 0 && $enemyhp < 1)
        {
        	if($all == 1 && $hp > 0 && $enemyhp < 1){
        		if($dump3s>10){$dump3s=10;}
        	}
            echo "JSdump1='fighting';JSdump2='$all';";
            echo "setTimeout(\"fightingCounter('fightCounter', (new Date().getTime()+($dump3s)*1000), '$fight', '$all', '$group','$invasionFight', '$timee');\", 500);";
            $output .= "<input type=\"text\" size=\"3\" readonly value=\"" . ($dump3s) . "\" title=\"$timee\" id=\"fightCounter\" title=0 class=counter><br />";
		}

        //BEGIN display links
        if ($randommonsterattack == 1)
        {
        	if($enemyhp == 0){
            	$output .= "<a href='#' onclick=\"window.scrollTo(0,0);updateCenterContents('loadLayout', 1);return false;\"><font color=white>Return to $S_location</font></a>";
            }
        } else
        { #RAND MONSTER ONCE A WHILE ATTACK
            if ($enemyhp < 1 or $hp < 1)
            {
                if ($group == 1 && $hp > 0)
                {
                    $output .= "<a href='#' onclick=\"window.scrollTo(0,0);updateCenterContents('loadLayout', 1);return false;\"><font color=white>Return to $S_location</a><br />";
                } elseif ($all == 0 && $hp > 0)
                {
					$output .= "<a href='#' onclick=\"window.scrollTo(0,0);fighting('$fight', 0, '$group', '$invasionFight');return false;\"><font color=white>Fight 1 more creature</a> - <a href='#' onclick=\"window.scrollTo(0,0);fighting('$fight', 1, '$group', '$invasionFight');return false;\"><font color=white>Fight all creatures</a> - <a href='#' onclick=\"window.scrollTo(0,0);updateCenterContents('loadLayout', 1);return false;\"><font color=white>Return to $S_location</a><br />";
                } elseif ($all == 1 && $hp > 0)
                {
                    $output .= "<a href='#' onclick=\"window.scrollTo(0,0);fighting('$fight', 0, '$group', '$invasionFight');return false;\"><font color=white>Fight 1 more creature</a> - [<font color=white>Fight all creatures] - <a href='#' onclick=\"window.scrollTo(0,0);updateCenterContents('loadLayout', 1);return false;\"><font color=white>Return to $S_location</a><br />";
                }
                if ($hp == 0)
                {
                    $output .= "<a href='#' onclick=\"window.scrollTo(0,0);updateCenterContents('loadLayout', 1);return false;\"><font color=white>Click here to continue.</a>";
                }
            } else
            {
                if ($group == 1)
                {
                    //$output .= "";
				}else if ($all == 1){
                    $output .= "<a href='#' onclick=\"fighting('$fight', 0, '$group', '$invasionFight');return false;\"><font color=white>Stop fighting after this creature</font></a><br />";
                }else{
                	$output .= "<a href='#' onclick=\"fighting('$fight', 1, '$group', '$invasionFight');return false;\"><font color=white>Fight all creatures</a><br />";
                }
            }
            if ($invasion)
            {
                $output .= "<BR>There " . ($monstersmuch == 1 ? "is" : "are") . " $monstersmuch " . $fight . ($monstersmuch == 1 ? "" : "s") . " left.<BR>";
            }
            $output .= "<br />";
        } #RAND MONSTER ONCE A WHILE ATTACK
        //END display links


        $output .= "<table><tr id='fightLogTop'><td><b>$S_user</b></td><td> </td><td><b>$fight</b></td></tr>";
        $output .= "$text ";
        $output .= "<tr><td><b>$S_user</b></td><td> </td><td><b>$fight</b></td></tr>";
        $output .= "</table><BR>";

        if ($group == 1)
        {
            $output .= "<B>You and $crowding players are attacking a $fight ($enemycombat) at $S_location.</b>";
        } else
        {
            $output .= "<B>You are attacking a $fight ($enemycombat) at $S_location.</b>";
        }
        $output .= "<BR><BR>";


        if ($group == 1 && $fighttijdklopt == 1)
        {
            mysqli_query($mysqli, "UPDATE partyfight SET text='$text', hp='$enemyhp' WHERE monster='$fight' && location='$S_location' LIMIT 1") or die("err1or --> AGF f");
        }

        if ($hp > 0 && $enemyhp > 0)
        {
            if ($group == 1)
            {
                mysqli_query($mysqli, "UPDATE users SET work='fight' , worktime='$fight', dump='$dump', dump2='', hp=$hp, dump3='$newdump3' WHERE username='$S_user' LIMIT 1") or
                    die("err1or --> GF 1 v");
            } else
            {
                mysqli_query($mysqli, "UPDATE users SET work='fight' , worktime='$fight', dump='$enemyhp', dump2='$text', hp='$hp', dump3='$newdump3' WHERE username='$S_user' LIMIT 1") or
                    die("err1or -->GEENG h");
            }
        }


        if ($enemyhp < 1 or $hp < 1)
        {
            mysqli_query($mysqli, "UPDATE users SET work='', dump='', dump2='', dump3='', worktime='' WHERE username='$S_user' LIMIT 1") or die("err1or --> sss11");
        }


        //BEGIN display links
        if ($randommonsterattack == 1 )
        {
        	if( $enemyhp == 0){
            	$output .= "<a href='#' onclick=\"updateCenterContents('loadLayout', 1);window.scrollTo(0,0);return false;\"><font color=white>Return to $S_location</font></a>";
            }
        } else
        { #RAND MONSTER ONCE A WHILE ATTACK
            if ($enemyhp < 1 or $hp < 1)
            {
                if ($group == 1)
                {
                    $output .= "<a href='#' onclick=\"updateCenterContents('loadLayout', 1);window.scrollTo(0,0);return false;\"><font color=white>Return to $S_location</font></a><br />";
                } elseif ($all == 0 && $hp > 0)
                {
                    $output .= "<a href='#' onclick=\"fighting('$fight', 0, '$group', '$invasionFight');window.scrollTo(0,0);return false;\"><font color=white>Fight 1 more creature</font></a> - <a href='#' onclick=\"fighting('$fight', 1, '$group', '$invasionFight');window.scrollTo(0,0);return false;\"><font color=white>Fight all creatures</font></a> - <a href='#' onclick=\"updateCenterContents('loadLayout', 1);window.scrollTo(0,0);return false;\"><font color=white>Return to $S_location</font></a><br />";
                } elseif ($all == 1 && $hp > 0)
                {
                    $output .= "<a href='#' onclick=\"fighting('$fight', 0, '$group', '$invasionFight');window.scrollTo(0,0);return false;\"><font color=white>Fight 1 more creature</font></a> - [<font color=white>Fight all creatures] - <a href='#' onclick=\"updateCenterContents('loadLayout', 1);window.scrollTo(0,0);return false;\"><font color=white>Return to $S_location</font></a><br />";
                }
                if (!$group && $hp == 0)
                {
                    $output .= "<a href='#' onclick=\"updateCenterContents('loadLayout', 1);window.scrollTo(0,0);return false;\"><font color=white>Click here to continue.</font></a>";
                }
            } else
            {
                if ($group == 1)
                {
                    //$output .= "";
				}
                else if ($all == 1){
                    $output .= "<a href='#' onclick=\"fighting('$fight', 0, '$group', '$invasionFight');window.scrollTo(0,0);return false;\"><font color=white>Stop fighting after this creature</font></a><br />";
                }
                else
                {
                	$output .= "<a href='#' onclick=\"window.scrollTo(0,0);fighting('$fight', 1, '$group', '$invasionFight');return false;\"><font color=white>Fight all creatures</a><br />";
                }
            }
            if ($invasion)
            {
                $output .= "<BR>There " . ($monstersmuch == 1 ? "is" : "are") . " $monstersmuch " . $fight . ($monstersmuch == 1 ? "" : "s") . " left.<BR>";
            }
            $output .= "<br /><table border=0 cellpadding=0 cellspacing=0><tr align=left valign=top><td>";
            $output .= "$fooddump";
            $output .= "</td></tr></table>";
        } #RAND MONSTER ONCE A WHILE ATTACK
        //END display links


    }
    else
    {
        if ($invasion)
        {
            if ($work != 'fight')
            {
                mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='' WHERE username='$S_user' && work='fight' LIMIT 1") or die("err1or --> 12332231");
            }
            $output .= "<center><a href='' onclick=\"updateCenterContents('loadLayout', 1);return false;\">return to $S_location</a></h1>";
        } else
        {
            mysqli_query($mysqli, "UPDATE users SET work='', worktime='', dump='', dump2='' WHERE username='$S_user' && work='fight' LIMIT 1") or die("err1or --> 1232sa231");
            $output .= "<center>There are no more $fight monsters at $S_location, click <a href='' onclick=\"updateCenterContents('loadLayout', 1);return false;\">here</a> to return to $S_location.</h1>";
            if ($group == 1)
            {
                $output .= "<br /><br /><h3><b>The final combat log:</b></h3><br />";
                $output .= "<table><tr><td><B>$S_user<td><Td><B>$fight";
                $output .= "$dump2 ";
                $output .= "<tr><td><B>$S_user</B><td><Td><B>$fight</B>";
                $output .= "</table><BR>";
            }
        }
    }

    $output .= "</center></td><td width=10></td></tr></table>";
    $output .= "<br />";
    $output .= "</td><td background=layout/layout3_R.jpg></td></tr>";
    $output .= "<tr><td width=13 height=13 background=layout/layout3_LO.jpg></td><td background=layout/layout3_O.jpg></td><td background=layout/layout3_RO.jpg></td></tr>";
    $output .= "</table></center>";


    $output = str_replace('"', '\\"', $output);
    echo "$('centerContent').innerHTML=\"$output\";";
    return;


} #user/def

?>