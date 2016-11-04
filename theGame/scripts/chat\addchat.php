<?php

//Every valid return message send by echo, should be prefixed with "::" so that JS can verify its a real message
//This has been added 5 september 2008, to ensure the "chat buffer bleeding" isnt shown to users.

  if(defined('AZtopGame35Heyam') && (($S_staffRights['canLoginToTools']==1 && $S_MODLOGIN==1) OR $SystemMessage==1)   ){
    // included in Syrnia chat tools
   }else{
		$S_user='';
		include_once('../../../currentRunningVersion.php');
	}
	if(!$mysqli){
		include_once(GAMEPATH."includes/db.inc.php");
	}

if (!headers_sent()) {
  session_start();
  header("Cache-Control: no-cache, must-revalidate");
}

  	if(!$S_user || !$mysqli){
  		if($SystemMessage){

  		}else{
		exit();
		}
	}


if(($_REQUEST['chatMessage']!=NULL OR $_REQUEST['chatMessage']==0 )  OR ((($S_staffRights['canLoginToTools']==1 && $S_MODLOGIN==1)) && $moderator==1) OR ($SystemMessage==1)){

	//chat via mods of via system message
	if((($S_staffRights['canLoginToTools']==1 && $S_MODLOGIN==1)) && $moderator==1 OR $SystemMessage==1){
	   $whisperTo=strtolower($whisperTo);
	}else{
		$chatMessage = ($_REQUEST['chatMessage']);
		$channel = $_REQUEST['chatChannel'];

		//Newbs
		if(stristr($S_location, "Tutorial")){
		 	$channel=5;
		}

		$whisperCommandPos = strpos($chatMessage,"@");
		$whisperTo=strtolower(substr($chatMessage, 0, $whisperCommandPos));
		if($whisperTo){
			if(strlen($whisperTo)<=20){
				if(substr($whisperTo, -1)==' '){//Last character is a space
					$whisperTo = substr_replace($whisperTo ,"",-1);
				}
				$channel="W";
				$chatMessage=substr($chatMessage, $whisperCommandPos+1);

				if(stristr($S_location, "Tutorial")){
					echo"::Whisper not delivered; You can not whisper in the tutorial.";
					exit();
				}
				if(strtolower($whisperTo)==strtolower($S_user)){
					echo"::Whisper not delivered; You can not whisper yourself.";
					exit();
				}
				$resultaat = mysqli_query($mysqli,"SELECT ID FROM users WHERE username='$whisperTo'");
		 		$aantal = mysqli_num_rows($resultaat);
		 		if($aantal!=1){
		 			echo"::Whisper not delivered; The player \"$whisperTo\" does not exist.";
					exit();
		 		}
			}else{
				$whisperTo='';
				//echo"::Whisper not delivered; The username you entered is too long";
				//exit();
			}
		}
	}


	if(strstr($S_chatChannels, "[$channel]")==true && $SystemMessage<>1){ # If its an system message it may talk in any channel
	 	echo"::You have disabled this channel!";
	 	exit();
	}


 	if($channel===0 && $SystemMessage){$channel=$channel;	//? clan/login etc.?
	}else if($channel==0 && $SystemMessage && ($moderator==1 || $systemOverride==1)){$channel=$channel; //event tools chat tool
	}else if($channel=='W'){$channel="W_$whisperTo";
	}else if($channel==1){$channel="1_".$S_mapNumber;
	}elseif($channel==2 OR $channel==4){$channel=$channel;
	}elseif($channel==3){ if($S_clantag<>'' && stristr ($S_clantag, "\\")==false &&  stristr ($S_clantag, "/")==false){$channel=$channel.'_'.htmlspecialchars($S_clantag); }else{  echo"::You are not in a clan!";  exit(); }
	}elseif($channel==6 && ($S_side=='Pirate' OR $moderator==1 OR $SystemMessage)){ $channel=$channel;
	}elseif($channel==5){$channel=$channel;
	}elseif($channel==89 && ($S_chatTag=='Mod' OR $S_chatTag=='Guide' OR $S_chatTag=='Admin' OR $moderator==1 && ($S_staffRights['chatMod']==1))){ $channel=$channel;

	}elseif($channel==99 && ($S_staffRights['generalChatAccess']==1) && $S_MODLOGIN==1){ $channel=$channel;
	}elseif($channel==98 && ($S_staffRights['chatMod']==1) && $S_MODLOGIN==1){ $channel=$channel;
	}elseif($channel==97 && ($S_staffRights['forumMod']==1) && $S_MODLOGIN==1){ $channel=$channel;
	}elseif($channel==96 && ($S_staffRights['bugsMod']==1) && $S_MODLOGIN==1){ $channel=$channel;
	}elseif($channel==95 && ($S_staffRights['multiMod']==1) && $S_MODLOGIN==1){ $channel=$channel;

	}elseif($channel==90 && ($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']  || $S_staffRights['multiSeniormod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['leadmod'] || $S_staffRights['bugsSupervisor']) && $S_MODLOGIN==1){ $channel=$channel;


	//}elseif(	substr($chatMessage, 0, 1)=='/' ){  $postName=stristr(substr($chatMessage, 1), '/', true);		}
	}else{ echo"::Error 1; cannot post to this channel"; exit(); }

} else {  // empty
	echo"::You didn't enter any message. (1)";
	exit();
}



 //if($chatMessage==''){$chatMessage='empty line.'; }

