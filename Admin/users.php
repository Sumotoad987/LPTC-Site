<?php
    session_start();
 ?>
<html>
	<head>
		<title>Dashboard</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=0.2" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
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
							<p><i class="fa fa-users" aria-hidden="true"></i> Users</p>
							<a href="invite.php"><button class="btn btn-default add"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-user" aria-hidden="true"></i></button></a>
						</div>
						<div>
							<?php
								require_once("../includes/dbconnect.php");
								$results = $connection->query("Select Email, Username, Rank FROM Users");
								if($results->num_rows > 0){
                					while($row = $results->fetch_assoc()){
                						$hashed = md5($row['Email']);
                						echo('<div class="user"><div class="user-img"><img src="https://www.gravatar.com/avatar/' . $hashed . '?d=mm"></div>
                						<div class="user-details"><h3>' . $row['Username'] . '</h3><p>' . $row['Email'] . '</p><p class="rank">' . $row['Rank'] . '</p></div></div>');
                					}
                				}							
                			?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
