<?php
require('library/SplClassLoader.php');
$loader = new SplClassLoader();
$loader->setIncludePath(realpath(dirname(__FILE__)));
$loader->register();

//library\ThinPHP\App::init();

// Shortcuts:
function d($a, $d = false) { var_dump($a); if ($d) { die(); } }

// Routes:
// App::addRoute("^/a/?$","about"); // example.com/a is the same as example.com/about

// Run the App.
library\ThinPHP\App::run();
