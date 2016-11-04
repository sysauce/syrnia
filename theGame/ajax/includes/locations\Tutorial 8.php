<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 8</a><BR>";
$output.="<BR>";



} elseif($locationshow=='LocationText'){

$output.="<B><font color=red>How to learn more?</font></B><br />";
$output.="<BR>";
$output.="This is the second-last location, this tutorial has come to an end.<BR>";
$output.="If you want to learn more about specific game skills check the manual, there's a link to the manual at the bottom of the page, next to the chat bar.<BR>";
$output.="<BR>";
$output.="We hope this tutorial was usefull and saves you a lot of time exploring Syrnia on your own.<BR>";
$output.="<h3>You are now not just $S_user, <B>you are a Syrnian</B></h3>";


    $output.="Go to the last tutorial by clicking on the map at the top right.<BR>";  
    

}
}
?>