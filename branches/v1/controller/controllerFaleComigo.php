<?php
/**
 * Descrição: Controller Fale Comigo
 */
require_once("../model/mime/htmlMimeMail.php");
require_once("../model/modelFaleComigo.php");

$oFaleComigo = new FaleComigo();
$oFaleComigo->setNomeEmpresa($_POST["txtNomeEmpresa"]);
$oFaleComigo->setContato($_POST["txtContato"]);
$oFaleComigo->setEmail($_POST["txtEmail"]);
$oFaleComigo->setMensagem($_POST["txtMensagem"]);
$oFaleComigo->setData(date("d/m/Y"));
$oFaleComigo->enviarMensagem();
if(true){
    header("Location:../site.php?secao=contato&msg=OK");
}else{
    header("Location:../site.php?secao=contato&msg=FAIL");
}