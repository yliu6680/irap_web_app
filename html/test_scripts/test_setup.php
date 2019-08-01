<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
require("functions.php");
$temp = irap_set_up("phptest","ecoli_k12","lyr");
settype($temp, "string");
print_r(gettype($temp));
if ($temp == '0'){
  echo 'success'; 
} else {
  echo 'fail';
}
#$a = irap_set_up("phptest22","ecoli_k12","lyr");
#echo gettype($a);

?>
