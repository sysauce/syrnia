<?
if(defined('AZtopGame35Heyam')){


if($S_location=='Valera'){ $kwester='Derek Friddik'; }
elseif($S_location=='Sanfew'){ $kwester='Tom Friddik'; }
elseif($S_location=='Port Senyn'){ $kwester='John Friddik'; }
elseif($S_location=='Rile'){ $kwester='George Friddik'; }

$output.="<h3>$kwester</h3>";
$output.="The Friddik brothers are known for all the strange jobs they give to anyone visiting them, they can always give you something to do.<BR>";
$output.="<BR>";
$output.="They will never say what they will pay you as reward. Another strange fact is that they will only reward you if you complete your job within the time limit...<BR>";
$output.="Seems like the Friddik brothers have got a strange sense of humour.<BR>";
$output.="<hr><BR>";


$time=time();
$sql = "SELECT timelimit, jobgive, jobgivemuch FROM quests WHERE username='$S_user' && dump='$kwester' && timelimit<$time LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat))
{
    $telaat=$time-$record->timelimit;
    $output.="<i>$kwester tells you:</i> Sorry $S_user but you are $telaat seconds too late for completing the job, I do not need the $record->jobgivemuch $record->jobgive anymore.<BR>";
    $sql = "DELETE FROM quests WHERE username='$S_user' && dump='$kwester' && timelimit<$time LIMIT 1";
    mysqli_query($mysqli, $sql) or die("error report this bug please  asdghf1");
}

if($var1=='endquest'){ ## endquest
	$sql = "SELECT dump, joblocation, jobgive, jobgivemuch FROM quests WHERE username='$S_user' && dump='$kwester' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{  ##SQL

		$sqll = "SELECT much FROM items_inventory WHERE username='$S_user' && name='$record->jobgive' && much>=$record->jobgivemuch && itemupgrade='' LIMIT 1";
		$resultaaat = mysqli_query($mysqli, $sqll);
		while ($recoord = mysqli_fetch_object($resultaaat))
		{
			if($record->jobgive=='Wood'){ //Missie 1
				$reward="Gold";  $rewardmuch=rand(30,60);  $rewardtype="";
				$tekst="<i>$kwester tells you:</i> Ahhh $S_user thanks. ";
				$tekst.="Here's your reward.<BR>";
				$tekst.="<i>$kwester gives you <B>$rewardmuch $reward</b></i><BR><BR>";
			}else if($record->jobgive=='Tin ore'){ //Missie 2
				$reward="Bronze bars";  $rewardmuch=rand(15,50);  $rewardtype="bars";
				$tekst="<i>$kwester tells you:</i> The ores I needed! Thanks $S_user!<BR>";
				$tekst.="I have been trying to smith for some days but I actually don't want to smith the bars...you may have them.<BR>";
				$tekst.="I'll just keep smelting, here's your reward.<BR>";
				$tekst.="<i>$kwester gives you <B>$rewardmuch $reward</b></i><BR><BR>";
			}else if($record->jobgive=='Rod'){ //Missie 3
				$reward="Gold";  $rewardmuch=rand(60,165);  $rewardtype="";
				$tekst="<i>$kwester tells you:</i> A rod? A ROD!<BR>";
				$tekst.="Im very happy! Those stinky shrimps make me go CRAZY.<BR>";
				$tekst.="Here, take this as reward!<BR>";
				$tekst.="<i>$kwester gives you <B>$rewardmuch $reward</b></i><BR>";
				$tekst.="<i>$kwester runs away...he is most likely going to fish something other than shrimps..</i><BR><BR>";
			}else if($record->jobgive=='Cooked Sardine'){ //Missie 4
				$reward="Gold";  $rewardmuch=$much*4+25;  $rewardtype="";
				$tekst="<i>$kwester tells you:</i> What... I can't come over?<BR>";
				$tekst.="It's always the same ....He forgets to cook for 2, then uses the same lame excuse every time \"I haven't been able to clean up my house\"...<BR>";
				$tekst.="Ah well, I guess he asked you to bring me some food instead?<BR>";
				$tekst.="Thanks for that though.<BR>";
				$tekst.="<i>$kwester gives you <B>$rewardmuch $reward</b></i><BR>";
				$tekst.="<BR><BR>";
			}else{ //Missie 5
				$naarwie=""; $reward="Gold";  $rewardmuch=rand(40,155);  $rewardtype="";
				$tekst="<i>$kwester tells you:</i> Ah a letter...let me read it..<BR>";
				$tekst.="...I can't eat burnt fish? I guess this is just a joke.<BR>";
				$tekst.="It looks very crunchy and tasty, so it should be eatable...<BR>";
				$tekst.="Im hungry ..Please leave me alone..I'll pay you to leave..right NOW.<BR>";
				$tekst.="<i>$kwester gives you <B>$rewardmuch $reward</b></i><BR>";
				$tekst.="<BR><BR>";
			}


			removeItem($S_user, $record->jobgive, $record->jobgivemuch, '', '', 1);
			$sqlaa = "DELETE FROM quests WHERE username='$S_user' && dump='$kwester' LIMIT 1";
			  mysqli_query($mysqli, $sqlaa) or die("error report this bug please  asdghf1");

			$kwe=1;  $tekst=stripslashes($tekst);
			$output.="$tekst";
			if($reward=='Gold'){ # gold
				getGold($S_user, $rewardmuch);
			} else { # geen gold
				addItem($S_user, $reward, $rewardmuch, $rewardtype, '', '', 1);

			} # geen gold
		} ## EINDE 2e SQL


		if($kwe<>1){ $output.="<B>You have not got the $record->jobgivemuch $record->jobgive yet!</b><BR><BR>"; }
	} # eubde SQL BEGIN
} ## einde endquest


   $sql = "SELECT dump, joblocation, jobgivemuch, jobgive FROM quests WHERE username='$S_user' && dump<>'$kwester' && dump LIKE '%Friddik%'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$output.="<i>$kwester tells you:</i> Welcome $S_user, I cannot give you any quests, weren't you going to $record->dump at $record->joblocation to get him $record->jobgivemuch $record->jobgive?<BR>";
		$kwest=1;
	}


   $sql = "SELECT dump, joblocation, jobgivemuch, jobgive, timelimit FROM quests WHERE username='$S_user' && dump='$kwester'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$timeleft=$record->timelimit-time();
		$output.="<i>$kwester tells you:</i> Have you got the $record->jobgivemuch $record->jobgive?<BR>";
		$output.="<a href='' onclick=\"locationText('friddik', 'endquest');return false;\">Yes</a><BR><BR>You have got ".ceil($timeleft/60)." minutes left to finish this job.";
		$kwest=1;
	}

