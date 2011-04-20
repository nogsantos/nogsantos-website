// JavaScript Document
function refreshDtaBase()
{
		host 	= document.getElementById('host').value;
		db 		= document.getElementById('db').value;
		usr 	= document.getElementById('usr').value;
		pwr 	= document.getElementById('pwr').value;
	var params  = 'host=' + host;
		params += '&db='  + db;
		params += '&usr=' + usr;
		params += '&pwr=' + pwr;
	postText('controller/gerador/modulo.php?controle=dtaBase', params, returnRefreshDtaBase);
}
function returnRefreshDtaBase(Html)
{
	select_innerHTML(document.getElementById('dtaBases'), Html);
}
function refreshTables(db)
{
		host 	= document.getElementById('host').value;
		db 		= document.getElementById('db').value;
		usr 	= document.getElementById('usr').value;
		pwr 	= document.getElementById('pwr').value;
		dbs		= document.getElementById('dtaBases').value;
	var params  = 'host=' + host;
		params += '&db='  + db;
		params += '&usr=' + usr;
		params += '&pwr=' + pwr;
		params += '&dbs=' + dbs;
	postText('controller/gerador/modulo.php?controle=tables', params, returnRefreshTables);
}
function returnRefreshTables(Html)
{
	select_innerHTML(document.getElementById('dtaBasesTables'), Html);
}
function generatorClass()
{
		host 	= document.getElementById('host').value;
		usr 	= document.getElementById('usr').value;
		pwr 	= document.getElementById('pwr').value;
		db 		= document.getElementById('dtaBases').value;
		dbs		= document.getElementById('db').value;
		tables	= document.getElementById('tablesTheGenerator');
	var params  = 'host=' + host;
		params += '&usr=' + usr;
		params += '&pwr=' + pwr;
		params += '&db='  + db;
		params += '&dbs='  + dbs;
	for(i=0; i<tables.length; i++)
	{
		if(tables.options.item(i).selected)
			params += '&tables[]='  + tables.options.item(i).value;
	}
	postText('controller/gerador/modulo.php?controle=gerador', params, returnGeneratorClass);
}
function returnGeneratorClass(Html)
{
//	alert(Html);
	eval(Html);
}