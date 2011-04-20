<?
function geraPcad ($campos,$objeto) {
	for ($i=0;$i<count($campos);$i++) { 
		$pcad .= "\$o".$objeto."->set".converteNome($campos[$i])."(\$_POST[\"".$campos[$i]."\"]);<br>";
	}
	$pcad .="<br><br>";
	return $pcad;
}

function geraSet ($campos) {
	for ($i=0;$i<count($campos);$i++) { 
		$pset .= "\$this->".geraAtributo($campos[$i])." = \$oResult->getValores(0,\"".geraCampoSQL($campos[$i])."\");<br>";
	}
	$pset .="<br><br>";	
	return $pset;
}

function converteNome($campo) {
	//$primeiraLetra = $campo{3};
	$primeiraLetra = $campo{0};
	$primeiraLetra = strtoupper($primeiraLetra);
	$restoNome = substr($campo,1);
	$nomeConvertido = $primeiraLetra . $restoNome;
	return $nomeConvertido;
}

function getCampos($arquivo) {
	$file = file($arquivo);
	for ($i=0;$i<count($file);$i++) {
		$campos[$i] = trim($file[$i]);
		$campos[$i] = str_replace('$','',$campos[$i]);
	}
	return $campos;
}

function getTipo($campo) {
	//return strtolower(substr($campo,3,4));
	return strtolower(substr($campo,0,4));
}

function geraAtributo($campo) {	
	//return strtolower(substr($campo,3,1)).substr($campo,4);
	return $campo;
}

function geraListaAtributos($campos) {
	$atributos .= "&nbsp;&nbsp;&nbsp;&nbsp;protected $".geraAtributo($campos[0]).";<br>";
	for ($i=1;$i<count($campos);$i++) {	
		$atributos .= "&nbsp;&nbsp;&nbsp;&nbsp;private $".geraAtributo($campos[$i]).";<br>";
	}
	$atributos .= "<br><br>";
	return $atributos;
}

function insereValidacao($campo, $tipo) {	
	if (stristr($campo,'fone')) $tipo = '';
	if (stristr($campo,'fax')) $tipo = '';
	if (stristr($campo,'cep')) $tipo = '';
	if (stristr($campo,'hora')) $tipo = '';		
	if (stristr($campo,'desc')) $tipo = '';
	switch($tipo) {
		case 'numr':
			$validado = "FormataNumeroGravacao(\$this->".geraAtributo($campo).")";
		break;
		case 'flag':
			$validado = "FormataBool(\$this->".geraAtributo($campo).")";		
		break;
		case 'data':
			$validado = "FormataDataGravacao(\$this->".geraAtributo($campo).")";		
		break;
		default:
			$validado = "FormataStr(\$this->".geraAtributo($campo).")";		
		break;
	}
	return $validado;
}

function geraCampoSQL($campo) {
	//$sqlfaux1 = strtolower(substr($campo,3,4));
	$sqlfaux1 = substr($campo,0,4);
	//$sqlfield = $sqlfaux1.'_'.strtolower(substr($campo,7));
	$sqlfield = $sqlfaux1.'_'.strtolower(substr($campo,4));
	return $sqlfield;
}

function geraStrErro($atributo,$tipo) {
	switch($tipo) {
		case 'numr':
			$strErr = "Número de ".$atributo." Inválido";
		break;
		case 'flag':
			$strErr = $atributo." Inválido";	
		break;
		case 'data':
			$strErr = "Data de ".$atributo." Inválida";		
		break;
		default:
			$strErr = "Campo ".$atributo." Inválido";		
		break;
	}
	return $strErr;	
}

