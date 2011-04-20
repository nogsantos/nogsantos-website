<?php

require_once('Resultset.php');

class Oad {
    
    private static $oConexao;
    private static $vResult = array();
    private $result;
    
    static function conectar() {

//        $sHost = "127.0.0.1";
//        $sUser = "postgres";
//        $sSenha = "123456";
//        $sBd = "referenciasnet";

        $sHost = "127.0.0.1";
        $sUser = "nogsanto_humo";
        $sSenha = "nog123";
        $sBd = "nogsanto_referenciasnet";

        if (!(self::$oConexao = @pg_connect("host=$sHost port=5432 dbname=$sBd user=$sUser password=$sSenha"))) {
            throw new Exception("Erro ao conectar no banco de dados do sistema.ß");
        }
    }
    static function desconectar() {
        if (!(@pg_close())) {
            throw new Exception("Erro ao fechar o banco de dados do sistema.ß");
        }
        else
            Oad::$vResult = array();
    }
    static function executar($sQuery) {
        if (!@pg_query(self::$oConexao, $sQuery)) {
            throw new Exception('Query: ' . $sQuery . ' ' . pg_last_error(self::$oConexao));
        }
    }
    static function consultar($sQuery) {
        $result = new Resultset();
        if (!($vAux = @pg_query(self::$oConexao, $sQuery))) {
            throw new Exception('Query: ' . $sQuery . ' ' . pg_last_error(self::$oConexao));
        }
        $nRows = pg_numrows($vAux);
        $nCols = pg_numfields($vAux);
        if ($nRows > 0) {
            for ($i = 0; $i <= ($nRows - 1); $i++) {
                self::$vResult[$i] = $vAuxResult = pg_fetch_array($vAux);
            }
        } else {
            self::$vResult = array();
        }

        $result->setValores($nRows, $nCols, self::$vResult);
        return $result;
    }
    static function begin() {
        self::executar("BEGIN");
    }
    static function commit() {
        self::executar("COMMIT");
    }
    static function rollback() {
        self::executar("ROLLBACK");
    }
}