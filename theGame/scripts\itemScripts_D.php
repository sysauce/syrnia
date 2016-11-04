<?
 	session_start();
 	if(!$S_user){
		exit();
	}
	require_once("../../currentRunningVersion.php");
?>
/*    (c) Syrnia.com
 *--------------------------------------------------------------------------*/
var GAMEURL = "<?php echo GAMEURL;?>";
var lastMovedItem=null;
var lastMovedItemParent=null;
var debugNr=0;

function debug(text)
{
	debugNr++;
	if(DEBUGMODE==1){
	 	if($('DebugContent')){
			$('DebugContent').innerHTML+="<br /><b>"+debugNr+"</b>: "+text;
		}else{
			alert('debug:'+text);
		}
	}
}


function createItemHTML(itemID, itemTitle, itemAmount, upgradeImage){
 	if(upgradeImage!=null){
		upgradeImage="<img src=\""+upgradeImage+"\"/>";
	}else{
		var upgradeImage='';
	}
	var position=itemTitle.indexOf(" [");
	if(position>0){
	 	var itemImage=itemTitle.substr(0,position);
	}else{
	 	var itemImage=itemTitle;
	}

	if(disableImages==1){
		return "<div id=\""+itemID+"\" title=\""+itemTitle+"\" style=\"float:left;width:180px;\"><font color=white id=much>"+itemAmount+"</font> "+itemTitle+" </div>";
	}else{
		return "<div id=\""+itemID+"\" title=\""+itemTitle+"\" style=\"height:45px;float:left;width:45px;background-image: url('<?php echo SERVERURL; ?>images/inventory/"+itemImage.replace(/ /g,'%20')+".gif');\"><font color=white id=much>"+itemAmount+"</font>"+upgradeImage+"</div>";
	}
}


function cancelDragDrop(itemElement, wasFromContainer, wasToContainer, moveAmount, oldItemID){
	var itemElement= $(itemElement);
	var wasToContainer=$(wasToContainer);
	var wasFromContainer=$(wasFromContainer);

	if(wasFromContainer.id=='centerDropList' && !itemElement.id.match('temp_') && wasToContainer.id!='houseInventory'){
		var elementIfExcists = itemInContainer(wasToContainer, itemElement.title, 0);
		if(elementIfExcists){
			removeItemFromContainer(wasToContainer, elementIfExcists.title, moveAmount, 1);
		}

		var elementIfExcists = itemInContainer(wasFromContainer, itemElement.title, 0);
		if(elementIfExcists){
			removeItemFromContainer(wasFromContainer, elementIfExcists.title, moveAmount+10000, 1);
		}

		recreateSortable(wasFromContainer.id);
		recreateSortable(wasToContainer.id);

		messagePopup("Another player has already picked up this item!", 'Dropped items');
		DoPeriodUpdate();
		return;
	}

	var elementIfExcists = itemInContainer(wasFromContainer, itemElement.title, 0);

	if(elementIfExcists==null){//Not in parent anymore
		var upgradeImage=null;
		if(itemElement.lastChild.tagName=='IMG'){
			upgradeImage=itemElement.lastChild.src;
		}
		var itemID;
		if(oldItemID){
			itemID=oldItemID;
		}else{
			itemID=itemElement.id;
		}
		wasFromContainer.innerHTML+=createItemHTML(itemID, itemElement.title, parseInt(moveAmount), upgradeImage);
		disableSelection($(itemElement.id));
		containerClickEvents(wasFromContainer);
	}else{
		elementIfExcists.firstChild.innerHTML=parseInt(elementIfExcists.firstChild.innerHTML)+moveAmount;
	}

	var elementIfExcists = itemInContainer(wasToContainer, itemElement.title, 0);
	if(elementIfExcists){
		removeItemFromContainer(wasToContainer, elementIfExcists.title, moveAmount, 1);
	}

 	recreateSortable(wasFromContainer.id);
	recreateSortable(wasToContainer.id);
	if(wasToContainer.id=='houseInventory' && wasFromContainer.id=='centerDropList'){
		messagePopup("You can not transfer items from the droplist to your house, and vice versa.", 'Dropped items');
	}else if(wasToContainer.id=='houseInventory'){
		messagePopup("You can not transfer that many items to your house, check the available free slots!", 'House storage');
	}else{
		messagePopup("Because of a connection problem your last item transfer had to be reverted.", 'Item transfer');
	}
}

