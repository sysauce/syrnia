<?php
//X2
//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");
$timee=$time=time();


//WAARDEN
$API_VERSION = 1;

$AH_LIMIT=25; // Auction
$HS_LIMIT=500; // (24 * skills)
$UL_LIMIT=2; // Once a day 
$CL_LIMIT=2; // Once a day 
$PROFILE_LIMIT=2000; // Users..hmm 
$O_LIMIT=1000; // Clanmemberlist (24*clans[400]=1000 ?) & HighscoreUserlist  (24=24)

$request=$_REQUEST['request'];
$key=$_REQUEST['key'];

$valid = 0;
$QueryG = mysqli_query($mysqli, "SELECT todaysothers, todaysauctionrequests, todayshighscorerequests, todaysuserlistrequests, todaysclanlistrequests, todaysprofilerequests FROM api WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error!");
while ($record = mysqli_fetch_object($QueryG))
{
	$valid=1;
	
    $AH_R = $record->todaysauctionrequests;
	$HS_R = $record->todayshighscorerequests;
	$UL_R = $record->todaysuserlistrequests;
	$CL_R = $record->todaysclanlistrequests;
	$P_R = $record->todaysprofilerequests;
	$O_R = $record->todaysothers;	
}
            
            
if($valid!=1){
	echo"0 Unauthorised API usage!";
	exit();
}

if($version && $version!=$API_VERSION){
	echo"0 You are using API version <b>$version</b>, but the latest version is <b>$API_VERSION</b>. Looks like we changed something crucial that required changing our version number!";
	exit();
}

