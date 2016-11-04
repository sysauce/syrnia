<?php
if(defined('AZtopGame35Heyam') && $_SESSION['S_user']){


	$sql = "SELECT  dump2 FROM users WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{

	 $jailreason=$record->dump2;
	}


	$output.="<center><Table cellpadding=0 class=\"inhoud\" cellspacing=0 width=100%>";
	$output.="<tr><td width=13 height=13 background=layout/layout3_LB.jpg></td><td background=layout/layout3_B.jpg></td><td width=13 background=layout/layout3_RB.jpg></td></tr>";
	$output.="<tr height=100><td background=layout/layout3_L.jpg></td><td CLASS=\"inhoud\" valign=top align=center>";
	$output.="<table width=100%><tr><td width=10></td><td align=left valign=top>";


	$jailtime=$jailtime-time()+1;

	$output.="<Center>";
	$output.="<BR>";
	$output.="<center><font color=white>";
	$output.="<h1>Locked up, you rogue!</h1>";
	$output.="You have been locked up in the $S_location jail.<BR>";
	$output.="<B>Reason:</B> $jailreason.<BR>";
	$output.="You will need to wait until you have paid for your crime.<BR>";
	$output.="<BR>";

	$hour=date(G);
	if($hour>=21 OR $hour<=3){$image='night';} #21-3 night      6
	elseif($hour<=4 OR $hour>=21){$image='night';} #4-9 morning  6
	else{ $image='day'; } #10-20 day   10
	$output.="<img src='images/work/jail.jpg' id='workImage' border=1><BR>";
	$output.="<BR>";


	$output.="<input type=\"text\" readonly size=\"5\" value='$jailtime' id=\"jailCounter\" style=\"background-color: #660000; border: 0 solid #333333\" class=counter></form>";



	$output.="</td><td width=10></td></tr>";
	$output.="</table>";
	$output.="<br />";
	$output.="</td><td background=layout/layout3_R.jpg></td></tr>";
	$output.="<tr><td width=13 height=13 background=layout/layout3_LO.jpg></td><td background=layout/layout3_O.jpg></td><td background=layout/layout3_RO.jpg></td></tr>";
	$output.="</table>";

	$output=str_replace('"', '\\"', $output);
	echo"if($('jailCounter')==null){";
	echo "$('centerContent').innerHTML=\"$output\";";
	echo"}";

	echo"countDown('jailCounter', (new Date().getTime()+($jailtime)*1000), 'loadLayout', \"releaseFromJail\");";
	echo"if(disableImages && $('workImage')){\$('workImage').remove();}";




} # define
?>