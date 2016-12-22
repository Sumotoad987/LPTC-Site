<?php
    session_start();
 ?>
<html>
	<head>
		<title>Ranks</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=0.21" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script>
			$(document).ready(function(){
    			$('[data-toggle="tooltip"]').tooltip({ placement: 'right'}); 
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
					<h1>Users</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header">
							<p><i class="fa fa-users" aria-hidden="true"></i> Ranks</p>
							<a href="rank.php"><button class="btn btn-default add"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
						</div>
						<div>
							<form action="rank.php" method="POST">
								<table style="width:100%;">
									<tr>
										<th>Name</th>
										<th>Premissons</th>
									</tr>
									<?php
										require_once("../includes/dbconnect.php");
										$sql = "Select Id, Name, Premissons FROM Ranks ORDER BY id";
										$results = $connection->query($sql);
										if($results->num_rows > 0){
											while($row = $results->fetch_assoc()){
												echo("<tr><td>" . $row['Name'] . '</td><td>');
												$premissons = explode(",", $row['Premissons']);
												echo("<input type='hidden' name='{$row['Name']}[]' value='{$row['Premissons']}'>");
												echo("<input type='hidden' name='{$row['Name']}[]' value='{$row['Id']}'>");
												$stmt = $connection->prepare("Select Provider, Description From Premissons where Name = ?");
												foreach($premissons as $premisson){
													$stmt->bind_param("s", $premisson);
													$stmt->execute();
													$stmt->bind_result($provider, $description);
													$stmt->fetch();
													echo("<a data-toggle='tooltip' title='{$description}'>{$provider}_{$premisson}</a> ");
												}
												$stmt->close();
												echo('<button type="submit" value="' . $row['Name'] .'" name="Rank_Name" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>');
												echo("</td></tr>");
											}
										}
									?>
								</table>
							</form>
							<!-- 
<?php
								require_once("../includes/dbconnect.php");
								$results = $connection->query("Select Email, Username, Rank, id FROM Users");
								if($results->num_rows > 0){
                					while($row = $results->fetch_assoc()){
                						$hashed = md5($row['Email']);
                						echo('<form method="POST" style="margin-bottom:0" action="user.php"><div class="user" onclick="javascript:this.parentNode.submit();"><div class="user-img"><img src="https://www.gravatar.com/avatar/' . $hashed . '?d=mm"></div>
                						<div class="user-details"><input name="id" type="hidden" value="' . $row['id'] . '"><h3>' . $row['Username'] . '</h3><p>' . $row['Email'] . '</p><p class="rank">' . $row['Rank'] . '</p></div></div></form>');
                					}
                				}							
                			?>
 -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
