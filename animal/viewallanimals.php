<?php

$title = "View All Animals";
include('includes/header.php');
//move them back to user home if they're not a staff member
if ($_SESSION['staff'] == 'false') {
	header( 'Location: userhome.php' );
}


?>
<div class= "row">
		<div class="large-12 columns">
<h1>All the animals in the system</h1>

<table>
	<tr>
		<th>Animal Name</th>
		<th>Type</th>
		<th>Owner</th>
	</tr>

	<?php
	//fill up the rest of the table with stuff from the database

	$query = "select animal.animalid, name, username from animal, owns, user where animal.animalid = owns.animalid and user.userid = owns.userid";

	$rows = $db->query($query);

	foreach($rows as $row){
		echo "<tr>
			<td><a href = \"viewanimal.php?id=" . $row["animalid"] . "\">" . $row["name"]. "</a></td>
			<td>  </td>
			<td>" . $row["username"] .  "</td>
			</tr> \n";
	}
	?>
</table>
</div></div>
<?php
include('includes/footer.php');
?>