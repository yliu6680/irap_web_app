<?php
  require "header.php";
?>
<div class="irap-title">
  <div class="container">
    <h1>iRAP Analysis Signup Page</h1>
  </div>
</div>

<div class="container">
  <?php
  // Here we create an error message if the user made an error trying to sign up.
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyfields") {
      echo '<p class="signuperror">Fill in all fields!</p>';
    }
    else if ($_GET["error"] == "sqlerror") {
      echo '<p class="signuperror">MySQL server error!</p>';
    }
    else if ($_GET["error"] == "invaliduidmail") {
      echo '<p class="signuperror">Invalid username and e-mail!</p>';
    }
    else if ($_GET["error"] == "invaliduid") {
      echo '<p class="signuperror">Invalid username!</p>';
    }
    else if ($_GET["error"] == "invalidmail") {
      echo '<p class="signuperror">Invalid e-mail!</p>';
    }
    else if ($_GET["error"] == "passwordcheck") {
      echo '<p class="signuperror">Your passwords do not match!</p>';
    }
    else if ($_GET["error"] == "usertaken") {
      echo '<p class="signuperror">Username is already taken!</p>';
    }
  }
  // Here we create a success message if the new user was created.
  else if (isset($_GET["signup"])) {
    if ($_GET["signup"] == "success") {
      echo '<p class="signupsuccess">Signup successful!</p>';
    }
  }
  ?>
  <form action="includes/signup.inc.php" method="post" class="irap-form">
    <div class="row">
      <div class="form-group col-lg-4">
        <label>Username</label>

        <?php
        // Here we check if the user already tried submitting data.

        // We check username.
        if (!empty($_GET["uid"])) {
          echo '<input type="text" class="form-control" id="UsrName" placeholder="Username" name="uid" value="'.$_GET["uid"].'">';
        }
        else {
          echo '<input type="text" class="form-control" name="uid" placeholder="Username">';
        }
        ?>

      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-4">
        <label>Email</label>

        <?php
        // We check e-mail.
        if (!empty($_GET["mail"])) {
          echo '<input type="text" class="form-control" name="mail" placeholder="E-mail" value="'.$_GET["mail"].'">';
        }
        else {
          echo '<input type="text" class="form-control" name="mail" placeholder="E-mail">';
        }
        ?>

      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-4">
      	<label>Password</label>
        <input type="password" class="form-control" id="Password" name="pwd" placeholder="Password">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-4">
        <label>Password Confirm</label>
        <input type="password" class="form-control" id="ConfirmPassword" name="pwd-repeat" placeholder="Confirm password">
      </div>
    </div>

    <button class="irap-btn" type="submit" name="signup-submit">Signup</button>
  </form>
</div>

<?php
require "footer.php";
?>