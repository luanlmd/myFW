<?php
require("../classes/App.php");

// Shortcuts:
// function p($par) { return Request::par($par); }
// function l($url) { return new Link($url); }

// Routes:
// App::addRoute("^/a/?$","about"); // example.com/a is the same as example.com/about

// Setup Database connection:
// Database::getInstance()->init('dsn','user','password');

// Run the App. The id parameter will make sure all the Sessions and Cookies use unique keys and become encrypted

App::run("Your Project Name/ID");