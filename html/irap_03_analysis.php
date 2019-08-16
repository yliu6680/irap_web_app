<!DOCTYPE html>
<html>
<body>
  <h1>Analysis status</h1>

<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
require("functions.php");
session_start();

$usrname=$_SESSION['usrname'];
$conf_file=$_SESSION['conf'];

$temp = irap_set_up($_SESSION['all_data_dir'], $conf_file['species'], $usrname);

$output_dir = "/var/www/html/users/".$usrname."/".$_SESSION['md5_code']."/";
$conf_dir = $conf_file['output_dir'];
$max_threads = 8;

$email = mysqli_get_email_by_id($_SESSION['id']);

# run the test mode of the pipeline
if ($temp == '0'){    
  echo "<script>alert('Your analysis has started successfully;)</script>";
  exec('export IRAP_DIR=/home/ubuntu/irap/irap_install && export PATH=$IRAP_DIR/python/bin/:$IRAP_DIR/bin/bowtie1/bin:$IRAP_DIR/bin:$IRAP_DIR/scripts:$IRAP_DIR/python/bin/:$IRAP_DIR/cellBrowser/:$PATH && export LD_LIBRARY_PATH=$IRAP_DIR/lib:$LD_LIBRARY_PATH: && export CFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost  $CFLAGS" && export R_LIBS_USER=/home/ubuntu/irap/irap_install/Rlibs && export R_LIBS=/home/ubuntu/irap/irap_install/Rlibs && export CXXFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost -L$IRAP_DIR/lib $CXXFLAGS" && export PERL5LIB=$IRAP_DIR/perl/lib/perl5:$IRAP_DIR/lib/perl5:$IRAP_DIR/lib/perl5/x86_64-linux:$IRAP_DIR/lib/perl5/5.20.3 && export PYTHONUSERBASE=$IRAP_DIR/python && export PYTHONPATH=$IRAP_DIR/lib64/python2.7/site-packages:$IRAP_DIR/lib/python2.7/site-packages:$PYTHONPATH && export MEM=10000 && export THREADS=8 && printenv && irap -h && cd '.$output_dir.' && irap conf='.$conf_dir.' max_threads='.$max_threads.' -n 2>&1', $output_test, $return_var_test);
  echo "<br><br><br>";
  #print_r($output_test);
  echo "<br><br><br>";
  #print_r($return_var_test);
  echo "<br><br><br>";
} else {
  echo "<script>alert('something wrong with getting data;')</script>";
}

if (!$return_var_test){
  # run the pipeline, output the result to the result directory and package them to the html directory.
  exec("python3 /var/www/script/sendmail.py ld20171225@gmail.com " . $email . " " . $_SESSION['md5_code'] . " started"); 
  exec('export IRAP_DIR=/home/ubuntu/irap/irap_install && export PATH=$IRAP_DIR/python/bin/:$IRAP_DIR/bin/bowtie1/bin:$IRAP_DIR/bin:$IRAP_DIR/scripts:$IRAP_DIR/python/bin/:$IRAP_DIR/cellBrowser/:$PATH && export LD_LIBRARY_PATH=$IRAP_DIR/lib:$LD_LIBRARY_PATH: && export CFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost  $CFLAGS" && export R_LIBS_USER=/home/ubuntu/irap/irap_install/Rlibs && export R_LIBS=/home/ubuntu/irap/irap_install/Rlibs && export CXXFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost -L$IRAP_DIR/lib $CXXFLAGS" && export PERL5LIB=$IRAP_DIR/perl/lib/perl5:$IRAP_DIR/lib/perl5:$IRAP_DIR/lib/perl5/x86_64-linux:$IRAP_DIR/lib/perl5/5.20.3 && export PYTHONUSERBASE=$IRAP_DIR/python && export PYTHONPATH=$IRAP_DIR/lib64/python2.7/site-packages:$IRAP_DIR/lib/python2.7/site-packages:$PYTHONPATH && export MEM=10000 && export THREADS=8 && printenv && irap -h && cd '.$output_dir.' && irap conf='.$conf_dir.' max_threads='.$max_threads.' && tar -cvzf result.tar.gz ./* | at -m now + 2 minutes  2>&1', $output, $return_var);
  exec("python3 /var/www/script/sendmail.py ld20171225@gmail.com " . $email . " " . $_SESSION['md5_code'] . " finished");
  echo "<br><br><br>";
  #print_r($output);
  echo "<br><br><br>";
  #print_r($return_var);
  echo "<br><br><br>";

  # remove the raw results directories
  if (file_exists($output_dir.$conf_file['name'].'.tar.gz')){
    rrmid($output_dir.$conf_file['name'].'/');
    rrmid($_SESSION['all_data_dir'].'/data/');
  }
} else {
  echo "<script>alert('something wrong with the pipeline setting;')</script>";
}
?>

<a href="irap_04_results.php"><button>Next:Show and download results</button></a>

</body>
</html>



