<?php
class Database
{
	//Store the DataBase instances
	private static $instances = array();

	public static function getInstance($name="default")
	{
		if (!isset(self::$instances[$name]))
		{
			self::$instances[$name] = new DataBase();
		}
		return self::$instances[$name];
	}
	
	private $dsn = null;
	private $user = null;
	private $pass = null;
	private $pdo = null;
	
	
	function init($dsn, $user, $pass)
	{
		$this->dsn = $dsn;
		$this->user = $user;
		$this->pass = $pass;
	}
	
	//Connect to a database
	function connect($dsn = null, $user = null, $pass = null)
	{
		if ($this->pdo) return $this->pdo;
		if ($dsn && $user && $pass)
		{
			$this->pdo = new PDO($dsn, $user, $pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this;
		}
		$this->pdo = new PDO($this->dsn, $this->user, $this->pass);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $this;
	}
	
	function &getPDO()
	{
		return $this->pdo;
	}
	
	public function prepare($sql)
	{
		return $this->pdo->prepare($sql);
	}
	
	//Execute SQL commands
	public function exec($sql)
	{
		$this->connect();
		if ($this->pdo) { return $this->pdo->exec($sql); }
		throw new Exception("Not connected to Database.");
	}
	
	//Execute a query and return the Object
	public function query($sql,$object = "DTO")
	{
		$this->connect();
		if ($this->pdo) { return $this->pdo->query($sql, is_object($object)? PDO::FETCH_INTO : PDO::FETCH_CLASS ,$object); }
		throw new Exception("Not connected to Database.");
	}
	
	public function queryOne($sql,$object = "DTO")
	{
		return $this->pdo->query($sql, is_object($object)? PDO::FETCH_INTO : PDO::FETCH_CLASS ,$object);	
	}
}
