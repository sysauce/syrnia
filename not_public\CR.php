<?php

if ($pass == '134fe')
{
	echo "Start<br/>";
    ###############################
    ## EVERY 15 MINUTEN ( te vaak runnen..veel cleanups..veeel spawns in arch cave
    ###############################

    $ip = $_SERVER['REMOTE_ADDR'];

	define('AZtopGame35Heyam', true );

    //GAMEURL, SERVERURL etc.
    require_once ("../currentRunningVersion.php");
    // Require the main game file.
    require_once (GAMEPATH . "includes/db.inc.php");
	include_once (GAMEPATH . 'ajax/includes/functions.php');

    $datum = date("d-m-Y H:i");
    $time = $timee = time();

    $beginTime = $timee;
    $saaql = "INSERT INTO bugreports (username, text, time, type)
	 	VALUES ('CRONJOB', 'CRONJOB 1 NEVER ENDED!', '$beginTime', 'CRON')";
    mysqli_query($mysqli, $saaql) or die("Func Item add error 2, please report!");
	$CRONJOBID=$mysqli->insert_id;




    ### TIMEOUT ONLINE
    $saaeql = "SELECT username FROM users WHERE online=1";
    $resultaeat = mysqli_query($mysqli, $saaeql);
    while ($record = mysqli_fetch_object($resultaeat))
    {
        //$timeout = time() - 7200;//2 hours
        $timeout = time() - 3600;//1 hour
        $saaql = "SELECT ID FROM stats WHERE username='$record->username' && lastvalid<$timeout && lastaction<$timeout && loggedin<$timeout LIMIT 1";
        $resulteat = mysqli_query($mysqli, $saaql);
        while ($rec = mysqli_fetch_object($resulteat))
        {
            mysqli_query($mysqli, "UPDATE users SET online=0 WHERE username='$record->username' LIMIT 1") or
                die("error --> 4243");
            mysqli_query($mysqli, "UPDATE staffrights SET isOnline=0 WHERE username='$record->username' LIMIT 1") or
                die("error --> 4243");
        }
    }

    ## ITEM CHEC
    $timemax = time() - 3600;
    	$sql = "DELETE FROM items_dropped WHERE droptime<'$timemax'";
		  mysqli_query($mysqli,$sql) or die("error report this bug please 1  asdghf1");
    //$sql = "DELETE FROM items_inventory WHERE much<1";
    //mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
    $sql = "DELETE FROM houses WHERE much<1";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
    $sql = "DELETE FROM shops WHERE much<1";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
    $sql = "DELETE FROM messages WHERE username=''";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");

    ## MAIN FORUM CLEANSEN
    $limit = time() - 3600 * 24 * 7 * 2; //2 weeks cleanup on main forum
    $sql = "SELECT ID FROM forumtopics WHERE clan='Syrnia Main Forum' && sticky=0 && categorie<>'830' && categorie<>'1916'  && categorie<>'1917'  && categorie<>'1918' && categorie<>'1919'  && categorie<>'346' && lastreply<'$limit'";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $sql = "DELETE FROM forumtopics WHERE ID='$record->ID'";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
        $sql = "DELETE FROM forummessages WHERE topic='$record->ID'";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
    }

    /*

    ## ALL FORUMs CLEANSEN
    $limit=time()-3600*24*7*12; //12 weeks cleanup on all forums (actually only mod forum atm, clan should be emptied later!)
    $sql ="SELECT ID FROM forumtopics WHERE clan='SyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrniaSyrnia' && lastreply<'$limit' && sticky=0 && locked=0";
    $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    $sql = "DELETE FROM forumtopics WHERE ID='$record->ID'";
    mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
    $sql = "DELETE FROM forummessages WHERE topic='$record->ID'";
    mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
    }
    */


    ## DELETE GAME MESSAGES VAN 4 WEKEN
    $timeout = 3600 * 24 * 7 * 4;
    $sql = "DELETE FROM messages WHERE sendby='<B>Syrnia</B>' && time<'$timeout'";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");


    ## DELETE DELETED MESSAGES 4 WEKEN
    $timeout = $time - 3600 * 24 * 7 * 4;
    $sql = "DELETE FROM messages WHERE time<'$timeout' && status=127";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");


    ## ADD NEW ARENA TIMES
    #once every 2 days a new arena time one week ahead
    if(rand(1, (96 * 2)) == 1 || $bm)
    {
        $arenatime = time() + 604800;
        $rand = rand(1, 7);
        if($rand == 1)
        {
            $minLevel = 10;
            $maxLevel = 19;
        }
		elseif($rand == 2)
        {
            $minLevel = 20;
            $maxLevel = 29;
        }
		elseif($rand == 3)
        {
            $minLevel = 30;
            $maxLevel = 39;
        }
		elseif($rand == 4)
        {
            $minLevel = 40;
            $maxLevel = 49;
        }
		elseif($rand == 5)
        {
            $minLevel = 50;
            $maxLevel = 59;
        }
		elseif($rand == 6)
        {
            $minLevel = 60;
            $maxLevel = 79;

		}
		elseif($rand == 7)
        {
            $minLevel = 80;
            $maxLevel = 200;
		}

		$addArena = false;
		$loopCount = 0;
		do
		{
			$resultaat = mysqli_query($mysqli, "SELECT ID FROM arena WHERE time >= $arenatime - 3600 AND time <= $arenatime + 3600 LIMIT 1");
			$aantal = mysqli_num_rows($resultaat);
			if($aantal > 0)
			{
				echo "add hour<br/>";
				$arenatime += 3600;
			}
			else
			{
				echo "add BM<br/>";
				$addArena = true;
			}
			$loopCount++;
		}while(!$addArena && $loopCount < 5);

		$sql = "INSERT INTO arena (time, minLevel, maxLevel)
			VALUES ('$arenatime', '$minLevel', '$maxLevel')";
        mysqli_query($mysqli, $sql) or die("error r");
    }


    #####
    ### ELK 60 min ONGEVEER
    ####
    if(rand(1, 3) == 1 || $ac5o)
    { ###


        ## ITEM DROP CHESTS
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM items_dropped WHERE location like 'Arch. cave 2%' AND type = 'locked' LIMIT 4");
        $aantal = mysqli_num_rows($resultaat);
        while ($aantal < 3)
        {
            $itemnr = rand(1, 3);
            $item[1] = 'Locked moldy chest';
            $item[2] = 'Locked ancient chest';
            $item[3] = 'Locked toolbox';

            if (rand(1, 10) <= 6)
            { # 60% van de chests op hidden location (2.18, 2.19, 2.17, 2.8 )
                $locationdrop = rand(17, 19);
            } else
            {
                $locationdrop = rand(1, 20);
            }
            $locationdrop = "Arch. cave 2.$locationdrop";

            $sql = "INSERT INTO items_dropped (name, type, much, location, droptime)
  VALUES ('$item[$itemnr]', 'locked', '1', '$locationdrop', '2')";
            mysqli_query($mysqli, $sql) or die("error report this bug please33 234366 msg  $sendto', '$user', '$tekst', '$datum', '$time'");
            $aantal++;
        } ### ITEM DROP VAN CHEST



        ##  CHEST CONTEST
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM locations WHERE location like '%Arch. cave %'  && type='chest' && rewarded<>1 LIMIT 4");
        $aantal = mysqli_num_rows($resultaat);
     //   echo "$aantal chests..<BR>";

        while($aantal <= 3)
        {
            $itemnr = rand(1, 3);
            $layer = rand(1, 3);// * 2; #layer 2 or 4
            if($layer == 3) { $layer = 5; } else { $layer *= 2; }

            $item[1] = 'Locked moldy chest';
            $item[2] = 'Locked ancient chest';
            $item[3] = $layer == 5 ? 'Locked sarcophagus' : 'Locked toolbox';

            $leeg = 1; #bij 0 is het leef
            $attempts = 0;
            while($leeg <> 0 && $attempts<100)
            {
                $attempts++;
                if($layer == 2)
                {
                    if(rand(1, 10) <= 8)
                    { # 80% van de chests op hidden location (2.18, 2.19, 2.17, 2.8 )
                        $locationdrop = rand(17, 19);
                    }
                    else
                    {
                        $locationdrop = rand(8, 20);
                    }
                }
                else if($layer == 4)
                {
                    do
                    {
                        $locationdrop = rand(1, 7);
                    }while($locationdrop == 4 || $locationdrop == 5);
                }
                else if($layer == 5)
                {
                    do
                    {
                        $locationdrop = rand(1, 13);
                    }while($locationdrop == 3 || $locationdrop == 4);
                }
                $locationdrop = "Arch. cave $layer.$locationdrop";

                $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE location='$locationdrop' && rewarded=0 LIMIT 1");
                $leeg = mysqli_num_rows($resultaat);
            }
            $sql = "DELETE FROM invasions WHERE location='$locationdrop'";
            mysqli_query($mysqli, $sql) or die("error report t2344324his bug pleaseMESSAGE");
            $sql = "DELETE FROM locations WHERE location='$locationdrop'";
            mysqli_query($mysqli, $sql) or die("error rep234323ort this bug pleaseMESSAGE");
            $totalcombis = rand(25, 75);
            $combination = rand(1, $totalcombis);
           // echo "adding new chest at $locationdrop.<BR>";
            $saaql = "INSERT INTO locations (location, monsters, monstersmuch, invasiontime, type, itemtype, combination, hideInEventList)
 VALUES ('$locationdrop', '$item[$itemnr]', '1', '$totalcombis', 'chest', 'locked', '$combination', true)";
            mysqli_query($mysqli, $saaql) or die("ER2OR: $saaql");
            $aantal++;
            //echo "nu $aantal chests<br>";

        } ### CHEST CONTEST


        ##  RARE RESOURCE
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM locations WHERE location like 'Arch. cave 4%'  && monstersmuch>0 && type='resource' LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
       // echo "rare resource?<BR>";
        while ($aantal < 1)
        {
            //echo "rare resource<BR>";
            $itemnr = rand(1, 5);

            $item[1] = 'Gold ore';
            $itemmuch[1] = rand(2, 20);
            $item[2] = 'Gold ore';
            $itemmuch[2] = rand(2, 20);
			$item[3] = 'Platina ore';
            $itemmuch[3] = rand(2, 20);
			$item[4] = 'Platina ore';
            $itemmuch[4] = rand(2, 20);
			$item[5] = 'Platina ore';
            $itemmuch[5] = rand(2, 20);
            $item[5] = 'Syriet ore';
            $itemmuch[5] = rand(1, 2);

            if(rand(1,2)==1){
            	$locationdrop = "Arch. cave 4.5";
            }else{
            	$locationdrop = "Arch. cave 4.4";
            }
            $sql = "DELETE FROM locations WHERE location='$locationdrop' && type='resource'";
            mysqli_query($mysqli, $sql) or die("error rep234323ort this bug pleaseMESSAGE");

            $saaql = "INSERT INTO locations (location, monsters, monstersmuch, type, itemtype, dump, hideInEventList)
 VALUES ('$locationdrop', '$item[$itemnr]', '$itemmuch[$itemnr]', 'resource', 'Mine $item[$itemnr]', 'ore', true)";
            mysqli_query($mysqli, $saaql) or die("ER2OR: $saaql");
            $aantal++;
			echo "$itemmuch[$itemnr] $item[$itemnr] at $locationdrop<br/>";
        } ### RARE RESOURCE


        //echo "&.";


        ##  SPAWN GROUP
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM partyfight WHERE location like 'Arch. cave 4%' && hp>0 LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
        while ($aantal < 1)
        { # 1 spawnen
           // echo "Spawnn groupfight..<br />"; #
            $monster = rand(1, 100);
            if ($monster <= 2)
            {
                $monster = "Roodarus";
            } elseif ($monster <= 10)
            {
                $monster = "Stemosaurus";
            } elseif ($monster <= 50)
            {
                $monster = "Honurus";
            } else
            {
                $monster = "Waranerus";
            }


            $sql = "SELECT hp FROM monsters WHERE name='$monster' LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                $hishp = floor($record->hp * 1.1 + 3);
            }

            $vol = 1; #niet leeg
            while ($vol <> 0)
            {
                $locationdrop = "Arch. cave 4." . rand(1, 7);
                $resultaat = mysqli_query($mysqli, "SELECT ID FROM partyfight WHERE location='$locationdrop' && hp>0 LIMIT 1");
                $vol = mysqli_num_rows($resultaat);
            }
           // echo "location $locationdrop<br>"; #

            $sql = "DELETE FROM partyfight WHERE location='$locationdrop' LIMIT 1";
            mysqli_query($mysqli, $sql) or die("error repor32443t this bug pleaseMESSAGE");

            $saaql = "INSERT INTO partyfight (location, monster, hp, hideInEventList)
 VALUES ('$locationdrop', '$monster', '$hishp', true)";
            mysqli_query($mysqli, $saaql) or die("ERO3R");
            $aantal++;
        } ### SPAWN GROUP




        ##  RARE RESOURCE AC5
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM locations WHERE location LIKE 'Arch. cave 5%' && monstersmuch>0 && type='resource' LIMIT 2");
        $aantal = mysqli_num_rows($resultaat);
       // echo "rare resource?<BR>";
        while ($aantal < 2)
        {
            //echo "rare resource<BR>";
            $itemnr = rand(1, 7);

			if($ac5o == 'pur')
			{
				$itemnr = 7;
			}
			else if($ac5o == 'obs')
			{
				$itemnr = 5;
			}
			else if($ac5o == 'syr')
			{
				$itemnr = 3;
			}
			else if($ac5o == 'plat')
			{
				$itemnr = 1;
			}

            $item[1] = 'Platina ore';
            $itemmuch[1] = rand(15, 30);
            $creature[1] = "Gold scaled gaman";
            $creaturemuch[1] = rand(15, 20);

            $item[2] = 'Platina ore';
            $itemmuch[2] = rand(15, 30);
            $creature[2] = "Gold scaled gaman";
            $creaturemuch[2] = rand(15, 20);

			$item[3] = 'Syriet ore';
            $itemmuch[3] = rand(3, 6);
            $creature[3] = "Platina scaled gaman";
            $creaturemuch[3] = rand(15, 20);

			$item[4] = 'Syriet ore';
            $itemmuch[4] = rand(3 , 6);
            $creature[4] = "Platina scaled gaman";
            $creaturemuch[4] = rand(15, 20);

			$item[5] = 'Obsidian ore';
            $itemmuch[5] = rand(2, 4);
            $creature[5] = "Syriet scaled gaman";
            $creaturemuch[5] = rand(10, 15);

            $item[6] = 'Obsidian ore';
            $itemmuch[6] = rand(2, 4);
            $creature[6] = "Syriet scaled gaman";
            $creaturemuch[6] = rand(10, 15);

            $item[7] = 'Puranium ore';
            $itemmuch[7] = rand(2, (rand(1,3) == 1 ? 2 : 3));
            $creature[7] = "Obsidian scaled gaman";
            $creaturemuch[7] = rand(5, 10);

            if($aantal == 1)
            {
                //Already have a spawn at 1 location so do it at the other
                $sql = "SELECT location FROM locations WHERE location LIKE 'Arch. cave 5%' && monstersmuch>0 && type='resource'";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    if($record->location == "Arch. cave 5.3")
                    {
                        $locationdrop = "Arch. cave 5.4";
                    }
                    else
                    {
                        $locationdrop = "Arch. cave 5.3";
                    }
                }
            }
            else if(rand(1,2)==1)
            {
            	$locationdrop = "Arch. cave 5.3";
            }
            else
            {
            	$locationdrop = "Arch. cave 5.4";
            }

            $sql = "DELETE FROM locations WHERE location='$locationdrop' && type IN ('resource','oreblock')";
            mysqli_query($mysqli, $sql) or die("error rep234323ort this bug pleaseMESSAGE");

            $saaql = "INSERT INTO locations (location, monsters, monstersmuch, type, itemtype, dump, hideInEventList)
 VALUES ('$locationdrop', '$creature[$itemnr]', '$creaturemuch[$itemnr]', 'oreblock', 'Fight $creature[$itemnr]', '', true)";
            mysqli_query($mysqli, $saaql) or die("ER2OR: $saaql");

            $saaql = "INSERT INTO locations (location, monsters, monstersmuch, type, itemtype, dump, hideInEventList)
 VALUES ('$locationdrop', '$item[$itemnr]', '$itemmuch[$itemnr]', 'resource', 'Mine $item[$itemnr]', 'ore', true)";
            mysqli_query($mysqli, $saaql) or die("ER2OR: $saaql");
            $aantal++;
            $aantal++;
			echo "$itemmuch[$itemnr] $item[$itemnr] at $locationdrop<br/>";
        } ### RARE RESOURCE AC5


        ##  SPAWN GROUP AC5
        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM partyfight WHERE location like 'Arch. cave 5%' && hp>0 LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
        while ($aantal < 1)
        { # 1 spawnen
           // echo "Spawnn groupfight..<br />"; #
            $monster = rand(1, 7);
            if ($monster <= 1)
            {
                $monster = "Obsidian flame dragon";
            }
            else if($monster <= 3)
            {
                $monster = "Syriet flame dragon";
            }
            else
            {
                $monster = "Platina flame dragon";
            }


            $sql = "SELECT hp FROM monsters WHERE name='$monster' LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                $hishp = floor($record->hp * 1.1 + 3);
            }

            $vol = 1; #niet leeg
            while ($vol <> 0)
            {
                do
                {
                    $locationdrop = rand(2, 13);
                }while($locationdrop == 3 || $locationdrop == 4);
                $locationdrop = "Arch. cave 5." . $locationdrop;
                $resultaat = mysqli_query($mysqli, "SELECT ID FROM partyfight WHERE location='$locationdrop' && hp>0 LIMIT 1");
                $vol = mysqli_num_rows($resultaat);
            }
           // echo "location $locationdrop<br>"; #

            $sql = "DELETE FROM partyfight WHERE location='$locationdrop' LIMIT 1";
            mysqli_query($mysqli, $sql) or die("error repor32443t this bug pleaseMESSAGE");

            $saaql = "INSERT INTO partyfight (location, monster, hp, hideInEventList)
 VALUES ('$locationdrop', '$monster', '$hishp', true)";
            mysqli_query($mysqli, $saaql) or die("ERO3R");
            $aantal++;
        } ### SPAWN GROUP AC5


        ## ONG ELK UUR
    }


    //BEGIN!


