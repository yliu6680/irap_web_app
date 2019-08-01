<?php
### functions in the irap_00_upload.php
# functions to parse $_FILES object data sturcture, and move it to user's own directory
function parse_multifile($file, $data_store){
  $file_num = count($file['name']);
  for($i=0; $i<$file_num; $i++){
    $temp=array("name"=>$file['name'][$i],
          "type"=>$file['type'][$i],
    "tmp_name"=>$file['tmp_name'][$i],
          "size"=>$file['size'][$i],
          "error"=>$file['error'][$i]);
    parse_file($temp, $data_store);
  }
  return;
} 

function parse_file($file, $data_store){    
  $temp_dir=$file['tmp_name'];
  $upload_dir=$data_store.$file['name'];
  if (move_uploaded_file($temp_dir, $upload_dir)) {
      echo "<br>";
      echo "file name: ".$file['name']."<br>";
      echo "file type: ".$file['type']."<br>";
      echo "file temp locate: ".$upload_dir."<br>";
      echo "file size: ".$file['size']."<br>";
      echo "error message: ".$file['error']."<br>";
      echo "<br>";
  }
  return;
}
######################################################################## methods used for checking input files
# parse the csv file into array
function parse_csv_to_names($filename, $delimiter=','){
  if(!file_exists($filename) || !is_readable($filename))
    return FALSE;

  $header = NULL;
  $data = array();
  if (($handle = fopen($filename, 'r')) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE){
      if(!$header) {
        $header = $row;
      } 
      else {
        $row = array_combine($header, $row);
        $librarylayout = strtolower($row['LibraryLayout']);
        if($librarylayout == 'single')
          $ret = array_push($data, $row['fastq1']);
        elseif ($librarylayout == 'paired') 
          $ret = array_push($data, $row['fastq1'], $row['fastq2']);
        else
          echo "<br>meta file format error;<br>";
      }
    }
    fclose($handle);
  }
  return $data;
}

# check whether the names are corresponded
function check_file($meta_fastq_names, $upload_fastq_names, $data_store){
  # 1. all file names should be corresponded with $meta_fastq_names, $upload_fastq_names, checked by the ***in_array($name, $upload_fastq_names)***.
  #    all file names should be unique, checked by the ***!in_array($name, $temp)***.
  #    all extensions should be fastq, checked by the ***$extention == 'fastq'***.
  $temp = array();
  
  foreach ($meta_fastq_names as $name) {
    $a = explode('.', $name);
    $s1 = end($a);
    $s2 = array_slice($a, -2, 1);
    $s2 = $s2[0];
    $extention1 = strtolower($s1);
    $extention2 = strtolower($s2);
    print_r($extention2);
    if (in_array($name, $upload_fastq_names) && !in_array($name, $temp) && ($extention1 == 'fastq' || $extention2 == 'fastq')){
      $temp[] = $name;
    }
    else {
      echo "<br>meta file fastq name error<br>";
      return "fastq files name error";
    }
  }
  
  # 2. the length of the two names array should be same
  if (!(count($meta_fastq_names) == count($upload_fastq_names))) {
    return "fastq files name error";
  }

  # 3. lastly, run the first file with fastqc, to make sure that the files are valid
  $example_fastq = $data_store.$upload_fastq_names[0];
  $fqc_out_dir = "/var/www/html/users/".$_SESSION['usrname']."/";
  echo $example_fastq;
  echo $fqc_out_dir;
  exec("python3 /var/www/script/run_fastqc.py ".$fqc_out_dir." ".$example_fastq." 2>&1", $output, $return);
  print_r($output);

  # check whether the results were generated by the fastqc algo
  $test_name = $upload_fastq_names[0];
  $s = explode( "fastq" ,$test_name);
  $t = $s[0];
  $ret = substr($t, 0, -1)."_fastqc.html";

  $filename = $fqc_out_dir.$ret;
  print_r($filename);
  echo (int)(!file_exists($filename))."<br>";

  # return the result, also delete the files generated by the fastqc algo
  if (!file_exists($filename)){
    return "fastq files content error";
  }

  array_map('unlink', glob($fqc_out_dir."*"));
  return "success";
}
########################################################################################################

# functions of analyzing
# set up the irap environment
function irap_set_up($project_name, $species, $username){
  exec('bash /var/www/script/irap_set_up.sh '.$project_name.' '.$species.' '.$username.' 2>&1', $output, $return_val);
  print_r($output);
  print_r($return_val);

  if (!$return_val) {
    return $return_val;
  } else {
    return !$return_val;
  }
}

# function that remove the irap result dreictories
function rrmdir($dir) { 
  if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) { 
      if ($object != "." && $object != "..") { 
        if (is_dir($dir."/".$object))
          rrmdir($dir."/".$object);
        else
          unlink($dir."/".$object); 
      } 
    }
    rmdir($dir); 
  } 
}

# function that generate a random code, according to the Unix epoch time and username
function generate_md5_code($usrname){
  $t = md5(date("U").$usrname);
  mkdir("/var/www/data/users/".$usrname."/".$t, 0775);
  mkdir("/var/www/html/users/".$usrname."/".$t, 0775);
  mkdir("/var/www/result/users/".$usrname."/".$t, 0775);
  # $_SESSION['md5_code'] = $t;
  return $t;
}
?>

