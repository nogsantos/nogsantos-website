// JavaScript Document
function select_innerHTML(objeto, innerHTML)
{
/******
* select_innerHTML - corrige o bug do InnerHTML em selects no IE
* Veja o problema em: http://support. microsoft.com/default.aspx?scid=kb;en-us;276228
* Versão: 2.1 - 04/09/2007
* Autor: Micox - Náiron José C. Guimarães - micoxjcg@yahoo.com.br
* @objeto(tipo HTMLobject): o select a ser alterado
* @innerHTML(tipo string): o novo valor do innerHTML
*******/
    objeto.innerHTML = ""
    var selTemp = document.createElement("micoxselect")
    var opt;
    selTemp.id="micoxselect1"
    document.body.appendChild(selTemp)
    selTemp = document.getElementById("micoxselect1")
    selTemp.style.display="none"
    if(innerHTML.toLowerCase().indexOf("<option")<0){//se não é option eu converto
        innerHTML = "<option>" + innerHTML + "</option>"
    }
    innerHTML = innerHTML.toLowerCase().replace(/<option/g,"<span").replace(/<\/option/g,"</span")
    selTemp.innerHTML = innerHTML
      
    
    for(var i=0;i<selTemp.childNodes.length;i++){
  var spantemp = selTemp.childNodes[i];
  
        if(spantemp.tagName){     
            opt = document.createElement("OPTION")
    
   if(document.all){ //IE
    objeto.add(opt)
   }else{
    objeto.appendChild(opt)
   }       
    
   //getting attributes
   for(var j=0; j<spantemp.attributes.length ; j++){
    var attrName = spantemp.attributes[j].nodeName;
    var attrVal = spantemp.attributes[j].nodeValue;
    if(attrVal){
     try{
      opt.setAttribute(attrName,attrVal);
      opt.setAttributeNode(spantemp.attributes[j].cloneNode(true));
     }catch(e){}
    }
   }
   //getting styles
   if(spantemp.style){
    for(var y in spantemp.style){
     try{opt.style[y] = spantemp.style[y];}catch(e){}
    }
   }
   //value and text
   opt.value = spantemp.getAttribute("value")
   opt.text = spantemp.innerHTML
   //IE
   opt.selected = spantemp.getAttribute('selected');
   opt.className = spantemp.className;
  } 
 }    
 document.body.removeChild(selTemp)
 selTemp = null
}
function addEvent( obj, type, fn ) 
{
  if ( obj.attachEvent ) 
  {
    obj['e'+type+fn] = fn;
    obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
    obj.attachEvent( 'on'+type, obj[type+fn] );
  } 
  else
  {
    obj.addEventListener( type, fn, false );
  }
}
function removeEvent( obj, type, fn ) 
{
  if ( obj.detachEvent ) 
  {
    obj.detachEvent( 'on'+type, obj[type+fn] );
    obj[type+fn] = null;
  } else
    obj.removeEventListener( type, fn, false );
}
function focusBlur()
{
	for(i=0; i<document.getElementsByTagName('input').length; i++)
	{
		if(!document.getElementsByTagName('input').item(i).readOnly && (document.getElementsByTagName('input').item(i).type=='text' || document.getElementsByTagName('input').item(i).type=='password'))
		{
			addEvent(document.getElementsByTagName('input').item(i), 'focus', function () { this.className = 'onFocus'; });
			addEvent(document.getElementsByTagName('input').item(i), 'blur', function () { this.className = 'onBlur'; });
		}
	}
	for(i=0; i<document.getElementsByTagName('textarea').length; i++)
	{
		if(!document.getElementsByTagName('textarea').item(i).readOnly)
		{
			addEvent(document.getElementsByTagName('textarea').item(i), 'focus', function () { this.className = 'onFocus'; });
			addEvent(document.getElementsByTagName('textarea').item(i), 'blur', function () { this.className = 'onBlur'; });
		}
	}
}
function submitForm(acao)
{
	document.forms[0].action += '&acao=' + acao;
	document.forms[0].submit();
}
function multiSelect(selectWithOptions, selectWithoutOptions, type)
{
	if(type=='sub')
	{
		for(i=0; i<selectWithOptions.length; i++)
		{
			if(selectWithOptions.options.item(i).selected)
			{
				selectWithoutOptions.appendChild(selectWithOptions.options.item(i));
			}
		}
	}
	else if(type == 'sum')
	{
		for(i=0; i<selectWithoutOptions.length; i++)
		{
			if(selectWithoutOptions.options.item(i).selected)
			{
				selectWithOptions.appendChild(selectWithoutOptions.options.item(i));
			}
		}
	}
}