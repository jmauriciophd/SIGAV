//var windowWidth = document.documentElement.clientWidth;
//var windowHeight = document.documentElement.clientHeight;

function centerDiv(divId) {	
	jQuery(function($){
		//request data for centering
		var popupHeight = $("#" + divId).height();
		var popupWidth = $("#" + divId).width();
		//centering
		$("#" + divId).css({
			//"top": windowHeight/2-popupHeight/2,
			//"left": windowWidth/2-popupWidth/2
			"top": document.documentElement.clientHeight/2-popupHeight/2,
			"left": document.documentElement.clientWidth/2-popupWidth/2
		});
	});	
}

//SETTING UP OUR POPUP  
//0 means disabled; 1 means enabled;  
var popupStatus = 0;  
var divIdPopup;

function loadPopupSemAjax(divId) {
	divIdPopup = divId;
	centerPopup();
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		});		
	}
}


function loadPopupSemAjaxQuestion(divId) {
	divIdPopup = divId;
	centerPopupQuestion();
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		});		
	}
}

//loading popup with jQuery magic!
function loadPopup(nomeAcao, nomeMetodo, divId){
	divIdPopup = divId;
	centerPopup();
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#backgroundPopup").fadeIn("slow");
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		
		sendDivRequest(nomeAcao, nomeMetodo, divIdPopup, null);
		
		});		
	}
}

//loading popup with jQuery magic!
function loadPopupSemAjax(divId){
	divIdPopup = divId;
	centerPopup();
	
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#backgroundPopup").fadeIn("slow");
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		
		});		
	}
}
/*
function loadPopup(nomeAcao, nomeMetodo, divId, params) {
	divIdPopup = divId;
	centerPopup();
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#backgroundPopup").fadeIn("slow");
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		
		sendDivRequest(nomeAcao, nomeMetodo, divIdPopup, params);
		});		
	}
}
*/
function loadPopupCallBackOnLoad(nomeAcao, nomeMetodo, divId, params, funcao) {
	divIdPopup = divId;
	centerPopup();
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){$("#backgroundPopup").css({
			"opacity": "0.7"
		});		
		$("#backgroundPopup").fadeIn("slow");
		$("#" + divIdPopup).fadeIn("slow");
		popupStatus = 1;
		
		sendDivRequestCallbackOnLoad(nomeAcao, nomeMetodo, funcao, divId, params);
		});		
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	jQuery(function($){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$(".popupAjax").fadeOut("slow");
		popupStatus = 0;
	}
	});
}

//centering popup
function centerPopupQuestion(){
	jQuery(function($){
	/*var popupHeight = $("#" + divIdPopup).height();
	var popupWidth = $("#" + divIdPopup).width();
	//centering
	$("#" + divIdPopup).css({
		"position": "absolute",
		//"top": document.documentElement.clientHeight/2-popupHeight/2 + 20,
		"left": document.documentElement.clientWidth/2-popupWidth/2 + 80
	});
	//only need force for IE6
	
	$("#" + divIdPopup).css({
		"position": "absolute",
		//"top": document.documentElement.clientHeight/2-popupHeight/2,
		"left": document.documentElement.clientWidth/2-popupWidth/2 + 80
	});*/
	
	$("#backgroundPopup").css({
		"height": document.documentElement.clientHeight
	});	});
	document.getElementById('DIVRepresentativoControversia').style.marginLeft="-70px";
	document.getElementById('DIVRepresentativoControversia').style.marginTop="450px";
}


//centering popup
function centerPopup(){
	jQuery(function($){
	//request data for centering
	//var windowWidth = document.documentElement.clientWidth;
	//var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#" + divIdPopup).height();
	var popupWidth = $("#" + divIdPopup).width();
	//centering
	$("#" + divIdPopup).css({
		"position": "absolute",
		"top": document.documentElement.clientHeight/2-popupHeight/2 + 20,
		"left": document.documentElement.clientWidth/2-popupWidth/2 + 80
	});
	//only need force for IE6
	
	$("#" + divIdPopup).css({
		"position": "absolute",
		"top": document.documentElement.clientHeight/2-popupHeight/2,
		"left": document.documentElement.clientWidth/2-popupWidth/2 + 80
	});
	
	$("#backgroundPopup").css({
		"height": document.documentElement.clientHeight
	});	});
}

jQuery(function($){
//CLOSING POPUP  
//Click out event!  
$("#backgroundPopup").click(function(){  
	disablePopup();  
});
//Press Escape event!  
$(document).keypress(function(e){  
	if(e.keyCode==27 && popupStatus==1){  
		disablePopup();  
	}  
 });
});