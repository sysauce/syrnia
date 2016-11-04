<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 9</a><BR>";
$output.="<BR>";



} elseif($locationshow=='LocationText'){


$output.="<B><font color=red>Join the world</font></B><br />";
$output.="<BR>";
$output.="You are ready to join the world of Syrnia.<BR>";
$output.="Read the game manuals for more information, and use the <b>help</b> chat to ask for help.<BR>";
$output.="<BR>";
$output.="It's now up to you to decide what you will be doing with your Syrnian live!<BR>";

$output.="<ul>";
$output.="<li>Want to become a pirate and send pirates to Kill other Syrnians?";
$output.="<li>Want to kill other players in the Outlands?";
$output.="<li>Want to become an famous trader with your own shop on every island?";
$output.="<li>Want to become the best in 1 or more skills ?";
$output.="<li>Want to provoke with your rare artifacts ?";
$output.="<li>Want to spend nights getting drunk at the Elven casino ?";
$output.="<li>Want to meet new friends ?";
$output.="</ul>";
$output.="<BR>";
$output.="In Syrnia you can be anything you want to be, your imagination is your only limit as long as you make sure to follow the rules.<br /><br />";

$output.="<a href='' onclick=\"updateCenterContents('move', 'Sanfew');updateCenterContents('reloadChatChannels');return false;\">Click here to go to Sanfew, where Syrnia actually begins!</a><BR>";




}
}
?>