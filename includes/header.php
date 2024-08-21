<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>User Registration</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>


	<?php if ($_SESSION['id']) { ?>
		<div class="brand clearfix">
			<a href="#" class="logo" style="font-size:16px;">Shreekar Hostel</a>
			<span class="menu-btn"><i class="fa fa-bars"></i></span>
			<ul class="ts-profile-nav">
				<li class="ts-account">
					<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
					<ul>
						<li><a href="my-profile.php">My Account</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>

	<?php
	} else { ?>
		<div class="brand clearfix">
			<a href="#" class="logo" style="font-size:16px;">Shreekar Hostel</a>
			<span class="menu-btn"><i class="fa fa-bars"></i></span>

		</div>
	<?php } ?>