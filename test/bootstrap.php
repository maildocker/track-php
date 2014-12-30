<?php 

include(dirname(dirname(__FILE__)) . '/lib/EventDocker.php');
EventDocker::register_autoloader();

function autoload_tests($class) {

  if (strpos($class, 'EventDockerTest_') !== 0) {
    return;
  }

  $class = substr($class, 13);
  $file = str_replace('_', '/', $class);
  if (file_exists(dirname(__FILE__) . '/' . $file . '.php')) {
    require_once(dirname(__FILE__) . '/' . $file . '.php');
  }
}

spl_autoload_register('autoload_tests');
