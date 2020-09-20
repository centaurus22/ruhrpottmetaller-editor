<?php
function custom_autoloader($class) {
  include 'rpmetaller/' . $class . '.php';
}

spl_autoload_register('custom_autoloader');
