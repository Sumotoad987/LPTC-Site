<?php
    session_start();
    require_once("../includes/permissons.php");
    require_once("../includes/dbconnect.php");
    require_once("../includes/functions.php");
    $p = new Permissons($_SESSION["rank"], $connection);
 ?>
<html>
	<head>
		<title>Pages</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js?v=0.1" type="text/javascript"></script>
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
						<div class="header">
							<p>Pages</p>
							<a href="page.php"><button class="btn btn-default add"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></button></a>
						</div>
						<div>	
                			<?php
                				$sql = "Select id, Name, Modified, Parent From Pages Order by PageOrder";
                				$results = $connection->query($sql);
                				if($results->num_rows > 0){
                					while($row = $results->fetch_assoc()){
                						$published = new DateTime($row['Modified']);
                						$timeSince = timeSince($published);
                						if($timeSince == ""){
                							$timeSince = "Now";
                						}	
                						
                						
                						echo("<a class='plain item-anchor' name='{$row['id']}' data-role='{$row['Parent']}' href='page.php?id={$row['id']}'>
                								<div class='item'>
                									<div class='item-content'>
                										<h2>{$row['Name']}</h2>
                										<p><i class='fa fa-clock-o'></i> {$timeSince}</p>
                										<form action='Actions/publish.php' method='POST'>
                											<input type='hidden' name='Delete' value='{$row['id']}'>
                											<i class='icon-delete in-a-submit fa fa-trash-o fa-lg'></i>
                										</form>
                								 	</div>
                								 </div>
                							   </a>");
                					}
                				}
                			?>
                		</div>	
                		<script>
                			$(document).ready(function(){
                				pages = $('a[data-role]');
								//Move them under
								for(i = 0; i < pages.length; i++){
									dataRole = $(pages[i]).attr('data-role');
									if(dataRole != ""){
										//Is a child
										parent = $('a[name=' + dataRole + ']')
										if(parent.parent().attr('type') != "temporary"){
											parent.wrap("<div type='temporary'></div>");
										}
										temporaryDiv = parent.parent()
										//Check to see if the child has children
										if($(pages[i]).parent().attr("type") == "temporary"){
											//Has children we should move temporary div surrounding it
											pageItem = $(pages[i]).parent()
										}else{
											//Doesn't have children
											pageItem = $(pages[i])
										}
										temporaryDiv.append(pageItem)
										parents = "-"
										parentsDataRole = parent.attr('data-role')
										while(parentsDataRole != ""){
											parents += '-'
											parentsDataRole = $('a[name=' + parentsDataRole + ']').attr('data-role')
										}
										h2 = $(pages[i]).children().children().children()[0]
										h2.innerHTML = parents + h2.innerHTML
									}
								}	
								temporaryDivs = $("[type='temporary']")
								temporaryDivs.each(function(i, div){
									$(div.children[0]).unwrap()
								})	
                			});
                		</script>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
