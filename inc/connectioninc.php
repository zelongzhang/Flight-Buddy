<?php

function connectionExists($conn, $id)
{
	$sql = "SELECT * FROM connection WHERE id = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
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

function routeExists($conn, $route)
{
	$sql = "SELECT * FROM air_route WHERE id = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $route);
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

function planeExists($conn, $plane)
{
	$sql = "SELECT * FROM airplane WHERE id = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $plane);
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

function priceOk($price){
	if($price<0){
		return false;
	}else{
		return true;
	}
}

function createConnection($connection, $id, $date, $time, $availableSeats, $routeId, $airplaneId, $price, $username) 
{
	$sql = "INSERT INTO connection (id, date, time, available_seats, route_id, airplane_id, price) VALUE (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// TODO: Throw Error/Warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "issiiid", $id, $date, $time, $availableSeats, $routeId, $airplaneId, $price);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);


	$sql = "INSERT INTO manages (connection_id, username) VALUE (?, ?)";
	$stmt = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// TODO: Throw Error/Warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "is", $id, $username);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);


}

function isConnectionFieldsEmpty($id, $date, $time, $availableSeats, $routeId, $airplaneId, $price)
{
	if (empty($id) || empty($date) || empty($time) || empty($availableSeats) || empty($routeId) || empty($airplaneId) || empty($price))
	{
		return true;
	}
	return false;
}

function getAssocConnections($conn, $username)
{
	$sql = "SELECT DISTINCT C.id, C.date, C.time, C.available_seats, C.route_id, C.airplane_id, C.price FROM connection AS C, manages AS M WHERE C.id = M.connection_id AND M.username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw Error/Warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	
	$result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            
			$result_arr[]= $row;
        }

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

function isConnectionManaged($conn, $connection_id, $username)
{
	if(!ConnectionExists($conn, $connection_id))
	{
		return false;
	}
	$sql = "SELECT * FROM manages WHERE connection_id = ? AND username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
	mysqli_stmt_bind_param($stmt, "is", $connection_id, $username);
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

function removeConnection($conn, $connection_id)
{
	$sql = "DELETE FROM connection WHERE id=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw Error/Warning
		return false;
	}
	mysqli_stmt_bind_param($stmt, "s", $connection_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	$sql = "DELETE FROM manages WHERE connection_id=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo($conn->error);
		//TODO: Throw Error/Warning
		return false;
	}
	mysqli_stmt_bind_param($stmt, "s", $connection_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return true;
}