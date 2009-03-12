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
		$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $this;
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
	public function query($sql,$class = "Object")
	{
		return $this->pdo->query($sql, PDO::FETCH_CLASS,$class);
	}
}
