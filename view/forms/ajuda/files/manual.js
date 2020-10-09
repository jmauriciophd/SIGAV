// variavel com valor do tamanho da janela.
//var janela_largura = screen.availWidth;
//var janela_altura = screen.availHeight;

function resizewindow(){
	vindice = document.getElementById('idindice');
	vbody = document.getElementById('idbody');
	//idindice.style.display = 'none';
	if(vindice.style.display == "none"){
		vindice.style.display = 'block';
		vbody.style.width = "75%";
	}
	else{
		vindice.style.display = "none";
		vbody.style.width = "99%";
	}
	
}

function printpage(){
	var newurl = parent.document.getElementById('idbody');
	var janela_largura = screen.availWidth;
	var janela_altura = screen.availHeight;
	var setting = 'scrollbars=yes,status=no,toolbar=no,menubar=yes,width='+janela_largura;	 
	setting += ',height='+janela_altura+',left=20,top=10,resizable=no';
	window.open(newurl.src,'',setting);	
}
