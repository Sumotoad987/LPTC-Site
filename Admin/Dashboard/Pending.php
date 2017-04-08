<div class="col-lg-4">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Pending actions</h3>
		</div>
		<div class="panel-body">
			<?php
			$query = "Select Name, UserId, id, Modified, Created, 'rank' as Content, 'NULL' as Details From Ranks Where Enabled = 0 UNION Select 
				IFNULL(Username, Email) as Username, 
				UserId, id, Modified, Created, 'user' as Content, RequestedRank as Details From Users Where RequestedRank IS NOT NULL";
			$results = $connection->query($query);
			echo($connection->error);
			$resultsArray = $results->fetch_all(MYSQLI_ASSOC);
			if(count($resultsArray) > 0){
				for($i = 0; $i < count($resultsArray); $i++){
					$row = $resultsArray[$i];
					if($row['Modified'] == $row['Created']){
						$action = 'create';
					}else{
						$action = 'modified';
					}
					date_default_timezone_set("Europe/Dublin"); 
					$posted = new DateTime($row['Modified']);
					$timeSince = timeSince($posted);
					$usernameQuery->bind_param("i", $row['UserId']);
					$usernameQuery->execute();
					$usernameQuery->bind_result($username);
					$usernameQuery->store_result();
					$usernameQuery->fetch();
					$details = "";
					if($row['Content'] == 'user'){
						$page = 'edit-user';
						$rankName = rankName($row['Details'], $connection);
						$details = ", giving them the rank <a href='rank.php?id=${row['Details']}'>" . $rankName . '</a>';  
					}else{
						$page = $row['Content'];
					}
					echo("
						<section class='item panel-item'>
							<div class='icon'>
								<i class='fa fa-key pull-left' aria-hidden='true'></i>
							</div>
							<div class='item-body'>
								<p>{$username} is requesting to {$action} the {$row['Content']} <a href='{$row['Content']}.php?id={$row['id']}'>{$row['Name']}</a>$details</p>
								<div class='time'>
									<p style='display:inline'>{$timeSince}</p>
									<a class='pull-right' href='Actions/{$page}.php?confirm={$row['id']}'>Confirm</a>
								</div>
							</div>
						</section>
					");
				}
			}else{
				print("<p class='noActivity'>Nothing to see here</p>");
			}
		?>
		</div>
	</div>
</div>