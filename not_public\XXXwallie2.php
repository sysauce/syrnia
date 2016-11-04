<?php
//GAMEURL, SERVERURL etc.
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");


$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$timee = time();
// My callback password, as set in the management section.
$MyCallbackPassword = 'terug';
$MyEmail = 'support@syrnia.com';
// First, we process the $_POST variables.
$ResultCode = $_POST["ResultCode"];
$ShoppingCartId = $_POST["ShoppingCartId"];
$TransDate = $_POST["TransDate"];
$TransTime = $_POST["TransTime"];
$Password = $_POST["Password"];
$TestMode = $_POST["TestMode"];
$TransferAmount = $_POST["TransferAmount"];
$TransactionCosts = $_POST["TransactionCosts"];
$TotalAmount = $_POST["TotalAmount"];

// Is my received callback password the correct one?
if ($Password != $MyCallbackPassword)
{
	header("HTTP/1.1 403 Forbidden");
	
	$buffer =  "Wrong password: $Password ";
	$buffer .=  "IP: $ip ";
	$buffer .=  "Time: $time ";
	$buffer .=  "Other: $ResultCode - $ShoppingCartId - $TransDate - $TotalAmount";
	
	mail($MyEmail, "Wallie Callback Received: ERROR", $buffer);
	
	echo 1;
	
    exit;
} else
{
	   // Callback was correct. Mark the transaction as succesful!
    // For this example script, i'll mail the details of this transaction to myself.

    $buffer .= "The syrnia account $ShoppingCartId donated " . ($TransferAmount /
        100) . " euros";


    $donationUser = $ShoppingCartId;
    $donationAmount = $TransferAmount / 100;

    $saaql = "INSERT INTO messages (username, sendby, message, time, topic)
	VALUES ('donationUser', '<B>Syrnia</B>', '$donationAmount euros have been donated for you !<br />', '$time', 'Syrnia Donation')";
    mysqli_query($mysqli, $saaql) or die("EROR");

    mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$donationAmount' WHERE username='$donationUser' LIMIT 1") or
        die("error --> 544343");

    mysqli_query($mysqli,
        "INSERT INTO donations (username, txn_id, phpip, much, donatedby, updatedusers, time, donationAmount)
	VALUES ('$donationUser', '$TestMode - $ResultCode', '$ip', '$donationAmount', '$donationUser', '$donationUser', '$timee', '$donationAmount')") or
        die("ERROR 111 PLEASE MAIL $contact ");


    $buffer .= "
Someone payed you a total of $TotalAmount eurocent!:
Details:
ShoppingCartID = $ShoppingCartId   (donationUser=$donationUser)
Date = $TransDate
Time = $TransTime
Testmode = $TestMode
TransferAmount = $TransferAmount
TransactionCosts = $TransactionCosts
TotalAmount = $TotalAmount  (donation=$donationAmount)
";
    // Mail it
    mail($MyEmail, "Wallie Callback Received", $buffer);

}
?>