function geraFuncao($campos,$valida) {
	for ($i=0;$i<count($campos);$i++) {
		$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;function set".converteNome($campos[$i])."(\$valor) {<br>";
		if (getTipo($campos[$i]) == "numr") {
			if (!$valida) $funcoes .= "//"; $funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (is_numeric(\$valor)) {<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \$valor;<br>";
		} elseif ((getTipo($campos[$i]) != "flag")&&(stristr($campos[$i],'chk'))) {
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (\$valor != NULL) {<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = implode(\",\",\$valor);<br>";
		} elseif ((getTipo($campos[$i]) == "flag")&&(stristr($campos[$i],'chk'))) {
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (FormataBool(\$valor) == \"true\") {<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \$valor;<br>";
		} else {
			if (!$valida) $funcoes .= "//"; $funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (\$valor != \"\") {<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \$valor;<br>";
		}

		if ((getTipo($campos[$i]) == "flag")&&(stristr($campos[$i],'chk'))) {
			//$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \"false\";<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} else {<br>";
		} else {
			if (!$valida) $funcoes .= "//"; $funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} else {<br>";
		}

		if ((getTipo($campos[$i]) == "flag")&&(stristr($campos[$i],'chk'))) {
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \"false\";<br>";
		} else if ((getTipo($campos[$i]) != "flag")&&(stristr($campos[$i],'chk'))) {
			//$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \"false\";<br>";
		} else {		
			if (!$valida) $funcoes .= "//"; $funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erros::addErro(\"".geraStrErro($campos[$i],getTipo($campos[$i])).".ß\");<br>";
		}
		if (stristr($campos[$i],'chk')) {
			//$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this->".geraAtributo($campos[$i])." = \"false\";<br>";
			$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>";
		} else {
			if (!$valida) $funcoes .= "//"; $funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>";
		}
		$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>";
		if ((getTipo($campos[$i]) != "flag")&&(stristr($campos[$i],'chk'))) {
		$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;function get".converteNome($campos[$i])."() { return explode(\",\",\$this->".geraAtributo($campos[$i]).");}<br><br>";
		} else {
		$funcoes .= "&nbsp;&nbsp;&nbsp;&nbsp;function get".converteNome($campos[$i])."() { return \$this->".geraAtributo($campos[$i]).";}<br><br>";
		}
		$funcoes .= "<br>";
	}
	return $funcoes;
}

function geraSelect($campos,$tb) {
	$select = "\$sSql = \"SELECT \";<br>";
	$i = 0;
	while ($i<count($campos)) {
		$select .= "\$sSql .= \" ";
		for ($j=0;($j<=4)&&($i<count($campos));$j++) {
			$select .= geraCampoSQL($campos[$i]);
			if (($j <= 4)&&($i<count($campos)-1)) $select .= ", ";
			$i++;
		}
		$select .= "\";<br>";
	}
	$select .= "\$sSql .= \" FROM ".$tb."\";<br>";
	$select .= "//Descomente se houver condição WHERE:<br>";	
	$select .= "//\$sSql .= \" WHERE ".geraCampoSQL($campos[0])." = \".\$n".converteNome($campos[0]).";<br><br>";	
	return $select;
}

function geraInsert($campos,$tb) {
	$insert = "\$sSql = \"INSERT INTO ".$tb." (\";<br>";
	$i = 0;
	while ($i<count($campos)) {
		$insert .= "\$sSql .= \" ";
		for ($j=0;($j<=4)&&($i<count($campos));$j++) {
			$insert .= geraCampoSQL($campos[$i]);
			if (($j <= 4)&&($i<count($campos)-1)) $insert .= ", ";
			$i++;
		}
		$insert .= "\";<br>";
	}
	$insert .= "\$sSql .= \") VALUES (\";<br>";

	//Gera Valores

	$i = 0;
	while ($i<count($campos)) {
		$insert .= "\$sSql .= \"";
		for ($j=0;($j<=1)&&($i<count($campos));$j++) {
			$insert .= "\".".insereValidacao($campos[$i],getTipo($campos[$i])).".\"";
			if (($j <= 1)&&($i<count($campos)-1)) $insert .= ", ";
			$i++;
		}
		$insert .= "\";<br>";
	}	

	$insert .= "\$sSql .= \")\";<br><br>";

	$insert = ereg_replace('.= "".','.= ' ,$insert );
	$insert = ereg_replace('.""','' ,$insert );

	return $insert;
}

function geraUpdate($campos,$tb) {
	$update = "\$sSql = \"UPDATE ".$tb." SET \";<br>";
	$i = 1;
	while ($i<count($campos)) {
		$update .= "\$sSql .= \" ";
		for ($j=0;($j<=0)&&($i<count($campos));$j++) {
			$update .= geraCampoSQL($campos[$i])." = \".".insereValidacao($campos[$i],getTipo($campos[$i])).".\"";
			if (($j <= 0)&&($i<count($campos)-1)) $update .= ",";
			$i++;
		}
		$update .= "\";<br>";
	}
	$update .= "\$sSql .= \" WHERE  ".geraCampoSQL($campos[0])." = \".\$this->".geraAtributo($campos[0]).";<br><br>";
	$update = ereg_replace('.""','' ,$update );
	return $update;
}


//$_FILES['file']['name'] = "camposServEquipTur.txt";
//$_POST['tb'] = "tb_servequiptur";
//$_POST['objeto'] = "ServEquipTur";

if (isset($_FILES['file']['name'])) {

	$vCampos = getCampos($_FILES['file']['name']);

	if (isset($_POST['valida'])) {
		$valida = true;
	}else{
		$valida = false;
	}
	
	$sFuncoes = geraFuncao($vCampos,$valida);
	$sSelect = geraSelect($vCampos,$_POST['tb']);
	$sInsert = geraInsert($vCampos,$_POST['tb']);
	$sUpdate = geraUpdate($vCampos,$_POST['tb']);
	$sAtributos = geraListaAtributos($vCampos);
	$sPcad = geraPcad($vCampos,$_POST['objeto']);
	$sSet = geraSet($vCampos);
	
	echo "<font face=\"Courier New, Courier, mono\" size=\"2\"><p>";
	echo "//<b>Atributos</b><br><br>";
	echo $sAtributos;
	echo "//<b>Funções:</b><br><br>";
	echo $sFuncoes;
	echo "//<b>SQL Select: (Para funções setarDados ou Busca)</b><br><br>";
	echo $sSelect;
	echo "//<b>SQL Insert:</b><br><br>";
	echo $sInsert;
	echo "//<b>SQL Update:</b><br><br>";	
	echo $sUpdate;
	echo "//<b>Comandos para função SetarDados:</b><br><br>";	
	echo $sSet;
	echo "//<b>Comandos para Pcad:</b><br><br>";	
	echo $sPcad;

	echo "</p></font>";
}

?>
<form action="ClassGenerator.php" method="post" enctype="multipart/form-data" name="form1">
  
  <font size="1" face="Fixedsys">
  <input type="file" name="file">
  Tabela no banco:
  <input type="text" name="tb">
  Objeto no pcad:
  <input type="text" name="objeto">  
  Valida?
  <input name="valida" type="checkbox" id="valida" value="true">
  <input type="submit" name="Submit" value="Submit">
  </font>
</form>