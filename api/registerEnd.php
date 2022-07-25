<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once '../inc/sqldb.php';
	require_once '../inc/logininc.php';

	$js_submit = (array) json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("submitRegister", $js_submit))
    {
        $_POST = $js_submit;
    }
	
	if(isset($_POST["submitRegister"])) {
		$username = $_POST["username"];
		$email = $_POST["email"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$password = $_POST["password"];
		$passwordConfirm = $_POST["passwordConfirm"];
		
		if(isRegFieldsEmpty($username, $fname, $lname, $email, $password, $passwordConfirm))
		{
			echo(json_encode(array("Error" => "Register field(s) are empty.")));
		}
		elseif(!isUsernameValid($username))
		{
			echo(json_encode(array("Error" => "Invalid username. Username must be between 4-22 characters with letters and numbers only.")));
		}
		elseif(!isEmailValid($email))
		{
			echo(json_encode(array("Error" => "Invalid email.")));
		}
		elseif(!doPasswordsMatch($password, $passwordConfirm))
		{
			echo(json_encode(array("Error" => "Password and confirm password do not match.")));
		}
		elseif(isUsernameInDb($connection, $username))
		{
			echo(json_encode(array("Error" => "That username is already taken. Please choose another username.")));
		}
		elseif(isEmailInDb($connection, $email))
		{
			echo(json_encode(array("Error" => "That email is already in use. Please choose another email.")));
		}
		else
		{
			createUser($connection, $username, $fname, $lname, $password, $email);
			echo(json_encode(array("Message" => "Succesfully registered as " . $username)));
		}
	}
	else {
		echo(json_encode(array("Error" => "Invalid access.")));
	}