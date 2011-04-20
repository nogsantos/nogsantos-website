<?php
$path = '../../';
require_once('../../require_class.php');
if ($_GET['controle'] == 'gerador') {
    $obj = new getDados($_POST['host'], $_POST['usr'], $_POST['pwr'], $_POST['db']);

    //ZIP FILE---------------------------
    $createZip = new createZip;
    $createZip->addDirectory("model/");
    $createZip->addDirectory("ctrl/");
    //------------------------------------

    for ($i = 0; $i < count($_POST['tables']); $i++) {

        $directory = split('_', $_POST['tables'][$i]);
        //DIRECTORY AND FILE NAME ZIP FILE
        $createZip->addDirectory("model/" . $directory[1]);
        $createZip->addDirectory("ctrl/" . $directory[1]);
        //----------------------------------------

        $producer = new ProducerClass($_POST['tables'][$i], $obj->getFields($_POST['tables'][$i]));
        $producer->generator('../../newClasses/');

        //ADD ZIP FILE

        $fileContents = file_get_contents("../../newClasses/" . ucwords(strtolower($directory[1])) . ".php");
        $createZip->addFile($fileContents, "model/" . $directory[1] . "/" . ucwords(strtolower($directory[1])) . '.php');
        //--------------------
        @unlink("../../newClasses/" . ucwords(strtolower($directory[1])) . ".php");

        $producer = new ProducerPcad($_POST['tables'][$i], $obj->getFields($_POST['tables'][$i]));
        $producer->generator('../../newClasses/');

        //ADD ZIP FILE
        $fileContents = file_get_contents("../../newClasses/" . "pcad" . strtolower($directory[1]) . ".php");
        $createZip->addFile($fileContents, "ctrl/" . $directory[1] . "/" . "pcad" . strtolower($directory[1]) . ".php");
        //--------------------
        @unlink("../../newClasses/" . "pcad" . strtolower($directory[1]) . ".php");
    }
    $fileName = "newClasses.zip";
    $fd = fopen($fileName, "wb");
    $out = fwrite($fd, $createZip->getZippedfile());
    fclose($fd);

//		$createZip -> forceDownload($fileName);
//		@unlink($fileName);
    if (file_exists($fileName)) {
?>
        				//alert('ok');
        				//window.open('controller/gerador/<?php echo $fileName ?>', '', '');
        				document.location.href = 'controller/gerador/<?php echo $fileName ?>';
        setTimeout(function () {postText('controller/gerador/modulo.php?controle=unlinkFile', 'file=<?php echo $fileName; ?>', eval)}, 1000);
<?php
    } else {
?>alert('Erro ao Produzir arquivos');<?php
    }
} else if ($_GET['controle'] == 'dtaBase') {
    $obj = new getDados($_POST['host'], $_POST['usr'], $_POST['pwr'], $_POST['db']);
    optionDtaBase($obj->getDbs());
} else if ($_GET['controle'] == 'tables') {
    $obj = new getDados($_POST['host'], $_POST['usr'], $_POST['pwr'], $_POST['db']);
    if ($_POST['dbs'] == '-1') {
        optionTables($obj->getTables($_POST['db']));
    } else {
        optionTables($obj->getTables($_POST['dbs']));
    }
} else if ($_GET['controle'] == 'unlinkFile') {
    unlink($_POST['file']);
}
?>