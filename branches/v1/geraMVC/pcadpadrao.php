<?php
/**
 * Empresa:
 * Descrição:
 * Releases (Data, responsável e descrição [Último release primeiro]):
 * xx/xx/xxxx (autor), (descrição da atividade)
 * Incluído este cabeçalho descrevendo a funcionalidade da página
 */
require_once ("funcoes.php");
require_once ("classes/Classe.php");

if (empty($_SESSION["NUMG_OPERADOR"]) || $_SESSION["NUMG_OPERADOR"] == "") {
    header("Location: expirou.htm");
    exit;
}
switch ($_POST["sFuncao"]) {
    case "cadastrar_entidade":
        $objeto = new Classe();
        //Atributos da classe
        $objeto->setPropriedade($_POST["nomeCampo"]);
        $objeto->cadastrar();
        if (Erros::isError()) {MostraErros();}
        else {
            header("Location: formulario.php?msg=CADASTRAR_OK&numg_objeto=" . $objeto->getNumgObjeto());
        }
    break;
    case "editar_entidade":
        $objeto = new Classe();
        //Atributos da classe
        $objeto->setPropriedade($_POST["nomeCampo"]);
        $objeto->editar();
        if (Erros::isError()) {
            MostraErros();
        } else {
            header("Location: formulario.php?msg=EDITAR_OK&numg_objeto=" . $objeto->getNumgObjeto());
            exit;
        }

        break;

    case "excluir_entidade":

        $objeto = new Classe();

        $objeto->excluir($_POST["numgObjeto"]);

        if (Erros::isError()) {
            MostraErros();
        } else {
            header("Location: formulario.php?msg=EXCLUIR_OK");
            exit;
        }

        break;

    default:
        header("Location: formulario.php");
        exit;
        break;
}
?>