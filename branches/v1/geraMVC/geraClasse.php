<?php
function print_pre($array)
{
	?><pre><?
		print_r($array);
	?></pre><?
}
$table = 'ac_peca';

$connect = pg_connect("host=192.168.7.3 port=5432 dbname=sgm user=postgres password=123456");

$sql = "SELECT column_name FROM information_schema.columns WHERE table_name ='" . $table . "';";

$result = pg_query($sql);

$cols = array();
for($i=0; $i<pg_num_rows($result); $i++)
{
	$cols[$i] = pg_fetch_array($result, $i, 2);
	$cols[$i] = $cols[$i][0];
}

$path = 'teste/';
$table = split('_', $table);

$class =  "<?php
class " . ucwords(strtolower($table[1])) . "
{
	 private \$sSql;\n";
for($i=0; $i<count($cols); $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .="\t private \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ";\n";
}
for($i=0; $i<count($cols); $i++)
{
$variavel = split('_', $cols[$i]);
$class .="\n\t function set" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ") 
	{
       if (!empty(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")) 
	   {
          \$this->" . $variavel[0] . ucwords(strtolower($variavel[1])) . " = \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ";
       } 
	   else 
	   {
          Erros::addErro(\"Campo " . $variavel[0] . ucwords(strtolower($variavel[1])) . " Inválido.ß\");
       }
    }//end set" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")
	
	function get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "()
	{
		return \$this->" . $variavel[0] . ucwords(strtolower($variavel[1])) . ";
	}//end 	function get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "()
";
}
$class .="
	function cadastrar()
	{
		if(Erro::isError()) 
		{
			return false;
		} 
		else 
		{
			Oad::conectar();

			\$this->pValidaGravacao();
			
			if (Erro::isError())
			{
				Oad::desconectar();
				return false;
			}
			else
			{
				\$this->sSql = \"
								 INSERT INTO " . join('_', $table) . "
								 (\n";
for($i=1; $i<count($cols)-1; $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\t\t\t\t\t\t\t" . $cols[$i] . ",\n";
}
$class .= "\t\t\t\t\t\t\t\t\t" . $cols[sizeof($cols)-1] . "\n";
$class .="\t\t\t\t\t\t\t\t)
\t\t\t\t\t\t\t\t VALUES 
\t\t\t\t\t\t\t\t (\n";
for($i=1; $i<count($cols)-1; $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\t\t\t\t\t\t\t \" . FormataStr(\$this->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "()) . \",\n";
}
$variavel = split('_', $cols[count($cols)-1]);
$class .= "\t\t\t\t\t\t\t\t\t \" . FormataStr(\$this->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "()) . \",\n";
$class .="\t\t\t\t\t\t\t\t )\";
				try 
				{
					Oad::begin();
					Oad::executar(\$this->sSql);
					\$this->numgExposicoes = Oad::consultar(\"SELECT MAX(" . $cols[0] . ") FROM " . join('_', $table) . "\")->getValores(0,0);
					Oad::commit();
					Oad::desconectar();
				} 
				catch(Exception \$e) 
				{
					Oad::rollback();
					Oad::desconectar();
					Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($table[1])) . ".cadastrar()\" . \$e->getMessage() . \"ß\");
					return false;
				}
			}//end else
			return true;
		}//end else
	}//end function cadastrar()
	function editar()
	{
		if (Erro::isError()) 
		{
			return false;
		}//end if (Erro::isError()) 
		else 
		{
		
			Oad::conectar();
				
			\$this->pValidaGravacao();
	
			if (Erro::isError())
			{
				Oad::desconectar();
				return false;
			}//end if (Erro::isError())
			else
			{
				\$this->sSql = \"UPDATE " . join('_', $table) . " SET \n";
for($i=1; $i<count($cols)-1; $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\t\t\t\t\t\t " . $cols[$i] . " = \" . FormataStr(\$this->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "()) . \",\n";
}
	$variavel = split('_', $cols[0]);
$class .="\t\t\t\t\t\t\tWHERE \n\t\t\t\t\t\t\t\t" . $cols[0] . " = \" . \$this->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "() . \"
								\";
				try 
				{
					Oad::begin();
					Oad::executar(\$this->sSql);
					\$this->numgExposicoes = Oad::consultar(\"SELECT MAX(" . $cols[0] . ") FROM " . join('_', $table) . "\")->getValores(0,0);
					Oad::commit();
					Oad::desconectar();
				} 
				catch(Exception \$e) 
				{
					Oad::rollback();
					Oad::desconectar();
					Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($table[1])) . ".cadastrar()\" . \$e->getMessage() . \"ß\");
					return false;
				}
			}//end else
			return true;
		}//end else
	}//end function editar()\n";
$variavel = split('_', $cols[0]);
$class .="\tfunction excluir(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")
	{
		if(Erro::isError()) 
		{
			return false;
		}
		else 
		{
			Oad::conectar();
				
			\$this->pValidaExclusao(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ");
	
			if (Erro::isError())
			{
				Oad::desconectar();
				return false;
			}
			else
			{
				\$this->sSql = \"DELETE FROM " . join('_', $table) . " WHERE  " . $cols[0] . " = \" . \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . " . \"\";
				try 
				{
		
					Oad::begin();
					Oad::executar(\$this->sSql);
					Oad::commit();
					Oad::desconectar();
										
				} 
				catch(Exception \$e) 
				{
		
					Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($table[1])) . ".excluir()\" . \$e->getMessage() . \"ß\");
					Oad::rollback();
					Oad::desconectar();
					return false;
				}
			}//end else
			return true;
		}//end else
	}//end function excluir(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")\n";
$variavel = split('_', $cols[0]);
$class .= "\tfunction setarDados(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")
	{
		if(Erro::isError() && empty(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . "))
		{
			return false;
		} 
		else 
		{
			\$this->sSql= \"
						SELECT\n";
for($i=1; $i<count($cols)-1; $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\t\t\t\t\t" . $cols[$i] . ",\n";
}
$class .= "\t\t\t\t\t\t\t" . $cols[sizeof($cols)-1] . "\n";
$variavel = split('_', $cols[0]);
$class .=
"						FROM " . join('_', $table) . "
						WHERE " . $cols[0] . " = \" . \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . " . \"\";
			try 
			{
				Oad::conectar();
				\$result = Oad::consultar(\$this->sSql);
			} 
			catch(Exception \$e) 
			{
				Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($table[1])) . ".setarDados()\" . \$e->getMessage() . \"ß\");
				Oad::desconectar();
				return false;
			}
			Oad::desconectar();
		}//end else\n\n";
for($i=0; $i<count($cols); $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\$this->" . $variavel[0] . ucwords(strtolower($variavel[1])) . "\t\t\t= \$result->getValores(0, '" . $cols[$i] . "'); \n";
}
$class .="\n\t\treturn true;
	}//end function setarDados(\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ")\n";
$class .= "\tfunction consultarTodas()
	{
		if(Erro::isError()) 
		{
			return false;
		} 
		else 
		{
			\$this->sSql= \"
						SELECT\n";
for($i=1; $i<count($cols)-1; $i++)
{
	$variavel = split('_', $cols[$i]);
	$class .= "\t\t\t\t\t\t\t" . $cols[$i] . ",\n";
}
$class .= "\t\t\t\t\t\t\t" . $cols[sizeof($cols)-1] . "\n";
$variavel = split('_', $cols[0]);
$class .=
"						FROM " . join('_', $table) . "\";
				try 
				{
					Oad::conectar();
					\$result = Oad::consultar(\$this->sSql);
				} 
				catch(Exception \$e) 
				{
					Erro::addErro(\"Fonte: SGM." . ucwords(strtolower($table[1])) . ".setarDados()\" . \$e->getMessage() . \"ß\");
					Oad::desconectar();
					return false;
				}
				Oad::desconectar();

			return \$result;
		}//end else
	}//end function consultarTodas()\n";
$class .="}//end class " . ucwords(strtolower($table[1])) . "
?>";
$a = fopen($path . ucwords(strtolower($table[1])) . '.php', 'w');
fwrite($a, $class);
fclose($a);
//header('Content-Disposition: attachment; filename="newclass.php"');

//-------------------------Pcad
$pcad = "<?php
switch(\$_POST['txtFuncao'])
{
	//Inserir
	case 'cadastrar_" . $table[1] . "' :

		\$o" . ucwords(strtolower($table[1])) . " = new " . ucwords(strtolower($table[1])) . "();\n";
for($i=0; $i<count($cols); $i++)
{
	$variavel = split('_', $cols[$i]);
	$pcad .="\t\t\$o" . ucwords(strtolower($table[1])) . "->set" . ucwords(strtolower($cols[$i])) . "(\$_POST['" . $variavel[0] . ucwords(strtolower($variavel[1])) . "']);\n";
}
	$pcad .="\t\t\$o" . ucwords(strtolower($table[1])) . "->cadastrar();

		if(Erro::isError()) 
		{
			MostraErros();
		}\n";
$variavel = split('_', $cols[0]);
$pcad .="\t\t\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . " = \$o" . ucwords(strtolower($table[1])) . "->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "();

		unset(\$o" . ucwords(strtolower($table[1])) . ");

		header(\"Location: cad" . $table[1] . ".php?info=1&" . $cols[0] . "=\" . \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ");
		exit();
	break;
	case 'editar_" . $table[1] . "' :

		\$o" . ucwords(strtolower($table[1])) . " = new " . ucwords(strtolower($table[1])) . "();\n";
for($i=0; $i<count($cols); $i++)
{
	$variavel = split('_', $cols[$i]);
	$pcad .="\t\t\$o" . ucwords(strtolower($table[1])) . "->set" . ucwords(strtolower($cols[$i])) . "(\$_POST['" . $variavel[0] . ucwords(strtolower($variavel[1])) . "']);\n";
}
	$pcad .="\t\t\$o" . ucwords(strtolower($table[1])) . "->editar();

		if(Erro::isError()) 
		{
			MostraErros();
		}\n";
$variavel = split('_', $cols[0]);
$pcad .="\t\t\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . " = \$o" . ucwords(strtolower($table[1])) . "->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "();

		unset(\$o" . ucwords(strtolower($table[1])) . ");

		header(\"Location: cad" . $table[1] . ".php?info=2&" . $cols[0] . "=\" . \$" . $variavel[0] . ucwords(strtolower($variavel[1])) . ");
		exit();
	break;
	case 'excluir_" . $table[1] . "':
		\$o" . ucwords(strtolower($table[1])) . " = new " . ucwords(strtolower($table[1])) . "();\n";
$pcad .="\t\t\$o" . ucwords(strtolower($table[1])) . "->excluir(\$_POST['" . $variavel[0] . ucwords(strtolower($variavel[1])) . "']);\n
			if(Erro::isError()) 
			{
				MostraErros();
			}

			\$" . $variavel[0] . ucwords(strtolower($variavel[1])) . " = \$o" . ucwords(strtolower($table[1])) . "->get" . ucwords(strtolower($variavel[0])) . ucwords(strtolower($variavel[1])) . "();

			unset(\$o" . ucwords(strtolower($table[1])) . ");

			header(\"Location: cad" . strtolower($table[1]) . ".php?info=3\");
			exit();
	break;
}//end switch(\$_POST['txtFuncao'])
?>
";
$a = fopen($path . 'pcad' . strtolower($table[1]) . '.php', 'w');
fwrite($a, $pcad);
fclose($a);
?>