//echo "#.";

    //BEGIN THIS CODE IS ALSO IN 15 MIN CRON AND AT CAVE OF TRADES AUCTION CODE!
    $swql = "SELECT ID, name, much, type, bid, time, seller, bidder, donator,itemupgrade, time, upgrademuch,pickupLocation FROM auctions WHERE time<='$timee' && messaged!=1";
    $resultat = mysqli_query($mysqli, $swql);
    while ($rec = mysqli_fetch_object($resultat))
    {
        $plus = '';
        if ($rec->upgrademuch > 0)
        {
            $plus = "+";
        }
        $upg = '';
        if ($rec->itemupgrade)
        {
            $upg = "[$plus$rec->upgrademuch $rec->itemupgrade]";
        }
        if ($rec->bidder)
        {
            mysqli_query($mysqli, "DELETE from auctions WHERE ID='$rec->ID' LIMIT 1") or die("UaG56");

			$naarwie = $rec->bidder;
            mysqli_query($mysqli,
                "INSERT INTO messages (username, sendby, message, topic, time)
			 	VALUES ('$rec->bidder', '<B>Syrnia</B>', 'A Cave of trades runner tells you:<br />
			  <i>You have bid $rec->bid gold for $rec->much $rec->name $upg from $rec->seller and won the auction!<br />
			  Here it is...</i><br />
			  You got the item you bid for!<br /> ',  'Cave of trades', '$timee')") or
                die("D  1IE 2");

			if($upg==''){//Only use items without upgrade
            	mysqli_query($mysqli, "UPDATE items SET amountSold=amountSold+'$rec->much', soldFor=soldFor+'$rec->bid', marketprice=soldFor/amountSold  WHERE name='$rec->name' LIMIT 1") or die("UaGArt");
            }

            $getgold = round($rec->bid * 0.95);
            mysqli_query($mysqli, "UPDATE users SET gold=gold+'$getgold'  WHERE username='$rec->seller' LIMIT 1") or die("UaGArt");
            $resultaaXat = mysqli_query($mysqli,"SELECT gold FROM users WHERE username='$rec->seller' LIMIT 1");
			while ($recG = mysqli_fetch_object($resultaaXat)) { $newGold=$recG->gold; }

            mysqli_query($mysqli,
                "INSERT INTO messages (username, sendby, message, topic, time)
				  VALUES ('$rec->seller', '<B>Syrnia</B>', 'A Cave of trades runner tells you:<br />
				  <i>Dear $rec->seller,<br />Your $rec->much $rec->name $upg has been sold at your auction.<br />
				  $rec->bidder won the auction, with a bid of $rec->bid gold.<br />
				  You get $getgold gold because a 5% fee goes to the Caves of trades. You now have $newGold gold.<br />
				  It will take up to 15 minutes for the gold to appear.</i><br />
				  <br /> ', 'Cave of trades', '$time')") or die("D  1IE 2");


            $resultaat = mysqli_query($mysqli,
                "SELECT username FROM items_inventory WHERE name='$rec->name' && itemupgrade='$rec->itemupgrade' && upgrademuch='$rec->upgrademuch' && username='$naarwie' LIMIT 1");
            $aantal = mysqli_num_rows($resultaat);
            if ($aantal == 1)
            {
                mysqli_query($mysqli, "UPDATE items_inventory SET much=much+'$rec->much' WHERE name='$rec->name' && itemupgrade='$rec->itemupgrade' && upgrademuch='$rec->upgrademuch' && username='$naarwie' LIMIT 1");
            } else
            {
                $sql = "INSERT INTO items_inventory (username, name, much, type, itemupgrade, upgrademuch)
					         VALUES ('$naarwie', '$rec->name', '$rec->much', '$rec->type', '$rec->itemupgrade', '$rec->upgrademuch')";
                mysqli_query($mysqli, $sql) or die("erroraa report this bug");
            }


        } else
        {

            mysqli_query($mysqli, "UPDATE auctions SET messaged=1 WHERE ID='$rec->ID' LIMIT 1") or die("UaH78");

            $saaql = "INSERT INTO messages (username, sendby, message, topic, time)
				  VALUES ('$rec->seller', '<B>Syrnia</B>', 'A Cave of trades runner tells you:<br />
				  <i>Your $rec->much $rec->name $upg has not been sold at your auction.<br />
				  There was no bidder, you can collect your item at $rec->pickupLocation.<br /></i><br />
				  <br /> ', 'Cave of trades', '$time')";
            mysqli_query($mysqli, $saaql) or die("D  1IE 2");
        }


    }
    //END THIS CODE IS ALSO IN 15 MIN CRON!






    //ONLY delete place
	function deleteUser($username){
		global $mysqli;
		$resultaaaat = mysqli_query($mysqli,"SELECT ID, type FROM buildings WHERE username='$username'");
       	while ($record = mysqli_fetch_object($resultaaaat))
        {
            if ($record->type == 'shop')
            {
                $sqll = "DELETE FROM shops WHERE ID='$record->ID'";
                mysqli_query($mysqli, $sqll) or die("error report this bug please  asdg34343hf1");
            } elseif ($record->type == 'house')
            {
                $sqll = "DELETE FROM houses WHERE ID='$record->ID'";
                mysqli_query($mysqli, $sqll) or die("error report this bug please  asdg34343hf1");
            }
        }
        mysqli_query($mysqli, "DELETE FROM options WHERE username='$username'") or die("error report this bug please  as32dghf1");
        mysqli_query($mysqli, "DELETE FROM donators WHERE username='$username'") or die("error report this bug please  as32dghf1");
        mysqli_query($mysqli, "DELETE FROM items_inventory WHERE username='$username'") or die("error report this bug please  as32dghf1");
        mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username='$username'") or die("error report this bug please  as32dghf1");
        mysqli_query($mysqli, "DELETE FROM ips WHERE username='$username'") or die("error report this bug please  as32dghf1");
        mysqli_query($mysqli, "DELETE FROM messages WHERE username='$username'") or die("error report this bug please  asdg252hf1");
        mysqli_query($mysqli, "DELETE FROM users WHERE username='$username'") or die("error report this bug please  22a3sdghf1    '$username'");
        mysqli_query($mysqli, "DELETE FROM buildings WHERE username='$username'") or die("error report this bug please  asd123ghf1");
        mysqli_query($mysqli, "DELETE FROM quests WHERE username='$username'") or die("error report this bug please  asdgh242f1");
        mysqli_query($mysqli, "DELETE FROM stats WHERE username='$username'") or die("error report this bug please  asdg34343hf1");
        mysqli_query($mysqli, "DELETE from auctions WHERE seller='$username' LIMIT 1") or die("Ua seller");
		mysqli_query($mysqli, "DELETE FROM users_junk WHERE username='$username' LIMIT 1") or die("error report this bug please  22a3sdghf1    '$username'");

		$resultaaaat = mysqli_query($mysqli,"SELECT ticketID FROM tickettopics WHERE author='$username'");
        while ($record = mysqli_fetch_object($resultaaaat))
        {
        	mysqli_query($mysqli, "DELETE FROM ticketmessages WHERE topicID='$record->ticketID'  ") or die("error report this bug XFD");
       	}
		mysqli_query($mysqli, "DELETE FROM tickettopics WHERE author='$username' LIMIT 1") or die("error report this bug please  22a3SDsdghf1    '$username'");

		$resultaaaat = mysqli_query($mysqli,"SELECT pw,tag, name FROM clans WHERE username='$username'");
        while ($record = mysqli_fetch_object($resultaaaat))
        {
        	if($record->pw!=''){
        		$resultat = mysqli_query($mysqli,"SELECT ID FROM clans WHERE tag='$record->tag' && username!='$username' LIMIT 1");
        		$memberCount = mysqli_num_rows($resultat);
        		if($memberCount>=1){//There is at least 1 other member
        			//Transfer clan leadership
        			mysqli_query($mysqli, "UPDATE clans SET pw='$record->pw' WHERE tag='$record->tag' && username!='$username' LIMIT 1") or die("UaH78");
        		}else{
        			//Delete clan
					      mysqli_query($mysqli,"DELETE FROM clans WHERE name='$record->name'") or die("error report this bug please2MESSAGE");
					      mysqli_query($mysqli,"DELETE FROM forummessages WHERE clan='$record->name'") or die("error report this bug please3MESSAGE");
					      mysqli_query($mysqli,"DELETE FROM forumtopics WHERE clan='$record->name'") or die("error report this bug please4MESSAGE");
					      mysqli_query($mysqli,"DELETE FROM forumcats WHERE clan='$record->name'") or die("error report this bug please5MESSAGE");
					      mysqli_query($mysqli,"DELETE FROM clannews WHERE clan='$record->name'") or die("error report this bug please6MESSAGE");
        		}
        	}
			//Remove user itself
        	mysqli_query($mysqli, "DELETE FROM clans WHERE username='$username' LIMIT 1") or die("error report this bug please  asdg34343hf1");
		}
	}

if($_SERVER['HTTP_HOST'] == "www.syrnia.com")
{
    ## DELETE INACTIVES WHO NEVER ACTIVATED
    $time = time() - 8 * 7 * 24 * 3600; // 8 weeks
    $resultaaaaaat = mysqli_query($mysqli,
        "SELECT username, email, joined FROM users  WHERE joined<$time && password LIKE '%]_[%' && location='Tutorial 1' && work='' && totalskill<25 && worktime=0");
    while ($recco = mysqli_fetch_object($resultaaaaaat))
    {
        $dees = round((time() - $recco->joined) / (3600 * 24));
        $user = $recco->username;
        deleteUser($user);
	//	echo "Deleted & MAAR GEEN mail $user na $dees days nog geen activation (Still on tut 1).<BR>";
    }

    ///////
    //#$##$##$#$

    ### MAIL INACTIVE USERS
    $timeout = time() - 4 * 30 * 24 * 3600; //4 maanden   10368000
    $timeout2 = time() - 356 * 3600 * 24 * 5; //5 JAAR      153792000
    $time = time();
    $email = '';

    $SQL="SELECT username, loggedin FROM stats WHERE (loggedin<$timeout  && inactivemailed=0 && donation<10) OR (loggedin<$timeout2  && inactivemailed=0 && donation>=10) ORDER BY ID ASC LIMIT 25";
	$result = mysqli_query($mysqli,"$SQL");
    while ($record = mysqli_fetch_object($result))
    {
	    $user=$record->username;
	    $resultaaaat = mysqli_query($mysqli,"SELECT email, fullname, joined, password, work FROM users WHERE username='$user' LIMIT 1");
	    while ($rec = mysqli_fetch_object($resultaaaat))
		{
			$email=$rec->email; $UserWork=$rec->work; $fullname=$rec->fullname;  $joined=$rec->joined;  $PAS=$rec->password;
		}
	    $days=round((time()-$joined)/86400);
	    $notdays=round((time()-$record->loggedin)/86400); if($notdays>=10000){$notdays=$days;}
	    if($notdays>=7 && $email<>'' && $days>2 && $PAS){
	    if($notdays>0 && $notdays<400){$login="But you have not logged in for $notdays days."; } else{ $login="But you have never logged in.";}
$message="Dear $fullname,

You registered an acount '$user' at the free online RPG game www.syrnia.com $days days ago.
$login
If you do not login within 31 days we will delete your account because we want to keep the server at full speed.
However, you are very welcome to come back! If you do your account is up and running again and will not be deleted.

Your login details:
Username: $user
Password: $PAS

Please notice that Syrnia has got a lot of updates the last $notdays days that are worth looking at!
At least take a quick view at the latest news entries to check the new skills/quests/maps etc.
I hope you will get back into playing syrnia again. Every player contributes their own unique part to Syrnia.

http://www.syrnia.com

Thanks for playing, we hope to see you around again.

Greetings,
Syrnia";
	    if($UserWork<>'freezed'){ mail( "$email", "Syrnia",$message,"From: support@syrnia.com" ); }

	   // echo"$user [$email] -  mailed about his inactivity ($days days no login).<BR>";
	    }

	    mysqli_query($mysqli,"UPDATE stats SET inactivemailed='$time' WHERE username='$user' LIMIT 1") or die("error --> 544343");
	   // echo"Ik zou nu gemailed moeten hebben [$email] van [$user].. met wkerrie: [UPDATE stats SET inactivemailed='$time' WHERE username='$user' LIMIT 1] ";

    }
    /////////
    /// END OF INACTIVITY MAIL



   // echo "Done there..<br />";


    $timeout = time() - 2 * 30 * 24 * 3600; // 2 maanden na de mail van ianctivity: deleten

    $resultaaaaat = mysqli_query($mysqli, "SELECT username, loggedin FROM stats WHERE inactivemailed<>0 && inactivemailed<'$timeout'");
    while ($recco = mysqli_fetch_object($resultaaaaat))
    {
        $user = $recco->username;
     //   echo "Deleting $user..<br/>";
		deleteUser($user);
    }
}


if(isHalloween() OR date("-m-d")=='-11-02' OR date("-m-d")=='-11-2')
{
	### HALLOWEEN WITCH EVENT
    $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username=' Halloween witch' LIMIT 1");
	$aantal = mysqli_num_rows($resultaeat);

	if($aantal<1){
	//	echo"begin in first if<br />";
		if(date("-m-d")!='-11-02' && date("-m-d")!='-11-2'){

		//Spawn witch
	 	$sql = "INSERT INTO users (username, password, online)
				VALUES (' Halloween witch', 'DSDSA342423', '1')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");
		$sql = "INSERT INTO items_wearing (username, name, type)
				VALUES (' Halloween witch', 'Witch hat', 'helm')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");

    	}

		//	 echo"done in first if<br />";
	}else{
		//Rewards (witch was already around)

	//	echo"..<br />";
        $previousWinner="''";
        $chatLine='';
        $rewardedUsers = 0;
        $currentLocation = '';
		while ($record2 = mysqli_fetch_object($resultaeat))
    	{
            $currentLocation=$record2->location;

    		//	echo"IN<br />";
			### ADD CHAT MESSAGE
		    $SystemMessage = 1;$moderator=1;
			$chatMessage = "For their efforts in stealing the witch's prized possessions at $record2->location, the following players were rewarded:";
		    $channel = 0;
		    include (GAMEPATH . "/scripts/chat/addchat.php");
		    ### EINDE CHAT MESSAGE

			for($i=1;$i<=3;$i++){
				//Pick a user, and reward him/her
				$user='';

				$resultaat = mysqli_query($mysqli, "SELECT users.username as usern FROM users_junk, users WHERE users.username=users_junk.username &&" .
                    " users.online=1 && users.location='$record2->location' && users_junk.eventField='witch' && users.username NOT IN ($previousWinner) ORDER BY RAND() LIMIT 1");
				while ($rec = mysqli_fetch_object($resultaat)) { $user=$rec->usern; }

				if($user){
                    $rewardedUsers++;
					$rand=rand(1,21);

                    switch($rand)
                    {
                        case 1:
                        case 2:
                            $get="Witch hat";
                            break;

                        case 3:
                        case 4:
                            $get="Black cat";
                            break;

                        case 5:
                        case 6:
                            $get="Bat";
                            break;

                        case 7:
                        case 8:
                            $get="Witch cloak";
                            break;

                        case 9:
                        case 10:
                            $get="Witch broomstick";
                            break;

                        case 11:
                        case 12:
                            $get="Witch skirt";
                            break;

                        case 13:
                        case 14:
                            $get="Witch gloves";
                            break;

                        case 15:
                        case 16:
                            $get="Witch boots";
                            break;

                        case 17:
                        case 18:
                            $get="Halloween group fight summoning orb";
                            break;

                        case 19:
                        case 20:
                            $get="Halloween creature summoning orb";
                            break;

                        case 21:
                            $get="Heerchey docks teleport orb";
                            break;
                    }
					/*if($rand==1){
						$get="Witch hat";
					}else if($rand==2){
						$get="";
					}else if($rand==3){
						$get="Elder eagle summoning orb";
					}else if($rand==4){
						$get="Gnome summoning orb";
					}else if($rand==5){
						$get="Witch hat";
					}*/
					$resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
					while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }

					addItem("$user", $get, 1, $gettype, '', '', 0);

					$chatLine="$user got a $get.";
                    $SystemMessage = 1; $moderator=1;
                    $chatMessage = "$chatLine";
                    $channel = 0;
                    include (GAMEPATH . "/scripts/chat/addchat.php");
					$previousWinner.=",'$user'";
				}else if($rewardedUsers > 0){
					$chatLine="No other players got a reward, as they didn't meet the criteria.";
                    $SystemMessage = 1; $moderator=1;
                    $chatMessage = "$chatLine";
                    $channel = 0;
                    include (GAMEPATH . "/scripts/chat/addchat.php");
					$i=9;
				}
			}
			if($rewardedUsers > 0){
				$chatLine="";
			}else{
				$chatLine="No players were rewarded! No players annoyed the witch and were at the witches location.";
			}
			if($chatLine){
				### ADD CHAT MESSAGE
			    $SystemMessage = 1; $moderator=1;
			    $chatMessage = "$chatLine";
			    $channel = 0;
			    include (GAMEPATH . "/scripts/chat/addchat.php");
			    ### EINDE CHAT MESSAGE
			}
		}//SQL witch
		//	echo"@<br />";
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='' WHERE eventField NOT IN ('!witch1', '!witch2', '!witch3')") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!witch4' WHERE eventField = '!witch3'") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!witch3' WHERE eventField = '!witch2'") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!witch2' WHERE eventField = '!witch1'") or die("err1");

        if($rewardedUsers > 0)
        {
            mysqli_query($mysqli, "UPDATE users_junk SET eventField='!witch1' WHERE username IN ($previousWinner)") or die("err1");
        }
	//		echo"$<br />";
	}//witch was around, rewards
	//echo"a<br />";

	if(date("-m-d")!='-11-02' && date("-m-d")!='-11-2'){

    $currentIslandID = 0;
    if($currentLocation != '')
    {
        $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaeat))
        {
            $currentIslandID=$record->mapNumber;
        }
    }

    //Stop the Halloween witch from going to the same island twice
    $ISLAND_NR = $currentIslandID;
    while($ISLAND_NR == $currentIslandID)
    {
        $rand=rand(1,100);
        if($rand<=5){
            $ISLAND="Mezno island";
            $ISLAND_NR=4;
        }else if($rand<=15){
            if(rand(1,4) == 1)
            {
                $ISLAND="Anasco island";
                $ISLAND_NR=19;
            }
            else
            {
                $ISLAND="Kanzo island";
                $ISLAND_NR=15;
            }
        }else if($rand<=25){
            $ISLAND="Exrollia";
            $ISLAND_NR=17;
        }else if($rand<=35){
            $ISLAND="Webbers island";
            $ISLAND_NR=18;
        }else if($rand<=50){
            if(rand(1,2) == 1)
            {
                $ISLAND="Ogre cave";
                $ISLAND_NR=5;
            }
            else
            {
                $ISLAND="Elven island";
                $ISLAND_NR=6;
            }
        }else if($rand<=65){
            $ISLAND="Serpenthelm island";
            $ISLAND_NR=16;
        }else if($rand<=75){
            $ISLAND="Dearn island";
            $ISLAND_NR=2;
        }else if($rand<=90){
            $ISLAND="Remer island";
            $ISLAND_NR=1;
        }else {
            $ISLAND="Skull island";
            $ISLAND_NR=7;
        }
    }

//echo"b<br />";

	 ### ADD CHAT MESSAGE
    $SystemMessage = 1;$moderator=1;
	$chatMessage = "The halloween witch was spotted on her broomstick, heading to $ISLAND".".";
    $channel = 0;
    include ("../theGame/scripts/chat/addchat.php");
    ### EINDE CHAT MESSAGE
echo"c<br />";
    $resultaeat = mysqli_query($mysqli, "SELECT locationName FROM locationinfo WHERE mapNumber='$ISLAND_NR' ORDER BY RAND() LIMIT 1");
    while ($record = mysqli_fetch_object($resultaeat))
    {
		$newLoc=$record->locationName;
    }
    echo"newloc $newLoc<br />";
	mysqli_query($mysqli, "UPDATE users SET location='$newLoc' WHERE username=' Halloween witch' LIMIT 1") or   die("UaCRO");

	  echo"d<br />";

	} else{
		mysqli_query($mysqli, "DELETE FROM users WHERE username=' Halloween witch' LIMIT 1") or   die("UaCRO");
    	mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Halloween witch' LIMIT 1") or   die("UaCRO");
	}

}else{
	mysqli_query($mysqli, "DELETE FROM users WHERE username=' Halloween witch' LIMIT 1") or   die("UaCRO");
    mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Halloween witch' LIMIT 1") or   die("UaCRO");
}
## END WITCH EVENT



### XMAS EVENT
if(isXmas() OR date("-m-d")=='-12-27')
{
    $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username=' Jack Frost' LIMIT 1");
	$aantal = mysqli_num_rows($resultaeat);

	if($aantal<1){
	//	echo"begin in first if<br />";
		if(date("-m-d")!='-12-27'){

		//Spawn Jack Frost
	 	$sql = "INSERT INTO users (username, password, online)
				VALUES (' Jack Frost', 'DSDSA342423', '1')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");
		$sql = "INSERT INTO items_wearing (username, name, type)
				VALUES (' Jack Frost', 'Frost hat', 'helm'),
                (' Jack Frost', 'Frost shield', 'shield'),
                (' Jack Frost', 'Frost vest', 'body'),
                (' Jack Frost', 'Frost staff', 'hand'),
                (' Jack Frost', 'Frost legs', 'legs'),
                (' Jack Frost', 'Frost gloves', 'gloves'),
                (' Jack Frost', 'Frost shoes', 'shoes'),
                (' Jack Frost', 'Reindeer', 'horse')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");

    	}

		//	 echo"done in first if<br />";
	}else{
		//Rewards (Jack Frost was already around)

	//	echo"..<br />";
        $previousWinner="''";
        $excludedWinner="''";
        $chatLine='';
        $rewardedUsers = 0;
        $currentLocation = '';
		while ($record2 = mysqli_fetch_object($resultaeat))
    	{
            $currentLocation=$record2->location;
    		//	echo"IN<br />";

			for($i=1;$i<=6;$i++){
				//Pick a user, and reward him/her
				$user='';

				$resultaat = mysqli_query($mysqli, "SELECT users.username as usern FROM users_junk, users WHERE users.username=users_junk.username &&" .
                    " users.online=1 && users.location='$record2->location' && users_junk.eventField='jf' && users.username NOT IN ($previousWinner) ORDER BY RAND() LIMIT 1");
				while ($rec = mysqli_fetch_object($resultaat)) { $user=$rec->usern; }

				if($user)
                {
                    $rewardedUsers++;

                    if($rewardedUsers == 1)
                    {
                        ### ADD CHAT MESSAGE
                        $SystemMessage = 1;$moderator=1;
                        $chatMessage = "For their efforts in stealing Jack Frost's prized possessions at $record2->location, the following players were rewarded:";
                        $channel = 0;
                        include (GAMEPATH . "/scripts/chat/addchat.php");
                        ### EINDE CHAT MESSAGE
                    }

                    if($i > 3)
                    {
                        $get="Locked christmas present";
                        $resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
                        while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }

                        addItem("$user", $get, 1, $gettype, '', '', 0);

                        $chatLine .= ($i == 4 ? "" : ($i == 5 ? ", " : " and ")) . "$user" . ($i == 6 ? " also got a $get." : "");
                        $previousWinner.=",'$user'";
                    }
                    else
                    {
                        $rand=rand(1,18);

                        switch($rand)
                        {
                            case 1:
                            case 2:
                                $get="Frost hat";
                                break;

                            case 3:
                            case 4:
                                $get="Frost shield";
                                break;

                            case 5:
                            case 6:
                                $get="Frost vest";
                                break;

                            case 7:
                            case 8:
                                $get="Frost staff";
                                break;

                            case 9:
                            case 10:
                                $get="Frost legs";
                                break;

                            case 11:
                            case 12:
                                $get="Frost gloves";
                                break;

                            case 13:
                            case 14:
                                $get="Frost shoes";
                                break;

                            case 15:
                            case 16:
                                $get="Christmas creature summoning orb";
                                break;

                            case 17:
                            case 18:
                                $get="Christmas group fight summoning orb";
                                break;
                        }

                        $resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
                        while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }

                        addItem("$user", $get, 1, $gettype, '', '', 0);

                        $chatLine="$user got a $get.";
                        $SystemMessage = 1; $moderator=1;
                        $chatMessage = "$chatLine";
                        $channel = 0;
                        include (GAMEPATH . "/scripts/chat/addchat.php");
                        $previousWinner.=",'$user'";
                        $excludedWinner.=",'$user'";
                        $chatLine = "";
                    }
				}else if($rewardedUsers > 0 && $rewardedUsers < 3){
					$chatLine="No other players got a reward, as they didn't meet the criteria.";
                    $SystemMessage = 1; $moderator=1;
                    $chatMessage = "$chatLine";
                    $channel = 0;
                    include (GAMEPATH . "/scripts/chat/addchat.php");
					$i=9;
                    $chatLine = "";
				}

                if($i == 6 && $rewardedUsers > 3 && $rewardedUsers < 6)
                {
                    if($rewardedUsers == 5)
                    {
                        $chatLine = str_replace(", ", " and ", $chatLine);
                    }

                    $chatLine .= " also got a Locked christmas present!";
                }
			}
			if($rewardedUsers == 0)
            {
				$chatLine="No players were rewarded! No players annoyed Jack Frost and were at the same location.";
			}
			if($chatLine){
				### ADD CHAT MESSAGE
			    $SystemMessage = 1; $moderator=1;
			    $chatMessage = "$chatLine";
			    $channel = 0;
			    include (GAMEPATH . "/scripts/chat/addchat.php");
			    ### EINDE CHAT MESSAGE
			}
		}//SQL witch
		//	echo"@<br />";
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='' WHERE eventField NOT IN ('!jf1', '!jf2', '!jf3')") or die("err jf 1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!jf4' WHERE eventField = '!jf3'") or die("err jf2");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!jf3' WHERE eventField = '!jf2'") or die("err jf3");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!jf2' WHERE eventField = '!jf1'") or die("err jf4");

        if($rewardedUsers > 0)
        {
            mysqli_query($mysqli, "UPDATE users_junk SET eventField='!jf1' WHERE username IN ($excludedWinner)") or die("err jf5");
        }
	//		echo"$<br />";
	}//witch was around, rewards
	//echo"a<br />";

	if(date("-m-d")!='-12-27'){

    $currentIslandID = 0;
    if($currentLocation != '')
    {
        $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaeat))
        {
            $currentIslandID=$record->mapNumber;
        }
    }

    //Stop Jack Frost from going to the same island twice
    $ISLAND_NR = $currentIslandID;
    while($ISLAND_NR == $currentIslandID)
    {
        $rand=rand(1,100);
        if($rand<=5){
            $ISLAND="Mezno island";
            $ISLAND_NR=4;
        }else if($rand<=15){
            if(rand(1,4) == 1)
            {
                $ISLAND="Anasco island";
                $ISLAND_NR=19;
            }
            else
            {
                $ISLAND="Kanzo island";
                $ISLAND_NR=15;
            }
        }else if($rand<=25){
            $ISLAND="Exrollia";
            $ISLAND_NR=17;
        }else if($rand<=35){
            $ISLAND="Webbers island";
            $ISLAND_NR=18;
        }else if($rand<=50){
            if(rand(1,2) == 1)
            {
                $ISLAND="Ogre cave";
                $ISLAND_NR=5;
            }
            else
            {
                $ISLAND="Elven island";
                $ISLAND_NR=6;
            }
        }else if($rand<=65){
            $ISLAND="Serpenthelm island";
            $ISLAND_NR=16;
        }else if($rand<=75){
            $ISLAND="Dearn island";
            $ISLAND_NR=2;
        }else if($rand<=90){
            $ISLAND="Remer island";
            $ISLAND_NR=1;
        }else {
            $ISLAND="Skull island";
            $ISLAND_NR=7;
        }
    }

