<?php
if(defined('AZtopGame35Heyam')){

	ob_start();
?>
<table cellpadding=0 cellspacing=0>
<tr valign=top><td width=200 align=left>

 <h3><b>Screenshots</b></h3>
 <a href=http://m2h.nl/content/scr/Syrnia_4.jpg target=_blank><img width=180 src="http://m2h.nl/content/scr/Syrnia_4.jpg" border=0 /></a><br />
 <br />
<a href=http://m2h.nl/content/scr/Syrnia_1.jpg target=_blank><img width=180 src="http://m2h.nl/content/scr/Syrnia_1.jpg" border=0 /></a><br />
<br />
 <h3>Features</h3>
 <ul>

<li>A lot <b>skills</b> to train, the skills are listed at the right.</li>
<li><b>PvP</b>: Kill other players and gain their posessions...</li>
<li><b>Monsters</b> to kill</li>
<li><b>Quests</b> to complete: Each quest is unique and will gain you experience and rewards.</li>
<li>Choose your <b>own way of playing</b>; If you want to you can concentrate on just one skill. To become the best trader you do not need to fight at all.</li>
<li><b>Free to play</b></li>
<li><b>Not</b> turn or tick based</li>
<li>15 Skills</li>
<li>500+ Items</li>
<li>100+ Locations</li>
<li>Discover treasures at dangerous places</li>
<li>Online multiplayer:<BR>Interact with friends/foes</li>
<li>Collect rare weapons/armour/items</li>
<li>A <b>good community</b>. Syrnia supports a chat & forum.</li>
<li>You can <b>become famous</b> in the world of Syrnia</li>
<li>The game offers a lot more you will like for sure! Experience it, and join this free game :).</li>
 </ul>


</td><td width=3></td><td width=1 bgcolor=#000000><img src='/layout/newdesign/pixel.png' border='0' width='1' height='1'></td><td width=5></td><td valign=top>

<h2>What's this RPG about?</h2>
Syrnia is the new online adventure land where the world changes according to the players behaviour. Are you able to discover the land of Syrnia, are you brave enough to beat other players on skills as mining, fishing, fighting, thieving and many more?<BR>
<br />
You will soon find out when playing Syrnia. You will never get bored because of the many upcoming updates and the many things to do in game.<br>
When travelling across the Syrnia lands, you will meet a lot of new friends, which can help you, and if you really feel like a team you can build up a clan with it's own clan headquarters to fight other clans.<BR>
<BR>
There will be a lot of different things to do, bad or good, it's all in Syrnia. Will you be the one who plunders the houses and robs the shops in Syrnia? Or will you be the hard worker, who fishes, mines or smiths very often? It's your decision! But you don't have to choose, you can practice all of the skills with the same character!<br>
<BR>



  <center><?php echo MakeButton("Join now", "?page=register", 250, ""); ?></center>



  <table width=100%>
<tr valign=top>
 <td>
<br />
<B>Syrnias skills:</B><BR>
<br />
<table>
<tr><td><img src=images/skills/attack.gif><td>-<B>Combat </B>(Attack, Defence, Strength, Health)  <i>Kill monsters or other players (pvp).</i>
<tr><td><img src=images/skills/farming.gif><td>-<B>Farming </B><i>Plant seeds, wait... and then harvest your crops.</i>
<tr><td><img src=images/skills/magic.gif><td>-<B>Magic </B><i>Enchant armour or Orbs, then use the magic to gain mystical powers.</i>
<tr><td><img src=images/skills/smithing.gif><td>-<B>Smithing </B><i>Use your hammer and ores to smith your own armour and weapons.</i>
<tr><td><img src=images/skills/mining.gif><td>-<B>Mining</B> <i>Train mining a lot until you are able to mine the very rare and valuable ores.</i>
<tr><td><img src=images/skills/cooking.gif><td>-<B>Cooking </B><i>Support the mighty warriors, sell them your cooked food in exchange for some of their loot.</i>
<tr><td><img src=images/skills/fishing.gif><td>-<B>Fishing </B><i>Keep patience and fish a lot, maybe you will find an old treasure chest in your net one day...</i>
<tr><td><img src=images/skills/constructing.gif><td>-<B>Construction</B> <i>Learn construction at school, then  build houses and shops for other people, they will pay you well!</i>
<tr><td><img src=images/skills/trading.gif><td>-<B>Trading </B><i>Own your own shops at various locations, track your sales and try to bring your products on the Syrnia market.</i>
<tr><td><img src=images/skills/speed.gif><td>-<B>Speed </B><i>Walk a lot and you will gain more speed every day, while walking you can also start to collect beautiful flowers.</i>
<tr><td><img src=images/skills/woodcutting.gif><td>-<B>Woodcutting </B><i>A lot of wood is needed in Syrnia, can you supply enough wood for the constructors?</i>
<tr><td><img src=images/skills/thieving.gif><td>-<B>Thieving</B> <i>If you do not like the above skills, thieving might be your way to live in Syrnia...You will not be liked though.</i>
</table>
<BR>If you do not like any of the above skills you can always choose to become pirate and invade the islands of the normal players.<BR>
<BR>

  <center><?php echo MakeButton("Join now", "?page=register", 250, ""); ?></center>
  <br />
Type game: <B>Free browserbased text based multiplayer rpg game.</B><BR>
<BR>
<h3>Thanks</h3>
Thanks go to the following persons, which have helped making Syrnia as it is now.<br/>
<Table>
<tr><Td><B>Muaat<td> 3D artist for inventory images, work images etc.<BR>
<tr><Td><td><B>Also big thanks to all the moderators!</B>
</table>
<BR>

</table>


</table>

<?php

$output = ob_get_contents();
ob_end_clean();

$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270);

}
?>