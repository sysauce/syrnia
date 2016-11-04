<?

class ChatInput {

  public function sendModMessage($channel, $playername, $message)
  {

    $this->limit = 400;
    $this->status = 'Mod';

   	$this->chatLineID();
  	$this->time = date('H:i');

    $this->channel = $channel;
    $this->donator = '';
  	$this->playername = htmlentities($playername, ENT_QUOTES, 'UTF-8');
  	$this->clan = '';
  	$this->message = $message;

  }


  public function sendPlayerMessage($channel, $donator, $playername, $clan, $message)
  {

    if($this->checkMute())
    {
      return 'Muted';
    }

    if($playername == 'M2H')
    {
      $this->status = 'Admin';
    }

    $this->limit = 200;

  	$this->chatLineID();
  	$this->time = date('H:i');

    $this->channel = $channel;
    $this->donator = $donator;
  	$this->playername = htmlentities($playername, ENT_QUOTES, 'UTF-8');
  	$this->clan = htmlentities($clan, ENT_QUOTES, 'UTF-8');
  	$this->message = $message;

  	if($this->checkChannel() && $this->checkMessage())
  	{
      $add2Chat = $this->add2Chat();
      if($add2Chat == 1)
      {
        return 1;
      } else {
        return $add2Chat;
      }

    } else {
      return $this->checkChannel() . ' ' . $this->checkMessage();
    }

  }

  public function checkMute()
  {
    if(time() < $_SESSION['mute'])
    {
      return 1;
    }
    return 0;
  }

  public function checkChannel() {
    // add checks in!
	// chan permission checks
	// Mod checks
	// etcs.

	/*
	    if($channel==0 && $SystemMessage){$channel=$channel;
	}elseif($channel==1 OR $channel==2){$channel=$channel;
	}elseif($channel==3){ if(Sclantag<>'' && stristr ($S_clantag, "\\")==false &&  stristr ($S_clantag, "/")==false){$channel=$channel.'_'.htmlspecialchars($S_clantag); }else{  echo"You are not in any clan!";  exit(); }
	}elseif($channel==4 && ($S_side=='Pirate' OR $moderator==1)){ $channel=$channel;
	}elseif($channel==5){$channel=$channel;
	}elseif($channel==99 && $S_moderation['chat']==1 && $S_MODLOGIN==1){ $channel=$channel;
	}else{ echo"Error, cannot post to channel"; exit(); }
	*/
    return 1;
  }

  public function checkMessage() {
	if(stristr($this->message,'fuck')) {
	  return 'Swearing';
	} else {
    return 1;
  }
  }

  public function drunkChatMessage()
  {
    $bericht = $this->message;

    $drunkie=rand(1,5);
    if($S_drunk>60 && $drunkie==1){$bericht=str_replace("a ", "ee", "$bericht");}
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
    if($S_drunk>100 && $drunkie==5){$bericht=str_replace("a ", "<strong>*burp*</strong>", "$bericht");}
    elseif($S_drunk>200 && $drunkie==1){$bericht=str_replace("hey", "<strong>*hic*</strong>", "$bericht");}
    elseif($S_drunk>300 && $drunkie==2){$bericht=str_replace("hi", "<strong>*hic*</strong>", "$bericht");}
    elseif($S_drunk>400 && $drunkie==3){$bericht=str_replace("hey", "<strong>*burp*</strong>", "$bericht");}
    elseif($S_drunk>500 && $drunkie==4){$bericht=str_replace("hi", "<strong>*burp*</strong>", "$bericht");}

    $this->message = $beright;

  }

  public function processChatChannel() {
    return $this->channel;
  }

  public function processChatMessage() {
    return htmlentities($this->message, ENT_QUOTES, 'UTF-8');
    if($_SESSION['S_drunk'] > time())
    {
      $this->drunkChatMessage();
    }
  }

  public function chatLineID() {

  	$this->chatLineID = number_format(microtime(true), 2, '.', ''); // Hopefully unique and incrementing, could make more unique if needed
  	/*
  	$microtime = explode(' ', strval(microtime()));
  	$chatBufferArrayKey = number_format($microtime[0] + $microtime[1], 4, '.', ''); // More unique
      */

  }

  public function chatBufferFile()
  {
    return "{$FULLPATH}chatBuffer.php";
  }

