<?php
if(isset($_SESSION["user"])) {
?>
<div id = "leftsidebar">
  <ul id = "navigationList">
    <li><a href = "index.php">HOME</a></li>
    <li><a href = "missions.php">MISSIONS</a></li>
    <li><a href = "journal.php">JOURNAL</a></li>
    <li><a href = "about.php">ABOUT</a></li>
    <li><a href = "resources.php">RESOURCES</a></li>
  </ul>
</div>
<?php } ?>