<?php
  require "header.php";
?>
<div class="irap-title">
  <div class="container">
    <h1>iRAP analysis login page</h1>
  </div>
</div>

<div class="container">
  <?php
    if (isset($_GET["login"])) {
      if ($_GET["login"] == "wronguidpwd") {
        echo '<p class="signuperror">Username has not been taken or password is not correct</p>';
      }
    }
    else if (isset($_GET["error"])) {
      if ($_GET["error"] == "emptyfields") {
        echo '<p class="signuperror">Fill in all fields!</p>';
      }
      else if ($_GET["error"] == "sqlerror") {
        echo '<p class="signuperror">MySQL server error!</p>';
      }
      else if ($_GET["error"] == "wrongpwd") {
	echo '<p class="signuperror">User name or password is not correct!';
      }
    }

  ?>
  <form action="includes/login.inc.php" method="post" class="irap-form">
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
  <input class="irap-btn" type="submit" name="login-submit" value="login">
  </form>
</div>

<?php
// if (isset($_POST['UsrName'])) {
//   $_SESSION['usrname']=$_POST['UsrName'];

//   #$cmd2 = shell_exec("python3 /var/www/script/generate_php.py upload.php ".$UserName." 2>&1");
//     #echo $cmd2;
//   #$cmd3 = shell_exec("python3 /var/www/script/generate_php.py analysis.php ".$UserName." 2>&1");
//   #echo $cmd3;
//   #$cmd4 = shell_exec("python3 /var/www/script/generate_php.py download.php ".$UserName." 2>&1");
//   #echo $cmd4;
//   sleep(1);
//   header("Location: home.php");
// }

require "footer.php";
?>
