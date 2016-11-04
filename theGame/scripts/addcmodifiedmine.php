<?php



## EINDE ADD CHAT MSG

/*
 ##LOG
 if($channel==0 OR $channel==1 OR $channel==2){
 $file = /logs/chat/chatlogs/."chatlogs/".date("Y_m_d").".php";
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
print_r($S_areatag);
	$chatLogFile2='';
    if($chatType == 'clan' && $S_clantag != 'Pond')
    {
	      // This little bit of magic makes the clan tags into safe filenames
	      $clantagSplit = str_split($S_clantag);
	      $clantagASCII = array();
	      for($ord = 0; $ord < count($clantagSplit); $ord++)
	      {
	        $clantagASCII[$ord] = ord($clantagSplit[$ord]);
	      }
	      $clantagDIR = /logs/chat/chatlogs/ . "chatlogs/clan/" . date("Y_m_d") . "/";
	      if(!is_dir($clantagDIR))
	      {
	        mkdir($clantagDIR, 0777);
	      }
		$chatLogFile = $clantagDIR . implode("_", $clantagASCII) . ".php";
    } elseif($chatType == 'region') {
  		$chatLogFile = /logs/chat/chatlogs/ . "chatlogs/$chatType/".$S_mapNumber."_" . date("Y_m_d") . ".php";
	} elseif($chatType == 'whisper') {
  			$chatDir1 = /logs/chat/chatlogs/ . "chatlogs/$chatType/" . date("Y_m_d") . "/";
	      	if(!is_dir($chatDir1))
	      	{
	        	mkdir($chatDir1, 0777);
	      	}
		  $chatLogFile = $chatDir1.strtolower($whisperTo)."_" . date("Y_m_d") . ".php";
		  	$chatDir2 = /logs/chat/chatlogs/ . "chatlogs/$chatType/" . date("Y_m_d") . "/";
	      	if(!is_dir($chatDir2))
	      	{
	        	mkdir($chatDir2, 0777);
	      	}
		  $chatLogFile2 = $chatDir2.strtolower($S_user)."_" . date("Y_m_d") . ".php";


	} elseif($chatType != 'clan') {
  		$chatLogFile = /logs/chat/chatlogs/ . "chatlogs/$chatType/" . date("Y_m_d") . ".php";
  	} else {
      $chatLogFile = '';
    }

		//

		//$chatLogFile = /logs/chat/chatlogs/ . "chatlogs/$chatType/" . date("Y_m_d") . ".php";

		//$file = /logs/chat/chatlogs/ . "chatlogs/" . date("Y_m_d") . ".php";
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
