<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once "../inc/sqldb.php";
    require_once "../inc/logininc.php";
    require_once "../inc/connectioninc.php";
    require_once "../inc/auth.php";

    $js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("username", $js_submit))
    {
        $_GET = $js_submit;
    }

    if (isTokenValid($_GET["username"]))
    {
        if(isUserManager(!$connection, $_GET["username"]))
        {
            echo(json_encode(array("Error" => "User is not a flight manager.")));
        }
        //fetch and return connections
        $connections = getAssocConnections($connection, $_GET["username"]);
        echo json_encode($connections);
    }