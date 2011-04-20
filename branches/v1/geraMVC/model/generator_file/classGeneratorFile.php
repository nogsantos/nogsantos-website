<?php
class GeneratorFile
{
private $nameFile;
private $text;
private $path;
private $File;
	function GeneratorFile($nameFile, $text, $path)
	{
		$this->nameFile = $nameFile;
		$this->text 	= $text;
		$this->path 	= $path;

		$this->openFile();
		$this->writeFile();
		$this->closeFile();
	}
	function openFile()
	{
		$this->File = fopen($this->path . $this->nameFile, 'w');
	}
	function writeFile()
	{
		fwrite($this->File, $this->text);
	}
	function closeFile()
	{
		fclose($this->File);
	}
}
?>