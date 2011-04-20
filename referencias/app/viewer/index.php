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

$resReferencia = Referencia::consultarTodasReferencia();
?>
<html>
    <head>
        <title>Fabricio Nogueira</title>
    </head>
    <link rel="stylesheet" type="text/css" media="screen" href="../../public/css/estilo.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../public/css/custom.css" />
    <script type="text/javascript" src="../../public/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="../../public/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="../../public/js/jquery.tablesorter.pager.js"></script>
    <body>
        <? include("../../public/includes/inc.menu.php"); ?>
        <form method="post" action="exemplo.html" id="frm-filtro">
            <p>
                <label for="pesquisar">Pesquisar pela descrição</label>
                <input type="text" id="pesquisar" name="pesquisar" size="30" />
            </p>
        </form>
        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" value="1" id="marcar-todos" name="marcar-todos" /></th>
                    <th align="center" >ID</th>
                    <th align="center" >Tipo</th>
                    <th align="left">Url</th>
                    <th align="left">Descri&ccedil;&atilde;o</th>
                    <th align="center">Dt. Cadastro</th>
                    <th align="center">A&ccedil;&otilde;es</th>
                </tr>
            </thead>
            <tbody>
                <?for($i=0;$i<$resReferencia->getCount();$i++){?>
                <tr>
                    <td align="center"><input type="checkbox" value="1" name="marcar[]" /></td>
                    <td align="center"><?=$resReferencia->getValores($i, "numg_referencia")?></td>
                    <td align="center"><?=Tipo::consultaDescTipo($resReferencia->getValores($i, "numg_tipo"));?></td>
                    <td align="left"><a href="<?=$resReferencia->getValores($i, "desc_url")?>" target="_blank"><?=$resReferencia->getValores($i, "desc_url")?></a></td>
                    <td><?=$resReferencia->getValores($i, "desc_obs")?></td>
                    <td align="center"><?=Funcoes::FormataData($resReferencia->getValores($i, "data_cadastro"))?></td>
                    <td align="center">
                        <a href="../viewer/cadReferencia.php?numgReferencia=<?=$resReferencia->getValores($i, "numg_referencia")?>"><img src="../../public/imagens/edit.png" width="16" height="16" alt="Editar" title="Editar" /></a>
                        <a href="../controller/Referencia.controller.php?sFuncao=excluir&numgReferencia=<?=$resReferencia->getValores($i, "numg_referencia")?>"><img src="../../public/imagens/delete.png" width="16" height="16" alt="Deletar" title="Deletar" /></a>
                    </td>
                </tr>
                <?}?>
            </tbody>
        </table>
        <div id="pager" class="pager">
            <form>
                <span>
                        Exibir <select class="pagesize">
                        <option selected="selected"  value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option  value="40">40</option>
                    </select> registros
                </span>
                <img src="../../public/imagens/first.png" class="first"/>
                <img src="../../public/imagens/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="../../public/imagens/next.png" class="next"/>
                <img src="../../public/imagens/last.png" class="last"/>
            </form>
        </div>
        <script type="text/javascript">
            $(function(){

                $('table > tbody > tr:odd').addClass('odd');

                $('table > tbody > tr').hover(function(){
                    $(this).toggleClass('hover');
                });

                $('#marcar-todos').click(function(){
                    $('table > tbody > tr > td > :checkbox')
                    .attr('checked', $(this).is(':checked'))
                    .trigger('change');
                });

                $('table > tbody > tr > td > :checkbox').bind('click change', function(){
                    var tr = $(this).parent().parent();
                    if($(this).is(':checked')) $(tr).addClass('selected');
                    else $(tr).removeClass('selected');
                });

                $('form').submit(function(e){ e.preventDefault(); });

                $('#pesquisar').keydown(function(){
                    var encontrou = false;
                    var termo = $(this).val().toLowerCase();
                    $('table > tbody > tr').each(function(){
                        $(this).find('td').each(function(){
                            if($(this).text().toLowerCase().indexOf(termo) > -1) encontrou = true;
                        });
                        if(!encontrou) $(this).hide();
                        else $(this).show();
                        encontrou = false;
                    });
                });

                $("table")
                .tablesorter({
                    dateFormat: 'uk',
                    headers: {
                        0: {
                            sorter: false
                        },
                        5: {
                            sorter: false
                        }
                    }
                })
                .tablesorterPager({container: $("#pager")})
                .bind('sortEnd', function(){
                    $('table > tbody > tr').removeClass('odd');
                    $('table > tbody > tr:odd').addClass('odd');
                });

            });
        </script>
    </body>
</html>