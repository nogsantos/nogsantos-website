<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Funcoes {
    public function anti_sql_injection($string) {
        $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
        $string = pg_escape_string($string);
        return $string;
    }
    public function FormataStr($str) {
        if ($str == "") {
            $str = "null";
        } else {
            $str = self::anti_sql_injection(trim($str));
            $str = "'" . $str . "'";
        }
        return $str;
    }

    public function FormataBool($valor) {
        if (trim($valor) == "") {
            return "NULL";
        } else if ((trim($valor) == 't') || (trim($valor) == 'true') || (trim($valor) == 'y') || (trim($valor) == 'yes') || (trim($valor) == '1')) {
            return "'t'";
        } else if ((trim($valor) == 'f') || (trim($valor) == 'false') || (trim($valor) == 'n') || (trim($valor) == 'no') || (trim($valor) == '0')) {
            return "'f'";
        }
    }

    public function FormataData($vData) {
        if ($vData == "") {
            return false;
        } else {
            return date("d/m/Y", strtotime(substr($vData, 0, 19)));
        }
    }

    public function FormataDataGravacao($vData) {
        if (trim($vData) == "") {
            return "null";
        } else {
            $vData = ereg_replace("/", "-", $vData);
            $vData = trim($vData);
            $pos = strpos($vData, "-");

            if ($pos === 2) {
                $vXchange = explode("-", $vData); //10-10-2005 12:12:12
                $vXchangeAux = explode(" ", $vXchange[2]); //
                $vData = $vXchangeAux[0] . "-" . $vXchange[1] . "-" . $vXchange[0] . " " . $vXchangeAux[1];
            }
            $vTime = null;
            $vData = explode("-", $vData);
            if (strlen($vData[1]) == 1) {
                $vData[1] = "0" . $vData[1];
            }
            if (strlen($vData[0]) == 1) {
                $vData[0] = "0" . $vData[0];
            }
            if (strlen($vData[2]) > 4) {
                $vTimeAux = explode(" ", $vData[2]);
                $vTime = explode(":", $vTimeAux[1]);
                $vData[2] = $vTimeAux[0];
                if ($vTime[2] != "") {
                    return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
                } else {
                    $vTime[2] = "00";
                    return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
                }
            } else {
                return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . "'";
            }
        }
    }

    public function FormataNumeroGravacao($valor) {
	if (trim($valor) == "") {
	    return "null";
	}else{
		return str_replace(",","",str_replace(".","",$valor));
	}
    }
    public function print_pre($array,$exit=null){
        ?><pre><?print_r($array);
        $exit != null ? exit : "";
    }

    public function montaCombo($oResultset, $indiceValue, $indiceLabel, $indiceSelecionado = null, $incluirOptVazia = false) {
        if (!is_null($oResultset)) {
            if ($incluirOptVazia) {
                echo '<option value="null"></option>' . chr(13);
            }
            if ($indiceSelecionado != null) {
                for ($i = 0; $i < $oResultset->getCount(); $i++) {?>
                    <?='<option value="' . $oResultset->getValores($i, $indiceValue) . '"' ?><? if ($oResultset->getValores($i, $indiceValue) == $indiceSelecionado) {
                    echo ' selected="selected"';
                    } ?><?= ">" ?><?= $oResultset->getValores($i, $indiceLabel) . "</option>" . chr(13) ?>
            <?}
            } else {
                for ($i = 0; $i < $oResultset->getCount(); $i++) {?>
                    <?= '<option value="' . $oResultset->getValores($i, $indiceValue) . '">' ?><?= $oResultset->getValores($i, $indiceLabel) . "</option>" . chr(13) ?>
                <?
                }
            }
        }
    }
}