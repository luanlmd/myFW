<?php
class ErrorController extends Controller
{
    function error403Action()
	{
		header("HTTP/1.1 403 Forbidden");
	}
	function error404Action()
    {
		header("HTTP/1.1 404 Not Found");
    }
    function error500Action()
    {
        header("HTTP/1.1 500 Internal Server Error");
    }
}
