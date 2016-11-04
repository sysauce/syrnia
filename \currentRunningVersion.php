<?php

// Define the location of game files.
if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost:8080")
{
	define("DEBUGMODE", "true");

    define("GAMEFOLDER", "theGame/");
    define("GAMEPATH", "D:/xampp/htdocs/SyrniaSiteSVN/theGame/");
    define("GAMEURL", "http://" . $_SERVER['HTTP_HOST'] . "/SyrniaSiteSVN/theGame/");
    define("SERVERURL", "http://" . $_SERVER['HTTP_HOST'] . "/SyrniaSiteSVN/");
    define("CHATLOGPATH", "D:/xampp/htdocs/SyrniaSiteSVN/logs/chat/");
} else if ($_SERVER['HTTP_HOST'] == "84.104.180.174:8080"  )
{
	define("DEBUGMODE", "");

    define("GAMEFOLDER", "theGame/");
    define("GAMEPATH", "C:/xampp/htdocs/SyrniaLiveNew/theGame/");
    define("GAMEURL", "http://" . $_SERVER['HTTP_HOST'] . "/theGame/");
    define("SERVERURL", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("CHATLOGPATH", "C:/xampp/htdocs//SyrniaLiveNew/logs/chat/");

} else if($_SERVER['HTTP_HOST'] == "dev2.syrnia.com" OR $_SERVER['HTTP_HOST'] == "www.dev2.syrnia.com")
{
    define("DEBUGMODE", "true");
	//define("DEBUGMODE", "");

	define("GAMEFOLDER", "theGame/");
    define("GAMEPATH", "/wwwroot/wwwSVNS/SyrniaDevSVN/theGame/");
    define("GAMEURL", "http://" . $_SERVER['HTTP_HOST'] . "/theGame/");
    define("SERVERURL", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("CHATLOGPATH", "/wwwroot/wwwSVNS/SyrniaDevSVN/logs/chat/");
} else
{
    ///LIVE
    define("DEBUGMODE", "");

	define("GAMEFOLDER", "theGame/");
    define("GAMEPATH", "/wwwroot/wwwSVNS/SyrniaLiveSVN/theGame/");
    define("GAMEURL", "http://" . $_SERVER['HTTP_HOST'] . "/theGame/");
    define("SERVERURL", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("CHATLOGPATH", "/wwwroot/wwwSVNS/SyrniaLiveSVN/logs/chat/");
}


?>