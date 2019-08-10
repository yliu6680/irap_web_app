<?php
  require "header.php";
?>
<div class="irap-title">
  <div class="container">
    <h1>Select your methods for the analysis</h1>
  </div>
</div>

<div class="container">
  <form class="irap-form" name="conf_file" action="?" method="post" content-type="multipart/form-data" >
    <div name="name">
      <b>Project name:</b><br>
      <input type="text" name="name" id="name">
    </div>

    <br>

    <div name="species">
      <b>Species:</b><br>
      <select name="species" id="species">
        <option value="Human">Human</option>
        <option value="Mouse">Mouse</option>
        <option value="Zebrafish">Zebrafish</option>
        <option value="ecoli_k12">ecoli_k12</option>
        <option value="Arabidopsis thaliana">Arabidopsis thaliana</option>
      </select>
    </div>

    <br>

    <div name="mapper" id="mapper">
      <b>Alignment tools:</b><br/>

      <label for="STAR">STAR</label>
      <input type="radio" name="mapper" id="star" value="star" checked/>

      <label for="TopHat2">TopHat2</label>
      <input type="radio" name="mapper" id="tophat2" value="tophat2"/>

      <label for="Bowtie2">Bowtie2</label>
      <input type="radio" name="mapper" id="bowtie2" value="bowtie2"/>

      <label for="BWA2">BWA2</label>
      <input type="radio" name="mapper" id="bwa2" value="bwa2"/>

      <label for="MapSplice">MapSplice</label>
      <input type="radio" name="mapper" id="mapsplice" value="mapsplice"/>

    </div>

    <br>

    <div name="Quantification" id="Quantification">
      <b>Quantification tools:</b><br>

      <label for="Cufflinks2">Cufflinks2</label>
      <input type="radio" name="quantification" id="Cufflinks2" value="cufflinks2"/>

      <label for="HT-Seq2">HT-Seq2</label>
      <input type="radio" name="quantification" id="HT-Seq2" value="htseq2"/>

      <label for="Kallisto">Kallisto</label>
      <input type="radio" name="quantification" id="Kallisto" value="kallisto"/>

      <label for="Salmon">Salmon</label>
      <input type="radio" name="quantification" id="Salmon" value="salmon"/>

      <label for="FeatureCounts">FeatureCounts</label>
      <input type="radio" name="quantification" id="FeatureCounts" value="featurecounts" checked/>


    </div>

    <br>

    <div name="DE_methods" id="DE_methods">
      <b>Diffierential expression analysis tools:</b><br>

      <label for="Cuffdiff2">Cuffdiff2</label>
      <input type="radio" name="DE_methods" id="Cuffdiff2" value="cuffdiff2"/>

      <label for="DESeq2">DESeq2</label>
      <input type="radio" name="DE_methods" id="DESeq2" value="deseq2" checked/>

      <label for="EdgeR">EdgeR</label>
      <input type="radio" name="DE_methods" id="EdgeR" value="edger" />

    </div>

    <br>

    <input class="btn btn-default" type="submit" name="submit" value="Submit options" />

  </form>

<?php
if (isset($_POST['name'])) {
  #print_r($_POST);
  #session_start();
  #print_r($_SESSION);

  $data_store = $_SESSION['all_data_dir'];

  $name=$_POST['name'];
  $species=$_POST['species'];
  
  #according to the species, get the corresponded genome data, copy a link?
  #$reference="../data/".$species."/".$species.".fasta";
  #$gtf="../data/".$species."/".$species.".gtf";
  $reference_dir=$species.".fa.gz";
  $gtf_dir=$species.".gtf";

  $user_trans="auto";
  $raw_data_dir=$data_store."data/";
  $cont_index="no";
  $mapper=$_POST['mapper'];
  $quantification=$_POST['quantification'];
  $DE_methods=$_POST['DE_methods'];

  $template_dir="/var/www/script/irap_conf_template.conf";
  #$template_dir="../script/irap_conf_template.conf";   ### local change

  $output_dir="/var/www/html/users/".$_SESSION['usrname'].'/'.$_SESSION['md5_code']."/".$_POST['name'].".conf"; 
  #$output_dir=".".'/'.$_POST['name'].".conf";   ### local change

  $meta_data=$_SESSION['all_data_dir'].$_SESSION['files_names']['meta_data'];
  
  $_SESSION['conf']=array("name"=>$name,
	  "species"=>$species,
	  "mapper"=>$mapper,
	  "quantification"=>$quantification,
	  "de_method"=>$DE_methods,
	  "template_dir"=>$template_dir,
	  "output_dir"=>$output_dir,
    "meta_data"=>$meta_data);
  
  $script_dir = "/var/www/script/generate_conf.py";
  #$script_dir = "../script/generate_conf.py";   ###local change

  $cmd = shell_exec("python3 ".$script_dir." --name=".$name." --species=".$species." --reference=".$reference_dir." --gtf_file=".$gtf_dir." --user_trans=".$user_trans." --data_dir=".$raw_data_dir." --cont_index=".$cont_index." --mapper=".$mapper." --quant_method=".$quantification." --quant_norm_tool=irap --quant_norm_method=fpkm --de_method=".$DE_methods." --template_dir=".$template_dir." --output_dir=".$output_dir." --meta_data=".$meta_data." 2>&1");

#  $cmd = shell_exec("python ".$script_dir." --name=".$name." --species=".$species." --reference=".$reference_dir." --gtf_file=".$gtf_dir." --user_trans=".$user_trans." --data_dir=".$raw_data_dir." --cont_index=".$cont_index." --mapper=".$mapper." --quant_method=".$quantification." --quant_norm_tool=irap --quant_norm_method=fpkm --de_method=".$DE_methods." --template_dir=".$template_dir." --output_dir=".$output_dir." --meta_data=".$meta_data." 2>&1");
  
  print_r($cmd);

  echo "<br><a class='btn irap-btn' href='irap_02_conf_review.php' role='button'>Next: review iRAP options</a>";

}
?>

<br>
</div>

<?php
  require "footer.php";
?>

