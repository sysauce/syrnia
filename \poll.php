<?php
//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");

$datum = date("d-m-Y H:i");
$time = time();
session_start();

$site = "syrnia.com";
$polluser = $S_user;

echo "<html>
<head>
<title>Poll</title>
<style type=\"text/css\">
      TABLE{
      font-family: verdana ;
      font-size:13px;
      }
      body {
      font-family: verdana ;
      font-size:13px;
      }
      </style>
</head>
<body bgcolor=#000000 text=#CCCCCC link=#cc0000 alink=#bb0000 vlink=#dd0000>";
if ($polluser == '')
{
    echo "<b>You are not logged in!</b><br />";
}
echo "<a href=?p=answer>Answer a poll for $site</a>
<hr>";


if ($p == 'answer')
{
    #############################


    if ($poll)
    {


        $slql = "SELECT ID, title,text, users FROM polls where ID='$poll' && openedUntill>'$time' && users not like '%[$polluser]%' order by ID desc LIMIT 1";
        $resultaalt = mysqli_query($mysqli, $slql);
        while ($rec = mysqli_fetch_object($resultaalt))
        {
            $pollID = $rec->ID;

            echo "<form action='' method=post>
<B>$rec->title</B><br />
$rec->text.<BR>
<br>";

            if ($QS)
            {
                $NR = $BS;
                while ($NR < $QS && $_POST["questionID$NR"])
                {
                    $answer = $_POST["question$NR"];
                    if ($answer == '')
                    {
                        $completed = 0;
                        echo "<font color=yellow>You did not fill in question #$NR.</font>.<br />";
                    } else
                    {
                        $completed = 1;
                    }
                    $NR++;
                }

                if ($completed <> 1)
                {
                    echo "<font color=red><B>You did not fill in all answers, please do so.<br />
				Your answers were not submitted.<br /></font>";
                }

            }


            if ($completed == 1)
            {

                $NR = $BS;
                while ($NR < $QS)
                {
                    $qID = $_POST["questionID$NR"];
                    $answer = $_POST["question$NR"];

                    $sql = "INSERT INTO answers (user, pollID, questionID, answer) VALUES ('$polluser', '$poll', '$qID', '$answer')";
                    $results = mysqli_query($mysqli, $sql) or die("SQL connection error, please check your settings [Fout in module 1]");
                    $NR++;
                }

                mysqli_query($mysqli, "UPDATE  polls  SET users='$rec->users[$polluser]' where ID='$poll' LIMIT 1") or
                    die(" ERROR 222 PLEASE MAIL $contact ");

                echo "<B>Your answers have been saved.</B><br />
				Thank you for taking the time to fill it in, this can be a great help!<br />";

                $completed = 1;


            } else
            { #NOT COMPLETED


                $nr = 1;
                $sql = "SELECT ID,question, choices FROM questions WHERE pollID='$pollID' order by ID asc";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    if ($BS == '')
                    {
                        echo "<input type=hidden name=BS value='$record->ID'>";
                        $BS = 1;
                    }
                    $questions = explode(",", $record->choices);

                    echo "<B>$nr. " . stripslashes($record->question) . "</B><BR>";

                    $i = 0;
                    while ($questions[$i])
                    {
                        echo "<input type=hidden name=\"questionID$nr\" value=\"$record->ID\">
	<input type=radio name=\"question$nr\" value=\"" . stripslashes($questions[$i]) .
                            "\"> " . stripslashes($questions[$i]) . "<br>
	";
                        $i++;
                    }
                    echo "<br />";
                    $nr++;
                }

                echo "<hr>
<input type=hidden name=QS value='$nr'>
<input type=submit value='Submit the form'></form>";

            } #COMPLETED

        } #MYSQL

        if ($pollID == '')
        {
            echo "You have already answered this poll.<br />";
        }

    } else
    {
        echo "Select a poll:<br /><br>";
        $sql = "SELECT ID, title,users FROM polls WHERE openedUntill>'$time' order by id desc";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat))
        {

            echo "<B>$record->title</B> ";
            if (stristr($record->users, "[$polluser]"))
            {
                echo "<strike>Answered</strike><br />";
            } else
            {
                echo "<a href=?p=answer&poll=$record->ID>Answer</a><br />";
            }
        }


    }


} #





?>