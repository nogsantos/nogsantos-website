// JavaScript Document
function postText(url , params, callback)
{
	try 
	{
	  ajax = new XMLHttpRequest();
	}
	catch(ee) 
	{
	  try 
	  {
		 ajax = new ActiveXObject('Msxml2.XMLHTTP');
	  }
	  catch(e) 
	  {
		 try 
		 {
			ajax = new ActiveXObject('Microsoft.XMLHTTP');
		 }
		 catch(E)
		 {
			ajax = false;
		 }
	  }
	}
	if(ajax)
	{
	   ajax.open('POST', url, true);
	   ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	   ajax.onreadystatechange = function() 
	   {
		  if (ajax.readyState == 4)
		  {
			 
			 /* L� o texto da p�gina que foi submetida */
			 /* Obs.: nessa p�gina eu retorno um javascript */
			 params = ajax.responseText;
			 /* O js que de retorno � executado no eval() */
			 callback(params);
		  }
	   }
	   /* Envia os dados contidos na variavel texto como se fosse uma parametros de um GET */
	   ajax.send(params);
	}
	else
	{
		alert('Este Broser N�o tem Suporte a Ajax');
	}
}