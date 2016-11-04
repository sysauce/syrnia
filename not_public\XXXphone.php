<?php
//GAMEURL, SERVERURL etc.
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");


$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$timee = time();

$MyEmail = "support@syrnia.com";


//DAOPAY

$ordernumber = trim($_GET['tid']);
$status = trim($_GET['stat']);

if ($ordernumber == "" || $status == "") {
    die("parameter invalid");
}


if ($status == "connected") {

    /**
     * The payment has been started
     * Process the request parameters described at the manual
     */

} else
    if ($status == "part") {

        /**
         * The payment has been terminated too soon
         * Process the request parameters described at the manual
         */

    } else
        if ($status == "ok") {
            /**
             * Payment successfully completed
             * Process the request parameters described at the manual
             */


            


            $payout = $_REQUEST['payout'];
            $tid = $_REQUEST['tid'];
            $paid = $_REQUEST['paid'];
            $currency = $_REQUEST['currency'];
            $origin = $_REQUEST['origin'];
            $prodprice = $_REQUEST['prodprice'];
            $prodcurrency = $_REQUEST['prodcurrency'];
            $appcode = $_REQUEST['appcode'];
            $mcx = $_REQUEST['mcx'];
            $mcxtid = $_REQUEST['mcxtid'];
            $mcxtimeout = $_REQUEST['mcxtimeout'];
            $mcxcurrency = $_REQUEST['mcxcurrency'];
            $mcxtariff = $_REQUEST['mcxtariff'];
            $userid = $_REQUEST['userid'];


            $donationUser = '';
            $resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE ID='$userid' LIMIT 1");
            while ($record = mysqli_fetch_object($resultaat)) {
                $donationUser = $record->username;
            }

            $donationAmount = $payout;
            //if($currency!='EUR'){
        	require_once('exchangerates.php');
        	$donationAmount = GetEuros($currency, $payout);
        	$buffer .= "Currency($currency - $payout)omgezet naar $donationAmount!\n";
           // }

            $subject = "DAOPAY transaction received";


            $buffer .= "
DAOPAY data:
Found username= $donationUser

[SELECT username FROM users WHERE ID='$userid' LIMIT 1]

$ordernumber = [ordernumber]
$payout = ['payout']; 
Syrnia Donation Amount = $donationAmount
$tid = ['tid'];
$paid = ['paid'];
$currency = ['currency'];
$origin = ['origin'];
$prodprice = ['prodprice'];
$prodcurrency = ['prodcurrency'];
$appcode = ['appcode'];
$mcx = ['mcx'];
$mcxtid = ['mcxtid']; 
$mcxtimeout = ['mcxtimeout']; 
$mcxcurrency = ['mcxcurrency']; 
$mcxtariff = ['mcxtariff']; 
$userid = ['userid'];
";


            $Query = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$donationUser' LIMIT 1");
            $aantal = mysqli_num_rows($Query);
            if ($aantal == 1) {


                $buffer .= " Found user :) ";
                $saaql = "INSERT INTO messages (username, sendby, message, time, topic)
		VALUES ('$donationUser', '<B>Syrnia</B>', 'You have donated $donationAmount euros via a (mobile) phone transaction!<br />', '$time', 'Syrnia Donation - DAOPAY')";
                mysqli_query($mysqli, $saaql) or die("EROR");

                mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$donationAmount' WHERE username='$donationUser' LIMIT 1") or
                    die("error --> 544343");


                $buffer = addslashes($buffer);
                mysqli_query($mysqli,
                    "INSERT INTO donations (username, txn_id, phpip, much, donatedby, updatedusers, time, donationAmount, details)
		VALUES ('$donationUser', '$tid', '$ip', '$donationAmount', '$donationUser', '$donationUser', '$timee', '$donationAmount', '$buffer')") or
                    die("ERROR 111 PLEASE MAIL $contact ");

            } else {
                $subject = "ERROR! DAOPAY Callback Received";
                $buffer = "DID NOT FIND USER!\n" . $buffer;
            }

            // Mail it
            mail($MyEmail, $subject, $buffer);


        } else {

            // Parameter Error
            $subject = "ERROR! DAOPAY Callback Received";
            $buffer = "DID NOT FIND STATS CODE $status for tid = $TID!\n" . $buffer;
            // Mail it
            mail($MyEmail, $subject, $buffer);

        }

        //END  DAOPAY







?>