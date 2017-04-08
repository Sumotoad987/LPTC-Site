<?php
    session_start();
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    $p->hasPermisson(["User_Edit"]);
    $stmt = $connection->prepare("Select Email, Username, Rank, RequestedRank From Users Where ID = ?");
   	$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_POST['id'] ;
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email, $username, $rank, $requestedRank);
    $stmt->fetch();
    $stmt->close();
 ?>
<html>
	<head>
		<title>Invite</title>
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
				$('.selectpicker').on('change', function(){
					console.log($('.selectpicker option:selected').attr('class'));
					if($('.selectpicker option:selected').attr('class') == 'approvalNeeded'){
						$('button.dropdown-toggle').removeClass('btn-defualt');
						$('button.dropdown-toggle').addClass('btn-danger');
					}else{
						$('button.dropdown-toggle').removeClass('btn-danger');
						$('button.dropdown-toggle').addClass('btn-default');
					}
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
							
							<p><b>
								<?php 
									$username = $username == "" ? "&#8291;" : $username;
									echo($username); 
								?>
							</b></p>
						</div>
						<div class="box-content">
							<form action="Actions/edit-user.php" method="POST">
								<p>Username:</p>
								<?php
									echo("<input name='id' type='hidden' value='{$_POST['id']}'>");
									echo("<input name='username' class='large-input' value='{$username}'><p>Email:</p><input name='email' class='large-input' value='{$email}'>");
								?>
								<p>Rank</p>
								<select name='rank' class='selectpicker' <?php if($requestedRank != NULL){ echo('data-style="btn-danger"'); } ?> >
									<?php
										// Get ranks
										$sql = "SELECT id, Name From Ranks ORDER BY id";
										$result = $connection->query($sql);
										echo("");
										if($result->num_rows > 0){
											while($row = $result->fetch_assoc()){
												$attribute = '';
												if($requestedRank != NULL){
													if($row['id'] == $requestedRank){
														$attribute = "selected class='approvalNeeded'";
													}elseif($row['id'] == $rank){
														$row['Name'] .= "(Current)";
													}
												}else{
													$attribute = $row['id'] == $rank ? "selected" : "";
												}
												echo("<option {$attribute} value='{$row[id]}'>"  . $row['Name'] . "</option>");
											}
										}	
									?>
								</select>
								<br>
								<input class="btn btn-primary" type="submit" name="save" value="Save user" style="">
								<input class="btn btn-danger delete-button" type="submit" name="Delete" value="Delete">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
