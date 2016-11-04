<?
if(defined('AZtopGame35Heyam')){


$output.="<h2>Smithing</h2>";

if($var1==''){

$output.="<B>Select a metal to smith:</B><BR>";
$output.="<a href='' onclick=\"locationText('smith', 'bronze');return false;\">Bronze</a><BR>";

if($smithingl>=10){ $output.="<a href='' onclick=\"locationText('smith', 'iron');return false;\">Iron</a><BR>";}
if($smithingl>=25){ $output.="<a href='' onclick=\"locationText('smith', 'steel');return false;\">Steel</a><BR>";}
if($smithingl>=40){ $output.="<a href='' onclick=\"locationText('smith', 'silver');return false;\">Silver</a><BR>";}
if($smithingl>=55){  $output.="<a href='' onclick=\"locationText('smith', 'gold');return false;\">Gold</a><BR>";}
if($smithingl>=70){  $output.="<a href='' onclick=\"locationText('smith', 'platina');return false;\">Platina</a><BR>"; }
if($smithingl>=85){  $output.="<a href='' onclick=\"locationText('smith', 'syriet');return false;\">Syriet</a><BR>"; }
if($smithingl>=100 && $S_location=='Beset'){  $output.="<a href='' onclick=\"locationText('smith', 'obsidian');return false;\">Obsidian</a><BR>"; }
if($smithingl>=120)
{
    $resultaaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE username='$S_user' && name = 'Puranium bars' LIMIT 1");
    $havePuranium = mysqli_num_rows($resultaaat);
    if($havePuranium > 0)
    {
        $output.="<a href='' onclick=\"locationText('smith', 'puranium');return false;\">Puranium</a><BR>";
    }
}

	if($smithingl>=15){

		$output.="<br /><B>Or select an upgrade:</B><BR>";
		$output.="<a href='' onclick=\"locationText('smith', 'upgrade');return false;\">Upgrade using spider silk</a><BR>";

	}

}

if($var1){ $output.="<a href='' onclick=\"locationText('smith');return false;\">Back to smith overview</a><BR><BR>"; }
if($var1=='bronze'){


$output.="<B>Bronze</B><BR>";
if($smithingl>=-5 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze cauldron');return false;\">Bronze cauldron (3 bars)</a><BR>"; }
if($smithingl>=-5 && $S_location!='Tutorial 3' && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze safe');return false;\">Bronze safe (6 bars)</a><BR>"; }
if($smithingl>=-5 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze pickaxe');return false;\">Bronze pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=-5){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze dagger');return false;\">Bronze dagger (1 bar)</a><BR>"; }
if($smithingl>=-5 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze hatchet');return false;\">Bronze hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=-4 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze hammer');return false;\">Bronze hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=-4 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze sabatons');return false;\">Bronze sabatons (2 bars)</a><BR>"; }
if($smithingl>=-3 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze short sword');return false;\">Bronze short sword (2 bars)</a><BR>"; }
if($smithingl>=-3 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze medium helm');return false;\">Bronze medium helm (1 bar)</a><BR>"; }
if($smithingl>=-2 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze scimitar');return false;\">Bronze scimitar (2 bars)</a><BR>"; }
if($smithingl>=-2 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze small shield');return false;\">Bronze small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=-1 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze mace');return false;\">Bronze mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=0 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze hands');return false;\">Bronze hands (2 bars)</a><BR>"; }
if($smithingl>=1 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze long sword');return false;\">Bronze long sword (2 bars)</a><BR>"; }
if($smithingl>=2 && $S_location!='Tutorial 3'){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze medium shield');return false;\">Bronze medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=3){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze chainmail');return false;\">Bronze chainmail(4 bars)</a><BR>"; }
if($smithingl>=4){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze legs');return false;\">Bronze legs (4 bars)</a><BR>"; }
if($smithingl>=5){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze large helm');return false;\">Bronze large helm (3 bars)</a><BR>"; }
if($smithingl>=6){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze axe');return false;\">Bronze axe (3 bars)</a><BR>"; }
if($smithingl>=7){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze large shield');return false;\">Bronze large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=8){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze two handed sword');return false;\">Bronze two handed sword (4 bars)</a><BR>"; }
if($smithingl>=9){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Bronze plate');return false;\">Bronze plate (5 bars)</a><BR>"; }

} elseif($var1=='iron'){

$output.="<B>Iron</B><BR>";
if($smithingl>=10){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron cauldron');return false;\">Iron cauldron (3 bars)</a><BR>"; }
if($smithingl>=10 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron safe');return false;\">Iron safe (6 bars)</a><BR>"; }
if($smithingl>=10){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron pickaxe');return false;\">Iron pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=10){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron dagger');return false;\">Iron dagger (1 bar)</a><BR>"; }
if($smithingl>=10){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron hatchet');return false;\">Iron hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=11){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron hammer');return false;\">Iron hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=11){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron sabatons');return false;\">Iron sabatons (2 bars)</a><BR>"; }
if($smithingl>=12){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron short sword');return false;\">Iron short sword (2 bars)</a><BR>"; }
if($smithingl>=12){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron medium helm');return false;\">Iron medium helm (1 bar)</a><BR>"; }
if($smithingl>=13){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron scimitar');return false;\">Iron scimitar (2 bars)</a><BR>"; }
if($smithingl>=13){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron small shield');return false;\">Iron small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=14){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron mace');return false;\">Iron mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=15){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron hands');return false;\">Iron hands (2 bars)</a><BR>"; }
if($smithingl>=16){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron long sword');return false;\">Iron long sword (2 bars)</a><BR>"; }
if($smithingl>=17){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron medium shield');return false;\">Iron medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=18){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron chainmail');return false;\">Iron chainmail (4 bars)</a><BR>"; }
if($smithingl>=19){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron legs');return false;\">Iron legs (4 bars)</a><BR>"; }
if($smithingl>=20){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron large helm');return false;\">Iron large helm (3 bars)</a><BR>"; }
if($smithingl>=21){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron axe');return false;\">Iron axe (3 bars)</a><BR>"; }
if($smithingl>=22){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron large shield');return false;\">Iron large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=23){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron two handed sword');return false;\">Iron two handed sword (4 bars)</a><BR>"; }
if($smithingl>=24){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Iron plate');return false;\">Iron plate (5 bars)</a><BR>"; }

}elseif($var1=='steel'){
$output.="<B>Steel</B><BR>";
if($smithingl>=25){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel cauldron');return false;\">Steel cauldron (3 bars)</a><BR>"; }
if($smithingl>=25 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel safe');return false;\">Steel safe (6 bars)</a><BR>"; }
if($smithingl>=25){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel pickaxe');return false;\">Steel pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=25){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel dagger');return false;\">Steel dagger (1 bar)</a><BR>"; }
if($smithingl>=25){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel hatchet');return false;\">Steel hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=26){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel hammer');return false;\">Steel hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=26){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel sabatons');return false;\">Steel sabatons (2 bars)</a><BR>"; }
if($smithingl>=27){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel short sword');return false;\">Steel short sword (2 bars)</a><BR>"; }
if($smithingl>=27){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel medium helm');return false;\">Steel medium helm (1 bar)</a><BR>"; }
if($smithingl>=28){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel scimitar');return false;\">Steel scimitar (2 bars)</a><BR>"; }
if($smithingl>=28){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel small shield');return false;\">Steel small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=29){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel mace');return false;\">Steel mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=30){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel hands');return false;\">Steel hands (2 bars)</a><BR>"; }
if($smithingl>=31){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel long sword');return false;\">Steel long sword (2 bars)</a><BR>"; }
if($smithingl>=32){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel medium shield');return false;\">Steel medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=33){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel chainmail');return false;\">Steel chainmail (4 bars)</a><BR>"; }
if($smithingl>=34){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel legs');return false;\">Steel legs (4 bars)</a><BR>"; }
if($smithingl>=35){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel large helm');return false;\">Steel large helm (3 bars)</a><BR>"; }
if($smithingl>=36){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel axe');return false;\">Steel axe (3 bars)</a><BR>"; }
if($smithingl>=37){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel large shield');return false;\">Steel large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=38){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel two handed sword');return false;\">Steel two handed sword (4 bars)</a><BR>"; }
if($smithingl>=39){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Steel plate');return false;\">Steel plate (5 bars)</a><BR>"; }


}elseif($var1=='silver'){
$output.="<B>Silver</B><BR>";
if($smithingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver cauldron');return false;\">Silver cauldron (3 bars)</a><BR>"; }
if($smithingl>=40 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver safe');return false;\">Silver safe (6 bars)</a><BR>"; }
if($smithingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver pickaxe');return false;\">Silver pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver dagger');return false;\">Silver dagger (1 bar)</a><BR>"; }
if($smithingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver hatchet');return false;\">Silver hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=41){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver hammer');return false;\">Silver hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=41){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver sabatons');return false;\">Silver sabatons (2 bars)</a><BR>"; }
if($smithingl>=42){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver short sword');return false;\">Silver short sword (2 bars)</a><BR>"; }
if($smithingl>=42){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver medium helm');return false;\">Silver medium helm (1 bar)</a><BR>"; }
if($smithingl>=43){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver scimitar');return false;\">Silver scimitar (2 bars)</a><BR>"; }
if($smithingl>=43){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver small shield');return false;\">Silver small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=44){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver mace');return false;\">Silver mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=45){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver hands');return false;\">Silver hands (2 bars)</a><BR>"; }
if($smithingl>=46){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver long sword');return false;\">Silver long sword (2 bars)</a><BR>"; }
if($smithingl>=47){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver medium shield');return false;\">Silver medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=48){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver chainmail');return false;\">Silver chainmail (4 bars)</a><BR>"; }
if($smithingl>=49){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver legs');return false;\">Silver legs (4 bars)</a><BR>"; }
if($smithingl>=50){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver large helm');return false;\">Silver large helm (3 bars)</a><BR>"; }
if($smithingl>=51){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver axe');return false;\">Silver axe (3 bars)</a><BR>"; }
if($smithingl>=52){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver large shield');return false;\">Silver large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=53){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver two handed sword');return false;\">Silver two handed sword (4 bars)</a><BR>"; }
if($smithingl>=54){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Silver plate');return false;\">Silver plate (5 bars)</a><BR>"; }


}elseif($var1=='gold'){
$output.="<B>Gold</B><BR>";
if($smithingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold cauldron');return false;\">Gold cauldron (3 bars)</a><BR>"; }
if($smithingl>=55 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold safe');return false;\">Gold safe (6 bars)</a><BR>"; }
if($smithingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold pickaxe');return false;\">Gold pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold dagger');return false;\">Gold dagger (1 bar)</a><BR>"; }
if($smithingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold hatchet');return false;\">Gold hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=56){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold hammer');return false;\">Gold hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=56){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold sabatons');return false;\">Gold sabatons (2 bars)</a><BR>"; }
if($smithingl>=57){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold short sword');return false;\">Gold short sword (2 bars)</a><BR>"; }
if($smithingl>=57){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold medium helm');return false;\">Gold medium helm (1 bar)</a><BR>"; }
if($smithingl>=58){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold scimitar');return false;\">Gold scimitar (2 bars)</a><BR>"; }
if($smithingl>=58){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold small shield');return false;\">Gold small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=59){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold mace');return false;\">Gold mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=60){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold hands');return false;\">Gold hands (2 bars)</a><BR>"; }
if($smithingl>=61){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold long sword');return false;\">Gold long sword (2 bars)</a><BR>"; }
if($smithingl>=62){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold medium shield');return false;\">Gold medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=63){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold chainmail');return false;\">Gold chainmail (4 bars)</a><BR>"; }
if($smithingl>=64){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold legs');return false;\">Gold legs (4 bars)</a><BR>"; }
if($smithingl>=65){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold large helm');return false;\">Gold large helm (3 bars)</a><BR>"; }
if($smithingl>=66){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold axe');return false;\">Gold axe (3 bars)</a><BR>"; }
if($smithingl>=67){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold large shield');return false;\">Gold large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=68){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold two handed sword');return false;\">Gold two handed sword (4 bars)</a><BR>"; }
if($smithingl>=69){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Gold plate');return false;\">Gold plate (5 bars)</a><BR>"; }


}elseif($var1=='platina'){
$output.="<B>Platina</B><BR>";
if($smithingl>=70){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina cauldron');return false;\">Platina cauldron (3 bars)</a><BR>"; }
if($smithingl>=70 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina safe');return false;\">Platina safe (6 bars)</a><BR>"; }
if($smithingl>=70){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina pickaxe');return false;\">Platina pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=70){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina dagger');return false;\">Platina dagger (1 bar)</a><BR>"; }
if($smithingl>=70){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina hatchet');return false;\">Platina hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=71){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina hammer');return false;\">Platina hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=71){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina sabatons');return false;\">Platina sabatons (2 bars)</a><BR>"; }
if($smithingl>=72){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina short sword');return false;\">Platina short sword (2 bars)</a><BR>"; }
if($smithingl>=72){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina medium helm');return false;\">Platina medium helm (1 bar)</a><BR>"; }
if($smithingl>=73){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina scimitar');return false;\">Platina scimitar (2 bars)</a><BR>"; }
if($smithingl>=73){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina small shield');return false;\">Platina small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=74){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina mace');return false;\">Platina mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=75){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina hands');return false;\">Platina hands (2 bars)</a><BR>"; }
if($smithingl>=76){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina long sword');return false;\">Platina long sword (2 bars)</a><BR>"; }
if($smithingl>=77){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina medium shield');return false;\">Platina medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=78){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina chainmail');return false;\">Platina chainmail (4 bars)</a><BR>"; }
if($smithingl>=79){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina legs');return false;\">Platina legs (4 bars)</a><BR>"; }
if($smithingl>=80){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina large helm');return false;\">Platina large helm (3 bars)</a><BR>"; }
if($smithingl>=81){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina axe');return false;\">Platina axe (3 bars)</a><BR>"; }
if($smithingl>=82){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina large shield');return false;\">Platina large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=83){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina two handed sword');return false;\">Platina two handed sword (4 bars)</a><BR>"; }
if($smithingl>=84){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Platina plate');return false;\">Platina plate (5 bars)</a><BR>"; }

}elseif($var1=='syriet'){

$output.="<B>Syriet</B><BR>";
if($smithingl>=85){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet cauldron');return false;\">Syriet cauldron (3 bars)</a><BR>"; }
if($smithingl>=85 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet safe');return false;\">Syriet safe (6 bars)</a><BR>"; }
if($smithingl>=85){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet pickaxe');return false;\">Syriet pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=85){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet dagger');return false;\">Syriet dagger (1 bar)</a><BR>"; }
if($smithingl>=85){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet hatchet');return false;\">Syriet hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=86){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet hammer');return false;\">Syriet hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=86){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet sabatons');return false;\">Syriet sabatons (2 bars)</a><BR>"; }
if($smithingl>=87){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet short sword');return false;\">Syriet short sword (2 bars)</a><BR>"; }
if($smithingl>=87){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet medium helm');return false;\">Syriet medium helm (1 bar)</a><BR>"; }
if($smithingl>=88){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet scimitar');return false;\">Syriet scimitar (2 bars)</a><BR>"; }
if($smithingl>=88){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet small shield');return false;\">Syriet small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=89){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet mace');return false;\">Syriet mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=90){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet hands');return false;\">Syriet hands (2 bars)</a><BR>"; }
if($smithingl>=91){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet long sword');return false;\">Syriet long sword (2 bars)</a><BR>"; }
if($smithingl>=92){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet medium shield');return false;\">Syriet medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=93){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet chainmail');return false;\">Syriet chainmail (4 bars)</a><BR>"; }
if($smithingl>=94){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet legs');return false;\">Syriet legs (4 bars)</a><BR>"; }
if($smithingl>=95){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet large helm');return false;\">Syriet large helm (3 bars)</a><BR>"; }
if($smithingl>=96){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet axe');return false;\">Syriet axe (3 bars)</a><BR>"; }
if($smithingl>=97){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet large shield');return false;\">Syriet large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=98){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet two handed sword');return false;\">Syriet two handed sword (4 bars)</a><BR>"; }
if($smithingl>=99){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Syriet plate');return false;\">Syriet plate (5 bars)</a><BR>"; }

}elseif($var1=='obsidian' && $S_location=='Beset'){

$output.="<B>Obsidian</B><BR>";
if($smithingl>=100){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian cauldron');return false;\">Obsidian cauldron (3 bars)</a><BR>"; }
if($smithingl>=100 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian safe');return false;\">Obsidian safe (6 bars)</a><BR>"; }
if($smithingl>=100){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian pickaxe');return false;\">Obsidian pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=100){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian dagger');return false;\">Obsidian dagger (1 bar)</a><BR>"; }
if($smithingl>=100){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian hatchet');return false;\">Obsidian hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=101){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian hammer');return false;\">Obsidian hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=101){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian sabatons');return false;\">Obsidian sabatons (2 bars)</a><BR>"; }
if($smithingl>=102){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian short sword');return false;\">Obsidian short sword (2 bars)</a><BR>"; }
if($smithingl>=102){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian medium helm');return false;\">Obsidian medium helm (1 bar)</a><BR>"; }
if($smithingl>=103){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian scimitar');return false;\">Obsidian scimitar (2 bars)</a><BR>"; }
if($smithingl>=103){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian small shield');return false;\">Obsidian small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=104){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian mace');return false;\">Obsidian mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=105){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian hands');return false;\">Obsidian hands (2 bars)</a><BR>"; }
if($smithingl>=106){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian long sword');return false;\">Obsidian long sword (2 bars)</a><BR>"; }
if($smithingl>=107){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian medium shield');return false;\">Obsidian medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=108){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian chainmail');return false;\">Obsidian chainmail (4 bars)</a><BR>"; }
if($smithingl>=109){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian legs');return false;\">Obsidian legs (4 bars)</a><BR>"; }
if($smithingl>=110){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian large helm');return false;\">Obsidian large helm (3 bars)</a><BR>"; }
if($smithingl>=111){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian axe');return false;\">Obsidian axe (3 bars)</a><BR>"; }
if($smithingl>=112){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian large shield');return false;\">Obsidian large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=113){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian two handed sword');return false;\">Obsidian two handed sword (4 bars)</a><BR>"; }
if($smithingl>=114){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Obsidian plate');return false;\">Obsidian plate (5 bars)</a><BR>"; }

}elseif($var1=='puranium'){

$output.="<B>Puranium</B><BR>";
if($smithingl>=120){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium cauldron');return false;\">Puranium cauldron (3 bars)</a><BR>"; }
if($smithingl>=120 && stristr($_SESSION['S_questscompleted'], "[26]")){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium safe');return false;\">Puranium safe (6 bars)</a><BR>"; }
if($smithingl>=120){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium pickaxe');return false;\">Puranium pickaxe (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=120){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium dagger');return false;\">Puranium dagger (1 bar)</a><BR>"; }
if($smithingl>=120){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium hatchet');return false;\">Puranium hatchet (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=122){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium hammer');return false;\">Puranium hammer (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=122){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium sabatons');return false;\">Puranium sabatons (2 bars)</a><BR>"; }
if($smithingl>=124){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium short sword');return false;\">Puranium short sword (2 bars)</a><BR>"; }
if($smithingl>=124){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium medium helm');return false;\">Puranium medium helm (1 bar)</a><BR>"; }
if($smithingl>=126){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium scimitar');return false;\">Puranium scimitar (2 bars)</a><BR>"; }
if($smithingl>=126){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium small shield');return false;\">Puranium small shield (1 bar, 1 wood)</a><BR>"; }
if($smithingl>=128){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium mace');return false;\">Puranium mace (2 bars, 1 wood)</a><BR>"; }
if($smithingl>=130){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium hands');return false;\">Puranium hands (2 bars)</a><BR>"; }
if($smithingl>=132){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium long sword');return false;\">Puranium long sword (2 bars)</a><BR>"; }
if($smithingl>=134){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium medium shield');return false;\">Puranium medium shield (2 bars, 2 wood)</a><BR>"; }
if($smithingl>=136){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium chainmail');return false;\">Puranium chainmail (4 bars)</a><BR>"; }
if($smithingl>=138){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium legs');return false;\">Puranium legs (4 bars)</a><BR>"; }
if($smithingl>=140){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium large helm');return false;\">Puranium large helm (3 bars)</a><BR>"; }
if($smithingl>=142){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium axe');return false;\">Puranium axe (3 bars)</a><BR>"; }
if($smithingl>=144){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium large shield');return false;\">Puranium large shield (3 bars, 1 wood)</a><BR>"; }
if($smithingl>=146){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium two handed sword');return false;\">Puranium two handed sword (4 bars)</a><BR>"; }
if($smithingl>=148){ $output.="<a href='' onclick=\"locationText('work', 'smithing', 'Puranium plate');return false;\">Puranium plate (5 bars)</a><BR>"; }



}elseif($var1=='upgrade'){


	//+1 15		+2   25		+3   40		+4   60		+5   80
	$upgrades[1]['upgradeType']="Durability";
	$upgrades[1]['upgradeMuch']=1;
	$upgrades[1]['upgradeLevel']=15;
	$upgrades[1]['upgradeCost1name']="Soft spider silk";
	$upgrades[1]['upgradeCost1much']=1;
	$upgrades[1]['upgradeCost2name']='';
	$upgrades[1]['upgradeCost2much']='';
	$upgrades[1]['upgradeEXP']='75';
	$upgrades[1]['upgradeBasetime']='120';

	$upgrades[2]['upgradeType']="Durability";
	$upgrades[2]['upgradeMuch']=2;
	$upgrades[2]['upgradeLevel']=30;
	$upgrades[2]['upgradeCost1name']="Hardened spider silk";
	$upgrades[2]['upgradeCost1much']=1;
	$upgrades[2]['upgradeCost2name']='';
	$upgrades[2]['upgradeCost2much']='';
	$upgrades[2]['upgradeEXP']='150';
	$upgrades[2]['upgradeBasetime']='160';

 	if(is_numeric($var3) && is_numeric($var2) && $upgrades[$var2]['upgradeType']){

        $output.="<B>Upgrade: +".$upgrades[$var2]['upgradeMuch']." ".$upgrades[$var2]['upgradeType']." (".$upgrades[$var2]['upgradeCost1much']." ".$upgrades[$var2]['upgradeCost1name'].")</B><br />";
        $resultaaat = mysqli_query($mysqli, "SELECT ID FROM items_wearing WHERE type != 'trophy' AND username='$S_user' && name LIKE '% hammer' LIMIT 1");
        $aantalEquipped = mysqli_num_rows($resultaaat);
        if($aantalEquipped>0){


            if($upgrades[$var2]['upgradeLevel']>$smithingl){
                exit();
            }

            $itemIDToUpgrade=$var3;
            $item1=$upgrades[$var2]['upgradeCost1name'];
            $aantaltype1=$upgrades[$var2]['upgradeCost1much'];

            $item2=$upgrades[$var2]['upgradeCost2name'];
            $aantaltype2=$upgrades[$var2]['upgradeCost2much'];


            $resultaaat = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE username='$S_user' && name='$item1' && much>='$aantaltype1' LIMIT 1");
            $aantalty1 = mysqli_num_rows($resultaaat);

            if($item2){
                $resultaaat = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE username='$S_user' && name='$item2' && itemupgrade='' && much>=$aantaltype2 LIMIT 1");
                $aantalty2 = mysqli_num_rows($resultaaat);
            }else{
                $aantalty2=1;
            }

            if($aantalty1 && $aantalty2){//Got the required items
                $sql = "SELECT ID, name, much, type FROM items_inventory WHERE username='$S_user' && itemupgrade='' && ID='$itemIDToUpgrade' LIMIT 1";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat))
                {
                    if(stristr($record->name, "Dragon") === false)
                    {
                        if($record->type=='shoes' OR $record->type=='hand' OR $record->type=='helm' OR $record->type=='legs' OR $record->type=='gloves' OR $record->type=='body' OR $record->type=='shield')
                        {
                            $output.="<a href='' onclick=\"locationText('work', 'smithing', 'upgrade', '$var2', '$var3');return false\">Start upgrading the $record->name</a><BR>";
                        }
                    }
                    else
                    {
                        $output.="You can't upgrade your $record->name with " . $item1 . " because it appears to be imbued with powerful magic.</a><BR>";
                    }
                }
            }
            else {

                $output.="You have not got all the items you need for this upgrade:<br /><ul>";
                $output.="<li>$aantaltype1 $item1<BR>";
                if($item2){
                    $output.="<li>$aantaltype2 $item2<BR>";
                }
                $output.="</ul>";
            }

        }
        else
        {
            $output.="You need to wear a hammer. Equip your hammer and click <a href='' onclick=\"locationText('smith', 'upgrade', '$var2', '$var3');return false\">here</a> to continue.";
        }
 	}else if(is_numeric($var2) && $upgrades[$var2]['upgradeType']){

		$output.="<B>Upgrade: +".$upgrades[$var2]['upgradeMuch']." ".$upgrades[$var2]['upgradeType']." (".$upgrades[$var2]['upgradeCost1much']." ".$upgrades[$var2]['upgradeCost1name'].")</B><br />";
		$output.="On what item do you want to apply this upgrade? (You can not be wearing it)<br /><br />";



		   $sql = "SELECT ID, name, much, type, itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && itemupgrade='' ORDER BY name asc";
		   $resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
				if($record->type=='shoes' OR $record->type=='hand' OR $record->type=='helm' OR $record->type=='legs' OR $record->type=='gloves' OR $record->type=='body' OR $record->type=='shield'){
			 		$output.="<a href='' onclick=\"locationText('smith', 'upgrade', '$var2', '$record->ID');return false\">$record->name</a><BR>";
			 	}
			}


	}else{

		$output.="<B>Possible upgrades</B><BR>";

		for($i=1;$upgrades[$i]['upgradeType'];$i++){
			if($smithingl>=$upgrades[$i]['upgradeLevel']){ $output.="<a href='' onclick=\"locationText('smith', 'upgrade', '$i');return false;\">+".$upgrades[$i]['upgradeMuch']." ".$upgrades[$i]['upgradeType']." (".$upgrades[$i]['upgradeCost1much']." ".$upgrades[$i]['upgradeCost1name'].")</a><BR>"; }
		}

	}


}






}
?>