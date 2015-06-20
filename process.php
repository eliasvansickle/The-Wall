<?php
session_start();
require('connection.php');


if(isset($_POST['action']) && $_POST['action'] == 'register') 
{
	//call to function
	register_user($_POST); //uses actual $_POST
}
if(isset($_POST['action']) && $_POST['action'] == 'login') 
{
	//call to function
	login_user($_POST);
}
if(isset($_POST['action']) && $_POST['action'] == 'log_off') 
{
	session_destroy();
	session_start();
	$_SESSION['log_off'] = "You have been logged off";
	header('location:index.php');
	die();
}
if(isset($_POST['action']) && $_POST['action'] == 'submit_message') 
{
	//call to function
	message($_POST); //uses actual $_POST
}
function register_user($post) // just a parameter called post 
{
	////////START OF VALIDATION CHECKS////////
	$errors = array();
	if(empty($_POST['first_name']) || !ctype_alpha(str_replace(' ', '', $_POST['first_name']))) 
	{
		$errors['first_name'] = "Please enter your first name.";
	}
	if(empty($_POST['last_name']) || !ctype_alpha(str_replace(' ', '', $_POST['last_name']))) 
	{
		$errors['last_name'] = "Please enter your last name";
	}
	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$errors['email'] = "Please submit a valid email";
		}
	if((strlen($_POST['password']) < 6))
	{
		$errors['password'] = "Password must be longer than 6 characters";
	}
	if($_POST['passconf'] != $_POST['password']) 
	{
		$errors['passconf'] = "Passwords must match";
	}
	$_SESSION['errors'] = $errors;
	// die();
	////////END OF VALIDATION CHECKS////////

	if(!empty($_SESSION['errors']))
	{
		header('location: index.php');
	}
	else // Insert validated user registration information into the database
	{
		$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
				  VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['email']}', '{$post['password']}', NOW(), NOW())";

		run_mysql_query($query);
		$_SESSION['registration_success_message'] = "Thank you for registering";
		header("location: index.php");
		die();

	}
}

function login_user($post) // just a parameter called post
{
	$query = "SELECT * FROM users WHERE users.password = '{$post['password']}' 
			  AND users.email = '{$post['email']}'";

	$user = fetch($query); // go and attempt to get user information from the database.

	if(count($user) > 0)
	{
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['first_name'] = $user[0]['first_name'];
		$_SESSION['logged_in'] = TRUE;
		header('location: main.php');
	}
	else
	{
		$_SESSION['fail'] = "Can't find a user with those credentials";
		header("location: index.php");
		die();
	}
}

function message($post)
{
	$query_message = "INSERT INTO messages (user_id, message, created_at, updated_at) VAlUES ({$_SESSION['user_id']}, '{$post['message']}', NOW(), NOW())";

	run_mysql_query($query_message);

	$query_comment = "INSERT INTO comments (message_id, user_id, comment, created_at, updated_at) VALUES ('{$post['message_id']}', '{$post['user_id']}', '{$post['comment']}', NOW(), NOW())";

	var_dump($query_comment);
	// run_mysql_query($query_comment);

	header("location: main.php");


}
 ?>











