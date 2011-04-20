<?php
class ProducerPcad extends GeneratorFile {
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
             * Empresa: Controller
             * Descrição:
             * Releases (Data, responsável e descrição [Último release primeiro]):
             * xx/xx/xxxx (autor), (descrição da atividade)
             * Incluído este cabeçalho descrevendo a funcionalidade da página
             */
            switch(\$_POST['txtFuncao']){
                /**
                 * Descrição: Inserir.
                 */
                case 'cadastrar_" . $this->table[1] . "' :
		\$o" . ucwords(strtolower($this->table[1])) . " = new " . ucwords(strtolower($this->table[1])) . "();\n";
                for ($i = 0; $i < count($this->fields); $i++) {
                    if ($this->fields[$i] != $this->primaryKey[1]) {
                        $this->variable = split('_', $this->fields[$i]);
                        $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->set" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(\$_POST['" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . "']);\n";
                    } else {
                        $this->variable = split('_', $this->fields[$i]);
                        $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->set" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(0);\n";
                    }
                }
        $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->cadastrar();
		if(Erro::isError()){MostraErros();}\n";
        $this->text .="\t\t\$" . $this->primaryKey[0] . " = \$o" . ucwords(strtolower($this->table[1])) . "->get" . ucwords($this->primaryKey[0]) . "();
		unset(\$o" . ucwords(strtolower($this->table[1])) . ");
		header(\"Location: cad" . $this->table[1] . ".php?info=1&" . $this->primaryKey[1] . "=\$" . $this->primaryKey[0] . "\");
	break;
        /**
         * Descrição: Editar.
         */
	case 'editar_" . $this->table[1] . "' :
		\$o" . ucwords(strtolower($this->table[1])) . " = new " . ucwords(strtolower($this->table[1])) . "();\n";
            for ($i = 0; $i < count($this->fields); $i++) {
                $this->variable = split('_', $this->fields[$i]);
                $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->set" . ucwords(strtolower($this->variable[0])) . ucwords(strtolower($this->variable[1])) . "(\$_POST['" . $this->variable[0] . ucwords(strtolower($this->variable[1])) . "']);\n";
            }
            $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->editar();
		if(Erro::isError()) {MostraErros();}\n";
            $this->text .="\t\t\$" . $this->primaryKey[0] . " = \$o" . ucwords(strtolower($this->table[1])) . "->get" . ucwords($this->primaryKey[0]) . "();
		unset(\$o" . ucwords(strtolower($this->table[1])) . ");
		header(\"Location: cad" . $this->table[1] . ".php?info=2&" . $this->primaryKey[1] . "= . \$" . $this->primaryKey[0] . "\");
	break;
        /**
         * Descrição: Excluir.
         */
	case 'excluir_" . $this->table[1] . "':
		\$o" . ucwords(strtolower($this->table[1])) . " = new " . ucwords(strtolower($this->table[1])) . "();\n";
            $this->text .="\t\t\$o" . ucwords(strtolower($this->table[1])) . "->excluir(\$_POST['" . $this->primaryKey[1] . "']);\n
    		if(Erro::isError()){MostraErros();}
		unset(\$o" . ucwords(strtolower($this->table[1])) . ");
		header(\"Location: cad" . strtolower($this->table[1]) . ".php?info=3\");
	break;
}";
        $this->GeneratorFile('pcad' . strtolower($this->table[1]) . '.php', $this->text, $this->path);
}
}
?>