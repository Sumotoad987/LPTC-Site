<?php
	session_start();
	require_once("../includes/permissons.php");
   	require_once("../includes/dbconnect.php");
   	require_once("../includes/functions.php");
    $p = new Permissons($_SESSION["rank"], $connection);
	if(isset($_GET['id'])){
		 $p->hasPermisson(["Rank_Edit"]);
		 $stmt = $connection->prepare("Select Name, Premissons From Ranks Where id = ?");
		 $stmt->bind_param("i", $_GET['id']);
		 $result = $stmt->execute();
		 $stmt->bind_result($name, $premissons);
		 $stmt->fetch();
		 if($name == ""){
		 	header('Location: ranks.php?denied');
		 }
		 $stmt->close();
	}else{
		$p->hasPermisson(["Rank_Create"]);
	}
?>
<html>
	<head>
		<title>New rank</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css?v=0.1" rel="stylesheet">	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js?v=0.22" type="text/javascript"></script>
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
							<a href="ranks.php" class="back"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>	
							<p><b>Create new rank</b></p>
						</div>
						<div class="box-content">
							<form action="Actions/rank.php" onsubmit="moveValues()" method="POST">
								<p>Name</p>
								<?php
									echo("<input name='Name' class='large-input' value='{$name}'>");
									echo("<input type='hidden' name='Id' id='rankId' value='{$_GET['id']}'>");
								?>
								<select id="myselect" class="selectpicker premissons" multiple name="Premissons[]" data-dropup-auto="false">
									<?php
										require_once("../includes/dbconnect.php");
										$sql = "Select id, Name, Provider, Inherited, Dissolves, Options From Premissons";
										$results = $connection->query($sql);
										$Setpremissons = isset($premissons) ? explode(",", $premissons) : array();
										if($results->num_rows > 0){
											$value = 1;
                							while($row = $results->fetch_assoc()){
                								$class = "";
                								$attributes = "" ;
                								$extraContent = "";
                								if($row['Inherited'] != NULL){
                									$class .= "indentedOptions ";
                									$attributes .= "data-role='" . $row['Inherited'] . "' ";
                								}
                								if($row['Dissolves'] == TRUE){
                									$class .= "dropdownOption ";
                									$attributes .= "name='" . $row['Name']. "' ";
                								}
                								if(in_array($row['Name'], $Setpremissons)){
                									$attributes .= "selected";
                								}
                								var_dump($row['Options']);
                								if($row['Options'] == TRUE){
            										var_dump($row['Name']);
                									$class .= "hasOptions";
                									ob_start();
													includeNoVars('Permissons/' . $row['Name'] . '.php');
													$file_content = ob_get_contents();
													ob_end_clean();
                									$includedOptions .= "<div id='{$row['Name']}' class='included-options'> {$file_content} </div>";
                								} 
                								echo("<option value='{$value}' class='{$class}' {$attributes} data-content='<span>{$row['Name']}</span>{$extraContent}'>{$row['Name']}</option>");
                								$value += 1;
                							}
                						}
									?>

								</select>
								<?php
									echo($includedOptions);
									$value = isset($_GET['id']) ? "Update rank" : "Create rank";
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
			var openedMenus = []
			$( document ).ready(function() {
				var i = setInterval(function (){

       				if ($('.bootstrap-select').length){
            			clearInterval(i);
            			//Settings system
            			$(".fa-cog").click(function(event){
            				event.stopPropagation()
            				//Sets up the the rankOptions and controls if it is hidden of not
            				if($(event.target).parent().siblings()[0] != undefined){
            					optionsDiv = $(event.target).parent().siblings()[0]
            					$(optionsDiv).toggle()
            				}else{
								optionsDiv = $("<div class='rank-options'></div>")
								container = $("<div></div>")
								siblings =  $(event.target).siblings()
								//Gets the span element(contains the permisson title), if the first sibling has "fa" it means it is the triangular pointer
								span = $(siblings[0]).hasClass("fa") ? siblings[1] : siblings[0]
								//
								container.css('margin-left', $(span).css('margin-left'))
								$('#' + span.innerHTML).css('display', 'block')
								container.append($('#' + span.innerHTML))
								optionsDiv.append(container)
								$(event.target).parent().parent().append(optionsDiv)
            				}
            			});
            			//Dropdown system
            			$(".indentedOptions").click(function(event){
            				//If click indented options makes parent not clicked
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
							console.log("Clicked");
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
						//Open the dropdown for all selected elements
						selected = $(".premissons [selected]");
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
				/* -----------------NOTICE------------------------:
						Two parents/childs if you use the normal text attribute
						rotate.parentElement.parentElement;
						options[i].childNodes[0].childNodes[0]
						
						
						One parent/child if you use data-content
						rotate.parentElement;
						options[i].childNodes[0]
						-----------------END--------------------------------	
					*/
				name = rotate.parentElement.name;
				options =  Array.prototype.slice.call(document.querySelectorAll("a[data-role=" + name + "]"));
				if(rotate.id == "rotateBack"){
					//Close the dropdown menu
					rotate.id="rotateForward";
					display="none";
					for(var i = 0; i < options.length; i++){
						name = options[i].getAttribute("name")
						if(name != "null"){								
							options.push.apply(options, Array.prototype.slice.call(document.querySelectorAll('a[data-role=' + name + ']')));
							options[i].childNodes[0].id = "rotateForward";
						}
						options[i].style="display:none";
					}
				}else{
					//Open the dropdown menu
					rotate.id = 'rotateBack';
					/* -----------------NOTICE------------------------:
						Two parents if you use the normal text attribute
						openDropDown(rotate.parentElement.parentElement);
						
						
						One parent if you use data-content
						openDropDown(rotate.parentElement);
						-----------------END--------------------------------	
					*/
					openDropDown(rotate.parentElement);
				}
			}
			//Moves the values before the form is submitted and submit the permisson options
			function moveValues(){
				selectOptions = $("#myselect").children()
				for(var i = 0; i < selectOptions.length; i++){
					selectOptions[i].value = selectOptions[i].innerHTML;
				}
				rankOptions = $(".included-options");
				rankOptions.each(function(){
					topLi = $(this).parent().parent().parent()
					if(topLi.children("a").attr("aria-selected") == 'true'){
						formData = $(this).find(":input").serialize()
						formData = formData + "&Id=" + $("#rankId").attr("value")
						$.post('Permissons/Page_Edit.php?premissonOptions', formData, function(result){
						})
					}
				});
			}
			function openDropDown(option){
				console.log("openDropDown");
				display="block";
				name = $(option).attr("name");
				options = Array.prototype.slice.call(document.querySelectorAll("a[data-role=" + name + "]"));
				$(option).children()[0].id = 'rotateBack'
				//Makes sure option has not been opened yet, if it already has and this code was to run it would change the order of the options
				if($(option).attr("beenopened") != "true"){
					console.log($(option).attr("beenopened"))
					//Move all its children underneath items
					$(options).each(function(){
						$(this).parent().insertAfter(option.parentElement);
					});
					$(option).attr("beenopened", true);
				}
				//Open all dropdowns above it
				dataRole = $(option).attr("data-role")
				while(dataRole != "null"){//Has parent
					parent = $("[name=" + dataRole + "]")
					rotate = $(parent).children()[0]
					if($(rotate).attr("id") == "rotate"){//It is not already opened
						//Change the rotate icon so it is pointing down
						$(rotate).attr('id', 'rotateBack')
						//Get the children of the parent(who are the siblings of the option we just had)
						siblings = Array.prototype.slice.call(document.querySelectorAll("a[data-role=" + dataRole + "]"))
						//Merges the two arrays
						options = siblings.concat(options)
					}
					dataRole = $(parent).attr("data-role")
					$(parent).attr("beenopened", true)
				}
				///
				for(var i = 0; i < options.length; i++){
					options[i].style="display:" + display + "!important;";
					if(openedMenus.indexOf(option) === -1){
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
						if($(options[i]).attr("class").includes("dropdownOption")){
							totalMargin = 8 * margin;
						}
						spanText = $(options[i]).children()[0];
						if($(spanText).hasClass("rank-options-cog")){
							spanText = $(options[i]).children()[1];
						}
						spanText.style="margin-left:" + totalMargin + "px;";
					}
				}
				if(openedMenus.indexOf(option) === -1){
					openedMenus.push(option)
				}
			}
		</script>

	</body>
</html>

<!---
	Documentation:
	The ticks on the bootstrap come from a styleing to do with <li>'s with the class="selected" attribute, because the permisson options
	are inside this they get the tick when the permisson itself is ticked. This was fixed by a change to the bootstrap-select css sheet
-->