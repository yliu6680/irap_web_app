<?php
error_reporting(E_ALL ^ E_WARNING);
require("functions.php");
$UserName = "abc";
$md5_code = generate_md5_code($UserName);
mkdir("/var/www/data/".$UserName."/$t", 0775);
print_r($md5_code);
?>
