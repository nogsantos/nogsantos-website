<?

function geraInicioPhp($caminhoClasse,$autor,$objeto,$idFormulario){

	$campoNoBanco = substr($idFormulario,0,4)."_".strtolower(substr($idFormulario,4));
	$classe = basename($caminhoClasse);
	$vClasse = explode(".",$classe);
	$classe = $vClasse[0];
	
	$inicioPhp = '<?php'."\n";
	$inicioPhp .= 'include_once("funcoes.php");'."\n";
	$inicioPhp .= 'include_once("'.$caminhoClasse.'");'."\n\n";
	$inicioPhp .= '/**'."\n";
	$inicioPhp .= ' * Empresa: Interagi Tecnologia'."\n";
	$inicioPhp .= ' * Descrição:'."\n";
	$inicioPhp .= ' * Releases (Data, responsável e descrição [Último release primeiro]):'."\n";
	$inicioPhp .= ' * '.date("d/m/Y").' ('.$autor.')'."\n";
	$inicioPhp .= ' * Incluído este cabeçalho descrevendo a funcionalidade da página'."\n";
	$inicioPhp .= '*/'."\n\n";
	$inicioPhp .= '//instancia o objeto '."\n";
	$inicioPhp .= '$o'.$objeto.' = new '.$classe.'();'."\n\n";
	$inicioPhp .= '//ID'."\n";
	$inicioPhp .= 'if ($_GET["'.$campoNoBanco.'"] != "") {'."\n";
	$inicioPhp .= "\t".'$o'.$objeto.'->setarDados($_GET["'.$campoNoBanco.'"]);'."\n";
	$inicioPhp .= '}'."\n";
	$inicioPhp .= '?>'."\n";
	
	return $inicioPhp;
}

function geraInicioHtml(){
	$inicioHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
	$inicioHtml .= '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
	$inicioHtml .= '<head>' . "\n";
	$inicioHtml .= '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />' . "\n";
	$inicioHtml .= '<title></title>' . "\n";
	$inicioHtml .= '</head>' . "\n";
	$inicioHtml .= '<body>';
	return $inicioHtml;
}

function geraFimHtml(){
	$fimHtml .= '</body>' . "\n";
	$fimHtml .= '</html>';
	return $fimHtml;
}

function getCampos($arquivo) {
	$file = file($arquivo);
	for ($i=0;$i<count($file);$i++) {
		$campos[$i] = trim($file[$i]);
		$campos[$i] = str_replace('$','',$campos[$i]);
	}
	return $campos;
}

function geraInicioForm($actionForm,$objeto,$idFormulario){
	$inicioForm = '<form name="form" id="form" action="'.$actionForm.'" method="post">' . "\n";
	$inicioForm .= '<input type="hidden" name="'.$idFormulario.'" id="'.$idFormulario.'" value="<?=$o'.$objeto.'->get'.strtoupper($idFormulario{0}).substr($idFormulario,1).'()?>" />';
	return 	$inicioForm;
}

function geraInicioTabela(){
	return '<table border="0" cellpadding="0" cellspacing="0">';	
}

function geraLinhasTabela($vCampos,$idFormulario,$objeto){
	for($i=0;$i<count($vCampos);$i++){
		if($vCampos[$i] != $idFormulario){
			$trInicio = "\n<tr>\n";
			$tdInicio = "<td>";
			$conteudo = $vCampos[$i];
			$tdFim = "</td>\n";
			$trFim = "</tr>";
			$linha .= $trInicio.$tdInicio.$conteudo.$tdFim.$trFim;				
			$trInicio = "\n<tr>\n";
			$tdInicio = "<td>";
			$conteudo = montaCampo($vCampos[$i],$idFormulario,$objeto);
			$tdFim = "</td>\n";
			$trFim = "</tr>";			
			$linha .= $trInicio.$tdInicio.$conteudo.$tdFim.$trFim;
		}
	}
	
	return $linha;
}

function geraFimTabela(){
	return '</table>';	
}

