<?php
if ($wallie)
{
    ##WALLIE

    echo "<h1>You have donated succesfully !</h1>
	 Thank you for donating to syrnia, the account you specified has been upgraded !<br/>
	 If your specified account has not got any extra donation status then it might need a re-login, if that doesn't help you can contact support@syrnia.com.<br/>
	 You can now close this screen and continue playing !<br/>";

} else
{
    ## PAYPAL

    $ip = $_SERVER['REMOTE_ADDR'];

    require_once ("../currentRunningVersion.php");
    require_once (GAMEPATH . "includes/db.inc.php");


    $datum = date("d-m-Y H:i");
    $time = time();
    $timee = time();
    $DONATIONTOGIVE = 0;
    $S_user = '';
    session_start();

    $contact = "support@syrnia.com";


    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    //$req = 'cmd=_notify-synch';

    foreach ($_POST as $key => $value)
    {
        $value = urlencode(stripslashes($value));
        $req .= "&$key=$value";
    }

    // terugsturen naar PayPal-systeem ter validering
    $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    $fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);

    // geposte codes toewijzen aan lokale variabelen
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $mc_fee = $_POST['mc_fee'];

	$address_country_code =  $_POST['address_country_code'];
	$residence_country = $_POST['residence_country'];
	$COUNTRYCODE=$address_country_code;
	if(!$COUNTRYCODE){
		$COUNTRYCODE=$residence_country;
	}
	
    $mailContent = "IF this is at the top of the mail, the donation failed!


itemname: $item_name 
itemnr: $item_number

payment status: $payment_status 
payment amount: $payment_amount $payment_currency 
mc_fee: $mc_fee 

CountryCode: $COUNTRYCODE

txnid: $txn_id 

recierver email: $receiver_email 
email: $payer_email 

Memo: ".$_POST['memo']."

### Too much details:
$req";

    if (!$fp)
    {
        // HTTP-fout
        // HTTP ERROR
        echo "HTTP ERROR<BR>
		This has been logged !<BR>
		Contact $contact for more information if your account has not got the donation status it should have !<BR>
		Include this error report and your in-game username.<BR>";

        $mailContent .= "HTTP Error: 
		user=$S_user
		UN=$UN
		SHowner=$SHowner";
    } else
    {
        fputs($fp, $header . $req);
        while (!feof($fp))
        {
            $res = fgets($fp, 1024);
            if (strcmp($res, "VERIFIED") == 0)
            {
                // controleren of payment_status is Completed
                // controleren of txn_id niet eerder is verwerkt
                // controleren of receiver_email uw primaire PayPal-adres is
                // controleren of payment_amount/payment_currency kloppen
                // betaling verwerken

                $Query = mysqli_query($mysqli, "SELECT ID FROM donations WHERE txn_id='$txn_id' LIMIT 1");
                $aantTXN = mysqli_num_rows($Query);

                if (($aantTXN < 1 or $aantTXN == '') && $payment_currency == 'EUR' && ($receiver_email ==
                    'support@syrnia.com' or $receiver_email == 'support@m2h.nl' || $receiver_email == 'syrnia@syrnia.com') && $payment_status ==
                    'Completed')
                {

                    $tryuser = $S_user;
                    if ($S_user == '')
                    {
                        $tryuser = str_replace("Syrnia donation ", "", "$item_name");
                    }

                    if (stristr($tryuser, 'SlaveHack donation '))
                    {


                        $link = "http://www.slavehack.com/donatedPIN.php?pass=45gTrFes43F&user=$tryuser&item_name=$item_name&item_number=$item_number&payment_status=$payment_status&payment_amount=$payment_amount&payment_currency=$payment_currency&txn_id=$txn_id&receiver_email=$receiver_email&payer_email=$payer_email&mc_fee=$mc_fee";
                        $link = str_replace(" ", "%20", $link);

                        $result = implode('', file($link));


                        $mailContent = "On syrnia server: donation passed on to SH
						 	
						 	TEMP!!! link[ $link ]
						 	
						 	The response was: $result
						 	
						 	-End response
						 	
						 	$mailContent";


                    } else
                    {
                        mysqli_query($mysqli,
                            "INSERT INTO donations (username, txn_id, phpip, much, time, donatedby, donationAmount, countrycode, details, fee)
							VALUES ('$user', '$txn_id', '$ip', '$mc_gross', '$timee', '$tryuser', '$mc_gross', '',  '$req', '$mc_fee')") or
                            die("ERROR 111 PLEASE MAIL $contact ");
                        $Query = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$tryuser' LIMIT 1");
                        $aantal = mysqli_num_rows($Query);

                        if ($aantal == 1)
                        {
                            mysqli_query($mysqli, "UPDATE stats SET donation=donation+'$mc_gross' WHERE username='$tryuser' LIMIT 1") or
                                die("ert113");

                            $mailContent = "Syrnia donation, succes: $tryuser ($mc_gross)
								
							 	$mailContent";
                        } else
                        {
                            $extraSubject = "FAILED:";
                            $mailContent = "ERROR: Syrnia donation user \"$tryuser\" not found ($mc_gross)
								
							 	$mailContent";
                        }

                    }


                } else
                {
                    $extraSubject = "FAILED:";

                    $tryuser = str_replace("Syrnia donation ", "", "$item_name");
                    $Query = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$tryuser' LIMIT 1");
                    $aantal = mysqli_num_rows($Query);
                    if ($aantal == 1 && $payment_status == 'Pending')
                    {
                        //it's a syrnia user, and payment is pending
                        $text = "Dear $truyser,<br />
					<br />
					You have just completed your donation to Syrnia. However, it was not added right away as the donation is still pending. Paypal e-cheque transactions are usualy pending for 2-5 business days before they clear.<br />
					<br />
					Please note that we are waiting for Paypal.com to clear the donation, and that we cannot help to speed it up.<br />
					You can check the details of the donation any time at your paypal account.<br />
					<br />
					Regards,<br />
					Syrnia.com";
                        $sql = "INSERT INTO messages (username, sendby, message, topic, time)
					  VALUES ('$tryuser', '<B>Syrnia</b>', '$text', 'Donation pending', '$timee')";
                        mysqli_query($mysqli, $sql) or die("error report this ");

                    }


                }

                //END OF VERIFIED

            } else
                if (strcmp($res, "INVALID") == 0)
                {
                    // loggen voor handmatig onderzoek
                    $extraSubject = "FAILED:";
                    $mailContent = "INVALID PAYMENT ($res): 
			user=$S_user
			UN=$UN
			SHowner=$SHowner
			
			$mailContent";
                } else
                {
                    // $mailContent.="Odd error ($res)!\n\r";
                }
        }
        fclose($fp);
    }


    $mailSubject = "$extraSubject Donation [$tryuser] [$mc_gross] at $timee";

    mail("$contact", $mailSubject, $mailContent, "From: $contact");


} #wallie OR paypal

?>
end