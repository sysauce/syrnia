<?
if(defined('AZtopGame35Heyam')){

include_once('includes/levels.php');

function jailLocation(){
	global $S_mapNumber, $S_side;

	if($S_mapNumber==1){
	 	$loc='Sanfew';
	}else if($S_mapNumber==2){
	 	$loc='Unera';
	}else if($S_mapNumber==3 OR $S_mapNumber==14){ //OL
	 	$loc='Elven gate';
	}elseif($S_mapNumber==4){
	 	$loc='Xanso';
	}elseif($S_mapNumber==5){
	 	$loc='Ogre camp';
	}elseif($S_mapNumber==6){
	 	$loc='Elven gate';
	}elseif($S_mapNumber==7){
	 	$loc='Skulls nose';
	}elseif($S_mapNumber==8){
	 	$loc='Port party'; }
	else if($S_mapNumber==9 OR $S_mapNumber==10 OR $S_mapNumber==11 OR $S_mapNumber==12 OR $S_mapNumber==13 OR $S_mapNumber==20 OR $S_mapNumber==21){
	 	$loc='Heerchey manor';
	}else if($S_mapNumber==15){
	 	$loc='Kanzo';
	}else if($S_mapNumber==16){
	 	$loc='Rose gates';
	}else if($S_mapNumber==17){
	 	$loc='Port Calviny';
	}else if($S_mapNumber==18){
	 	$loc='Web haven';
	}else if($S_mapNumber==19){
	 	$loc='Thabis';

		 //Should never get here:
	}else if($S_side=='Pirate'){
	 	$loc='Crab nest';
	}else{
	 	$loc='Lisim';
	}

	return $loc;

}


function thieve($var1, $var2, $var3){

 	global $mysqli, $S_user, $S_location, $S_mapNumber, $S_donation, $levelArray;
 	$timee=time();

    $halloween = isHalloween();
    $xmas = isXmas();
    $easter = isEaster();

 	$thievingl=$levelArray['thieving']['level'];

 	//var1=[player OR shop or shopgold]

	$resultt = mysqli_query($mysqli, "SELECT ID FROM locations WHERE monstersmuch>0 && (type='invasion' || type='skillevent') && location='$S_location' && startTime<'$timee' LIMIT 1");
	$invasions = mysqli_num_rows($resultt);

    $guildJob = false;
	if($invasions && $var2 != ' Halloween witch' && $var2 != ' Jack Frost' && $var2 != ' Easter Bunny'){ #### INVASION!!

        $resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE jobname='Thieving guild' && timelimit>'$timee' && username='$S_user' && completed=0 && dump='$var2' LIMIT 1");
        $aantal = mysqli_num_rows($resultaaat);
        if($aantal==0)
        {
            $output.="It's not the right time to thieve...<br /><a href='' onClick=\"updateCenterContents('loadLayout', '-');return false;\">Click here to discover what is going on.</a>";

            $output=str_replace('"', '\\"', $output);
            echo "$('LocationContent').innerHTML=\"$output\";";
            exit();
        }
        else
        {
            $guildJob = true;
        }
	}

    if(stristr($S_location, "Lost caves"))
    {
        $resultaat = mysqli_query($mysqli, "SELECT username FROM users_junk WHERE partyIslandSailLocation='Heerchey manor' AND username='$S_user' LIMIT 1");
        $canThieve = mysqli_num_rows($resultaat) == 0;

        if(!$canThieve)
        {
            $output.= "Your guide from Heerchey advises you not to try stealing from people helping the Heerchey family.<br/>" .
                " <a href='' onclick=\"updateCenterContents('move', 'Heerchey manor');return false;\">OK, take me back to Heerchey manor</a><br/><br/>";
            $output=str_replace('"', '\\"', $output);
            echo "$('LocationContent').innerHTML=\"$output\";";
            exit();
        }
    }


	###########
	## PLAYER THIEVING
	if($var1=='player' && $var2){
	 	$victim=$var2;
		if(strtoupper($victim)==strtoupper($S_user) OR strtoupper($victim)=='M2H' OR $S_mapNumber<1 OR $S_mapNumber==3 OR $S_mapNumber==14){
			return;
		}

        $continue = true;

        if(($halloween || $xmas || $easter) && $S_location == jailLocation() && $var2 != ' Halloween witch' && $var2 != ' Jack Frost' && $var2 != ' Easter Bunny')
        {
            $eventNPC = "";
            if($halloween)
            {
                $eventNPC = " Halloween witch";
            }
            else if($xmas)
            {
                $eventNPC = " Jack Frost";
            }
            else if($easter)
            {
                $eventNPC = " Easter Bunny";
            }
            $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username='$eventNPC' LIMIT 1");
            while ($record = mysqli_fetch_object($resultaeat))
            {
                $currentLocation = $record->location;
            }

            if($currentLocation)
            {
                $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
                while ($record = mysqli_fetch_object($resultaeat))
                {
                    $currentIslandID=$record->mapNumber;
                }

                if($currentIslandID == $S_mapNumber && !$guildJob)
                {
                    $output .= "Stop trying to spoil the holiday! :D";

                    $continue = false;
                }
            }
        }

        $resultt = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && (work='move' OR work='sail')  LIMIT 1");
        $aana = mysqli_num_rows($resultt);
        if($aana >= 1)
        {
            $output.="$victim is no longer at this location.";
        }

        if($continue)
        {
            $resultaat = mysqli_query($mysqli,"SELECT thieving, gold FROM users WHERE location='$S_location' && username='$victim' LIMIT 1" );
            while ($record = mysqli_fetch_object($resultaat))
            {
                $atSameLocation=1;

                $thievingll=floor(pow($record->thieving, 1/3.507655116));
                $thievingratio=$thievingl-$thievingll+5;

                if($thievingratio<0){$thievingratio=0; }
                if($thievingratio>90){$thievingratio=90; }

                $pak=rand(0,100);
                if($record->gold<>0){
                    $goldpak=floor((rand(0,$thievingratio)/100)*$record->gold);
                } else {
                    $goldpak=0; $golder=1;
                }

                $resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE jobname='Thieving guild' && timelimit>'$timee' && username='$S_user' && completed=0 && dump='$victim' LIMIT 1");
                $aantal = mysqli_num_rows($resultaaat);
                if($aantal==1){
                    $timee=time();
                    $output.="<font color=green><B>You successfully thieved by order of the thieving guild.</font></b><BR>";
                    mysqli_query($mysqli,"UPDATE quests SET completed=1, timelimit=timelimit-'$timee' WHERE username='$S_user' && jobname='Thieving guild' LIMIT 1") or die("err2or --> 1");
                }

                $thievingEXP=20;

                if($victim==" Halloween witch")
                {
                    $pak=rand(1,10)-4;
                    $thievingratio=-2;//80% kans op fail - 120 sec jailtime
                    $thievingEXP=3;

                    mysqli_query($mysqli, "UPDATE users_junk SET eventField='witch' WHERE username='$S_user' AND eventField NOT LIKE '!witch%' LIMIT 1") or die("err1");
                }
                else if($victim==" Jack Frost")
                {
                    $pak=rand(1,10)-4;
                    $thievingratio=-2;//80% kans op fail - 120 sec jailtime
                    $thievingEXP=3;

                    mysqli_query($mysqli, "UPDATE users_junk SET eventField='jf' WHERE username='$S_user' AND eventField NOT LIKE '!jf%' LIMIT 1") or die("err1");
                }
                else if($victim==" Easter Bunny")
                {
                    $pak=rand(1,10)-4;
                    /*if(DEBUGMODE)
                    {
                        $pak = rand(-10, 0);
                    }*/
                    $thievingratio=-2;//80% kans op fail - 120 sec jailtime
                    $thievingEXP=3;

                    mysqli_query($mysqli, "UPDATE users_junk SET eventField='eb' WHERE username='$S_user' AND eventField NOT LIKE '!eb%' LIMIT 1") or die("err1");
                }

                if($pak>$thievingratio){ //Failed
                    $jailsec=($thievingratio*15+150);
                    if($jailsec>6*3600){$jailsec=6*3600; }
                    $output.="<b>You have been caught thieving $victim!</b><BR>";
                    $output.="You are sent to jail for $jailsec seconds.<BR>";
                    $output.="<a href='' onClick=\"updateCenterContents('loadLayout', '-');return false;\">Click here to continue.</a>";
                    //echo "setTimeout(updateCenterContents('loadLayout', '-'),2000);";
                    echo "document.getElementById('centerPlayerList').innerHTML = '';";

                    /*if(DEBUGMODE && ($victim==" Halloween witch" || $victim==" Jack Frost" || $victim==" Easter Bunny"))
                    {
                        $workt=time()+10;
                    }
                    else
                    {
                    $workt=time()+$jailsec;
                    }*/

                    $workt=time()+$jailsec;
                    $jailLoc=$S_location;
                    $S_location=jailLocation();


                    mysqli_query($mysqli, "UPDATE users SET work='jail', location='$S_location', worktime='$workt', dump2='Thieving $victim at $jailLoc', dump='', thieving=thieving+5 WHERE username='$S_user' LIMIT 1") or die("err1");
                    include_once('mapData.php');
                    $levelArray=addExp($levelArray, 'thieving', 5);

                    $sql = "INSERT INTO messages (username, sendby, message, topic, time)
                      VALUES ('$victim', '<B>Syrnia</b>', '$S_user tried to thieve you at $jailLoc, but was caught on the crime scene and has been sent to jail for $jailsec seconds.', 'Thief attempt', '$timee')";
                    mysqli_query($mysqli, $sql) or die("error report this 543fd");

                }else {   #

                    //Event thieving
                    if($victim == " Halloween witch")
                    {
                        $get=rand(1,100);
                        if($get<=5){ $get="Halloween pumpkin";  $getmuch=1;
                        }elseif($get<=10){  $get="Beryl";  $getmuch=rand(1,1);
                        }elseif($get<=20){  $get="Eggplant seeds"; $getmuch=rand(4,5);
                        }elseif($get<=30){  $get="Cucumber seeds"; ; $getmuch=rand(1,5);
                        }elseif($get<=40){  $get="Cooked Cod";  $getmuch=rand(1,22);
                        }elseif($get<=45){  $get="Amber";  $getmuch=rand(1,1);
                        }elseif($get<=55){  $get="Pumpkin seeds";  $getmuch=rand(2,4);
                        }elseif($get<=100){  $get="Burnt Frog";  $getmuch=rand(1,2);
                        }

                        $resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
                        while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }
                        addItem($S_user, $get, $getmuch, $gettype, '', '', 1);

                        $output.="<br />You have successfully thieved the halloween witch.<br />You stole $getmuch $get from her.<BR>";
                        $output.="<a href='' onclick=\"thieving('player','$victim','');return false;\">Thief her again</a>";

                    }
                    else if($victim == " Jack Frost")
                    {
                        $get=rand(1,100);
                        if($get<=1){ $get="Santa hat";  $getmuch=1;
                        }elseif($get<=10){  $get="Garnet";  $getmuch=rand(1,1);
                        }elseif($get<=20){  $get="Apple seeds"; $getmuch=rand(4,5);
                        }elseif($get<=30){  $get="Cucumber seeds"; ; $getmuch=rand(5,5);
                        }elseif($get<=40){  $get="Cooked Cod";  $getmuch=rand(10,20);
                        }elseif($get<=45){  $get="Amber";  $getmuch=rand(1,1);
                        }elseif($get<=55){  $get="Pear seeds";  $getmuch=rand(4,5);
                        }elseif($get<=100){  $get="Coal";  $getmuch=rand(1,2);
                        }

                        $resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
                        while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }
                        addItem($S_user, $get, $getmuch, $gettype, '', '', 1);

                        $output.="<br />You have successfully thieved Jack Frost.<br />You stole $getmuch $get from him.<BR>";
                        $output.="<a href='' onclick=\"thieving('player','$victim','');return false;\">Thief him again</a>";
                    }
                    else if($victim == " Easter Bunny")
                    {
                        $get=rand(1,1000);
                        if($get<=25){ $get="Locked wooden egg";  $getmuch=1;
                        }elseif($get<=50){ $get="Bronze easter egg";  $getmuch=1;
                        }elseif($get<=75){ $get="Silver easter egg";  $getmuch=1;
                        }elseif($get<=100){ $get="Gold easter egg";  $getmuch=1;
                        }elseif($get<=200){  $get="Amber";  $getmuch=rand(1,1);
                        }elseif($get<=300){  $get="Garnet";  $getmuch=rand(1,1);
                        }elseif($get<=400){  $get="Cucumber seeds"; ; $getmuch=rand(5,5);
                        }elseif($get<=500){  $get="Black easter egg";  $getmuch=rand(5,10);
                        }elseif($get<=600){  $get="White easter egg";  $getmuch=rand(5,10);
                        }elseif($get<=700){  $get="Pink easter egg";  $getmuch=rand(5,10);
                        }elseif($get<=800){  $get="Apple seeds"; $getmuch=rand(4,5);
                        }elseif($get<=900){  $get="Pear seeds";  $getmuch=rand(4,5);
                        }elseif($get<=950){  $get="Carrots";  $getmuch=rand(10,25);
                        }elseif($get<=1000){  $get="Red easter egg";  $getmuch=rand(1,10);
                        }

                        $resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
                        while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }
                        addItem($S_user, $get, $getmuch, $gettype, '', '', 1);

                        $output.="<br />You have successfully thieved The Easter Bunny.<br />You stole $getmuch $get from it.<BR>";
                        $output.="<a href='' onclick=\"thieving('player','$victim','');return false;\">Thieve it again</a>";
                    }
                    else
                    {//Normal thieving
                        if($golder==1){
                            $output.="<br />You have successfully thieved $victim, but they are not carrying any gold at the moment.<BR>";
                        }else {
                            $saaql = "INSERT INTO zlogs (titel, tekst, time)
                          VALUES ('$S_user thieved $victim', '$S_user thieved $victim and stole $goldpak gold', '$timee')";
                          mysqli_query($mysqli,$saaql) or die("D  1IE 2");
                            $output.="<br />You have successfully thieved $victim";
                            if($goldpak > 0)
                            {
                                $output .= ".<br />You stole $goldpak gold from $victim, without anyone seeing you do it.<BR>";
                            }
                            else
                            {
                                $output .= ", but you were unable to get any gold.<br/>";
                            }
                            $output.="<a href='' onclick=\"thieving('player','$victim','');return false;\">Thief $victim again</a>";
                            mysqli_query($mysqli, "UPDATE users SET gold=gold-'$goldpak' WHERE username='$victim' LIMIT 1") or die("err1");
                        }
                        getGold($S_user, $goldpak);
                    }

                    mysqli_query($mysqli, "UPDATE users SET thieving=thieving+$thievingEXP WHERE username='$S_user' LIMIT 1") or die("1or");
                    $levelArray=addExp($levelArray, 'thieving', $thievingEXP);
                }

                $output=str_replace('"', '\\"', $output);
                echo "$('LocationContent').innerHTML=\"$output\";";
                exit();
            }

            if($atSameLocation!=1){
                $output.="You could not thief $victim since $victim is not at $S_location (any more).";
                $output=str_replace('"', '\\"', $output);
                echo "$('LocationContent').innerHTML=\"$output\";";
                exit();
            }
        }
        else
        {
            $output=str_replace('"', '\\"', $output);
            echo "$('LocationContent').innerHTML=\"$output\";";
            exit();
        }

	######################
	//// SHOP GOLD THIEVING
	}else if($var1=='shopGold' && $var2){

	  $kassa=$var2;

		//var1=[player OR shop or shopgold]
 		//var2=$kassa
	   $sql = "SELECT username, gold, buildingclosed FROM buildings WHERE type='shop' && ID='$kassa' && location='$S_location' LIMIT 1";
	   $resultaat = mysqli_query($mysqli, $sql);
	   while ($record = mysqli_fetch_object($resultaat)) {
	   		$shop_closed = $record->buildingclosed;
		   $owner=$record->username;
		   $goldSHOP=$record->gold;
	   }
		if($owner && $owner<>$S_user && $shop_closed==0){
		    $sql = "SELECT location FROM users WHERE username='$owner' LIMIT 1";
		   $resultaat = mysqli_query($mysqli, $sql);
		   while ($record = mysqli_fetch_object($resultaat))
		   {
		       $ownerlocation=$record->location;
			}
		   $kanslukt=$thievingl;
		   if($kanslukt>99){$kanslukt=99;}
		   if($ownerlocation==$S_location){ $kanslukt=$kanslukt/5; }
		   $kans=rand(0,300);
		   if($kans<$kanslukt){

			   	$goldSHOP=rand(0,($goldSHOP*0.9));
				$output.="You have successfully thieved the shop and got $goldSHOP gold!<br />";
				getGold($S_user, $goldSHOP);
				mysqli_query($mysqli, "UPDATE users SET thieving=thieving+25 WHERE username='$S_user' LIMIT 1") or die("err1");
				$levelArray=addExp($levelArray, 'thieving', 25);
				mysqli_query($mysqli, "UPDATE buildings SET gold=gold-$goldSHOP WHERE type='shop' && ID='$kassa' && location='$S_location' LIMIT 1") or die("err1");

		   } else {
			   $jailtime=$goldSHOP/10;
		   		if($jailtime<900){$jailtime=900;}
		   		if($jailtime>1800){$jailtime=1800;}
		   		$jailtime=round($jailtime);

				$workt=time()+$jailtime;

				$thieveLoc=$S_location;
				$S_location=jailLocation();

				mysqli_query($mysqli,"UPDATE users SET work='jail', location='$S_location', worktime='$workt', dump2='Thieving the shop of $owner at $thieveLoc', dump='', thieving=thieving+5 WHERE username='$S_user' LIMIT 1") or die("err1");
				include_once('mapData.php');
				$levelArray=addExp($levelArray, 'thieving', 5);

				$sql = "INSERT INTO messages (username, sendby, message, time, topic)
				  VALUES ('$owner', '<B>Syrnia</b>', '$S_user tried to thieve your shops gold at $thieveLoc, but was caught on the crime scene and has been sent to jail for $jailtime seconds.', '$timee', 'Thief attempt')";
				mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

				$output.="You have been caught!<BR>";
				$output.="You are sent to jail for $jailtime seconds.<BR>";
				$output.="Click <a href='' onClick=\"updateCenterContents('loadLayout', '-');return false;\">here</a> to continue.<BR>";

		      }

		$output=str_replace('"', '\\"', $output);
		echo "$('LocationContent').innerHTML=\"$output\";";
		exit();
	}


	#######################
	///// SHOP ITEM THIEVING
	}elseif($var1=='shop' && $var1 && $var2){

	 $itemID=$var2;
	 $shop=$var3;

	## SHOP THIEVING
	$item='';
	   $sql = "SELECT much,name,price,type,  itemupgrade, upgrademuch FROM shops WHERE ID='$shop' && NR='$itemID' LIMIT 1";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat)) {
		    $itemAmount=$record->much;
		    $item=$record->name;
		    $price=$record->price;
		    $type=$record->type;
		    $upgrade=$record->itemupgrade;
		    $upgrademuch=$record->upgrademuch;

		    if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
			if($record->itemupgrade){
			  	$upg=" [$plus$record->upgrademuch $record->itemupgrade]";
			}else{
				$upg='';
			}
		}
	 if($itemAmount>0 && $item && $price>0 && is_numeric($price)){
		   $sql = "SELECT username, gold, buildingclosed FROM buildings WHERE type='shop' && ID='$shop' && location='$S_location' LIMIT 1";
		   $resultaat = mysqli_query($mysqli,$sql);
		   while ($record = mysqli_fetch_object($resultaat))
		   {
		   		$shop_closed=$record->buildingclosed;
	   			$owner=$record->username;
		   }
		    if($owner && $owner!=$S_user && $shop_closed==0){
			    $sql = "SELECT location FROM users WHERE username='$owner' LIMIT 1";
			   $resultaat = mysqli_query($mysqli,$sql);
			   while ($record = mysqli_fetch_object($resultaat)) {   $ownerlocation=$record->location;   }
			   $kanslukt=$thievingl*10;
			   $kansmislukt=$price*10;
			   if($ownerlocation==$S_location){ $kansmislukt=$price*5; }
			   $kans=rand(0,$kanslukt);
			if(($thievingl*100-900)<$price){$kans=0;}
			   if($kans>$kansmislukt){
			   //$resultaat = mysqli_query($mysqli, "SELECT username FROM items_inventory WHERE name='$item' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch' && username='$S_user' LIMIT 1");

				// $sql = "INSERT INTO items_inventory (username, name, much, type, itemupgrade, upgrademuch)
			    //     VALUES ('$S_user', '$item', '1', '$type', '$upgrade', '$upgrademuch')";
			   //   mysqli_query($mysqli,$sql) or die("erroraa report this bug");
				if($itemAmount>1){
					mysqli_query($mysqli, "UPDATE shops SET much=much-1 WHERE ID='$shop' && NR='$itemID' LIMIT 1") or die("error --> 4a1 TI 23");
				}else{
					mysqli_query($mysqli, "DELETE FROM shops WHERE ID='$shop' && NR='$itemID' LIMIT 1") or die("error --> 4a1 TI 23");
				}

				$output.="You have successfully thieved the $item!<br />";
				$output.="Click <a href='' onClick=\"locationText('shops', 'viewShop', '$shop');return false;\">here</a> to return to the shop.<BR>";
				$exp=floor($price/2);

				addItem($S_user, $item, 1, $type, $upgrade, $upgrademuch, 1);

				mysqli_query($mysqli,"UPDATE users SET thieving=thieving+'$exp' WHERE username='$S_user' LIMIT 1") or die("err1");
				$levelArray=addExp($levelArray, 'thieving', $exp);
			   } else {
					$jaily=($price*25);
					if($jaily>10800){ $jaily=10800; }
					$workt=time()+$jaily;

					$thieveLoc=$S_location;
					$S_location=jailLocation();

					mysqli_query($mysqli,"UPDATE users SET work='jail', location='$S_location', worktime='$workt', dump2='Thieving the shop of $owner at $thieveLoc', dump='', thieving=thieving+5 WHERE username='$S_user' LIMIT 1") or die("err1");
					$levelArray=addExp($levelArray, 'thieving', 5);
					include_once('mapData.php');

					$sql = "INSERT INTO messages (username, sendby, message, time, topic)
					  VALUES ('$owner', '<B>Syrnia</b>', '$S_user tried to thieve a $item $upg at your shop at $thieveLoc, but was caught on the crime scene and has been sent to jail for $jaily seconds.', '$timee', 'Thief attempt')";
					mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

					$output.="You have been caught!<BR>";
					$output.="You are sent to jail for ".$jaily." seconds.<BR>";
					$output.="Click <a href='' onClick=\"updateCenterContents('loadLayout', '-');return false;\">here</a> to continue.<BR>";


			   }

			   	$output=str_replace('"', '\\"', $output);
				echo "$('LocationContent').innerHTML=\"$output\";";
				exit();

		    }
	   }else{
		 	$output.="You could not attempt to thieve the item because it's not in the shop any more.<br />";
			$output.="Click <a href='' onClick=\"locationText('shops', 'viewShop', '$shop');return false;\">here</a> to return to the shop.<BR>";

			$output=str_replace('"', '\\"', $output);
			echo "$('LocationContent').innerHTML=\"$output\";";
			exit();
		}
	 }






}
}
?>