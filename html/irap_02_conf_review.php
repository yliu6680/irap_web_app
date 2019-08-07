<!DOCTYPE html>
<html>
<body>
  <h1>iRAP upload data and reference files:</h1>
  <h3>Review:</h3>

<?php
session_start();
echo "<b><p>Uploaded data:</p></b>";
$names=$_SESSION['files_names'];

echo "<p>Sequencing data:</p>";
$raw_data_files=$names['raw_data'];
foreach ($raw_data_files as $f) {
  echo "&nbsp";
  echo $f;
  echo "<br>";
}

echo "<b><p>Methods selected:</p></b>";
$conf_file=$_SESSION['conf'];

print_r('Project name: '.$conf_file['name']);
echo "<br>";
print_r('Species: '.$conf_file['species']);
echo "<br>";
print_r('Alignment method: '.$conf_file['mapper']);
echo "<br>";
print_r('Quantification: '.$conf_file['quantification']);

echo "<br>";

echo "<b><p>Your case code is:</p></b>";
echo $_SESSION['md5_code'];
echo "<br>";


$usrname=$_SESSION['usrname'];
echo "<b><p>Download configuration file:</p></b>";
echo "&nbsp";
echo "<a href='users/".$usrname."/".$_SESSION['md5_code']."/".$conf_file['name'].".conf'><button>Download</button></a>";
echo "<br>";

?>

<br>

<a href='irap_03_analysis.php'><button>Next: run the iRAP pipeline</button></a>

</body>
</html>

