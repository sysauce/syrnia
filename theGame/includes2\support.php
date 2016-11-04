<?
$S_user='';
  session_start();
  $time=$timee=time();

  	//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");


echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
body {
	color:#000000;
}
</style>
<script src=\"".GAMEURL."scriptaculous-js-1.8.3/lib/prototype.js\" type=\"text/javascript\"></script>
	";
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PUBLIC">
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</HEAD>
<?
echo"<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000>

<center><br />
 <Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td>

<h1>Support Syrnia</h1>
Syrnia is free, and will stay free, but we do need your help in return.<BR>
There are various ways you can help Syrnia; some cost money, some only cost time.<BR>
To make your attempts to help Syrnia work, I made you a list of very effective ways of helping.
If everyone is able to do 2 of the below actions at least once a week, this would make a <u>HUGE</u> difference.
Helping Syrnia is also beneficial for you: more players, more updates, more fun!<br />
<hr>";

##################

echo"1 <b><a href=?action=vote>Vote for Syrnia</a></B><BR>";
//echo"2 <b><a href=?action=cpa>Sign up on offers</a></B><BR>";
echo"2 <b><a href=?action=premium>Purchase premium points</a></B><BR>";
echo"3 <b><a href=?action=tell>Promote Syrnia</a></B><BR>";


echo"<br />";