## als je nogg een quest doet.
if($kwest<>1){

#vraag wuestje
if($var1=='ask'){
## GET RANDOM BROER
	$naarlocation='';
	while($naarlocation==''){
		$naarwi=rand(1,4);
		if($naarwi==1){$naarwie="Derek Friddik";  $naarlocation="Valera";
		}elseif($naarwi==2){ $naarwie="John Friddik";  $naarlocation="Port Senyn";
		}elseif($naarwi==3){ $naarwie="George Friddik";  $naarlocation="Rile";
		}elseif($naarwi==4){  $naarwie="Tom Friddik";  $naarlocation="Sanfew";  }
		if($naarlocation==$S_location){ $naarlocation=''; }
	}
	## GET RANDOM MISSIE
	$missie=rand(1,5);
	if($missie==1){
	#######################
		$item="Wood";  $much=rand(3,25);  $tijd=$much*20;   $timelimit=$tijd+rand(1200,2000);
		$tekst="<i>$kwester tells you:</i> $S_user, I've got a job for you;<BR>";
		$tekst.="Bring my brother $naarwie $much $item within ".ceil($timelimit/60)." minutes.<BR>";
		$tekst.="He lives in $naarlocation.<BR>";
		$tekst.="I believe he needs the wood to create some new chairs..";

		$description="Get $naarwie $much $item";

	}elseif($missie==2){
	#######################
		$item="Tin ore";  $much=rand(5,35);  $tijd=$much*20;      $timelimit=$tijd+rand(1200,2000);
		$tekst="<i>$kwester tells you:</i> $S_user, I've got a job for you;<BR>";
		$tekst.="Bring my brother $naarwie $much $item within ".ceil($timelimit/60)." minutes.<BR>";
		$tekst.="He lives in $naarlocation.<BR>";
		$tekst.="I believe he is trying to learn how to smith, but I don't think he even knows how to use a hammer..HAHA!<BR>";
		$tekst.="When we were kids I once hit him with a hammer on his head.<BR>He forgot his name and didn't know it for weeks, and nobody wanted to tell him his name!<BR>";
		$tekst.="He hasn't touched a hammer ever since.<BR>";
		$tekst.="Well... you'd better be going.";

		$description="Get $naarwie $much $item";

	}elseif($missie==3){
	#######################
		$item="Rod";  $much="1";  $tijd="1";       $timelimit=$tijd+rand(1200,2000);
		$tekst="<i>$kwester tells you:</i> $S_user, I've got a job for you;<BR>";
		$tekst.="Bring my brother $naarwie $much $item within ".ceil($timelimit/60)." minutes.<BR>";
		$tekst.="He lives in $naarlocation.<BR>";
		$tekst.="He was net fishing all the time, but he really hates those shrimps, and so do I!<BR>";
		$tekst.="Please bring him a rod, so he can fish on species which we all love to eat!<BR>";
		$tekst.="I'll hope he will invite me to dinner when he can make some nice food.<BR>";
		$tekst.="Please be quick.";

		$description="Get $naarwie $much $item";

	}elseif($missie==4){
	#######################
		$item="Cooked Sardine";  $much=rand(5,30);  $tijd=$much*20;        $timelimit=$tijd+rand(1200,2000);
		$tekst="<i>$kwester tells you:</i> $S_user, I've got a job for you;<BR>";
		$tekst.="Me and $naarwie would have dinner together tonight but I can't invite him over since I haven't been able to cleanup my house.<BR>";
		$tekst.="Could you tell him he can't come over tonight, and also bring him $much $item?<BR>";
		$tekst.="Although you will need to get to him before he's on his way to my house.<BR>";
		$tekst.="(within ".ceil($timelimit/60)." minutes)<BR>";
		$tekst.="$naarwie lives in $naarlocation.<BR>";
		$tekst.="Thanks in forward.";

		$description="Get $naarwie $much $item";

	}elseif($missie==5){
	#######################
		  addItem($S_user, 'Friddik quest letter', 1, 'quest', '', '', 1);
		$item="Friddik quest letter";  $much=1;  $tijd=0;    ;    $timelimit=$tijd+rand(600,1500);
		$tekst="<i>$kwester tells you:</i> You have got excellent timing!<BR>";
		$tekst.="I really need you to tell my brother $naarwie he can't eat the burnt shrimps I gave him!<BR>";
		$tekst.="Bah. I always make jokes about eating burnt fish. Some people will really believe you can eat it!!<BR>";
		$tekst.="I've sent $naarwie a shipment of food but an employee of mine added some burnt fish too, he thought he was funny.<BR> ";
		$tekst.="Please be quick and give him thise message explaining him some stuff about burnt fish.<BR>";
		$tekst.="<i>$kwester gives you a Letter</i>";

		$description="Bring $naarwie the $item";

	}


	### INSERT
	$timelimit=$timelimit+time();
	$tekstbro=addslashes($tekstbro);
	$sql = "INSERT INTO quests (username, jobname, dump, joblocation, jobgive, jobgivemuch, timelimit, jobdescription)
	  VALUES ('$S_user', 'The Friddik Brothers', '$naarwie', '$naarlocation', '$item', '$much','$timelimit', '$description')";
	mysqli_query($mysqli, $sql) or die("error report this kuuwest bug ");



	$output.="$tekst";

} else{ ## geen vraag
	$output.="<a href='' onclick=\"locationText('friddik', 'ask');return false;\">Ask $kwester for a job.</a><BR>";
} ## eidne aanvraag

}
} # einde define
?>