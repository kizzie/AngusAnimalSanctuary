<?php
$title = "logout"; 
include ('includes/header.php'); 

//destroy the session
	session_destroy();
//redirect to the login page
	header ('Location: index.php');
	
?>

<!-- unlikely to be run, but just in case -->
<h1> Logging out, if not redirected click <a href = "index.php">here </a></h1>

<?php include ('includes/footer.php'); 

?>