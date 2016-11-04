<?php
 	session_start();
 	if(!$S_user){
		exit();
	}
	require_once("../../currentRunningVersion.php");
?>
/*    (c) Syrnia.com
 *--------------------------------------------------------------------------*/

var JSScriptsVersion=1;

<?php //messagePopup ?>
function messagePopup(message, title){
	if($('messagePopup').style.visibility!='visible')
    {
		 $('messagePopup').style.visibility='visible';
         $('popupTitle').innerHTML = "";
         $('popupMessage').innerHTML = "";
	}
    if(title == "Level up!" && $('popupTitle').innerHTML == "&nbsp;<b>Level up!</b>&nbsp;")
    {
        $('popupMessage').innerHTML = $('popupMessage').innerHTML + "<br/><br/>" + message;
    }
    else
    {
        $('popupMessage').innerHTML = message;
    }
    $('popupTitle').innerHTML = "&nbsp;<b>"+title+"</b>&nbsp;";
}

<?php //levelUp ?>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('o p(0,2){$(\'8\').3=9($(\'8\').3)+1;$(0+\'c\').3=9($(0+\'c\').3)+1;l(\'<i j="m k" r="u/t.A"/> <b>6!</b><e />4\\\'5 d \'+(g(0)?\'h\':\'a\')+\' <7 C=z>\'+0+\' 2</7> (\'+2+\')<e/>\'+"<a w=\\"#\\" D=\\"$(\'f\').x = \'6! 4\\\\\'5 d "+(g(0)?\'h\':\'a\')+" "+0+" 2 ("+2+")\';$(\'f\').B();y s;\\">n</a>",\'q v!\')}',40,40,'skill||level|innerHTML|You|ve|Congratulations|font|statsTotalSkillText|parseInt|||LevelText|gained|br|chatMessage|aOrAn|an|img|alt|skills|messagePopup|Total|Share|function|levelUp|Level|src|false|totalskill|images|up|href|value|return|green|gif|focus|color|onclick'.split('|')))

<?php //initDivMouseOver ?>
eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c.toString(a)+'\\b','g'),k[c])}}return p}('1 7(4){6 0=8.c(4);0.2=3;0.b=1(){5.2=9};0.a=1(){5.2=3}}',13,13,'div|function|isMouseOver|false|divid|this|var|iDMO|document|true|onmouseout|onmouseover|getElementById'.split('|')))

<?php //initWindowBlur ?>
eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c.toString(a)+'\\b','g'),k[c])}}return p}('1 7(){6.5=1(){3.0(\'9\').2=4;b{3.0(\'c\').2=4}8(a){}}}',13,13,'getElementById|function|isMouseOver|document|false|onblur|window|iWB|catch|playerInventory|err|try|centerContent'.split('|')))

<?php //clickInInventory (actually clickInContainer) ?>
eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c.toString(a)+'\\b','g'),k[c])}}return p}('e d(7,1){5(1==f){1=g.i}c 0=j.a(7);l=0.9;r=6(0.8.h)-l;t=0.o;b=6(0.8.k)-t;2=1.s;3=1.p;5(2>=l&&2<=r&&3>=t&&3<=b){4 n}m{4 q}}',30,30,'div|ev|_0|_1|return|if|parseInt|divid|style|offsetLeft|getElementById||var|cII|function|null|window|width|event|document|height||else|true|offsetTop|clientY|false||clientX|'.split('|')))

function addPlayer(name, tag, attack, hp, level){
 			var level='';
 	if(attack==1){ //PVP Enemy
		$('centerPlayerList').innerHTML+= tag+" "+level+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a>";
		$('centerPlayerList').innerHTML+= " <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=red>Attack</font></b></a> ("+hp+" hp)";
		$('centerPlayerList').innerHTML+= "<br />";
	}else if(attack==2){ //PVP yourself
	 	$('statsHPText').innerHTML=hp;
		$('centerPlayerList').innerHTML+= tag+" "+level+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a>";
		$('centerPlayerList').innerHTML+= " ("+hp+" hp)";
		$('centerPlayerList').innerHTML+= "<br />";
	}else if(attack==3){ //PVP friendly
		$('centerPlayerList').innerHTML+= tag+" "+level+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a>";
		$('centerPlayerList').innerHTML+= " <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=green>Attack</font></b></a> ("+hp+" hp)";
		$('centerPlayerList').innerHTML+= "<br />";
	}else if(attack==4){ //PVP friendly
		$('centerPlayerList').innerHTML+= tag+" "+level+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a>";
		$('centerPlayerList').innerHTML+= " <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=yellow>Attack</font></b></a> ("+hp+" hp)";
		$('centerPlayerList').innerHTML+= "<br />";
	}else{//non-PVP
		$('centerPlayerList').innerHTML+= tag+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a><br />";
	}

}

