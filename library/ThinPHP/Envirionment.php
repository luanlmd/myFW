<?php
namespace library\ThinPHP;

class Environment
{
	/** framework virtual directory
	*
	* @var String 
	*/
	public $virtualRoot;

	/** framework root directory
	*
	* @var String
	*/
	public $root;

	/** requested uri
	*
	* @var String
	*/
	public $uri;

	/** request parameters
	*
	* @var Array
	*/
	public $pars;

	/** Constructor of the environment manager
	*
	* @param Array $server 
	*/

	public function __construct($server, $key, $salt)
	{
		$this->key = $key;
		$this->salt = $salt;

		$this->virtualRoot = str_replace("public/","",str_replace($server["DOCUMENT_ROOT"],"",dirname($server["SCRIPT_FILENAME"]).'/'));
		if (!strlen($this->virtualRoot) || $this->virtualRoot{0} != '/') { $this->virtualRoot = '/'. $this->virtualRoot; }
		
		$this->documentRoot = realpath(dirname(__FILE__).'/../../').'/';
		$this->protocol = explode('/',$server['SERVER_PROTOCOL']);
		$this->method      = strtolower($server['REQUEST_METHOD']);

		$this->base = strtolower(array_shift($protocol)) . '://' . $server['HTTP_HOST'] . $this->virtualRoot;
	}
}
