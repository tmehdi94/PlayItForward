function display_user_info(data)
{
	var user_info=data["current_user"];
	$("#user #info .error").empty();
	
	
	//user_info is for debugging purposes. It prints out all the available user data
//	if($("#user #account #user_info").size()>0)
//	{
//		//If #uesr_info exists, replace it with the latest data
//		$("#user #account #user_info").empty();
//		for(key in user_info)
//		{
//			$("#user #account ul").append("<li>"+key+": "+user_info[key]+"</li>");
//		}
//	}
//	else
//	{
//		$("#user #account").append("<ul id='user_info'></ul>");
//		for(key in user_info)
//		{
//			$("#user #account ul").append("<li>"+key+": "+user_info[key]+"</li>");
//		}
//	}
//	
	//Display user's current task
	var task="";
	if(user_info["currentTask"]!="")
	{
		task="<li>"+user_info["currentTask"]+"</li>";
	}
	//If the user has no onging mission, just print none
	else
	{
		task="None";
	}
//	$("#user #account #current_mission").html("<p>Your current mission: </p><ul>"+task+"</ul>");
	
	//Display user's completed tasks
//	var tasks="";
//	if(user_info["completedTasks"].length!=0)
//	{
//		for(var i=0; i!=user_info["completedTasks"].length; i++)
//		{
//			tasks+="<li>"+user_info["completedTasks"][i]["title"]+" ("+user_info["completedTasks"][i]["star"]+"-star)"+"</li>";
//		}
//	}
	//If the user has completed no missions, just print none
//	else
//	{
//		tasks="<li>None</li>";
//	}
//	$("#user #account #completed_missions").html(
//			"<p>You have completed:</p>"+
//			"<ul>"+
///			tasks+
//			"</ul>"
//	);
	
//	//Display user's email
//	$("#user #account #email").html(
//			"<p>email address: "+
//			user_info["email"]+
//			"</p>"
//	);
	
	//Display the personal goals
//	$("#user #account #personal_goal1").html("<p>Personal Goal 1: "+user_info["personalGoal1"]+"</p>");
//	$("#user #account #personal_goal2").html("<p>Personal Goal 2: "+user_info["personalGoal2"]+"</p>");
//	$("#user #account #personal_goal3").html("<p>Personal Goal 3: "+user_info["personalGoal3"]+"</p>");
	
	

	//Dipslay account setting
		
	
	$("#user #account #account_setting").html(
			"<div id='greeting'></div>"+
		    "<div id='avatar'></div>"+
			"<p><a href='#'>Change username</a></p>" +
	    	"<form method='post' action='accountsettings.php' id='change_username'>"+
	    	"  <label>New username: </label><input type='text' name='username' /><br />"+
	    	"<input type='submit' value='change' /><br />"+
	    	"</form>"+
			"<p><a href='#'>Change email address</a></p>"+
			"<form method='post' action='accountsettings.php' id='change_email'>"+
			  "<label>New email address: </label><input type='email' name='email' /><br />"+
			  "<input type='submit' value='change' /><br />"+
			"</form>"+
			"<p><a href='#'>Change password</a></p>"+
			"<form method='post' action='accountsettings.php' id='change_password'>"+
			  "<label>Old password: </label><input type='password' name='old_password' /><br />"+
			  "<label>New password: </label><input type='password' name='password' /><br />"+
			  "<label>Password again: </label><input type='password' name='password_again'/><br />"+
			  "<input type='submit' value='change' /><br />"+
			"</form>"+
			"<p><a href='#'>Change personal goals</a></p>"+
			"<form method='post' action='accountsettings.php' id='change_goals'>"+
			  "<label>Personal Goal 1: </label><input type='text' name='pg1' /><br />"+
			  "<label>Personal Goal 2: </label><input type='text' name='pg2' /><br />"+
			  "<label>Personal Goal 3: </label><input type='text' name='pg3' /><br />"+
			  "<input type='submit' value='change' /><br />"+
			"</form>"
	);
	$("#user #account #account_setting").hide();
	$("#user #account #account_setting_toggle").html(
			"<a href='#'>Show account setting</a>"
	);
	
	//A widget that allows the user to hide and expand the account setting section.
	$("#user #account #account_setting_toggle").unbind("click");
	$("#user #account #account_setting_toggle").click(function(){
		$("#user #account #account_setting").toggle(500, function(){
			if($("#user #account #account_setting").css("display")=="none")
			{
				$("#user #account #account_setting_toggle").html(
						"<a href='#'>Show account settings</a>"
				);
			}
			else
			{
				$("#user #account #account_setting_toggle").html(
						"<a href='#'>Hide account settings</a>"
				);
			}
		});
	});
	
	//Display the greeting
	$("#user #account #account_setting #greeting").html(
			"<p>Hello "+user_info["username"]+"! You are Level "+user_info["level"]+"</p>"
//			"<p>You progress towards the next level:"+user_info["progress"]+"</p>"+
//			"<meter value='"+user_info["progress"]/100+"'>"+user_info["progress"]+"</meter>"
	);
	
	// Display/Edit avatar
	if(user_info["avatar"]!="default.jpg")
	{
		//The <?php echo time() ?> prevents the image from being cached. So the latest image will always display
		//$("#user #account #avatar").html("<img src='users/"+user_info["username"]+"/avatar.jpg?<?php echo time(); ?>' height='75' width='75' alt='You don&apos;t have an avatar'></img>");
		
		// changed by Taha - this way it will reflect whatever is from the session, default set to default.jpg
		// image is broken because the path is wrong it should be users/username/(avatar.image or defautl.image)
		$("#user #account #account_setting #avatar").html("<img src='users/"+user_info["username"]+"/"+user_info["avatar"]+"' height='75' width='75'></img>");
		$("#user #account #account_setting #avatar").append(
			"<form enctype='multipart/form-data' action='uploadavatar.php' method='post'>" +
			  "<label>Choose a new profile picture</label><br />" +
			  "<input type='file' name='avatar' />" +
			  "<input type='submit' value='upload' />" +
			"</form>"
		);
	}
	else
	{
		$("#user #account #account_setting #avatar").html("<img src='users/default.jpg' height='75' width='75'></img>");
		$("#user #account #account_setting #avatar").html(
			"<form enctype='multipart/form-data' action='uploadavatar.php' method='post'>" +
			  "<label>Upload a profile picture</label><input type='file' name='avatar'/>" +
			  "<input type='submit' value='upload' />" +
			"</form>" 
		);
	}
	
	//bind event handler to the newly created change forms
	$("#user #change_username, #user #change_email, #user #change_password, #user #change_goals").on("submit", function(e){
		e.preventDefault();
		$.post("accountsettings.php", $(this).serialize(), function(data){
			if(data["success"]==1)
			{
				$("#user").hide(500);
				$("#user #login_container").hide(500);
				$("#user #register_container").hide(500);
				$("#user #logout_container").show(500);
				$("#user").show(500);
				
				display_user_info(data);
			}
			else if(data["success"]==0)
			{
				$("#user #info .error").html("<p>"+data["error"]+"</p>");
			}
			else
			{
				$("#user #info .error").html("<p>"+"We encountered an unknown error!"+"</p>");
			}
			
		}, "json").fail(function(jqXHR, textStatus, errorThrown){
			$("#user #info .error").html("<p>"+"Some serious error has occurred: "+textStatus + ", " + errorThrown+"</p>");
		});
	});
	
}

function destroy_user_info()
{
	$("#user #error").empty();
	$("#user #account").children().empty();
}
