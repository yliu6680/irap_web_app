<?php
  require "header.php";
?>
<div class="irap-title">
  <div class="container">
    <h1>iRAP result page</h1>
  </div>
</div>
<div class="padding-div"></div>
<div class="container">
<form name="case_number" action="?" method="post" enctype="multipart/form-data">

  <div name="name">
    <b>Please enter your user name:</b></br>
    <input type="text" name="name" id="name">
  </div>

  <div name="name">
    <b>Please enter your case number:</b></br>
    <input type="text" name="case_id" id="case_id">
  </div>

  <br>

  <input class="btn btn-default" type="submit" name="submit" value="Submit options" />

</form>

<?php
#session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);
$file_add = "";

if (isset($_POST['submit'])){
  $case_id=$_POST['case_id'];
  #$conf_file=$_SESSION['conf'];
  print_r("<br>Your case id is:".$case_id.", download your result:");
  $file_name = "result";
  $file_add = '/users/'.$_POST['name'].'/'.$case_id.'/'.$file_name.'.tar.gz';
  print_r($file_add."<br>");


} else {
  echo "<br>Your case id is not set, set it in the above text box"."<br>";
}

echo '<a class="btn irap-btn" role="button" href='.$file_add.' download>Download results</a>';

?>
</div>
<?php
  require "footer.php";
?>