function geraFimForm(){
	return '</form>';	
}

function getTipo($campo) {	
	return strtolower(substr($campo,0,4));
}

function montaCampo($campo,$idFormulario,$objeto){	
	$tipo = getTipo($campo);
	if (stristr($campo,'cpf')) $tipo = '';
	if (stristr($campo,'cnpj')) $tipo = '';
	if (stristr($campo,'fone')) $tipo = '';
	if (stristr($campo,'fax')) $tipo = '';
	if (stristr($campo,'cep')) $tipo = '';
	if (stristr($campo,'data')) $tipo = '';	
	if (stristr($campo,'hora')) $tipo = '';		
	if (stristr($campo,'desc')) $tipo = '';
	if (stristr($campo,'endereco')) $tipo = '';
	if (stristr($campo,'sexo')) $tipo = 'numr';
	if (stristr($campo,'senha')) $tipo = 'senha';
	switch($tipo){
		case "flag":
			return '<input type="checkbox" id="'.$campo.'" name="'.$campo.'" <?php if($o'.$objeto.'->get'.strtoupper(substr($campo,0,1)).substr($campo,1).'){echo " checked"}?>/>'.$campo;
			break;
		case "numg":			
			return '<select id="'.$campo.'" name="'.$campo.'"><option value="<?=$o'.$objeto.'->get'.strtoupper(substr($campo,0,1)).substr($campo,1).'()?>">'.strtoupper(substr($campo,0,1)).substr($campo,1).'</option></select>';
			break;
		case "numr":
			return '<select id="'.$campo.'" name="'.$campo.'"><option value="<?=$o'.$objeto.'->get'.strtoupper(substr($campo,0,1)).substr($campo,1).'()?>">'.strtoupper(substr($campo,0,1)).substr($campo,1).'</option></select>';
			break;
		case "senha":
			return '<input type="password" name="'.$campo.'" id="'.$campo.'" value="<?=$o'.$objeto.'->get'.strtoupper(substr($campo,0,1)).substr($campo,1).'()?>" />';
			break;
		default:
			return '<input type="text" name="'.$campo.'" id="'.$campo.'" value="<?=$o'.$objeto.'->get'.strtoupper(substr($campo,0,1)).substr($campo,1).'()?>" />';
	}
}

if (isset($_FILES['file']['name'])) {

	$vCampos = getCampos($_FILES['file']['name']);
	
	$idFormulario = trim($_POST["idFormulario"]);
	$caminhoClasse = trim($_POST["caminhoClasse"]);
	$autor = trim($_POST["autor"]);
	$objeto = trim($_POST["objeto"]);
	
	$sTextArea = '<textarea cols="100%" rows="20">';
	$sTextArea .= geraInicioPhp($caminhoClasse,$autor,$objeto,$idFormulario);
	$sTextArea .= geraInicioHtml() . "\n";
	$sTextArea .= geraInicioForm($_POST["actionform"],$objeto,$idFormulario) . "\n";
	$sTextArea .= geraInicioTabela();
	$sTextArea .= geraLinhasTabela($vCampos,$idFormulario,$objeto) . "\n";
	$sTextArea .= geraFimTabela() . "\n";
	$sTextArea .= geraFimForm() . "\n";;
	$sTextArea .= geraFimHtml();
	$sTextArea .= '</textarea>';
	
	echo $sTextArea;
}

?>
<form action="FormularioGenerator.php" method="post" enctype="multipart/form-data" name="form1">
  
  <font size="1" face="Fixedsys">
  <input type="file" name="file"><br />
  Action:<br />
  <input type="text" name="actionform"><br />
  Objeto no cad:<br />
  <input type="text" name="objeto"><br />
  ID do formulário:<br />
  <input type="text" name="idFormulario"><br />
  Caminho da Classe:<br />
  <input type="text" name="caminhoClasse"><br />
  Autor:<br />
  <input type="text" name="autor"><br />
  <input type="submit" name="Submit" value="Submit">
  </font>
</form>