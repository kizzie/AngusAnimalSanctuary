<?php
$title = "Process Adoption";  
include ('includes/header.php'); 

//bit of security, if they're not logged in as staff redirect to the user home page
if ($_SESSION['staff'] == 'false') {
	header( 'Location: userhome.php' );
}

//process the form if submitted.

if (isset($_POST['submitted'])){

		unset($_POST['submitted']);
		//get all the ID numbers for the animals where the adoption needs processing. 

		$q = "select * from adoptionrequest where approved is null";

	//try {
		$rows = $db->query($q);
		
		//print_r($_POST);
		//echo "d";
		foreach ($rows as $row){ //for each of the animals that needs approval
			
			$animalid = $row["animalid"]; //get the animal's ID
			$requestid = $row["adoptionid"];
	
			if (isset($_POST[$requestid])){ //if the ID is in the post data then the user did something to their approval status
				//echo "g";
				if ($_POST[$requestid] == "approve") {
				//	echo "h";
					//set the adoption process to approved
					$query_to_approve_adoption = "update adoptionrequest set adoptionrequest.approved = true where adoptionid = " . $row["adoptionid"];
					//echo $query_to_approve_adoption;
					$db->exec($query_to_approve_adoption);
					
					//change the owner of the animal
					//this is in the owns table. The original owner is the staff member, but since there is only ever one owner per animal we can 
					//just search for the animal id
					$query_to_change_owner = "UPDATE owns SET owns.userid = " . $row['userid'] . " where animalid = " . $row['animalid'];
					//echo $query_to_change_owner;
					$db->exec($query_to_change_owner);
						
				} else {
					//set the adoption process to deny
					$query_to_deny_adoption = "update adoptionrequest set adoptionrequest.approved = false where adoptionid = " . $row["adoptionid"];
					$db->exec($query_to_deny_adoption);
					
					//make the animal available for adoption again
					//find the animal in the animal table and set the available value to be true
					$query_to_update_animal = "update animal set animal.available = true where animalid = ". $row['animalid'];
					$db->exec($query_to_update_animal);
					
				}
			} // else do nothing. We don't change a thing
		}
		
// 	} catch (PDOException $ex) {
// 		echo "<p>Sorry, a database error occurred. Please try again.</p>";
// 		echo "<p>(Error details: " . $ex->getMessage() . ")";
// 	}

	

}

?>
<div class= "row">
		<div class="large-12 columns">
<h1>Animals waiting for adoption</h1>


<form action="processadoptions.php" method="post">

	<table>
		<tr>
			<td>Name</td>
			<td>Animal</td>
			<td>Approve</td>
			<td>Deny</td>
		</tr>

		<?php
		//for displaying the form
		$q = "select * from adoptionrequest where approved is null";
		
		try {
			$rows = $db->query($q);
		} catch (PDOException $ex) {
			echo "<p>Sorry, a database error occurred. Please try again.</p>";
			echo "<p>(Error details: " . $ex->getMessage() . ")";
		}

		//for every adoption request we add a row to the form
		foreach ($rows as $row) {
			echo '<tr>';
			//get the username for this id
			$usernamequery = "select * from user where userid = " . $row["userid"];
			$username = $db->query($usernamequery)->fetch(); //just get the first line as we know it will only match one

			//get the animal name for this id
			$animalnamequery = "select * from animal where animalid= " . $row["animalid"];
			$animalname = $db->query($animalnamequery)->fetch();

			//output the form line
			echo "<td>" . $username["username"] . "</td>
					<td>". $animalname["name"] . "</td>
					<td> <input type=\"radio\" name=\"" . $row["adoptionid"] . "\" value=\"approve\"> </td>
				<td> <input type=\"radio\" name=\"" . $row["adoptionid"] . "\" value=\"deny\"> </td>";
		}
		?>
	</table>

	<p>
		<input type="submit" name="submit" value="Submit" />
	</p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
</div></div>

<?php include ('includes/footer.php'); ?>