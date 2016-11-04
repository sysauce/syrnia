<?php
ksort($_REQUEST);
$hashparam = 'security_request_hash';
$data = '';
$privatekey = '25eb77664f3a3afb2821f9400edda26e';
foreach ($_REQUEST as $key => $val) {
if ($key != $hashparam) { $data .= $val; }
}
if (md5($data . $privatekey) != $_REQUEST[$hashparam]){
return;  /* FAILED CHECK */
}
/* SUCCESS - YOUR SCRIPT GOES HERE */


$ip = $_SERVER['REMOTE_ADDR'];
require_once ("../currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");

$datum = date("d-m-Y H:i");
$time = time();
$timee = time();
session_start();



$points = $_REQUEST['points'];
$name = $_REQUEST['name'];   
$email = $_REQUEST['email'];   
$quantity = $_REQUEST['quantity'];
$reference = $_REQUEST['reference'];
$tags = $_REQUEST['tags'];

while($quantity>0){
    
    $rand = rand(1000,9999);
    $code = "$points$reference"."_$rand";
    
    
    mysqli_query($mysqli,
        "INSERT INTO premiumcodes (code, points, email, quantity, reference, tags, name)
		VALUES ('$code', '$points', '$email', '$quantity', '$reference', '$tags', '$name')") or
        die("ERROR 111 PLEASE MAIL ");
    $Query = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$tryuser' LIMIT 1");
   
    echo $code."\n";                    
                        
    $quantity -= 1;
}




?>