function addPlayer2(name, tag, attack, hp, level){
 	if(attack==1){ //PVP Enemy
		return "<small>"+tag+"</small> <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a>  <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=red>Attack</font></b></a> <small>"+level+" ("+hp+" hp)</small><br />";
	}else if(attack==2){ //PVP yourself
	 	$('statsHPText').innerHTML=hp;
		return tag+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a> "+level+"  ("+hp+" hp)<br />";
	}else if(attack==3){ //PVP friendly
		return tag+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a> <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=green>Attack</font></b></a> "+level+" ("+hp+" hp)<br />";
	}else if(attack==4){ //PVP friendly
		return tag+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a> <a href='' onClick=\"updateCenterContentsExtended('pvp', 'attack', '"+name+"');return false;\"><b><font color=yellow>Attack</font></b></a> "+level+" ("+hp+" hp)<br />";
	}else{//non-PVP
		return tag+" <a href='' onClick=\"updateCenterContents('showPlayer', '"+name+"');return false;\"><b><font color=white>"+name+"</font></b></a><br />";
	}
}

function clearPlayerList(){
	$('centerPlayerList').innerHTML="";
}

function postBotNumber(){
 	var numberHolder=$('botInputField');
 	if(numberHolder==null){
		return;
	}
	updateCenterContents('botCheck', numberHolder.value);
}

function locationText(action, var1, var2, var3, var4, var5){
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {calledBy: 'LT', action: action, var1: var1, var2: var2, var3:var3, var4:var4, var5:var5},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 	if(Ajax.activeRequestCount<=10){
			  	//messagePopup('There was a connection problem(timeout:'+t.status+'), the game was unable to connect to the game. However, the game is trying to reconnect in 30 seconds. [Warning code: cCS lT]', 'Connection problem');
				//setTimeout("locationText('"+action+"', '"+var1+"', '"+var2+"', '"+var3+"', '"+var4+"', '"+var5+"');", 30000);
			}else{
				//messagePopup('There was a connection problem(too many connections:'+t.status+'), the game was unable to connect to the game. The game has given up trying to reconnect. Please try again later. [Warning code: cCS lT]', 'Connection problem');
			}
		}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS lT]', 'Connection problem');
	}
}

function thieving(action, thieve1, thieve2){
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'thieving', action: action, thieve1: thieve1, thieve2: thieve2},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 	if(Ajax.activeRequestCount<=10){
			  	//messagePopup('There was a connection problem(timeout:'+t.status+'), the game was unable to connect to the game. However, the game is trying to reconnect in 30 seconds. [Warning code: cCS thieving]', 'Connection problem');
				//setTimeout("thieving('"+action+"', '"+thieve1+"', '"+thieve2+"');", 30000);
			}else{
			 	//messagePopup('There was a connection problem(too many connections:'+t.status+'), the game was unable to connect to the game. The game has given up trying to reconnect. Please try again later. [Warning code: cCS thieving]', 'Connection problem');
			 }
		}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS thieving]', 'Connection problem');
	}
}

function fighting(fightWhat, fightAll, group, invasionFight){
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'fighting', fightWhat: fightWhat,  fightAll: fightAll, group: group, invasionFight:invasionFight},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
			if(Ajax.activeRequestCount<=10){
			  	//messagePopup('There was a connection problem(timeout:'+t.status+'), the game was unable to connect to the game. However, the game is trying to reconnect in 30 seconds. [Warning code: cCS fighting]', 'Connection problem');
				//setTimeout("fighting('"+fightWhat+"', '"+fightAll+"', '"+group+"', '"+invasionFight+"');", 30000);
			}else{
				//messagePopup('There was a connection problem(too many connections:'+t.status+'), the game was unable to connect to the game. The game has given up trying to reconnect. Please try again later. [Warning code: cCS fighting]', 'Connection problem');
			}
		}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS fighting]', 'Connection problem');
	}
}

function fightingCounter(display, endDate, fightWhat, fightAll, group, invasionFight, counterTitle){
	if($(display)==null || ($(display).title!=0 && $(display).title!=counterTitle)){
		return;
	}
	if($(display).title!=counterTitle){
		$(display).title=counterTitle;
	}
 	var now = new Date();
	var secondsLeft=Math.ceil((endDate-now.getTime())/1000);
	$(display).value=secondsLeft;

	if(secondsLeft==0){
  		fighting(fightWhat, fightAll, group, invasionFight);
	 	//setTimeout("fightingCounter('"+display+"','"+endDate+"',  '"+fightWhat+"', '"+fightAll+"', '"+group+"', '"+invasionFight+"', '"+counterTitle+"')",2000);
	}else if(secondsLeft>=1){
	 	setTimeout("fightingCounter('"+display+"','"+endDate+"',  '"+fightWhat+"', '"+fightAll+"', '"+group+"', '"+invasionFight+"', '"+counterTitle+"')",500);
 	}else{
 		//Lower than 1
		 fighting(fightWhat, fightAll, group, invasionFight);
 	}

}

