<?php
if (!isset($reffer_from_php)) {
	header('Location: ../error_pages/forbidden.php');
	exit();
}
?>

<div class="irap-title">
  <div class="container">
    <h1>Welcome to the homepage</h1> 
  </div>
</div>

<div class="container">
	<br>
	<p>IRAP - Integrated RNA-Seq Analysis Pipeline</p>
	<p>iRAP is a flexible RNA-seq analysis pipeline that allows the user to select and apply their preferred combination of existing tools for mapping reads, quantifying expression and testing for differential expression. Depending upon the application, iRAP can be used to quantify expression at the gene, exon or transcript level.</p>
	<br>
	<a class="btn irap-btn" href="irap_00_upload.php" role="button">Get Start!</a>
	<div class="padding-top"></div><br>
	<a class="btn irap-btn" href="irap_04_results.php" role="button">Get Your Submitted Results</a>
</div>