//echo"b<br />";

	 ### ADD CHAT MESSAGE
    $SystemMessage = 1;$moderator=1;
	$chatMessage = "Jack Frost was spotted heading to $ISLAND.";
    $channel = 0;
    include ("../theGame/scripts/chat/addchat.php");
    ### EINDE CHAT MESSAGE
echo"c<br />";
    $resultaeat = mysqli_query($mysqli, "SELECT locationName FROM locationinfo WHERE mapNumber='$ISLAND_NR' ORDER BY RAND() LIMIT 1");
    while ($record = mysqli_fetch_object($resultaeat))
    {
		$newLoc=$record->locationName;
    }
    echo"newloc $newLoc<br />";
	mysqli_query($mysqli, "UPDATE users SET location='$newLoc' WHERE username=' Jack Frost' LIMIT 1") or   die("UaCRO");

	  echo"d<br />";

	} else{
		mysqli_query($mysqli, "DELETE FROM users WHERE username=' Jack Frost' LIMIT 1") or   die("UaCRO");
    	mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Jack Frost' LIMIT 1") or   die("UaCRO");
	}

}else{
	mysqli_query($mysqli, "DELETE FROM users WHERE username=' Jack Frost' LIMIT 1") or   die("UaCRO");
    mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Jack Frost' LIMIT 1") or   die("UaCRO");
}
## END JACK FROST EVENT


