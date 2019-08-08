<?php
  require "header.php";
?>

<div class="irap-title">
  <div class="container">
    <h1>Upload fastq data and meta data:</h1> 
    <p>The fastq files should be valid, and corresponded to the meta data file (must be csv file), which means that names of the fastq files in your metadata should be the same with your uploaded fastq files. Plus, your cvs file should have multiple conditions and district file names. See an example file here.</p> 
  </div>
</div>

<div class="container">
  <form class="irap-form" name="data_file" action="?" method="post" enctype="multipart/form-data">
          <label><b>Raw data:</b></label>
	  <input type="file" name="raw_data[]" id="raw_data" multiple/>
	  <br>
          <label><b>Meta data:</b></label>
          <input type="file" name="meta_data" id="meta_data">
          <br>
          <input class="btn btn-default" type="submit" name="submit" value="Upload" />
</form>

<?php
error_reporting(E_ALL ^ E_WARNING);
require("functions.php");

session_start();
if(!empty($_POST)){
  #print_r($_POST);
  #echo "<br>";
  #print_r($_FILES);
  #echo "<br>";

  $fastq_files=$_FILES['raw_data'];
  $fasta_file=array('name'=>"fasta");
  $gtf_file=array('name'=>"gtf");
  $meta_file=$_FILES['meta_data'];

  $UserName= $_SESSION['usrname'];
  $md5_code = generate_md5_code($UserName);

  $data_store='/var/www/data/users/'.$UserName."/".$md5_code."/";    
  #$data_store='../data/';   ### local change

  # want to store information (addresses and names) of the uploaded files, should be changed in the future update.

  $_SESSION['all_data_dir']=$data_store;
  $_SESSION['md5_code']=$md5_code;
  $_SESSION['files_names']=array("raw_data"=>$fastq_files['name'],
	  "reference"=>$fasta_file['name'],
	  "gtf_file"=>$gtf_file['name'],
	  "meta_data"=>$meta_file['name']);

  #print_r($_SESSION);

  # move the file to user's directory
  parse_multifile($fastq_files, $data_store);
  parse_file($meta_file, $data_store);

  # check whether the uploaded files are valid
  $meta_data_dir = $data_store.$meta_file['name'];
  $upload_data_names = $fastq_files['name'];
  $meta_data_names = parse_csv_to_names($meta_data_dir, $delimiter=',');
  #echo "<br>meta dir:";
  #print_r($meta_data_dir);
  #echo "<br>meta: ";
  #print_r($meta_data_names);
  #echo "<br>upload: ";
  #print_r($upload_data_names);
  
  $check_status = check_file($meta_data_names, $upload_data_names, $data_store);

  if ($check_status == "success"){
    echo "<script>alert('success;')</script>";
  }
  elseif ($check_status == "fastq files name error") {
    echo "<script>alert('fastq files name error;')</script>";
  }
  elseif ($check_status == "fastq files content error") {
    echo "<script>alert('fastq files content error;')</script>";
  }
  else{
    echo "<script>alert('unkown errors;')</script>";
  }  
}
/*
  try{
    $check_status = check_file($meta_data_names, $upload_data_names, $data_store);
    echo $check_status;
  } catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
*/
?>

<br>

<a class="btn irap-btn" href="irap_01_conf.php" role='botton'>Next: iRAP options</a>
</div>
<?php
require "footer.php";
?>
