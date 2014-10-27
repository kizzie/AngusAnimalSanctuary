<?php
$title = "View Adoption Requests";
include('includes/header.php');

?>

<div class="row">
	<div class="large-12 columns">
		<h1>View all adoptions</h1>

		<p>
			Adoptions can either be <i>approved, declined</i> or <i>not yet
				processed</i>. Entries that have null stored in the approved field
			of the database show up as not yet approved.
		</p>

		<table>
			<tr>
				<th>Adoption ID</th>
				<th>Animal ID</th>
				<th>Animal Name</th>
				<th>UserID</th>
				<th>Username</th>
				<th>Approved</th>
			</tr>

			<?php
			//get the details from the database and display them

			try {

				$query = "select adoptionid, adoptionrequest.animalid, animal.name, adoptionrequest.userid, user.username, approved from adoptionrequest, user, animal where adoptionrequest.animalid = animal.animalid and adoptionrequest.userid = user.userid and user.userid = " . $_SESSION['userid'];

				$rows = $db->query($query);

				foreach ($rows as $row) {
					echo "<tr>
						<td>" . $row["adoptionid"] . "</td>
						<td>" . $row["animalid"] . "</td>
						<td>" . $row["name"] . "</td>
					<td>" . $row["userid"] . "</td>
					<td>" . $row["username"] . "</td>
						<td>";

					if ($row["approved"] === "0") {
					echo "Not Approved";
				} else if ($row["approved"] === "1") {
					echo "Approved";
				} else {
					echo "Not processed";
				}
				echo "</td></tr>";
					
				}

			} catch (PDOException $ex) {
		echo "<p>Sorry, a database error occurred. Please try again.</p>";
		echo "<p>(Error details: " . $ex->getMessage() . ")";
	}


	?>
		</table>

	</div>
</div>


<?php include ('includes/footer.php'); ?>