<?php //addItem ?>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('g M(a,f,9,5,d,i){4 e=0;3(9=="7"){4 c=$(\'7\').q;3(!c){c=D("7")}e=c?0:1}j C.B(E+"F/I.H",{G:"A",z:"r/x-p-s-u",y:"w-8",J:{a:a,K:f,X:9,W:5,e:e},Y:g(t){4 k=j b("&&&");4 2=\'\';3(k.11(t.n)){2=b.10}6{2=t.n}3(2==\'\'){4 m=T(5,i,0);L(m,9,5,f,a);h(b.l)}6{h(b.l);3(d){3($(d).v.o==5){3(5==\'Q\'){4 2=\'R\'+2}6 3(5==\'7\'){4 2=\'S\'+2}6 3(5==\'P\'){4 2=\'O\'+2}6{4 2=\'N\'+2}$(d).o=2;Z($(2))}6{}}}},V:g(t){}});U}',62,64,'||newItemID|if|var|toContainer|else|centerDropList||fromContainer|itemID|RegExp|over|updateID|lg|moveAmount|function|eval|itemTitle|new|patt1|rightContext|elementMustExcists|responseText|id|www|isMouseOver|application|form||urlencoded|parentNode|UTF||encoding|contentType|post|Request|Ajax|cII|GAMEURL|ajax|method|php|moveItems|parameters|move|cancelDragDrop|addItem|itemX_|itemH_|houseInventory|playerInventory|itemI_|itemD_|itemInContainer|return|on0|to|from|onSuccess|disableSelection|leftContext|test'.split('|')))

function itemInContainer(container, itemTitle, itemID){
	var currentChild =$(container).firstChild;
	 for(;currentChild!=null;currentChild=currentChild.nextSibling){
		if(currentChild.title==itemTitle && (currentChild.id!=itemID)){
			return currentChild;
			break;
		}
	} //For
	return null;
}

function movedItem(itemElement, dropon)
{
 	var moveAmount;
 	var newParent=lastMovedItem.parentNode;
 	if(!lastMovedItem || !lastMovedItem.parentNode){
 	 	//debug('ERROR: item transfer went wrong!');
		return;
	}

 	if(newParent.id=='houseInventory' || lastMovedItemParent.id=='houseInventory'){
 		moveAmount=parseInt($('moveMuchHouse').value);
 		if($('houseSlots') && newParent.id=='houseInventory'){
			if(parseInt($('houseSlots').innerHTML) < moveAmount){
				moveAmount=parseInt($('houseSlots').innerHTML);
			}
		}
 	}else if($('moveMuch')==null){
		moveAmount=1;
	}else{
		 moveAmount=parseInt($('moveMuch').value);
	}
	if(moveAmount<1 || !moveAmount || !isFinite(moveAmount)){
		moveAmount=1;
	}


 	var itemAmount=parseInt(lastMovedItem.firstChild.innerHTML);
 	if(moveAmount>itemAmount){
		moveAmount=itemAmount;
	}else if(moveAmount<=0 || itemAmount==null){
	 	//debug('DEBUG 0 itemScript');
	 	return 0;
	}

 	if(dropon.id=='wearDisplayTD'){
			wearItem(itemElement);
	}else{
	 	if(itemElement==null){

	 	 	if(lastMovedItem.id.match('temp_')){ //
	 	 		cancelDragDrop(lastMovedItem.id, lastMovedItemParent, newParent, moveAmount);
				messagePopup('You moved the item too fast after dropping it..the move has been cancelled..', 'Moving items');
				return;
			}
	 		if(lastMovedItemParent.id!=newParent.id){
	 		 	var elementIfExcists = itemInContainer(lastMovedItem.parentNode, lastMovedItem.title, lastMovedItem.id);
				  if(elementIfExcists==null){ // New item
					if(moveAmount>=itemAmount){ //All
					//debug('new all');

						addItem(lastMovedItem.id.substr(6), moveAmount, lastMovedItemParent.id, lastMovedItem.parentNode.id, lastMovedItem.id, lastMovedItem.title);

						recreateSortable(newParent.id);
						recreateSortable(lastMovedItemParent.id);
						return 1;
					}else{	//Part
					//debug('new part');
						var title=lastMovedItem.title;

						var oldID=lastMovedItem.id;
						var oldParent=lastMovedItemParent;

						if(lastMovedItem.lastChild.tagName=='IMG'){
							var upgradeImage=lastMovedItem.lastChild.src;
						}

						var tempID='temp_'+lastMovedItem.id+Math.ceil(Math.random()*100);
						var newParent=lastMovedItem.parentNode;
						lastMovedItem.remove();

						newParent.innerHTML+=createItemHTML(tempID, title, moveAmount, upgradeImage);
						addItem(oldID.substr(6), moveAmount, oldParent.id, newParent.id, tempID, title);


						oldParent.innerHTML+=createItemHTML(oldID, title, (itemAmount-moveAmount), upgradeImage);
						disableSelection($(oldID));

						containerClickEvents(newParent);
						containerClickEvents(oldParent);
						recreateSortable(newParent.id);
						recreateSortable(oldParent.id);

						return 1;
					}
				}else{ //Already excists
					if(moveAmount>=parseInt(lastMovedItem.firstChild.innerHTML)){ //All
					//debug('excists all');
						var itemTitle=lastMovedItem.title;


						addItem(lastMovedItem.id.substr(6), moveAmount, lastMovedItemParent.id, lastMovedItem.parentNode.id, 0 ,itemTitle );
						elementIfExcists.firstChild.innerHTML=parseInt(elementIfExcists.firstChild.innerHTML)+parseInt(lastMovedItem.firstChild.innerHTML);

						lastMovedItem.remove();


					}else{ //Part
						//debug('excists:part');
						var oldID=lastMovedItem.id;
						addItem(lastMovedItem.id.substr(6), moveAmount, lastMovedItemParent.id, lastMovedItem.parentNode.id, 0, lastMovedItem.title);

						elementIfExcists.firstChild.innerHTML=parseInt(elementIfExcists.firstChild.innerHTML)+moveAmount;

						if(lastMovedItem.lastChild.tagName=='IMG'){
							var upgradeImage=lastMovedItem.lastChild.src;
						}
						lastMovedItemParent.innerHTML+=createItemHTML(oldID, lastMovedItem.title, (parseInt(lastMovedItem.firstChild.innerHTML)-moveAmount),upgradeImage );

						var parent=lastMovedItem.parentNode;

						lastMovedItem.remove();

						disableSelection($(oldID));

						containerClickEvents(lastMovedItemParent);

						recreateSortable(parent.id);
						recreateSortable(lastMovedItemParent.id);
						return 1;


					}
				}
			}else{
				//debug('parents same'+newParent.id);
			}
		}else{
			//debug('item != null itemscripts');
		}
	}
}

