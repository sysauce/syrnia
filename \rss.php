<?php

//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");

header("Content-Type: application/rss+xml");


?>
<<?php ?>?xml version="1.0"?>
<rss version="2.0">
<channel>
<title>Syrnia news RSS feed</title>
<description>All news items from Syrnia, a free browserbased RPG game</description>
<link>http://www.syrnia.com</link>
<ttl>1440</ttl>

<?php

$resultaat = mysqli_query($mysqli, "SELECT ID, titel, date, mesage FROM news ORDER BY ID DESC LIMIT 10") or die('Error, query failed');
while ($record = mysqli_fetch_object($resultaat))
{
	$ID=$record->ID;
	$message=stripslashes($record->mesage);
	$titel=stripslashes($record->titel);
	$date=$record->date;
	
	$message=str_replace("<br />", "", $message);
	$message=str_replace("<br>", "", $message);
	$message=htmlentities($message);

	
	$unixTime = mktime(0, 0, 0, substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4));

echo"<item>
<guid>".htmlentities("http://www.syrnia.com/index.php?page=news&ID=$ID")."</guid>
<title>".htmlentities($titel)."</title>
<description>".$message."</description>
<link>".htmlentities("http://www.syrnia.com/index.php?page=news&ID=$ID")."</link>
<pubDate>".	date('r', $unixTime)."</pubDate>
</item>
";


}	


?>


</channel>
</rss>

