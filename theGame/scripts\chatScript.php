<?php
session_start();
require_once("../../currentRunningVersion.php");

if(!$S_user){
	exit();
}
?>
/*    (c) Syrnia.com
 *--------------------------------------------------------------------------*/
//var chatContent = new Array();
var reloadTimer=0;
var ReloadSeconds=6000;
var lastChatTime=new Date().getTime();
var lastChatUpdate;
var chatLines=0;
var ignoreList = new Array();

function postChatMessage(){

	if($('chatMessage').value==""){
		return;
	}
	var chatPost = new Ajax.Request("<?php echo GAMEURL."scripts/chat/addchat.php";?>",
	{
		evalScripts: "false",
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		//parameters: {calledBy: 'LT', action: action, var1: var1, var2: var2, var3:var3, var4:var4, var5:var5},
		parameters: {chatMessage: $('chatMessage').value, chatChannel: $('chatChannel').value},//Form.serialize("frmChat"),
		onSuccess: function( t) {
      		if(t.responseText){
      			if(t.responseText.substr(0,2)!='::'){
				 	updateCenterContents('bugReport', 'Chat error, message: '+t.responseText);
				 	addChat(0, ' There possibly was a chat error, please verify if your message has been added.');
				 	return;
				}
				var returnedMessage =t.responseText.substr(2);
				var patt1 = new RegExp("&&&");
				if(patt1.test(returnedMessage)){
					if(RegExp.leftContext){addChat(0, ' Chat error: ' + RegExp.leftContext);}
					eval(RegExp.rightContext);
				}else{
				 	addChat(0, ' Chat error: ' + returnedMessage);
				}
			}
		},
		on0: function( t) {
	    	alert('It looks like there is a connection problem; Either the game server is offline, or your internet connection is having problems. Your chat message was not added !');
		}
	});

    var currentTime2=new Date();
 	lastChatTime=currentTime2.getTime();
	$('chatMessage').value="";
	ReloadSeconds=6000;
}

function updateChat(){
 	if((new Date().getTime()-5000)<lastChatUpdate){
 	 	debug('Chat stop 1');
		return;
	}
	if($('chatMessage').style.visibility=='visible'){
	 	if(Ajax.activeRequestCount<=0){ //max 1 request (0+1)
	 		lastChatUpdate=new Date().getTime();
	 		var currentTime=new Date();
		 	if((currentTime.getTime()-lastChatTime)>600000){
		  		reloadTimer=setTimeout('updateChat();',20000);
		 	}else if((currentTime.getTime()-lastChatTime)>300000){
			 	reloadTimer=setTimeout('updateChat();',10000);
			}else{
				reloadTimer=setTimeout('updateChat();',6000);
			}

			var chatPost = new Ajax.Request("<?php echo GAMEURL."scripts/chat/chatnew.php";?>",
				{
					method: "post",
					contentType: "application/x-www-form-urlencoded",
					encoding: "UTF-8",
					onSuccess: function( t) {
						eval(t.responseText);
					}
				});
		}else{
			reloadTimer=setTimeout('updateChat();',5001);
		}
	}else{
	 	debug('Chat stop 2');
	 	//if($('chatMessage').style.visibility=='visible'){
		//	chatSwitch();
	 	//}
	}
}

function QuickWhisper(playerName){
	$('chatMessage').focus();
	$('chatMessage').value=playerName+"@";
}

function SwitchChatChannel(channelNr){
	$('chatChannel').value=channelNr;
	$('chatMessage').focus();
}

