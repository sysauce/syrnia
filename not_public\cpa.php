<?php
echo"About to check..<br />";

require_once ('../currentRunningVersion.php');

$campaign = $_REQUEST['campaign'];
$sub = $_REQUEST['sub'];
$earn = $_REQUEST['earn'];
if ($password == '')
{
    $password = $_REQUEST['password'];
}
if ($sub == '')
{
    $sub = $_REQUEST['subid'];
}
if ($password != 'p4s')
{
    echo "wrong!<br />";
    exit;
}

if (stristr($sub, "[SH]"))
{
    echo"extern..<br />";
	$subSH = substr($sub, 4, 100);
    file("http://www.slavehack.com/cpa.php?password=p4s&campaign=$campaign&campid=$campid&sub=$subSH&earn=$earn&testy=1");
    //$result = implode ('', $url);
	
    exit();
}else{
	echo"syrnia..<br />";

}
echo "0!";
// Require generic functions.
require_once (GAMEPATH . "includes/db.inc.php");

echo "1!";
include_once (GAMEPATH . 'ajax/includes/functions.php');
echo "2!";

$resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$sub' LIMIT 1");
$exists = mysqli_num_rows($resultaat);
if ($exists == 1)
{
	echo "almost adding..";
	$much = ceil($earn / 0.5);
	if ($much <= 0)
	{
	    $much = 1;
	}
	if ($much >= 20)
	{
	    $much = 20;
	}
	
	addItem("$sub", 'Red gift', "$much", 'open', '', '', 0);
	
	$time = time();
	$sql = "INSERT INTO votes (username, datum, vars, earn, site)
	         VALUES ('$sub', '$time', 'c[$campaign]e[$earn]p[$password],s[$sub]', '$earn', '$campaign')";
	mysqli_query($mysqli, $sql) or die("Syrnia is not accesible at the moment, please come back in a while $sql");

	echo "success!";

}else{
	echo"Error! That username does not exist";	
}

?>


