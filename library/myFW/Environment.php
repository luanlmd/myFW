<?php
namespace library\myFW;

class Environment
{
	public $virtualRoot;
	public $documentRoot;
	public $uri;
	
	public $protocol;
	public $base;

	public $development_env;
	
	public function __construct($server)
	{
		$this->virtualRoot = str_replace("public/","",str_replace($server["DOCUMENT_ROOT"],"",str_replace("index.php", "", $server["SCRIPT_FILENAME"])));
		$this->documentRoot = realpath(dirname(__FILE__).'/../../').'/';
		$uri = explode('?', $server['REQUEST_URI']);
		$this->uri = str_replace($this->virtualRoot,'',$uri[0]);
		
		$protocol = explode('/',$server['SERVER_PROTOCOL']);
		$this->protocol = $protocol[0];
		$this->base = strtolower(array_shift($protocol)) . '://' . $server['HTTP_HOST'] .'/'. $this->virtualRoot;
				
		$this->development_env = (isset($server['DEVELOPMENT_ENV']))? $server['DEVELOPMENT_ENV'] : 'production' ;
	}
}
