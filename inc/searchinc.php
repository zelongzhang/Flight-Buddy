<?php

function isFieldEmpty($price, $flightTime, $maxDistance, $departure, $arrival, $date)
{
	if (empty($price) || empty($flightTime) || empty($maxDistance) || empty($departure) || empty($arrival) || empty($date))
	{
		return true;
	}
	return false;
}

function getFlights($connection, $price, $flightTime, $maxDistance, $departure, $arrival, $date) 
{
	$query = "SELECT DISTINCT C.id, C.price, C.time, C.date, departure_airport, arrival_airport, distance, flight_time, C.available_seats
		FROM air_route AS A, connection AS C
			WHERE
				C.route_id = A.id AND
				C.price <= ? AND
				C.date = ? AND
				A.flight_time <= ? AND
				A.distance <= ? AND
				A.departure_airport = ? AND
				A.arrival_airport = ?;";

    $stmt = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $query)) {
		echo($connection->error);
		//TODO: Throw some kind of error/warning
		exit();
	}
    mysqli_stmt_bind_param($stmt, "iisiss", $price, $date, $flightTime, $maxDistance, $departure, $arrival);
    mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$result_arr[]= $row;
	}
    if (empty($result_arr))
	{
		return json_decode ("{}");
	}
	else
	{
		return $result_arr;
	}
	mysqli_stmt_close($stmt);
}