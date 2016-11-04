<?
if(defined('AZtopGame35Heyam') && $S_user){

if($S_location=='Penteza'){ ## PETNTEZA


	$chips=0;
   $sql = "SELECT much from items_inventory where username='$S_user' && name='Elven casino chips' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {$chips=$record->much;}

   $sql = "SELECT casinolose from stats where username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {$casinolose=$record->casinolose; }


$output.="-<a href='' onclick=\"locationText('casino', 'buy');return false;\">Buy/sell casino chips.</a><BR>";
$output.="-<a href='' onclick=\"locationText('casino', 'exchange');return false;\">Exchange casino chips.</a><BR>";
$output.="<B>Games:</B><BR>";
if($casinolose>=0){$output.="-<a href='' onclick=\"locationText('casino', 'CIR');return false;\">Creature intelligence research</a><BR>"; } else{ $output.="You have not yet played enough to unlock this game.<BR>"; }
if($casinolose>=100){$output.="-<a href='' onclick=\"locationText('casino', 'Lottery');return false;\">Lottery</a><BR>"; } else{ $output.="You have not yet played enough to unlock this game.<BR>"; }
if($casinolose>=2500){$output.="-<a href='' onclick=\"locationText('casino', 'Launch-a-Gnome');return false;\">Launch-a-Gnome</a><BR>"; } else{ $output.="You have not yet played enough to unlock this game.<BR>"; }
if($casinolose>=5000){$output.="-<a href='' onclick=\"locationText('casino', 'Trow-a-Gnome');return false;\">Throw-a-Gnome</a><BR>"; } else{ $output.="You have not yet played enough to unlock this game.<BR>"; }
if($casinolose>=10000){$output.="-<a href='' onclick=\"locationText('casino', 'Creature race');return false;\">Creature race</a><BR>"; } else{ $output.="You have not yet played enough to unlock this game.<BR>"; }
$output.="<HR>";

if($var1=='buy'){

	if($var2=='buy' && $var3>0 && is_numeric($var3)  ){
	 	$buychips=$var3;
		   $sql = "SELECT gold from users where username='$S_user' LIMIT 1";
		   $resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat)) {$gold=$record->gold;}
		    echo"$('statsGoldText').innerHTML=\"$gold\";";
		if($buychips*10>$gold){$buychips=floor($gold/10);}
		$cost=$buychips*10;
		if($cost>0){
			payGold($S_user, $cost);
			mysqli_query($mysqli, "UPDATE stats SET casinobought=casinobought+$buychips WHERE username='$S_user' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
			addItem($S_user, 'Elven casino chips', $buychips, 'casino', '', '', 1);
			$output.="<B>Bought $buychips casino chips for $cost gold.</B><BR>";
		}else{
			$output.="<B>Bought 0 casino chips.</B><BR>";
		}
	} elseif($var2=='sell' && $var3>0 && is_numeric($var3)){
		$sellchips=$var3;
		if($sellchips>$chips){
		 	$sellchips=$chips;
		}
		$get=$sellchips*5;
		removeItem($S_user, 'Elven casino chips', $sellchips, '', '', 1);
		getGold($S_user, $get);
		mysqli_query($mysqli, "UPDATE stats SET casinosold=casinosold+'$sellchips' WHERE username='$S_user' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
		$output.="<B>Sold $sellchips casino chips for $get gold.</B><BR>";
	}

	$output.="Hello, you can buy the Elven casino chips for 10 gold, and you can sell your chips for 5 gold.<BR><center>";
	$output.="<form onsubmit=\"locationText('casino', 'buy', 'buy', $('buychips').value);return false;\"><input type=text id=buychips class=input size=3><input type=submit value=Buy class=button></form>";
	$output.="<form  onsubmit=\"locationText('casino', 'buy', 'sell', $('sellchips').value);return false;\"><input type=text id=sellchips class=input size=3><input type=submit value=Sell class=button></form></center>";

} elseif($var1=='CIR'){
###################################
###################################
	if($var2){ #bet
		$win=rand(0,100); $chipslose=1;
        if($chips >= $chipslose)
        {
            removeItem($S_user, 'Elven casino chips', 1, '', '', 1);
            mysqli_query($mysqli, "UPDATE stats SET casinolose=casinolose+$chipslose WHERE username='$S_user' LIMIT 1") or die("err262622or --> 1 $much--$get aaa");
            if($win<=50){
                $chipswon=2; $win=2; $chips=$chips+$chipswon;
                mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$win WHERE username='$S_user' LIMIT 1") or die("err22or --aaa    $win=$chipswon    a1332113> 1 $much--$get aaa");
                addItem($S_user, 'Elven casino chips', $chipswon, 'casino', '', '', 1);
                $output.="<B>You were right, you won 2 chips!</B><BR>";
            } else{
                $output.="<B>The creature went to the other item first, you lost 1 chip.</B><BR>";
            } # not won
        }
        else
        {
            $output.="<B>You don't have enough chips to play.</B><BR>";
        }
	} #bet

	$chips=$chips+$chipswin-$chipslose;
	$output.="You have got <B>$chips</B> chips left.<BR><BR>";
	if($chips>=1){ #C
		$monster=rand(1,5);
		if($monster==1){$monster='Rat'; }
		elseif($monster==2){$monster='Gnome'; }
		elseif($monster==3){$monster='Bat'; }
		elseif($monster==4){$monster='Giant spider'; }
		elseif($monster==5){$monster='Bear'; }
		$item1=rand(1,5);
		if($item1==1){$item1='Net'; }
		elseif($item1==2){$item1='Fox tail'; }
		elseif($item1==3){$item1='Herring'; }
		elseif($item1==4){$item1='Carrot seeds'; }
		elseif($item1==5){$item1='Diamond'; }
		$item2=rand(1,5);
		if($item2==1){$item2='Spar'; }
		elseif($item2==2){$item2='Pike'; }
		elseif($item2==3){$item2='Bread'; }
		elseif($item2==4){$item2='Burnt Mackerel'; }
		elseif($item2==5){$item2='Steel plate'; }
		$output.="Welcome to the Creature intelligence research bet game.<BR>";
		$output.="We are trying to find certain patterns in the behaviour of the creatures.<BR>";
		$output.="While we research you can bet on the results.<BR>";
		$output.="It costs you 1 chip to bet, if you win you get 2 chips.<BR>";
		$output.="<BR>";
		$output.="We are now  looking at a $monster. Which of these two items do you think he will go to?<BR>";
		$output.="<Table><tr><td bgcolor=333333><table><tr align=center><td><img src='images/inventory/$item1.gif'><BR>$item1<BR>";
		$output.="<a href='' onclick=\"locationText('casino', 'CIR', 'bet', 1);return false;\">Bet on this item</a> ";
		$output.="<td><img src='images/inventory/$item2.gif'><BR>$item2<BR>";
		$output.="<a href='' onclick=\"locationText('casino', 'CIR', 'bet', '2');return false;\">Bet on this item</a> ";
		$output.="</table>";
		#$output.="<tr><td bgcolor=cccccc><center><img src='../images/enemies/$monster.jpg'>";
		$output.="</table>";

	}else{
	 	$output.="You do not have enough chips left to play this game.<BR>";
	} #C
#################################################### einde spel 1
} elseif($var1=='Lottery' && $casinolose>=100){ ################# LOTTERY
if($chips>=3){

	if($var2=='buy' && $var3>0 && is_numeric($var3)){
	 	$buylot=$var3;
		if($buylot*3>$chips){$buylot=floor($chips/3);}
		$cost=$buylot*3;
		$chips-=$cost;
		removeItem($S_user, 'Elven casino chips', $cost, '', '', 1);
		mysqli_query($mysqli, "UPDATE stats SET casinolose=casinolose+'$cost' WHERE username='$S_user' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
		addItem($S_user, 'Elven casino lottery ticket', $buylot, 'casino', '', '', 1);

		$output.="<B>Bought $buylot lottery tickets for $cost chips.</B><BR>";
	}

	$loten=0;
   $sql = "SELECT SUM(much) AS much FROM items_inventory WHERE name='Elven casino lottery ticket'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {$loten=$record->much;}
   $sql = "SELECT COUNT(ID) AS much FROM items_wearing WHERE name='Elven casino lottery ticket'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {$loten+=$record->much;}
	$sql = "SELECT SUM(much) AS much FROM houses WHERE name='Elven casino lottery ticket'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {$loten+=$record->much;}
	$sql = "DELETE FROM clanbuildingsitems WHERE name='Elven casino lottery ticket'";
    mysqli_query($mysqli, $sql);


if($loten>=500){
	$price=floor(($loten*3)*0.5);
	$winnaar=rand(1,$loten); $left=$loten; $won=0;
    $messaged = array();
	   $sql = "SELECT username, much from items_inventory  where name='Elven casino lottery ticket' ";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{

			$left=$left-$record->much;
			if($left<$winnaar && $won==0){

				$won=1;  $winnaar=$record->username;
				$sql = "DELETE FROM items_inventory  WHERE username='$record->username'&& name='Elven casino lottery ticket'"; ##REMOVE ALLEEN WINNAAR..ZIE BELOW
				      mysqli_query($mysqli, $sql) or die("error report this bug 2");

                if(!isset($messaged[$record->username]))
                {
                    $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                      VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you and congratulated you:</i> You have won the Elven casino lottery and won $price casino chips!', '$time', 'Elven casino lottery')";
                    mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                    $messaged[$record->username] = true;
                }

				mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$price WHERE username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory  WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1");
				$aantal = mysqli_num_rows($resultaat);

				if($aantal==1){
					mysqli_query($mysqli, "UPDATE items_inventory  SET much=much+'$price' WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				} else{
				 	$sql = "INSERT INTO items_inventory  (username, name, much, type)
					VALUES ('$winnaar', 'Elven casino chips', '$price', 'casino')";
				    mysqli_query($mysqli, $sql) or die("erroraa report this bug");
				}

			}   #won
	  } #select mysql

	   $sql = "SELECT username from items_wearing where name='Elven casino lottery ticket' ";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{

			$left=$left-1;
			if($left<$winnaar && $won==0){

				$won=1;  $winnaar=$record->username;
				$sql = "DELETE FROM items_wearing WHERE username='$record->username'&& name='Elven casino lottery ticket'"; ##REMOVE ALLEEN WINNAAR..ZIE BELOW
				      mysqli_query($mysqli, $sql) or die("error report this bug 2");

                if(!isset($messaged[$record->username]))
                {
                    $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                      VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you and congratulated you:</i> You have won the Elven casino lottery and won $price casino chips!', '$time', 'Elven casino lottery')";
                    mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                    $messaged[$record->username] = true;
                }

				mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$price WHERE username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory  WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1");
				$aantal = mysqli_num_rows($resultaat);

				if($aantal==1){
					mysqli_query($mysqli, "UPDATE items_inventory  SET much=much+'$price' WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				} else{
				 	$sql = "INSERT INTO items_inventory  (username, name, much, type)
					VALUES ('$winnaar', 'Elven casino chips', '$price', 'casino')";
				    mysqli_query($mysqli, $sql) or die("erroraa report this bug");
				}

			}   #won
	  } #select mysql

	  $sql = "SELECT buildings.username as username, houses.much as much, houses.NR as NR from buildings, houses  where houses.name='Elven casino lottery ticket' && buildings.ID=houses.ID ";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{

			$left=$left-$record->much;
			if($left<$winnaar && $won==0){

				$won=1;  $winnaar=$record->username;
				$sql = "DELETE FROM houses  WHERE NR='$record->NR'"; ##REMOVE ALLEEN WINNAAR..ZIE BELOW
				      mysqli_query($mysqli, $sql) or die("error report this bug 2");

                if(!isset($messaged[$record->username]))
                {
                    $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                      VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you and congratulated you:</i> You have won the Elven casino lottery and won $price casino chips!', '$time', 'Elven casino lottery')";
                    mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                    $messaged[$record->username] = true;
                }

				mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$price WHERE username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory  WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1");
				$aantal = mysqli_num_rows($resultaat);
				if($aantal==1){
					mysqli_query($mysqli, "UPDATE items_inventory  SET much=much+'$price' WHERE name='Elven casino chips' && username='$winnaar' LIMIT 1") or die("err22or --> 1 $much--$get aaa");
				} else{
				 	$sql = "INSERT INTO items_inventory  (username, name, much, type)
					VALUES ('$winnaar', 'Elven casino chips', '$price', 'casino')";
				    mysqli_query($mysqli, $sql) or die("erroraa report this bug");
				}

			}   #won
	  } #select mysql


	   $sql = "SELECT username from items_inventory  where name='Elven casino lottery ticket'";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
            $sssql = "DELETE FROM items_inventory  WHERE username='$record->username' && name='Elven casino lottery ticket'";
			      mysqli_query($mysqli, $sssql) or die("error report this bug 2");

            if(!isset($messaged[$record->username]))
            {
                $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                  VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you:</i> $winnaar won the Elven casino lottery and got $price chips. Please hand me over your tickets, since they are invalid now.', '$timee', 'Elven casino lottery')";
                mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                $messaged[$record->username] = true;
            }
		} ##LOSERS  MYSQL

	   $sql = "SELECT username from items_wearing  where name='Elven casino lottery ticket'";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
            $sssql = "DELETE FROM items_wearing  WHERE username='$record->username' && name='Elven casino lottery ticket'";
			      mysqli_query($mysqli, $sssql) or die("error report this bug 2");

            if(!isset($messaged[$record->username]))
            {
                $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                  VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you:</i> $winnaar won the Elven casino lottery and got $price chips. Please hand me over your tickets, since they are invalid now.', '$timee', 'Elven casino lottery')";
                mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                $messaged[$record->username] = true;
            }
		} ##LOSERS  MYSQL

		$sql = "SELECT buildings.username as username, houses.NR as NR from buildings, houses  where houses.name='Elven casino lottery ticket' && buildings.ID=houses.ID";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
            $sssql = "DELETE FROM houses  WHERE NR='$record->NR'";
			      mysqli_query($mysqli, $sssql) or die("error report this bug 2");

            if(!isset($messaged[$record->username]))
            {
                $saql = "INSERT INTO messages (username, sendby, message, time, topic)
                  VALUES ('$record->username', '<B>Syrnia</b>', '<i>An elf approaches you:</i> $winnaar won the Elven casino lottery and got $price chips. Please hand me over your tickets, since they are invalid now.', '$timee', 'Elven casino lottery')";
                mysqli_query($mysqli, $saql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                $messaged[$record->username] = true;
            }
		} ##LOSERS  MYSQL

        unset($messaged);

}else{
	$output.= "<b>If we sell ".(500-$loten)." more lottery tickets we'll draw!</b><br /><br />";
} ## 500 tickets


$output.="<B>You have got $chips chips left.</B><BR>";

$output.="You can buy tickets for the Elven Casino lottery, when enough tickets are sold we will select 1 winner who will win approximately 750 casino chips.<BR>";
$output.="1 Lottery ticket costs 3 chips.<BR>";
$output.="<form onsubmit=\"locationText('casino', 'Lottery', 'buy', $('buylot').value);return false;\"><input type=text id=buylot size=3 class=input><input type=submit value=Buy class=button></form>";


}else{ $output.="You do not have enough chips left to play this game.<BR>"; } #C
########## EINDE LOTTERY
} elseif($var1=='Launch-a-Gnome' && $casinolose>=2500){
###################################
###################################
if($chips>=3){
if($var2=='bet'){ #bet
	$x=rand(0,6);
	$y=rand(1,7);
	$chipslose=3;
	removeItem($S_user, 'Elven casino chips', $chipslose, '', '', 1);
	mysqli_query($mysqli, "UPDATE stats SET casinolose=casinolose+$chipslose WHERE username='$S_user' LIMIT 1") or die("err262622or --> 1 $much--$get aaa");
	$output.="<img src='images/ingame/launch-a-Gnome.php?x=$x&y=$y'><BR>";
	if($x==3 && $y==4){
		$chipswon=147; $win=$chipswin; $chips=$chips+$chipswon;
		mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$win WHERE username='$S_user' LIMIT 1") or die("err22or --aaa    $win=$chipswon    a1332113> 1 $much--$get aaa");
		addItem($S_user, 'Elven casino chips', $chipswon, 'casino', '', '', 1);
		$output.="<B>Nice shot! You won $chipswon chips!</B><BR>";
	} else{
	$output.="<B>Thats not the middle, you lost.</B><BR>";
	} # not won
} #bet
$chips=$chips+$chipswin-$chipslose;
$output.="You have got <B>$chips</B> chips left.<BR><BR>";

$output.="Welcome to Launch-a-Gnome.<BR>";
$output.="Launch a Gnome and fire it at the target, to win the Gnome should land exacly in the middle of the target.<BR>";
$output.="It costs you 3 chips to fire a Gnome, if you win you get 147 chips.<BR>";
$output.="<input type=hidden name=bet value=1>";
$output.="<input type=submit value='Launch!' onclick=\"locationText('casino', 'Launch-a-Gnome', 'bet');return false;\">";

}else{ $output.="You do not have enough chips left to play this game.<BR>"; } #C
} elseif($var1=='Trow-a-Gnome' && $casinolose>=5000){
###################################
###################################
if($chips>=6){
if($var2=='bet'){ #bet
	$x=rand(0,300);
	$chipslose=6;
	removeItem($S_user, 'Elven casino chips', $chipslose, '', '', 1);
	mysqli_query($mysqli, "UPDATE stats SET casinolose=casinolose+$chipslose WHERE username='$S_user' LIMIT 1") or die("err262622or --> 1 $much--$get aaa");
	if($x<240){
		$xA-=20;
	}else if($x>270){
		$xA+=20;
	}else{
		$xA+=$x;
	}
	$output.="<img src='images/ingame/trow-a-Gnome.php?x=$xA'><BR>You threw the Gnome $x meters away!<BR>";
	if($x>=240 && $x<=270){
		$chipswon=60; $win=$chipswon; $chips=$chips+$chipswon;
		mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$win WHERE username='$S_user' LIMIT 1") or die("err22or --aaa    $win=$chipswon    a1332113> 1 $much--$get aaa");
		addItem($S_user, 'Elven casino chips', $chipswon, 'casino', '', '', 1);
		$output.="<B>Excellent! You won $chipswon chips!</B><BR>";
	} else{
		$output.="<B>Thats not between the 2 big poles, you lost.</B><BR>";
	} # not won
} #bet
$chips=$chips+$chipswin-$chipslose;
$output.="You have got <B>$chips</B> chips left.<BR><BR>";

$output.="Welcome to Throw-a-Gnome.<BR>";
$output.="Throw a Gnome between the two poles to win.<BR>";
$output.="It costs you 6 chips to fire a Gnome, if you win you get 60 chips.<BR>";
$output.="<input type=hidden name=bet value=1>";
$output.="<input type=submit value='Throw a Gnome!' onclick=\"locationText('casino', 'Trow-a-Gnome', 'bet');return false;\">";

}else{ $output.="You do not have enough chips left to play this game.<BR>"; } #C
} elseif($var1=='Creature race'){
###################################
###################################
if($chips>=50){
if($var2=='bet'){ #bet
	$x=rand(0,100);
	$chipslose=50;
	removeItem($S_user, 'Elven casino chips', $chipslose, '', '', 1);
	mysqli_query($mysqli, "UPDATE stats SET casinolose=casinolose+$chipslose WHERE username='$S_user' LIMIT 1") or die("err262622or --> 1 $much--$get aaa");
	if($x<=18){
		$chipswon=250;
		$chips=$chips+$chipswon;
		mysqli_query($mysqli, "UPDATE stats SET casinowon=casinowon+$chipswon WHERE username='$S_user' LIMIT 1") or die("err22or --aaa    $win=$chipswon    a1332113> 1 $much--$get aaa");
		addItem($S_user, 'Elven casino chips', $chipswon, 'casino', '', '', 1);
		$output.="<B>Your monster finished first! You won $chipswon chips!</B><BR>";
	} else{
	$output.="<B>Your monster lost, and so did you.</B><BR>";
	} # not won
} #bet
$chips=$chips+$chipswin-$chipslose;
$output.="You have got <B>$chips</B> chips left.<BR><BR>";

$monster=rand(1,2);
if($monster==1){$monster='Rat'; }
elseif($monster==2){$monster='Gnome'; }
$monster2=rand(1,2);
if($monster2==1){$monster2='Giant spider'; }
elseif($monster2==2){$monster2='Bear'; }
$monster3=rand(1,2);
if($monster3==1){$monster3='Rat'; }
elseif($monster3==2){$monster3='Bunyip'; }
$monster4=rand(1,2);
if($monster4==1){$monster4='Wolf'; }
elseif($monster4==2){$monster4='Wild dog'; }
$monster5=rand(1,2);
if($monster5==1){$monster5='Cobra'; }
elseif($monster5==2){$monster5='Fox'; }

$output.="Welcome to the creature race!<BR>";
$output.="Bet on creature races and make big money!<BR>";
$output.="It costs you 50 chip to bet, if you win you get 250 chips.<BR>";
$output.="<BR>";
$output.="<table border=1>";
$output.="<tr bgcolor=999999><td><img src='images/enemies/$monster.jpg'><Td><input type=submit value='Bet' onclick=\"locationText('casino', 'Creature race', 'bet', '1');return false;\">";
$output.="<tr bgcolor=999999><td><img src='images/enemies/$monster2.jpg'><Td><input type=submit value='Bet' onclick=\"locationText('casino', 'Creature race', 'bet', '2');return false;\">";
$output.="<tr bgcolor=999999><td><img src='images/enemies/$monster3.jpg'><Td><input type=submit value='Bet' onclick=\"locationText('casino', 'Creature race', 'bet', '3');return false;\">";
$output.="<tr bgcolor=999999><td><img src='images/enemies/$monster4.jpg'><Td><input type=submit value='Bet' onclick=\"locationText('casino', 'Creature race', 'bet', '4');return false;\">";
$output.="<tr bgcolor=999999><td><img src='images/enemies/$monster5.jpg'><Td><input type=submit value='Bet' onclick=\"locationText('casino', 'Creature race', 'bet', '5');return false;\">";
$output.="</table>";

}else{ $output.="You do not have enough chips left to play this game.<BR>"; } #C
#################################################### einde spel 1
}elseif($var1=='exchange'){

if($var2=='buy'){
 	$buya=$var3;
 	$cost=0; $much=1;
	if($buya=='Elven two handed sword'){ $cost=12000; $type='hand';}
	elseif($buya=='Elven plate'){ $cost=12000; $type='body';}
	elseif($buya=='Elven pickaxe'){ $cost=7000; $type='hand';}
	elseif($buya=='Elven hatchet'){ $cost=6000; $type='hand';}
	elseif($buya=='Elven helmet'){ $cost=5000; $type='helmet';}
	elseif($buya=='Orb'){ $cost=2000; $much=100; $type='magic';}
	if($cost>0){
	if($chips>=$cost){
	removeItem($S_user, 'Elven casino chips', $cost, '', '', 1);
	addItem($S_user, $buya, $much, $type, '', '', 1);
	$output.="<B>Bought $much $buya.</B><BR>";
	}else{ $output.="You do not have enough chips <BR>";}
	}
}

$output.="You can exchange your chips for casino prizes.<BR>";
$output.="Please take a look at the prices.<BR><BR>";
$output.="<Table><tr><td><B>Prize<td><B>Chips<td>";
$output.="<tr><td>Elven two handed sword<td>12000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Elven two handed sword');return false;\">Buy</a>";
$output.="<tr><td>Elven plate<td>12000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Elven plate');return false;\">Buy</a>";
$output.="<tr><td>Elven pickaxe<td>7000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Elven pickaxe');return false;\">Buy</a>";
$output.="<tr><td>Elven hatchet<td>6000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Elven hatchet');return false;\">Buy</a>";
$output.="<tr><td>Elven helmet<td>5000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Elven helmet');return false;\">Buy</a>";
$output.="<tr><td>100 Orb<td>2000<td><a href='' onclick=\"locationText('casino', 'exchange', 'buy', 'Orb');return false;\">Buy</a>";
$output.="</table>";

} else{ ### NIKSSS

$output.="Welcome to the Elven casino!<BR>";
$output.="Please note that we are allowed to change prices/games or anything else in the casino any time.<BR>";
$output.="Have fun playing!<BR>";
}


} # PENTEZA
} ##USER
?>