function wearItem(itemElement){
	new Ajax.Request("<?php echo GAMEURL."ajax/wearItem.php";?>",
	{
	method: "post",
	contentType: "application/x-www-form-urlencoded",
	encoding: "UTF-8",
	parameters: {itemID: itemElement.id},
	onSuccess: function( t) {
		eval(t.responseText);
	},
	on0: function( t) {
	 	//messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS wearItem]', 'Connection problem');
		//setTimeout("wearItem('"+itemElement+"');", 10000);
	}
	});
}

function unwearItem(position){
	new Ajax.Request("<?php echo GAMEURL."ajax/wearItem.php";?>",
	{
	method: "post",
	contentType: "application/x-www-form-urlencoded",
	encoding: "UTF-8",
	parameters: {position: position},
	onSuccess: function( t) {
		eval(t.responseText);
	},
	on0: function( t) {
	 	//messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS unwearItem]', 'Connection problem');
		//setTimeout("unwearItem('"+position+"');", 10000);
	}
	});
}



function recreateSortable(sortableName){
	if(disableDragDrop==1){
	 	return;
	}else{
	 	if($(sortableName)){
			Sortable.destroy(sortableName);
			if(sortableName=='playerInventory'){
				Sortable.create(sortableName,{tag:'div',scroll: window, scrollSensitivity:100, scrollSpeed:15, constraint:false,containment:['centerDropList', 'houseInventory'], dropOnEmpty:true,
			onUpdate:function(element){ if(lastMovedItem!=null){ movedItem(null, element);}  } });
			}else if(sortableName=='houseInventory'){
			 	Sortable.create(sortableName,{tag:'div', scroll: window,scrollSensitivity:100, scrollSpeed:15,constraint:false,containment:['playerInventory', 'centerDropList'], dropOnEmpty:true,
			onUpdate:function(element){ if(lastMovedItem!=null && lastMovedItemParent.id=='centerDropList'){
		cancelDragDrop(lastMovedItem.id, lastMovedItemParent, lastMovedItem.parentNode, parseInt(lastMovedItem.firstChild.innerHTML));
		}}});
			}else{
				Sortable.create(sortableName,{tag:'div', scroll: window,scrollSensitivity:100, scrollSpeed:15,constraint:false,containment:['playerInventory'], dropOnEmpty:true});
			}
		}
	}
}


