<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once "../inc/sqldb.php";
    require_once "../inc/profileinc.php";
    require_once "../inc/auth.php";

    $js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("username", $js_submit))
    {
        $_GET = $js_submit;
    }

    if (isTokenValid($_GET["username"]))
    {
        //fetch and return profile
        $profile = getUserProfile($connection, $_GET["username"]);
        echo json_encode(
            array(
                "username" => $profile["username"],
                "email" => $profile["email"],
                "firstname" => $profile["first_name"],
                "lastname" => $profile["last_name"]
            )
        );
    }