<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once '../inc/sqldb.php';
	require_once '../inc/logininc.php';
    require_once '../inc/profileinc.php';
	require_once '../inc/auth.php';

	$js_submit = (array) json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("changeProfile", $js_submit))
    {
        $_POST = $js_submit;
    }
	if(isset($_POST["changeProfile"])) {
        $username = $_POST["username"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$password = $_POST["password"];
        $passwordConfirm = $_POST["passwordConfirm"];
		$email = $_POST["email"];
		
		if(!isTokenValid($username))
		{
			echo(json_encode(array("Error" => "User Login Token Invalid. Please login again.")));
		}
		if(isUpdateAccountFieldsEmpty($username))
		{
			echo(json_encode(array("Error" => "Submission field(s) are empty.")));
		}
        elseif(!doPasswordsMatch($password, $passwordConfirm))
		{
			echo(json_encode(array("Error" => "Passwords do not match.")));
		}
		else
		{
			updateAccount($connection, $username, $fname, $lname, $password, $email);
			echo(json_encode(array("Message" => "Succesfully updated account " . $username)));
		}
	}
	else {
		echo(json_encode(array("Error" => "Invalid access.")));
	}