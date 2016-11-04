<?php
if ($pass == '134fe')
{
    ###############################
    ## ELK HOUR  (te vaak runnen: highscores refresh)
    ###############################

    $ip = $_SERVER['REMOTE_ADDR'];
    //GAMEURL, SERVERURL etc.
    require_once ("../currentRunningVersion.php");
    // Require the main game file.
    require_once (GAMEPATH . "includes/db.inc.php");

    $datum = date("d-m-Y H:i");
    $time = time();
    $timee = time();


    $beginTime = $timee;
    $saaql = "INSERT INTO bugreports (username, text, time, type)
	 	VALUES ('CRONJOB', 'CRONJOB2 NEVER ENDED!', '$beginTime', 'CRON')";
    mysqli_query($mysqli, $saaql) or die("Func Item add error 2, please report !");
	$CRONJOBID=$mysqli->insert_id;

    $dateH = date(Y_m_d_);
    ### AANMAKEN

    $i = 1;
    while ($i <= 19)
    { #WHILE

        $aap = DESC;

        if ($i == 1)
        {
            $order = farming;
        } elseif ($i == 2)
        {
            $order = mining;
        } elseif ($i == 3)
        {
            $order = smithing;
        } elseif ($i == 4)
        {
            $order = speed;
        } elseif ($i == 5)
        {
            $order = attack;
        } elseif ($i == 6)
        {
            $order = defence;
        } elseif ($i == 7)
        {
            $order = strength;
        } elseif ($i == 8)
        {
            $order = health;
        } elseif ($i == 10)
        {
            $order = speed;
        } elseif ($i == 11)
        {
            $order = level;
        } elseif ($i == 12)
        {
            $order = woodcutting;
        } elseif ($i == 13)
        {
            $order = constructing;
        } elseif ($i == 14)
        {
            $order = trading;
        } elseif ($i == 15)
        {
            $order = thieving;
        } elseif ($i == 16)
        {
            $order = fishing;
        } elseif ($i == 17)
        {
            $order = magic;
        } elseif ($i == 18)
        {
            $order = cooking;
        } else
        {
            $order = totalskill;
        }
        $outputNEWFORMAT = '';

        $rank = 0;

        

        if ($order <> 'totalskill' && $order <> 'level')
        {

            $sql = "SELECT username, $order FROM users WHERE work<>'freezed' && username<>'M2H' ORDER BY users.$order $aap LIMIT 1000";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {


                $exp = $record->$order;
                $orderl = floor(pow($exp, 1 / 3.507655116));

                $rank = $rank + 1;

                $outputNEWFORMAT .= "$record->username@$orderl@$exp
";

               
            }

        } elseif ($order == 'totalskill')
        {
            $sql = "SELECT totalskill, username, level, (mining+smithing+attack+defence+strength+speed+farming+health+magic+woodcutting+constructing+trading+thieving+fishing+cooking) AS exp FROM users WHERE username<>'M2H' && work<>'freezed' ORDER BY totalskill desc, exp DESC LIMIT 1000";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {


                $rank = $rank + 1;
                $level = $record->totalskill;

                $outputNEWFORMAT .= "$record->username@$level@$record->exp
";

                
            }

        } elseif ($order == 'level')
        {
            $sql = "SELECT level, username, (attack+defence+strength+health) AS exp FROM users WHERE username<>'M2H' && password<>'' ORDER BY level desc, exp desc LIMIT 1000";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {


                $rank = $rank + 1;
                $level = $record->$order;

                $outputNEWFORMAT .= "$record->username@$level@$record->exp
";
            }


        }



        ###
        $uur = date(H);
        $dateSLA = date(Y_m_d_);

        $file = "../logs/highscore/newformat/$dateSLA$order.php";
        if (!$file_handle = fopen($file, "w"))
        {
            echo "Cannot open file $file<BR>";
        }
        if (!fwrite($file_handle, $outputNEWFORMAT))
        {
            echo "Cannot write to file (Newf: $file)3<BR>";
        }
        fclose($file_handle);
        ####


        $i = $i + 1;
    } #WHILE

    #### AANMAKEN


    $endTime = time();
    $totalTime = $endTime - $beginTime;
    
    mysqli_query($mysqli, "DELETE FROM  bugreports WHERE ID='$CRONJOBID' LIMIT 1") or   die("UaCRO");



    echo ".";

} else
{
    echo ",";
}
?>