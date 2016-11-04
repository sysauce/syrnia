<?php

ob_start();

?>

<center><h1>Highscore</h1><?php 

$drinkingSkillEnabled=false;
if(defined('AZtopGame35Heyam')){


$dateH=date(Y_m_d_);



if ($rank == username){$order=username; }
elseif ($rank == mining){$order=mining; }
elseif ($rank == smithing){$order=smithing;}
elseif($rank == speed){$order=speed; }
elseif($rank == attack){$order=attack; }
elseif($rank == defence){$order=defence; }
elseif($rank == strength){$order=strength; }
elseif($rank == health){$order=health; }
elseif($rank == speed){$order=speed; }
elseif($rank == level){$order=level; }
elseif($rank == woodcutting){$order=woodcutting; }
elseif($rank == constructing){$order=constructing; }
elseif($rank == trading){$order=trading; }
elseif($rank == thieving){$order=thieving; }
elseif($rank == fishing){$order=fishing; }
elseif($rank == magic){$order=magic; }
elseif($rank == cooking){$order=cooking; } 
elseif($rank == farming){$order=farming; } 
elseif($drinkingSkillEnabled==true && $rank == drinking){$order=drinking; } 
else{ $rank=speed; $order=totalskill; }


 echo"
 <a href=index.php?page=highscore2>Search player</a> - <a href=index.php?page=highscore2&clan=1>Show clanlist</a><BR>
 The highscore contains the top 1000 players and is updated every hour.<BR>
 <center><B>Skill: $order</B></center><BR>

<center>
<table width=700>
<tr><td width=100><td width=95 valign=top>
<center>

<Table>
<tr><td>
<table cellpadding=0 cellspacing=0 border=0>
<tr bgcolor=#DEC598 align=center valign=center><td><a href=index.php?page=highscore&action=players&rank=level><img border=0 src=images/level.gif alt='Combat Level'></a></td><td><a href=index.php?page=highscore&action=players&rank=total><img src=images/totalskill.gif alt='Total Skill' border=0></a>
<tr><td><a href=index.php?page=highscore&action=players&rank=smithing><img src=images/skills/smithing.gif border=0 alt='Smithing'></a></td>
<td><a href=index.php?page=highscore&action=players&rank=speed><img src=images/skills/speed.gif border=0 alt='Speed'></a></td>
<tr><td><a href=index.php?page=highscore&action=players&rank=attack><img src=images/skills/attack.gif border=0 alt='Attack'></a></td>
<td><a href=index.php?page=highscore&action=players&rank=defence><img src=images/skills/defence.gif border=0 alt='Defence'></a></td>
<tr><td><a href=index.php?page=highscore&action=players&rank=strength><img src=images/skills/strenght.gif border=0 alt='Strength'></a></td>
<td><a href=index.php?page=highscore&action=players&rank=health><img src=images/skills/health.gif border=0 alt='Health'></a></td>
<tr><td><a href=index.php?page=highscore&action=players&rank=woodcutting><img src=images/skills/woodcutting.gif alt='Woodcutting' border=0></a></td>
<td><a href=index.php?page=highscore&action=players&rank=constructing><img src=images/skills/constructing.gif alt='Constructing' border=0></a></td>
<tr><td><a href=index.php?page=highscore&action=players&rank=trading><img src=images/skills/trading.gif border=0 alt='Trading'></a></td>
<td><a href=index.php?page=highscore&action=players&rank=thieving><img src=images/skills/thieving.gif border=0 alt=Thieving></a></td>
<tr><td><a href=index.php?page=highscore&action=players&rank=fishing><img src=images/skills/fishing.gif border=0 alt=Fishing></a></td>
<td><a href=index.php?page=highscore&action=players&rank=cooking><img src=images/skills/cooking.gif border=0 alt=Cooking></a></td>
</tr><tr><Td><a href=index.php?page=highscore&action=players&rank=mining><img src=images/skills/mining.gif border=0 alt=Mining></a></td>
<Td><a href=index.php?page=highscore&action=players&rank=magic><img src=images/skills/magic.gif border=0 alt=Magic></a></td>
<tr><Td><a href=index.php?page=highscore&action=players&rank=farming><img src=images/skills/farming.gif border=0 alt=Farming></a></td>
</table>
</td></tr></table>


<td width=30>
<td valign=top>
<center>


<Table>
<tr><td bgcolor=#8F8570>
";




if($order<>'totalskill' && $order<>'level'){
echo"
<Table>
<tr bgcolor=#DEC598>
<td>Rank
<td>Username
<td>Level
<td>Experience
</tr>
";
}else{
echo"
<Table>
<tr bgcolor=#DEC598>
<td>Rank
<td>Username
<td>Level
<td>Total exp
</tr>
";
}

 
        $uur = date(H);
        $dateSLA = date(Y_m_d_);

$file = "logs/highscore/newformat/$dateSLA$order.php";

if (!$file_handle = fopen($file,"r")) { echo "Cannot open file; The highscore is still being created..check again in a few minutes. <br />\n"; }   
	if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot open file; The highscore is still being created...check again in a few minutes. <br />\n"; } 
	fclose($file_handle); 

	$lines = explode('
', $file_contents);
	

	$rank=0;
	foreach($lines as $line){		
		$data = explode('@', $line);		
		if($data[2]){
			$rank++;
			echo  "<tr>
			<td>".$rank."
			<td><a target=_blank href=\"http://www.syrnia.com/index.php?page=highscore2&high=".$data[0]."\"><font color=white>".$data[0]."</font></a>
			<td>".$data[1]."
			<td>".$data[2]."
			</tr>";
		}
	}    
	


echo"</table></table></td></tr></table>";


$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270); 





}
?>