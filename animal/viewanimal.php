<?php


include ('includes/header.php');

$id = $db->quote($_GET["id"]); //sanitise, just in case someone has messed with the _GET variables


//Get who owns this animal 
$owns = $db->query("select * from owns where animalid = $id")->fetch();

//is the animal owned by a staff member?
$staffowned = $db->query("select staff from user, animal, owns where owns.userid = user.userid and animal.animalid = owns.animalid")->fetch();

//if they own the animal, or they are a staff member then continue
//if ($owns['userid'] == $_SESSION['userid'] || $_SESSION['staff'] == 'true' || $staffowned['staff'] == 1){
	
	//get the animal from the database
	$animal = $db->query("select * from animal where animalid = $id")->fetch();

	if (!empty($animal)){

		echo "<h1>" . $animal["name"] . "</h1> \n";
		echo "<h3>Date of Birth: " . $animal["dob"] . "</h3> \n";

		echo "<img src = \"upload/" . $animal["photo"] . "\" width = 200height = 200>\n";
		echo "<p>" . $animal["description"] . "</p>\n";
		echo "<p>";
		if ($animal["available"]) {
			echo "Currently ";
		} else {
			echo "Not ";
		}
		echo "available for adoption. </p>";

	} else { 
		//this should not happen except for staff members
		echo "<h1> Error, animal does not exist, are you messing with the GET variables? </h1>";
	}
//} else { //general error message
//	echo "<h1>Access Denied: You do not own this animal </h1>";
//}

include ('includes/footer.php');
?>