if($action=='tell'){  ############################
	 echo"<table><tr><td width=20><td>Simply tell some of your friends of the game. It also makes the game more fun for you because it's nice to play with friends.<BR>
	Sometimes there are events organised where you'll receive prizes for promoting Syrnia, so make sure to use your own referral link to promote.<BR>
	<pre>http://www.syrnia.com/?who=p_".str_replace(' ', '%20',$S_user)."</pre><br />
	<br />
	Also feel free to add your referral link on websites/forums where it is allowed.
	Adding a link to Syrnia somewhere on a website not only makes the visitors of the website visit Syrnia, but search engines will also see the link and Syrnia will get higher ranked on any search results.<BR>
	";


	$sql = "SELECT ID FROM stats WHERE refer='p_$S_user'";
	$resultaat = mysqli_query($mysqli,$sql);
	 $aantal = mysqli_num_rows($resultaat);
	echo"<br /><B>$aantal players have joined</B> using your referral link.<br />";




echo"</td></tr></table>";


}elseif($action=='vote'){  ##################################
	echo"<table><tr><td width=20><td><u>Vote for syrnia</u><BR>
	<img src='../../images/inventory/Green gift.gif' hspace=10 vspace=10 align=left ><br />Please vote for Syrnia at the websites below, please do so every day you play Syrnia.<BR>
	<U>You get green gifts for voting for syrnia on the top sites!</U><BR>
	The gifts do take a while to appear in your inventory, and we cannot guarantee green gifts for every time you vote. You usually get 2-4 green gifts if you vote every day.<br />
	<br />";

//	<a href=\"http://www.directoryofgames.com/main.php?view=topgames&action=vote&v_tgame=276\" target=_blank>Vote</a> DoG<br>


$voteingSites[0]="<a href=\"http://www.gamesites200.com/mpog/in.php?id=271\">Vote <img src=\"http://www.gamesites200.com/mpog/vote.gif\" alt=\"Vote on the MMORPG / MPOG Top 200\" border=\"0\"></a><br /><img src=\"http://www.gamesites200.com/track.gif\" alt=\"MMORPG / MPOG Top 200 - Free and Paid Online Games\" border=\"0\"></a>";
$voteingSites[1]="<a href=\"http://apexwebgaming.com/in/415\" target=_Blank>Vote</a> apexwebgaming <BR>";
$voteingSites[2]="<a href=\"http://www.omgn.com/incoming.php?ID=740&Vote=true\" target=_Blank>Vote</a> OMGN.com ";

//Is this counter?
$voteingSites[3]="<a href=\"http://top50.onrpg.com\" target=_Blank>Vote</a> ONRPG RPG top 50 <BR>";

$voteingSites[4]="<a href=\"http://www.topwebgames.com/in.asp?id=2909&uid=$S_user\" target=_Blank>Vote</a>  topwebgames.com<BR>";
//$voteingSites[5]="<a href=\"http://theogn.com/gamedata.php?gameid=1466\" target=_Blank>Vote</a> <i>theogn.com</i><BR>";
$voteingSites[6]="<a href=\"http://www.toprpgames.com/vote.php?idno=686&uid=$S_user\" target=_Blank>Vote</a>  toprpggames.com<BR>";
$voteingSites[7]="<a href=\"http://www.gamesites100.net/in.php?site=3687&uid=$S_user\" target=_Blank>Vote</a> gamesites100.net<BR> ";
$voteingSites[8]="<a href=\"http://www.gtop100.com/in.php?site=9196\" target=_Blank>Vote</a> Gtop100<BR>";
$voteingSites[9]="<A href=\"http://www.worldonlinegames.com/vote1/789/\" target=_Blank>Vote</a> WOG<br>";
$voteingSites[10]="<a href='http://www.topgamesites.net' target=_blank>Vote</a> TGS<br>";

//Are we ON this 1?
$voteingSites[11]="<a href=\"http://www.mmorpg100.com/in.php?id=1172\" target=_Blank>Vote</a> mmorpg100<br>";

$voteingSites[12]="<a href=\"http://www.oz-games200.com/in.php?gameid=809\" target=_Blank>Vote</a> Oz-games200 <br>";
$voteingSites[13]="<a href=\"http://mpogtop.com/in.php/1169840191\" target=_blank>Vote</a> MPOGtop<br>";
$voteingSites[14]="<a href=\"http://www.gametopsites.com\" target=_blank>Vote</a> gametopsites<br>";



echo"<table border=1>";
$number=1;
for($i=0;$i<=14;$i++){
	if($voteingSites[$i]){
		if($i%2==0){
			echo"<tr valign=middle bgcolor=#EED3A5><td>$number ".$voteingSites[$i]."</td></td>";
		}else{
			echo"<tr valign=middle><td>$number ".$voteingSites[$i]."</td></td>";
		}
        $number++;
	}
}
echo"</table>";
	echo"<br />













	</td></tr></table>";

  }else if($action=='premium'){ ###########################
	 echo"<table><tr><td width=20><td><B>Premium points</B><br/>
	 You can unlock nice extra features by buying premium points. Premium points can be bought via our third party payment provider Paymentwall. Paymentwall allows you to buy using Wallie, Paypal, Google checkout, mobile, and more more options.
	You are free to consider purchasing Syrnia premium points using the link below whenever you want.<BR>
	<br/>
	<a href=?action=$action&sub=list><b>What can I unlock?</b></a><br/>
	<a href=?action=$action&sub=how><b>How can I donate?</b></a><br/>
	<a href=?action=$action&sub=transfer><b>Transfer premium points</b></a><br/>
	<br/>";

  /*  if($S_user){
    echo"<b>Unlock premium points</b><br />
    Have you got a premium points code? Use it below.<br/>
    <form action='' method=post><input type=text name=ppPoints><input type=submit value=Redeem></form>
    ";


        if($ppPoints){

            $ppPoints = trim($ppPoints);
            $points = '';
           	$sql = "SELECT points,redeemed FROM premiumcodes WHERE code='$ppPoints' LIMIT 1";
			$resultaat = mysqli_query($mysqli,$sql);
			while ($record = mysqli_fetch_object($resultaat)) {
			     $redeemed = $record->redeemed;
                 $points = $record->points;
            }
            if($points==''){
                echo"Error; This code does not exist.<br />";
            }else if($redeemed){
                echo"Error; This code has already been redeemed!<br />";
            }else{

                $donationAmount = $points/100;
                $donationUser = $S_user;
                $ip = $_SERVER['REMOTE_ADDR'];

                mysqli_query($mysqli, "UPDATE premiumcodes SET redeemed=1 WHERE code='$ppPoints' LIMIT 1") or die("error --> 543");
                mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$donationAmount' WHERE username='$donationUser' LIMIT 1") or die("error --> 544343");

            mysqli_query($mysqli,
                "INSERT INTO donations (username, txn_id, phpip, much, donatedby, updatedusers, time, donationAmount)
        	VALUES ('$donationUser', '$ppPoints', '$ip', '$donationAmount', '$donationUser', '$donationUser', '$timee', '$donationAmount')") or
                die("ERROR 111 PLEASE MAIL $contact ");

                 $_SESSION['S_donation'] = $_SESSION['S_donation'] + $donationAmount;

           // $sql = "SELECT donation FROM stats WHERE username='$S_user' LIMIT 1";
			// $resultaat = mysqli_query($mysqli,$sql);
		//	 while ($record = mysqli_fetch_object($resultaat)) {
			//      $_SESSION['S_donation'] = $record->donation + ALSO_FREE_DONATION_FROM STAFFLIST!
              // }

                echo"<b>$donationAmount Euros have been added to your donation status!</b><br />";
            }
        }
    }*/





	if($sub=='transfer'){
		echo"<h2>Premium point transfers</h2>
		At this page you can transfer (parts of) any of your recent premium points purchase to another player.<br/>
		You can add a personal message, or even transfer it annonymously.<br/>
		<br/>
		To transfer points to another player:<br/>
		<ol>
		<li>Purchase premium points for your own account.<br/>
		<li>After the purchase, verify that your account was rewarded the premium points
		<li>Then, at the bottom of this page a form will appear which you can use to transfer (a part of) your points to another player, or multiple players.<br/>
		</ol><br />";

	    $timeout=time()-3600*24*7;
	    $donationToShare=0;
		$sql = "SELECT much FROM donations WHERE donatedby='$S_user' && time>'$timeout'";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat)) { $donationToShare+=$record->much; }

		if($donationToShare>0){




			if($playerName){
			     $doTrans= $euros;
				if($euros>=50){
			 	$resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$playerName' LIMIT 1");
	   			$there = mysqli_num_rows($resultaat);
				if($there!=1){
					echo"<font color=red><b>The player name you specified does not exist!</b></font><br/>";
				}elseif(!is_numeric($euros) || $euros>$donationToShare || $euros<=0){
				 	echo"<font color=red><b>You entered an invalid transfer amount.</b></font><br/>";
				}else{
					$eurosT=$euros/100;
						$sql = "SELECT ID, much, updatedusers FROM donations WHERE donatedby='$S_user' && time>'$timeout'";
						$resultaat = mysqli_query($mysqli,$sql);
						while ($record = mysqli_fetch_object($resultaat)) {
						 	if($euros>0){
								if($euros<=$record->much){
								 	mysqli_query($mysqli,"UPDATE donations SET much=much-'$euros',  updatedusers='$record->updatedusers | gave [$eurosT | $euros] to $playerName' WHERE ID='$record->ID' LIMIT 1") or die("err22aa");
									$euros=0;
								}else{
								 	if($record->much>0){
								 		mysqli_query($mysqli,"UPDATE donations SET much=0,  updatedusers='$record->updatedusers | gave ($record->much) to $playerName' WHERE ID='$record->ID' LIMIT 1") or die("err22aa");
										$euros=$euros-$record->much;
									}
								}
							}
						}
						mysqli_query($mysqli,"UPDATE stats SET donation=donation+'$doTrans' WHERE username='$playerName' LIMIT 1") or die("err22aa");
						mysqli_query($mysqli,"UPDATE stats SET donation=donation-'$doTrans' WHERE username='$S_user' LIMIT 1") or die("err22aa");

					$Messa=htmlentities(trim(stripslashes($Messa)));
					if(!$show){
						$text="A player has transferred $doTrans of their premium points to your account, check the Support page to see what options you've unlocked.<br/> This message was added:<br/><br/><i>$Messa</i>";
					}else{
						$text="<b>$S_user</b> has transferred $doTrans of their premium points to your account, check the Support page to see what options you've unlocked.<br/> This message was added:<br/><br/><i>$Messa</i>";
					}

					$text=addslashes($text);
					$sql = "INSERT INTO messages (username, sendby, message, topic, time)
  VALUES ('$playerName', '<B>Syrnia</b>', '$text', 'Premium points transferred', '$timee')";
  mysqli_query($mysqli,$sql) or die("error report this ");

					echo"You have successfully transferred $doTrans points to the player <b>$playerName</b>.<br/>";
					$donationToShare-=$euros;
				}

			 }else{
			 	echo"<b>Error: You need to transfer at least 50 points</b><br/>";
			 }
			 }

			echo"You have purchased $donationToShare premium points in the last 7 days, you can transfer (a part of) this to other player(s).<br/>";
		}


		if($donationToShare>0){

			echo"<form action='' method=post>
			<table>
			<tr><td>To player<td><input type=text name=playerName>
			<tr valign=top><td>Amount<br /><small>Min. 50</small></td><td><input type=text name=euros>
			<tr valign=top><td>Option<td><select name=show><option value=1>Show my name<option value=0>Hide my name</select>
			<tr valign=top><td>Text (optional)<td><textarea name=Messa rows=4 colls=10></textarea>

			<tr><td><td><input type=submit value=Transfer>
			</table></form>";

		}else{
			echo"<i>At the moment you cannot transfer any premium points to another players as you've not purchased any points in the past 7 days.</i><br />";
		}

	}elseif($sub=='how'){
		$userID=-1;
    	$resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' LIMIT 1");
    	while ($record = mysqli_fetch_object($resultaat))
    	{
    		$userID = $record->ID;
    	}

    	echo"<h2>How can I buy premium points?</h2>
		There are 2 options to donate to Syrnia, using a Wallie-card or using FastSpring(Premium codes). FastSpring allows several payment methods: Paypal, credit card, direct bank transfer and more.<br/>
		If you purchase premium points, the points will be added to your account as soon as the payment has been processed (bank transfers take time, credit card is instant). You can donate points to another player by purchasing premium points and then going to the <a href=?action=$action&sub=transfer>points transfer page</a>. At the transfer page you can transfer (a part of) your premium points to another player, you can even choose to add a personal message, or do so anonymously.<br /><br/>

		<h3>Purchase premium points</h3>";

        if($userID>0){
        echo"	<h2>Using the main Paymentwall</h2>
		<iframe src=\"http://wallapi.com/api/ps/?key=a75f86de09ed3bfef7b181e5a463e53b&uid=".$userID."&widget=p1_1\" width=\"750\" height=\"800\" frameborder=\"0\"></iframe>";


        echo"<br /><br /><h2>Paymentwall mobile payments</h2>
        <script src=\"http://wallapi.com/js/widget/mobile.client.js\" type=\"text/javascript\"></script><a id=\"buttID\" style=\"display: block; cursor: pointer; height: 37px; width: 230px; text-indent: -2000em; background: url(http://wallapi.com/images/widgets/mobile/mobile_but3.png) repeat scroll 0 0 transparent;\" onclick=\"pw_widget_mobile('buttID', 'a75f86de09ed3bfef7b181e5a463e53b', '".$userID."', 'm1_1'); return false;\"></a>
        ";
        //        <iframe src=\"http://wallapi.com/api/ps/?key=a75f86de09ed3bfef7b181e5a463e53b&uid=".$userID."&widget=m1_1\" width=\"670\" height=\"776\" frameborder=\"0\"></iframe><br /><br />";



    }else{

        echo"You need to login to purchase premium points.";
    }







	/*	echo"<h3>How to donate using TrialPay</h3>
		TrialPay offers two ways to donate, by using promotional offers or mobile payments.<BR>
		Use the following link for promotional offers: <a href=\"http://www.trialpay.com/productpage/?c=eff9535&tid=6rGo5So&sid=$S_user\">TrialPay offers for user:$S_user</a><br/><br />
		";

		echo"<h3>Donate via phone/SMS using DAOPAY</h3>
		DAOPay offers two ways to donate, using <b>SMS</b> messages or <b>phone</b> calls. Do note that this comes with a fee: From 17% up to 68% on the amount you pay will actually be transferred to your Syrnia account, depending on your country. To check your country rates <a href=http://www.daopay.com/business/fees-and-payouts.php>click here</a>. <u>Please do first check the fee for your country to avoid disappointment</u>. If you can donate via any other method Syrnia accepts you should consider those because of the lower fees.<br />
		Use the following form to use DAOPAY for your syrnia account:<br />
		Pay by SMS/Phone: <select name=\"PhoneAmount\" id=\"PhoneAmount\">
		<option value=1.50>1.50 euro</option>
		<option value=2>2.00 euro</option>
		<option value=2.5>2.50 euro</option>
		<option value=3>3.00 euro</option>
		<option value=3.50>3.50 euro</option>
		<option value=5>5.00 euro</option>
		<option value=7.5>7.50 euro</option>
		<option value=10.00>10.00 euro</option>
		</select><input type=submit value='Start' onclick='StartDAOPay();return false;'>

		<script>
		function StartDAOPay(){
			window.location = \"http://daopay.com/payment/?appcode=58999&price=\"+$('PhoneAmount').value+\"&userid=$userID&phone=1\";
		}</script>";*/




		/*echo"<br/>
		<h3>How to donate using a Wallie-card</h3>
		<img src=http://www.syrnia.com/images/wallie.gif align=left hspace=10 vspace=10> The Wallie card is a secure prepaid paying method that is simple and safe to use on the internet.<br/>
		You can pay anonymously without providing any personal or financial information.
		There are several values of Wallie cards, and whenever using a card you will not need to spent the entire value of a Wallie card at once.
		Wallie is available in several countries.<br/>
		For a list of sales outlets of the Wallie-card and further information, visit Wallies website:<br/>
		<a href=http://www.wallie.co.uk target=_blank>http://www.wallie.co.uk</a> (UK)<br/>
		<a href=http://www.wallie.nl target=_blank>http://www.wallie.nl</a> (NL)<br/>
		<br/>
		3 steps to donate using Wallie:<br/>
		<ol>
		<li>Enter an username to donate below, and select how much you'd like to donate.<br/>
		<li>Now follow the Wallie instructions (It will ask you for a Wallie card number).
		<li>You're done! The account name you specified has been upgraded right away and has been send a small notification message.
		</ol>";

		echo"
		<form method=\"post\" action=\"https://betaal-met.wallie-card.nl/\">
		<input type=\"hidden\" name=\"MerchantID\" value=\"616\">
		Donate for username: <input type=\"text\" name=\"ShoppingCartID\" value=\"$S_user\"><br/>
		Amount: <select name=\"Amount\">
		<option value=250>2.50 euro</option>
		<option value=500>5.00 euro</option>
		<option value=750>7.50 euro</option>
		<option value=1000>10.00 euro</option>
		<option value=1250>12.50 euro</option>
		<option value=1500>15.00 euro</option>
		<option value=1750>17.50 euro</option>
		<option value=2000>20.00 euro</option>
		<option value=2250>22.50 euro</option>
		<option value=2500>25.00 euro</option>
		<option value=2750>27.50 euro</option>
		<option value=3000>30.00 euro</option>
		<option value=3250>32.50 euro</option>
		<option value=3500>35.00 euro</option>
		<option value=3750>37.50 euro</option>
		<option value=4000>40.00 euro</option>
		<option value=4250>42.50 euro</option>
		<option value=4500>45.00 euro</option>
		<option value=4750>47.50 euro</option>
		<option value=5000>50.00 euro</option>
		</select>
		<input type=\"hidden\" name=\"ReturnURL\" value=\"http://www.syrnia.com/donated.php?wallie=1\">
		<input type=\"hidden\" name=\"Currency\" value=\"EUR\"><br>
		<input type=\"hidden\" name=\"Language\" value=\"en\"><br>
		<input type=\"submit\" value=\"Donate using Wallie\">
		</form>";*/

		echo"<br/><h3>Have you bought premium points, but got any problems?</h3>
		Any transaction should be added instantly, the only exception to this are when a transaction needs time to complete, such as PayPal e-cheques and bank to bank transfers. If your points purchase has not been added right away please email support@syrnia.com.<br/>

		";


		}else{


	     echo"<h2>What can I unlock?</h2>";

	if($S_user){

	$donation=$S_donation;
	if(!$S_donation){
		$sql = "SELECT donation FROM stats WHERE username='$S_user' LIMIT 1";
		$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
		while ($record = mysqli_fetch_object($resultaat)) { $donation=$record->donation; }
	}
	echo"You have a total of $donation premium points.<BR>";
	}


	function returnStatus($cash, $donation) {
		if($cash<=$donation){
			$pass="<small>Unlocked</small></td><td>$cash</td><td> <font color=green>";
		}else{
			$cash2=floor(($cash-$donation));
			$pass="$cash2 points left</td><td>$cash</td><td> <font color=red>";
		}
		return $pass;
	}// Usage   $password =  returnStatus(25, $donation);



	echo"
	With premium points you can unlock the following options:<BR>
	<table border=1>
	<tr valign=top><td width=100><u>Points left*</u></td><td width=50><u>Required</u><td><U>Unlocked</U>
	<tr valign=top><td>".returnStatus(100, $donation)." $d100 Chat status: Underlined name
	<tr valign=top><td>".returnStatus(500, $donation)." Bold shop title at shop overview
	<tr valign=top><td>".returnStatus(750, $donation)." Forum signature (Edited via options)<BR>Forum avatar (Edited via options)
	<tr valign=top><td>".returnStatus(1000, $donation)." Account can be deleted after 5 years of inactivity instead of 4 months
	<tr valign=top><td>".returnStatus(1000, $donation)." Bot check between every 15-20 minutes instead of every 10-15 minutes(*B)<BR>
														Hold up to 75 recieved and 10 sent messages
	<tr valign=top><td>".returnStatus(1250, $donation)." Your shops title looks more attractive and attractive auction house items
	<tr valign=top><td>".returnStatus(1250, $donation)." Unlocks a trophy slot to show off items
	<tr valign=top><td>".returnStatus(1500, $donation)." Extra stats at stats pop-up
	<tr valign=top><td>".returnStatus(1750, $donation)." 3 digit bot check code instead of 4
	<tr valign=top><td>".returnStatus(1750, $donation)." Hold up to 100 recieved and 15 sent messages
	<tr valign=top><td>".returnStatus(2000, $donation)." Forum search option
	<tr valign=top><td>".returnStatus(2500, $donation)." Expanded welcome information (Check all events, last messages etc.)
	<tr valign=top><td>".returnStatus(2500, $donation)." No in-game ads (In forum and messages)
	<tr valign=top><td>".returnStatus(2500, $donation)." Able to ignore +/- 40 instead of 20 usernames";

	echo"<tr valign=top><td>".returnStatus(2750, $donation)." Hold up to 125 recieved and 20 sent messages";
	echo"<tr valign=top><td>".returnStatus(3000, $donation)." Option to disable your login message(s) in the chat";
	echo"<tr valign=top><td>".returnStatus(3000, $donation)." Change inventory height at options";
	echo"<tr valign=top><td>".returnStatus(3250, $donation)." Unlock the Journal page: Be able to manage 10 notes.";
	echo"<tr valign=top><td>".returnStatus(3500, $donation)." Option to disable the Google search";
	echo"<tr valign=top><td>".returnStatus(3750, $donation)." Check stocks of your houses and shops at the stats pop-up.";
	echo"<tr valign=top><td>".returnStatus(3750, $donation)." Be able to manage 20 notes at the Journal page.";
	echo"<tr valign=top><td>".returnStatus(4000, $donation)." Able to ignore +/- 75 instead of 20 usernames";
	echo"<tr valign=top><td>".returnStatus(4000, $donation)." Hold up to 150 recieved and 25 sent messages";
	echo"<tr valign=top><td>".returnStatus(4250, $donation)." Be able to manage 30 notes at the Journal page.";
	echo"<tr valign=top><td>".returnStatus(4750, $donation)." Be able to manage 40 notes at the Journal page.</td>";
	echo"<tr valign=top><td>".returnStatus(5000, $donation)." You can now view the Highscore history at the options page (Contains all records from 2006-01-26 to now, excluding any days the game might have been offline.)</td></tr>";
	echo"<tr valign=top><td>".returnStatus(5500, $donation)." Doubles the maximum amount of chat lines that the chat history contains</td></tr>";
	echo"<tr valign=top><td>".returnStatus(7500, $donation)." Allows you to also check yesterdays chat history (Within the history chat lines limit)</td></tr>";
	echo"<tr valign=top><td>".returnStatus(10000, $donation)." Bot check between every +/-20 minutes instead of every 15-20 minutes(*B)</td></tr>";


	//echo"<tr valign=top><td>".returnStatus(100, $donation)." Bot check every +/- 20 minutes<br />";

	//<tr valign=top><td>".returnStatus(150, $donation)."<small><strike>Got any wish?<BR>
//	<li>Always wanted to have an huge invasion of 100 000 rats?
//	<li>You want a great idea given priority and updated soon?<BR>
//	If you donate to this much I'm sure we can furfill one nice wish. Contact support@syrnia.com <u>first</u> before donating to discuss the opportunities as wishes should be reasonable and fit the game.</small>
//	</strike><br/>
//	<font color=red>We are not accepting any wishes at the moment, please check back later.</font>
	echo"</table>
	<Small><i>(*B: At the premium options you can enable/disable the lower botcheck frequency for fighting)</i></small><BR>
	<br/>
	* This is your total amount of premium points, example:<BR>
	If you first buy 500 premium points and later on another 750 you will have a total of 1250 premium points, and you will have unlocked all options of 1250 premium points and below.<BR>";
	}
	echo"<BR>
	</td></tr></table>";

