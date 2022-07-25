<?php

function isRegFieldsEmpty($username, $fname, $lname, $email, $password, $passwordConfirm)
{
	if (empty($username) || empty($fname) || empty($lname) || empty($email) || empty($password) || empty($passwordConfirm))
	{
		return true;
	}
	return false;
}

function isLoginFieldsEmpty($username, $password)
{
	if (empty($username) ||  empty($password))
	{
		return true;
	}
	return false;
}

function isUsernameValid($username)
{
	if (!preg_match("/^[a-z\d]{4,22}$/i", $username))
	{
		return false;
	}
	return true;
}

function isEmailValid($email)
{
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		return false;
	}
	return true;
}

function doPasswordsMatch($password, $passwordConfirm)
{
	if($password !== $passwordConfirm)
	{
		return false;
	}
	return true;
}

function isUsernameInDb($conn, $username)
{
	$sql = "SELECT * FROM user WHERE username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$result_arr = mysqli_fetch_assoc($result);
	if (empty($result_arr))
	{
		return false;
	}
	else
	{
		return true;
	}
	mysqli_stmt_close($stmt);
}

function isEmailInDb($conn, $email)
{
	$sql = "SELECT * FROM user WHERE email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$result_arr = mysqli_fetch_assoc($result);
	if (empty($result_arr))
	{
		return false;
	}
	else
	{
		return true;
	}
	mysqli_stmt_close($stmt);
}

function isUserRegistered($conn, $username, $password)
{
	$sql = "SELECT * FROM user WHERE username = ? AND password = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw Error/Warning
		exit();
	}
	$profile = getUserProfile($conn, $username);
	if(!$profile)
	{
		return false;
	}
	$hashed_password = $profile["password"];
	if(password_verify($password, $hashed_password))
	{
		mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$result_arr = mysqli_fetch_assoc($result);
		if (empty($result_arr))
		{
			return false;
		}
		else
		{
			return true;
		}
		mysqli_stmt_close($stmt);
	}
	else
	{
		return false;
	}
}

function createUser($connection, $username, $fname, $lname, $password, $email) {
	$sql = "INSERT INTO user (username, password, email, first_name, last_name) VALUE (?, ?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// TODO: Throw Error/Warning
		exit();
	}
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	mysqli_stmt_bind_param($stmt, "sssss", $username, $hashed_password, $email, $fname, $lname);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function isUserManager($connection, $username)
{
	$sql = "SELECT * FROM flight_manager WHERE username = ?;";
	$stmt = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// TODO: Throw Error/Warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$result_arr = mysqli_fetch_assoc($result);
	if (empty($result_arr))
	{
		return false;
	}
	else
	{
		return true;
	}
	mysqli_stmt_close($stmt);
}