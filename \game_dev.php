<?php

if ($_SERVER['REMOTE_ADDR'] != "81.171.7.245")
{
    exit();
}

//GAMEURL, SERVERURL etc.
//require_once("currentRunningVersion.php");

//OVERRULE !
define("GAMEFOLDER", "devGame/");
define("GAMEPATH", "/var/www/html/syrnia/devGame/");
define("GAMEURL", "http://" . $_SERVER['HTTP_HOST'] . "/devGame/");
define("SERVERURL", "http://" . $_SERVER['HTTP_HOST'] . "/");
define("CHATLOGPATH", "/var/www/html/syrnia/logs/chat/");


// Require the main game file.
require_once (GAMEPATH . "index.php");

?>