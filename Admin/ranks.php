<?php
    session_start();
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    $p->hasPermisson(["Rank"]);
 ?>
<html>
	<head>
		<title>Ranks</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<link href="../css/custom.css?v=0.45" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js?v=0.1" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
    			tooltipRight(); 
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
				<?php
					$errors = array('denied' => 'Sorry that rank does not exist', 'refer' => 'Sorry that needs Admin authorization');
					$result = $errors[array_keys($_GET)[0]];
					echo("<a class='denied'>{$result}</a>");
				?>
				<div class="col-lg-12">
					<div class="box">
						<div class="header">
							<p><i class="fa fa-users" aria-hidden="true"></i> Ranks</p>
							<a href="rank.php">
								<button class="btn btn-default add">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</button>
							</a>
						</div>
						<div>
								<table style="width:100%;">
									<tr>
										<th>Name</th>
										<th>Premissons</th>
									</tr>
									<?php
										require_once("../includes/dbconnect.php");
										$sql = "Select id, Name, Premissons, Enabled FROM Ranks ORDER BY id";
										$results = $connection->query($sql);
										if($results->num_rows > 0){
											while($row = $results->fetch_assoc()){
												$attribute = $row['Enabled'] == TRUE ? '' : 'class="disabledOption"';
												echo("<tr {$attribute}><td>" . $row['Name'] . '</td><td>');
												$premissons = explode(",", $row['Premissons']);
												$stmt = $connection->prepare("Select Provider, Description From Premissons where Name = ?");
												foreach($premissons as $premisson){
													$stmt->bind_param("s", $premisson);
													$stmt->execute();
													$stmt->bind_result($provider, $description);
													$stmt->fetch();
													echo("<a data-toggle='tooltip' title='{$description}'>{$provider}_{$premisson}</a> ");
												}
												$stmt->close();
												echo("<form action='Actions/rank.php' method='POST' class='form-delete'>
                										<input type='hidden' name='Delete' value='{$row['id']}'>
                										<i class='icon-delete fa fa-trash-o form-submit'></i>
                									  </form>");
												echo("<a href='rank.php?id={$row['id']}'><button class='edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></a>");
												echo("</td></tr>");
											}
										}
									?>
								</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
