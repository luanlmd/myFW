<?php
namespace myFW\Exceptions;
class HttpException extends \Exception
{
	public function __construct($code = 0, Exception $previous = null)
	{
		parent::__construct('Http Error', $code, $previous);
    }
}
