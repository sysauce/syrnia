<?

$S_user = '';
$S_donation = '';
$S_staffRights = '';

//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");

session_start();
$S_user = $_SESSION['S_user'];

//CAPTHA
require_once('libs/recaptcha-php-1.11/recaptchalib.php');
$publickey = "6Le0ir0SAAAAABtGE-yO57GIi91V1awqF1MoUJyB";
$privatekey = "6Le0ir0SAAAAAIzKtmOSG7GCbMQuy3aT8O830xJw";
$resp = null;# the response from reCAPTCHA
$error = null;  # the error code from reCAPTCHA, if any


echo "<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"style3.css\">";
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PUBLIC">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script src="<?php echo GAMEURL . "scriptaculous-js-1.8.3/lib/prototype.js"; ?>" type="text/javascript"></script>
	<script src="<?php echo GAMEURL . "scriptaculous-js-1.8.3/src/scriptaculous.js"; ?>" type="text/javascript"></script>
</HEAD>
<?
echo "<BODY background=\"layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000 style='color: #000000;'><center><br />
 <Table width=95% cellpadding=20 cellspacing=10><tr bgcolor=#E2D3B2><td>";


$timee = $time = time();

$TcategoryArray[0] = "Game bugs";
$TcategoryArray[1] = "Registration / Game information";
$TcategoryArray[2] = "Cheats / Exploits / Multis";
$TcategoryArray[3] = ""; //Chat, disabled
$TcategoryArray[4] = "Forum";
$TcategoryArray[5] = "Donating";

//Statusses:
//Solved
//Pending moderator reply
//Pending player reply


$IP = $REMOTE_ADDR;

