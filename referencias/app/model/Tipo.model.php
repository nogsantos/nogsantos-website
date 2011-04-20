<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tipo{
    private $numgTipo;
    private $descTipo;
    private $descObs;

    public function getNumgTipo() {
        return $this->numgTipo;
    }

    public function setNumgTipo($numgTipo) {
        $this->numgTipo = $numgTipo;
    }

    public function getDescTipo() {
        return $this->descTipo;
    }

    public function setDescTipo($descTipo) {
        $this->descTipo = $descTipo;
    }

    public function getDescObs() {
        return $this->descObs;
    }

    public function setDescObs($descObs) {
        $this->descObs = $descObs;
    }

    public function cadastrar(){
        $sSql = " INSERT INTO re_tipos(
                  desc_tipo, desc_obs)
                  VALUES ( ";
        $sSql .= Funcoes::FormataStr($this->getDescTipo()).",";
        $sSql .= Funcoes::FormataStr($this->getDescObs()).");";
        try {
            Oad::conectar();
            Oad::begin();
            Oad::executar($sSql);
            Oad::commit();
            $maxNumgTipo = Oad::consultar("Select max(numg_tipo) from re_tipos");
            $this->numgTipo = $maxNumgTipo->getValores(0, "max");
            return true;
        } catch (Exception $exc) {
            Oad::rollback();
            Oad::desconectar();
            echo $exc->getMessage();
            return false;
        }
    }

    public function consultaTipo($numgTipo){
        $sSql = " Select numg_tipo, desc_tipo, desc_obs from re_tipos where numg_tipo = {$numgTipo} ";
        try {
            Oad::conectar();
            $oTipo = Oad::consultar($sSql);
            Oad::desconectar();
            return $oTipo;
        } catch (Exception $exc) {
            Oad::desconectar();
            echo $exc->getMessage();
        }
    }

    public function editarTipo(){
        $sSql  = " update re_tipos set ";
        $sSql .= " desc_tipo       = ".Funcoes::FormataStr($this->getDescTipo()).",";
        $sSql .= " desc_obs        = ".Funcoes::FormataStr($this->getDescObs());
        $sSql .= " where numg_tipo = {$this->getNumgTipo()} ";
        try {
            Oad::conectar();
            Oad::begin();
            Oad::executar($sSql);
            Oad::commit();
            return true;
        } catch (Exception $exc) {
            Oad::rollback();
            Oad::desconectar();
            echo $exc->getMessage();
            return false;
        }
    }

    public function excluirTipo(){
        $sSql  = " delete from re_tipos where numg_tipo = {$this->getNumgTipo()}; ";
        try {
            Oad::conectar();
            Oad::begin();
            Oad::executar($sSql);
            Oad::commit();
            return true;
        } catch (Exception $exc) {
            Oad::rollback();
            Oad::desconectar();
            echo $exc->getMessage();
            return false;
        }
    }

    public function consultaTodosTipo(){
        $sSql = " Select numg_tipo, desc_tipo, desc_obs from re_tipos";
        try {
            Oad::conectar();
            $oResult = Oad::consultar($sSql);
            Oad::desconectar();
            return $oResult;
        } catch (Exception $exc) {
            Oad::desconectar();
            echo $exc->getMessage();
        }
    }

    public function consultaDescTipo($numgTipo){
        $sSql = " Select desc_tipo from re_tipos where numg_tipo = {$numgTipo}";
        try {
            Oad::conectar();
            $oResult = Oad::consultar($sSql);
            Oad::desconectar();
            return $oResult->getValores(0, "desc_tipo");
        } catch (Exception $exc) {
            Oad::desconectar();
            echo $exc->getMessage();
        }
    }
}