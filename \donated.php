<?php

echo "<html>
<head></head>
<body bgcolor=\"#333333\">
<center>
<br /><br />
<table width=798 height=100% cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
<tr height=107><td background=\"layout/main_top.jpg\"></td></tr>
<tr valign=top><td>

<table height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
<tbody>
<tr valign=top>
<td width=\"10\" background=\"layout/main_left.jpg\"/> </td><td width=\"20\" bgcolor=\"#e2d3b2\"> </td><td width=\"723\" bgcolor=\"#e2d3b2\"><center><h1>Donation</h1></center>";

if ($wallie)
{ ##WALLIE
    echo "<h1>You have donated successfully!</h1>
	 Thank you for donating to syrnia, the account you specified has been upgraded!<br/>
	 If your specified account has not got any extra donation status then it might need a re-login, if that doesn't help you can contact support@syrnia.com.<br/>
	 You can now close this screen and continue playing!<br/>";
}else if ($phone)
{ ##WALLIE
    echo "<h1>Thank you for using DAOPay</h1>
	  If you have successfully completed a DAOPay transaction then your donation status should be updated after a game refresh. A game relogin might help if the changes did not apply right away.<br/>";
}else if ($trialpay)
{ ##TRAILPAY
    echo "<h1>Thank you for using trialpay!</h1>
	 If you have successfully completed an trialpay offer/transaction then your donation status should be updated according to the trailpay estimation. If your donation status should be updated right away, a game relogin might be required.<br/>";
	 } else
{ ## PAYPAL
    $ip = $_SERVER['REMOTE_ADDR'];


    echo "
<font size=3>";


    if ($cancelled == 1 or $cancel == 1)
    { ## CANCEL

        echo "You have cancelled your donation.<BR>";

    } else
    {

        echo "Everything should have been transferred successfully, thank you for your donation!<br />
<br />
<b>1. If you've used an e-cheque:</b><br />
Your donation will be added to your account the moment the e-cheque clears (usually +/- 5 working days).<br />
You can check the status of your e-cheque any time at paypals website.<br />
<br />
<b>2. For all other paypal donation methods:</b><br/>
Your donation should have just been added to your account properly.<br/>
Please re-login to the game to check if the donation was added, feel free to add a support ticket about the donation if it was not added.<br/>
If you want, you can now transfer (a part of) your donation to other player(s) by going to the support page in-game.<br/>
<br/>
<br/>
Your donation was very helpfull to Syrnia; even small donations help more than you think.<BR>
We hope you will enjoy your extra in-game features.<BR>
<br/>
Thank you,<br/>
Everyone behind syrnia.com<br/>";


    } #paypal payment
} #wallie

echo "</td><td width=\"20\" bgcolor=\"#e2d3b2\"> </td><td width=\"10\" background=\"layout/main_right.jpg\"/>
</tr>
<tr>
</tr>
</tbody>
</table>

</td></tr></table></center></body></html>";
?>