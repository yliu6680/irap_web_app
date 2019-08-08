<?php
  require "header.php";
?>
<div class="irap-title">
  <div class="container">
    <h1>iRAP analysis login page</h1>
  </div>
</div>

<div class="container">
  <form action="?" method="post" class="irap-form">
    <div class="row">
      <div class="form-group col-lg-4">
        <label>Username</label>
        <input type="text" class="form-control" id="UsrName" name="UsrName">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-4">
        <label>Password</label>
        <input type="password" class="form-control" id="Password" name="Password">
      </div>
    </div>
  <input type="submit" value="login">
  </form>
</div>


<?php
#echo exec('whoami')."</br>";
if (isset($_POST['UsrName'])) {
  #session_start();
  $_SESSION['usrname']=$_POST['UsrName'];
  print_r($SESSION);
  $UserName = $_POST["UsrName"];
  $cmd1 = shell_exec("python3 /var/www/script/generate_dir.py ".$UserName." 2>&1");
  echo $cmd1;

  #$cmd2 = shell_exec("python3 /var/www/script/generate_php.py upload.php ".$UserName." 2>&1");
    #echo $cmd2;

  #$cmd3 = shell_exec("python3 /var/www/script/generate_php.py analysis.php ".$UserName." 2>&1");
  #echo $cmd3;

  #$cmd4 = shell_exec("python3 /var/www/script/generate_php.py download.php ".$UserName." 2>&1");
  #echo $cmd4;

  sleep(1);

  header("Location: irap_00_upload.php");

}
require "footer.php";
?>
