<?php

class Referencia{
   private $sSql;
   private $numgReferencia;
   private $numgTipo;
   private $dataCadastro;
   private $dataAtualizacao;
   private $descUrl;
   private $descObs;

   public function getNumgReferencia() {
       return $this->numgReferencia;
   }

   public function setNumgReferencia($numgReferencia) {
       $this->numgReferencia = $numgReferencia;
   }

   public function getNumgTipo() {
       return $this->numgTipo;
   }

   public function setNumgTipo($numgTipo) {
       $this->numgTipo = $numgTipo;
   }

   public function getDataCadastro() {
       return $this->dataCadastro;
   }

   public function setDataCadastro($dataCadastro) {
       $this->dataCadastro = $dataCadastro;
   }

   public function getDataAtualizacao() {
       return $this->dataAtualizacao;
   }

   public function setDataAtualizacao($dataAtualizacao) {
       $this->dataAtualizacao = $dataAtualizacao;
   }

   public function getDescUrl() {
       return $this->descUrl;
   }

   public function setDescUrl($descUrl) {
       $this->descUrl = $descUrl;
   }

   public function getDescObs() {
       return $this->descObs;
   }

   public function setDescObs($descObs) {
       $this->descObs = $descObs;
   }

   public function cadastrarReferencia(){
       $this->sSql = " INSERT INTO public.re_referencias(
                       numg_tipo, data_cadastro,
                       desc_url, desc_obs)
                       VALUES ( ";
       $this->sSql .= Funcoes::FormataNumeroGravacao($this->getNumgTipo()).",";
       $this->sSql .= "now(),";
       $this->sSql .= Funcoes::FormataStr($this->getDescUrl()). ",";
       $this->sSql .= Funcoes::FormataStr($this->getDescObs()). ");";
       try {
           Oad::conectar();
           Oad::begin();
           Oad::executar($this->sSql);
           Oad::commit();
           $maxReferencia = Oad::consultar(" Select max(numg_referencia) from re_referencias ");
           $this->numgReferencia = $maxReferencia->getValores(0, "max");
           Oad::desconectar();
       } catch (Exception $exc) {
           Oad::rollback();
           Oad::desconectar();
           echo $exc->getMessage();
           exit;
       }
   }

   public function editarReferencia(){
        $sSql = " update re_referencias set ";
        $sSql .= " numg_tipo        = " . Funcoes::FormataNumeroGravacao($this->getNumgTipo()) . ",";
        $sSql .= " data_atualizacao = now(),";
        $sSql .= " desc_url         = " . Funcoes::FormataStr($this->getDescUrl()) . ",";
        $sSql .= " desc_obs         = " . Funcoes::FormataStr($this->getDescObs());
        $sSql .= " where numg_referencia = {$this->getNumgReferencia()} ";
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

   public function excluirReferencia(){
        $sSql  = " delete from re_referencias where numg_referencia = {$this->getNumgReferencia()}; ";
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

   public function consultarReferencia($numgReferencia){
        $sSql = " Select numg_referencia, numg_tipo, data_cadastro, desc_url,
                  desc_obs from re_referencias where numg_referencia = {$numgReferencia};";
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

   public function consultarTodasReferencia(){
        $sSql = " Select numg_referencia, numg_tipo, data_cadastro, desc_url,
                  desc_obs from re_referencias
                  order by data_cadastro desc";
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

}