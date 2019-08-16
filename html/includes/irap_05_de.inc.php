<?php
if (!isset($reffer_from_php)) {
  header("Location: error_pages/forbidden.php");
  exit();
}

$username = $_SESSION['check_user'];
$case_id = $_SESSION['case_id'];
$json_dir = "/var/www/html/users/" . $username . '/' . $case_id . '/' . 'irap_options.json';
$strJsonFileContents = file_get_contents($json_dir);
$json_array = json_decode($strJsonFileContents, true);
$conds = array(
	"1" => array_keys($json_array['meta_dict']['cond_lib'])[0],
	"2" => array_keys($json_array['meta_dict']['cond_lib'])[1],
);
$tsv_file_name = $conds['1'] . 'Vs' . $conds['2'] . '.genes_de.tsv';
$root_dir = "users/" . $username . '/' . $case_id . '/' . $json_array['name']. '/';
$de_dir = 'irap_qc/' . $json_array['method_dict']['mapper'] . '/' . $json_array['method_dict']['quantification'] . '/' . $json_array['method_dict']['de_method'] . '/';
$tsv_dir = $root_dir . $de_dir . $tsv_file_name;
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
      .padding-div{
        padding-top:2.5%;
      }
    </style>
  </head>
<body>
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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
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

	<script
  		src="https://code.jquery.com/jquery-2.2.4.js"
  		integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  		crossorigin="anonymous">
  	</script>
  	<script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  	<script src="http://d3js.org/d3.v3.min.js"></script>

	<script type="text/javascript">
<?php
   echo "d3.tsv('".$tsv_dir."', function(d) {
";
?>
	  		console.log(typeof d);
  		if ( +d.padj <= 0.05) {
  		return [
   	 	d.id, // convert "Year" column to Date
   	 	+d.log2FoldChange,
    	+d.stat,
    	+d.pval,
    	+d.padj // convert "Length" column to number
  		]};
	}, function(error, rows) {
  	$(document).ready(function() {
    $('#example').DataTable( {
        data: rows,
        columns: [
            { title: "id" },
            { title: "log2FoldChange" },
            { title: "stat" },
            { title: "pval" },
            { title: "padj" }
        	]
    	} );
	} );
	});
  	</script>


<div class="irap-title">
  	<div class="container"> 
		<h1>Show the differential expression result:</h1>
  	</div>
</div>  

<br>
<div class="container">
<table id="example" class="display" width="100%"></table>
</div>
<div class="padding-div-top"></div>

<footer>
</footer>

</body>
</html>





