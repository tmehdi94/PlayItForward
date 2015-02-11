<?php include 'header.php'; ?>
<div class = "wrapmeup">
	<div class = "bodyBlock">
			<h1>MISSIONS</h1>
			
			<?php 
			
			//if (isset($message)) echo "<p style='color:blue;'>$message</p>";
			$missions = get_available_missions($_SESSION['user']['id'], $db);
			
			$output1star = "";
			$output2star = "";
			$output3star = "";
			// iterate through each mission and generate the appropriate HTML for it
			if ($missions == "No missions available!") {
				echo "<div title='Notification!' id='notification'>".$missions."</div>"; 
			}
			else {
				foreach ($missions as $key => $value) {
					$innerdiv = $value['id']."fb";
					$output = "";
					$output .= "<div id='$value[id]'>\n";
					$output .= "<h3 class='$value[title]'><a href='#' onclick=\"toggle_visibility('$innerdiv'); return false;\">$value[title]</a></h3>\n";
					$output .= "<div id='$innerdiv' style='display:none;'>\n";
					$output .= "<p class='{$value['id']}desc'>$value[desc]</p>\n";
					$output .= "<form method='post' action='' name='$value[id]' id='$value[id]'>\n";
					$output .= "<input type='hidden' name='id' id='id' value='$value[id]'>";
					$output .= "<textarea onkeyup='wordcount(this.value, $value[id]);' id='feedback' name='feedback' rows='4' cols='50' placeholder='How did it go? (at least 30 words)'></textarea>\n";
					$output .= "<br/><input id='submitmission' name='submit' type='submit' value='Submit Mission'>\n";
					$output .= "</form>\n<span class='wordcount'>Word Count:</span><input type='text' size='4' readonly id='{$value['id']}w_count'></div>\n</div>\n";		
					if ($value['star'] == 1) {
						$output1star .= "$output";
					}
					else if ($value['star'] == 2) {
						$output2star .= "$output";
					}
					else if ($value['star'] == 3) {
						$output3star .= "$output";
					}
					else { echo "Invalid mission!"; }
					//print_r($value);
				}
				if ($output1star != "") {
					echo "<p class='missionheading'>1 Star Missions</p>".$output1star."<br/>";
				}
				if ($output2star != "") {
					echo "<p class='missionheading'>2 Star Missions</p>".$output2star."<br/>";
				}
				if ($output3star != "") {
					echo "<p class='missionheading'>3 Star Missions</p>".$output3star."<br/>";
				}
			}
			?>
			
		<script>  
			
				function wordcount(count, id) {
					var cnt;
					var words = count.split(/\s/);
					cnt = words.length;
					
					var ele = document.getElementById(id+'w_count');
					ele.value = cnt;
				}
		</script>

	</div>
	<?php include 'leftsidebar.php'; ?>
	<?php include 'rightsidebar.php'; ?>
</div>
<?php include 'footer.php'; ?>
