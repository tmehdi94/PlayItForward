<div id = "rightsidebar">
<?php if(isset($_SESSION["user"])) { ?>
	<img width=150 height=150 src = "users/
	<?php if (($_SESSION["user"]["avatar"]) == "default.jpg") { ?>
		default.jpg
	<?php } else { ?>
	<?php echo $_SESSION["user"]["username"]; ?>/<?php echo $_SESSION["user"]["avatar"]; } ?>"</img><br/>
	<p>Welcome <?php echo $_SESSION["user"]['username']; ?>!</p>
  <p>Level <?php echo get_current_level($_SESSION["user"]["id"], $db)['level']; ?>!</p>
<?php
	// calculate progress
	$w = 5;
	$level = get_user_level_info($_SESSION["user"]["id"], $db);
	$sum = $level['current1star'] + $level['current2star'] + $level['current3star'];
	if ($sum == 1) $w = 25;
	else if ($sum == 2) $w = 50;
	else if ($sum == 3) $w = 75;
	else if ($sum == 4) $w = 100;
  ?>
  <p>Missions status:</p>
  <div class="meter animate">
	<span style="width: <?php echo $w; ?>%"><span></span></span>
</div>
  <p><a id="personalgoals" class="rightsidebarlinks" href="#" onclick="return false;">View personal goals!</a></p>
  <div id="dialog" title="Personal Goals">
  <p>
  <ol>
  <?php
	// get goals
	$goals = get_goals($_SESSION["user"]["id"], $db);
	foreach ($goals as $id => $goal) {
		echo "<li>".$goal."</li>";
	}
	echo "<p>Have you put work towards your personal goals today?</p>";
  ?>
  </ol>
  </p>
  </div>
  <hr/>
  <p><a class = "rightsidebarlinks" href="#" onclick="toggle_visibility('suggestamission'); return false;">Suggest a mission!</a></p>
  <form style="display:none;" id ="suggestamission" action="" method="post">
  <input type='hidden' name='id' id='id' value='<?php echo $_SESSION["user"]["id"]; ?>'>
  <textarea name="suggest" id="suggest" rows="4" cols="15" placeholder="Enter some ideas for missions here"></textarea>
  <input id='suggestmission' name='submit' type='submit' value='Suggest Mission'>
  </form>
<?php } else { ?>
	Please log in or register to see what you can do with Confiden!
<?php } ?>
</div>
