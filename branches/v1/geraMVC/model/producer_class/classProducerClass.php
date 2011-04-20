<?php
class ProducerClass extends GeneratorFile {
    private $table;
    private $fields;
    private $text;
    private $path;
    private $variable;
    private $primaryKey = array();
    function __construct($table, $fields) {
        $this->table = split('_', $table);
        $this->fields = $fields;
        $this->primaryKey[0] = 'numg' . ucwords(strtolower($this->table[1]));
        $this->primaryKey[1] = 'numg_' . strtolower($this->table[1]);
    }

    function generator($path) {
        $this->path = $path;
        $this->text = "<?php
                        /**
                         * Empresa:
                         * Descri��o: Model
                         * Releases (Data, respons�vel e descri��o [�ltimo release primeiro]):
                         * xx/xx/xxxx (autor), (descri��o da atividade)
                         * Inclu�do este cabe�alho descrevendo a funcionalidade da p�gina
                         */
                        class " . substr(ucwords(strtolower($this->table[1])),0,-1) . "{
                        private \$sSql;\n";
                        for ($i = 0; $i < count($this->fields); $i++) {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .="\t private \$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";\n";
                        }
        /**
         * Descri��o: Gerador dos Gets and Sets
         */
        for ($i = 0; $i < count($this->fields); $i++) {
            $this->primaryKey[3] = ($this->fields[$i] != $this->primaryKey[1]) ? '!empty' : 'is_numeric';
            $this->variable = split('_', $this->fields[$i]);
            $this->text .="
                /**
                 * Descri��o: Set and Get
                 */
                \n\t public function set" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(\$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . "){
                if (" . $this->primaryKey[3] . "(\$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ")) {
                    \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " = \$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";
                }else {
                    \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " = 'NULL';
                    //Erro::addErro(\"Campo " . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " Inv�lido.�\");
                }
            }
            public function get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(){return \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";}";
        }
        $this->text .="
                /**
                 * Descri��o: Cadastrar.
                 * @uthor:
                 * Data:
                 */
                public function cadastrar(){
                \$this->sSql = \" INSERT INTO " . join('_', $this->table) . "(\n";
                for ($i = 0; $i < count($this->fields); $i++) {
                    if ($this->fields[$i] != $this->primaryKey[1]) {
                        if ($i != count($this->fields) - 1) {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .= "\t\t\t\t\t\t\t\t\t" . $this->fields[$i] . ",\n";
                    }else{
                        $this->variable = split('_', $this->fields[$i]);
                        $this->text .= "\t\t\t\t\t\t\t\t\t" . $this->fields[$i] . "\n";
                    }
                }
        }
        $this->text .="\t\t\t\t\t\t\t\t)
            \t\t\t\t\t\t\t\t VALUES
            \t\t\t\t\t\t\t\t (\n";
            for ($i = 0; $i < count($this->fields); $i++) {
                if ($this->fields[$i] != $this->primaryKey[1]) {
                    if ($i != count($this->fields) - 1) {
                        $this->variable = split('_', $this->fields[$i]);
                        $this->text .= "\t\t\t\t\t\t\t\t\t \" . Formata(\$this->get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "()) . \",\n";
                    } else {
                        $this->variable = split('_', $this->fields[$i]);
                        $this->text .= "\t\t\t\t\t\t\t\t\t \" . Formata(\$this->get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "()) . \"\n";
                    }
                }
            }
        $this->text .="\t\t\t\t\t\t\t\t )\";
            try{
                Oad::conectar();
                Oad::begin();
                Oad::executar(\$this->sSql);
                \$this->" . $this->primaryKey[0] . " = Oad::consultar(\"SELECT MAX(" . $this->primaryKey[1] . ") FROM " . join('_', $this->table) . "\")->getValores(0,0);
                Oad::commit();
                Oad::desconectar();
                return true;
            }catch(Exception \$e){
                Oad::rollback();
                Oad::desconectar();
                Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".cadastrar()\" . \$e->getMessage() . \"�\");
                return false;
            }
			
	}
        /**
         * Descri��o: Edi��o dos Dados.
         * @author:
         * Data:
         */
	public function editar(){
            \$this->sSql = \"UPDATE " . join('_', $this->table) . " SET \n";
                for ($i = 0; $i < count($this->fields); $i++) {
                    if ($this->fields[$i] != $this->primaryKey[1]) {
                        if ($i != count($this->fields) - 1) {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .= "\t\t\t\t\t\t\t\t " . $this->fields[$i] . " = \" . Formata(\$this->get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "()) . \",\n";
                        } else {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .= "\t\t\t\t\t\t\t\t " . $this->fields[$i] . " = \" . Formata(\$this->get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "()) . \"\n";
                        }
                    }
                }
                $this->text .="\t\t\t\t\t\t\tWHERE \n\t\t\t\t\t\t\t\t" . $this->primaryKey[1] . " ={\$this->get" . ucwords($this->primaryKey[0]) . "()}\";
                try {
                    Oad::conectar();
                    Oad::begin();
                    Oad::executar(\$this->sSql);
                    Oad::commit();
                    Oad::desconectar();
                    return true;
                }catch(Exception \$e){
                    Oad::rollback();
                    Oad::desconectar();
                    Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".cadastrar()\" . \$e->getMessage() . \"�\");
                    return false;
                }
			
            }";
        $this->text .="
            /**
             * Descri��o: Exclus�o dos Dados.
             * @author:
             * Data:
             */
            \tpublic function excluir(\$" . $this->primaryKey[0] . "){
                \$this->sSql = \"DELETE FROM " . join('_', $this->table) . " WHERE  " . $this->primaryKey[1] . " = {\$" . $this->primaryKey[0] ."}\";
                try{
                    Oad::conectar();
                    Oad::begin();
                    Oad::executar(\$this->sSql);
                    Oad::commit();
                    Oad::desconectar();
                    return true;
                }catch(Exception \$e){
                        Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".excluir()\" . \$e->getMessage() . \"�\");
                        Oad::rollback();
                        Oad::desconectar();
                        return false;
                }
			
	}";
        $this->text .= "
            /**
             * Descri��o: Seta os dados.
             * @author:
             * Data:
             */
            \tpublic function setarDados(\$" . $this->primaryKey[0] . "){
                \$this->sSql= \" SELECT\n";
                                for ($i = 0; $i < count($this->fields); $i++) {
                                    if ($this->fields[$i] != $this->primaryKey[1]) {
                                        if ($i != count($this->fields) - 1) {
                                            $this->variable = split('_', $this->fields[$i]);
                                            $this->text .= "\t\t\t\t\t\t\t" . $this->fields[$i] . ",\n";
                                        } else {
                                            $this->variable = split('_', $this->fields[$i]);
                                            $this->text .= "\t\t\t\t\t\t\t" . $this->fields[$i] . "\n";
                                        }
                                    }
                                }
        $this->text .="	FROM " . join('_', $this->table) . "
                        WHERE " . $this->primaryKey[1] . " = {\$" . $this->primaryKey[0] . "}\";
			try{
                            Oad::conectar();
                            \$result = Oad::consultar(\$this->sSql);
                            Oad::desconectar();
			}catch(Exception \$e){
                            Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".setarDados()\" . \$e->getMessage() . \"�\");
                            Oad::desconectar();
                            return false;
			}\n";
                        for ($i = 0; $i < count($this->fields); $i++) {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .= "\t\t\$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . "\t\t\t= \$result->getValores(0, '" . $this->fields[$i] . "'); \n";
                        }
                        $this->text .="\n\t\treturn true;
                    }\n";
        $this->text .= "
            /**
             * Descri��o: Consulta todos os registros da tabela.
             * @author:
             * Data:
             */
            \tpublic function consultarTodas(){
                \$this->sSql= \" SELECT\n";
                                for ($i = 0; $i < count($this->fields); $i++) {
                                    if ($i != count($this->fields) - 1) {
                                        $this->variable = split('_', $this->fields[$i]);
                                        $this->text .= "\t\t\t\t\t\t\t" . $this->fields[$i] . ",\n";
                                    } else {
                                        $this->variable = split('_', $this->fields[$i]);
                                        $this->text .= "\t\t\t\t\t\t\t" . $this->fields[$i] . "\n";
                                    }
                                }
        $this->text .=" FROM " . join('_', $this->table) . "\";
			try {
                            Oad::conectar();
                            \$result = Oad::consultar(\$this->sSql);
                            Oad::desconectar();
                            return \$result;
                        }catch(Exception \$e) {
                            Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".setarDados()\" . \$e->getMessage() . \"�\");
                            Oad::desconectar();
                            return false;
                        }
	}\n";
        $this->text .="}";
        $this->GeneratorFile(ucwords(strtolower($this->table[1])) . '.php', $this->text, $this->path);
    }
}
?>