  public function add2Buffer()
  {

    $channel = $this->processChatChannel();

    $message = $this->processChatMessage();

    $chatBufferLine = '$' . "cBA['$this->chatLineID']['line'] = '$this->chatLineID'; " .
  	                  '$' . "cBA['$this->chatLineID']['channel'] = '$channel'; " .
  	                  '$' . "cBA['$this->chatLineID']['time'] = '$this->time'; " .
  	                  '$' . "cBA['$this->chatLineID']['status'] = '$this->status'; " .
  	                  '$' . "cBA['$this->chatLineID']['donator'] = '$this->donator'; " .
  	                  '$' . "cBA['$this->chatLineID']['playername'] = '$this->playername'; " .
  	                  '$' . "cBA['$this->chatLineID']['clan'] = '$this->clan'; " .
  	                  '$' . "cBA['$this->chatLineID']['message'] = '$message';";

    if(rand(1,5) == 3 || file_exists("{$FULLPATH}chatbuffers/chatBuffer.php")) {

     	require_once("{$FULLPATH}chatbuffers/chatBuffer.php"); // Include the file

  	  while(count($cBA) > 20) { // Remove the oldest entries
  	    array_shift($cBA);
  	  }

  	  $chatBufferFileContents = "<?php\n";

  	  while(count($cBA) > 0) {

  	    $chatBufferLineArray = array_shift($cBA);

  	    $chatBufferFileContents = $chatBufferFileContents .
                                  '$' . "cBA['{$chatBufferLineArray['line']}']['line'] = '{$chatBufferLineArray['line']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['channel'] = '{$chatBufferLineArray['channel']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['time'] = '{$chatBufferLineArray['time']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['status'] = '{$chatBufferLineArray['status']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['donator'] = '{$chatBufferLineArray['donator']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['playername'] = '{$chatBufferLineArray['playername']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['clan'] = '{$chatBufferLineArray['clan']}'; " .
  	                              '$' . "cBA['{$chatBufferLineArray['line']}']['message'] = '{$chatBufferLineArray['message']}'; \n";
  	  }

  	  $chatBufferFileContents = $chatBufferFileContents . $chatBufferLine . "\n?>";

  	  if(!$chatBufferFileHandle = fopen("{$FULLPATH}chatbuffers/chatBuffer.php",'w'))
      {
  	    return 'CannotOpenChatBufferFileToWrite';
  	  } else {
        if(!fwrite($chatBufferFileHandle, $chatBufferFileContents))
        {
    	    fclose($chatBufferFileHandle);
    	    return 'CannotWriteChatBufferFile';
        } else {
          fclose($chatBufferFileHandle);
        }
      }

  	} else { // if not random

  	  if(!$chatBufferFileHandle = fopen("{$FULLPATH}chatbuffers/chatBuffer.php",'a'))
      {
  	    return 'CannotOpenChatBufferFileToAppend';
  	  } else {

  	    $chatBufferFileContents = "<?php\n";

    	  $chatBufferFileContents = $chatBufferFileContents . $chatBufferLine . "\n?>";

        if (!fwrite($chatBufferFileHandle, $chatBufferFileContents))
        {
    		  fclose($chatBufferFileHandle);
    		  return 'CannotWriteChatBufferFile';
    	  } else {
          fclose($chatBufferFileHandle);
        }
    	}

    	return 1;

    }

  }

  public function add2History() {
    return 1;
  }

  public function add2Chat()
  {

    $checkChan = $this->checkChannel(); // Check if allowed to post to channel

    if($checkChan != 1) { // if not
  	  return $checkChan; // return error message
  	}

    $checkMessage = $this->checkMessage(); // Check if allowed to post to channel
    if($checkMessage != 1) { // if not
  	  return $checkMessage; // return error message
  	}

    $add2Buffer = $this->add2Buffer(); // Add message to the buffer

  	if($add2Buffer == 1) { // if it works
  	  $add2History = $this->add2History(); // Add message to the history

  	  if($add2History == 1) { // if it works
  	    return 1; // yey!
  	  } else { // if not
  	    return $add2History; // return error message
  	  }
  	} else { // if not
  	  return $add2Buffer; // return error message
  	}
  }
}


/*
// Saucy's Chat Logging
	if($channel == 99) && $S_user == "SaucyWhopper"){
//	if(substr($channel,0,1) == 3 || $channel == 99){

		switch(substr($channel,0,1)){
			case 0:
				$chatType = "world";
				break;
			case 1:
				$chatType = "world";
				break;
			case 2:
				$chatType = "trade";
				break;
			case 3:
				$chatType = "clan";
				break;
			case 4:
				$chatType = strtolower($S_side);
				break;
			case 5:
				$chatType = "help";
				break;
		}

		if($channel == 99){
			$chatType = "mod";
		}

		$chatLogFile = CHATLOGPATH . "chatlogs/$chatType/" . date("Y_m_d") . ".php";

		//

		//$file = $FULLPATH . "chatlogs/" . date("Y_m_d") . ".php";


		chmod ("$chatLogFile", 0666);

		if (!$chatLogFileHandle = fopen($chatLogFile,"r")) { echo ""; }

		if (!$chatLogFileContents = fread($chatLogFileHandle, filesize($chatLogFile))) { echo ""; }

		fclose($chatLogFileHandle);

		$chatLogFileContents=stripslashes($chatLogFileContents);

		if (!$chatLogFileHandle = fopen($chatLogFile,"a")) { echo ""; }

		if($channel != 4 && substr($channel,0,1) != 3 && $channel != 99){
			$chatLogFileContents="[$channel] $MSG\n$chatLogFileContents";
		} elseif(substr($channel,0,1) == 3){
			$chatLogFileContents="[$channel]<!--C--> $MSG\n$chatLogFileContents";
		} elseif($channel == 4) {
			if(strtolower($S_side) == "pirate"){
				$chatLogFileContents="[$channel]<!--P--> $MSG\n$chatLogFileContents";
			} elseif(strtolower($S_side) == "elve"){
				$chatLogFileContents="[$channel]<!--E--> $MSG\n$chatLogFileContents";
			}

		} elseif($channel == 99){
			$chatLogFileContents="[$channel] $MSG\n";
		}

		if (!fwrite($chatLogFileHandle, $chatLogFileContents)) { echo "Error hist"; }
		fclose($chatLogFileHandle);
	}
*/

?>
