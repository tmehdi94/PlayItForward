<?php include 'header.php';?>
<div class = "wrapmeup">
 	<div class = "bodyBlock">
		<h1>JOURNAL</h1>
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

			}catch(PDOException $ex)
			{
				$error_msg="Failed to run query: " . $ex->getMessage();
				echo json_encode(array("error"=>$error_msg, "success"=>0));
				die();
			
			}
		}
	?>
	<h3>You entry has been posted!</h3>
	<p><a href = "journal.php">Would you like to add another?</a></p>
</div>
	<?php include 'leftsidebar.php'; ?>
	<?php include 'rightsidebar.php'; ?>
</div>
<?php include 'footer.php'; ?>
