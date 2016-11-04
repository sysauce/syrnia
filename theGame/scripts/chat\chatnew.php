<?php
header("Content-Type: text/html;charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");
session_start();

if($S_user){

require_once('../../../currentRunningVersion.php');

if(!$mysqli){
	include_once(GAMEPATH."includes/db.inc.php");
}

if(!$S_lastChatMSGID){
	//Temporary fix
	$S_lastChatMSGID = '';
	$_SESSION["S_lastChatMSGID"] =$S_lastChatMSGID;
}


if($S_lastChatMSGID==''   ){  //OR $S_lastchatvar[0]<min(array_keys($chat))
 	//Get all chatlines (from the lowest available number)
 	//Looks like user just loaded, or needs to catch up quickly
	$resultaat = mysqli_query($mysqli, "SELECT ID FROM chatbuffer ORDER BY ID DESC LIMIT 1");
	while ($record = mysqli_fetch_object($resultaat))
	{
		$S_lastChatMSGID=$record->ID-5;
	}
echo"//exit X
";
	exit(); //
}

$checkClan = false;

$resultaat = mysqli_query($mysqli, "SELECT ID,message, channel FROM chatbuffer WHERE ID>".$S_lastChatMSGID." ORDER BY ID ASC");
while ($record = mysqli_fetch_object($resultaat))
{
	$lastID=$record->ID;
	$kanaal=$record->channel;
	if(
			$kanaal=="0"
			OR ($kanaal=="1_$S_mapNumber")
			OR $kanaal==2
			OR ($kanaal=="3_$S_clantag" && $S_clantag<>'' )
			OR $kanaal==4
			OR ($kanaal==6 && ($S_side=='Pirate' OR ($S_staffRights['chatMod']==1 && $S_MODLOGIN==1)))
			OR $kanaal==5
			OR $kanaal=="W_".strtolower($S_user)
			OR ($kanaal==89 && ((($S_staffRights['chatMod']==1) && $S_MODLOGIN==1) OR $S_chatTag=='Guide')  )
			OR ($kanaal==99 && ($S_staffRights['generalChatAccess']==1) && $S_MODLOGIN==1)
			OR ($kanaal==98 && ($S_staffRights['chatMod']==1) && $S_MODLOGIN==1)
			OR ($kanaal==97 && ($S_staffRights['forumMod']==1) && $S_MODLOGIN==1)
			OR ($kanaal==96 && ($S_staffRights['bugsMod']==1) && $S_MODLOGIN==1)
			OR ($kanaal==95 && ($S_staffRights['multiMod']==1) && $S_MODLOGIN==1)
			OR ($kanaal==90 && ($S_staffRights['chatSeniormod'] || $S_staffRights['chatSupervisor'] || $S_staffRights['forumSeniormod'] || $S_staffRights['forumSupervisor']   || $S_staffRights['multiSeniormod'] || $S_staffRights['leadmod'] || $S_staffRights['multiSupervisor'] || $S_staffRights['bugsSeniormod'] || $S_staffRights['bugsSupervisor']) && $S_MODLOGIN==1)

	){
        if($kanaal=="3_$S_clantag" && $S_clantag<>'')
        {
            if(strpos($record->message, "<em>$S_user has been kicked from the clan") > 0)
            {
                $S_clantag = "";
                $_SESSION["S_clantag"]= $S_clantag;
                $S_clanstockhouses = array();
            }
            if(strpos($record->message, "<em>") > 0 && strpos($record->message, "has bought some land to build") > 0)
            {
                $S_clanstockhouses = array();
                if($S_addStock)
                {
                    $sql = "SELECT * FROM clanbuildings WHERE tag='$S_clantag' ORDER BY location ASC";
                    $resultset = mysqli_query($mysqli,$sql);
                    if($rec = mysqli_fetch_object($resultset))
                    {
                        do
                        {
                            $S_clanstockhouses[$rec->location] = true;
                        }while($rec = mysqli_fetch_object($resultset));
                    }
                }
                $_SESSION["S_clanstockhouses"] = $S_clanstockhouses;
            }
        }

	  	if($kanaal>=89){
	  		//Nothing (dont cut of last numbers)
	  	}else{
			$kanaal=substr($kanaal, 0,1);
		}

		if(strstr($S_chatChannels, "[$kanaal]")===false && (!stristr($S_location, "Tutorial") OR $kanaal==5)   ){
			$msg=addslashes($record->message);
			if($msg && $kanaal!=''){
				echo"addChat('$kanaal', '$msg');";
			}
		} # Ignoring channel

	}# echo"//not allowed to see ".$chat[$i][1]."<br />";

}
if(is_numeric($lastID)){
	$S_lastChatMSGID=$lastID;
}
##END OTHER CHANNELS


}else{
 ?>
chatSwitch();
//alert("Your chat doesn't work (anymore) because either you've been logged out, or your browser is having session problems. Your chat has been disabled.");
<?php
 }#nologin
//}
?>
