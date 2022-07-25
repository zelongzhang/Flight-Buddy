<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once "../inc/sqldb.php";
	require_once "../inc/connectioninc.php";
    require_once "../inc/auth.php";

	$js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("username", $js_submit))
    {
        $_POST = $js_submit;
    }
	if(isTokenValid($_POST["username"])) {
		if(!isUserManager($connection, $_POST["username"]))
		{
			echo(json_encode(array("Error" => "User is not a flight manager.")));
		}
		$username = $_POST["username"];
		$id = $_POST["id"];
		$date = $_POST["date"];
		$time = $_POST["time"];
		$availableSeats = $_POST["availableSeats"];
        $routeId = $_POST["routeId"];
        $airplaneId = $_POST["airplaneId"];
		$price = $_POST["price"];
		
		if(isConnectionFieldsEmpty($id, $date, $time, $availableSeats, $routeId, $airplaneId, $price))
		{
			echo(json_encode(array("Error" => "Submission field(s) are empty.")));
		}
		elseif(connectionExists($connection, $id))
		{
			echo(json_encode(array("Error" => "Please choose a unique id for your connection.")));
		}
		elseif(!routeExists($connection, $routeId))
		{
			echo(json_encode(array("Error" => "The chosen route does not exist.")));
		}
        elseif(!planeExists($connection, $airplaneId))
		{
			echo(json_encode(array("Error" => "The chosen plane does not exist.")));
		}
		elseif(!priceOk($price))
		{
			echo(json_encode(array("Error" => "Enter Valid Price.")));
		}
		else
		{
			createConnection($connection, $id, $date, $time, $availableSeats, $routeId, $airplaneId, $price, $username);
			echo(json_encode(array("Message" => "Succesfully created connection " . $id)));
		}
	}
	else {
		echo(json_encode(array("Error" => "Invalid access.")));
	}