function addChat(channel, message2){
  	var currentTime2=new Date();
  	//lastChatTime=currentTime2.getTime();

	var ignorePlayer = 0;
	var theMessage = message2;

	var donatorCheckSplit1 = theMessage.split('<strong><u>');
	var donatorCheckSplit2 = theMessage.split('</em><u>');

	if(theMessage.match('<strong>')){ //Only check strings with <strong>


		if(donatorCheckSplit1[0] != theMessage || donatorCheckSplit2[0] != theMessage){
		    var theMessageSplit1 = theMessage.split('><u>');
		    var theMessageSplit2 = theMessageSplit1[1].split('</u></strong>');
		} else {
  			var theMessageSplit1 = theMessage.split('<strong>');
			var theMessageSplit2 = theMessageSplit1[1].split('</strong>');
		}

		var thePlayerName = theMessageSplit2[0].toString();

        if(thePlayerName != '<em>(Mod)</em>Moderator' && theMessageSplit2[1].length > 0)
        {
            message2 = message2.replace('<strong>', '<strong onclick="QuickWhisper(\''+thePlayerName+'\');return false;">');
        }

		for (var index = 0, len = ignoreList.length; index < len; ++index) {
		  var item =  ignoreList[index].toString();
		  if (item.toLowerCase() === thePlayerName.toLowerCase()) {
		    ignorePlayer = 1;
		  }
		};
	}

    if (ignorePlayer == 1) {
		 return;
    }

	if(channel==0){ 	 		var Pre="<font class=\"SystemChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else if(channel==1){ 	 	var Pre="<font class=\"RegionChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else if(channel==2){ 	 	var Pre="<font class=\"WorldChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else if(channel==4){ 		var Pre="<font class=\"TradeChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else if(channel==3){ 		var Pre="<font class=\"ClanChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else if(channel==6){ 		var Pre="<font class=\"PirateChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	<?php if($S_staffRights['chatMod']==1 OR $S_chatTag=='Mod' OR $S_chatTag=='Admin' OR $S_chatTag=='Guide') { ?>  }else if(channel==8 || channel==89){ var Pre="<font class=\"GuideChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>"; <?php } ?>
<?php if($S_staffRights['canLoginToTools']==1) { ?>  }else if(channel==99){ var Pre="<font class=\"ModChatAlt2\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>"; <?php } ?>
<?php if($S_staffRights['canLoginToTools']==1) { ?>  }else if(channel==9 || (channel>=91 && channel<=99)){ var Pre="<font class=\"ModChat\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>"; <?php } ?>
<?php if($S_staffRights['canLoginToTools']==1) { ?>  }else if(channel==9 || (channel>=90 && channel<=90)){ var Pre="<font class=\"ModChatAlt\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>"; <?php } ?>
	}else if(channel==5){ 		var Pre="<font class=\"GameHelp\"><span onclick=\"SwitchChatChannel("+channel+");return false;\">["+channel+"]</span>";
	}else{ 						var Pre="<font class=\"WhisperChat\">["+channel+"]";
	}
	message2=Pre+message2+"</font><br />";


	/*
	chatContent.push(message2);
	var output2='';
	for(var i=0;i<chatContent.length;i++){
	 	output2=output2+chatContent[i];
	}
	if(i>=50){
	 	chatContent.shift();
	}
	$('chatContent').innerHTML=output2;
	*/

	if(chatLines>=30 || chatLines==0){
	 	if(chatLines==0){
			chatLines++;
	  		$('chatContent').innerHTML=message2;
	  		return;
	  	}

	 	var patt1 = new RegExp("</font><br>", "i");
	 	var patt2 = new RegExp("</font><br />", "i");
		//var patt3 = new RegExp("</FONT><BR>");
	 	//var patt4 = new RegExp("</FONT><BR />");
		 if(patt1.test($('chatContent').innerHTML)){
			$('chatContent').innerHTML=RegExp.rightContext+message2;
		}else if(patt2.test($('chatContent').innerHTML)){
			$('chatContent').innerHTML=RegExp.rightContext+message2;
		//}else if(patt3.test($('chatContent').innerHTML)){
		//	$('chatContent').innerHTML=RegExp.rightContext+message2;
		//}else if(patt4.test($('chatContent').innerHTML)){
		//	$('chatContent').innerHTML=RegExp.rightContext+message2;
		}else{
		 	if($('chatMessage').style.visibility=='visible'){
				messagePopup('Chat error [newMessage] ! Please contact the Syrnia support so we can fix this problem for you. The chat has been disabled.', 'Chat add error');
				chatSwitch();
			}
		}
	}else{
		$('chatContent').innerHTML+=message2;
		chatLines++;
	}


	$('chatContent').scrollTop=$('chatContent').scrollHeight;
}

function chatSwitch(noSet){
  if($('chatMessage').style.visibility=='visible'){
	    barheight-=$("chatContent").offsetHeight;
		$('chatChannel').style.visibility='hidden';
	    $('chatMessage').style.visibility='hidden';
	    $('chatSend').style.visibility='hidden';
	    $('popupChat').style.visibility='visible';
	    $('chatDisable').innerHTML='Enable Chat';
	    $('chatContent').hide();
	    if(noSet!=1){	updateCenterContentsExtended('setOption', 'chat', 2);	}
  }else{
		if(noSet!=1){	updateCenterContentsExtended('setOption', 'chat', 0);	}
	    $('chatChannel').style.visibility='visible';
	    $('chatMessage').style.visibility='visible';
	    $('chatSend').style.visibility='visible';
	    $('popupChat').style.visibility='hidden';
	    $('chatDisable').innerHTML='Disable Chat';
	    $('chatContent').show();
	    var currentTime2=new Date();
		lastChatTime=currentTime2.getTime();
		updateChat();
		barheight+=$("chatContent").offsetHeight;
  }
}


//Chat container
var persistclose=0;
var startX = 204;
var startY = 0;
var verticalpos="frombottom"
var oldPy=0;
var chatFloatReload=10;
var barheight;

function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function closebar(){
	if (persistclose)
		document.cookie="remainclosed=1"
		$("chatHolder").style.visibility="hidden"
}


function ml(id){
	 var ns = (navigator.appName.indexOf("Netscape") != -1) || window.opera;

	var el=$(id);
	if (!persistclose || persistclose)
	el.style.visibility="visible"
	if(document.layers)el.style=el;
	el.sP=function(x,y){this.style.left=x+"px";this.style.top=y+"px";};
	el.x = startX;
	if (verticalpos=="fromtop"){
		el.y = startY;
	}else{
		el.y = ns ? pageYOffset + innerHeight : iecompattest().scrollTop + iecompattest().clientHeight;
		el.y -= startY;
	}
	return el;
}



function staticbar(){
	barheight=$("chatHolder").offsetHeight;

	var ns = (navigator.appName.indexOf("Netscape") != -1) || window.opera;


	window.stayTopLeft=function(){

		if (verticalpos=="fromtop"){
			var pY = ns ? pageYOffset : iecompattest().scrollTop;
			ftlObj.y += (pY + startY - ftlObj.y)/2;
		}else{
			var pY = ns ? pageYOffset + innerHeight - barheight: iecompattest().scrollTop + iecompattest().clientHeight - barheight;
			if(pY!=oldPy){
				chatFloatReload=2;
			}else{
				if(chatFloatReload<500){
				 	chatFloatReload+=0.1;
				}
			}
			oldPy=pY;
			ftlObj.y += (pY - startY - ftlObj.y)/2;
		}
		ftlObj.sP(ftlObj.x, ftlObj.y);
		setTimeout("stayTopLeft()", chatFloatReload);
	}
	ftlObj = ml("chatHolder");
	stayTopLeft();
}