<?php
class ErrorController extends Controller
{
    function http404()
    {
		header("HTTP/1.1 404 Not Found");
    }
    function http500()
    {
        header("HTTP/1.1 500 Internal Server Error");
    }
}