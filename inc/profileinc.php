<?php

function isUpdateAccountFieldsEmpty($username)
{
    if (empty($username))
    {
        return true;
    }
    return false;
}

function updateAccount($connection, $username, $fName, $lName, $password, $email) {
	if(!empty($fName)){
		$sql = "UPDATE user SET first_name = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			// TODO: Throw Error/Warning
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ss", $fName, $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(!empty($lName)){
		$sql = "UPDATE user SET last_name = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			// TODO: Throw Error/Warning
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ss", $lName, $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(!empty($password)){
		$sql = "UPDATE user SET password = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			// TODO: Throw Error/Warning
			exit();
		}
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(!empty($email)){
		$sql = "UPDATE user SET email = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($connection);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			// TODO: Throw Error/Warning
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ss", $email, $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}	
}

function getUserProfile($conn, $username)
{
	$sql = "SELECT * FROM user WHERE username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw Error/Warning
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
		return $result_arr;
	}
	mysqli_stmt_close($stmt);
}