<?php

function LoginUser($username){
    $S_realIP = $_SERVER['REMOTE_ADDR'];
    $timee=time();
 	global  $mysqli;

    $sAAAl = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $resultAERt = mysqli_query($mysqli, $sAAAl);
    while ($record = mysqli_fetch_object($resultAERt))
    {

        if ($record->work != 'freezed')
        {
                $excists = 1;
                $S_side = $record->side;
				$S_userID = $record->ID;
                $S_user = $record->username;
                $dump2 = $record->dump2;
                $online = $record->online;
                $S_location = $record->location;


                $sql = "SELECT donation, layout, loggedin FROM stats WHERE username = '$username' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $S_previouslogintime = $record->loggedin;
                    $lastloggedin= floor((time() - $record->loggedin) / 3600);
                    $_SESSION["lastloggedin"]= $lastloggedin;
                    $S_layout = $record->layout;
                    $S_donation = $record->donation;
                }

                $sql = "SELECT hidePublicLogin,botcheckinterval FROM donators WHERE username = '$username' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $hidePublicLogin = $record->hidePublicLogin;
                    $_SESSION['S_botcheckinterval'] = $record->botcheckinterval;
                }

                $sql = "SELECT chatTag, alliedclans, alliedplayers FROM users_junk WHERE username = '$username' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $S_chatTag = $record->chatTag;

                    $S_playeralliedclans = strtolower($record->alliedclans);
                    $_SESSION["S_playeralliedclans"] = $S_playeralliedclans;

                    $S_playeralliedplayers = strtolower($record->alliedplayers);
                    $_SESSION["S_playeralliedplayers"] = $S_playeralliedplayers;
                }

                $sql = "SELECT chatChannels,  disableDragDrop FROM options WHERE username='$username' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $S_chatChannels = $record->chatChannels;
                    $S_disableDragDrop = $record->disableDragDrop;
                }


                $S_clantag = '';
                $sql = "SELECT tag, pw, addStock, removeStock, manageStock, alliedclans, alliedplayers FROM clans WHERE username = '$username' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $S_clantag = $record->tag;
                    //$_SESSION["S_clantag"] = $S_clantag;

                    $S_addStock = $record->addStock || $record->pw;
                    $_SESSION["S_addStock"] = $S_addStock;

                    $S_removeStock = $record->removeStock || $record->pw;
                    $_SESSION["S_removeStock"] = $S_removeStock;

                    $S_manageStock = $record->manageStock || $record->pw;
                    $_SESSION["S_manageStock"] = $S_manageStock;

                    $S_clanalliedclans = strtolower($record->alliedclans);
                    $_SESSION["S_clanalliedclans"] = $S_clanalliedclans;

                    $S_clanalliedplayers = strtolower($record->alliedplayers);
                    $_SESSION["S_clanalliedplayers"] = $S_clanalliedplayers;
                }

                $S_alliedclans = explode(",", $S_playeralliedclans . (strlen($S_playeralliedclans) > 0 ? "," : "") . $S_clanalliedclans);
                $_SESSION["S_alliedclans"]= $S_alliedclans;

                $S_alliedplayers = explode(",", $S_playeralliedplayers . (strlen($S_playeralliedplayers) > 0 ? "," : "") . $S_clanalliedplayers);
                $_SESSION["S_alliedplayers"]= $S_alliedplayers;


                //Load the clan stockhouses
                $S_clanstockhouses = array();
                if($S_addStock)
                {
                    $sql = "SELECT * FROM clanbuildings WHERE tag='$S_clantag' ORDER BY location ASC";
                    $resultset = mysqli_query($mysqli,$sql);
                    if($record = mysqli_fetch_object($resultset))
                    {
                        do
                        {
                            $S_clanstockhouses[$record->location] = true;
                        }while($record = mysqli_fetch_object($resultset));
                    }
                }
                $_SESSION["S_clanstockhouses"]= $S_clanstockhouses;

                $S_processedRequests = array();
                $_SESSION["S_processedRequests"]= $S_processedRequests;

                ### CREATE NEW QUESTS VAR
                $resulteaat = mysqli_query($mysqli,"SELECT completed, questID,subID FROM quests WHERE username='$S_user'");
                while ($rec = mysqli_fetch_object($resulteaat))
                {
                    if ($rec->completed == 1)
                    {
                        $S_questscompleted = "[$rec->questID]$S_questscompleted";
                    } else
                    {
                        $S_quests = "[$rec->questID($rec->subID)]$S_quests";
                    }
                }

                if ($record->gender == 'female')
                {
                    $S_heshe = "she";
                } else
                {
                    $S_heshe = "he";
                }


                //Because layout needs to know if its tutorial or not
                $resulteaat = mysqli_query($mysqli,
                    "SELECT mapNumber FROM locationinfo WHERE locationName='$S_location'");
                while ($rec = mysqli_fetch_object($resulteaat))
                {
                    $S_mapNumber = $rec->mapNumber;
                }

                $_SESSION['S_mapNumber'] = $S_mapNumber;



                // Lets check if the user is a Mod?
                $S_staffRights = "";
                $resulteaat = mysqli_query($mysqli,
                    "SELECT freeDonation, canLoginToTools, guideModRights, eventModRights, chatMod, chatSeniormod, chatSupervisor ,forumMod ,	forumSeniormod ,	forumSupervisor, 	bugsMod ,generalChatAccess,	bugsSeniormod ,	bugsSupervisor, 	multiMod ,	multiSeniormod ,	multiSupervisor,manualEditRights, leadmod FROM staffrights WHERE username='$S_user' LIMIT 1");
                while ($rec = mysqli_fetch_object($resulteaat))
                {
                	$S_donation+=$rec->freeDonation;

                    $S_staffRights['generalChatAccess'] = $rec->generalChatAccess;
                    $S_staffRights['canLoginToTools'] = $rec->canLoginToTools;
                    $S_staffRights['guideModRights'] = $rec->guideModRights;
                    $S_staffRights['eventModRights'] = $rec->eventModRights;
                    $S_staffRights['chatMod'] = $rec->chatMod;
                    $S_staffRights['chatSeniormod'] = $rec->chatSeniormod;
                    $S_staffRights['chatSupervisor'] = $rec->chatSupervisor;
                    $S_staffRights['forumMod'] = $rec->forumMod;
                    $S_staffRights['forumSeniormod'] = $rec->forumSeniormod;
                    $S_staffRights['forumSupervisor'] = $rec->forumSupervisor;
                    $S_staffRights['bugsMod'] = $rec->bugsMod;
                    $S_staffRights['bugsSeniormod'] = $rec->bugsSeniormod;
                    $S_staffRights['bugsSupervisor'] = $rec->bugsSupervisor;
                    $S_staffRights['multiMod'] = $rec->multiMod;
                    $S_staffRights['multiSeniormod'] = $rec->multiSeniormod;
                    $S_staffRights['multiSupervisor'] = $rec->multiSupervisor;
                    $S_staffRights['manualEditRights'] = $rec->manualEditRights;
					$S_staffRights['leadmod'] = $rec->leadmod;


                }
                $_SESSION["S_staffRights"]= $S_staffRights;

                   setcookie("Syrnia", $S_user, time() + 14400);
                $S_lastrefresh = 0;
                $_SESSION["S_previouslogintime"]= $S_previouslogintime;
                $_SESSION["S_heshe"]= $S_heshe;
                $_SESSION["S_side"]= $S_side;
                $_SESSION["S_quests"]= $S_quests;
                $_SESSION["S_questscompleted"]= $S_questscompleted;
                $_SESSION["S_clantag"]= $S_clantag;
                $_SESSION["S_chatTag"]= $S_chatTag;
                $_SESSION["S_donation"]= $S_donation;
				$_SESSION["S_userID"]= $S_userID;
                $_SESSION["S_user"]= $S_user;
                $_SESSION["S_realIP"]= $S_realIP;
                $_SESSION["S_location"]= $S_location;
                $_SESSION["S_mapNumber"]= $S_mapNumber;
                $S_lastactive = $timee;
                $_SESSION["S_lastactive"]= $S_lastactive;
                $S_lastchatvar[0] = '';
                $S_lastchatvar[1] = '';
				$_SESSION["S_lastchatvar"]= $S_lastchatvar;
                $_SESSION["S_layout"]= $S_layout;

                $_SESSION["S_chatChannels"]= $S_chatChannels;
                $_SESSION["S_disableDragDrop"]= $S_disableDragDrop;


                ##IP LOG
                $S_realIP = $_SERVER['REMOTE_ADDR'];
                $resultaaat = mysqli_query($mysqli, "SELECT IP FROM ips WHERE ip='$S_realIP' && username='$S_user' LIMIT 1");
                $aaantal = mysqli_num_rows($resultaaat);
                if ($aaantal == 1)
                {
                    $sql = "UPDATE ips SET count=count+1, lastlogin='$timee' WHERE username='$S_user' && IP='$S_realIP' LIMIT 1";
                    mysqli_query($mysqli, $sql) or die("error report this bug please X6");
                } else
                {
                    mysqli_query($mysqli, "INSERT INTO ips (username, IP, count, lastlogin)VALUES ('$S_user', '$S_realIP', '1', '$timee')") or
                        die("error  ");
                }
                ### IP LOG


                $timee = time();
                mysqli_query($mysqli, "UPDATE stats SET loggedin='$timee', lastaction='$timee', inactivemailed=0 WHERE username='$S_user' AND (SELECT online FROM users WHERE username = '$S_user') = 0 LIMIT 1") or
                    die("error --> 23443");
                mysqli_query($mysqli, "UPDATE users SET online=1 WHERE username='$S_user' LIMIT 1") or
                    die("error --> 2435543");


                if ($online != 0)
                {

                } else
                    if ($S_user == 'M2H')
                    {
                        ##LOG
                        $file = "logs/logins/" . $S_user . ".php";
                        if (!$file_handle = fopen($file, "a"))
                        {
                            echo "Cannot open file";
                        }
                        $file_contents = "$S_user logged in at $S_realIP on $datum<br />\n";
                        if (!fwrite($file_handle, $file_contents))
                        {
                            echo "Cannot write to file";
                        }
                        fclose($file_handle);

                    } else
                    {

                        if ($work <> 'Misbehaviour')
                        {
						//Hide logins from chat

                            if($hidePublicLogin<1)
							{
                                ### ADD CHAT MESSAGE
                                $SystemMessage = 1;
                                $chatMessage = "$S_user has logged in";
                                $channel = 1;
                                if (stristr($S_location, 'Tutorial'))
                                {
                                    $channel = 5;
                                }
                                include (GAMEFOLDER . "/scripts/chat/addchat.php");
                                ### EINDE CHAT MESSAGE
							}

							if($hidePublicLogin<2)
							{
                                if ($S_clantag)
                                {
                                    ### ADD CLAN CHAT MESSAGE
                                    $SystemMessage = 1;
                                    $chatMessage = "$S_user has logged in";
                                    $channel = 3;
                                    include (GAMEFOLDER . "/scripts/chat/addchat.php");
                                    ### EINDE CLAN CHAT MESSAGE
                                }
                            }

                        }
                            $datum = date("d-m-Y H:i");

                            ##LOG
                            $file = "logs/logins/" . $S_user . ".php";
                            if (!$file_handle = fopen($file, "a"))
                            {
                                echo "Cannot open file";
                            }
                            $file_contents = "$S_user logged in at $S_realIP on $datum<br />\n";
                            if (!fwrite($file_handle, $file_contents))
                            {
                                echo "Cannot write to file";
                            }
                            fclose($file_handle);


                    }


                    return true;
        }
        }
    return false;
}

?>