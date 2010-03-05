<?php
class ErrorController extends Controller
{
    function error403()
	{
		header("HTTP/1.1 403 Forbidden");
	}
	function error404()
    {
		header("HTTP/1.1 404 Not Found");
    }
    function error500()
    {
        header("HTTP/1.1 500 Internal Server Error");
    }
}