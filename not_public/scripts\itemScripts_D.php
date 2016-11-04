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
function addItem(itemID, moveAmount, fromContainer, toContainer, updateID, itemTitle){
	var lg = 0;
    if(fromContainer == "centerDropList")
    {
        var over = $('centerDropList').isMouseOver;

        if(!over)
        {
            over = cII("centerDropList");
        }

        lg = over ? 0 : 1;
    }
    new Ajax.Request(GAMEURL + "ajax/moveItems.php",
	{
	method: "post",
	contentType: "application/x-www-form-urlencoded",
	encoding: "UTF-8",
	parameters: {itemID: itemID, move: moveAmount, from: fromContainer, to: toContainer, lg: lg},
	onSuccess: function( t) {
		var patt1 = new RegExp("&&&");
		var newItemID = '';
		if(patt1.test(t.responseText)){
			newItemID =RegExp.leftContext;
		}else{
		 	newItemID=t.responseText;
		}
		if(newItemID==''){
		 	var elementMustExcists = itemInContainer(toContainer, itemTitle, 0);
			cancelDragDrop(elementMustExcists, fromContainer, toContainer, moveAmount, itemID);
			eval(RegExp.rightContext);
		}else{
			eval(RegExp.rightContext);
		 	if(updateID){
				if($(updateID).parentNode.id==toContainer){
					if(toContainer=='playerInventory'){
						var newItemID = 'itemI_'+newItemID;
					}else if(toContainer=='centerDropList'){
						var newItemID = 'itemD_'+newItemID;
					}else if(toContainer=='houseInventory'){
						var newItemID = 'itemH_'+newItemID;
					}else{
						var newItemID = 'itemX_'+newItemID;
					}
					$(updateID).id=newItemID;
					disableSelection($(newItemID));
				}else{
					//debug('Moved item too quick back&forth');
				}
			}
		}
	},
	on0: function( t) {
	 	//messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS addItem]', 'Connection problem');
		//setTimeout("addItem('"+itemID+"', '"+moveAmount+"', '"+fromContainer+"', '"+toContainer+"', '"+updateID+"', '"+itemTitle+"');", 10000);
	}
	});

	return;
}


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
function useItem(itemID, var2, var3){
    if(var3 == null)
    {
        var3 = 1;
    }

    if(itemID==null){
 	 	if(lastMovedItem && lastMovedItem.id!=null){
			var itemID=lastMovedItem.id.substr(6);
		}else{
		 	alert('Alert:Item error when using item');
			return;
		}
	}
	if(var2){
		//new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		new Ajax.Request(GAMEURL + "ajax/centerContent.php",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'useItem', itemID: itemID, var2: var2, var3: var3},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 //	messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS useItem]', 'Connection problem');
			//setTimeout("useItem('"+itemID+"', 'X');", 10000);
		}
		});

	}else{
		//new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		new Ajax.Request(GAMEURL + "ajax/centerContent.php",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'useItem', itemID: itemID, var3: var3},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 	//messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS useItem]', 'Connection problem');
			//setTimeout("useItem('"+itemID+"', 'X');", 10000);
		}
		});
	}
}

<?php //useItemNew ?>
function useItemNew(itemID, var2){
 	if(itemID==null){
 	 	if(lastMovedItem && lastMovedItem.id!=null){
			var itemID=lastMovedItem.id.substr(6);
		}else{
		 	alert('Alert:Item error when using item');
			return;
		}
	}
	if(var2){
		//new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		new Ajax.Request(GAMEURL + "ajax/centerContent.php",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'useItem', itemID: itemID, var2: var2},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 //	messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS useItem]', 'Connection problem');
			//setTimeout("useItemNew('"+itemID+"', 'X');", 10000);
		}
		});

	}else{
		//new Ajax.Request("<?php echo GAMEURL."ajax/centerContent.php";?>",
		new Ajax.Request(GAMEURL + "ajax/centerContent.php",
		{
		method: "post",
		contentType: "application/x-www-form-urlencoded",
		encoding: "UTF-8",
		parameters: {var1: 'useItem', itemID: itemID},
		onSuccess: function( t) {
			eval(t.responseText);
		},
		on0: function( t) {
		 	//messagePopup('There was a connection problem, the game was unable to connect to the game. However, the game is trying to reconnect in 10 seconds. [error code: iS useItem]', 'Connection problem');
			//setTimeout("useItemNew('"+itemID+"', 'X');", 10000);
		}
		});
	}
}

