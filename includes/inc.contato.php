<?php
/**
 * Descrição: Formulário fale comigo
 */
if($_GET["msg"]!=""){
    switch ($_GET["msg"]) {
        case "OK":
            $msg = "Mensagem Enviada com Sucesso.";
        break;
        case "FAIL":
            $msg = "Falha no Envio da Mensagem.";
        break;
        case "NULL":
            $msg = "Por favor, preencha os campos marcados com (*) para enviar a mensagem.";
        break;
        default:$msg ="";break;
    }
}else{
    $msg ="";
}
?>
<div id="divContato">
    <div id="divTitle">Contato.</div>
    <div id="subTitle"><?php echo $msg?></div>
    <form class="cmxform" name="formFaleComigo" id="formFaleComigo" action="controller/controllerFaleComigo.php" method="post">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%">
                    <b>Nome / Empresa*</b><br>
                    <input type="text" name="txtNomeEmpresa" id="txtNomeEmpresa" size="50">
                </td>
                <td width="50%" rowspan="5" valign="top" align="left">
                    <div id="contatosFaleconosco">
                        Se você precisa de um website, um sistema web... ou sangue novo no seu time,
                        basta enviar uma mensagem. Preencha o formul&aacute;rio ao lado que retornarei o mais breve poss&iacute;vel.
                        Alternativamente, voc&ecirc; pode me enviar um <a href="mailto:fabricio@nogsantos.com.br">email</a> ou tamb&eacute;m utilizar algum dos canais abaixo para contato.
                        <br>
                        <div id="titleBarraContatos">
                            Online em algum lugar...
                        </div>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td valign="middle" align="center">
                                    <a href="http://www.facebook.com/?ref=home#!/profile.php?id=1651814885&amp;sk=info" target="_blank" style="color:white">
                                        <img src="imagens/facebook-32x32.png" width="32" height="32" title="FaceBook" alt="FaceBook">
                                    </a>
                                </td>
                                <td valign="middle" align="center">
                                    <a href="http://br.linkedin.com/pub/fabricio-nogueira/23/98b/8b9" target="_blank" style="color:white">
                                        <img src="imagens/linkedin-32x32.png" width="32" height="32" title="LinkedIn" alt="LinkedIn">
                                    </a>
                                </td>
                                <td  valign="middle" align="center">
                                    <a href="http://twitter.com/nogsantos" target="_blank" style="color:white">
                                        <img src="imagens/twitter-32x32.png" width="32" height="32" title="Twitter" alt="Twitter">
                                    </a>
                                </td>
                                <td valign="middle" align="center">
                                    <a href="http://www.skoob.com.br/usuario/309807" target="_blank" style="color:white">
                                        <img src="imagens/skoob-32x32.png" width="32" height="32" title="Skoob" alt="Skoob">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Contato<br>
                    <input type="text" name="txtContato" id="txtContato" size="50">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Email*</b><br>
                    <input type="text" name="txtEmail" id="txtEmail" size="50">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Mensagem*</b><br>
                    <textarea name="txtMensagem" id="txtMensagem" rows="1" cols="1" style="width:500px; height:190px;"></textarea>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding:10px 0 0 380px;">
                    <input type="submit" name="btEnviar" id="btEnviar" value="Enviar">
                    <input type="reset" name="btLimpar" id="btLimpar" value="Limpar">
                </td>
            </tr>
        </table>
    </form>
</div>