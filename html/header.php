<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="This is an example of a meta description. This will often show up in search results.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title></title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
      .irap-title {
        padding-top: 5%;
        padding-bottom: 2.5%;
        background-color: #6f5499;
      }
      .irap-title h1 {  
        color: white;
      }
      .irap-title p {
        color: #cdbfe3;
      }
      .irap-form {
        padding-top: 2%; 
      }
      .irap-btn {
        color: white;
        background-color: #6f5499;
        border-color: #6f5499;
      }
      .padding-div-top {
        padding-top: 2.5%;
      }
      .padding-div-bottom {
        padding-bottom: 2.5%;
      }
      .irap-link-color {
        color: black;
      }
      .signuperror {
        padding-top: 14px;
        font-family: arial;
        font-size: 16px;
        color: red;
      }      
      .signupsuccess {
        padding-top: 14px;
        font-family: arial;
        font-size: 16px;
        color: green;
      }
    </style>
  </head>
  <body>

    <!-- Here is the header where I decided to include the login form for this tutorial. -->
    <header>
      <div class="container">
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="home.php" class="navbar-brand"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> IRAP</a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php
            if (!isset($_SESSION['usrname'])){
              echo '<li><a href="irap_signup.php">Signup</a></li>';
              echo '<li><a href="irap_login.php">Login</a></li>';
            }
            else {
              echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </li>';
              echo '<li><a href="includes/logout.inc.php">Logout</a></li>';
            }
            ?>
            </ul>
         
          </div>
        </div>
      </nav>
      </div>
      <div class="header-login">
      
        <!--
        Here is the HTML login form.
        Notice that the "method" is set to "post" because the data we send is sensitive data.
        The "inputs" I decided to have in the form include username/e-mail and password. The user will be able to choose whether to login using e-mail or username.

        Also notice that using PHP, we can choose whether or not to show the login/signup form, or to show the logout form, if we are logged in or not. We do this based on SESSION variables which I explain in more detail in the login.inc.php file!
        -->

      </div>
    </header>