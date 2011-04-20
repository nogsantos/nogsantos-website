<?php

class Resultset {

    private $registros;
    private $linhas;
    private $colunas;
    private $resultados;

    function setValores($linhas, $colunas, $vRegistro) {
        $this->resultados = $linhas;
        $this->linhas = $linhas;
        $this->colunas = $colunas;
        $this->registros = $vRegistro;
    }

    function getValores($linha, $coluna) {
        return $this->registros[$linha][$coluna];
    }

    function setValor($linha, $coluna, $valor) {
        $this->registros[$linha][$coluna] = $valor;
    }

    function getRegistros() {
        return $this->registros;
    }

    function getCount() {
        return $this->resultados;
    }

    function addValores($vNovoReg) {
        if (!empty($vNovoReg)) {

            for ($i = 0; $i < $vNovoReg->getCount(); $i++) {

                $this->resultados = $this->linhas + 1;
                $this->linhas = $this->linhas + 1;
                $this->registros[$this->linhas]["numg_cliente"] = $vNovoReg->getValores[$i]["numg_cliente"];
                $this->registros[$this->linhas]["nome_cliente"] = $vNovoReg->getValores[$i]["nome_cliente"];
            }
        }
    }

    function getLinhas() {
        return $this->linhas;
    }

    function getColunas() {
        return $this->colunas;
    }
}