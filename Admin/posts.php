<?php
    session_start();
    require_once("../includes/functions.php");
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
 ?>
<html>
	<head>
		<title>Posts</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
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
						<!-- Side navigation bar -->
						<?php
							include("../includes/navigation.html");
						?>
						<!-- End of side navigation bar -->
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-user"></span> 
								<?php echo($_SESSION["username"]);?>
								<span class="caret"></span>
							</a>
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
                	<div class="box">
        				<div class="header"> 
        					<p>Posts</p>
        					<a href="post.php">
        						<button class="btn btn-default add">
        							<i class="fa fa-plus" aria-hidden="true"></i> 
        							<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
        						</button>
        					</a>
        				</div>
                   		<?php
                			$sql = "SELECT id, title, Posted from Posts";
                			$results = $connection->query($sql);
                			if($results->num_rows > 0){
                				while($row = $results->fetch_assoc()){
                					date_default_timezone_set("Europe/Dublin"); 
                					$posted = new DateTime($row['Posted']);
                					$timeSince = timeSince($posted);
                					echo("<form method='POST' action='post.php'><div onclick='javascript:this.parentNode.submit()' class='item'><div class='item-content'><input type='hidden' name='id' value='{$row['id']}'>
                					<h2>{$row['title']}</h2><p><i class='fa fa-clock-o'></i> {$timeSince}</i></p><i class='icon-delete fa fa-trash-o fa-lg'></i></div></div></form>");
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
