<!DOCTYPE html>
<html>
<body>
    <h1>iRAP analysis login page</h1>

<form action="?" method="post">
名字: <input type="text" id="UsrName" name="UsrName">
<input type="submit" value="login">
</form>

<?php
echo exec('whoami')."</br>";
if (isset($_POST['UsrName'])) {
  session_start();
  $_SESSION['usrname']=$_POST['UsrName'];

  echo $_SESSION;

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
?>

</body>
</html>
