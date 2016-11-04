<?
if(defined('AZtopGame35Heyam')){

global $PARTYISLAND;
if(!$PARTYISLAND && $S_mapNumber==8 && $S_user!='M2H' && $S_user!='edwin'){
	mysqli_query($mysqli, "UPDATE users SET location=(SELECT partyIslandSailLocation FROM users_junk WHERE username='$S_user' LIMIT 1) WHERE username='$S_user'") or die("error --> 1113");
	/*mysqli_query($mysqli, "UPDATE users SET location='Crab nest', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side='Pirate'") or die("error --> 1113");
	mysqli_query($mysqli, "UPDATE users SET location='Port Senyn', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side!='Pirate'") or die("error --> 1113");*/
	include('includes/mapData.php');
	echo"updateCenterContents('loadLayout', 1);";
	exit();
}

$xmas = isXmas();

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('auction');return false;\"><font color=white>Auction house</a><BR>";

//if(date(dmY)=='05032008' OR date(dmY)=='04032008'){$output.="<a href='' onclick=\"locationText('visit');return false;\"><font color=white>Collect a gift</a><BR>"; }
//<a href=?p=pubs><font color=white>Visit the party pub</a><BR>";
//if(date(jn)=='134' OR date(jn)=='144'  OR date(jn)=='154' OR date(jn)=='164'    ){$output.="<a href=?p=visit><font color=white>Visit the easter bunny</a><BR>"; }
if($xmas)
{
    $output.="<a href='' onclick=\"locationText('visit');return false;\"><font color=white>Visit Santa</a><BR>";
    $output.="<a href='' onclick=\"locationText('adoptareindeer');return false;\"><font color=white>Adopt a reindeer</a><BR>";
}

//if(date(jn)=='53' OR date(jn)=='13' && $S_user=='M2H'){$output.="<a href=?p=stats><font color=white>Syrnia statistics</a><BR>"; }
if(date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30' ){
 	$output.="<br/>";
 	$output.="<a href='?fight=$S_location'><font color=white>Fight a halloween monster (4+)</a><BR>";
 	$output.="<a href=?p=tricktreat><font color=white>Trick or Treat present</a><BR>";
}
$output.="<BR>";



} elseif($locationshow=='LocationText'){


if($action=='auction'){

 include('textincludes/auction.php');

}elseif($action=='tradingpost'){

	include('textincludes/trading.php');

}elseif($action=='stats'  && $notDisabled){
					$sql = "SELECT ID FROM auctions ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $auctions=$record->ID; }

					$sql = "SELECT ID FROM buildings ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $buildings=$record->ID; }

					$sql = "SELECT ID FROM clannews ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $clannews=$record->ID; }

					$sql = "SELECT ID FROM clans ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $clans=$record->ID; }

				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM clans");
				$clansnu= mysqli_num_rows($resultaaat);

				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM farms");
				$seeds= mysqli_num_rows($resultaaat);

				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM farms WHERE dump='fail'");
				$rotten= mysqli_num_rows($resultaaat);

					$sql = "SELECT ID FROM forumtopics ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $topics=$record->ID; }

					$sql = "SELECT ID FROM forummessages ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $forummessages=$record->ID; }

				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM pvp WHERE text like '% killed %'");
				$kills=  mysqli_num_rows($resultaaat);


					$sql = "SELECT ID FROM tradingpost ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $trades=$record->ID; }

					$sql = "SELECT ID FROM tradingpostitems ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $tradeitems=$record->ID; }

					$sql = "SELECT ID FROM users ORDER BY ID DESC LIMIT 1";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) { $S_users=$record->ID; }

						$output.="Syrnia is running exacly 2 year today.<BR>
						<BR>
						We have had $S_users registrations.<BR>
						There have been $auctions auctions.<BR>
						$buildings shops and houses have been built.<BR>
						$clans clans have been made, $clansnu still exist.<BR>
						Clans have posted $clannews news items.<BR>
						<br/>
						At the moment there are $seeds farms which have planted seeds....at least $rotten of them will be rotten.<BR>
						There have been $topics forum topics, containing $forummessages messages.<BR>
						There were $kills kills in the outlands.<BR>
						It took $trades trades to trade $tradeitems items at the tradingposts.<BR>
						<BR>";



}elseif($p==2 && $p=='pubs'){

			## PUB
			$chat='pub';

			$output.="Everbybody greets you when entering the pub: \"Welcome back to the party pub!<BR> Enjoy yourself, do you want a drink?\"<BR>";
			if($buy){$cost=0;
			if($buy=='Beer'){$cost=6; $much=3;}
			$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && gold>=$cost LIMIT 1");
			$aantal = mysqli_num_rows($resultaaat);
			if($cost>0){

			if(payGold($S_user, $cost)==1){
			$resultaat = mysqli_query($mysqli,  "SELECT username FROM inventory WHERE name='$buy' && username='$S_user' LIMIT 1");
			   $aantal = mysqli_num_rows($resultaat);
			if($aantal==1){
			mysqli_query($mysqli, "UPDATE inventory SET much=much+3 WHERE name='$buy' && username='$S_user' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
			} else{
			 $sql = "INSERT INTO inventory (username, name, much, type)
			         VALUES ('$S_user', '$buy', '3', 'cooked food')";
			      mysqli_query($mysqli, $sql) or die("erroraa report this bug");
			}
			$output.="Here's your $buy!<BR>";
		}
			}
			}
		//	$output.="<BR>Drinks:<BR>
		//	-<a href='".SERVERURL."/?p=pub&buy=Beer'>Buy</a> 3 beers (6 gold)<BR>
		//	<BR>";

}elseif($p=='tricktreat'){
$event='halloween2007';

$sql = "SELECT joined FROM users WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }

$resultaat = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$S_user' LIMIT 1" );
while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }

if($memberfor>=2){

    $resultaat = mysqli_query($mysqli,  "SELECT username FROM votes WHERE username='$S_user' && datum='$event' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
    if($aantal==1){
   		$output.="You've already recieved your Trick or Treat, come back next year.<br/>";
      }else{

	   if($givepresent){


$get=rand(1,3);
if($get==1){
	$get=rand(1,3);
	if($get==1){  $get="Burnt Frog"; $gettype="Burnt food"; $getmuch=1;
	}elseif($get==2){  $get="Rocks"; $gettype="ore"; $getmuch=2;
	}elseif($get==3){  $get="Burnt Shrimps"; $gettype="Burnt food"; $getmuch=2;
	}
	$output.="Ouch...<B>Trick!<B><br/>";
}else{
	$get=rand(1,7);
	if($get==1){  $get="Amber"; $gettype="gem"; $getmuch=1;
	}elseif($get==2){  $get="Blue gift"; $gettype="open"; $getmuch=1;
	}elseif($get==3){  $get="Locked toolbox"; $gettype="locked"; $getmuch=1;
    }elseif($get==4){  $get="Red gift"; $gettype="open"; $getmuch=1;
    }elseif($get==5){  $get="Green gift"; $gettype="open"; $getmuch=1;
    }elseif($get==6){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=10;
    }elseif($get==7){  $get="Halloween pumpkin"; $gettype="cooked food"; $getmuch=1;
	}
	$output.="Great...<B>Treat!<B><br/>";
}


 $sql = "INSERT INTO votes (datum, username, site)
         VALUES ('$event', '$S_user', '$S_realIP')";
      mysqli_query($mysqli, $sql) or die("erroraa report this bug");

if($get=='Gold'){
	getGold($S_user, $getmuch);
} elseif($get){
     $resultaat = mysqli_query($mysqli,  "SELECT username FROM inventory WHERE name='$get' && itemupgrade='' && username='$S_user' LIMIT 1");
   $aantal = mysqli_num_rows($resultaat);
if($aantal==1){
mysqli_query($mysqli, "UPDATE inventory SET much=much+'$getmuch' WHERE name='$get' && username='$S_user' LIMIT 1") or die("error --> 4a123");
} else{
 $sql = "INSERT INTO inventory (username, name, much, type)
         VALUES ('$S_user', '$get', '$getmuch', '$gettype')";
      mysqli_query($mysqli, $sql) or die("erroraa report this bug");
}
}
$output.="<font color=green>Your halloween present is: <font color=red>$getmuch $get!</font></font><BR>
<BR>
</B>";

}else{
 $output.="Halloween presents are given here. You can not choose what you get, but beware, you won't like all of the possible presents...<br/>
 There are tricks and there are treats, which one will you get ?<br/>
 <br/>
 <a href=/index2_main.php?p=tricktreat&givepresent=1>Give me my present</a><br/>";
}

   }    # NOG NIET GEZETE
}else{ $output.="Sorry, only people who've played for a while are allowed in this event, please come back next time.<br/>";  }






}elseif($action=='visit'){
/////VISIT



$event= "santa" . date("Y");

$aantal='a';
$resultaat = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$S_user' LIMIT 1" );
while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }


	if(date(jn)=='134' OR date(jn)=='144' OR date(jn)=='154'   OR date(jn)=='164' ){
		$presentGiver='the easter bunny';
	}elseif($xmas){
		$presentGiver='Santa';
	}else{
		$presentGiver='Syrnia';
	}

if($presentGiver){
	if($memberfor>=2){

    $resultaat = mysqli_query($mysqli,  "SELECT username FROM votes WHERE username='$S_user' && datum='$event' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
    if($aantal==1){
     	$output.="You already got a gift, remember?<BR>";
   		//$output.="You already visited $presentGiver, remember?<BR>";
		//$output.="Now please move away to make room for other people who want to sit on the $presentGiver's lap.<BR>";
    }else{
      	if($var1==''){
   			$output.="You have not visited $presentGiver yet.<BR>";
   			$output.="Do you want to sit on his lap?<BR>";

   			//$output.="You can collect a free gift because of Syrnias birthday.<br />";
   			//$output.="Choose wisely.<br />";
			 $output.="<a href='' onclick=\"locationText('visit', 'sit');return false;\">Choose a gift</a><BR>";
		}else{
$get=$var2;
if($get>0 && $get<=5){

if($get==1){
$get=rand(1,9);
if($get==1){  $get="Diamond"; $gettype="gem"; $getmuch=1;
}elseif($get==2){  $get="Garnet"; $gettype="gem"; $getmuch=1;
}elseif($get==3){  $get="Beryl"; $gettype="gem"; $getmuch=2;
}elseif($get==4){  $get="Spar"; $gettype="gem"; $getmuch=1;
}elseif($get==5){  $get="Avril"; $gettype="gem"; $getmuch=2;
}elseif($get==6){  $get="Amber"; $gettype="gem"; $getmuch=2;
}elseif($get==7){  $get="Moonstone"; $gettype="gem"; $getmuch=2;
}elseif($get==8){  $get="Quartz"; $gettype="gem"; $getmuch=1;
}elseif($get==9){  $get="Diaspore"; $gettype="gem"; $getmuch=2;}

}elseif($get==2){
$get=rand(1,6);
if($get==1){  $get="Cooked Sardine"; $gettype="cooked food"; $getmuch=1000;
}elseif($get==2){  $get="Cooked Pike"; $gettype="cooked food"; $getmuch=500;
}elseif($get==3){  $get="Cooked Salmon"; $gettype="cooked food"; $getmuch=500;
}elseif($get==4){  $get="Cooked Tuna"; $gettype="cooked food"; $getmuch=500;
}elseif($get==5){  $get="Cooked Swordfish"; $gettype="cooked food"; $getmuch=400;
}elseif($get==6){  $get="Cooked Shark"; $gettype="cooked food"; $getmuch=300;}

}elseif($get==3){
$getmuch=rand(500,1500);  $get="Wood"; $gettype='item';

}elseif($get==4){
$get=rand(1,4);
if($get==1){  $get="Iron ore"; $gettype="ore"; $getmuch=500;
}elseif($get==2){  $get="Coal"; $gettype="ore"; $getmuch=500;
}elseif($get==3){  $get="Silver"; $gettype="ore"; $getmuch=400;
}elseif($get==4){  $get="Gold ore"; $gettype="ore"; $getmuch=250;}

}elseif($get==5){
$get=rand(1,6);
if($get==1){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=400; }
elseif($get==2){  $get="Green pepper seeds"; $gettype="seeds"; $getmuch=400; }
elseif($get==3){  $get="Spinach seeds"; $gettype="seeds"; $getmuch=400; }
elseif($get==4){  $get="Eggplant seeds"; $gettype="seeds"; $getmuch=400; }
elseif($get==5){  $get="Cucumber seeds"; $gettype="seeds"; $getmuch=400; }
elseif($get==6){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=400; }

}elseif($get==6){
$get=rand(1,1);
if($get==1){  $get="Kanzo teleport orb"; $gettype="magical"; $getmuch=1;
}

}

//Safety; if item is in items DB already, overwrite the TYPE
$sql = "SELECT type FROM items WHERE name='$get' LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { 	$gettype=$record->type; }


 $sql = "INSERT INTO votes (datum, username, site)
         VALUES ('$event', '$S_user', '$S_realIP')";
      mysqli_query($mysqli, $sql) or die("erroraa report this bug");

if($get=='Gold'){
	getGold($S_user, $getmuch);
} elseif($get){
 	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
}
$output.="<font color=green>$presentGiver gave you <font color=red>$getmuch $get!</font></font><BR>";
$output.="<BR>";
$output.="<b><i>We hope to see you again next year!</i></B>";

}else{
	$output.="<i>\"Hello $S_user!<br />";
	$output.="You have been playing Syrnia for almost $memberfor days now, can you believe it?\"</i><BR>";
	$output.="<BR>";

	//$output.="You sit on $presentGiver's lap, and tell him that you are so glad to see him.<BR>";
	//$output.="He asks you: what present would you like this year?.<BR>";
	$output.="What present would you like this year?<BR>";

	$output.="<br />";

	$output.="<a href='' onclick=\"locationText('visit', 'sit', 1);return false;\">Some shiny rocks</a><BR>";
	$output.="<a href='' onclick=\"locationText('visit', 'sit', 2);return false;\">Some yummy food</a><BR>";
	$output.="<a href='' onclick=\"locationText('visit', 'sit', 3);return false;\">Some building materials</a><BR>";
	$output.="<a href='' onclick=\"locationText('visit', 'sit', 4);return false;\">Some ores</a><BR>";
	$output.="<a href='' onclick=\"locationText('visit', 'sit', 5);return false;\">Some seeds for the garden</a><BR>";
	//$output.="<a href='' onclick=\"locationText('visit', 'sit', 6);return false;\">1 Kanzo teleport orb</a><BR>";
	$output.="<BR>";
}


   }    # NOG NIET GEZETE
   }
}else{
  	$output.="Only players who are registered for a few days can visit Santa.<br />";
}
}else{
 	$output.="There is no spoon!";
}


}
else if($action=='adoptareindeer')
{
$event= "reindeer" . date("Y");

$aantal='a';
$resultaat = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$S_user' LIMIT 1" );
while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }


	if(date(jn)=='134' OR date(jn)=='144' OR date(jn)=='154'   OR date(jn)=='164' ){
		$presentGiver='the easter bunny';
	}elseif($xmas){
		$presentGiver='Santa';
	}else{
		$presentGiver='Syrnia';
	}

if($presentGiver){
	if($memberfor>=2){

    $resultaat = mysqli_query($mysqli,  "SELECT username FROM votes WHERE username='$S_user' && datum='$event' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
    if($aantal==1){
     	$output.="You have already adopted a reindeer, remember? We can only give 1 reindeer to each person otherwise there won't be enough for next year!<BR>";
   		//$output.="You already visited $presentGiver, remember?<BR>";
		//$output.="Now please move away to make room for other people who want to sit on the $presentGiver's lap.<BR>";
    }else{
      	if($var1==''){
   			$output.="You have not adopted a reindeer yet.<BR>";
   			$output.="It costs 5,000gp to adopt a reindeer. Your money will provide care for the reindeer so there will be more to adopt next year.<BR>";

   			//$output.="You can collect a free gift because of Syrnias birthday.<br />";
   			//$output.="Choose wisely.<br />";
            if(hasGold($S_user) >= 5000)
            {
                $output.="<a href='' onclick=\"locationText('adoptareindeer', 'adopt');return false;\">Pay 5,000 gp to adopt a reindeer</a><BR>";
            }
            else
            {
                $output .= "You aren't carrying enough money to adopt a reindeer.";
            }
		}
        else if($var1=='adopt')
        {
            if(hasGold($S_user) >= 5000)
            {
                payGold($S_user, 5000);
                addItem($S_user, "Reindeer", 1, "horse", '', '', 1);
                $sql = "INSERT INTO votes (datum, username, site)
                    VALUES ('$event', '$S_user', '$S_realIP')";
                mysqli_query($mysqli, $sql) or die("erroraa report this bug");

                $output .= "You have adopted your very own reindeer!";
            }
            else
            {
                $output .= "You aren't carrying enough money to adopt a reindeer.";
            }
        }
    }

}else{
  	$output.="Only players who are registered for a few days can adopt a reindeer.<br />";
}
}else{
 	$output.="There is no spoon!";
}

}else{

	$output.="This is Syrnia's main place to party.<BR>";
	$output.="<BR>";

}



}
}
?>