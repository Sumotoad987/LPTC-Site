<?php
    session_start();
    if(isset($_GET['json_result'])){
    	$json = json_decode($_GET['json_result'], true);
    	$source = $json['favicon_generation_result']['favicon']['package_url'];
    	//Open the connection
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $source);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    	//Get the file
    	$data = curl_exec($ch);
    	curl_close($ch);
    	//Save the file
    	$destination = "favicons.zip";
    	$file = fopen($destination, "w+");
    	fputs($file, $data);
    	fclose($file);
    	//Unzip the file
    	$zip = new ZipArchive;
    	$res = $zip->open("favicons.zip");
    	echo($res);
    	if($res === TRUE){
    		$zip->extractTo("../");
    		array_map( "unlink", glob( "../images/favicon.*" ) );
    		unlink("favicons.zip");
    	}
    }
 ?>
<html>
	<head>
		<title>Settings</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=0.21" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script>
			$(document).ready(function() {
  				$('#tooltip').tooltip({ placement: 'right'});
			});
		</script>
	</head>
	<body>
		<div class="wrapper">
		<nav class="nav navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapseable">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand">Admin panel</a>				
				</div>
				<div class="collapse navbar-collapse" id="collapseable"> 
					<ul class="nav navbar-nav side-nav">
						<li><a href="index.php">Dashboard</a></li>
						<li><a href="#">General</a></li>
						<li><a href="posts.php">Posts</a></li>
						<li class="active"><a href="#">Users</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Pages<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Manage pages</a></li> 
								<li><a href="#">Create new page</a></li>
							</ul>
						</li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Addons<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Widgets</a></li>
								<li><a href="#">Plugins</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo($_SESSION["username"]);?><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">View account</a></li>
								<li><a href="#">Edit account</a></li>
								<li class="divider"></li>
								<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container-fluid content">
			<div class="row">
				<div class="col-lg-12">
					<h1>Users</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header">
							<p><i class="fa fa-cog" aria-hidden="true"></i> Settings</p>
						</div>
						<div class="box-content">
							<form method="POST" action="Actions/settings.php">
								<p>Site title:</p>
								<?php
									require_once("../includes/dbconnect.php");
									$results = $connection->query("Select Title, Description From Settings");
									if($results->num_rows > 0){
										while($row = $results->fetch_assoc()){
											echo("<input name='Title' class='large-input' value='" . $row['Title'] . "'>");
											echo('<p>Site description:</p><input name="Description" class="large-input" value="' . $row['Description'] . '">');
										}
									}else{
										echo('<input name="Title" class="large-input"><p>Site description:</p><input name="description" class="large-input">');
									}
									
								?>
								<input type="submit" class="btn btn-primary">
							</form>
							<form method="POST" enctype="multipart/form-data" action="Actions/upload.php">
								<p>Site image</p>
								<?php
									$file = glob("../favicon.*")[0];
									echo("<img class='image' src='" . $file . "'>");
								?>
								<input type="file" name="file" id="file" onchange="this.form.submit();" class="inputfile" />
								<button class="btn btn-primary" type="button"><label for="file" class="filelabel">Choose a file</label></button>
								<br>
								<p id="generator">Use Favicon Generator:</p><input type="checkbox" name="generator"><i class="fa fa-question-circle" aria-hidden="true" rel="tooltip" title="Creates multiple icons for mobile and browsers" id="tooltip"></i>
							<form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
