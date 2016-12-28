<?php
    session_start();
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
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
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
					<h1>Posts</h1>
				</div>
			</div>
            <div class="row">
                <div class="col-lg-12">
                    <?php
                		$sql = "SELECT * from Posts";
                		$results = $connection->query($sql);
                		if($results->num_rows > 0){
                			while($row = $results->fetch_assoc()){
                				date_default_timezone_set("Europe/Dublin"); 
                				$current = new DateTime(date('Y-m-d H:i:s'));
                				$posted = new DateTime($row['Posted']);
                				$interval = $posted->diff($current);
                				$timeSince = format_interval($interval);
                				echo('<div class="box"><form method="POST" action="post.php"><div class="post-content"><input type="hidden" name="id" value="' . $row['id'] . '"><h2>' . $row['title'] . '</h2><p>' . $row['content'] . '</p><p><i class="fa fa-clock-o"></i> ' . $timeSince . '</p></div>
                				<div class="action-container"><ul class="actions"><li class="action"><i class="fa fa-pencil" aria-hidden="true"></i><input
                				type="submit" name="submit" value="Edit"></li><li class="action"><i class="fa fa-trash-o" aria-hidden="true"></i>
                				<input type="submit" name="submit" value="Delete"></li></ul></div></form></div>');
                			}
                		}
                    ?>
                </div>
            </div>
		</div>
		</div>
	</body>
</html>
