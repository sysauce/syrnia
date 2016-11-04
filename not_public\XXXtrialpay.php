<?php
//GAMEURL, SERVERURL etc.
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");


$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$timee = time();

$MyEmail="support@syrnia.com";


//Trailpay
$sid=$_REQUEST["sid"];
$email=$_REQUEST["email"];

$oid=$_REQUEST["oid"];
$pid=$_REQUEST["pid"];
$reward_amount=$_REQUEST["reward_amount"];
$product_price=$_REQUEST["product_price"];
$revenue=$_REQUEST["revenue"];
$event_type=$_REQUEST["event_type"];

$Password=$_REQUEST["Password"];

// Is my received callback password the correct one?
if ($Password != 'ScsdFSD')
{
	header("HTTP/1.1 403 Forbidden");
	
	$buffer =  "Wrong password: $Password ";
	$buffer .=  "IP: $ip ";
	$buffer .=  "Time: $time ";
	$buffer .=  "Other: ..[$revenue] []$reward_amount] [$email] [$sid]";
	
	mail($MyEmail, "Trailpay Callback Received: ERROR", $buffer);
	
	echo 1;
	
    exit;
} else
{


	
	    $buffer .= "
Trailpay data:

$sid=sid
$email=email

$oid=oid
$pid=pid
$reward_amount= reward_amount
$product_price= product_price
$revenue=revenue
$event_type=event_type
";
   
   
$donationUser=$sid;
$donationAmount=$reward_amount;
$subject="Trailpay Callback Received";

  	$Query = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$donationUser' LIMIT 1");
     $aantal = mysqli_num_rows($Query);
	if($aantal==1){       
                   $buffer.=" Found user :) ";     
				$saaql = "INSERT INTO messages (username, sendby, message, time, topic)
				VALUES ('donationUser', '<B>Syrnia</B>', '$donationAmount euros have been donated for you by using a Trialpay promotion!<br />', '$time', 'Syrnia Donation - Trialpay')";
			    mysqli_query($mysqli, $saaql) or die("EROR");
			
			    mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$donationAmount' WHERE username='$donationUser' LIMIT 1") or
			        die("error --> 544343");
			
			    mysqli_query($mysqli,
			        "INSERT INTO donations (username, txn_id, phpip, much, donatedby, updatedusers, time, donationAmount)
				VALUES ('$donationUser', '$oid - $pid', '$ip', '$donationAmount', '$donationUser', '$donationUser', '$timee', '$donationAmount')") or
			        die("ERROR 111 PLEASE MAIL $contact ");
			        
        }else{
        	$subject="EROR! Trailpay Callback Received";
			$buffer="DID NOT FIND USER!\n".$buffer;
			
			        
        }
        
 // Mail it
    mail($MyEmail, $subject, $buffer);
    
    
}
?>