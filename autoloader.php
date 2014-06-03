<?php
/**
 * Simple function to autoload classes
 * via spl_autoload
 * 
 * @param string $class
 */
function autoloader($class) {
    include $class . '.php';
}

spl_autoload_register('autoloader');
?>
