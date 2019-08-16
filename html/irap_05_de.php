<?php
  session_start();
  if (isset($_SESSION['usrname']) || isset($_SESSION['case_id'])){
    $reffer_from_php = 0;
    require "includes/irap_05_de.inc.php";
  } else {
    header("Location: error_pages/need_login.php");
  }

