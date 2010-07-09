<?php
require("../library/App.php");

// Shortcuts:
// function p($par) { return Request::par($par); }
// function l($url) { return new Link($url); }

// Routes:
// App::addRoute("^/a/?$","about"); // example.com/a is the same as example.com/about

// Setup Database connection:
// Database::getInstance()->init('dsn','user','password');

// Set environment to test if running this app localy. Errors will be printed instead of being logged.
App::$environment = ($_SERVER['SERVER_ADDR'] == "127.0.0.1" || $_SERVER['SERVER_ADDR'] == "::1")? 'test' : 'production';

// Salt. better change it.
App::$salt = 'l10hd91jd0bj16hjd91jds7df91';

// Run the App. The id parameter will make sure all the Sessions and Cookies use unique keys and become encrypted
App::run('thinphp');