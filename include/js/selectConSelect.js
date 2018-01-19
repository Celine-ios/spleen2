var SELECTCONSELECT = {
	
	agregarFormaPago:function(idOrigen,idDestino){
		var objOrigen = document.getElementById(idOrigen);
		var cantOrigen = objOrigen.options.length;
		var objDestino = document.getElementById(idDestino);
		cantOrigen--;
		for(var i = cantOrigen;i>=0;i--){
			var eleccion = objOrigen.options[i];
			if(eleccion.selected){
				var cantDestino = objDestino.options.length;
				objDestino.options[cantDestino] = new Option(eleccion.text,eleccion.value);
				SELECTCONSELECT.modif(eleccion.value)
				objOrigen.options[i] = null;
			}
		}
	},
	
	modif:function(valor){
		var objDestino2 = document.getElementById("pc_f2");
		var valores = objDestino2.value.split("#");
		var cant = valores.length;
		var valFinal = "";
		var encontro = false;
		for(var i=0;i<cant;i++){
			if(valores[i] == valor)
				encontro = true;
			else
				if(valores[i]!="")
					valFinal += "#"+valores[i];
		}
		if(!encontro)
				valFinal += "#"+valor;

		objDestino2.value = "";
		objDestino2.value = valFinal;
	},

	agregarTodo:function(idOrigen,idDestino){
		var objOrigen = document.getElementById(idOrigen);
		var cantOrigen = objOrigen.options.length;
		var objDestino = document.getElementById(idDestino);
		for(var i = 0;i<cantOrigen;i++){
			var eleccion = objOrigen.options[i];
			var cantDestino = objDestino.options.length;
			objDestino.options[cantDestino] = new Option(eleccion.text,eleccion.value);
			SELECTCONSELECT.modif(eleccion.value)
		}
		objOrigen.options.length = null;
	}

}