/*}elseif($action=='cpa'){
	echo"<b>Sign-up on 1 of these offers and get red-gifts added to your account.</b><br />
	<img src='../../images/inventory/Red gift.gif' hspace=10 vspace=10  align=left ><br />
	The following text and links are added by a 3rd party (CPAlead).<br />
	The links below only contain offers you have not yet used.<br/>
	We're sorry: But the offers below are mostly US only, but the 3rd party is doing all they can to add international offers as well.<br />
	Do be carefull with you (personal) details, usage is at your own risk.<br />
	<strong><em>The addition of gifts to your inventory is solely the responsibility of the third parties system.
	If you do not receive your gifts you must contact them with the specifics of your issue for them to resolve the matter.</em></strong><br />
	<br/>
	<i>The following content is added by a 3rd party, for every point you get 1 Red gift.</i><br />
	<i>For any problems, contact CPALead via the button below.</i><br />
	<br/>
	<br/>
	<table cellpadding=10 width=95% border=1 cellspacing=0>
	<tr><td bgcolor=#EED3A5 align=center>
	<script type=\"text/javascript\" src=\"http://data.cpalead.com/asd/asd_load.php?pub=523&subid=".str_replace(" ", "%20", $S_user)."\"></script>
	</td></tr>
	</table>
	";*/

}else{
 echo"<br />Thanks for reading, and showing your interest in supporting Syrnia.<br />
";
}


?>
<BR>

</td></tr></table><br />
</center>
</body>
</html>
