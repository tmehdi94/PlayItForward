<?php include 'header.php';?>
	<?php

		if(!empty($_POST)){

			$error_msg="";

			if(empty($_POST['subject']))
			{
				$error_msg="Please include a subject line";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}

			if(empty($_POST['entry'])){
				$error_msg="Glad you're eager to post, but you forgot the entry!";
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			}

			$query = "
		            INSERT INTO journals (
		            	uid,
		            	author,
		            	date,
		                subject,
		                content
		            ) VALUES (
		            	:uid,
		            	:un,
		            	:date,
		                :subject,
		                :entry
	        	   )";
			
			$query_params = array(
				':uid'     => $_POST['id'],
				':un'      => $_POST['uname'],
				'date'     => date("Y/m/d"),
				':subject' => $_POST['subject'],
				':entry'   => $_POST['entry']
			);

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
				$notification = "Yay your entry has been recorded!!";
			}catch(PDOException $ex)
			{
				$error_msg="Failed to run query: " . $ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			
			}
		}
	?>
<div class = "wrapmeup">
         <div class = "bodyBlock">
		 	<?php 
			if ((isset($notification)) && ($notification != NULL) &&($notification != ""))
			echo "<div title='Notification!' id='notification'>".$notification."</div>"; ?>

                <h1>JOURNAL</h1>
                

                        <form action="" method="post" id="journal">
                                <input type='hidden' name='id' id='id' value='<?php echo $_SESSION["user"]["id"]; ?>'>
                                <input type='hidden' name='uname' id='uname' value='<?php echo $_SESSION["user"]["username"]; ?>'>
                                <span>Subject: <input type="text" name="subject" style="width:500px;"/></span><br>
                                <input type="hidden" name="entryid"/>
                                <textarea id="enid" name="entry" rows='10' cols='72'></textarea><br>
                                <input id="button_journal" type="submit" value="Post"/>
                        </form>
                        
      <!--Displays jounal entries-->
      <!--Old problem fixed, still trying to get the onclick display to work though-->
		    <h3>YOUR JOURNAL ARCHIVE</h3>
		    <div id = "journalarchive"><br/>
		      <?php  
		    	  	$prev =  get_journal_entries($_SESSION["user"]["id"], $db);
		    	  	$prevOut = "";
		
		    	  	// iterate through each mission and generate the appropriate HTML for it
					foreach ($prev as $key => $value) {
		
						$innerdiv = $value['id']."entry";
						$output = "";
						$output .= "<div id='$value[id]'>\n";
						$output .= "<h3 class='$value[subject]'><a href='#' onclick=\"toggle_visibility('$innerdiv'); return false;\">$value[subject]</a><span style = 'font-size:18px;'>: $value[date]</span></h3>";
						$output .= "<div id='$innerdiv' style='display:none;'>\n";
						$output .= "<p>$value[content]</p></div>\n</div>\n";
		
						$prevOut .= $output;
		
					}
		
				echo $prevOut;
		
		  	?>                        
		    </div>                    
                        
        </div>
        <?php include 'leftsidebar.php'; ?>
        <?php include 'rightsidebar.php'; ?>
</div>
<?php include 'footer.php'; ?>
