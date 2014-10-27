<?php
$title = "Staff Home";  
include ('includes/header.php');


//bit of security, if they're not logged in as staff redirect to the user home page
if ($_SESSION['staff'] == 'false') {
	header( 'Location: userhome.php' );
}

?>
<div class= "row">
		<div class="large-12 columns">
<h1> Animals waiting for adoption </h1>

<?php
	$q = "select * from animal where available = 1";
	
	$rows = $db->query($q);
	
	echo '<ul>';
	
	foreach ($rows as $row) { 
		//add the animalID to view to the get parameters
		echo '<li> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["name"] . "</a> </li>" ;
	}
	
	echo '</ul>';
?>

<h1> Adoptions waiting for approval </h1>

<?php
	$q = "select * from adoptionrequest";
	
	$rows = $db->query($q);
	
	echo '<ul>';
	
	foreach ($rows as $row) { 
		//get the username for this id
		
		$usernamequery = "select * from user where userid = " . $row["userid"];
		$username = $db->query($usernamequery)->fetch(); //just get the first line as we know it will only match one
		
		//get the animal name for this id
		
		$animalnamequery = "select * from animal where animalid= " . $row["animalid"];
		$animalname = $db->query($animalnamequery)->fetch();
		
		echo '<li>' . $username["username"] . " : " . $animalname["name"];
	}
	
	echo '</ul>';
?>
</div></div>

<?php include ('includes/footer.php');