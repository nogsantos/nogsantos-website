<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../../public/Funcoes.php");
require_once("../dataBase/Resultset.php");
require_once("../dataBase/Oad.php");
require_once("../model/Tipo.model.php");

$numgTipo = $_GET["numgTipo"]!="" ? $_GET["numgTipo"] : "";
$oTipo    = new Tipo();
$resTipo  = new Resultset();
if($numgTipo!=""){
    $resTipo = $oTipo->consultaTipo($numgTipo);
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
        <title>Fabricio Nogueira  - Cadastro de Tipos</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../../public/css/estilo.css" />
        <script type="text/javascript" src="../../public/js/jquery-1.5.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#btNovo").click(function(){
                    document.location = "cadTipo.php";
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
        <h1>Cadastro de Tipos</h1>
        <?if($msg!=""){?>
        <div style="width: 100%;text-align: left;color: blue"><?=$msg?></div>
        <?}?>
        <form name="form" id="form" method="post" action="../controller/Tipo.controller.php">
            <input type="hidden" name="sFuncao" id="sFuncao" value="" />
            <input type="hidden" name="numgTipo" id="numgTipo" value="<?=$numgTipo?>" />
            <div id="divMain">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                    <tr>
                        <td>
                            Codigo Tipo<br />
                            <input type="text" name="descTipo" id="descTipo" value="<?=$resTipo->getValores(0, "desc_tipo")?>" size="102" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Observa&ccedil;&atilde;o<br />
                            <textarea name="descObs" id="descObs" cols="100" rows="20"><?=$resTipo->getValores(0, "desc_obs")?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="left">
                            <?if($numgTipo==""){?>
                                <input type="button" id="btCadastrar" class="botao" value="Cadastrar" />
                            <?}else{?>
                                <input type="button" id="btNovo" class="botao" value="Novo Tipo" />
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