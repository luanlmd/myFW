<?php
require("../libs/App.php");

// Shortcuts:
// function p($par) { return Request::par($par); }
// function l($url) { return new Link($url); }

// Routes:
// App::addRoute("^/a/?$","about"); // example.com/a is the same as example.com/about

App::run("Your Project Name/ID");
