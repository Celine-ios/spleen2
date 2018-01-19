var KRNLDOM = {
	//Event listener by Scott Andrew (www.scottandrew.com)
	addEvent: function(obj, evType, fn, useCapture){
		if(obj.addEventListener){
			obj.addEventListener(evType, fn, useCapture);
			return true;
		}else if(obj.attachEvent){
			var r = obj.attachEvent('on'+evType, fn);
			return r;
		}else{
			return false;
		}
	},
	//Method based on Disenorama (www.disenorama.com), which in turn is based in Dan Pupius' (pupius.co.uk)
	getElementByClass: function(className, node){
		if(!node) node=document;
		var refTags = document.all ? node.all : node.getElementsByTagName("*");
		var retVal = new Array();
		for(var z=0;z<refTags.length;z++){
			if(refTags[z].className==className)
				retVal.push(refTags[z]);
		}
		return retVal;
	},
	
	getLabelsByFor: function(str){
		var labels = document.getElementsByTagName('label');
		for(var j=0;j<labels.length;j++){
			if(labels[j].htmlFor==str){
				return labels[j];
				break;
			}
		}
	},
		
	getElementsByName: function(name, node){
		if(!node) node=document;
		var refTags = document.all ? node.all : node.getElementsByTagName("*");
		var retVal = new Array();
		for(var t=0;t<refTags.length;t++){
			if(refTags[t].getAttribute('name')==name)
				retVal.push(refTags[t]);
		}
		return retVal;		
	},

	getAbsolutePos: function(el) {
		var SL = 0, ST = 0;
		var is_div = /^div$/i.test(el.tagName);
		if (is_div && el.scrollLeft)
			SL = el.scrollLeft;
		if (is_div && el.scrollTop)
			ST = el.scrollTop;
		var r = { x: el.offsetLeft - SL, y: el.offsetTop - ST };
		if (el.offsetParent) {
			var tmp = this.getAbsolutePos(el.offsetParent);
			r.x += tmp.x;
			r.y += tmp.y;
		}
		return r;
	},
	
	getElementsByAttribute: function(attr, node){
        if(!node) node=document;
        var tags = document.all ? node.all : node.getElementsByTagName("*");
        var els = new Array();
        for(var t=0;t< tags.length;t++){
            if(tags[t].getAttribute(attr)!=null)
                els.push(tags[t]);
        }
        return els;
    },
	
	addStyleSheet: function(stylesheet){
		tagsHead = document.getElementsByTagName('head');
		for(var h=0;h<tagsHead.length;h++) {tagHead = tagsHead[h]}
		newStyleSheet = document.createElement('link');
		attrHREF = document.createAttribute('href');
		attrREL = document.createAttribute('rel');
		attrTYPE = document.createAttribute('type');
		attrHREF.value = stylesheet;
		attrREL.value = "stylesheet";
		attrTYPE.value = "text/css";
		newStyleSheet.setAttributeNode(attrHREF);
		newStyleSheet.setAttributeNode(attrREL);
		newStyleSheet.setAttributeNode(attrTYPE);				
		tagHead.appendChild(newStyleSheet);
	}
}