if($S_user OR $SystemMessage){
$datum = date("H:i");
$timee=time();
   $resultaat = mysqli_query($mysqli, "SELECT chat FROM stats WHERE username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $DBchat=$record->chat;
	 //$S_lastaction=$record->lastaction;
	}



if($DBchat<$timee || $SystemMessage){  #DBchat is mute time

//if($S_lastaction<>'' AND $S_lastaction>$timee-2700){
 //$onlinetime=$timee-$S_lastaction;
//	mysqli_query($mysqli,"UPDATE stats SET lastaction='$timee', online=online+'$onlinetime' WHERE username='$S_user' LIMIT 1") or die("error --> chat 544343");
//}



$bericht=stripslashes($chatMessage);

$bericht=substr(htmlspecialchars($bericht), 0,160);
$bericht=str_replace("\&quot;", "&quot;", $bericht);
//$bericht=preg_replace("([^ ]{75})"," \\1 ",$bericht);
 //"([^ <>\"\\-]{50})"

if($channel == 3 || $channel >= 89)
{
    preg_match('/(http:\/\/[^\s]+)/', $bericht, $text);
    $hypertext = "<a href='". $text[0] . "' target='_blank'>" . $text[0] . "</a>";
    $bericht = preg_replace('/(http:\/\/[^\s]+)/', $hypertext, $bericht);
	
    preg_match('/(https:\/\/[^\s]+)/', $bericht, $text);
    $hypertext = "<a href='". $text[0] . "' target='_blank'>" . $text[0] . "</a>";
    $bericht = preg_replace('/(https:\/\/[^\s]+)/', $hypertext, $bericht);
}

$bericht=addslashes($bericht);

if(stristr ($bericht, "Fuck") === false && stristr ($bericht, "cunt") === false){


#Status
$status='';
if($S_chatTag){
 	if($S_chatTag=='Guide'){//Only show in help&guide chat
		if($channel==5 OR $channel==89){
			$status="($S_chatTag)";
		}
	}else{//Always show
		$status="($S_chatTag)";
	}
}



#### DRUNK

if($S_drunk>$timee && $moderator!=1 && $SystemMessage!=1 && $channel!=99 && $channel!=89 && $channel!=4 && $channel!=5){
	$drunkie=rand(1,5);
	if($S_drunk>60 && $drunkie==1){$bericht=str_replace("a", "ee", "$bericht");}
	elseif($S_drunk>100 && $drunkie==5){$bericht=str_replace("o", "oe", "$bericht");}
	elseif($S_drunk>120 && $drunkie==2){$bericht=str_replace("b", "bw", "$bericht");}
	elseif($S_drunk>200 && $drunkie==3){$bericht=str_replace("e", "ie", "$bericht");}
	elseif($S_drunk>300 && $drunkie==4){$bericht=str_replace("m", "h", "$bericht");}
	$drunkie=rand(1,5);
	if($S_drunk>60 && $drunkie==1){$bericht=str_replace("i", "ie", "$bericht");}
	elseif($S_drunk>100 && $drunkie==5){$bericht=str_replace("r", "ar", "$bericht");}
	elseif($S_drunk>120 && $drunkie==2){$bericht=str_replace("s", "sl", "$bericht");}
	elseif($S_drunk>200 && $drunkie==3){$bericht=str_replace("p", "phu", "$bericht");}
	elseif($S_drunk>300 && $drunkie==4){$bericht=str_replace("d", "du", "$bericht");}
	$drunkie=rand(1,5);
	if($S_drunk>60 && $drunkie==1){$bericht=str_replace("h", "ha", "$bericht");}
	elseif($S_drunk>100 && $drunkie==5){$bericht=str_replace("a", "", "$bericht");}
	elseif($S_drunk>120 && $drunkie==2){$bericht=str_replace("e", "", "$bericht");}
	elseif($S_drunk>200 && $drunkie==3){$bericht=str_replace("o", "", "$bericht");}
	elseif($S_drunk>300 && $drunkie==4){$bericht=str_replace("i", "", "$bericht");}
	$drunkie=rand(1,5);
	if($S_drunk>100 && $drunkie==5){$bericht=str_replace("a ", "<B>*burp*</B>", "$bericht");}
	elseif($S_drunk>200 && $drunkie==1){$bericht=str_replace("hey", "<B>*hic*</B>", "$bericht");}
	elseif($S_drunk>300 && $drunkie==2){$bericht=str_replace("hi", "<B>*hic*</B>", "$bericht");}
	elseif($S_drunk>400 && $drunkie==3){$bericht=str_replace("hey", "<B>*burp*</B>", "$bericht");}
	elseif($S_drunk>500 && $drunkie==4){$bericht=str_replace("hi", "<B>*burp*</B>", "$bericht");}
} ###### DRUNK

if(strlen(trim($bericht)) > 0){


if($S_donation>=100 && ($S_user!='Lalma' && $S_user!='Neslon')  ){
 	$beginTag="<u>"; $closeTag="</u>";
}else{
 	$beginTag=''; $closeTag='';
}

if($S_clantag){
 	$tag="<em>[".htmlspecialchars($S_clantag)."]</em>";
}

if($SystemMessage==1){
	if($BoldSystemMessage==1){
		$bericht="$datum <strong>$bericht</strong>";
	}else{
	 	$bericht="$datum <em>$bericht</em>";
	}
}elseif(($S_staffRights['canLoginToTools']==1 && $S_MODLOGIN==1) && $moderator==1){
	$bericht="$datum <strong><em>(Mod)</em>Moderator</strong>: $bericht ";
}else{
	if($status != ''){
	 	$status = '<em>' . $status . '</em>';
	}
	$bericht="$datum <strong>$status$beginTag$S_user$closeTag</strong>$tag: $bericht";
}

##### ADD CHAT MESSAGE
$MSG=($bericht);
if($whisperTo){
	if(!$SystemMessage==1 && !$moderator){//dont display this at the live pages (report, mod tools)
		echo"::&&&addChat('To: $whisperTo', '$MSG');";
	}
	$file = CHATLOGPATH."chatnew_whisper.php";
}else {
	$file = CHATLOGPATH."chatnewtxt.php";
}

/*****
include($file);
$NUMMER=max(array_keys($chat))+1;

if($channel=='' && $channel<>0){$channel='emptychannel';}
//[i][1] Channel
//[i][2] Text
## NEW CHAT ITEM
$newtekst='<?
$'."chat[$NUMMER][1]='$channel';".'$'."chat[$NUMMER][2]='$MSG';";

$message=$NUMMER-1;
while($message>$NUMMER-40){
	//if($MSG==$chat[$message][2] && strlen($MSG)>=200){$SPAM=1; }  ## SPAM CONTROLL
	//else
	if(!DEBUGMODE && stristr ($chat[$message][2], "<strong>$status$beginTag$S_user$closeTag</strong>") == true){ $ownMessages++;  } #SPAM CONTROLL 2
	## OLD CHAT ITEMS
	$newtekst.="
	".'$'."chat[$message][1]='".($chat[$message][1])."'; ".'$'."chat[$message][2]='".addslashes($chat[$message][2])."'; ";
	$message=$message-1;
}

##CLOSE
$newtekst.="
?>";
***/

if($SPAM!=1 OR $DEBUGMODE){ // 6/40 messages
if($ownMessages<=10 || $S_user=='M2H' OR $S_user=='edwin'){

/****
if (!$file_handle = fopen($file,"w")) {  }
//if (flock($fp, LOCK_EX)) { // do an exclusive lock
    if (!fwrite($file_handle, $newtekst)) { echo "::Chat post error: Failed adding your line!";  }
 //   flock($fp, LOCK_UN); // release the lock
//} else {
//    echo "::Chat post error: 3";
//}
fclose($file_handle);
****/


mysqli_query($mysqli, "INSERT INTO chatbuffer (message, channel) VALUES ('$bericht', '$channel')") or die("ERROR please report chatB []!");



## EINDE ADD CHAT MSG

/*
 ##LOG
 if($channel==0 OR $channel==1 OR $channel==2){
 $file = CHATLOGPATH."chatlogs/".date("Y_m_d").".php";
 chmod ("$file", 0666);
 if (!$file_handle = fopen($file,"r")) { echo ""; }
 if (!$file_contents = fread($file_handle, filesize($file))) { echo ""; }
 $file_contents=stripslashes($file_contents);
 fclose($file_handle);
 if (!$file_handle = fopen($file,"w")) { echo ""; }
if($channel != 4){
	$file_contents="[$channel] $MSG\n$file_contents";
} elseif($channel == 4) {
	$file_contents="[$channel]<!--P--> $MSG\n$file_contents";
}
 if (!fwrite($file_handle, $file_contents)) { echo "Error hist"; }
 fclose($file_handle);
 }
 ## LOG
*/
// Saucy's Chat Logging
//	if($channel == 99){
	$chatLogFileContents2='';
	if(  ($channel==0 && $SystemMessage) || $channel == 2 || $channel == 4 || substr($channel,0,1) == 3 || $channel == 6 || $channel == 5 || substr($channel,0,1) == 1  || $channel == 89 || $channel==99 || $channel==98 || $channel==97 || $channel==96 || $channel==95 || $channel==90 || substr($channel,0,1) == 'W'){
		switch(substr($channel,0,1)){
			case 'W':
				$chatType = "whisper";
				$chatLogFileContents="[W] $MSG\n";
				$chatLogFileContents2="[To: $whisperTo] $MSG\n";
				break;
			case 0:
				$chatType = "world";
				$chatLogFileContents="[$channel] $MSG\n";
				break;
			case 1:
				$chatType = "region";
				$chatLogFileContents="[$channel] $MSG\n";
				break;
			case 2:
				$chatType = "world";
				$chatLogFileContents="[$channel] $MSG\n";
				break;
			case 4:
				$chatType = "trade";
				$chatLogFileContents="[$channel] $MSG\n";
				break;
			case 3:
				$chatType = "clan";
				$chatLogFileContents="[$channel]<!--C--> $MSG\n";
				break;

			case 5:
				$chatType = "help";
				$chatLogFileContents="[$channel] $MSG\n";
				break;
			case 6:
				if(strtolower($S_side) == "pirate" OR $SystemMessage OR $moderator){
    					$chatLogFileContents="[$channel]<!--P--> $MSG\n";
    					$chatType = "pirate";
    				} elseif(strtolower($S_side) == "elf"){
    					$chatLogFileContents="[$channel]<!--E--> $MSG\n";
    					$chatType = "elf";
    				}
				break;

		}

		if($channel == 89){
			$chatType = "guide";
			$chatLogFileContents="[$channel] $MSG\n";
		}else if($channel == 99){
			$chatType = "mod";
			$chatLogFileContents="[$channel] $MSG\n";
		}else if($channel == 98){
			$chatType = "mod_chat";
			$chatLogFileContents="[$channel] $MSG\n";
		}if($channel == 97){
			$chatType = "mod_forum";
			$chatLogFileContents="[$channel] $MSG\n";
		}if($channel == 96){
			$chatType = "mod_bugs";
			$chatLogFileContents="[$channel] $MSG\n";
		}if($channel == 95){
			$chatType = "mod_multi";
			$chatLogFileContents="[$channel] $MSG\n";
		}if($channel == 90){
			$chatType = "mod_SS";
			$chatLogFileContents="[$channel] $MSG\n";
		}

	$chatLogFile2='';
    if($chatType == 'clan' && $S_clantag != '')
    {
	      // This little bit of magic makes the clan tags into safe filenames
	      $clantagSplit = str_split($S_clantag);
	      $clantagASCII = array();
	      for($ord = 0; $ord < count($clantagSplit); $ord++)
	      {
	        $clantagASCII[$ord] = ord($clantagSplit[$ord]);
	      }
	      $clantagDIR = CHATLOGPATH . "chatlogs/clan/" . date("Y_m_d") . "/";
	      if(!is_dir($clantagDIR))
	      {
	        mkdir($clantagDIR, 0777);
	      }
		$chatLogFile = $clantagDIR . implode("_", $clantagASCII) . ".php";
    } elseif($chatType == 'region') {
  		$chatLogFile = CHATLOGPATH . "chatlogs/$chatType/".$S_mapNumber."_" . date("Y_m_d") . ".php";
	} elseif($chatType == 'whisper') {
  			$chatDir1 = CHATLOGPATH . "chatlogs/$chatType/" . date("Y_m_d") . "/";
	      	if(!is_dir($chatDir1))
	      	{
	        	mkdir($chatDir1, 0777);
	      	}
		  $chatLogFile = $chatDir1.strtolower($whisperTo)."_" . date("Y_m_d") . ".php";
		  	$chatDir2 = CHATLOGPATH . "chatlogs/$chatType/" . date("Y_m_d") . "/";
	      	if(!is_dir($chatDir2))
	      	{
	        	mkdir($chatDir2, 0777);
	      	}
		  $chatLogFile2 = $chatDir2.strtolower($S_user)."_" . date("Y_m_d") . ".php";


	} elseif($chatType != 'clan') {
  		$chatLogFile = CHATLOGPATH . "chatlogs/$chatType/" . date("Y_m_d") . ".php";
  	} else {
      $chatLogFile = '';
    }

		//

		//$chatLogFile = CHATLOGPATH . "chatlogs/$chatType/" . date("Y_m_d") . ".php";

		//$file = CHATLOGPATH . "chatlogs/" . date("Y_m_d") . ".php";
    if($chatLogFile)
    {
  		$chatLogFileContents=stripslashes($chatLogFileContents);
  		if (!$chatLogFileHandle = fopen($chatLogFile,"a")) {  }//echo "Temporary error cannot append to log file.";
   		if (!fwrite($chatLogFileHandle, $chatLogFileContents)) {  } //echo "Temporary error cannot append to log file.";
  		fclose($chatLogFileHandle);
  	}
  	if($chatLogFile2 && !$SystemMessage==1 && !$moderator) //Whisper needs double logging
    {
  		$chatLogFileContents2=stripslashes($chatLogFileContents2);
  		if (!$chatLogFileHandle = fopen($chatLogFile2,"a")) {  }//echo "Temporary error cannot append to log file.";
   		if (!fwrite($chatLogFileHandle, $chatLogFileContents2)) {  } //echo "Temporary error cannot append to log file.";
  		fclose($chatLogFileHandle);
  	}
	}

}else{
 	echo"::Your message has been blocked as it was labeled as SPAM(1).";
}#SPAM1
}else{
 	echo"::Your message has been blocked as it was labeled as SPAM(2).";
}#SPAM2

}else{#BERICHT
 	echo"::You didn't add any message (2)";
}

} #fuck



}else{
 	echo"::$datum : You have been muted for ".ceil(($DBchat-time())/60)." more minutes, check your messages for a reason.";
} #MUTED

}else{ # USER
	echo"::You are not logged in (anymore)";
}

?>
