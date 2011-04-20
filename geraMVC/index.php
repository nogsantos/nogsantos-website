<?php
require_once('require_class.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Gerador MVC</title>
        <link href="resource/estilo.css" 			rel="stylesheet" type="text/css" />

        <script language="javascript" type="text/javascript" src="resource/ajax.js"></script>
        <script language="javascript" type="text/javascript" src="resource/js.js"></script>
        <script language="javascript" type="text/javascript" src="resource/gerador.js"></script>
    </head>
    <body>
        <form action="controller/gerador/modulo.php?controle=gerador" method="post" enctype="multipart/form-data">
            <table align="center" cellpadding="0" cellspacing="0" border="0" width="740" class="tableDad">
                <tr>
                    <td>
                        <fieldset>
                            <legend>Gerador MVC</legend>
                            <table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" class="table">
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="2" border="0" width="100%" class="table">
                                            <tr>
                                                <td width="20%" align="right">
										Host:
                                                </td>
                                                <td width="80%" align="left">
                                                    <input type="text" name="host" id="host" maxlength="30" size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right">
										Db:
                                                </td>
                                                <td width="80%" align="left">
                                                    <input type="text" name="db" id="db" maxlength="30" size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right">
										User:
                                                </td>
                                                <td width="80%" align="left">
                                                    <input type="text" name="usr" id="usr" maxlength="30" size="30" onblur="document.getElementById('pwr').focus(); refreshDtaBase()" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right">
										Password:
                                                </td>
                                                <td width="80%" align="left">
                                                    <input type="password" name="pwr" id="pwr" maxlength="15" size="15" onblur="refreshDtaBase()" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right">
										Data Base:
                                                </td>
                                                <td width="80%" align="left">
                                                    <select name="dtaBases" id="dtaBases" onchange="refreshTables(this.value)"></select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right" valign="top">
										Tables:
                                                </td>
                                                <td align="left">
                                                    <table cellpadding="0" cellspacing="0" border="0" class="table">
                                                        <tr>
                                                            <td>
                                                                <select id="dtaBasesTables" multiple="multiple" style="height:130px; width:180px;"></select>
                                                            </td>
                                                            <td width="12"></td>
                                                            <td>
                                                                <img src="img/Next.png"  style="cursor:pointer;" onclick="multiSelect(document.getElementById('dtaBasesTables'), document.getElementById('tablesTheGenerator'), 'sub')"/>
                                                                <img src="img/Back.png"  style="cursor:pointer;" onclick="multiSelect(document.getElementById('dtaBasesTables'), document.getElementById('tablesTheGenerator'), 'sum')"/>
                                                            </td>
                                                            <td valign="top">
													Generator:
                                                            </td>
                                                            <td>
                                                                <select id="tablesTheGenerator" multiple="multiple" style="height:130px; width:180px;"></select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center"><input type="button" value="Generator Classes" onclick="generatorClass()" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
<script language="javascript" type="text/javascript">
    focusBlur();
</script>