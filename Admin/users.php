<?php
    session_start();
    require_once("../includes/permissons.php");
    require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    $p->hasPermisson("User_View");
    
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
								$results = $connection->query("Select Email, Username, Rank, id FROM Users");
								if($results->num_rows > 0){
                					while($row = $results->fetch_assoc()){
                						$hashed = md5($row['Email']);
                						echo('<form method="POST" style="margin-bottom:0" action="user.php"><div class="user" onclick="javascript:this.parentNode.submit();"><div class="user-img"><img src="https://www.gravatar.com/avatar/' . $hashed . '?d=mm"></div>
                						<div class="user-details"><input name="id" type="hidden" value="' . $row['id'] . '"><h3>' . $row['Username'] . '</h3><p>' . $row['Email'] . '</p><p class="rank">' . $row['Rank'] . '</p></div></div></form>');
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