function updateLastMovedItem(elementItem){
	if(elementItem.id=='much' || elementItem.id=='' ){
		elementItem=elementItem.parentNode;
	}
	lastMovedItem=elementItem;
	lastMovedItemParent=lastMovedItem.parentNode;
}


function addItemToContainer(toInventory, itemID, title, amount, upgradeImage){
	if(upgradeImage==''){upgradeImage=null;}

 	var currentChild =$(toInventory).firstChild;
	for(;currentChild!=null;currentChild=currentChild.nextSibling){
		if(currentChild.title==title){
		 	var found=1;
			break;
		}
	}

 	if(found!=1){
		$(toInventory).innerHTML+=createItemHTML(itemID, title, amount, upgradeImage);
		disableSelection($(itemID));

	  		containerClickEvents(toInventory);

	}else{
		currentChild.firstChild.innerHTML=parseInt(currentChild.firstChild.innerHTML)+parseInt(amount);
		currentChild.id=itemID;
	}
	recreateSortable(toInventory);
}


function removeItemFromContainer(fromInventory, title, amount, doNotRecreate){
	 var currentChild =$(fromInventory).firstChild;
	for(;currentChild!=null;currentChild=currentChild.nextSibling){
		if(currentChild.title==title){
			 var found=1;
			break;
		}
	}
 	if(found==1){
	  	currentChild.firstChild.innerHTML=parseInt(currentChild.firstChild.innerHTML)-parseInt(amount);
		if(parseInt(currentChild.firstChild.innerHTML)<=0){
			if(currentChild){
			 //Fixme: Can this be removed, or was there a safari bug?
				if(currentChild.id.match('fightFood')){
				 	$(currentChild.id).remove();
				}else{
					currentChild.remove();
				}
			}
		}
	}else{
		messagePopup('No such item [title]!', 'Minor inventory problem..');
	}
	if(doNotRecreate!=1){
		recreateSortable(fromInventory);
	}
}

function removeItemFromContainerByID(fromInventory, itemID, amount, doNotRecreate){
 	var currentChild =$(fromInventory).firstChild;
	for(;currentChild!=null;currentChild=currentChild.nextSibling){
		if(currentChild.id==itemID){
			var found=1;
			break;
		}
	}
 	if(found==1){
	  	currentChild.firstChild.innerHTML=parseInt(currentChild.firstChild.innerHTML)-parseInt(amount);
		if(parseInt(currentChild.firstChild.innerHTML)<=0){
			currentChild.remove();
		}
	}else{
		messagePopup('No such item [ID]!', 'Inventory problem..');
	}
	if(doNotRecreate!=1){
		recreateSortable(fromInventory);
	}
}

<?php //useItem ?>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('3 9(2,5,0){4(0==7){0=1}4(2==7){4(a&&a.j!=7){D 2=a.j.F(6)}i{C(\'B:E H K I G\');J}}4(5){g k.l(e+"b/m.c",{f:"d",h:"r/x-v-z-A",y:"s-8",o:{n:\'9\',2:2,5:5,0:0},p:3(t){q(t.u)},w:3(t){}})}i{g k.l(e+"b/m.c",{f:"d",h:"r/x-v-z-A",y:"s-8",o:{n:\'9\',2:2,0:0},p:3(t){q(t.u)},w:3(t){}})}}',47,47,'var3||itemID|function|if|var2||null||useItem|lastMovedItem|ajax|php|post|GAMEURL|method|new|contentType|else|id|Ajax|Request|centerContent|var1|parameters|onSuccess|eval|application|UTF||responseText|www|on0||encoding|form|urlencoded|Alert|alert|var|Item|substr|item|error|using|return|when'.split('|')))

<?php //useItemNew ?>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1 C(0,2){3(0==e){3(4&&4.f!=e){B 0=4.f.A(6)}d{z(\'D:F J H I G\');E}}3(2){h i.b(7+"5/j.9",{c:"a",g:"p/x-s-u-y",w:"r-8",l:{k:\'m\',0:0,2:2},n:1(t){q(t.o)},v:1(t){}})}d{h i.b(7+"5/j.9",{c:"a",g:"p/x-s-u-y",w:"r-8",l:{k:\'m\',0:0},n:1(t){q(t.o)},v:1(t){}})}}',46,46,'itemID|function|var2|if|lastMovedItem|ajax||GAMEURL||php|post|Request|method|else|null|id|contentType|new|Ajax|centerContent|var1|parameters|useItem|onSuccess|responseText|application|eval|UTF|www||form|on0|encoding||urlencoded|alert|substr|var|useItemNew|Alert|return|Item|item|when|using|error'.split('|')))

