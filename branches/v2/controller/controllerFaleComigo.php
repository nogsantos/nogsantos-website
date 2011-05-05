<?php
/**
 * Descrição: Controller Fale Comigo
 */
require_once("../model/mime/htmlMimeMail.php");
require_once("../model/modelFaleComigo.php");

if($_POST['txtNomeEmpresa']!=""&&$_POST['txtEmail']!=""&&$_POST['txtMensagem']!=""){
    $oFaleComigo = new FaleComigo();
    $oFaleComigo->setNomeEmpresa($_POST["txtNomeEmpresa"]);
    $oFaleComigo->setContato($_POST["txtContato"]);
    $oFaleComigo->setEmail($_POST["txtEmail"]);
    $oFaleComigo->setMensagem($_POST["txtMensagem"]);
    $oFaleComigo->setData(date("d/m/Y"));
    if($oFaleComigo->enviarMensagem()){
        header("Location:../site.php?secao=contato&msg=OK");
    }else{
        header("Location:../site.php?secao=contato&msg=FAIL");
    }
}else{
    header("Location:../site.php?secao=contato&msg=NULL");
}
