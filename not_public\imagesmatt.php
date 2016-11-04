<?php
if(!$kabouter){
	exit();
}

// Require generic functions.
require_once ("../theGame/includes/db.inc.php");

echo "<html><body bgcolor=#000000>

";

$sql = "SELECT name FROM houses group by name order by type";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat))
{
    $i++;
    echo "<img align=left src=\"../images/inventory/$record->name.gif\" />
";

}

echo "

<br />
<br />
<small>$i images</small>
</body></html>";

?>
