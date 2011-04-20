<?php
/*
	o parametro path deve ser iniciado antes do include ou require
*/

//Pegar Dados do Gerador
require_once($path . 'model/get_dados/classGetDados.php');

//Gerar Arquivo
require_once($path . 'model/generator_file/classGeneratorFile.php');

//Produzir a Pcad
require_once($path . 'model/producer_pcad/classProducerPcad.php');

//Produzir a Class
require_once($path . 'model/producer_class/classProducerClass.php');

//Zip File
require_once($path . 'model/create_zip_file/createZipFile.php');

//Funcoes
require_once($path . 'misc/funcao.php');
?>