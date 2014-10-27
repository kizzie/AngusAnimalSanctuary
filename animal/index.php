<?php

	session_start();
	
	include('includes/database.php');
	
	

	if (isset($_POST['submitted'])){
		unset($_POST['submitted']);
		//sanitise those inputs.
		$username = $db->quote( $_POST['username']);
		
		//select the user with the correct name
		$q = "select * from user where username = $username";
		
		$rows = $db->query($q);
		
		//if the password matches then redirect
		foreach ($rows as $row) { 
			if ($row["password"] == $_POST['pass1']) { //password matches
				
				//set some session variables for using later
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['userid'] = $row['userid'];
				
				//redirect to either the staff or user home page based on the login
				if ($row["staff"] == "1"){
						$_SESSION['staff'] = 'true';
						header( 'Location: staffhome.php' );
					} else {
						$_SESSION['staff'] = 'false';
						header( 'Location: userhome.php' );
					}
			} 
		}
		//if the redirect doesn't happen then there was an error with the password, so display this and the form
		echo '<h1> There was a problem with your user name or password </h1>';
		
	} else if (isset($_POST['submittedRegister'])){
		
		unset($_POST['submittedRegister']); //in case they need to submit the form again, it won't get confused
		
		//sanitise those inputs
		if (isset($_POST["newusername"]) && isset($_POST["newpass"]) && isset($_POST["newemail"])){
			
			$new_user_name = $db->quote($_POST["newusername"]);
			$new_pass = $db->quote($_POST["newpass"]);
			$new_email = $db->quote($_POST["newemail"]);
			
			$q = "insert into user values (default, $new_user_name, $new_pass, $new_email, 0)";
			echo $q;
			
			try {
				$db->exec($q);
				
				//set session variables
				$_SESSION['username'] = $new_user_name;
				
				//get the ID for the user we just entered to include in the session
				$q2 = "select * from user where username = $new_user_name";
				$row = $db->query($q2)->fetch();
				
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['staff'] = 'false';
				
				//redirect to the logged in page
				header( 'Location: userhome.php' );
				
			} catch (PDOException $ex) {
				echo "<p>Sorry, a database error occurred. Please try again.</p>";
				echo "<p>(Error details: " . $ex->getMessage() . ")";
			}	
		}
		
		echo '<h1> There was a problem with your registration please try again</h1>';
	
	}
	
	
	
?>

<html>

<head>
<title> Login | Angus' Animal Sanctuary</title>
<link rel="stylesheet" href="includes/css/foundation.css" />
</head>

<body>
<div class= "row">
		<div class="large-12 columns">
<h1>Login</h1>
<form action="index.php" method="post">
	
	<p>User Name: <input type="text" name="username" size="15" maxlength="20" /></p>
    <p>Password: <input type="password" name="pass1" size="15" maxlength="20" /></p>
    <p><input type="submit" name="submit" value="Submit" /></p>
    <input type="hidden" name="submitted" value="TRUE" />
  </form>
  
 <h1>Register</h1>
 <form action="index.php" method="post">
	<p>User Name: <input type="text" name="newusername" size="15" maxlength="20" /></p>
    <p>Password: <input type="password" name="newpass" size="15" maxlength="20" /></p>
    <p>Email: <input type="email" name="newemail" size="15" maxlength="50" /></p>
    <p><input type="submit" name="submit" value="Submit" /></p>
    <input type="hidden" name="submittedRegister" value="TRUE" />
  </form>
  </div>
  </div>
</body>

</html>