<?php
    session_start();
    require_once("../includes/permissons.php");
    require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    $p->hasPermisson(["User_Invite"]);
 ?>
<html>
	<head>
		<title>Add user</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=0.24" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js" type="text/javascript"></script>
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
				<?php
					include("../includes/navigation.php");
				?>
			</div>
		</nav>
		<div class="container-fluid content">
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header" style="text-align:center">
							<a href="users.php" class="back"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
							<p><b>Invite new user</b></p>
						</div>
						<div class="box-content">
							<form action="Actions/invite.php" method="POST">
								<p>Email:</p>
								<input name="email" class="large-input">
								<p>Rank</p>
								<select name='rank' class='selectpicker'>
								<?php
									$sql = "SELECT Name From Ranks ORDER BY id";
									$result = $connection->query($sql);
									if($result->num_rows > 0){
										while($row = $result->fetch_assoc()){
											echo("<option>"  . $row['Name'] . "</option>");
										}
									}
								?>
								</select>
								<p>Custom message</p>
								<textarea name="message" maxlength="300" class="message" rows="3"></textarea>
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
