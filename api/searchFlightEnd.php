<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once "../inc/sqldb.php";
    require_once "../inc/auth.php";
    require_once "../inc/searchinc.php";

    $js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("submitSearch", $js_submit))
    {
        $_POST = $js_submit;
    }
    if(isset($_POST["submitSearch"])) 
    {
        $username = $_POST["username"];
        if(isTokenValid($username))
        {
            $price = $_POST["price"];
            $flightTime = $_POST["flightTime"];
            $maxDistance = $_POST["maxDistance"];
            $departureAirport = $_POST["departureAirport"];
            $arrivalAirport = $_POST["arrivalAirport"];
            $date = $_POST["date"];

            if(isFieldEmpty($price, $flightTime, $maxDistance, $departureAirport, $arrivalAirport, $date))
            {
                echo(json_encode(array("Error" => "One or more field is empty.")));
            }
            else
            {
                $flight = getFlights($connection, $price, $flightTime, $maxDistance, $departureAirport, $arrivalAirport, $date);
                echo(json_encode($flight));
            }
        }
    }
    else
    {
        echo(json_encode(array("Error" => "Invalid access.")));
    }