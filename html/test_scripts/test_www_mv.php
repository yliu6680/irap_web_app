<!DOCTYPE html>
<html>
<body>

<form name="data_file" action="?" method="post" enctype="multipart/form-data">
  <div name="test_mv">
    <b><label>Just upload a file:</label></b>
    <input type="file" name="test_file" id="test_file" multiple/>
    <br/>
  </div>
<input type="submit" name="submit" value="Upload" />
</form>

<?php
if(!empty($_POST)){
  ini_set('display_errors', true);
  error_reporting(E_ALL);

  $file=$_FILES['test_file'];
  $data_store='/home/ubuntu/test_www_mv/';
  $tmp_dir=$file['tmp_name'];
  if (move_uploaded_file($tmp_dir, $data_store.$file['name'])) {
    echo "<br>";
    echo "file name: ".$file['name']."<br>";
    echo "file type: ".$file['type']."<br>";
    echo "file temp locate: ".$data_store."<br>";
    echo "file size: ".$file['size']."<br>";
    echo "error message: ".$file['error']."<br>";
    echo "<br>";
  }
  exec('export IRAP_DIR=/home/ubuntu/irap/irap_install && export PATH=$IRAP_DIR/python/bin/:$IRAP_DIR/bin/bowtie1/bin:$IRAP_DIR/bin:$IRAP_DIR/scripts:$IRAP_DIR/python/bin/:$IRAP_DIR/cellBrowser/:$PATH && export LD_LIBRARY_PATH=$IRAP_DIR/lib:$LD_LIBRARY_PATH: && export CFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost  $CFLAGS" && export R_LIBS_USER=/home/ubuntu/irap/irap_install/Rlibs && export R_LIBS=/home/ubuntu/irap/irap_install/Rlibs && export CXXFLAGS="-I$IRAP_DIR/include -I$IRAP_DIR/include/bam -I$IRAP_DIR/include/boost -L$IRAP_DIR/lib $CXXFLAGS" && export PERL5LIB=$IRAP_DIR/perl/lib/perl5:$IRAP_DIR/lib/perl5:$IRAP_DIR/lib/perl5/x86_64-linux:$IRAP_DIR/lib/perl5/5.20.3 && export PYTHONUSERBASE=$IRAP_DIR/python && export PYTHONPATH=$IRAP_DIR/lib64/python2.7/site-packages:$IRAP_DIR/lib/python2.7/site-packages:$PYTHONPATH && export MEM=10000 && export THREADS=8 && printenv && irap -h && cd ./test_result/ && irap conf=/home/ubuntu/irap/irap_example.conf max_threads=8 2>&1', $output, $return_var);
  print_r($output);
  echo "<br><br><br>";
  print_r($return_var);
  echo "<br><br><br>";

  exec("source ./irap_setup.sh && irap -h 2>&1" , $output, $return_var);
  print_r($output);
  echo "<br><br><br>";
  print_r($return_var);
  echo "<br><br><br>";

  exec("irap -h 2>&1", $output, $return_var);
  print_r($output);
  echo "<br><br><br>";
  print_r($return_var);
  echo "<br><br><br>";

}
?>

</body>
</html>
