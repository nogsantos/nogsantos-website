<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="botoesHome">
    <div id="radio">
        <button id="home">Home</button>
        <button id="curriculo">Curriculo</button>
        <button id="contato">Contato</button>
        <button id="pessoal">Pessoal</button>
    </div>
    <div id="barraFerramentas" style="text-align: center;vertical-align: middle;">
        <table border="0" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <td valign="middle" align="right"><div id="printDiv" onclick="PrintElementID('descConteudo',  'janela');" ><img src="imagens/print.png" border="0" alt="Imprimir Conteúdo" title="Imprimir Conteúdo" width="32" height="32" ></div></td>
                <td valign="middle" align="right"><div id="favourito" onclick="addFav();" ><img src="imagens/favoritit.png" border="0" alt="Adicionar aos Favoritos" title="Adicionar aos Favoritos" width="32" height="32" ></div></td>
                <td valign="middle" align="right"><div id="reduz_fonte"><img src="imagens/decrease-font.png" border="0" alt="Diminuir fonte" title="Diminuir fonte" width="32" height="32" ></div></td>
                <td valign="middle" align="left"><div id="aumenta_fonte"><img src="imagens/increase-font.png" border="0" alt="Aumentar fonte" title="Aumentar fonte" width="32" height="32" ></div></td>
            </tr>
        </table>
    </div>
</div>