if ($action == 'create')
{
    #### CREATE TICKET FOR BOTH LOGGED IN USERS, OR GUESTS
    //////////////////////////////////////////////////////

    echo "<h1>Creating a new ticket</h1>";

    if ($formsend)
    {
    	if (!$S_user) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
		}

        if (!$S_user && !$resp->is_valid) {

            $error = $resp->error;
			echo "<font color=red>You failed the captcha: $error.</font><br/>";

        }else if ($TcategoryArray[$Tcategory] && $Ttopic && $Tmessage && (stristr($Temail, "@") or
            $Tcontact == 'message' && $S_user))
        {
            if ($Tcontact == 'message')
            {
                $Temail = '';
            }
            if ($S_user)
            {
                $author = $S_user;
            } else
            {
                $author = $Temail;
                $Tcontact = "email";
            }

            $Ttopic = htmlentities(trim($Ttopic));
            $Tcontact = htmlentities(trim($Tcontact));
            $Tmessage = nl2br(htmlentities(trim($Tmessage)));
            $Tauthor = htmlentities(trim($Tauthor));
            $Temail = htmlentities(trim($Temail));

            if ($Tcategory == 0)
            {
                //Bugs, add browser info
                $browser = htmlentities(trim($browser));
                $Tmessage = $Tmessage . "<br /><br /><small><b>Browser information:</b><br />$browser</small>";

            }

            $timecheck = $timee - 3600 * 24;
            $resultaat = mysqli_query($mysqli,
                "SELECT messageID FROM ticketmessages WHERE IP='$IP' && time>='$timecheck' LIMIT 25");
            $aantalMessages = mysqli_num_rows($resultaat);
            $timecheck2 = $timee - 3600;
            $resultaat = mysqli_query($mysqli,
                "SELECT messageID FROM ticketmessages WHERE IP='$IP' && time>='$timecheck2' LIMIT 10");
            $aantalMessages2 = mysqli_num_rows($resultaat);
            if ($S_staffRights['canLoginToTools']==1 || ($aantalMessages <= 20 && $aantalMessages2 <= 5))
            { //Flood controll, max 20 messages a day, max 5 per hour.

                $password = rand(111111111, 999999999);
                if ($S_donation >= 5500)
                {
                    $prior = $S_donation;
                }

                $sql = "INSERT INTO tickettopics (title,category,status,lastaction,author,reply,email,moddescription,password, priority)
      VALUES ('$Ttopic', '$Tcategory', 'Pending moderator reply', '$timee', '$author', '$Tcontact','$Temail', '', '$password', '$prior')";
                mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs31 ");


                $insertID = mysqli_insert_id($mysqli);

                $sql = "INSERT INTO ticketmessages (time,topicID,message,author, IP)
      VALUES ('$timee', '$insertID', '$Tmessage','$author', '$IP')";
                mysqli_query($mysqli, $sql) or die("error report this bug please ->ticket cs33");

                echo "Thank you, your ticket has been added, we will reply as soon as possible.<br/>
		You can always add more information to this ticket by visiting it's status page in-game (if you are able to login), or via this link:<br/>
		<a href=\"".SERVERURL."tickets.php?action=view&ticketP=$password&ticketID=$insertID\">".SERVERURL."tickets.php?action=view&ticketP=$password&ticketID=$insertID</a><br/>
		<br/>
		On the status page you can always see an up to date status of the ticket.<br/>";
                if ($Temail)
                {
                    $message = "Hello,

You have created a support ticket on syrnia.com, here is an reminder for the link to track the tickets details:
".SERVERURL."tickets.php?action=view&ticketP=$password&ticketID=$insertID

Please do not reply this email, instead use the ticket system to contact us.

Syrnia.com";
                    $headers = 'From: noreply@syrnia.com' . "\r\n" .
    'Reply-To: noreply@syrnia.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n" .
    'Return-Path: <noreply@syrnia.com>\r\n';
mail( "$Temail", "Syrnia ticket support",$message, $headers, "-f noreply@syrnia.com");

                }

            } else
            { #Flood controll
                echo "Your message was not added as you have reached the max. amount of messages you are allowed to post per hour and/or day.<br/>
	 This is a flood protection. Please save your ticket details and submit the ticket later.<br/>
	 We're sorry for this delay.<br/>";
            }

        } else
        {
            echo "<font color=red>You did not fill in all fields correctly, please do so and try again.</font><br/>";
        }
    }

    if ($insertID == '')
    { //No ticket added


        echo "<form action='' method=post><table>

			<input type=hidden name=browser id=browser value=\"No details\">
			<input type=hidden name=formsend value=1> ";
        if ($S_user)
        {
            echo "<tr><td>Username<td><b>$S_user</b>";
        }
        echo "<tr><td width=200>Topic<td><input type=text name=Ttopic value=\"" .
            htmlentities(trim($Ttopic)) . "\">
			<tr valign=top><td>Category<td><select name=Tcategory><option value=\"\">";
        $i = 0;
        while ($i<=5)
        {
        	if($TcategoryArray[$i] != ''){
            	echo "<option value=\"$i\">" . $TcategoryArray[$i];
            }
            $i++;
        }
        echo "</select>
			<tr valign=top><td>Message<td><textarea name=Tmessage rows=10 cols=40>" .
            htmlentities(trim($Tmessage)) . "</textarea>";
        if ($S_user)
        {
            echo "<tr valign=top><td height=5> ";
            echo "<tr valign=top><td>How do you want us to contact you?<td><select name=Tcontact><option value=\"\"><option value=\"message\">Message me in-game<option value=\"email\">Email me<option value=\"emailmessage\">Email me, and message me in-game</select>";
            echo "<tr valign=top><td height=5> ";
            echo "<tr valign=top><td>If you want to be emailed, what email address should we use?<td><input type=text name=Temail>";
        } else
        {
            echo "<tr valign=top><td height=5> ";
            echo "<tr valign=top><td>What email address can we send replies to?<td><input type=text name=Temail>";
        }


//CAPTHA
if(!$S_user){
	echo "<tr><td>Captcha</td><td>";
	echo recaptcha_get_html($publickey, $error);
	echo "</td></tr>";
}
//END CAPTHA

        echo "<tr><td></td><td><input type=submit name=Submit value=Send>

			</table></form><small>Please fill in all fields</small>";

?>
   <script language="JavaScript">
    var number_of_values_to_test = 4;
    var name_array = new Array(number_of_values_to_test);
    var properties = new Array(number_of_values_to_test);
    name_array[0] = "Application Name";
    properties[0] = "appName";
    name_array[1] = "Code Name";
    properties[1] = "appCodeName";
    name_array[2] = "Version";
    properties[2] = "appVersion";
    name_array[3] = "User Agent";
    properties[3] = "userAgent";

	var content='';
    for (var index=0;index < number_of_values_to_test;index++) {
        content+=' ( '+name_array[index]+' - '+navigator[properties[index]]+' ) ';
    }
    $('browser').value=content;


</script>
<?

    }


} elseif ($action == 'view')
{

    echo "<h1>Support - view a ticket</h1>";

    ### VIEW TICKET
    //////////////////////////////////////////////////////

    // ADD MESSAGE
    if ($Tmessage && (is_numeric($ticketID)))
    {
        if ($S_user == '')
        {
            $ticketP = htmlentities(trim($ticketP));
            $ticketID = htmlentities(trim($ticketID));
            $whereSQL = "password='$ticketP' && ticketID='$ticketID'";
            $author = "guest";
        } else
        {
            $S_user = htmlentities(trim($S_user));
            $whereSQL = "ticketID='$ticketID' && author='$S_user'";
            $author = $S_user;
        }

        $Tmessage = nl2br(htmlentities(trim($Tmessage)));

        $resultaat = mysqli_query($mysqli,
            "SELECT category, locked FROM tickettopics WHERE $whereSQL LIMIT 1");
        while ($record = mysqli_fetch_object($resultaat))
        {
            if ($record->locked == 1)
            {
                exit(); //You shouldnt be able to get here
            }
            if ($record->category == 0)
            {
                //Bugs, add browser info
                $browser = htmlentities(trim($browser));
                $Tmessage = $Tmessage . "<br /><br /><small><b>Browser information:</b><br />$browser</small>";
            }
        }

        $resultaat = mysqli_query($mysqli,
            "SELECT topicID FROM ticketmessages WHERE IP='$IP' && message='$Tmessage' && topicID='$ticketID'  LIMIT 1");
        $aantalMessagesSame = mysqli_num_rows($resultaat);
        if ($aantalMessagesSame != 1)
        {

            $timecheck = $timee - 3600 * 24;
            $resultaat = mysqli_query($mysqli,
                "SELECT messageID FROM ticketmessages WHERE IP='$IP' && time>='$timecheck' LIMIT 1");
            $aantalMessages = mysqli_num_rows($resultaat);
            $timecheck2 = $timee - 3600;
            $resultaat = mysqli_query($mysqli,
                "SELECT messageID FROM ticketmessages WHERE IP='$IP' && time>='$timecheck2' LIMIT 1");
            $aantalMessages2 = mysqli_num_rows($resultaat);
            if ($aantalMessages <= 25 && $aantalMessages2 <= 10)
            { //Flood controll, max 25 messages a day, max 10 per hour.

                $resultaat = mysqli_query($mysqli, "SELECT ticketID FROM tickettopics WHERE $whereSQL LIMIT 1");
                $excists = mysqli_num_rows($resultaat);
                if ($excists == 1)
                {

                    mysqli_query($mysqli,
                        "UPDATE tickettopics SET status='Pending moderator reply', lastaction='$timee' WHERE $whereSQL LIMIT 1") or
                        die("err1or --> 1232231");
                    mysqli_query($mysqli,
                        "INSERT INTO ticketmessages (time,topicID,message,author, IP)
	      		VALUES ('$timee', '$ticketID', '$Tmessage','$author', '$IP')") or die("error report this bug please ->ticket cs33");
                    echo "<B>Added your message.</B><br />";
                } else
                {
                    echo "Your ticket does not exist.<br />";
                }
            } else
            { //flood controll
                echo "You have added too much messages and too fast, please try again later.<br/>";
            }
        } #double message
    } // END ADD MESSAGE


    if ($S_user)
    {
        echo "Logged in as $S_user.<br/>";

        if ($ticketID)
        {
            echo "<a href=?page=ticket&action=view>Back to overview</a><br/>
 <br/>";


            if ($solved == 1)
            {
                mysqli_query($mysqli, "UPDATE tickettopics SET status='Solved', lastaction='$timee' WHERE author='$S_user' && ticketID='$ticketID' LIMIT 1") or
                    die("err1or --> 1232231");
            }

            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID, title, category, status, lastaction, author, reply, locked FROM tickettopics WHERE author='$S_user' && ticketID='$ticketID' LIMIT 1");
            while ($record = mysqli_fetch_object($resultaat))
            {
                $found = 1;
                echo "<Table><tr><td>Topic<td><b>$record->title</b>
     	<tr><td>Category<td><b>" . $TcategoryArray[$record->category] . "</b>
	 	<tr><td>Username/Email<td><b>$record->author.
		<tr><td>Last update<td><b>" . date("Y-m-d H:i", $record->lastaction) . "
	 	<tr><td>Status<td><b>$record->status
	 	<tr><td>Replies<td><b>";
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
                echo "</table>
		  <br/>";

                if ($record->status == "Solved")
                {
                    echo "This message has been marked as solved by either you, or a moderator.
				 To continue this ticket add a new message and clarify the problem.<br/><br/>";
                } else
                {
                    echo "Is the problem solved ? Please close this ticket: <form action='' method=post><input type=hidden name=solved value=1>
				 <input type=submit value=\"Mark ticket as solved\"></form><br/>";
                }


                echo "<table cellpadding=5 width=100% cellspacing=5>";
                $resultt = mysqli_query($mysqli,
                    "SELECT author, time, message FROM ticketmessages WHERE topicID='$record->ticketID' ORDER by messageID desc");
                while ($rec = mysqli_fetch_object($resultt))
                {
                    echo "<tr valign=top><td bgcolor=#B19A68>" . date("Y-m-d H:i", $rec->time) .
                        " <b>$rec->author</b> </td></tr>";
                    echo "<tr valign=top><td bgcolor=#EFD6AD>$rec->message</td></tr>";
                }
                echo "</table>";


                if ($record->locked != 1)
                {
                    echo "<br/>
			<br/>
			<B>Add a message</b><br/>
			<table>
			<form action='' method=post>
			<input type=hidden name=browser id=browser value='No browser information found'>
			<tr valign=top><td><textarea name=Tmessage rows=7 cols=60></textarea>";
                    echo "<tr><td><input type=submit name=Submit>
			</form>
			</table>";
                } else
                {
                    echo "<br/>
			<br/>
			<i>You can not add any more messages as this ticket has been locked.</i><br/>";
                }

?>
   <script language="JavaScript">
    var number_of_values_to_test = 4;
    var name_array = new Array(number_of_values_to_test);
    var properties = new Array(number_of_values_to_test);
    name_array[0] = "Application Name";
    properties[0] = "appName";
    name_array[1] = "Code Name";
    properties[1] = "appCodeName";
    name_array[2] = "Version";
    properties[2] = "appVersion";
    name_array[3] = "User Agent";
    properties[3] = "userAgent";

	var content='';
    for (var index=0;index < number_of_values_to_test;index++) {
        content+=' ( '+name_array[index]+' - '+navigator[properties[index]]+' ) ';
    }
    $('browser').value=content;


</script>
<?

            }

        } else
        {
            echo "Showing all your tickets.<br/>
  <a href=?page=ticket&action=create>Create a new ticket</a>.<br/>
 <br/>";

            echo "<Table width=100% cellpadding=5>
		 <tr bgcolor=#B19A68><td>#</td><td>Topic</td><td>Category<td>Last update<td>Status<td>Replies";
            $resultaat = mysqli_query($mysqli,
                "SELECT ticketID, title, category, status, lastaction, author, reply FROM tickettopics WHERE author='$S_user' ORDER BY ticketID desc");
            while ($record = mysqli_fetch_object($resultaat))
            {
                $found = 1;

                echo "<tr bgcolor=#EFD6AD><td>$record->ticketID</td><td><b><a href=?page=ticket&action=view&ticketID=$record->ticketID>$record->title</a></b>
		<td><small>" . $TcategoryArray[$record->category] . "</b>
		<td><small>" . date("Y-m-d H:i", $record->lastaction) . "
	 	<td><small><b>";
                if ($record->status == 'Solved')
                {
                    echo "<font color=green>$record->status</font>";
                } elseif ($record->status == 'Pending player reply')
                {
                    echo "<font color=red>$record->status</font>";
                } else
                {
                    echo "<font color=orange>$record->status</font>";
                }
                echo "<td><small>";
                if ($record->reply == 'email')
                {
                    echo "Email only.";
                } elseif ($record->reply == 'emailmessage')
                {
                    echo "Email and in-game message";
                } elseif ($record->reply == 'message')
                {
                    echo "In-game message only";
                }
                echo "</tr>";
            }
            echo "</table>";


        }


    } else
    {
        ////GUEST TICKET VIEWER!
        #****************

        if ($ticketP && $ticketID)
        {

            if ($solved == 1)
            {
                mysqli_query($mysqli, "UPDATE tickettopics SET status='Solved', lastaction='$timee' WHERE password='$ticketP' && ticketID='$ticketID' LIMIT 1") or
                    die("err1or --> 1232231");
            }

            $resultaat = mysqli_query($mysqli,
                "SELECT title, category, status, lastaction, author, reply FROM tickettopics WHERE password='$ticketP' && ticketID='$ticketID' LIMIT 1");
            while ($record = mysqli_fetch_object($resultaat))
            {
                $found = 1;
                echo "<Table><tr><td>Topic<td><b>$record->title</b>
     	<tr><td>Category<td><b>" . $TcategoryArray[$record->category] . "</b>
	 	<tr><td>By<td><b>$record->author.
		<tr><td>Last update<td><b>" . date("Y-m-d H:i", $record->lastaction) . "
	 	<tr><td>Status<td><b>$record->status
	 	<tr><td>Replies<td><b>";
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
                echo "</table><br/>";

                if ($record->status == "Solved")
                {
                    echo "This message has been marked as solved by either you, or a moderator.
			 To continue this ticket add a new message and clarify the problem.<br/><br/>";
                } else
                {
                    echo "Is the problem solved ? Please close this ticket: <form action='' method=post><input type=hidden name=solved value=1>
			 <input type=submit value=\"Mark ticket as solved\"></form><br/>";
                }

                echo "<table cellpadding=5 width=100% cellspacing=5>";
                $resultt = mysqli_query($mysqli,
                    "SELECT author, time, message FROM ticketmessages WHERE topicID='$ticketID' ORDER by messageID desc");
                while ($rec = mysqli_fetch_object($resultt))
                {
                    echo "<tr valign=top><td bgcolor=#B19A68>" . date("Y-m-d H:i", $rec->time) .
                        " <b>$rec->author</b> </td></tr>";
                    echo "<tr valign=top><td bgcolor=#EFD6AD>$rec->message</td></tr>";
                }
                echo "</table>";

                echo "<br/>
			<br/>
			<B>Add a message</b><br/>
			<table>
			<form action='' method=post>
			<tr valign=top><td><textarea name=Tmessage rows=7 cols=60></textarea>";
                echo "<tr><td><input type=submit name=Submit>
			</form>
			</table>";
            }

            if ($found != 1)
            {
                echo "<B>Your ticket was not found, please check your ticket ID and password.</b><br/>";
            }

            ////END OF GUEST TICKET VIEWER
            #****************
        }

        if ($found != 1)
        {
            echo "Search your ticket:<br/>

		<Table>
		<form action='' method=post>
		<tr><td>Ticket ID 		<td><input type=text name=ticketID><br/>
		<tr><td>Ticket password <td><input type=text name=ticketP><br/>
		<tr><td><td><input type=submit value=search><br/>
		</form></table>";
        }
    }


} else
{
    echo "<h1>Ticket support</h1>";
    echo "Need help? <a href=?page=ticket&action=create>Create a ticket</a>, and we'll contact you as soon as possible.<br/><br/>
	Already made a ticket?<br/>
	<a href=?page=ticket&action=view>View your ticket</a>";
}


?>
<br />
</td></tr>
</table>
<br />
</center>
</body>
</html>