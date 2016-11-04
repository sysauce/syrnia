<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


if($S_location == 'Arch. cave 5.9' || $S_location == 'Arch. cave 5.13')
{
}
else if($S_location == 'Arch. cave 5.5')
{
    $output .= "You see a fallen warrior, his platina armour almost completely melted. The remains flicker with seemingly inextinguishable green and black flames.<BR>";
}
else if($S_location == 'Arch. cave 5.8')
{
    $output .= "Blue and green flames shimmer over the body of another warrior. The only thing you can tell for sure is that they were wearing obsidian armour.<BR>";
}
else
{
    $output .= "In the dark, long forgotten Arch. caves 5 system, there creeps an evil force of creatures. " .
        "These creatures are drawn to this deep level of the caves by its hot temperatures and precious metals contained in the cave walls. " .
        "Even when you can't see them, their roars echo around the caves.<BR>";
}

if($S_location=='Arch. cave 5.1')
{
	$output.="Above you, you see a dark hole in the wall.<BR>";
	$output.="<br/><A href='' onclick=\"updateCenterContents('move', 'Lost caves 10');return false;\">Enter it</a>";
}

if($S_location=='Arch. cave 5.3' || $S_location=='Arch. cave 5.4')
{
    $sql = "SELECT type,monsters,itemtype,dump, monstersmuch FROM locations WHERE location='$S_location' && (type='resource' || type = 'oreblock') && monstersmuch>0 ORDER BY ID ASC";
    $resultaat = mysqli_query($mysqli, $sql);
    $oreblock = false;
    $oreblockMonsters = "";
    $oreblockMonstersRemaining = 0;
    while ($record = mysqli_fetch_object($resultaat))
	{
        if($record->type == 'oreblock')
        {
            $oreblock = true;
            $oreblockMonsters = $record->monsters;
            $oreblockMonstersRemaining = $record->monstersmuch;
        }
	    if($record->dump=='ore')
        {
	    	$output.="<BR>";
	    	$output.="The rock walls contain small shining layers of $record->monsters" . ($record->monsters == "Puranium" ? ", this looks like a very rare ore" : ".") . "<BR>";

            if($oreblock)
            {
                $output.="It looks like some ".$oreblockMonsters."s have been attracted to the ore, you'll have to kill them before the ore is safe to mine!<br />";
                $output.="<a href='' onclick=\"fighting('$oreblockMonsters');return false;\">Attack</A> ($oreblockMonstersRemaining left)";
            }
            else
            {
                $output.="<A href='' onclick=\"locationText('work', 'mining', '$record->monsters', 'rare');return false;\">$record->itemtype [$record->monstersmuch left]</a><BR>";
            }
	   }
   }
}

