<?php
    session_start();
    require_once("../includes/permissons.php");
    require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    function format_interval(DateInterval $interval) {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        else if ($interval->m) { $result .= $interval->format("%m months "); }
        else if ($interval->d) { $result .= $interval->format("%d days "); }
        else if ($interval->h) { $result .= $interval->format("%h hours "); }
        else if ($interval->i) { $result .= $interval->format("%i minutes "); }
        else if ($interval->s) { $result .= $interval->format("%s seconds "); }
    
        return $result;
    }
 ?>
<html>
	<head>
		<title>Dashboard</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
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
					<h1>Pages</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header">
							<p>Pages</p>
							<a href="page.php"><button class="btn btn-default add"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></button></a>
						</div>
						<div>	
                			<?php
                				$sql = "Select id, Name, Publisher, Published From Pages";
                				$results = $connection->query($sql);
                				if($results->num_rows > 0){
                					while($row = $results->fetch_assoc()){
                						date_default_timezone_set("Europe/Dublin"); 
                						$current = new DateTime(date('Y-m-d H:i:s'));
                						$published = new DateTime($row['Published']);
                						$interval = $published->diff($current);
                						$timeSince = format_interval($interval);
                						echo("<form method='Post' action='page.php'><div onclick='javascript:this.parentNode.submit();' class='item'><div class='item-content'><input type='hidden' name='id' value='{$row['id']}'>
                						<h2>{$row['Name']}</h2><p><i class='fa fa-clock-o'></i> {$timeSince}</i></p><i class='icon-delete fa fa-trash-o fa-lg'></i></div></div>");
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
