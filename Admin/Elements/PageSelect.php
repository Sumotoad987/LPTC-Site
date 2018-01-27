<?php
	$working = getcwd();
	chdir(dirname(__FILE__));
	require_once("../../includes/functions.php");
	require_once("../../includes/dbconnect.php");
	$connection = db_connect();
	chdir($working);
	$name = "parent";
	if(isset($argument)){
		$name .= '[]';
	}
?>
<select class="selectpicker" <?php echo($argument); echo(" name=" . $name);?> id="pagePicker">
	<?php
		// $dbconnectLoc = newRel2Abs("../../includes/dbconnect.php", dirname(__FILE__));
// 		echo("Hello");
// 		require_once($dbconnectLoc);
		if(!isset($argument)){
			echo("<option value=''>None</option>");
		}
		$sql = "Select Name, id, Parent From Pages Order by PageOrder";
		$results = $connection->query($sql);
		$children = array();
		$selectedPages = explode(",", $pages);
		while($row = $results->fetch_assoc()){
			$attribute = "";
			if($row['id'] != $_GET['id'] && intval($row['Parent']) != intval($_GET['id']) && in_array($row['Parent'], $children) == FALSE){
				//Dont display page if it is this page, it is a child of this page if has a ancestor which is a child of this page
				$attribute = $row['id'] == $parent ? "selected" : "";
				$attribute .= $row['Parent'] != NULL ? "data-role='{$row['Parent']}'" : '';
				$attribute .= in_array($row['id'], $selectedPages) ? 'selected' : '';
				echo("<option name='{$row['id']}' value='{$row['id']}' class='pickerPage' {$attribute}>{$row['Name']}</option>");
			}elseif(isset($_GET['id']) == false){
				//Display all pages
				echo("<option name='{$row['id']}' value='{$row['id']}' class='pickerPage' {$attribute}>{$row['Name']}</option>");
			}else{
				echo($row['id']);
				$children[] = $row['id'];
			}
		}
		var_dump($children);
	?>
</select>
	<script>
		$(document).ready(function(){
			//Delete pages that don't have their parent
			$("option[data-role]").each(function(i, option){
				parent = $("option[name=" + $(option).attr('data-role') + "]")
				if(parent.length == 0){
					option.remove()
				}
			});
			//Move pages into correct positons
			$('.selectpicker').selectpicker();
			pages = $('a[data-role]');
			//Move them under
			for(i = 0; i < pages.length; i++){
				dataRole = $(pages[i]).attr('data-role');
				if(dataRole != 'null'){
					//Is a child
					parent = $('a[name=' + dataRole + ']')
					if(parent.parent().parent().prop("tagName") != "DIV"){
						parent.parent().wrap("<div type='temporary'></div>");
					}
					temporaryDiv = parent.parent().parent()
					//Check to see if the child has children
					if($(pages[i]).parent().parent().prop("tagName") == "DIV"){
						//Has children we should move temporary div surrounding it
						pageItem = $(pages[i]).parent().parent()
					}else{
						//Doesn't have children
						pageItem = $(pages[i]).parent()
					}
					temporaryDiv.append(pageItem)
					margin = parseInt($(parent).css('margin-left'), 10) + 10; 
					parentsDataRole = parent.attr('data-role')
					marginMultiplier = 1
					while(parentsDataRole != "null"){
						marginMultiplier += 1
						parentsDataRole = $('a[name=' + parentsDataRole + ']').attr('data-role')
					}
					$(pages[i]).css('margin-left', 10 * marginMultiplier + "px");
				}
			}	
			temporaryDivs = $("[type='temporary']")
			temporaryDivs.each(function(i, div){
				$(div.children[0]).unwrap()
			})									
		});
	</script>