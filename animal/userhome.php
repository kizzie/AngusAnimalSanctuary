<?php
$title = "User Home";  
include ('includes/header.php'); ?>
<div class= "row">
		<div class="large-12 columns">
<h1>My Animals</h1>

<?php
	//get the animals out the database owned by this user
	$q = "select * from animal, owns where animal.animalid = owns.animalid and owns.userid = " . $_SESSION['userid'] ;
	
	$rows = $db->query($q);
	 
	foreach($rows as $row){
		echo '<li> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["name"] . "</a> </li>" ;
	} 
?>

<h1>Pending Adoptions</h1>

<?php
	$q = "select * from adoptionrequest, animal where userid = " . $_SESSION['userid'] . " and approved is null and adoptionrequest.animalid = animal.animalid";

	$rows = $db->query($q);
	
	foreach($rows as $row){
		echo '<li> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["name"] . "</a> </li>" ;
	}
	

?>
</div></div>


<?php  include ('includes/footer.php'); ?>