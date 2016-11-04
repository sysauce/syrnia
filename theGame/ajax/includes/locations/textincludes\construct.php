<?
if(defined('AZtopGame35Heyam')){

include_once('includes/levels.php');

$output.="<b>Constructing</b><br />";
$output.="<BR>";
$output.="<BR>";

$output.="<b>Shops</b><BR>";
if($constructingl>=5){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop100');return false;\">Build a shop (100 slots) 500 wood</a><BR>"; }
if($constructingl>=6){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop250');return false;\">Build a shop (250 slots) 750 wood</a><BR>"; }
if($constructingl>=12){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop500');return false;\">Build a shop (500 slots) 1,000 wood</a><BR>"; }
if($constructingl>=15){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop750');return false;\">Build a shop (750 slots) 1,250 wood</a><BR>"; }
if($constructingl>=18){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop1000');return false;\">Build a shop (1,000 slots) 1,500 wood</a><BR>"; }
if($constructingl>=23){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop1500');return false;\">Build a shop (1,500 slots) 2,000 wood</a><BR>"; }
if($constructingl>=26){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop2000');return false;\">Build a shop (2,000 slots) 4,000 wood</a><BR>"; }
if($constructingl>=30){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop2500');return false;\">Build a shop (2,500 slots) 5,000 wood</a><BR>"; }
if($constructingl>=40){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop5000');return false;\">Build a shop (5,000 slots) 7,500 wood</a><BR>"; }
if($constructingl>=50){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop10000');return false;\">Build a shop (10,000 slots) 15,000 wood</a><BR>"; }
if($constructingl>=60){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop20000');return false;\">Build a shop (20,000 slots) 30,000 wood</a><BR>"; }
if($constructingl>=70){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop30000');return false;\">Build a shop (30,000 slots) 40,000 wood</a><BR>"; }
if($constructingl>=80){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop40000');return false;\">Build a shop (40,000 slots) 50,000 wood</a><BR>"; }
if($constructingl>=90){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop50000');return false;\">Build a shop (50,000 slots) 65,000 wood</a><BR>"; }
if($constructingl>=99){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'shop100000');return false;\">Build a shop (100,000 slots) 100,000 wood</a><BR>"; }


$output.="<BR><BR><B>Houses</B><BR>";
if($constructingl>=1){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house250');return false;\">Build a house (250 slots) 250 wood</a><BR>"; }
if($constructingl>=1){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house500');return false;\">Build a house (500 slots) 750 wood</a><BR>"; }
if($constructingl>=10){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house1500');return false;\">Build a house (1500 slots) 2,500 wood</a><BR>"; }
if($constructingl>=20){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house3000');return false;\">Build a house (3000 slots) 5,000 wood</a><BR>"; }
if($constructingl>=25){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house5000');return false;\">Build a house (5000 slots) 10,000 wood</a><BR>"; }
if($constructingl>=35){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house10000');return false;\">Build a house (10,000 slots) 15,000 wood</a><BR>"; }
if($constructingl>=45){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house25000');return false;\">Build a house (25,000 slots) 20,000 wood</a><BR>"; }
if($constructingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house50000');return false;\">Build a house (50,000 slots) 30,000 wood</a><BR>"; }
if($constructingl>=65){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house75000');return false;\">Build a house (75,000 slots) 45,000 wood</a><BR>"; }
if($constructingl>=75){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house100000');return false;\">Build a house (100,000 slots) 60,000 wood</a><BR>"; }
if($constructingl>=85){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house150000');return false;\">Build a house (150,000 slots) 90,000 wood</a><BR>"; }
if($constructingl>=95){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'house250000');return false;\">Build a house (250,000 slots) 150,000 wood</a><BR>"; }


$output.="<BR><BR><B>Boats</B><BR>";
if($constructingl>=20){ $output.="<a href=''' onclick=\"locationText('work', 'constructing', 'Small fishing boat');return false;\">Build a small fishing boat 2,000 wood</a><BR>"; }
if($constructingl>=35){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'Sloop');return false;\">Build a sloop 5,000 wood</a><BR>"; }
if($constructingl>=42){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'Boat');return false;\">Build a boat 10,000 wood</a><BR>"; }
if($constructingl>=50){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'Trawler');return false;\">Build a trawler 15,000 wood</a><BR>"; }
if($constructingl>=55){ $output.="<a href='' onclick=\"locationText('work', 'constructing', 'Canoe');return false;\">Build a canoe 18,000 wood</a><BR>"; }




}
?>