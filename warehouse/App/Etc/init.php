<?php

include 'config.php';
include 'func.php';

function my_autoload ($pClassName)
 {
    $pClassName = str_replace('\\', DIRECTORY_SEPARATOR, $pClassName);
    include("../" . $pClassName . ".php");
  }
  spl_autoload_register("my_autoload");

mb_internal_encoding('UTF-8');