if($S_location == 'Arch. cave 5.9')
{
    $questID=23;
    if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false)/* &&
        (stristr($_SESSION['S_quests'], "$questID(0)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(1)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(2)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(3)]")<>''))*/
    {
        $output.="Protect the camp, then we'll talk...<br/><br/>";

        include('textincludes/quests.php');
    }
    else if($action == 'waleakalidiana')
    {
        $output.="Before you arrived we didn't think we were going to survive! Most of our warriors died soon after we arrived. " .
            "Even their best armour wouldn't hold up against some of the dragons. We learned too late that the flame of each dragon was weak against armour of the same colour.<br/><br/>";
        $output.="By then only Eillyassa was alive to protect us. Fortunately we still had several sets of platina, syriet and obsidian armour for her. " .
            "With each dragon she was constantly changing armour, she had a few close calls. We had to do something, so we started researching the scales and hides from the dragons she had killed.<br/><br/>";
        $output.="Discovering that their scales and hides offered protection the new armour was born, Eillyassa bravely fought her first dragon wearing it. " .
            "No longer having to change gear we were able to create this camp and survive until you came.<br/><br/>";
        $output.="For aiding us in our survival, we place ourselves at your service...for a price, of course.";

        $questID=25;
        if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false)/* &&
        (stristr($_SESSION['S_quests'], "$questID(0)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(1)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(2)]")<>'' OR
        stristr($_SESSION['S_quests'], "$questID(3)]")<>''))*/
        {
            $output.="You'll have to kill some dragons before we will make you armour...<br/><br/>";
            include('textincludes/quests.php');
        }
        else
        {
            $output.="Bring us materials and we can create special dragon armour for you...<br/><br/>";

            $koop[1][name] = "Dragon boots";
            $koop[1][type] = "shoes";
            $koop[1][cost1] = "Dragon hide";
            $koop[1][cost1much] = "2";
            $koop[1][cost2] = "Dragon scale";
            $koop[1][cost2much] = "2";
            $koop[1][cost3] = "Platina dragon hide";
            $koop[1][cost3much] = "2";
            $koop[1][cost4] = "Platina dragon scale";
            $koop[1][cost4much] = "2";
            $koop[1][cost5] = "Syriet dragon hide";
            $koop[1][cost5much] = "1";
            $koop[1][cost6] = "Syriet dragon scale";
            $koop[1][cost6much] = "1";
            $koop[1][cost7] = "Obsidian dragon hide";
            $koop[1][cost7much] = "1";
            $koop[1][cost8] = "Obsidian dragon scale";
            $koop[1][cost8much] = "1";
            $koop[1][costgold] = "5000";

            $koop[2][name] = "Dragon gauntlets";
            $koop[2][type] = "gloves";
            $koop[2][cost1] = "Dragon hide";
            $koop[2][cost1much] = "2";
            $koop[2][cost2] = "Dragon scale";
            $koop[2][cost2much] = "2";
            $koop[2][cost3] = "Platina dragon hide";
            $koop[2][cost3much] = "2";
            $koop[2][cost4] = "Platina dragon scale";
            $koop[2][cost4much] = "2";
            $koop[2][cost5] = "Syriet dragon hide";
            $koop[2][cost5much] = "1";
            $koop[2][cost6] = "Syriet dragon scale";
            $koop[2][cost6much] = "1";
            $koop[2][cost7] = "Obsidian dragon hide";
            $koop[2][cost7much] = "1";
            $koop[2][cost8] = "Obsidian dragon scale";
            $koop[2][cost8much] = "1";
            $koop[2][costgold] = "5000";

            $koop[3][name] = "Dragon helm";
            $koop[3][type] = "helm";
            $koop[3][cost1] = "Dragon hide";
            $koop[3][cost1much] = "3";
            $koop[3][cost2] = "Dragon scale";
            $koop[3][cost2much] = "3";
            $koop[3][cost3] = "Platina dragon hide";
            $koop[3][cost3much] = "3";
            $koop[3][cost4] = "Platina dragon scale";
            $koop[3][cost4much] = "3";
            $koop[3][cost5] = "Syriet dragon hide";
            $koop[3][cost5much] = "2";
            $koop[3][cost6] = "Syriet dragon scale";
            $koop[3][cost6much] = "2";
            $koop[3][cost7] = "Obsidian dragon hide";
            $koop[3][cost7much] = "1";
            $koop[3][cost8] = "Obsidian dragon scale";
            $koop[3][cost8much] = "1";
            $koop[3][costgold] = "7500";

            $koop[4][name] = "Dragon shield";
            $koop[4][type] = "shield";
            $koop[4][cost1] = "Dragon hide";
            $koop[4][cost1much] = "3";
            $koop[4][cost2] = "Dragon scale";
            $koop[4][cost2much] = "3";
            $koop[4][cost3] = "Platina dragon hide";
            $koop[4][cost3much] = "3";
            $koop[4][cost4] = "Platina dragon scale";
            $koop[4][cost4much] = "3";
            $koop[4][cost5] = "Syriet dragon hide";
            $koop[4][cost5much] = "2";
            $koop[4][cost6] = "Syriet dragon scale";
            $koop[4][cost6much] = "2";
            $koop[4][cost7] = "Obsidian dragon hide";
            $koop[4][cost7much] = "1";
            $koop[4][cost8] = "Obsidian dragon scale";
            $koop[4][cost8much] = "1";
            $koop[4][costgold] = "7500";

            $koop[5][name] = "Dragon legs";
            $koop[5][type] = "legs";
            $koop[5][cost1] = "Dragon hide";
            $koop[5][cost1much] = "4";
            $koop[5][cost2] = "Dragon scale";
            $koop[5][cost2much] = "4";
            $koop[5][cost3] = "Platina dragon hide";
            $koop[5][cost3much] = "4";
            $koop[5][cost4] = "Platina dragon scale";
            $koop[5][cost4much] = "4";
            $koop[5][cost5] = "Syriet dragon hide";
            $koop[5][cost5much] = "3";
            $koop[5][cost6] = "Syriet dragon scale";
            $koop[5][cost6much] = "3";
            $koop[5][cost7] = "Obsidian dragon hide";
            $koop[5][cost7much] = "1";
            $koop[5][cost8] = "Obsidian dragon scale";
            $koop[5][cost8much] = "1";
            $koop[5][costgold] = "10000";

            $koop[6][name] = "Dragon plate";
            $koop[6][type] = "body";
            $koop[6][cost1] = "Dragon hide";
            $koop[6][cost1much] = "4";
            $koop[6][cost2] = "Dragon scale";
            $koop[6][cost2much] = "4";
            $koop[6][cost3] = "Platina dragon hide";
            $koop[6][cost3much] = "4";
            $koop[6][cost4] = "Platina dragon scale";
            $koop[6][cost4much] = "4";
            $koop[6][cost5] = "Syriet dragon hide";
            $koop[6][cost5much] = "3";
            $koop[6][cost6] = "Syriet dragon scale";
            $koop[6][cost6much] = "3";
            $koop[6][cost7] = "Obsidian dragon hide";
            $koop[6][cost7much] = "1";
            $koop[6][cost8] = "Obsidian dragon scale";
            $koop[6][cost8much] = "1";
            $koop[6][costgold] = "15000";

            for($i = 1; $i <=6; $i++)
            {
                if($var1 == 'buy' && $i == $var2)
                {
                    $output.="<BR>";

                    $need1 = $koop[$i][cost1];
                    $need1much = $koop[$i][cost1much];
                    $need2 = $koop[$i][cost2];
                    $need2much = $koop[$i][cost2much];
                    $need3 = $koop[$i][cost3];
                    $need3much = $koop[$i][cost3much];
                    $need4 = $koop[$i][cost4];
                    $need4much = $koop[$i][cost4much];
                    $need5 = $koop[$i][cost5];
                    $need5much = $koop[$i][cost5much];
                    $need6 = $koop[$i][cost6];
                    $need6much = $koop[$i][cost6much];
                    $need7 = $koop[$i][cost7];
                    $need7much = $koop[$i][cost7much];
                    $need8 = $koop[$i][cost8];
                    $need8much = $koop[$i][cost8much];
                    $goldcost = $koop[$i][costgold];

                    $resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && gold>=$goldcost");
                    $aantal = mysqli_num_rows($resultaat);

                    $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need1' && much>='$need1much' && username='$S_user' LIMIT 1");
                    $aantal2 = mysqli_num_rows($resultaat);

                    $checkTotal = 0;
                    $checkActual = 0;
                    $aantal3 = 0;

                    if($need2)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need2' && much>='$need2much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need3)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need3' && much>='$need3much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need4)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need4' && much>='$need4much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need5)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need5' && much>='$need5much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need6)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need6' && much>='$need6much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need7)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need7' && much>='$need7much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($need8)
                    {
                        $checkTotal++;
                        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE name='$need8' && much>='$need8much' && username='$S_user' LIMIT 1");
                        $aantal3 = mysqli_num_rows($resultaat);
                        if($aantal3 >= 1)
                        {
                            $checkActual++;
                        }
                    }

                    if($aantal == 1 && $aantal2 == 1 && $checkActual >= $checkTotal && $goldcost > 0)
                    {
                        payGold($S_user, $goldcost);
                        removeItem($S_user, $need1, $need1much, '', '', 1);
                        if($need2)
                        {
                            removeItem($S_user, $need2, $need2much, '', '', 1);
                        }
                        if($need3)
                        {
                            removeItem($S_user, $need3, $need3much, '', '', 1);
                        }
                        if($need4)
                        {
                            removeItem($S_user, $need4, $need4much, '', '', 1);
                        }
                        if($need5)
                        {
                            removeItem($S_user, $need5, $need5much, '', '', 1);
                        }
                        if($need6)
                        {
                            removeItem($S_user, $need6, $need6much, '', '', 1);
                        }
                        if($need7)
                        {
                            removeItem($S_user, $need7, $need7much, '', '', 1);
                        }
                        if($need8)
                        {
                            removeItem($S_user, $need8, $need8much, '', '', 1);
                        }

                        $type = $koop[$i][type];
                        $name = $koop[$i][name];
                        addItem($S_user, $name, 1, $type, '', '', 1);

                        $output.="<B>You exchanged some resources for a " . $koop[$i][name] . "! Remember, because of its special powers, you won't be able to increase the durability with spider silk.</B><BR>";
                    }
                    else
                    {
                        $output.="<B>You do not have enough resources to exchange for a " . $koop[$i][name] . ".</B><BR>";
                    }

                    $output.="<BR>";
                }

                $output.="Exchange " . $koop[$i][costgold] . " gold, " . $koop[$i][cost1much] . "  " . $koop[$i][cost1];
                if($koop[$i][cost2much])
                {
                    $output.=", " . $koop[$i][cost2much] . "  " . $koop[$i][cost2];
                }
                if($koop[$i][cost3much])
                {
                    $output.=", " . $koop[$i][cost3much] . "  " . $koop[$i][cost3];
                }
                if($koop[$i][cost4much])
                {
                    $output.=", " . $koop[$i][cost4much] . "  " . $koop[$i][cost4];
                }
                if($koop[$i][cost5much])
                {
                    $output.=", " . $koop[$i][cost5much] . "  " . $koop[$i][cost5];
                }
                if($koop[$i][cost6much])
                {
                    $output.=", " . $koop[$i][cost6much] . "  " . $koop[$i][cost6];
                }
                if($koop[$i][cost7much])
                {
                    $output.=", " . $koop[$i][cost7much] . "  " . $koop[$i][cost7];
                }
                if($koop[$i][cost8much])
                {
                    $output.=", " . $koop[$i][cost8much] . "  " . $koop[$i][cost8];
                }

                $output.=" for a <a href='' onclick=\"locationText('waleakalidiana', 'buy', '$i');return false;\">" . $koop[$i][name] . "</a><BR><br/>";
            }
        }

        $output.="<BR>";
    }
    else
    {
        $output.="At the central location of the cave system you find a lean and burly man, with large calloused hands. Clearly a smith. " .
            "Alongside him a woman in robes, an ancient looking staff at her side. It must have been passed down to her from mages of a much older time. " .
            "<a href='' onclick=\"locationText('waleakalidiana');return false;\">Talk to Waleak and Alidiana</a><BR>";
    }
}

if($S_location=='Arch. cave 5.13')
{
    $output.="At the most secluded area in the cave system, there bubbles a small pool of molten lava. " .
        "The lowest temperature here is equal to the highest at Arch. caves 4.7. This will allow you to smelt platina and syriet all the time.<BR><br/>";
    $output.="<A href='' onclick=\"locationText('work', 'smelting','Platina bars');return false;\">Smelt platina bars</a><BR>";
    $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Syriet bars');return false;\">Smelt syriet bars</a><BR>";
    $output.="<br/>";

    if(date("w")==3 OR date("w")==6)
    {
        $output.="<br/>The current conditions at this location are perfect to smelt obsidian and even puranium!<br/>";
        $output.="In this environment it costs you 1 puranium ore, 5 obsidian ore and 10 silver to create one puranium bar.<br/>";
        //$output.="The costs could differ if the environment changes, but it has been stable so far...<br/>";
        $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Obsidian bars');return false;\">Smelt obsidian bars</a><BR>";
        $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Puranium bars');return false;\">Smelt puranium bars</a><BR>";
    }
    else
    {
        $output.="<br/>The current conditions at this location are not good enough to smelt obsidian or puranium.<br/>";
    }
}






}
}
?>