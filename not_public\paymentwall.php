<?php
$appkey = 'a75f86de09ed3bfef7b181e5a463e53b';
$appsecret = '69104aa2ae0d3e3466ab5aa289fc0be4';

$SECRET_KEY = $_REQUEST['SECRET_KEY'];
$uid = $_REQUEST['uid'];
$currency = $_REQUEST['currency'];
$type = $_REQUEST['type'];
$ref = $_REQUEST['ref'];
$sig = $_REQUEST['sig'];

$mySIG = MD5("uid=".$uid."currency=".$currency."type=".$type."ref=".$ref."".$appsecret."") ;

if($mySIG!=$sig){
    echo"invalid sig";
    exit();
}


$ip = $_SERVER['REMOTE_ADDR'];
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");

$datum = date("d-m-Y H:i");
$time = $timee = time();


$MyEmail = "support@syrnia.com";
 
 
    $donationUser = ''; 
    $resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE ID='$uid' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat)) {
        $donationUser = $record->username;
    }
    $pointsToCash = $currency;
    
    
    
if($type==0 || $type==1){
    //CREDIT OR CUSTOMERSERVICECREDIT
    
      
    
    
    
    $buffer .= "donationUser=$donationUser\n";
    $buffer .= "uid=$uid\n";
    $buffer .= "currency=$currency\n";
    $buffer .= "type=$type\n";
    $buffer .= "ref=$ref\n";
        
    if($donationUser){
        $subject = "Syrnia payment - Paymentwall - $pointsToCash";        
        $buffer .= " Found user :)\n";
        
   
        mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$pointsToCash' WHERE username='$donationUser' LIMIT 1") or die("error --> 544343");


        $buffer = addslashes($buffer);
            mysqli_query($mysqli,
                "INSERT INTO donations (username, txn_id, phpip, much, donatedby, updatedusers, time, donationAmount, details)
	VALUES ('$donationUser', '$ref', '$ip', '$pointsToCash', '$donationUser', '$donationUser', '$timee', '$pointsToCash', '$buffer')") or
                die("ERROR 111 PLEASE MAIL $contact ");

    } else {
        $subject = "ERROR! Paymentwall no user found!";
        $buffer .= "DID NOT FIND USER!\n" . $buffer;
    }

        
        
        // Mail it
        mail($MyEmail, $subject, $buffer);



    
        
        echo "OK";

    
}else if($type==2){
     //CHARGEBACK
    echo "OK $currency for $uid  type=$type  ref=$ref";
// Mail it
    $subject = "ERROR! Unhandled Paymentwall chargeback! Removed from main account, but this could go into negative if it was given to others!";
    $buffer .= " Unhandled Paymentwall chargeback\n";
    $buffer .= "donationUser=$donationUser\n";
    $buffer .= "uid=$uid\n";
    $buffer .= "currency=$currency\n";
    $buffer .= "type=$type\n";
    $buffer .= "ref=$ref\n";
        
        
    mysqli_query($mysqli, "UPDATE stats SET donation=donation-'$pointsToCash' WHERE username='$donationUser' LIMIT 1") or die("error --> 544343");

    mail($MyEmail, $subject, $buffer);


}  
    




?>