if($request=='auction'){
	//AUction list
	
	if($AH_R>=$AH_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of auctionhouse requests per day ($AH_LIMIT).";
			
	}else{
		mysqli_query($mysqli, "UPDATE api SET todaysauctionrequests=todaysauctionrequests+1, totalauctionrequests =totalauctionrequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
              
			  
  		$ahTIme=$timee-3600*6;
		$QueryG = mysqli_query($mysqli, "SELECT seller, name, much, itemupgrade, upgrademuch, bidder, bid, time FROM auctions WHERE time>'$ahTIme'") or die("0 Syrnia database error!");
		echo"1\n";
		while ($record = mysqli_fetch_object($QueryG))
		{
			$timeleft=ceil(($record->time-time())/3600);				
			echo"$record->much@$record->name@$record->itemupgrade@$record->upgrademuch@$record->seller@X@$record->bid@$timeleft\n";		
		}
	
	}
	
	
	
}else if($request=='highscore'){
	//// HIGHSCORE REQUEST
	
	
	if($HS_R>=$HS_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of highscore requests per day ($HS_LIMIT). You should never need to make more than 24*Skills requests per day!";
			
	}else{
		
		if($type=='attack' || $type=='constructing' || $type=='cooking' || $type=='defence' || $type=='farming' || $type=='fishing' || $type=='health' || $type=='level' || $type=='magic' || $type=='mining' || $type=='smithing' || $type=='speed' || $type=='strength' || $type=='thieving' || $type=='totalskill' || $type=='trading' || $type=='woodcutting'){
			
			mysqli_query($mysqli, "UPDATE api SET todayshighscorerequests=todayshighscorerequests+1, totalhighscorerequests=totalhighscorerequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
                            
			echo"1\n";
			$date=date("Y_m_d_");
			include("logs/highscore/newformat/$date$type.php");
			
		}else{
			
			echo"0\n";
			echo"<b>Invalid type!</b> type= 'attack' || 'constructing' || 'cooking' || 'defence' || 'farming' || 'fishing' || 'health' || 'level' || 'magic' || 'mining' || 'smithing' || 'speed' || 'strength' || 'thieving' || 'totalskill' || 'trading' || 'woodcutting' ";
			
		}
	}
	
	
}else if($request=='clanlist'){
	//// CLANLIST REQUEST
	
	
	if($CL_R>=$CL_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of clanlist requests per day ($CL_LIMIT). You should never need to make more than one of this type of request per day!";
			
	}else{
		mysqli_query($mysqli, "UPDATE api SET todaysclanlistrequests=todaysclanlistrequests+1, totalclanlistrequests =totalclanlistrequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
                            
		$QueryG = mysqli_query($mysqli, "SELECT tag, name FROM clans WHERE 1 group by tag") or die("0 Syrnia database error!");
		echo"1\n";
		while ($record = mysqli_fetch_object($QueryG))
		{
			echo"$record->tag\n$record->name\n";		
		}
	
	}
	
	
}else if($request=='claninfo'){
	//// CLANLIST REQUEST
	
	if($clan==''){
			echo"0\n";
			echo"You need to specify the clan tag.";
	}else if($O_R>=$O_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of clan requests per day ($O_LIMIT).";			
	}else{
		mysqli_query($mysqli, "UPDATE api SET todaysothers=todaysothers+1, totalothers =totalothers+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
                            
		$QueryG = mysqli_query($mysqli, "SELECT username FROM clans WHERE tag='$clan' order by pw desc") or die("0 Syrnia database error!");
		echo"1\n";
		while ($record = mysqli_fetch_object($QueryG))
		{
			echo"$record->username\n";		
		}
	
	}
	
	
}else if($request=='userlist'){
	//// userlist REQUEST
	
	
	if($UL_R>=$UL_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of userlist requests per day ($UL_LIMIT). You should never need to make more than one of this type of request per day!";
			
	}else{
		mysqli_query($mysqli, "UPDATE api SET todaysuserlistrequests=todaysuserlistrequests+1, totaluserlistrequests =totaluserlistrequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
                
		$timout=$timee-3600*24*30;            
		$QueryG = mysqli_query($mysqli, "SELECT username FROM stats where loggedin>$timout") or die("0 Syrnia database error!");
		echo"1\n";
		while ($record = mysqli_fetch_object($QueryG))
		{
			echo"$record->username\n";		
		}
	
	}
	
	
}else if($request=='activeplayerstats'){
	
	if($O_R>=$O_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of these requests per day..this should NEVER even happen! Please only request these one or two times per hour.";
			
	}else{		
		echo"1\n";
		
		mysqli_query($mysqli, "UPDATE api SET todaysothers=todaysothers+1, totalothers=totalothers+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
			  
			 $timeout=$timee-3600*24*7;                
		$QueryG = mysqli_query($mysqli, "SELECT users.username as namee,totalskill,level,fame,mining,smithing,attack,defence,strength,health,woodcutting,constructing,trading,thieving,speed,fishing,cooking,magic,farming FROM users, stats
WHERE users.username = stats.username && loggedin >=$timeout ") or die("0 Syrnia database error!");		
		while ($record = mysqli_fetch_object($QueryG))
		{
			if($record->namee!='M2H'){
				echo"$record->namee@";       
				$ex=0;
				$Query = mysqli_query($mysqli, "SELECT tag FROM clans WHERE username='$record->namee' LIMIT 1");
				while ($rec = mysqli_fetch_object($Query))
				{
					$ex=1;
					echo"$rec->tag@";
				}
				if($ex==0){
					echo"@";
				}
					
				echo"$record->totalskill@";
				echo"$record->level@";
				echo"$record->fame@";
				echo"$record->mining@";
				echo"$record->smithing@";
				echo"$record->attack@";
				echo"$record->defence@";
				echo"$record->strength@";
				echo"X@";
				echo"$record->health@";
				echo"$record->woodcutting@";
				echo"$record->constructing@";
				echo"$record->trading@";
				echo"$record->thieving@";
				echo"$record->speed@";
				echo"$record->fishing@";
				echo"$record->cooking@";
				echo"$record->magic@";
				echo"$record->farming\n";
			}
		}
	}
				
	
			
			
}else if($request=='playerprofile'){
	//// PROFILE REQUEST
	
	
	if($P_R>=$PROFILE_LIMIT){
			echo"0\n";
			echo"You have exceeded the max. number of profile requests per day ($PROFILE_LIMIT).";
			
	}else{		
		
		$found=0;		                  
		$QueryG = mysqli_query($mysqli, "SELECT totalskill,level,fame,mining,smithing,attack,defence,strength,hp,health,woodcutting,constructing,trading,thieving,speed,fishing,cooking,magic,farming FROM users WHERE username='$playername' LIMIT 1") or die("0 Syrnia database error!");		
		while ($record = mysqli_fetch_object($QueryG))
		{
		
			$found=1;
			echo"1\n";
			mysqli_query($mysqli, "UPDATE api SET todaysprofilerequests=todaysprofilerequests+1, totalprofilerequests=totalprofilerequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
          
          	$QueryP = mysqli_query($mysqli, "SELECT apiprivacy FROM options WHERE username='$playername' LIMIT 1") or die("0 Syrnia database error!");		
			while ($rec = mysqli_fetch_object($QueryP))
			{
				$privacy = $rec->apiprivacy;
			}
			if($playername=='M2H'){ $privacy=999; }
			
			echo"$privacy\n";
			if($privacy<=10){
				echo"$record->totalskill\n";
				echo"$record->level\n";
				echo"$record->fame\n";
				echo"$record->mining\n";
				echo"$record->smithing\n";
				echo"$record->attack\n";
				echo"$record->defence\n";
				echo"$record->strength\n";
				echo"X\n";
				echo"$record->health\n";
				echo"$record->woodcutting\n";
				echo"$record->constructing\n";
				echo"$record->trading\n";
				echo"$record->thieving\n";
				echo"$record->speed\n";
				echo"$record->fishing\n";
				echo"$record->cooking\n";
				echo"$record->magic\n";
				echo"$record->farming\n";
			}

			//if($privacy<=3){
				$ex=0;
				$QueryG = mysqli_query($mysqli, "SELECT tag,name FROM clans WHERE username='$playername' LIMIT 1");
				while ($record = mysqli_fetch_object($QueryG))
				{
					$ex=1;
					$tag=$record->tag;
					echo"$record->tag\n$record->name\n";
				}
				if($ex==0){
					echo"\n\n";
				}
			//	}else{
			//		echo"\n\n";
			//	}
			if($privacy<=2){
				$QueryG = mysqli_query($mysqli, "SELECT avatar, signature FROM donators WHERE username='$playername' LIMIT 1");
				while ($record = mysqli_fetch_object($QueryG))
				{
					$sig = str_replace("\n", '', $record->signature);
					$sig = str_replace("\r", '', $sig);
					//$sig = str_replace("
//", 'A', $sig);

				//	$sig = trim($sig);
					//$sig = str_replace("\r\n",'',$sig);
				//	$sig = str_replace('\r\n','',$sig);
				//	$sig = str_replace('/r','',$sig);
				//	$sig = str_replace('/n','',$sig);
					
					//$sig = str_replace('<br />','B',$sig);
					//$sig = str_replace('
//','X',$sig);
					
					
					$avatar=$record->avatar;
					if(!$avatar){
						$avatar=' ';
					}
					if(!$sig){
						$sig=' ';
					}
					echo"$avatar\n$sig\n";
				}
			}else{
				echo"\n\n";
			}
			if($privacy<=1){
				$QueryG = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$playername' LIMIT 1");
				while ($record = mysqli_fetch_object($QueryG))
				{
					$join=$record->joined;
					echo"$join\n";
				}
			}else{
				echo" \n";
			}
			if($privacy<=0){
				
				$QueryG = mysqli_query($mysqli, "SELECT name, type, itemupgrade, upgrademuch FROM items_wearing WHERE username='$playername' LIMIT 9");
				while ($record = mysqli_fetch_object($QueryG))
				{
					$equipment[$record->type]="$record->name@$record->itemupgrade@$record->upgrademuch";		
				}
				
				echo $equipment['trophy']."\n";
				echo $equipment['horse']."\n";
				echo $equipment['hand']."\n";
				echo $equipment['shield']."\n";
				echo $equipment['gloves']."\n";
				echo $equipment['helm']."\n";
				echo $equipment['body']."\n";
				echo $equipment['legs']."\n";
				echo $equipment['shoes']."\n";
			}
			
		}
		if($found==0){
			echo "0";
			if($playername){
				echo" The player you requested did not exist, this did cost you one request (use the userlist!).";
				mysqli_query($mysqli, "UPDATE api SET todaysprofilerequests=todaysprofilerequests+1, totalprofilerequests =totalprofilerequests+1 WHERE apikey='$key' LIMIT 1") or die("0 Syrnia database error");
          	}else{
          		echo"Use <b>playername=NAME</b> to query a players profile.<br />
				  <b>Output format:</b><br />
				  <div style=\"background-color:#CCCCCC;\">
				  PrivacyLevel (indicates how much this request will show)
				  totalskill<br />
				  combatlevel<br />
				  fameXP<br />
				  miningXP<br />
				  smithingXP<br />
				  attackXP<br />
				  defenceXP<br />
				  strengthXP<br />
				  hpXP<br />
				  healthXP<br />
				  woodcuttingXP<br />
				  constructingXP<br />
				  tradingXP<br />
				  thievingXP<br />
				  speedXP<br />
				  fishingXP<br />
				  cookingXP<br />
				  magicXP<br />
				  farmingXP<br />
				  ClanTag (privacy <=3)<br />
				  ClanTitle (privacy <=3)<br />
				  Avatar (privacy <=2)<br />
				  Signature (privacy <=2)<br />
				  JoinTime in unix timestamp format (privacy <=1)<br />
				  Equipment: Trophy<br />
				  Equipment: Horse<br />
				  Equipment: Left hand(Weapon)<br />
				  Equipment: Right hand(Shield)<br />
				  Equipment: Gloves<br />
				  Equipment: Helm<br />
				  Equipment: Body<br />
				  Equipment: Legs<br />
				  Equipment: Boots<br />				  
				  </div>
				  
				  ";				
			}
		}
	
	}
	
}else if($request=='freegoldforeveryone'){
	//HELP
	
	echo"1 -Done, all users got free gold.<br />";
		
	
}else if($request=='help'){
	//HELP
	
	echo"0
	Updated: 03 Aug 2009 [Note: Player Profile page equipment format changes, Added/Adding auctionhouse request]<br />
	Updated: 02 Aug 2009 [Note: First version]<br />
	<br />	
	<hr />
	<b>Valid requests:</b><br />
	<ul>
	<li><b>help</b>[No paramters]<br />Displays this list</li>
	<li><b>auction</b>[No paramters]<br />All current auctions, in the form of:<br />
	<small>Amount@Itemname@Upgrade@UpgradeAmount@NameOfOwner@X@CurrentBid@HoursLeft</small><br />
	This list also contains the auctions of the last 6 hours that have run out without bidder, but are not yet collected by the owner of the auction.<br />	
	<li><b>highscore</b>[Requires parameter: <u>type</u> Optional: <u>none</u>]<br />Request highscore info (1000 users per 'type', updated every hour). Max $HS_LIMIT requests per day.</li>
	<li><b>userlist</b>[No paramters]<br />Request a list of all users in Syrnia who logged in the last 30 days(can contain freezed and inactive players). Max $UL_LIMIT requests per day.</li>
	<li><b>clanlist</b>[No paramters]<br />Request a list of ALL clans in Syrnia. Max $CL_LIMIT requests per day. Full clan names follow a clan tag on the next line.</small></li>
	<li><b>claninfo</b>[Required parameter: <u>clan</u>]<br />Request the clan member list by clan tag.</small></li>	
	<li><b>playerprofile</b>[Required parameter: <u>playername</u> Optional: <u>none</u>]<br />Fetch player profile data. Max $PROFILE_LIMIT requests per day.</li>
	<li><b>activeplayerstats</b>[paramters]<br />A list of all players that logged in the last 14 days. In a list of NAME - ClanTag - Skill xp.</li>
	
	
	<li><b>freegoldforeveryone</b>[No paramters]<br />?! <small>(Don't bother to try ;))</small></li>
	</ul>
	<br />
	For more information about parameters, make a valid request without parameters: it will tell you about the missing parameter(s) and tell you what's possible.<br />
	<hr />
	<b>Implementation tips</b><br /><ol>
	<li>The first line of every request will contain a 1 or 0. Always check this line for an <b>1</b>, and make sure your code can handle requests that do not return 1 due to syrnia-database or network errors.</li>
	<li>Use <b>version=$API_VERSION</b> to force requests to ONLY succeed as long as the API is still using the current specified version. The current version of this script is $API_VERSION. If we update crucial parts of this script we will change the version number. If you use the version variable; the script will return 0 if you are using an older version number. This can be very handy to make sure your data will not mess up! We will <u>not</u> change the version number when adding new features, only when changing current features that could possibly mess up your data parsing.</li></ol><br />";	
	
	
}else{
	
	echo"0
	<b>Invalid request!</b> Try adding <b>&request=help</b> to the url.";
	
}

?>