<?

if(defined('AZtopGame35Heyam'))
{

if($locationshow == 'LocationMenu')
{
    $output.="<center><B>City Menu</B><BR>";
    $output.="<BR>";
    $output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
    $output.="<BR>";
}
else if($locationshow == 'LocationText')
{
    if($S_location == 'Lost caves 1')
    {
        $output.= "As you enter the lost caves the heat from Arch caves 4 stays with you, but these caves are very dark and appear to be extremely steep...are you brave enough to continue deeper?<br/><br/>";
    }
    else if($S_location == 'Lost caves 2' || $S_location == 'Lost caves 3' || $S_location == 'Lost caves 4')
    {
        $output.= "As you descend deeper into the ancient cave system, the heat from Arch. caves 4 has faded and a cold breeze chills you to the bone." .
        " The tunnel here has got steeper, and you get the feeling these caves could collapse around you at any time.<br/><br/>";
    }
    else if($S_location == 'Lost caves 5' || $S_location == 'Lost caves 6' || $S_location == 'Lost caves 7')
    {
        $output.= "At this point of your descent the tunnel is so steep you can barely stand, you struggle to control your speed and your balance is threatened with every step." .
        " The dark and dank surroundings fill you with fear. The threat of a collapse is even more menacing.<br/><br/>";
    }
    else if($S_location == 'Lost caves 8' || $S_location == 'Lost caves 9')
    {
        $output.= "You notice the cold has almost gone, so why are you still shaking? Perhaps you have noticed that even the gamans this deep in the earth seem afraid..." .
        "you wonder what could possibly strike fear into such savage creatures.<br/><br/>";
    }
    else if($S_location == 'Lost caves 10')
    {
        $output.= "The tunnel here has flattened and narrowed. As you approach the deepest point, you hear terrifying roars. You begin to get an understanding " .
        " of the fear these gamans have been displaying. The heat here has become almost unbearable.<br/><br/>";
    }

    /*$output.= "1: As you enter the lost caves the heat from Arch caves 4 stays with you, but these caves are very dark and appear to be extremely steep...are you brave enough to continue deeper?<br/><br/>";

    $output.= "2-4: As you descend deeper into the ancient cave system, the heat from Arch. caves 4 has faded and a cold breeze chills you to the bone." .
        " The tunnel here has got steeper, and you get the feeling these caves could collapse around you at any time.<br/><br/>";

    $output.= "5-6: At this point of your descent the tunnel is so steep you can barely stand, you struggle to control your speed and your balance is threatened with every step." .
        " The dark and dank surroundings fill you with fear. The threat of a collapse is even more menacing.<br/><br/>";

    $output.= "8-9: You notice the cold has almost gone, so why are you still shaking? Perhaps you have noticed that even the gamans this deep in the earth seem afraid..." .
        "you wonder what could possibly strike fear into such savage creatures.<br/><br/>";

    $output.= "10: The tunnel here has flattened and narrowed. As you approach the deepest point, you hear terrifying roars. You begin to get an understanding " .
        " of the fear these gamans have been displaying. The heat here has become almost unbearable.<br/><br/>";*/

    $canLeave = false;
    if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false)//$S_location == 'Lost caves 1' || $S_location == 'Lost caves 10')
    {
        $resultaat = mysqli_query($mysqli, "SELECT username FROM users_junk WHERE partyIslandSailLocation='Heerchey manor' AND username='$S_user' LIMIT 1");
        $canLeave = mysqli_num_rows($resultaat) == 0;
    }

    if($canLeave && $S_location == 'Lost caves 1')
    {
        $output.="Above you, you feel the familiar heat of Arch. cave 4...<BR>";

        $output.="<a href='' onclick=\"updateCenterContents('move', 'Arch. cave 4.5');return false;\">Move up to the heat</a><br/><br/>";
    }

    if(!$canLeave)
    {
        $output.="<a href='' onclick=\"updateCenterContents('move', 'Heerchey manor');return false;\">Take me back to Heerchey manor</a><br/><br/>";
    }

    if(!groupQuestActive($S_location, false))
    {
        if($S_location == 'Lost caves 10')
        {
            $stage = groupQuestStageComplete(1);
            if(true || $stage >= 60)
            {
                $questID=24;
                if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false)/* &&
                    (stristr($_SESSION['S_quests'], "$questID(0)]")<>'' OR
                    stristr($_SESSION['S_quests'], "$questID(1)]")<>'' OR
                    stristr($_SESSION['S_quests'], "$questID(2)]")<>'' OR
                    stristr($_SESSION['S_quests'], "$questID(3)]")<>''))*/
                {
                    $couldLeave = $canLeave;
                    $canLeave = false;

                    if(stristr($_SESSION['S_quests'], "$questID(1)]")<>'')
                    {
                        include('textincludes/quests.php');
                    }
                    else if($var2 == "yes")
                    {
                        $actionCount = groupQuestParticipation(1, 60);
                        $questActions = floor($actionCount * 1.2);
                        //$output .= "You did $actionCount actions!<br/><br/>";
                        //include('textincludes/quests.php');

                        if($actionCount >= 5000)
                        {
                            $output .= "Amazing! You did $actionCount actions! The Heerchey family feel you have assisted enough in the rescue to gain access to Arch. caves 5!";
                        }
                        else if($actionCount >= 2500)
                        {
                            $output .= "Well one, you did $actionCount actions! The Heerchey family don't think you have helped quite enough in the rescue to gain access to Arch. caves 5. " .
                            "They have noted your participation and have decided to credit you in your quest to gain permission.";
                        }
                        else if($actionCount > 500)
                        {
                            $output .= "You did $actionCount actions! The Heerchey family don't think you have helped quite enough in the rescue to gain access to Arch. caves 5. " .
                            "They have noted your participation and have decided to credit you in your quest to gain permission, however you have a lot of helping still to do!";
                        }
                        else if($actionCount > 0)
                        {
                            $questActions = 0;
                            $output .= "You only did $actionCount actions, shame on you! The Heerchey family don't think you have helped in the rescue at all! To gain access to Arch. caves 5 " .
                            "you must complete some work for the Heerchey family. You have a lot of work to do in order to gain entry to Arch caves 5!";
                        }
                        else
                        {
                            $questActions = -2000;
                            $output .= "To gain access to Arch. caves 5 " .
                            "you must complete some work for the Heerchey family. You have a lot of work to do in order to gain entry to Arch caves 5!";
                        }

                        $output .= "<br/><br/>";

                        $var2 = "yes";
                        include('textincludes/quests.php');

                        if($questActions >= 6000)
                        {
                            $questActions = 5999;
                        }

                        mysqli_query($mysqli,"UPDATE quests SET gatherleft=gatherleft-$questActions WHERE questID='$questID' && username='$S_user' LIMIT 1") or die("err2or --> LC10");

                        if($actionCount >= 5000)
                        {
                            $outputA = $output;
                            $gather='accessAC5';
                            include ('textincludes/quests.php');
                            $output = $outputA;
                            $outputA = null;

                            $canLeave = $couldLeave;
                        }
                        else
                        {
                            $output .= "The Heerchey family need some rocks cleared from this area to widen the tunnel. " .
                                "<a href='' onclick=\"locationText('work', 'other', 'accessAC5_1');return false;\">Mine</a> enough rocks or " .
                                "<a href='' onclick=\"locationText('work', 'other', 'accessAC5_2');return false;\">construct</a> enough supports " .
                                "and they will allow you to access Arch. caves 5.";
                        }
                    }
                    else
                    {
                        $output .= "The Heerchey family only allow access to Arch. caves 5 based on the assistance provided. " .
                            "<a href='' onclick=\"locationText('', '', 'yes');return false;\">Request access to Arch. caves 5</a>";
                    }
                }
            }

            if($canLeave && $S_location == 'Lost caves 10')
            {
                $output.="You see a small opening, just big enough to fit through...<BR>";
                $output.="<a href='' onclick=\"updateCenterContents('move', 'Arch. cave 5.1');return false;\">Move deeper in to the cave</a><br/><br/>";
            }
        }
    }
    else
    {
        include('textincludes/groupQuests.php');
    }
}

}
?>