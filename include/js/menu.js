var MENU = {
	
	zIndex: 100,
	claseName: "mop",
	menuAnt:"",
	idInterval: 0,
	idFade:0,
	desplazamiento: 25,
	
	start: function(){
		var els = KRNLDOM.getElementByClass(MENU.claseName);
		for(var i=0; i<els.length;i++){
			

			
		
			id = els[i].id.split("_");
			el = document.getElementById(id[0]+id[1]);
			if(el != null){
				els[i].onmouseover = MENU.mostrarMenu;
				els[i].onmouseout = MENU.ocultarMenu;
			}else{
				els[i].onmouseover = MENU.ocultarMenuActual;
			}
		}
	},
	
	mostrarMenu: function(){
		MENU.cancelarIdInterval();
		MENU.cancelarIdFade();
		MENU.ocultarMenuActual();
		MENU.mostrarMenuActual(this.id);
		return false;
	},
	
	ocultarMenu: function(){
		MENU.idInterval = window.setTimeout("MENU.fade(0,100)",1000);
		
	},
	
	ocultarMenuActual: function(){
		if(MENU.menuAnt !=""){
			id = MENU.menuAnt.split("_");
			el = document.getElementById(id2[0]+id2[1]);
			el.style.display = "none";
			el = document.getElementById(MENU.menuAnt);
			el.style.backgroundColor = "#f0f0f0";
			el2.style.color = "#888888";
		}
	},
	
	mostrarMenuActual:function(id){
		
		el2 = document.getElementById(id);
		var pos = KRNLDOM.getAbsolutePos(el2);
		el2.style.backgroundColor = "#2F6CA4";
		el2.style.color = "#ffffff";
		
		id2 = id.split("_");
		el = document.getElementById(id2[0]+id2[1]);
		el.style.display = "block";		
		el.style.left = pos.x+"px";
		el.style.top = (pos.y+MENU.desplazamiento)+"px";
		
		MENU.menuAnt = id;
		MENU.fade(1,0);
				
		el.onmouseover = MENU.cancelarIdInterval;
		el.onmouseout = MENU.ocultarMenu;
	},
	
	cancelarIdInterval: function(){
		window.clearTimeout(MENU.idInterval);
	},
	
	fade:function(tipo, nivel){
		
		id2 = MENU.menuAnt.split("_");
		el = document.getElementById(id2[0]+id2[1]);

		el.style.opacity = (nivel / 100);
    	el.style.MozOpacity = (nivel / 100);
	    el.style.KhtmlOpacity = (nivel / 100);
		el.style.filter = "alpha(opacity="+nivel+")"; 
		if(tipo){
			nivel += 10;
		}else{
			nivel -= 10;
		}
		if(nivel >= 100 || nivel <= 0){
			MENU.cancelarIdFade();
			if(nivel<=0){
				el.style.filter = "alpha(opacity=0)"; 
				MENU.ocultarMenuActual();
			}else{
				el.style.filter = "alpha(opacity=100)"; 
			}
		}else{
			MENU.idFade = window.setTimeout("MENU.fade("+tipo+","+nivel+")",30);
		}
	},
	
	cancelarIdFade: function(){
		window.clearTimeout(MENU.idFade);
	}
	
}

if(document.getElementsByTagName) KRNLDOM.addEvent(window, 'load', MENU.start, false);