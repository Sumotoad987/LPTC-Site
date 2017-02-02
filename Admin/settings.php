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
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    $p->hasPermisson(["Admin"]);
 ?>
<html>
	<head>
		<title>Settings</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=0.55324" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js" type="text/javascript"></script>
		<script>
			$(document).ready(function() {
  				tooltipRight();
  				var denied = $('.deniedJavascript');
				setTimeout(function(){
  
				  if (denied.hasClass('hidden')) {
					denied.removeClass('hidden');
					setTimeout(function () {
					  denied.removeClass('visuallyhidden');
					}, 20);
				  } else {
	
					denied.addClass('visuallyhidden');
	
					denied.one('transitionend', function(e) {

					  denied.addClass('hidden');

					});
	
				  }
				}, 4000);
			});
			function prepareForm(){
				var editor = ace.edit('htmlEditor');
				var textarea = $('textarea[name="Header"]');
				textarea.val(editor.getSession().getValue());
			}
		</script>
	</head>
	<body>
		<div class="wrapper">
		<nav class="nav navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<?php
					include("../includes/navigation.php");
				?>
			</div>
		</nav>
		<div class="container-fluid content">
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header">
							<p><i class="fa fa-cog" aria-hidden="true"></i> Settings</p>
						</div>
						<?php
							$varibles = array();
							$varibles[0] = "Sorry your file was not a image";
							$varibles[1] = "Sorry, only JPG, JPEG, PNG, GIF & ICO files are allowed.";
							$varibles[2] = "Sorry your file was not uploaded please try again";
							if(isset($_GET['failed'])){
								echo("<p class='deniedJavascript'>{$varibles[$_GET['failed']]}</p>");
							}
						?>
						<div class="box-content">
							<form onsubmit="prepareForm()" method="POST" action="Actions/settings.php">
								<p>Site title:</p>
								<?php
									$results = $connection->query("Select Title, Description, Header From Settings");
									if($results->num_rows > 0){
										while($row = $results->fetch_assoc()){
											echo("<input name='Title' class='large-input' value='{$row['Title']}'>");
											echo("<p>Site description:</p><input name='Description' class='large-input' value='{$row['Description']}'>");
											$header = isset($row['Header']) ? $row['Header'] : "";
										}
									}
								?>
								<p>Header:</p>
								<textarea style="display:none" name='Header'><?php echo($header); ?></textarea>
								<div id="htmlEditor" class='headerEditor'></div>
								<script src="../includes/ace-src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
								<script>
									var editor = ace.edit("htmlEditor");
									editor.setTheme("ace/theme/tommorow");
									editor.getSession().setMode("ace/mode/html");
									value = $("[name=Header]").text();
									editor.session.setValue(value, -1);
								</script>
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
