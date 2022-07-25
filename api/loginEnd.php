<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once "../inc/sqldb.php";
    require_once "../inc/logininc.php";
    require_once "../inc/auth.php";

    $js_submit = (array)json_decode(file_get_contents("php://input"), true);
    if(array_key_exists("submitLogin", $js_submit))
    {
        $_POST = $js_submit;
    }
    
    if(isset($_POST["submitLogin"])) 
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(isLoginFieldsEmpty($username, $password))
        {
            echo(json_encode(array("Error" => "Login field(s) are empty.")));
        }
        elseif(!isUserRegistered($connection, $username, $password))
        {
            echo(json_encode(array("Error" => "Username or Password did not match.")));
        }
        else
        {
            //User has entered valid login information, return a JWT in response.
            $jwt = createToken($connection, $username);
            $manager = isUserManager($connection, $username);
            echo json_encode(array("username" => $username, "jwt" => $jwt, "manager" => $manager));
        }
    }
    else
    {
        echo(json_encode(array("Error" => "Invalid access.")));
    }