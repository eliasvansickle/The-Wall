<?php 
	require ('connection.php');
	session_start(); 

	$query_message_data = "SELECT * FROM users JOIN messages ON users.id = messages.user_id ORDER BY messages.created_at DESC";
	$_SESSION['message_feed'] = fetch($query_message_data);

	$query_comment_data = "SELECT * FROM messages JOIN comments ON messages.id = comments.message_id JOIN users ON messages.user_id = users.id";
	$_SESSION['comment_feed'] = fetch($query_comment_data);

	// $query_comment_person = "SELECT * FROM comments JOIN messages ON comments.message_id = messages.id JOIN users ON messages.user_id = users.id";
	// $_SESSION['comment_person'] = fetch($query_comment_person);
?>
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
			<h2>Message Board</h2>
			<form action="process.php" method="post">
				<label>
					<textarea rows="5" cols="75" name="message" placeholder="Write your message here!"></textarea>
				</label>
				<label id="post_message">
					<input type="hidden" name="action" value="submit_message">
					<input type="submit" value="Post A Message">
				</label>
			</form>
		</div>
		<div id="feed">
			<?php
			if(isset($_SESSION['message_feed']) && !empty($_SESSION['message_feed'])) {
				foreach ($_SESSION['message_feed'] as $message) {
					echo "<div class='message_feed'><p>".$message['first_name']." ".$message['last_name']."- ".date('F jS Y', strtotime($message['created_at']))."</p><br>".$message['message']."</div>";			
			 ?>
			<div id='comment'>
				<?php if(isset($_SESSION['comment_feed']))
				{
					foreach ($_SESSION['comment_feed'] as $comment) {
						if($comment['message_id'] == $message['id']) {
						echo $comment['first_name']." ".$comment['last_name']."- ".date('F jS Y', strtotime($comment['created_at']))."<br><span class='comments'><p>".$comment['comment']. "</p></span><br>";
						}
					}
				} ?>
				<?php  
					echo "
					<form action='process.php' method='post'>
						<label>
							<textarea rows='1' cols='75' name='comment' placeholder='Write your comment here!'></textarea>
						</label>
						<label id='post_comment'>
							<input type='hidden' name='action' value='submit_comment'>
							<input type='hidden' name='message_id' value='".$message['id']."'>
							<input type='submit' value='Post A Comment'>
						</label>
					</form>";
					}
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>