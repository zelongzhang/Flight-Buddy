<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once "../inc/sqldb.php";
    require_once "../inc/logininc.php";
    require_once "../inc/connectioninc.php";
    require_once "../inc/auth.php";

    $js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("username", $js_submit))
    {
        $_POST = $js_submit;
    }
    
    $username = $_POST["username"];
    $connection_id = $_POST["connection_id"];
    if (isTokenValid($username))
    {
        if(isUserManager($connection, $username))
        {
            echo(json_encode(array("Error" => "User is not a flight manager.")));
        }
        if(!isConnectionManaged($connection, $connection_id, $username))
        {
            echo(json_encode(array("Error" => "Flight does not exist or is not managed by " + $username)));
        }
        if(removeConnection($connection, $connection_id))
        {
            echo(json_encode(array("Message" => "Successfully removed connection " . $connection_id)));
        }
        else
        {
            echo(json_encode(array("Error" => "Could not remove connection.")));
        }
    }
    else
    {
        echo(json_encode(array("Error" => "Invalid login token. Please login again.")));
    }