<?php
if(defined('AZtopGame35Heyam')){
	
$output="
<center>
<table width=95%>
<tr><td align=left>
<h1>F.A.Q.</h1>

The information on this page should answer your question(s).<br/>


<h3>I can't login, it tells me I got the wrong login details.</h3>
Please request an email with your login details to make sure you got the right details. Use <a href=/index.php?page=lostpw>this link</a> to do so.
<br/><br/><br/>

<h3>I can't activate, or I never got the activation email.</h3>
Requesting your login details works exacly the same as an activation. Please request an email with your login details. Use <a href=/index.php?page=lostpw>this link</a> to do so.
<br/><br/><br/>


<h3>I still do not know an answer to my question</h3>
Feel free to <a href=\"tickets.php?page=ticket&action=create\" onClick='enterWindow=window.open(\"tickets.php?page=ticket&action=create\",\"Syrnia support\",
                \"width=600,height=650,top=5,left=5,scrollbars=yes,resizable=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\">contact the support via a ticket</a>.
<br/>


</td></tr>
</table>
</center>
";


$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270); 

}
?>