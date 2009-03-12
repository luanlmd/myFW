<?php
class DataBase
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
	
	var $pdo = null;
	
	//Connect to a database
	function connect($dsn, $user, $pass)
	{
		$this->pdo = new PDO($dsn, $user, $pass);
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
		return $this->pdo->exec($sql);
	}
	
	//Execute a query and return the Object
	public function query($sql,$object = "Object")
	{
		return $this->pdo->query($sql, is_object($object)? PDO::FETCH_INTO : PDO::FETCH_CLASS ,$object);	
	}
}
