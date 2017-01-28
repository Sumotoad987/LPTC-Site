<?php
	session_start();
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
   	require_once("../includes/functions.php");
    $p = new Permissons($_SESSION["rank"], $connection);
?>
<html>
	<head>
		<title>Dashboard</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=0.17" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js" type="text/javascript"></script>
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
				<?php
					if(isset($_GET['denied'])){
						echo("<p class='denied'>Sorry you do not have the required permisson to access that page</p>");
					}
				?>
				<div class="col-lg-8">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Recent Activity</h3>
						</div>
						<div class="panel-body">
							<?php
								$sql = "Select CorrespondingId, Name, UserId, Date, Type, Action From Activity Order By Date DESC LIMIT 7";
								$results = $connection->query($sql);
								$usernameQuery = $connection->prepare("Select Username From Users Where Id = ?");
								if($results->num_rows > 0){
									while($row = $results->fetch_assoc()){
										date_default_timezone_set("Europe/Dublin"); 
										$posted = new DateTime($row['Date']);
										$timeSince = timeSince($posted);
										$usernameQuery->bind_param("i", $row['UserId']);
										$usernameQuery->execute();
										$usernameQuery->bind_result($username);
										$usernameQuery->fetch();
										$href = isset($row['CorrespondingId']) ? "href='{$row['Type']}.php?id={$row['CorrespondingId']}'" : "";
										echo("<section class='item panel-item'><div class='icon'><i class='fa fa-edit pull-left'></i></div>
										<div class='item-body'><p>{$username} {$row['Action']} <a $href>{$row['Name']}</a></p><div class='time'><p>{$timeSince}</p></div>
										</div></section>");
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id='dashboardAddons'>
				<i class="fa fa-user fa-5x circle-fa" aria-hidden="true"></i>
				<p class="circle-text">The Dashboard is a place of you, get more addons to cuztomize it</p>
			</div>
		</div>
		</div>
	</body>
</html>