<?php //containerClickEvents ?>
function containerClickEvents(container){
	if(disableDragDrop==1){
  	 	var container=$(container);
		for(var currentChild =container.firstChild;currentChild!=null;currentChild=currentChild.nextSibling){
		 	if(container.id=='playerInventory'){
			  //Player inventory
				Event.observe(currentChild.id, 'click', function(e)
				{
				 	var movingTo='';
				 	if($('houseAddOffButton') && $('houseAddOffButton').style.display!='none'){
				 	 	movingTo='houseInventory';
				 	}else if($('tradingStage')!=null && $('tradingStage').innerHTML=='Trading 2/4'){
				 	 	movingTo='trade';
				 	}else if($('addToCompound')!=null && $('addToCompound').innerHTML=='Add items to compound'){
				 	 	movingTo='compound';
				 	}else if($('droppingAddOffButton') && $('droppingAddOffButton').style.display!='none'){
						movingTo='centerDropList';
					}

					if(Event.element(e).id.match('temp_')){
							messagePopup('You can not yet use or move this item, please try again after a few seconds.', 'Moving/Using the item');
							return;
					}

					if(movingTo!=''){
				 	 	var itemElement=Event.element(e);
				 	 	if(itemElement.id=='much' || itemElement.id=='' ){
							itemElement=itemElement.parentNode;
						}
						var newID=itemElement.id;
				 	 	if(itemElement.lastChild.tagName=='IMG'){
						 	var upgradeImage=itemElement.lastChild.src;
						}

						if(movingTo=='trade')
						{
							if(itemElement.id.indexOf('itemI_') === 0)
							{
								var split = itemElement.id.split('_');
								var id = split[1];
								split = null;
								locationText('tradingpost', 'addItems', id, $('addMuchTradeItems').value);return false;
								id = null;
							}
						}
						else if(movingTo=='compound')
						{
							if(itemElement.id.indexOf('itemI_') === 0)
							{
								var split = itemElement.id.split('_');
								var id = split[1];
								split = null;
								locationText('clancompound', 'addItems', $('numberOfItems').value, id);return false;
								id = null;
							}
						}
						else
						{
							$(movingTo).innerHTML+=createItemHTML(itemElement.id, itemElement.title, parseInt(itemElement.firstChild.innerHTML), upgradeImage);
							itemElement.remove();
							disableSelection($(newID));
							updateLastMovedItem($(newID));
							lastMovedItemParent=container;
							containerClickEvents($(movingTo));
							movedItem(null, $(movingTo));
						}
					}
                    else
                    {
                        var itemID=Event.element(e).id.substr(6);


                        var over = false;
                        try
                        {
                            over = $('playerInventory').isMouseOver;
                        }
                        catch(err)
                        {
                        }

                        if(!over)
                        {
                            over = cII("playerInventory");
                        }

                        if(over)
                        {
                            useItemNew(itemID, 'X');
                        }
                        else
                        {
                            useItem(itemID, 'X', 2);
                        }
					}
				}
				);
			}else{
			 //House / Center drop list
				Event.observe(currentChild.id, 'click', function(e)
				{
					var itemElement=Event.element(e);
				 	if(itemElement.id=='much' || itemElement.id=='' ){
						itemElement=itemElement.parentNode;
					}
					var newID=itemElement.id;
				 	if(itemElement.lastChild.tagName=='IMG'){
					 	var upgradeImage=itemElement.lastChild.src;
					}
					$('playerInventory').innerHTML+=createItemHTML(itemElement.id, itemElement.title, parseInt(itemElement.firstChild.innerHTML), upgradeImage);

					itemElement.remove();
					disableSelection($(newID));
					updateLastMovedItem($(newID));
					lastMovedItemParent=container;
					containerClickEvents($('playerInventory'));
					movedItem(null, $('playerInventory'));
				}
				);
			}
		}

	}else{
		var container=$(container);
		for(var currentChild =container.firstChild;currentChild!=null;currentChild=currentChild.nextSibling){
				Event.observe(currentChild.id, 'click', function(e){updateLastMovedItem(Event.element(e)); });
				if(container.id=='playerInventory'){
					Event.observe(currentChild.id, 'dblclick', function(e){var itemID=Event.element(e).id.substr(6); useItemNew(itemID, 'X'); });
				}
		}
	}
}

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