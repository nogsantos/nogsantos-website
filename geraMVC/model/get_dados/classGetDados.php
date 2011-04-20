<?php
class getDados
{
private $table;
private $tables;
private $fields;
private $host;
private $usr;
private $pwr;
private $db;
private $dbs;
private $rows;
private $result;
private $prefix;
private $connect;

	function __construct($host, $usr, $pwr, $db)
	{
		$this->host = $host;
		$this->usr = $usr;
		$this->pwr = $pwr;
		$this->db = $db;
	}
	function openConnect()
	{
		$this->connect = @pg_connect("host=" . $this->host . " port=5432 dbname=" . $this->db . " user='" . $this->usr . "' password='" . $this->pwr . "'");
	}
	function closeConnect()
	{
		@pg_close($this->connect);
	}
	function getRows($result)
	{
		$this->rows = @pg_num_rows($result);
		return $this->rows;
	}
	function getDbs()
	{
		
		$this->openConnect();
		$this->dbs = @pg_query('SELECT datname FROM pg_database;');
		$this->closeConnect();
		$this->result = array();
		for($i=0; $i<$this->getRows($this->dbs); $i++)
		{
			$this->result[$i] = @pg_fetch_array($this->dbs, $i, 2);
			$this->result[$i] = $this->result[$i][0];
		}
		return $this->result;
	}
	function getTables($db)
	{
		$this->db = $db;
		$this->openConnect();
		$this->tables = @pg_query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';");
		$this->closeConnect();
		$this->result = array();
		for($i=0; $i<$this->getRows($this->tables); $i++)
		{
			$this->result[$i] = @pg_fetch_array($this->tables, $i, 2);
			$this->result[$i] = $this->result[$i][0];
		}
		return $this->result;
	}
	function getFields($table)
	{
		$this->table = $table;
		$this->openConnect();
		$this->fields = @pg_query("SELECT column_name FROM information_schema.columns WHERE table_name ='" . $this->table . "';");
		$this->closeConnect();
		$this->rows = $this->getRows($this->fields);
		$this->result = array();
		for($i=0; $i<$this->rows; $i++)
		{
			$this->result[$i] = @pg_fetch_array($this->fields, $i, 2);
			$this->result[$i] = $this->result[$i][0];
		}
		return $this->result;
	}
}
?>