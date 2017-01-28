<?php
    session_start();
    require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
   	require_once("../includes/functions.php");
    $p = new Permissons($_SESSION["rank"], $connection);
	$stmt = $connection->prepare('Select Username, Email, Created, Description From Users Where id = ?');
	$stmt->bind_param("i", $_GET['id']);
	$stmt->execute();
	$stmt->bind_result($username, $email, $created, $description);
	$stmt->fetch();
	$stmt->close();
 ?>
<html>
	<head>
		<title>Me</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js?v=0.11" type="text/javascript"></script>
		<script>
			$.fn.bindFirst = function(name, fn) {
			  var elem, handlers, i, _len;
			  this.bind(name, fn);
			  for (i = 0, _len = this.length; i < _len; i++) {
				elem = this[i];
				handlers = jQuery._data(elem).events[name.split('.')[0]];
				handlers.unshift(handlers.pop());
			  }
			};
			$(document).ready(function(){
				$(".toolbar-item").bindFirst('click', function(e){
					if($(e.target).hasClass("selected") == false){
						$(".user-info").toggle();
						$(".user-settings").toggle();
					}
				});
				$(".user-settings-websites-button").click(function(e){
					$(".user-settings-websites-add-new").toggle();
				});
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
				<div class="col-lg-12">
					<div class="box">
						<div class="header" style="text-align:center">
							<p><b><?php echo($username); ?></b></p>
							<div class="toolbar profile-toolbar">
								<div class="toolbar-item" id='settings'>
									<a>Settings</a>
								</div>
								<div class="toolbar-item selected" id='me'>
									<a>Me</a>
								</div>
							</div>
							<script>
								prepareToolbar();
							</script>
						</div>
						<div class="box-content">
							<div class="row user-info">
								<div class="col-lg-5">
									<div class="box user-box">
										<div class="header" style="text-align:center">
											<p><b>Info</b></p>
										</div>
										<div class="box-content">
											<p class="info"><b>Username:</b> <?php echo($username); ?></p>
											<p class="info"><b>Email:</b> <?php echo($email); ?></p>
											<p class="about"><b>About me:</b><br> <?php echo(htmlspecialchars($description)); ?></p>
											<p class="info"><b>Joined:</b> <?php echo(date("j/n/y", strtotime($created))) ?></p>
											<p class="info"><b>Websites:</b></p>
											<div class="websites">
												<?php
													$stmt = $connection->prepare("Select URL From Websites where UserId = ?");
													$stmt->bind_param("i", $_GET['id']);
													$stmt->execute();
													$stmt->bind_result($URL);
													while($stmt->fetch()){
														$host = parse_url($URL);  
														$host = $host['host'];
														echo("<a href='{$URL}'>{$host}</a><br>");
													}
												?>										
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-7">
									<div class="box user-box">
										<div class="header" style="text-align:center">
											<p><b>Posts</b></p>
										</div>
										<div class="box-content">
											<?php
												date_default_timezone_set("Europe/Dublin"); 
												$stmt = $connection->prepare("Select Name, Modified, Id From Posts Where UserId = ?");
												$stmt->bind_param("i", $_GET['id']);
												$stmt->execute();
												$stmt->bind_result($Name, $Modified, $id);
												while($stmt->fetch()){
													$Modified = new DateTime($Modified);
													$timeSince = timeSince($Modified);
													echo("<a class='plain' href='post.php?id={$id}'
															<div class='item'>
																<div class='item-content'>
																	<p>{$Name}</p>
																	<p><i class='fa fa-clock-o'></i> {$timeSince}</p>
																</div>
															</div>
														</a>");
												}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="row user-settings">
								<div class="user-setting-details">
									<form action="Actions/profile.php" method="POST">
										<input class="large-input" type="hidden" name="id" value="<?php echo($_SESSION['id']); ?>">
										<div class="user-settings-info">
											<p class="input-label">Username:</p>
											<input class="large-input" name="username" value="<?php echo($_SESSION['username']); ?>">
											<p class="input-label">Email:</p>
											<input class="large-input" name="email" value="<?php echo($_SESSION['email']); ?>">
											<p class="input-label">About you:</p>
											<div class="box user-box">
												<textarea name="description" rows='5' class="about-you"><?php echo($description); ?></textarea>
											</div>
											<button type="submit" class="btn btn-primary pull-right">Update</button> 
										</div>
										<p class="input-label inline">Websites:</p>
										<button type="button" class="pull-right user-settings-websites-button"><i class="fa fa-plus" aria-hidden='true'></i></button>
										<div class="user-settings-websites-add-new">
											<input class="large-input" placeholder="URL" name="URL">
											<input class="large-input" placeholder="Description" name="Description">
											<button type="submit" name="addWebsite" class="btn btn-primary pull-right user-settings-websites-add-button">Add website</button>
										</div>
										<div class="user-settings-websites box user-box">
											<?php
												$stmt = $connection->prepare("Select id, URL, Description From Websites Where UserId = ?");												
												$stmt->bind_param("i", $_SESSION['id']);
												$stmt->execute();
												$stmt->bind_result($websiteId, $url, $description);
												while($stmt->fetch()){
													echo("<div class='user-settings-websites-website'>
															<a href='$url'>
																<img class='user-settings-websites-website-snapshot' src='https://api.thumbalizr.com/?url=$url&width=100'>
																<div class='user-settings-websites-website-details'>
																	<span class='user-settings-websites-website-description'>$description</span>
																	<br>
																	<span class='user-settings-websites-website-url'>$url</span>
																</div>
															</a>
															<button class='pull-right icon-holder' type='submit' name='deleteWebsite' value='{$websiteId}'><i class='icon-submit fa fa-times' aria-hidden='true'></i></button>
														</div>");
												}
											?>
										</div>
									</form>
								</div>
								<div class="user-settings-security">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
