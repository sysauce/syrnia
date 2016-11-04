<?php
session_start();
define('AZtopGame35Heyam', true);
$timee = time();

$username = $_POST['username'];
$password = $_POST['password'];

//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");

require_once (GAMEPATH . "includes/db.inc.php");

if ($S_attempt < 5)
{

    $resultaaat = mysqli_query($mysqli,
        "SELECT ID FROM users WHERE online=1 LIMIT 100");
    $aantalOnline = mysqli_num_rows($resultaaat);
    if ($aantalOnline <= 2500)
    {

        $datum = date("d-m-Y H:i");
        if ($username && $password && $password <> ' ')
        {


            $S_realIP = $_SERVER['REMOTE_ADDR'];
            $QueryG = mysqli_query($mysqli,
                "SELECT banreason, banuntill FROM banned_ips WHERE bannedip='$S_realIP' && (banuntill>'$timee' OR banuntill=0) LIMIT 1");
            while ($recrd = mysqli_fetch_object($QueryG))
            {
                $reason = $recrd->banreason;
                $banuntill = $recrd->banuntill;
            }

            if ($reason)
            {
                echo "Your IP address has been banned, you are not allowed to use Syrnia.<br/>
	 The following reason was entered when banning your IP:<br/>
	 <i>$reason</i><br/>
	 <br/>";

                if ($banuntill != 0)
                {
                    echo "This ban will be removed in " . ceil(($banuntill - $timee) / 3600) .
                        " hours.If there are any problems you can use the ticket system to contact us.
	 You can of course try to use a proxy, but this is not allowed, it will never make your situation any better.<br/>
	 Instead please try to contact us OR wait untill the ban is automatically removed.<br/>";
                } else
                {
                    echo "This ban is permanent, unless the staff decides otherwise. If there are any problems you can use the ticket system to contact us.<br/>
	 You can of course try to use a proxy, but this is not allowed, it will never make your situation any better.<br/>
	 Please be wise and contact us instead.<br/>";
                }
                exit();
            }

            $sAAAl = "SELECT * FROM users WHERE username='$username' LIMIT 1";
            $resultAERt = mysqli_query($mysqli, $sAAAl);
            while ($record = mysqli_fetch_object($resultAERt))
            {


                if ($record->work != 'freezed')
                {
                    if (($record->password) == stripslashes($password))
                    {
                        include_once("mainfunctions.php");

                    	/*$resultaatS = mysqli_query($mysqli, "SELECT loggedin FROM stats WHERE username='$S_user' LIMIT 1");
	                    while ($reco = mysqli_fetch_object($resultaatS))
                        {
                            $lastlogin = $reco->loggedin;
                            if($lastlogin== '')
                            {
                                $lastlogin=0;
                            }
                        }*/

                        $result = LoginUser($record->username);
                        setcookie("gamescreenwidth", $screenwidth, time()+3600*24*7);  /* expire in 7 days */
                        if($result){
                            header("Location: " . SERVERURL . "loggedin.php?screenwidth=$screenwidth");
                            exit();
                        }else{
                            echo "Unknown login error!";
                        }
                    } #PASS


                } else
                { ## FREEZE
                    echo "Your account has been frozen by moderators because of misbehaviour, you can not login anymore.<BR>
		If your account remains frozen it will be automaticle deleted after 2-6 months.<BR>";
                    $freezed = 1;
                }
                if ($record->work == 'freezed')
                {
                    $freezed = 1;
                }
            } ## MYSQL LOGIN


        } else
        {
            header("Location: " . SERVERURL . "index.php?page=login&w=3&fee=$freezed&empty=1&DD2");
        }
    } else
    {
        echo "<b>Sorry!</b> <br />There are already $aantalOnline/$aantalOnline users playing, you can not login now. Please try again later.<br />Please make sure to notify the staff via the forums about this problem, so we will expand the games capacity.<br />  ";
        exit();
    }
} else
{ # ATTEMPTS
    echo "You have tried to login too often and can not login for a while anymore. It's also possible you tried to enter too many invalid bot check/captcha numbers. You can try to relogin to the game in a bit.<br />";
    exit();
}

if ($excists == '')
{
    $S_attempt = $S_attempt + 1;
    $_SESSION["S_attempt"]= $S_attempt;
	 header("Location: " . SERVERURL . "index.php?page=login&fee=$freezed&player=$username&DD1");
}


?>