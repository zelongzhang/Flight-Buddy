<?php

    require_once "../vendor/autoload.php";
    require_once "profileinc.php";
    use \Firebase\JWT\JWT;

    function createToken($connection, $username)
    {
        //Creates a JWT to authenticate user login. Main body composed of username, email, first name and last name.
        //Referenced from https://github.com/sitepoint-editors/basic-php-jwt-auth-example
        //and https://www.techiediaries.com/php-jwt-authentication-tutorial/
        $profile = getUserProfile($connection, $username);
        $username = $profile["username"];
        $email = $profile["email"];
        $firstname = $profile["first_name"];
        $lastname = $profile["last_name"];
        $secretKey = "PtD87Tf9Q5YbgqlEG9zXCmR4axdBXQ_-5VsM-sgvaSjVxt-LBdzvNfbJ2uamEq7vMKU6zfE3Cc4oNRfIKWmH6w";
        $tokenId    = base64_encode(random_bytes(16));
        $issuedAt   = time();
        // $notBefore = $issuedAt + 10;
        // $expire     = $issuedAt + 60;
        $serverName = "flightbuddy";

        $token = [
            "iat"  => $issuedAt,         // Issued at: time when the token was generated
            "jti"  => $tokenId,          // Json Token Id: an unique identifier for the token
            "iss"  => $serverName,       // Issuer
            "data" => [                  // Data related to the signer user
                "username" => $username,
                "email" => $email,
                "firstname" => $firstname,
                "lastname" => $lastname
            ]
        ];

        $jwt = JWT::encode($token, $secretKey, 'HS512');
        return $jwt;
    }

function isTokenValid($username)
{
    /*
    Checks if a token exists in the request and if it is valid for a user login JWT.
    Requires: Token in the header in the following format Authorization : Bearer <JWT>
              param: username: user name of the currently logged in user.
    */

    $headers = getallheaders();
    // Attempt to extract the token from the Bearer header
    if (!array_key_exists("Authorization", $headers))
    {
        header('HTTP/1.0 400 Bad Request');
        echo(json_encode(array("Error" => "Token not found in request. Please login again.")));
        exit;
    }

    $auth_header = explode(" ", $headers["Authorization"]);

    //Check if header is in correct format.
    if (count($auth_header)<2)
    {
        header('HTTP/1.0 400 Bad Request');
        echo(json_encode(array("Error" => "Token is not in correct format in header. Please login again.")));
        exit;
    }

    $jwt = $auth_header[1];
    //check if token can be extracted
    if (!$jwt)
    {
        header('HTTP/1.0 400 Bad Request');
        echo(json_encode(array("Error" => "Token was unable to be extracted from header. Please login again.")));
        exit;
    }

    $secretKey = "PtD87Tf9Q5YbgqlEG9zXCmR4axdBXQ_-5VsM-sgvaSjVxt-LBdzvNfbJ2uamEq7vMKU6zfE3Cc4oNRfIKWmH6w";
    JWT::$leeway += 60;
    // $now = time();
    $serverName = "flightbuddy";

    //try to decode jwt
    try 
    {
        $token = JWT::decode((string)$jwt, $secretKey, ['HS512']);
    }
    catch(Exception $e)
    {
        header('HTTP/1.1 401 Unauthorized');
        echo(json_encode(array("Error" => "Token could not be decoded. Please login again.")));
        exit;
    }
   
    $data = json_decode(json_encode($token->data), true);

    //check if token data matches posted data
    if ($token->iss !== $serverName || $data["username"] !== $username)
    {
        header('HTTP/1.1 401 Unauthorized');
        echo(json_encode(array("Error" => "Token is invalid. Please login again.")));
        exit;
    }
    return true;
}