function locationTextCounter(display, endDate, counterTitle, action, var1, var2, var3, var4, var5){

	if($(display)==null || ($(display).title!=0 && $(display).title!=counterTitle)){
		return;
	}
	if($(display).title==0){
		$(display).title=counterTitle;
	}
 	var now = new Date();
	var secondsLeft=Math.ceil((endDate-now.getTime())/1000);
	$(display).value=secondsLeft;

	if(secondsLeft==0){
	 	locationText(action, var1, var2, var3, var4, var5);
	}else if(secondsLeft>=1){
	 	setTimeout("locationTextCounter('"+display+"', '"+endDate+"', '"+counterTitle+"', '"+action+"', '"+var1+"', '"+var2+"', '"+var3+"', '"+var4+"', '"+var5+"')",500);
 	}else{
 		locationText(action, var1, var2, var3, var4, var5);
 	}
}

function countDown(display, endDate, var1, var2){
  	if($(display)==null){
		return;
	}

 	var now = new Date();
	var secondsLeft=Math.ceil((endDate-now.getTime())/1000);
 	$(display).value=secondsLeft;


	if(secondsLeft==0){
	 	updateCenterContents(var1, var2);
	}else if(display=='jailCounter' && secondsLeft%60==0){
		setTimeout("updateCenterContents('"+var1+"','"+var2+"');",1100);
	}else if(secondsLeft>=1){
		setTimeout("countDown('"+display+"','"+endDate+"', '"+var1+"', '"+var2+"')",500);
	}else{
		updateCenterContents(var1, var2);
	}
}

function updateCenterContents(var1, var2){
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: var1, var2: var2},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
			if(Ajax.activeRequestCount<=10){
			 	//messagePopup('There was a connection problem(timeout:'+t.status+'), the game was unable to connect to the game. However, the game is trying to reconnect in 30 seconds. [Warning code: cCS uCC]', 'Connection problem');
			//	setTimeout("updateCenterContents("+var1+", "+var2+");", 30000);
			}else{
				//messagePopup('There was a connection problem(too many connections:'+t.status+'), the game was unable to connect to the game. The game has given up trying to reconnect. Please try again later. [Warning code: cCS uCC]', 'Connection problem');
			}
		}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS uCC]', 'Connection problem');
	}
}

function updateCenterContentsExtended(var1, var2, var3, var4){
 	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: var1, var2: var2, var3: var3, var4: var4},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
			if(Ajax.activeRequestCount<=10){
			 	//messagePopup('There was a connection problem(timeout:'+t.status+'), the game was unable to connect to the game. However, the game is trying to reconnect in 30 seconds. [Warning code: cCS uCCE]', 'Connection problem');
			 	//setTimeout("updateCenterContentsExtended('"+var1+"', '"+var2+"', '"+var3+"', '"+var4+"');", 30000);
			}else{
				//messagePopup('There was a connection problem(too many connections:'+t.status+'), the game was unable to connect to the game. The game has given up trying to reconnect. Please try again later. [Warning code: cCS uCCE]', 'Connection problem');
			}
		}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS uCCE]', 'Connection problem');
	}
}

function periodUpdater(){
	DoPeriodUpdate();
	setTimeout("periodUpdater();",600000);//time also at index
}


function DoPeriodUpdate(){
	if(Ajax.activeRequestCount<=10){
	 	var chatPost = new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
			method: "post",
			contentType: "application/x-www-form-urlencoded",
			encoding: "UTF-8",
			parameters: {var1: 'periodUpdate'},
			onSuccess: function( t) {
				eval(t.responseText);
			},
			on0: function( t) {
			    //messagePopup('You\'ve got connection problems [Error code: '+t.status+') ]', 'Connection problem');
			}
		});
	}else{
		messagePopup('Because of a connection problem you have too many open connections to the game, please wait a while before interacting with the game again. Your last action has been cancelled. [Warning code: request count cCS pU]', 'Connection problem');
	}
}

function pvpLog(title){

	if($('combatLog')==null || ($('combatLog').title!='' && $('combatLog').title!=title)){
	 	return;
	}
	$('combatLog').title=title;

	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'pvp', var2: 'log'},
		onSuccess: function(t) {
			eval(t.responseText);
		}
		});
	}
	setTimeout("pvpLog('"+title+"');", 2000);

}

function pvpPlayers()
{
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'pvp', var2: 'players'},
		onSuccess: function(t) {
			eval(t.responseText);
		}
		});
	}
}

function tradingRefresher(justOnce){

	if($('tradingStage')==null){
	 	updatingTrade=0;
	 	return;
	}
	if(Ajax.activeRequestCount<=10){
		new Ajax.Request("<?php echo GAMEURL."ajax/tradingScreen.php";?>",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {stage: $('tradingStage').innerHTML},
		onSuccess: function(t) {
			eval(t.responseText);
		}
		});

		if(justOnce!=1){
			setTimeout("tradingRefresher()",10000);
		}
	}
}

function aOrAn(s)
{
    return s.match('^[aeiou]');
}