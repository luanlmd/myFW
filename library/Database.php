<?php
class Database
{
	/**
	 * Store the DataBase instances
	 *
	 * @var array
	 */
	private static $instances = array();

	/**
	 *
	 * @param string $name
	 * @return Database
	 */
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
	
	/**
	 *
	 * @param string $dsn
	 * @param string $user
	 * @param string $pass
	 */
	function init($dsn, $user, $pass)
	{
		$this->dsn = $dsn;
		$this->user = $user;
		$this->pass = $pass;
	}
	
	/**
	 *
	 * @param string $dsn
	 * @param string $user
	 * @param string $pass
	 * @return Database
	 */
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

	/**
	 *
	 * @return PDO
	 */
	function &getPDO()
	{
		return $this->pdo;
	}

	/**
	 * Prepare Statement
	 *
	 * @param string $sql
	 * @return <type>
	 */
	public function prepare($sql)
	{
		return $this->pdo->prepare($sql);
	}

	/**
	 * Execute SQL commands
	 *
	 * @param string $sql
	 * @return 
	 */
	public function exec($sql)
	{
		$this->connect();
		if ($this->pdo) { return $this->pdo->exec($sql); }
		throw new Exception("Not connected to Database.");
	}
	
	/**
	 * Execute a query and return the Object
	 *
	 * @param string $sql
	 * @param string $object
	 * @return array
	 */
	public function query($sql,$object = "DTO")
	{
		$this->connect();
		if ($this->pdo) { return $this->pdo->query($sql, is_object($object)? PDO::FETCH_INTO : PDO::FETCH_CLASS ,$object); }
		throw new Exception("Not connected to Database.");
	}

	/**
	 *
	 * @param string $sql
	 * @param string $object
	 * @return DTO
	 */

	public function queryOne($sql,$object = "DTO")
	{
		return $this->pdo->query($sql, is_object($object)? PDO::FETCH_INTO : PDO::FETCH_CLASS ,$object);	
	}
}