### EASTER EVENT
$easter = date("d", easter_date()) + 1 - 1;
$easterOver = /*date("-m-") == '-04-' && */(date("d") + 1 - 1 == $easter+2);
//$easterOver = date("-m-d") == '-04-10';
if(isEaster() || $easterOver)
{
    $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username=' Easter Bunny' LIMIT 1");
	$aantal = mysqli_num_rows($resultaeat);

	if($aantal<1){
	//	echo"begin in first if<br />";
		if(!$easterOver){

		//Spawn Easter Bunny
	 	$sql = "INSERT INTO users (username, password, online)
				VALUES (' Easter Bunny', 'DSDSA342423', '1')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");
		/*$sql = "INSERT INTO items_wearing (username, name, type)
				VALUES (' Jack Frost', 'Frost hat', 'helm'),
                (' Jack Frost', 'Frost shield', 'shield'),
                (' Jack Frost', 'Frost vest', 'body'),
                (' Jack Frost', 'Frost staff', 'hand'),
                (' Jack Frost', 'Frost legs', 'legs'),
                (' Jack Frost', 'Frost gloves', 'gloves'),
                (' Jack Frost', 'Frost shoes', 'shoes')";
    	mysqli_query($mysqli, $sql) or die("erroraa report this bug");*/

    	}

		//	 echo"done in first if<br />";
	}else{
		//Rewards (Easter Bunny was already around)

	//	echo"..<br />";
        $previousWinner="''";
        $chatLine='';
        $rewardedUsers = 0;
        $currentLocation = '';
		while ($record2 = mysqli_fetch_object($resultaeat))
    	{
            $currentLocation=$record2->location;
    		//	echo"IN<br />";

			for($i=1;$i<=3;$i++){
				//Pick a user, and reward him/her
				$user='';

				$resultaat = mysqli_query($mysqli, "SELECT users.username as usern FROM users_junk, users WHERE users.username=users_junk.username &&" .
                    " users.online=1 && users.location='$record2->location' && users_junk.eventField='eb' && users.username NOT IN ($previousWinner) ORDER BY RAND() LIMIT 1");
				while ($rec = mysqli_fetch_object($resultaat)) { $user=$rec->usern; }

				if($user){
                    $rewardedUsers++;

                    if($rewardedUsers == 1)
                    {
                        ### ADD CHAT MESSAGE
                        $SystemMessage = 1;$moderator=1;
                        $chatMessage = "For their efforts in stealing The Easter Bunny's prized possessions at $record2->location, the following players were rewarded:";
                        $channel = 0;
                        include (GAMEPATH . "/scripts/chat/addchat.php");
                        ### EINDE CHAT MESSAGE
                    }

					$rand=rand(1,22);
                    $getMuch = 1;

                    switch($rand)
                    {
                        case 1:
                            $get = "Locked wooden egg";
                            $getMuch = 1;
                            break;

                        case 2:
                            $get="Red easter egg";
                            $getMuch = 100;
                            break;

                        case 3:
                        case 4:
                            $get="Green easter egg";
                            $getMuch = 50;
                            break;

                        case 5:
                        case 6:
                            $get="Blue easter egg";
                            $getMuch = 40;
                            break;

                        case 7:
                        case 8:
                            $get="Yellow easter egg";
                            $getMuch = 30;
                            break;

                        case 9:
                        case 10:
                            $get="White easter egg";
                            $getMuch = 25;
                            break;

                        case 11:
                        case 12:
                            $get="Black easter egg";
                            $getMuch = 25;
                            break;

                        case 13:
                        case 14:
                            $get="Pink easter egg";
                            $getMuch = 25;
                            break;

                        case 15:
                        case 16:
                            $get="Orange easter egg";
                            $getMuch = 20;
                            break;

                        case 17:
                        case 18:
                            $get="White easter egg";
                            $getMuch = 20;
                            break;

                        case 19:
                            $get="Bronze easter egg";
                            $getMuch = 5;
                            break;

                        case 20:
                            $get="Silver easter egg";
                            $getMuch = 5;
                            break;

                        case 21:
                            $get="Gold easter egg";
                            $getMuch = 5;
                            break;

                        case 22:
                            $get="White rabbit";
                            $getMuch = 1;
                            break;
                    }

					$resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
					while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }

					addItem("$user", $get, $getMuch, $gettype, '', '', 0);

					$chatLine="$user got $getMuch $get" . ($getMuch == 1 ? "" : "s") . ".";
                    $SystemMessage = 1; $moderator=1;
                    $chatMessage = "$chatLine";
                    $channel = 0;
                    include (GAMEPATH . "/scripts/chat/addchat.php");
					$previousWinner.=",'$user'";
				}else if($rewardedUsers > 0){
					$chatLine="No other players got a reward, as they didn't meet the criteria.";
                    $SystemMessage = 1; $moderator=1;
                    $chatMessage = "$chatLine";
                    $channel = 0;
                    include (GAMEPATH . "/scripts/chat/addchat.php");
					$i=9;
				}
			}
			if($rewardedUsers > 0){
				$chatLine="";
			}else{
				$chatLine="No players were rewarded! No players annoyed The Easter Bunny and were at the same location.";
			}
			if($chatLine){
				### ADD CHAT MESSAGE
			    $SystemMessage = 1; $moderator=1;
			    $chatMessage = "$chatLine";
			    $channel = 0;
			    include (GAMEPATH . "/scripts/chat/addchat.php");
			    ### EINDE CHAT MESSAGE
			}
		}//SQL witch
		//	echo"@<br />";
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='' WHERE eventField NOT IN ('!eb1', '!eb2', '!eb3')") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!eb4' WHERE eventField = '!eb3'") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!eb3' WHERE eventField = '!eb2'") or die("err1");
		mysqli_query($mysqli, "UPDATE users_junk SET eventField='!eb2' WHERE eventField = '!eb1'") or die("err1");

        if($rewardedUsers > 0 && !DEBUGMODE)
        {
            mysqli_query($mysqli, "UPDATE users_junk SET eventField='!eb1' WHERE username IN ($previousWinner)") or die("err1");
        }
	//		echo"$<br />";
	}//witch was around, rewards
	//echo"a<br />";

	if(!$easterOver){

    $currentIslandID = 0;
    if($currentLocation != '')
    {
        $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaeat))
        {
            $currentIslandID=$record->mapNumber;
        }
    }

    //Stop The Easter Bunny from going to the same island twice
    $ISLAND_NR = $currentIslandID;
    while($ISLAND_NR == $currentIslandID)
    {
        $rand=rand(1,100);
        if($rand<=5){
            $ISLAND="Mezno island";
            $ISLAND_NR=4;
        }else if($rand<=15){
            if(rand(1,4) == 1)
            {
                $ISLAND="Anasco island";
                $ISLAND_NR=19;
            }
            else
            {
                $ISLAND="Kanzo island";
                $ISLAND_NR=15;
            }
        }else if($rand<=25){
            $ISLAND="Exrollia";
            $ISLAND_NR=17;
        }else if($rand<=35){
            $ISLAND="Webbers island";
            $ISLAND_NR=18;
        }else if($rand<=50){
            if(rand(1,2) == 1)
            {
                $ISLAND="Ogre cave";
                $ISLAND_NR=5;
            }
            else
            {
                $ISLAND="Elven island";
                $ISLAND_NR=6;
            }
        }else if($rand<=65){
            $ISLAND="Serpenthelm island";
            $ISLAND_NR=16;
        }else if($rand<=75){
            $ISLAND="Dearn island";
            $ISLAND_NR=2;
        }else if($rand<=90){
            $ISLAND="Remer island";
            $ISLAND_NR=1;
        }else {
            $ISLAND="Skull island";
            $ISLAND_NR=7;
        }
    }

