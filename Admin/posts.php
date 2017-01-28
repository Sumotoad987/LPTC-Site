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
						echo("<p class='denied'>Sorry that post does not exist</p>");
					}
				?>
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
                			$sql = "SELECT id, Name, Modified from Posts";
                			$results = $connection->query($sql);
                			if($results->num_rows > 0){
                				while($row = $results->fetch_assoc()){
                					date_default_timezone_set("Europe/Dublin"); 
                					$posted = new DateTime($row['Modified']);
                					$timeSince = timeSince($posted);
                					if($timeSince == ""){
                						$timeSince = "Now";
                					}
                					echo("<a class='item-anchor plain' href='post.php?id={$row['id']}'>
                							<div class='item'><div class='item-content'>
                								<h2>{$row['Name']}</h2>
                								<p><i class='fa fa-clock-o'></i> {$timeSince}</p>
                								<form action='Actions/post.php' method='POST'>
                									<input type='hidden' name='Delete' value='{$row['id']}'>
                									<i class='icon-delete in-a-submit fa fa-trash-o fa-lg'></i>
                								</form>
                							</div>
                						</a>");
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
