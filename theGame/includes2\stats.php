<?php
$S_user='';

require_once("../includes/db.inc.php");
  session_start();
if($S_user){

   $resultaat = mysqli_query($mysqli, "SELECT online FROM stats WHERE username='$S_user' LIMIT 1" );
    while ($record = mysqli_fetch_object($resultaat)) { $seconds=$record->online;  }

define('AZtopGame35Heyam', true );
include('../ajax/includes/levels.php');


echo"<html>
<HEAD><TITLE>Stats</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
body {
	color:#000000;
}
</style>";
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PUBLIC">
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</HEAD>
<?
echo"<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000> ";


  if(is_numeric($open) && $S_donation>=3750){
  echo"<table border=0 width=90% height=90% bgcolor=#E2D3B2><tr valign=top><td><center>";
   $resultaat = mysqli_query($mysqli, "SELECT gold, slots, type, location FROM buildings WHERE username='$S_user' && ID='$open' LIMIT 1" );
    while ($record = mysqli_fetch_object($resultaat))
	{
		$usedSlots=0;
	    echo"<h3>Your $record->type at $record->location</h3>
	    <a href=stats.php>Back to stats</a><BR>
	    <B>Contains:</B> $record->gold gold.<BR>
	    <B>Items:</B><BR>
	    <Table>";
	    	    if($record->type=='shop'){
		       $resultaaat = mysqli_query($mysqli, "SELECT name, much, upgrademuch, itemupgrade FROM shops WHERE ID='$open' order by name asc" );
    while ($rec = mysqli_fetch_object($resultaaat))
	{
		$usedSlots+=$rec->much;
		 if($rec->upgrademuch>0){$plus="+"; }else{ $plus=''; }
		if($rec->itemupgrade){
		  	$upg=" [$plus$rec->upgrademuch $rec->itemupgrade]";
		 	$upg2="<img src=\"../../images/ingame/$rec->itemupgrade.jpg\" />";
		}else{
			$upg=''; $upg2='';
		}

	    	   echo"<tr><td>$rec->much<td>$rec->name $upg2$upg</tr>";
    }
	    }else{
	 $resultaaat = mysqli_query($mysqli, "SELECT name, much, upgrademuch, itemupgrade FROM houses WHERE ID='$open' order by name asc" );
    while ($rec = mysqli_fetch_object($resultaaat)) {
	 		$usedSlots+=$rec->much;
		  if($rec->upgrademuch>0){$plus="+"; }else{ $plus=''; }
			if($rec->itemupgrade){
			  	$upg=" [$plus$rec->upgrademuch $rec->itemupgrade]";
			 	$upg2="<img src=\"../../images/ingame/$rec->itemupgrade.jpg\" />";
			}else{
				$upg=''; $upg2='';
			}
	    	   echo"<tr><td>$rec->much<td>$rec->name $upg2$upg</tr>";
    }
	    }
	    echo"</table>";
	echo"<br /><small>$usedSlots/$record->slots slots used</small>";
	}
	    echo"<BR></table>";
    } else{


echo"<h2><font color=white>$S_user</font></h2>
<table border=0 bgcolor=#E2D3B2>
<tr><td width=85><B>Skill<td width=30><B>Level<td width=50><B>Exp<td width=90><B>Next level</tr>
<tr><td>Smithing<Td>$smithingl<td>$smithing<td>$smithingexpneeded
<tr><td>Mining<Td>$miningl<td>$mining<td>$miningexpneeded
<tr><td>Cooking<td>$cookingl<td>$cooking<td>$cookingexpneeded
<tr><td>Fishing<td>$fishingl<td>$fishing<td>$fishingexpneeded
<tr><td>Constructing<td>$constructingl<Td>$constructing<td>$constructingexpneeded
<tr><td>Trading<td>$tradingl<td>$trading<td>$tradingexpneeded
<tr><td>Thieving<td>$thievingl<td>$thieving<td>$thievingexpneeded
<tr><td>Strength<td>$strengthl<td>$strength<Td>$strengthexpneeded
<tr><td>Health<td>$healthl<td>$health<Td>$healthexpneeded
<tr><td>Defence<td>$defencel<td>$defence<Td>$defenceexpneeded
<tr><td>Attack<td>$attackl<td>$attack<Td>$attackexpneeded
<tr><td>Woodcutting<td>$woodcuttingl<td>$woodcutting<Td>$woodcuttingexpneeded
<tr><td>Speed<td>$speedl<td>$speed<Td>$speedexpneeded
<tr><td>Magic<td>$magicl<td>$magic<td>$magicexpneeded
<tr><td>Farming<td>$farmingl<td>$farming<td>$farmingexpneeded";
if($S_donation>=1500){
 $combatExp=$health+$attack+$defence+$strength;
 $combatexpNeeded=$attackexpneeded+$defenceexpneeded+$healthexpneeded+$strengthexpneeded;
echo"<tr><td><b>Combat</b></td><td>$combatL<td>$combatExp<td>&nbsp;</td></tr>";

 $totalExp=$farming+$magic+$speed+$woodcutting+$health+$attack+$defence+$strength+$thieving+$trading+$constructing+$fishing+$cooking+$mining+$smithing;
 $totalexpNeeded=$farmingexpneeded+$magicexpneeded+$speedexpneeded+$woodcuttingexpneeded+$attackexpneeded+$defenceexpneeded+$healthexpneeded+$strengthexpneeded+$thievingexpneeded+$tradingexpneeded+$constructingexpneeded+$fishingexpneeded+$cookingexpneeded+$miningexpneeded+$smithingexpneeded;
echo"<tr><td><b>Total</b></td><td>$totalskill<td>$totalExp<td>&nbsp;</td></tr>";
}
echo"</table>
<BR>
<table border=0 bgcolor=#E2D3B2>
<tr><td width=280 align=center><h3>Houses</h3> <Table><tr><td><B>Location<td><B>Slots<td><B>Farmland<td><B>gp";

$aj=0;
   $resultaat = mysqli_query($mysqli, "SELECT ID, slots, location, farmslots, gold FROM buildings WHERE username='$S_user' && type='house' ORDER BY ID asc" );
   $totalgold = 0;
    while ($record = mysqli_fetch_object($resultaat)) { 	    if($S_donation>=3750){ $DONtx="<a href=stats.php?open=$record->ID>";}
    $aj=1; echo"<tr><td>$DONtx$record->location<td>$record->slots<Td>$record->farmslots<Td>$record->gold";
    $totalgold += $record->gold;
    }
    echo"<tr><td>&nbsp;<td>&nbsp;<Td>&nbsp;<Td>$totalgold";
if($aj<>1){echo"</table><BR>You do not yet control a house.<BR>"; } else { echo"</table>"; }





echo" </table>";



echo"<br />
<table border=0 bgcolor=#E2D3B2>
<tr><td width=280 align=center><h3>Shops</h3> <Table><tr><td><B>Location<td><B>Slots<td><B>gp";
if($S_donation>=1500){ echo"<Td><B>Visits<td><B>Earnings"; }

$aj=0;
   $resultaat = mysqli_query($mysqli, "SELECT ID, slots, location, shopviews, shopearn, buildingclosed, gold+safegold AS gold FROM buildings WHERE username='$S_user' && type='shop' ORDER BY ID asc" );
    while ($record = mysqli_fetch_object($resultaat))
	{
		if($record->buildingclosed==1){
			$closed="<br /><small>closed</small>";
		}else{
			$closed="";
		}
	    if($S_donation>=3750){ $DONtx="<a href=stats.php?open=$record->ID>";}
	     $aj=1; echo"<tr valign=center><td>$DONtx$record->location</a>$closed<td>$record->slots<Td>$record->gold";  if($S_donation>=1500){ echo"<Td>$record->shopviews<td>$record->shopearn"; }
 }
if($aj<>1){echo"</table><BR>You do not yet control a shop.<BR>"; }else { echo"</table>"; }


if($S_donation>=1500){ echo"<br />With your trading level you can manage $tradingslots slots per shop.<BR>";}

echo"</td></tr></table><br />";


echo"<br/><table border=0 bgcolor=#E2D3B2>
<tr><td width=280 align=left>";
if($showstats){
		 $resultaat = mysqli_query($mysqli, "SELECT ID, joined FROM users WHERE username='$S_user' LIMIT 1" );
		    while ($record = mysqli_fetch_object($resultaat)) { $ID=$record->ID; $joined=floor((time()-$record->joined)/86400); }

		$hoursleft=floor($seconds/3600);
		if($hoursleft<0){$hoursleft=0;}
		$seconds=$seconds-($hoursleft*3600);
		$minleft=floor($seconds/60);
		if($minleft<0){$minleft=0;}

		echo"
		<B>Playing</B><BR>
		You have been playing Syrnia for $hoursleft hours and $minleft minutes.<BR>
		You joined Syrnia $joined days ago, you are player number $ID.<BR>
		<BR>
		<B>Kills</B><BR>";

		$resultaat = mysqli_query($mysqli, "SELECT playerkills, monsterkills, playerdeaths, monsterdeaths, loggedin, casinobought, casinosold FROM stats WHERE username='$S_user' LIMIT 1" );
		    while ($record = mysqli_fetch_object($resultaat)) {
		    echo"You have killed $record->monsterkills monsters/creatures,<BR>
		  and $record->playerkills players.<BR>
		    You have been killed $record->monsterdeaths times by a monster/creature,<BR>and $record->playerdeaths times by another player.<BR>
		    <BR>";
		if($S_donation>=1500){ $mi=floor((time()-$record->loggedin)/60); echo"<B>Extra stats</B><BR>
            You have been online for $mi minutes since your last login.<BR>
		You have bought a total of $record->casinobought casino chips.<BR>
		You have sold a total of $record->casinosold casino chips.<BR>";

						$resultaaat = mysqli_query($mysqli, "select (select count(*)  from users where work<>'freezed' && username!='M2H' && totalskill >
						@USER_SCORE :=(select totalskill from users where username='$S_user' LIMIT 1)) as rank1" );
		    			while ($rec = mysqli_fetch_object($resultaaat)) {
							echo"There are ".($rec->rank1)." players with higher total skills than you.<br/>";
		 				}#mysql

		 				$resultaaat = mysqli_query($mysqli, "select (select count(*)  from users where gold >
						@USER_SCORE :=(select gold from users where username='$S_user' LIMIT 1)) as rank1" );
		    			while ($rec = mysqli_fetch_object($resultaaat)) {
							echo"There are $rec->rank1 players carrying more gold than you.<br/>";
		 				}#mysql

		 }#donat
		 }#mysql
}else{
 echo"<center><a href=stats.php?showstats=1>Show my stats</a></center>";
}

echo"</table>";

} ##OPEN


}else{ echo"Sessions (timeout) problem; Your browser logged you out."; }
?>
