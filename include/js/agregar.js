var AGREGAR = {

	cant: 1,
	
	add: function(nombre){
	
		var div = document.createElement('div');
		var labels = document.createElement('label');
		var campo = document.createElement('input');
		var vinculo = document.createElement('a');
		var vinculo_texto = document.createTextNode("Borrar");
		var vinculo2 = document.createElement('a');
		var vinculo_texto2 = document.createTextNode("Eliminar");
		
		var dclass = document.createAttribute('class');
		var ctype = document.createAttribute('type');
		var cname = document.createAttribute('name');
		var cid = document.createAttribute('id');
		var vhref = document.createAttribute('href');
		var vclick = document.createAttribute('onclick');
		
		dclass.value = 'file';
		ctype.value = 'file';
		cname.value = 'arch[]';
		cid.value = nombre+AGREGAR.cant;
		vhref.value = "#";
		vclick.value = "AGREGAR.borrar('"+nombre+"',"+AGREGAR.cant+"); return false;";
		
		div.setAttributeNode(dclass);
		campo.setAttributeNode(ctype);
		campo.setAttributeNode(cname);
		campo.setAttributeNode(cid);
		vinculo.setAttributeNode(vhref);
		vinculo.setAttributeNode(vclick);
		
		labels.innerHTML = nombre+" "+AGREGAR.cant;
		
		div.appendChild(labels);
		div.appendChild(campo);
		vinculo.appendChild(vinculo_texto);	
		div.appendChild(vinculo);

		var antes = document.getElementById("agregar");

		antes.parentNode.insertBefore(div, antes);	
		
		AGREGAR.cant++;

	},
	
	borrar: function(nombre, num){
		document.getElementById(nombre+num).value="";
	}
	
}

//if(document.getElementsByTagName) KRNLDOM.addEvent(window, 'load', INPUTS.start, false);