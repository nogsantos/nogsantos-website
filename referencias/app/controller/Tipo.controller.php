<?php

require_once("../../public/Funcoes.php");
require_once("../dataBase/Resultset.php");
require_once("../dataBase/Oad.php");
require_once("../model/Tipo.model.php");

switch ($_POST["sFuncao"]) {
    case "cadastrar":
        $oTipo = new Tipo();
        $oTipo->setDescTipo($_POST["descTipo"]);
        $oTipo->setDescObs($_POST["descObs"]);
        $oTipo->cadastrar();
        header("Location:../viewer/cadTipo.php?msg=1&numgTipo=".$oTipo->getNumgTipo());
    break;
    case "editar":
        $oTipo = new Tipo();
        $oTipo->setNumgTipo($_POST["numgTipo"]);
        $oTipo->setDescTipo($_POST["descTipo"]);
        $oTipo->setDescObs($_POST["descObs"]);
        $oTipo->editarTipo();
        header("Location:../viewer/cadTipo.php?msg=2&numgTipo={$_POST["numgTipo"]}");
    break;
    case "excluir":
        $oTipo = new Tipo();
        $oTipo->setNumgTipo($_POST["numgTipo"]);
        $oTipo->excluirTipo();
        header("Location:../viewer/cadTipo.php?msg=3");
    break;

    default:header("Location:../viewer/cadTipo.php");break;
}