//echo"b<br />";

	 ### ADD CHAT MESSAGE
    $SystemMessage = 1;$moderator=1;
	$chatMessage = "The Easter Bunny was spotted hopping to $ISLAND.";
    $channel = 0;
    include ("../theGame/scripts/chat/addchat.php");
    ### EINDE CHAT MESSAGE
echo"c<br />";
    $resultaeat = mysqli_query($mysqli, "SELECT locationName FROM locationinfo WHERE mapNumber='$ISLAND_NR' ORDER BY RAND() LIMIT 1");
    while ($record = mysqli_fetch_object($resultaeat))
    {
		$newLoc=$record->locationName;
    }
    echo"newloc $newLoc<br />";
	mysqli_query($mysqli, "UPDATE users SET location='$newLoc' WHERE username=' Easter Bunny' LIMIT 1") or   die("UaCRO");

	  echo"d<br />";

	} else{
		mysqli_query($mysqli, "DELETE FROM users WHERE username=' Easter Bunny' LIMIT 1") or   die("UaCRO");
    	mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Easter Bunny' LIMIT 1") or   die("UaCRO");
	}

}else{
	mysqli_query($mysqli, "DELETE FROM users WHERE username=' Easter Bunny' LIMIT 1") or   die("UaCRO");
    mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username=' Easter Bunny' LIMIT 1") or   die("UaCRO");
}
## END EASTER EVENT




	$resultaat = mysqli_query($mysqli, "SELECT ID FROM chatbuffer ORDER BY ID DESC LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat))
	{
		$MSGID=$record->ID-50;
		mysqli_query($mysqli, "DELETE FROM chatbuffer WHERE ID<'$MSGID'") or   die("UaCRO");

	}



	echo ".";
    $endTime = time();
    $totalTime = $endTime - $beginTime;
    mysqli_query($mysqli, "DELETE FROM  bugreports WHERE ID='$CRONJOBID' LIMIT 1") or   die("UaCRO");


    echo "..$totalTime seconds<br/>";


} else
{
    echo ",";
}
?>
End