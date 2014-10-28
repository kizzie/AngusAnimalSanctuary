<?php 
	if (!ISSET($title)){
		$title = "Default";
	}
?>

<html>
<head>
<title> <?php echo $title . ' | ' . "Angus' Animal Sanctuary"; ?> </title>

<link rel="stylesheet" href="includes/css/foundation.css" />
</head>

<body>


	<?php
	session_start();

	if (isset($_SESSION['username'])){
		echo "<h1>Logged in as " . htmlspecialchars($_SESSION['username']) . ": </h1>";
	} else {
		header( 'Location: index.php' );
	}


	//setup the database connection
	include('database.php');


	?>

	
		<div class="large-12 columns">
      	<ul class="button-group left">

				<?php
				//staff specific links
				if ($_SESSION['staff'] == 'true') {
					echo "<li><a href = \"staffhome.php\" class = \"button\">Home </a> </li>";
					echo "<li><a href = \"viewAllAnimalsForAdoption.php\" class = \"button\">View all animals available for adoption</a> </li>";
					echo "<li><a href = \"addanimal.php\" class = \"button\">Add Animal </a> </li>";
					echo "<li><a href = \"processadoptions.php\" class = \"button\">Process Adoptions </a> </li>";
					echo "<li><a href = \"viewalladoptions.php\" class = \"button\">View All Adoptions </a> </li>";
					echo "<li><a href = \"viewallanimals.php\" class = \"button\">View all animals </a> </li>";
				} else {
					//give the user menu
					echo "<li><a href = \"userhome.php\" class = \"button\">Home </a> </li>";
					echo "<li><a href = \"viewAllAnimalsForAdoption.php\" class = \"button\">View all animals available for adoption</a> </li>";
					echo "<li><a href = \"viewadoptionrequests.php\" class = \"button\">View my adoption requests</a> </li>";
				}
				?>
				<li><a href="logout.php" class = "button">Logout </a>
				</li>
			</ul>
		</div>
	