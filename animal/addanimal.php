<?php
$title = "Add Animal";
include ('includes/header.php');


//move them back to user home if they're not a staff member
if ($_SESSION['staff'] == 'false') {
	header( 'Location: userhome.php' );
}


if (isset($_POST['submitted'])){

	//get all the values and sanitise
	$errors = array();

	//name
	if (empty($_POST['name'])){
		$errors[] = "Name not entered";
	} else {
		$name = $db->quote($_POST['name']);
	}
	//date of birth
	if ($_POST['Month'] != "- Select Month -"){
		$month = $_POST['Month'];
	} else {
		$errors [] = "Please select a month";
	}

	if ($_POST['Day'] != "- Select Day -"){
		$day = $_POST['Day'];
	} else {
		$errors [] = "Please select a day";
	}

	if ($_POST['Year'] != "- Select Year -"){
		$year = $_POST['Year'];
	} else {
		$errors [] = "Please select a year";
	}

	//description
	if (empty($_POST['description'])){
		$errors[] = "Description not entered";
	} else {
		$description = $db->quote($_POST['description']);
	}

	//picture
	//code adapted from: http://www.w3schools.com/PHP/php_file_upload.asp

	if ($_FILES["file"]["error"] > 0)
	{
		$errors[] = "Error with file upload: " . $_FILES["file"]["error"] . "<br>";
		$filename = "default.jpg";
	}
	else
	{

			
		//set the filename
		$filename = $_FILES["file"]["name"];
			
		$allowedExts = array("gif", "jpeg", "jpg", "png");
			
		$type = $_FILES["file"]["type"];
		//get the extension at the end of the filename
		$temp = explode(".", $filename);
		$extension = end($temp);
			
		if ((($type == "image/gif")
				|| ($type == "image/jpeg")
				|| ($type == "image/jpg")
				|| ($type == "image/pjpeg")
				|| ($type == "image/x-png")
				|| ($type == "image/png"))
				&& ($_FILES["file"]["size"] < 2000000)
				&& in_array($extension, $allowedExts))
		{ //if the type is correct, the size is allowed

			if (file_exists("upload/" . $filename)) //if the file exists
			{
				//look for a new file name
				$foundvalid = FALSE;
				$count = 0;
				//while we've not found a valid name
				while ($foundvalid == FALSE){
					echo $foundvalid;
					//prepend the count to to the filename
					$filename = $count . $filename;
					echo $filename ;
					$count ++;
					//if the file still exists
					if (file_exists("upload/" . $filename) == FALSE) {
						$foundvalid = TRUE;
					}
				}
			}
			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename);
		} else {
			$errors[] = "File too big or wrong extension: File types accepted: gif, jpeg, jpg, and png.";
		}
	}


	if (sizeof($errors)==0){

		//check if the animal is added by a staff member for adoption

		if ($_SESSION['staff'] == 'true') {
			$available = 'true';
		} else {
			$available = 'false';
		}

		//add new animal to the database
		$q = "Insert into animal values (default, $name, '$year-$month-$day', $description, '$filename', $available)";
		//echo $q;
		$db->query($q);

		//get the ID of the animal
		$q2 = "select animalid from animal where name = $name and dob = '$year-$month-$day'";
		//echo $q2;
		$rows = $db->query($q2);

		foreach ($rows as $row) {
			$id = $row['animalid'];
			//assign the new owner
			$db->query("insert into owns values ('{$_SESSION['userid']}', '$id')");
		}

	} else {
		//print out the errors

		echo "<h1> Errors </h1> \n <ul>";
		foreach ($errors as $e) {
			echo "<li>" . $e  . "</li> \n";
		}
		echo "</ul>";
	}
}

?>

<div class="row">
	<div class="large-12 columns">
		<form action="addanimal.php" method="post" enctype="multipart/form-data">
			<h1>Animal Details</h1>
			<p>
				Name: <input type="text" name="name" size="15" maxlength="20" />
			</p>
			<p>Date of Birth:</p>
			<!-- this could have been done with date form element -->
			<div class = "row">
			<div class = "large-4 columns">
			<select name="Day">
				<!-- this could also be changed to be always valid with ajax -->
				<option>- Select Day -</option>
				<?php 
				for ($x = 1; $x <= 31; $x++){
				echo '<option value=' . $x . '>' . $x . '</option>';
			}
			?>
			</select>
			</div>
			<div class = "large-4 columns">
			<select name="Month">
				<option>- Select Month -</option>
				<?php 
				for ($x = 1; $x <= 12; $x++){
				echo '<option value=' . $x . '>' . $x . '</option>';
			}
			?>
			</select> </div>
			<div class = "large-4 columns">
			<select name="Year">
				<option>- Select Year -</option>
				<?php 
				for ($x = 1990; $x <= 2014; $x++){
				echo '<option value=' . $x . '>' . $x . '</option>';
			}
			?>
			</select>
			</div>
			</div>

			<p>Description</p>
			<textarea name="description" rows="3" cols="40"></textarea>

			<p>Image</p>
			<input type="file" name="file" id="file"><br>

			<p>
				<input type="submit" name="submit" value="Submit" />
			</p>
			<input type="hidden" name="submitted" value="TRUE" />
		</form>
	</div>
</div>



<?php include ('includes/footer.php'); ?>