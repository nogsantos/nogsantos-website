<?php

session_start();
if($_SESSION["USUARIO"] == ""){header("Location:../../index.php");}

require_once("../../public/Funcoes.php");
require_once("../dataBase/Resultset.php");
require_once("../dataBase/Oad.php");
require_once("../model/Referencia.model.php");

$sFuncao        = $_POST["sFuncao"]!="" ? $_POST["sFuncao"] : $_GET["sFuncao"] ;
$numgReferencia = $_POST["numgReferencia"] ? $_POST["numgReferencia"] : $_GET["numgReferencia"] ;
switch ($sFuncao) {
    case "cadastrar":
        $oReferencia = new Referencia();
        $oReferencia->setNumgTipo($_POST["numgTipo"]);
        $oReferencia->setDescUrl($_POST["descUrl"]);
        $oReferencia->setDescObs($_POST["descObs"]);
        $oReferencia->cadastrarReferencia();
        header("Location:../viewer/index.php");
    break;
    case "editar":
        $oReferencia = new Referencia();
        $oReferencia->setNumgReferencia($numgReferencia);
        $oReferencia->setNumgTipo($_POST["numgTipo"]);
        $oReferencia->setDescUrl($_POST["descUrl"]);
        $oReferencia->setDescObs($_POST["descObs"]);
        $oReferencia->editarReferencia();
        header("Location:../viewer/index.php");
    break;
    case "excluir":
        $oReferencia = new Referencia();
        $oReferencia->setNumgReferencia($numgReferencia);
        $oReferencia->excluirReferencia();
        header("Location:../viewer/index.php");
    break;

    default:header("Location:../viewer/cadReferencia.php");break;
}