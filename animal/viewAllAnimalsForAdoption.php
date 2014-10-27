<?php
$title = "View All Animals for Adoption"; 
include('includes/header.php');

	if (isset($_POST['submitted'])){
		$_POST['submitted'] = false;	
		
		foreach($_POST['animal'] as $animaid) {
			//add an adoption request for this animal
			$query = "insert into adoptionrequest values (default, " . $_SESSION['userid'] . ", $animaid, null)";
			//set the animal to not being available anymore
			$query_to_update_animal = "update animal set animal.available = false where animalid = ". $animaid;
			
			try {
				//try and do the two queries
				$db->exec($query);
				$db->exec($query_to_update_animal);
				
			} catch (PDOException $ex) {
				echo "<p>Sorry, a database error occurred. Please try again.</p>";
				echo "<p>(Error details: " . $ex->getMessage() . ")";
			}
			
		}
		
	}
	

?>
<div class= "row">
		<div class="large-12 columns">
<h1>All Animals available for adoption</h1>
<p> Please click on a link for more information about an animal </p>

<form action="viewAllAnimalsForAdoption.php" method="post">
<table>
<tr>
<th>Animal Name</th> <?php if ($_SESSION['staff'] == 'false') { echo '<th>Request </th>'; } ?>
</tr>

<?php

	//query
	$q = "select * from animal where available = 1";
	
	try {
	//output
		$rows = $db->query($q);
		
		foreach($rows as $row){
			echo '<tr>';
			echo '<td><a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["name"] . "</a> </td>" ;
			
			//only show the ability to adopt an animal if the user is not a member of staff
			if ($_SESSION['staff'] == 'false') {
				echo '<td> <input type="checkbox" name="animal[]" value="' . $row['animalid'] . '"></td>';
			}
			echo '</tr>';
			
		}
	
	}  catch (PDOException $ex) {
		echo "<p>Sorry, a database error occurred. Please try again.</p>";
		echo "<p>(Error details: " . $ex->getMessage() . ")";
	}

?>
</table>

<?php
if ($_SESSION['staff'] == 'false') {
	//only show the submit buttons if not a member of staff.
	echo '<input type="submit" name="submit" value="Submit" />';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
}
?>
</form>
</div></div>
<?php include('includes/footer.php');?>