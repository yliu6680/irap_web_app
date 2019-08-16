<?php
  require "header.php";

  if (isset($_SESSION['usrname'])){
    $reffer_from_php = 0;
    require "includes/irap_04_results.inc.php";
  } else {
    header('Location: error_pages/need_login.php');
  }

  require 'footer.php';


