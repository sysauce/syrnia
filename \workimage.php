<?php
header("Content-type: image/png");
$S_user = '';
session_start();
if ($S_user)
{
    //GAMEURL, SERVERURL etc.
    require_once ("currentRunningVersion.php");
    require_once (GAMEPATH . "includes/db.inc.php");


    $sql = "SELECT botcheck FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $botcheck = $record->botcheck;
    }

    if (is_numeric($botcheck) && $S_user)
    {

        $plaatje = imagecreatefromjpeg("images/dot1.jpg");
        #$plaatje = ImageCreate(150, 80);


        $top = imagecreatefromjpeg("images/dot2.jpg");

        $top3 = imagecreatefromjpeg("images/top2.jpg");

        $wit = ImageColorAllocate($plaatje, 255, 255, 255);


        $deel1 = substr("$botcheck", 0, 1);
        $deel2 = substr("$botcheck", 1, 1);
        $deel3 = substr("$botcheck", 2, 1);
        $deel4 = substr("$botcheck", 3, 1);


        ## FaKE NUMMERS
        $font = 'georgia';
        $size2 = rand(12, 14);
        $kleurnb = rand(5, 10);
        $zwart = ImageColorAllocate($plaatje, $kleurnb, $kleurnb, $kleurnb);

        ImageTTFText($plaatje, $size2, $draai1, $midden + ($size * 3 - 15), rand($size,
            80), $zwart, "layout/fonts/$font.ttf", "Thanks for your Time");
        ImageTTFText($plaatje, $size2, $draai2, $midden + ($size * 2 - 15), rand($size,
            80), $zwart, "layout/fonts/$font.ttf", "Guesses");
        ImageTTFText($plaatje, $size2, $draai3, $midden + ($size * 1 - 15), rand($size,
            80), $zwart, "layout/fonts/$font.ttf", "123 What to do 7890");
        ImageTTFText($plaatje, $size2, $draai4, $midden + ($size * 0 - 15), rand($size,
            80), $zwart, "layout/fonts/$font.ttf", "H3LL0 And all ");


        $size = rand(26, 28);
        if (rand(1, 4) == 1)
        {
            $font = 'verdana';
        } elseif (rand(1, 3) == 1)
        {
            $font = 'arialbd';
        } elseif (rand(1, 3) == 1)
        {
            $font = 'comic';
        } else
        {
            $font = 'georgia';
            $size = rand(29, 30);
        }

        $draai1 = rand(-40, 40);
        $draai2 = rand(-40, 40);
        $draai3 = rand(-40, 40);
        $draai4 = rand(-40, 40);
        $midden = rand(5, 150 - ($size * 4));

        ### ECHTE NUMMERS
        $kleurnb = rand(0, 10);
        $zwart = ImageColorAllocate($plaatje, $kleurnb, $kleurnb, $kleurnb);
        ImageTTFText($plaatje, $size, $draai1, $midden, rand($size, 50), $zwart,
            "layout/fonts/$font.ttf", "$deel1");
        $kleurnb = rand(0, 10);
        $zwart = ImageColorAllocate($plaatje, $kleurnb, $kleurnb, $kleurnb);
        ImageTTFText($plaatje, $size, $draai2, $midden + $size, rand($size, 50), $zwart,
            "layout/fonts/$font.ttf", "$deel2");
        $kleurnb = rand(0, 10);
        $zwart = ImageColorAllocate($plaatje, $kleurnb, $kleurnb, $kleurnb);
        ImageTTFText($plaatje, $size, $draai3, $midden + ($size * 2), rand($size, 50), $zwart,
            "layout/fonts/$font.ttf", "$deel3");
        $kleurnb = rand(0, 10);
        $zwart = ImageColorAllocate($plaatje, $kleurnb, $kleurnb, $kleurnb);
        ImageTTFText($plaatje, $size, $draai4, $midden + ($size * 3), rand($size, 50), $zwart,
            "layout/fonts/$font.ttf", "$deel4");
        #$rand=rand(99,99);
        #   imageCopyMerge($plaatje, $top, 0, 0, 0, 0, 150, 80,10);
        imageCopyMerge($plaatje, $top3, 0, 0, 0, 0, 150, 80, 50);


        Imagegif($plaatje);
        ImageDestroy($plaatje);
        ImageDestroy($top);
        ImageDestroy($top3);
    }
}
?>