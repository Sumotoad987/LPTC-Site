<?php
    session_start();
 ?>
<html>
	<head>
		<title>Add user</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=0.23" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css" rel="stylesheet">
		<script>
			$( document ).ready(function() {
				var text_max = 300;
				$('#count_message').html(text_max + ' remaining');
				$('.message').keyup(function() {
					var text_length = $('.message').val().length;
  					var text_remaining = text_max - text_length;
					$('#count_message').html(text_remaining + ' remaining');
				});
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
					<a class="navbar-brand">Homepage</a>				
				</div>
				<div class="collapse navbar-collapse" id="collapseable"> 
					<ul class="nav navbar-nav side-nav">
						<?php
							include("../includes/navigation.html");
						?>
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
					<h1>Invite</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header" style="text-align:center">
							<a href="users.php" style="float:left"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
							<p><b>Invite new user</b></p>
							<a href="users.php" style="visibility:hidden; float:right"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
						</div>
						<div class="box-content">
							<form action="Actions/invite.php" method="POST">
								<p>Email:</p>
								<input name="email" class="large-input">
								<p>Rank</p>
								<?php
									require_once("../includes/dbconnect.php");
									$sql = "SELECT Name From Ranks ORDER BY id";
									$result = $connection->query($sql);
									echo("<select name='rank' class='selectpicker'>");
									if($result->num_rows > 0){
										while($row = $result->fetch_assoc()){
											if($row['Name'] == $rank){
												echo("<option selected>"  . $row['Name'] . "</option>");
											}else{
												echo("<option>"  . $row['Name'] . "</option>");
											}
										}
									}	
									echo("</select>");
								?>
								<p>Custom message</p>
								<textarea maxlength="300" class="message" rows="3"></textarea>
								<p id="count_message"></p>
								<input class="btn btn-primary" type="submit" value="Invite user" style="float:right;">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
