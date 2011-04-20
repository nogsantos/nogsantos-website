<?php

session_start();
if($_SESSION["USUARIO"] == ""){header("Location:../../index.php");}

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../../public/Funcoes.php");
require_once("../dataBase/Resultset.php");
require_once("../dataBase/Oad.php");
require_once("../model/Tipo.model.php");
require_once("../model/Referencia.model.php");

$oReferencia   = new Referencia();
$resReferencia = new Resultset();
$oTipos        = new Tipo();
$resTipos      = new Resultset();
$resTipos      = $oTipos->consultaTodosTipo();

$numgReferencia = $_GET["numgReferencia"]!="" ? $_GET["numgReferencia"] : "" ;

if($numgReferencia!=""){
    $resReferencia = $oReferencia->consultarReferencia($numgReferencia);
}

switch ($_GET["msg"]) {
    case 1:$msg  = "Cadastro realizado.";break;
    case 2:$msg  = "Edição realizada.";break;
    case 3:$msg  = "Exclusão realizada.";break;
    default:$msg = "";break;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;">
        <title>Fabricio Nogueira  - Cadastro das referências</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../../public/css/estilo.css" />
        <script type="text/javascript" src="../../public/js/jquery-1.5.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#btNovo").click(function(){
                    document.location = "cadReferencia.php";
                });
                $("#btCadastrar").click(function(){
                    $("#sFuncao").val("cadastrar");
                    form.submit();
                });
                $("#btEditar").click(function(){
                    $("#sFuncao").val("editar");
                    form.submit();
                });
                $("#btExcluir").click(function(){
                    $("#sFuncao").val("excluir");
                    form.submit();
                });
            });
        </script>
    </head>
    <body>
        <?include("../../public/includes/inc.menu.php");?>
        <h1>Cadastro de referências</h1>
        <?if($msg!=""){?>
        <div style="width: 100%;text-align: left;color: blue"><?=$msg?></div>
        <?}?>
        <form name="form" id="form" method="post" action="../controller/Referencia.controller.php">
            <input type="hidden" name="sFuncao" id="sFuncao" value="" />
            <input type="hidden" name="numgReferencia" id="numgReferencia" value="<?=$numgReferencia?>" />
            <div id="divMain">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                    <tr>
                        <td >
                            Tipo<br />
                            <select name="numgTipo" id="numgTipo" style="width:840px;">
                                <?Funcoes::montaCombo($resTipos, "numg_tipo", "desc_tipo", $resReferencia->getValores(0, "numg_tipo"),true)?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Url<br />
                            <input type="text" name="descUrl" id="descUrl" value="<?=$resReferencia->getValores(0, "desc_url")?>" size="102"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Observa&ccedil;&atilde;o<br />
                            <textarea name="descObs" id="descObs" cols="100" rows="20"><?=$resReferencia->getValores(0, "desc_obs")?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="left">
                            <?if($numgReferencia==""){?>
                                <input type="button" id="btCadastrar" class="botao" value="Cadastrar" />
                            <?}else{?>
                                <input type="button" id="btNovo" class="botao" value="Nova Referencia" />
                                <input type="button" id="btEditar" class="botao" value="Editar" />
                                <input type="button" id="btExcluir" class="botao" value="Excluir" />
                            <?}?>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </body>
</html>