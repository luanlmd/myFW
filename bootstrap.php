<?php
require('library/SplClassLoader.php');
set_include_path(realpath(dirname(__FILE__)).'/library' . PATH_SEPARATOR . realpath(dirname(__FILE__)) . PATH_SEPARATOR . get_include_path());
$loader = new SplClassLoader();
$loader->register();

// Shortcuts:
function d($a, $d = false) { var_dump($a); if ($d) { die(); } }

// Routes:
// App::addRoute("^/a/?$","about"); // example.com/a is the same as example.com/about

// Run the App.
echo myFW\App::run($_SERVER);
