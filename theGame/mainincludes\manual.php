<?php

ob_start();

if($manual){
	$m = $manual;
}

?><center>
<table border=0 cellspacing=10 cellpadding=10><tr bgcolor=#8F8570><td>
<B>General:</B></td>
<td><a href=?page=manual&manual=begin>How to begin</a> - <a href=?page=manual&manual=adv_begin>Advanced How to Begin</a><br />
<br />
<a href=?page=manual&manual=quests>Quests & Jobs</a>
 - <a href=?page=manual&manual=events>(Random) events</a>
 - <a href=?page=manual&manual=fame>Fame & Pirates</a>
 - <a href=?page=manual&manual=donating>Donating</a>


<tr bgcolor=#8F8570><td><B>Skills:</B></td><td>
<a href=?page=manual&manual=woodcutting><img src=images/skills/woodcutting.gif border=0 alt=woodcutting></a>
<a href=?page=manual&manual=constructing><img src=images/skills/constructing.gif border=0 alt=constructing></a>
<a href=?page=manual&manual=fishing><img src=images/skills/fishing.gif border=0 alt=fishing></a>
<a href=?page=manual&manual=cooking><img src=images/skills/cooking.gif border=0 alt=cooking></a>
<a href=?page=manual&manual=mining><img src=images/skills/mining.gif border=0 alt=mining></a>
<a href=?page=manual&manual=smithing><img src=images/skills/smithing.gif border=0 alt=smithing></a>
<BR>
<a href=?page=manual&manual=thieving><img src=images/skills/thieving.gif border=0 alt=thieving></a>
<a href=?page=manual&manual=combat><img src=images/skills/attack.gif border=0 alt=combat></a>
<a href=?page=manual&manual=trading><img src=images/skills/trading.gif border=0 alt=trading></a>
<a href=?page=manual&manual=magic><img src=images/skills/magic.gif border=0 alt=magic></a>
<a href=?page=manual&manual=speed><img src=images/skills/speed.gif border=0 alt=speed></a>
<a href=?page=manual&manual=farming><img src=images/skills/farming.gif border=0 alt=farming></a>
</table>
</center>
<?php

if ($m=='begin' OR $m=='adv_begin' OR $m=='donating' OR $m=='events' OR $m=='farming' OR $m=='woodcutting' OR $m=='magic' OR $m=='speed' OR $m=='trading' OR $m=='fame' OR $m=='quests' OR $m=='constructing' OR $m=='fishing' OR $m=='cooking' OR $m=='mining' OR $m=='smithing' OR $m=='thieving' OR $m=='combat'){
##  HOW TO BEGIN
##################
?>
<table border=0 width=100%><tr bgcolor=#E2D3B2><td>
<table border=0 cellpadding=13 width=100%><tr bgcolor=#E2D3B2><td><font color=black>
<?php include("manual/$m.php"); ?>
</table>
</table>
<?php
} else {
echo"<table border=0 width=100%><tr bgcolor=#E2D3B2><td>
<font color=black><center><h1>Syrnia game manual</h1></center>
Select a topic in the menu above to learn more about the expanded features.
</td></tr></table>";
}


$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270);


?>