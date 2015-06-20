<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style_main.css">
	<title>Coding Dojo Wall</title>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>CodingDojo Wall</h1>
			<?php 
				echo "<span id='header_name'>Hi, {$_SESSION['first_name']}!</span>";
			 ?>
			 <form class="log_off" action="process.php" method="post">
			 	<label for="submit"></label>
		 		<input type="submit" value="Log Off">
		 		<input type="hidden" name="action" value="log_off">
		 	</form>
		</div>
		<div id="message">
			<h2>Post a message</h2>
			<form action="process.php" method="post">
				<label>
					<textarea rows="5" cols="75" name="message" placeholder="Write your message here!"></textarea>
				</label>
				<label id="post_message">
					<input type="submit" value="Post A Message">
				</label>
			</form>
		</div>
		<div id="feed"></div>
	</div>
</body>
</html>