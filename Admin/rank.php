<?php
	session_start();
	require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
    $p = new Permissons($_SESSION["rank"], $connection);
	if(isset($_POST['Rank_Name'])){
		 $p->hasPermisson("Rank_Edit");
	}else{
		$p->hasPermisson("Rank_Create");
	}
?>
<html>
	<head>
		<title>New rank</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css" rel="stylesheet">	
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
					<a class="navbar-brand">Homepage</a>				
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
					<h1>New rank</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="header" style="text-align:center">
							<a href="ranks.php" style="float:left"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
							<p><b>Create new rank</b></p>
							<a href="ranks.php" style="visibility:hidden; float:right"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
						</div>
						<div class="box-content">
							<form action="Actions/rank.php" onsubmit="moveValues()" method="POST">
								<p>Name</p>
								<?php
									$name = str_replace(" ", "_", $_POST['Rank_Name']);
									echo('<input name="Name" class="large-input" value="' . $_POST['Rank_Name'] . '">');
									echo("<input type='hidden' name='Id' value = " . $_POST[$name][1] . ">");
								?>
								<select id="myselect" class="selectpicker premissons" multiple name="Premissons[]" data-dropup-auto="false">
									<?php
										require_once("../includes/dbconnect.php");
										$sql = "Select Name, Provider, Inherited, Dissolves From Premissons";
										$results = $connection->query($sql);
										$Setpremissons = isset($_POST[$name][0]) ? explode(",", $_POST[$name][0]) : array();
										if($results->num_rows > 0){
											$value = 1;
                							while($row = $results->fetch_assoc()){
                								$class = "";
                								$attributes = "" ;
                								if($row['Inherited'] != NULL){
                									$class .= "indentedOptions ";
                									$attributes .= "data-role='" . $row['Inherited'] . "' ";
                								}
                								if($row['Dissolves'] == TRUE){
                									$class .= "dropdownOption";
                									$attributes .= "name='" . $row['Name']. "' ";
                								}
                								if(in_array($row['Name'], $Setpremissons)){
                									$attributes .= "selected";
                								}
                								echo("<option value='" . $value . "' class='" . $class . "' " . $attributes . '>' . $row['Name'] . '</option>');
                								$value += 1;
                							}
                						}
										// echo('<option value="1" class="dropdownOption" name="BB_Admin">BB_Admin</option>');
// 										echo('<option value="2" class="indentedOptions" data-role="BB_Admin">BeattCMS_User</option>');
									?>

								</select>
								<?php
									$value = isset($_POST[$name][0]) ? "Update rank" : "Create rank";
									echo("<input class='btn btn-primary' type='submit' value='{$value}' style='float:right;'>");
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			Array.prototype.diff = function(a) {
    			return this.filter(function(i) {return a.indexOf(i) < 0;});
			};
			$( document ).ready(function() {
				var i = setInterval(function (){

       				if ($('.bootstrap-select').length){
            			clearInterval(i);
            			$(".indentedOptions").click(function(event){
            				object = event.target;
							dataRole = object.getAttribute("data-role");
							parent = object.parentElement;
							while(dataRole === null){
								//In case click on text and not option
								dataRole = parent.getAttribute("data-role");
								parent = parent.parentElement;
							}
							i = 0;
							while(dataRole != "null"){
								upperOptions = document.getElementsByName(dataRole)
								if(upperOptions[0].getAttribute("aria-selected") == "true"){
									values = $("#myselect").val();
									index = values.indexOf(upperOptions[1].value);
									values.splice(index, 1);
									$("#myselect").selectpicker("val", values);
								}	
								dataRole = upperOptions[0].getAttribute("data-role");		
								i += 1;			
							}
						});
						$(".dropdownOption").click(function(event){
							object = event.target;
							name = object.getAttribute("name");
							parent = object.parentElement
							while(name === "null"){
								name = parent.getAttribute("name");
								parent = parent.parentElement
							}
							lowerOptions = Array.prototype.slice.call(document.querySelectorAll('option[data-role=' + name + ']'));
							values = [];
							for(var i = 0; i < lowerOptions.length; i++){
								name = lowerOptions[i].getAttribute("name")
								if(name != "null"){
									lowerOptions.push.apply(lowerOptions, Array.prototype.slice.call(document.querySelectorAll('option[data-role=' + name + ']')));
								}
								values.push(lowerOptions[i].getAttribute("value"))
							}
							currentValues = $("#myselect").val() || [];
							$("#myselect").selectpicker("val", currentValues.diff(values));
						});
						selected = $("[selected]");
						for(var e = 0; e < selected.length; e++){
							dataRole = selected[e].getAttribute("data-role");
							if(dataRole != null){
								above = $("a[name=" + dataRole + "]");
								openDropDown(above);
							}
						}
        			}
    			}, 100);
			});
			function getLower(name){
				items = []
				first = document.querySelectorAll('[data-role=' + name + ']');
			}
			function spliceFromArray(objects, values){
				for(var i = 0; i < objects.length; i++){
					index = values.indexOf(objects[i].value);
					if(index > -1){
						values.splice(index, 1)
					}
				}
			}
			function dropdownOptions(rotate){
				name = rotate.parentElement.parentElement.name;
				options =  Array.prototype.slice.call(document.querySelectorAll("a[data-role=" + name + "]"));
				if(rotate.id == "rotateBack"){
					//Close the dropdown menu
					rotate.id="rotateForward";
					display="none";
					for(var i = 0; i < options.length; i++){
						name = options[i].getAttribute("name")
						if(name != "null"){								
							options.push.apply(options, Array.prototype.slice.call(document.querySelectorAll('a[data-role=' + name + ']')));
							options[i].childNodes[0].childNodes[0].id = "rotateForward";
						}
						options[i].style="display:none";
					}
				}else{
					//Open the dropdown menu
					rotate.id = 'rotateBack';
					openDropDown(rotate.parentElement.parentElement);
				}
			}
			function moveValues(){
				selectOptions = $("#myselect").children()
				for(var i = 0; i < selectOptions.length; i++){
					selectOptions[i].value = selectOptions[i].innerHTML;
				}
			}
			function openDropDown(option){
				console.log("openDropDown");
				display="block";
				name = $(option).attr("name");
				options = Array.prototype.slice.call(document.querySelectorAll("a[data-role=" + name + "]"));
				console.log(options)
				for(var i = 0; i < options.length; i++){
					$(options[i]).parent().insertAfter(option.parentElement);
					options[i].style="display:" + display + "!important;";
					margin = 1;
					complete = false;
					var dataRole = name;
					while(complete == false){
						above = document.getElementsByName(dataRole);
						if(above[0].getAttribute("data-role") == "null"){
							complete = true;
						}else{
							dataRole = above[0].getAttribute("data-role");
							margin += 1;
						}
					}
					totalMargin = 20 * margin;
					if(options[i].getAttribute("class").includes("dropdownOption")){
						totalMargin = 8 * margin;
					}
					options[i].childNodes[0].style="margin-left:" + totalMargin + "px;";
				}
			}
		</script>
	</body>
</html>
