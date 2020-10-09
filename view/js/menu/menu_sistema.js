
_menuCloseDelay=400;     // The time delay for menus to remain visible on mouse out
_menuOpenDelay=300;      // The time delay before menus open on mouse over
_followSpeed=50;               // Follow scrolling speed
_followRate=100;               // Follow scrolling Rate
_subOffsetTop=100;            // Sub menu top offset
_subOffsetLeft=250;            // Sub menu left offset
_scrollAmount=50;               // Only needed for Netscape 4.x
_scrollDelay=100;          // Only needed for Netcsape 4.x


// BARRA DE MENU
with(XPMainStyle=new mm_style()){
onbgcolor="#045b90"; //cor do mouse sobre o item
oncolor="#FFFFFF";
offbgcolor="transparent"; //cor do fundo da barra principal #EFEDDE
offcolor="#045b90";
bordercolor="transparent"; //cor da borda #cccccc
borderstyle="solid";
borderwidth=0;
separatorcolor="#c0c0c0";  //cor do fundo da barra principal
separatorsize=1;
padding=3;

fontsize="12px";
fontstyle="normal";
fontweight="bold";
fontfamily="Tahoma, verdana, Helvetica";
fontcolor= "#045b90";
//subimagepadding=10;
//onborder="1px solid #003366"; //cor da borda selecionada
//offborder="1px solid #C4D0D6"; //cor da borda não selecionada #cccccc
}

// MENUS INTERNOS
with(XPMenuStyle=new mm_style()){
onbgcolor="#5a9ac0"; //cor do mouse sobre o item
oncolor="#FFFFFF";  // cor do texto das caixas internas selecionadas
offbgcolor="#045b90";
offcolor="#FFFFFF";  // cor do texto das caixas internas NÃO selecionadas
bordercolor="#ffffff";  //cor da borda das caixas ao redor do menu
borderstyle="solid";
borderwidth=1;
separatorcolor="#8A867A";
separatorpadding="0";
separatoralign="right";
separatorwidth="80%";
padding=2;   //Define aqui o altura do bloco
fontcolor="#FFFFFF";
fontsize="11px";
fontstyle="normal";
fontweight="normal";
fontfamily="Verdana,Tahoma,Helvetica";
//image="../../img/branco.gif";
//subimage="../../img/topo_lista_seta01.gif";
onborder="0px solid #FFCC00";//BORDA DE QUANDO O MOUSE PASSA
overfilter="Fade(duration=0.4);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
outfilter="randomdissolve(duration=0)";
//menubgimage="../../img/topo_bg_menuwinxp.gif";
}