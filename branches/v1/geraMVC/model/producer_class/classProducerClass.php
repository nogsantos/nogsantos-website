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
                         * Descrição: Model
                         * Releases (Data, responsável e descrição [Último release primeiro]):
                         * xx/xx/xxxx (autor), (descrição da atividade)
                         * Incluído este cabeçalho descrevendo a funcionalidade da página
                         */
                        class " . substr(ucwords(strtolower($this->table[1])),0,-1) . "{
                        private \$sSql;\n";
                        for ($i = 0; $i < count($this->fields); $i++) {
                            $this->variable = split('_', $this->fields[$i]);
                            $this->text .="\t private \$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";\n";
                        }
        /**
         * Descrição: Gerador dos Gets and Sets
         */
        for ($i = 0; $i < count($this->fields); $i++) {
            $this->primaryKey[3] = ($this->fields[$i] != $this->primaryKey[1]) ? '!empty' : 'is_numeric';
            $this->variable = split('_', $this->fields[$i]);
            $this->text .="
                /**
                 * Descrição: Set and Get
                 */
                \n\t public function set" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(\$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . "){
                if (" . $this->primaryKey[3] . "(\$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ")) {
                    \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " = \$" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";
                }else {
                    \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " = 'NULL';
                    //Erro::addErro(\"Campo " . $this->variable[0] . ucwords(strtolower($this->variable[1])) . " Inválido.ß\");
                }
            }
            public function get" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(){return \$this->" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . ";}";
        }
        $this->text .="
                /**
                 * Descrição: Cadastrar.
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
                Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".cadastrar()\" . \$e->getMessage() . \"ß\");
                return false;
            }
			
	}
        /**
         * Descrição: Edição dos Dados.
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
                    Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".cadastrar()\" . \$e->getMessage() . \"ß\");
                    return false;
                }
			
            }";
        $this->text .="
            /**
             * Descrição: Exclusão dos Dados.
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
                        Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".excluir()\" . \$e->getMessage() . \"ß\");
                        Oad::rollback();
                        Oad::desconectar();
                        return false;
                }
			
	}";
        $this->text .= "
            /**
             * Descrição: Seta os dados.
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
                            Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".setarDados()\" . \$e->getMessage() . \"ß\");
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
             * Descrição: Consulta todos os registros da tabela.
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
                            Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($this->table[1])) . ".setarDados()\" . \$e->getMessage() . \"ß\");
                            Oad::desconectar();
                            return false;
                        }
	}\n";
        $this->text .="}";
        $this->GeneratorFile(ucwords(strtolower($this->table[1])) . '.php', $this->text, $this->path);
    }
}
?>