<?php
    session_start();
 ?>
<html>
	<head>
		<title>Dashboard</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css" rel="stylesheet">
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
						<li class="active"><a href="index.php">Dashboard</a></li>
						<li><a href="posts.php">Posts</a></li>
						<li><a href="#">Users</a></li>
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
						<li><a href="settings.php">Settings</a></li>
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
					<h1>Dashboard</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Recent Activity</h3>
						</div>
						<div class="panel-body">
							<section class="item">
								<div class="icon pull-left">
									<i class="fa fa-edit"></i>
								</div>
								<div class="item-body">
									<p>James Errick edited New Website</p>
									<div class="time pull-left">
										<p>A moment ago</p>
									</div>	
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Feed</h3>
						</div>
						<div class="panel-body">
							<section class="item">
								<div class="icon pull-left">
									<i class="fa fa-comment"></i>
								</div>
								<div class="item-body">
									<p class="item-text">John Doe commented on New Website</p>
									<div class="time pull-left">
										<p>A moment ago</p>
									</div>							
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</body>
</html>
