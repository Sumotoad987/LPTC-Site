<?php
	function newRel2Abs($rel, $abs){
		$down = substr_count($rel, '../');
		$rel = str_replace("../", "", $rel);
		$returnPath = "";
		for($i = 0; $i<$down; $i++){
			$abs = implode('/', explode('/', $abs, -1));
		}
		return($abs . '/' . $rel);
	}
	// $loc = newRel2Abs("../../includes/functions.php", dirname(__FILE__));
// 	require_once($loc);
	function includeSpecial($argument, $pages){
		$pageSelectLoc = newRel2Abs("../Elements/PageSelect.php", dirname(__FILE__));
		include($pageSelectLoc);
	}
	$working = getcwd();
	chdir(dirname(__FILE__));
	require_once("../../includes/functions.php");
	require_once("../../includes/dbconnect.php");
	$connection = db_connect();
	chdir($working);
	//Handles return info
	if(isset($_GET['premissonOptions'])){
		if($_POST['Id'] == ""){
			$sql = "SHOW TABLE STATUS Like 'Ranks'";
			$result=$connection->query($sql);
			$row = $result->fetch_assoc();
			$_POST['Id'] = $row['Auto_increment'];
		}
		$stmt = $connection->prepare("Insert Into Page_Edit (Pages, canSee, rankId) Values (?, ?, ?) ON DUPLICATE KEY UPDATE Pages=Values(Pages), canSee=Values(canSee), rankId=Values(rankId)");
		$canSee = $_POST['canSee'] == 1 ? 1 : 0;
		echo($connection->error);
		$stmt->bind_param("sii", implode($_POST['parent'], ","), $canSee, $_POST['Id']);
		$stmt->execute();
		$stmt->close();
	}
	if(isset($_GET['id'])){
		$stmt = $connection->prepare("Select Pages, canSee From Page_Edit WHERE rankId = ?");
		$stmt->bind_param("i", $_GET['id']);
		$stmt->execute();
		$stmt->bind_result($pages, $canSee);
		$stmt->fetch();
		$stmt->close();
	}
?>

<div class="row">
	<div class="col-md-6">
		<p><label for="editablePages">Pages they can edit</label></p>
		<div id="editablePages">
		<?php
			// $pageSelectLoc = newRel2Abs("../Elements/PageSelect.php", dirname(__FILE__));
// 			includeNoVars($pageSelectLoc);
			includeSpecial("multiple", $pages)
		?>
		</div>
	</div>
	<div class="col-md-6">
		<p><label for="canSee">Can see other pages: </label><input name="canSee" type="checkbox" value="1" <?php if(isset($canSee)){echo("checked");}?>/></p>
	</div>
	<script>
		$("#editablePages").click(function(event){
			event.stopPropagation()
			if($("#editablePages").children().hasClass("open")){
				$("#editablePages").children().removeClass("open")
			}else{
				$("#editablePages").children().addClass("open")
			}
		});
		$(document).ready(function(){
			$('.selectpicker').selectpicker();
			$('.inner').on('click', '.pickerPage', function (event) {
				selectedElement = $(event.target)
				console.log(selectedElement)
				selectedValue = selectedElement.attr("name")
				console.log(selectedValue)
				while(selectedValue == undefined){
					selectedElement = $(selectedElement).parent()
					console.log(selectedElement);
					selectedValue = selectedElement.attr("name")
				}
				console.log(selectedValue);
				currentValues = $("#pagePicker").val() || []; 
				//The element has just been cliked
				if(currentValues.indexOf(selectedValue) > -1){
					lowerOptions = Array.prototype.slice.call($('option[data-role=' + selectedValue + ']'));
					values = [];
					for(var i = 0; i < lowerOptions.length; i++){
						name = lowerOptions[i].getAttribute("name")
						if(name != "null"){
							lowerOptions.push.apply(lowerOptions, Array.prototype.slice.call($('option[data-role=' + name + ']')));
						}
						values.push($(lowerOptions[i]).attr("value"))
					}
					var union = [...new Set([...currentValues, ...values])];
					console.log(union)
					$("#pagePicker").selectpicker("val", union);
				}
			});
		});
	</script>
</div>