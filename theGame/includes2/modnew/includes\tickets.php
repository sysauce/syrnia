<?
if (defined('AZtopGame35Heyam'))
{
    //TODO: limit category per mods.

    $IP = $REMOTE_ADDR;
    $time = time();
    $datum = strftime("%d-%m-%Y", $time);

    $TcategoryArray[0] = "Game bugs";
    $TcategoryArray[1] = "Registration / Game information";
    $TcategoryArray[2] = "Cheats / Exploits / Multis";
    $TcategoryArray[3] = "Chat";
    $TcategoryArray[4] = "Forum";
    $TcategoryArray[5] = "Donating";

    $TcategoryArrayRIGHT[0] = $S_staffRights['bugsMod'];
    $TcategoryArrayRIGHT[1] = $SENIOR_OR_SUPERVISOR;
    $TcategoryArrayRIGHT[2] = $S_staffRights['multiMod'];
    $TcategoryArrayRIGHT[3] = $S_staffRights['chatMod'];
    $TcategoryArrayRIGHT[4] = $S_staffRights['forumMod'];
    $TcategoryArrayRIGHT[5] = 0;
    if ($S_user == 'M2H' || $SENIOR_OR_SUPERVISOR == 1)
    {
        $TcategoryArrayRIGHT[5] = 1;
    }


    //Statusses:
    //Solved
    //Pending moderator reply
    //Pending player reply


    echo "<b>Category</b><ul>";
    for ($i = 0; $TcategoryArray[$i]; $i++)
    {
        if ($TcategoryArrayRIGHT[$i] == 1)
        {
            echo "<li><a href=?page=$page&viewcategory=$i>" . $TcategoryArray[$i] . "</a>";

            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID FROM tickettopics WHERE status='Pending moderator reply' && category='$i'");
            $amount = mysqli_num_rows($resultaat);
            echo "($amount open tickets)</li>";
        }
    }
    echo "</ul><br />
<A href=?page=$page&action=CreateTicket>Create a ticket</a><br />
<A href=?page=$page&action=SearchTicket>Search a ticket</a><hr><br />";

    if ($action == 'SearchTicket')
    {

        echo "<table><form action='' method=post>
 You must enter a username and/or topic and/or enter an ID.<br />
 <tr height=15><td>ID</td><td><input type=text name=searchID></td></tr>

 <tr><td>Username</td><td><input type=text name=searchUser></td></tr>
 <tr><td>Topic</td><td><input type=text name=searchTopic></td></tr>
 <tr><td>Catergory</td><td><select name=searchCat><option value=\"\">All</option>";

        for ($i = 0; $TcategoryArray[$i]; $i++)
        {
            if ($TcategoryArrayRIGHT[$i] == 1)
            {
                echo "<option value=$i>" . $TcategoryArray[$i] . "</option>";
            }
        }


        echo "</select></td></tr>
 <tr><td></td><td><input type=submit value='search'></td></tr>
  </table></form>";

        if ($searchTopic || $searchUser || $searchID)
        {

            if (is_numeric($searchID) && $searchID)
            {
                $IDFilter = " && ticketID='$searchID' ";
            }else{
            	$IDFilter="";
            }

			if (is_numeric($searchCat) && $searchCat)
            {
                $catFilter = " && category='$searchCat' ";
            }else{
   				$catFilter="";
            }

            if ($searchUser)
            {
                $userFilter = " && author='$searchUser' ";
            }else{
            	$userFilter="";
            }

            if ($searchTopic)
            {
                $topicFilter = " && title like '%$searchTopic%' ";
            }else{
            	$topicFilter="";
            }


            echo "<Table width=100% cellpadding=5>
<tr bgcolor=#B19A68><td>ID</td><td>User<td>Topic<td>Mod description<td>Last update<td>Status";

           $resultaat = mysqli_query($mysqli,
                "SELECT ticketID, title, category, status, requireSeniorMod, lastaction, author, reply,moddescription FROM tickettopics WHERE 1 $catFilter $topicFilter $userFilter $IDFilter ORDER BY lastaction desc LIMIT 50");
            while ($record = mysqli_fetch_object($resultaat))
            {
                if ($TcategoryArrayRIGHT[$record->category] == 1)
                {
                    echo "<tr bgcolor=#EFD6AD><td><small>$record->ticketID</small></td>
		<td><small>";
                    if ($record->requireSeniorMod == 1)
                    {
                        echo "<b>";
                    }
                    echo "$record->author</small></td>
		<td>" . $TcategoryArray[$record->category] . "</td>
		<td><b><a href=?page=$page&viewcategory=$record->category&ticketID=$record->ticketID>$record->title</a></b></td>
		<td><small>$record->moddescription</small></td>
		<td width=100><small>" . date("Y-m-d H:i", $record->lastaction) .
                        "</small></td>
	 	<td width=100><small><b>";
                    if ($record->status == 'Solved')
                    {
                        echo "<font color=green>$record->status</font>";
                    } elseif ($record->status == 'Pending player reply')
                    {
                        echo "<font color=orange>$record->status</font>";
                    } elseif ($record->status == 'Pending moderator reply')
                    {
                        echo "<font color=red>$record->status</font>";
                    }

                    echo "</tr>";
                }
            }
            echo "</table>
	 <small>All tickets with bold usernames require a senior mod</small>";


        }

    } else
        if ($action == 'CreateTicket')
        {
            #### CREATE TICKET FOR BOTH LOGGED IN USERS, OR GUESTS
            //////////////////////////////////////////////////////

            echo "<h1>Creating a new ticket</h1>";

            if ($formsend)
            {
                if ($TcategoryArray[$Tcategory] && $Ttopic && $Tmessage)
                {
                    if ($Tcontact == 'message')
                    {
                        $Temail = '';
                    }
                    $author = "Moderator";
					if($SENIOR_OR_SUPERVISOR){
						$author="Senior Moderator";
					}

                    $Ttopic = htmlentities(trim($Ttopic));
                    $Tcontact = htmlentities(trim($Tcontact));
                    $Tmessage = nl2br(htmlentities(trim($Tmessage)));
                    $Tauthor = htmlentities(trim($Tauthor));
                    $Temail = htmlentities(trim($Temail));

                    $password = rand(111111111, 999999999);
                    $sql = "INSERT INTO tickettopics (title,category,status,lastaction,author,reply,email,moddescription,password)
      VALUES ('$Ttopic', '$Tcategory', 'Pending player reply', '$timee', '$toUser', '$Tcontact','$Temail', '', '$password')";
                    mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs3 $sql");


                    $insertID = mysqli_insert_id($mysqli);

                    $sql = "INSERT INTO ticketmessages (time,topicID,message,author, IP, moderator)
      VALUES ('$timee', '$insertID', '$Tmessage','$author', '$S_realIP', '$S_user')";
                    mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs33");

                    echo "The ticket has been created.<br/>";

                    ///
                    $resultaat = mysqli_query($mysqli, "SELECT email FROM users WHERE username='$toUser' LIMIT 1");
                    while ($record = mysqli_fetch_object($resultaat))
                    {

                        if ($Tcontact == 'email' or $Tcontact == 'emailmessage')
                        {
                            $message = "Hello,

A support ticket has been created on Syrnia.com about your player account.
Please read and reply the ticket.
http://www.syrnia.com/tickets.php?page=ticket&action=view&ticketP=$password&ticketID=$insertID

Please do not reply this email, instead use the ticket system to contact us.

Syrnia.com";
                            mail("$record->email", "Syrnia ticket support", $message,
                                "From: support@syrnia.com");
                        }
                        if ($Tcontact == 'emailmessage' or $Tcontact == 'message')
                        {
                            $sql = "INSERT INTO messages (username, sendby, message, topic, time)
  	VALUES ('$toUser', '<B>Syrnia</B>', 'Dear $toUser,<br />
  	A support ticket has been created about your player account.
Please read and reply the ticket.<br/>
  	Use the ticket support page to view all your tickets.<br/>
	<a href=http://www.syrnia.com/tickets.php?action=view&ticketP=$password&ticketID=$insertID>Or click here</a>', 'Support ticket', '$timee')";
                            mysqli_query($mysqli, $sql) or die("error report6");
                        }
                    }

                    ///


                } else
                {
                    echo "<font color=red>You did not fill in all fields correctly, please do so and try again.</font><br/>";
                }
            }

            if ($insertID == '')
            { //No ticket added
                echo "<table>
			<form action='' method=post>
			<input type=hidden name=formsend value=1>";
                echo "<tr><td>To username<td><input type=text name=toUser>";

                echo "<tr><td width=200>Topic<td><input type=text name=Ttopic value=\"" .
                    htmlentities(trim($Ttopic)) . "\">
			<tr valign=top><td>Category<td><select name=Tcategory><option value=\"\">";
                $i = 0;
                while ($TcategoryArray[$i] != '')
                {
                    if ($TcategoryArrayRIGHT[$i] == 1)
                    {
                        echo "<option value=\"$i\">" . $TcategoryArray[$i];
                    }
                    $i++;
                }
                echo "</select>
			<tr valign=top><td>Message<td><textarea name=Tmessage rows=10 cols=40>" .
                    htmlentities(trim($Tmessage)) . "</textarea>";

                echo "<tr valign=top><td height=5> ";
                echo "<tr valign=top><td>How to contact ?<td>
			<select name=Tcontact><option value=\"message\">Message
			<option value=\"email\">Email
			<option value=\"emailmessage\">Email and message
			</select>";


                echo "<tr><td></td><td><input type=submit name=Submit value=Send>
			</form>
			</table><small>Please fill in all fields</small>";
            }

        } elseif (is_numeric($viewcategory) && $TcategoryArray[$viewcategory] && $TcategoryArrayRIGHT[$viewcategory] ==
        1)
        {


            // ADD MESSAGE
            if ($Tmessage && (is_numeric($ticketID)))
            {
                $author = "Moderator";
				if($SENIOR_OR_SUPERVISOR){
					$author="Senior Moderator";
				}

                $TmessageADD = nl2br(htmlentities(trim($Tmessage)));
                $resultaat = mysqli_query($mysqli,
                    "SELECT topicID FROM ticketmessages WHERE IP='$IP' && message='$TmessageADD' && topicID='$ticketID'  LIMIT 1");
                $aantalMessagesSame = mysqli_num_rows($resultaat);
                if ($aantalMessagesSame != 1)
                {

                    $resultaat = mysqli_query($mysqli,
                        "SELECT ticketID FROM tickettopics WHERE ticketID='$ticketID' LIMIT 1");
                    $excists = mysqli_num_rows($resultaat);
                    if ($excists == 1)
                    {


                        mysqli_query($mysqli,
                            "UPDATE tickettopics SET status='Pending player reply', lastaction='$timee',status2='' WHERE ticketID='$ticketID' LIMIT 1") or
                            die("err1or --> 1232231");
                        mysqli_query($mysqli,
                            "INSERT INTO ticketmessages (time,topicID,message,author, IP, moderator)
	      		VALUES ('$timee', '$ticketID', '$TmessageADD','$author', '$IP', '$S_user')") or
                            die("error report this bug please ->ticket cs33");
                        echo "<B>Added your message.</B><br />";


                        $resultaat = mysqli_query($mysqli,
                            "SELECT email,reply,password,author FROM tickettopics WHERE ticketID='$ticketID' LIMIT 1");
                        while ($record = mysqli_fetch_object($resultaat))
                        {

                            if ($record->reply == 'email' or $record->reply == 'emailmessage')
                            {
                                $message = "Hello,

A moderator has replied your support ticket on Syrnia.com.
Use the following link to read it:
http://www.syrnia.com/tickets.php?action=view&ticketP=$record->password&ticketID=$ticketID

Please do not reply this email, instead use the ticket system to contact us.

Syrnia.com";
                                mail("$record->email", "Syrnia ticket support", $message,
                                    "From: support@syrnia.com");
                            }
                            if ($record->reply == 'emailmessage' or $record->reply == 'message')
                            {
                                $sql = "INSERT INTO messages (username, sendby, message, topic, time)
  	VALUES ('$record->author', '<B>Syrnia</B>', 'Dear $record->author,<br />
  	A moderator has replied to your support ticket $ticketID.<br />
  	Use the ticket support page to view all your tickets.<br/>
	<a href=http://www.syrnia.com/tickets.php?action=view&ticketP=$record->password&ticketID=$ticketID>Or click here</a>', '<b>Syrnia</b>', '$timee')";
                                mysqli_query($mysqli, $sql) or die("error report6");
                            }
                        }

                    } else
                    {
                        echo "Your ticket does not exist.<br />";
                    }
                } else
                {
                    echo "Your reply already exists (did you refresh?).<br />";
                }
            } // END ADD MESSAGE


            if ($ticketID)
            {
                echo "<a href=?page=tickets&viewcategory=$viewcategory>Back to overview</a><br/>
 <br/>";


                if ($solved == 1)
                {
                    mysqli_query($mysqli, "UPDATE tickettopics SET status='Solved', lastaction='$timee', status2='$S_user marked ticket as solved' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }


                if ($locking == 1)
                {
                    mysqli_query($mysqli, "UPDATE tickettopics SET status='Solved', lastaction='$timee', status2='$S_user locked ticket', locked=1 WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                } else
                    if ($unlocking == 1)
                    {
                        mysqli_query($mysqli,
                            "UPDATE tickettopics SET status='Pending moderator reply', lastaction='$timee', status2='$S_user unlocked ticket', locked=0 WHERE ticketID='$ticketID' LIMIT 1") or
                            die("err1or --> 1232231");
                    }

                if ($setStatusPendingModReply == 1)
                {
                    mysqli_query($mysqli,
                        "UPDATE tickettopics SET status='Pending moderator reply', lastaction='$timee', status2='' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }

                if ($editModDescForm)
                {
                    mysqli_query($mysqli, "UPDATE tickettopics SET moddescription='$editModDesc' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }

                if ($submitchange == 1)
                {
                    mysqli_query($mysqli, "UPDATE tickettopics SET requireSeniorMod='$requireSeniorMod' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }

                if ($changeCat >= 0 && $changingCat == 1)
                {
                    mysqli_query($mysqli, "UPDATE tickettopics SET category='$changeCat', status='Pending moderator reply',status2='',lastaction='$timee' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }

				if ($changeGroup && $changingGroup == 1)
                {
                	$changeGroup=htmlentities($changeGroup);
                    mysqli_query($mysqli, "UPDATE tickettopics SET ticketGroup='$changeGroup' WHERE ticketID='$ticketID' LIMIT 1") or
                        die("err1or --> 1232231");
                }

                $resultaat = mysqli_query($mysqli,
                    "SELECT ticketID,requireSeniorMod,ticketGroup, title, category, moddescription, email, status,status2, lastaction, author, reply, locked FROM tickettopics WHERE ticketID='$ticketID' LIMIT 1");
                while ($record = mysqli_fetch_object($resultaat))
                {
                    $found = 1;
                    echo "<Table><tr><td>Topic<td><b>$record->title</b> (#$ticketID)
     	<tr><td>Category<td><b>" . $TcategoryArray[$record->category] . "</b>
     	<tr><td><td>Change to:";
                    echo "<form action='' method=post><input type=hidden name=changingCat value=1><select name=changeCat onchange=\"submit()\"><option value=>";
                    for ($i = 0; $TcategoryArray[$i]; $i++)
                    {
                        echo "<option value=$i>" . $TcategoryArray[$i];
                    }
                    echo "</select></form>";


		echo"<tr><td>Group<td><b>$record->ticketGroup</b>
     	<tr><td><td>";
                    echo "<table><tr valign=top><td>Change to:<form action='' method=post><input type=hidden name=changingGroup value=1><select name=changeGroup onchange=\"submit()\">";
                    $resultaat = mysqli_query($mysqli,
                    "SELECT ticketGroup FROM tickettopics WHERE category='$record->category' GROUP by ticketGroup ASC");
                	while ($rec = mysqli_fetch_object($resultaat))
                	{
                		if($record->ticketGroup==$rec->ticketGroup){
                			echo "<option value=\"$rec->ticketGroup\" selected>$rec->ticketGroup</option>";
                		}else{
                			echo "<option value=\"$rec->ticketGroup\">$rec->ticketGroup</option>";
                		}

                    }
                    echo "</select></form>";

                    echo "</td><td> Or add new group <form action='' method=post><input type=hidden name=changingGroup value=1><input type=text name=changeGroup><input type=submit value=Add></form></tr></td></table>";

                    echo "<tr><td>By<td><b>$record->author";
                    echo "<tr><td>Last update<td><b>" . date("Y-m-d H:i", $record->lastaction) . "
	 	<tr><td>Status<td><b>$record->status </b>";
                    if ($record->status == 'Solved')
                    {
                        echo "($record->status2)";
                    }

                    if ($record->status != 'Pending moderator reply')
                    {
                        echo "<form action='' method=post><input type=hidden name=setStatusPendingModReply value=1>
			 <input type=submit value=\"Set status: pending mod reply\"></form>";
                    }

                    if ($record->requireSeniorMod == 1)
                    {
                        echo "<form action='' method=post>
					  <input type=hidden name=submitchange value=1>
					  <input type=hidden name=requireSeniorMod value=0>
			 <input type=submit value=\"Cancel senior mod call\"></form>";
                    } else
                    {
                        echo "<form action='' method=post>
					  <input type=hidden name=submitchange value=1>
					  <input type=hidden name=requireSeniorMod value=1>
			 <input type=submit value=\"Require senior mod\"></form>";
                    }


                    echo "<tr><td>Replies<td><b>";
                    if ($record->reply == 'email')
                    {
                        echo "Email only.";
                    } elseif ($record->reply == 'emailmessage')
                    {
                        echo "Email and in-game message";
                    } elseif ($record->reply == 'message')
                    {
                        echo "in-game message only";
                    }
                    echo "
		<tr><td>Mod status description<td><form action='' method=post><input type=hidden name=editModDescForm value=1><input type=text size=80 name=editModDesc value=\"$record->moddescription\">
		<input type=submit value=Edit></form>
		  </table>

		  <br/>";

                    echo "<table><tr valign=top><td>";
                    if ($record->status == "Solved")
                    {
                        echo "This message has been marked as solved by either the player, or a moderator.<br />
			 To continue this ticket add a new message and clarify the problem.<br/><br/>";
                    } else
                    {
                        echo "Is the problem solved ? <form action='' method=post><input type=hidden name=solved value=1>
			 <input type=submit value=\"Close ticket\"></form><br/>";
                    }
                    echo "</td><td width=100> </td><td>";
                    if ($record->locked == 0)
                    {
                        echo "Need to lock the ticket (disable any future replies) ?<form action='' method=post><input type=hidden name=locking value=1>
			 <input type=submit value=\"Lock ticket\"></form><br/>";
                    } else
                    {
                        echo "<b>This ticket is locked</b>: Need to unlock the ticket ?<form action='' method=post><input type=hidden name=unlocking value=1>
			 <input type=submit value=\"Unlock ticket\"></form><br/>";
                    }
                    echo "</td></tr></table>";

                    echo "<table cellpadding=5 width=100% cellspacing=5>";
                    $resultt = mysqli_query($mysqli,
                        "SELECT author, time, ip, message, moderator FROM ticketmessages WHERE topicID='$ticketID' ORDER by messageID desc");
                    while ($rec = mysqli_fetch_object($resultt))
                    {
                        echo "<tr valign=top><td bgcolor=#B19A68>" . date("Y-m-d H:i", $rec->time) .
                            " <b>$rec->author</b> [" . substr("$rec->ip", 0, 10) . "**] by $rec->moderator </td></tr>";
                        echo "<tr valign=top><td bgcolor=#EFD6AD>$rec->message</td></tr>";
                    }
                    echo "</table>";


					if($record->requireSeniorMod!=1 OR $SENIOR_OR_SUPERVISOR){
		                    echo "<br/>
					<br/>
					<B>Add a message</b><br/>
					<table>
					<form action='' method=post>
					<tr valign=top><td><textarea name=Tmessage rows=7 cols=60>" . htmlentities(trim
		                        ($Tmessage)) . "</textarea></td></tr>";
		                    echo "<tr><td>Solved: <input type=checkbox name=solved value=1></td></tr>";
		                    echo "<tr><td><input type=submit name=Submit></td></tr>
					</form>
					</table>";
					}else{
						echo"<br /><br /><b>You can not add a message, only a senior or supervising mod can do so.</b><br /><br />";
					}

                }

            } else
            {

                if ($showall == '')
                {
                    $statusFilter = "&& status='Pending moderator reply'";
                    echo "<b>Only showing \"Pending moderator reply\" tickets.</b> <a href=?page=$page&viewcategory=$viewcategory&showall=1&currentGroup=$currentGroup>Show all</a><br/>
 <br/>";
                } else
                {
                    $showall = 1;
                    $statusFilter = '';
                    echo "<b>Showing all tickets.</b> <a href=?page=$page&viewcategory=$viewcategory&currentGroup=$currentGroup>Only show \"Pending moderator reply\"</a><br/>
 <br/>";
                }


                if (!is_numeric($beginTicketsList))
                {
                    $beginTicketsList = 0;
                }
                $resultaat = mysqli_query($mysqli,
                    "SELECT ticketID FROM tickettopics WHERE category='$viewcategory'");
                $amountTickets = mysqli_num_rows($resultaat);

                $resultaat = mysqli_query($mysqli,
                    "SELECT ticketID FROM tickettopics WHERE category='$viewcategory' && status='Solved'");
                $amountSolvedTickets = mysqli_num_rows($resultaat);
                $resultaat = mysqli_query($mysqli,
                    "SELECT ticketID FROM tickettopics WHERE category='$viewcategory' && status='Pending player reply'");
                $amountPendingPlayerTickets = mysqli_num_rows($resultaat);
                $resultaat = mysqli_query($mysqli,
                    "SELECT ticketID FROM tickettopics WHERE category='$viewcategory' && status='Pending moderator reply'");
                $amountPendingModTickets = mysqli_num_rows($resultaat);

                echo "$amountTickets total tickets, $amountSolvedTickets solved, $amountPendingPlayerTickets tickets pending players reply, $amountPendingModTickets pending our reply.<br/>";


				$resultaat = mysqli_query($mysqli, "SELECT ticketID, title, category, status, requireSeniorMod, lastaction, author, reply,moddescription FROM tickettopics WHERE ticketGroup='$currentGroup' && category='$viewcategory' $statusFilter ORDER BY requireSeniorMod DESC, lastaction desc");
                $currentTickers=mysqli_num_rows($resultaat);
				$pages = $currentTickers/50;

				echo"<b>Groups:</b> <a href=?page=$page&viewcategory=$viewcategory&showall=$showall&beginTicketsList=$beginTicketsList&currentGroup=>Ungrouped ";
				if($currentGroup==''){echo" ($currentTickers)";}
				echo"</a> - ";

				$resultaat = mysqli_query($mysqli,
                "SELECT ticketGroup, count(ticketGroup) as much FROM tickettopics WHERE category='$viewcategory' && ticketGroup<>'' $statusFilter GROUP by ticketGroup ASC");
            	while ($rec = mysqli_fetch_object($resultaat))
            	{
            		if($currentGroup==$rec->ticketGroup){
            			echo" $rec->ticketGroup - ";
            		}else{
            			echo" <a href=\"?page=$page&viewcategory=$viewcategory&showall=$showall&beginTicketsList=$beginTicketsList&currentGroup=$rec->ticketGroup\">$rec->ticketGroup ($rec->much)</a> - ";
            		}
                }
				echo"<br />";




                $resultaat = mysqli_query($mysqli, "SELECT ticketID, title, category, status, requireSeniorMod, lastaction, author, reply,moddescription FROM tickettopics WHERE ticketGroup='$currentGroup' && category='$viewcategory' $statusFilter ORDER BY requireSeniorMod DESC, lastaction desc LIMIT $beginTicketsList,50");

                echo "<br />Page(s): ";
                for ($i = 0; $i <= $pages; $i++)
                {
                    echo "<a href=\"?page=$page&viewcategory=$viewcategory&showall=$showall&currentGroup=$currentGroup&beginTicketsList=" . ($i *
                        50) . "\">" . ($i + 1) . "</a> -";
                }
                echo "<Table width=100% cellpadding=5>
		 <tr bgcolor=#B19A68><td>ID</td><td>User<td>Topic<td>Mod description<td>Last update<td>Status";


                while ($record = mysqli_fetch_object($resultaat))
                {
                    $found = 1;

                    echo "<tr bgcolor=#EFD6AD><td><small>$record->ticketID</small></td>
		<td><small>";
                    if ($record->requireSeniorMod == 1)
                    {
                        echo "<b>";
                    }
                    echo "$record->author</small></td>
		<td><b><a href=?page=$page&viewcategory=$viewcategory&ticketID=$record->ticketID>$record->title</a></b></td>
		<td><small>$record->moddescription</small></td>
		<td width=100><small>" . date("Y-m-d H:i", $record->lastaction) .
                        "</small></td>
	 	<td width=100><small><b>";
                    if ($record->status == 'Solved')
                    {
                        echo "<font color=green>$record->status</font>";
                    } elseif ($record->status == 'Pending player reply')
                    {
                        echo "<font color=orange>$record->status</font>";
                    } elseif ($record->status == 'Pending moderator reply')
                    {
                        echo "<font color=red>$record->status</font>";
                    }

                    echo "</tr>";
                }
                echo "</table>";
                echo"<small>All tickets with bold usernames require a senior mod</small><br />";

                echo "Page(s): ";
                for ($i = 0; $i <= $pages; $i++)
                {
                    echo "<a href=?page=$page&viewcategory=$viewcategory&showall=$showall&beginTicketsList=" . ($i *
                        50) . ">" . ($i + 1) . "</a> -";
                }



            }


        } else
        {
            echo "Select an category from the menu on top.<br/>";

            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID FROM tickettopics WHERE status='Pending moderator reply'");
            $amountPendingModTickets = mysqli_num_rows($resultaat);
            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID FROM tickettopics WHERE status='Pending player reply'");
            $amountPendingPlayerTickets = mysqli_num_rows($resultaat);
            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID FROM tickettopics WHERE status='Solved'");
            $solved = mysqli_num_rows($resultaat);
            echo "There are a total of $amountPendingModTickets tickets awaiting our response, $solved tickets have been solved ($amountPendingPlayerTickets pending players reply).<br/>";


        }


}
?>