<?php //containerClickEvents ?>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('n v(b){7(1n==1){8 b=$(b);Y(8 9=b.p;9!=f;9=9.P){7(b.5==\'i\'){d.s(9.5,\'y\',n(e){8 c=\'\';7($(\'H\')&&$(\'H\').J.M!=\'L\'){c=\'1l\'}g 7($(\'G\')!=f&&$(\'G\').l==\'1j 2/4\'){c=\'K\'}g 7($(\'F\')!=f&&$(\'F\').l==\'1g 1i 1m u\'){c=\'u\'}g 7($(\'I\')&&$(\'I\').J.M!=\'L\'){c=\'1f\'}7(d.j(e).5.1d(\'18\')){17(\'16 19 1e 1c 1b 1a 1h 1q E, 1B z 1F 1A a 1o 1C.\',\'1E/1D 1x E\');x}7(c!=\'\'){8 3=d.j(e);7(3.5==\'14\'||3.5==\'\'){3=3.13}8 k=3.5;7(3.r.15==\'10\'){8 q=3.r.S}7(c==\'K\'){7(3.5.N(\'C\')===0){8 h=3.5.h(\'D\');8 5=h[1];h=f;B(\'1w\',\'O\',5,$(\'1r\').A);x t;5=f}}g 7(c==\'u\'){7(3.5.N(\'C\')===0){8 h=3.5.h(\'D\');8 5=h[1];h=f;B(\'1s\',\'O\',$(\'1t\').A,5);x t;5=f}}g{$(c).l+=R(3.5,3.11,T(3.p.l),q);3.U();Z($(k));w($(k));W=b;v($(c));V(f,$(c))}}g{8 o=d.j(e).5.12(6);8 m=t;z{m=$(\'i\').1u}1v(1p){}7(!m){m=1z("i")}7(m){Q(o,\'X\')}g{1y(o,\'X\',2)}}})}g{d.s(9.5,\'y\',n(e){8 3=d.j(e);7(3.5==\'14\'||3.5==\'\'){3=3.13}8 k=3.5;7(3.r.15==\'10\'){8 q=3.r.S}$(\'i\').l+=R(3.5,3.11,T(3.p.l),q);3.U();Z($(k));w($(k));W=b;v($(\'i\'));V(f,$(\'i\'))})}}}g{8 b=$(b);Y(8 9=b.p;9!=f;9=9.P){d.s(9.5,\'y\',n(e){w(d.j(e))});7(b.5==\'i\'){d.s(9.5,\'1k\',n(e){8 o=d.j(e).5.12(6);Q(o,\'X\')})}}}}',62,104,'|||itemElement||id||if|var|currentChild||container|movingTo|Event||null|else|split|playerInventory|element|newID|innerHTML|over|function|itemID|firstChild|upgradeImage|lastChild|observe|false|compound|containerClickEvents|updateLastMovedItem|return|click|try|value|locationText|itemI_|_|item|addToCompound|tradingStage|houseAddOffButton|droppingAddOffButton|style|trade|none|display|indexOf|addItems|nextSibling|useItemNew|createItemHTML|src|parseInt|remove|movedItem|lastMovedItemParent||for|disableSelection|IMG|title|substr|parentNode|much|tagName|You|messagePopup|temp_|can|or|use|yet|match|not|centerDropList|Add|move|items|Trading|dblclick|houseInventory|to|disableDragDrop|few|err|this|addMuchTradeItems|clancompound|numberOfItems|isMouseOver|catch|tradingpost|the|useItem|cII|after|please|seconds|Using|Moving|again'.split('|')))

function compoundClickEvents(container)
{
    //alert('add compound click events');
    var container=$(container);
    for(var currentChild =container.firstChild;currentChild!=null;currentChild=currentChild.nextSibling)
    {
        //House / Center drop list
        Event.observe(currentChild.id, 'click', function(e)
        {
            var itemElement=Event.element(e);
            if(itemElement.id=='much' || itemElement.id=='' )
            {
                itemElement=itemElement.parentNode;
            }
            var newID=itemElement.id;

            //alert("id: " + newID);

            var split = itemElement.id.split('_');
			var id = split[1];

            $('compoundItemName').innerHTML = $('' + newID).title;
            $('compoundItemID').value = id;
            $('removeFromCompound').style.display = 'block';
        }
        );
    }
}