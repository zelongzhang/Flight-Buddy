function checkLogin()
{
    console.log("checking login");
    console.log(localStorage.getItem("jwt"));
    if(!localStorage.getItem("jwt") || !localStorage.getItem("username"))
    {
        //User is not logged in, generate login and signup buttons in header.
        generateLoginHeaders(false);
        return false;
    }
    else
    {
        //User is logged in, generate logged in user display and log out button.
        generateLoginHeaders(true);
        return true;
    }
}

function generateLoginHeaders(isloggedin)
{
    var style = "float: right;"+
    "background-color: transparent;"+
    "border: 1px solid white;"+
    "color: white;"+
    "text-align: center;"+
    "text-decoration: none;"+
    "padding: 5px 10px;"+
    "margin-top: -25px;"+
    "display: inline-block;"+
    "font-size: 16px;"+
    "transition-duration: 0.2s;";
    if(!isloggedin)
    {
        //User is not logged in, generate login and signup buttons in header.
        var signup = document.createElement("button");
        signup.setAttribute("id", "signup");
        signup.onclick = function () {location.href = "register.html";}
        signup.innerHTML = "Sign up";
        signup.style.cssText = style;
        document.body.appendChild(signup);

        var login = document.createElement("button");
        login.setAttribute("id", "login");
        login.onclick = function () {location.href = "login.html";}
        login.innerHTML = "Log In";
        login.style.cssText = style;
        document.body.appendChild(login);
    }
    else
    {
        //User is logged in, generate logged in user display and log out button.
        var logout = document.createElement("button");
        logout.setAttribute("id", "logout");
        logout.innerHTML = "Log Out";
        logout.style.cssText = style;
        logout.onclick = function () {
            localStorage.removeItem("jwt"); 
            localStorage.removeItem("username");
            localStorage.removeItem("manager");
            location.href = "home.html";
        }
        document.body.appendChild(logout);
    }
}

function getProfile()
{
    console.log(localStorage.getItem("jwt"));
    if(!localStorage.getItem("jwt") || !localStorage.getItem("username"))
    {
        //User is not logged in, generate confirmation and send back to homepage.
        if(window.confirm("Please log in first."))
        {
            window.location.replace("home.html");
        }
        else
        {
            window.location.replace("home.html");
        }
    }
    else
    {
        //User is logged in, generate html contents dynamically
        //Submit post request to profile endpoint to retrieve user profile information.
        fetch("api/profileEnd.php?username="+localStorage.getItem("username"), {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'Authorization': "Bearer " + localStorage.getItem("jwt")
        },
        })
        .then(response => response.json())
        .then(data => {
            console.log("Success:", data);
            if(data["Error"])
            {
                //Api has returned a validation error, redirect back to home.
                if(window.confirm(data["Error"]))
                {
                    localStorage.removeItem("jwt");
                    localStorage.removeItem("username");
                    localStorage.removeItem("manager");
                    window.location.replace("home.html");
                }
                else
                {
                    localStorage.removeItem("jwt");
                    localStorage.removeItem("username");
                    localStorage.removeItem("manager");
                    window.location.replace("home.html");
                }
            }
            else
            {
                //Api has returned a profile json, display dynamically
                var username = document.createElement("h3");
                username.innerHTML = "Username: " + data["username"];
                username.setAttribute("id", "username");
                document.body.appendChild(username);
                var email = document.createElement("h3");
                email.innerHTML = "Email: " + data["email"];
                document.body.appendChild(email);
                var firstname = document.createElement("h3");
                firstname.innerHTML = "First Name: " + data["firstname"];
                document.body.appendChild(firstname);
                var lastname = document.createElement("h3");
                lastname.innerHTML = "Lastname: " + data["lastname"];
                document.body.appendChild(lastname);
                var editProfile = document.createElement("button");
                editProfile.innerHTML = "Edit Profile";
                editProfile.onclick = function() {window.location.replace("editProfile.html");}
                document.body.appendChild(editProfile);

            }
        })
        .catch((error) => {
        console.error("Error:", error);
        });
    }
}

function getConnections()
{
    console.log(localStorage.getItem("jwt"));
    if(!localStorage.getItem("jwt") || !localStorage.getItem("username"))
    {
        //User is not logged in, generate confirmation and send back to homepage.
        if(window.confirm("Please log in first."))
        {
            window.location.replace("home.html");
        }
        else
        {
            window.location.replace("home.html");
        }
    }
    else
    {
        //User is logged in, check if user is flight manager
        if(localStorage.getItem("manager") == "false")
        {
            if(window.confirm("You are not a flight manager."))
            {
                window.location.replace("home.html");
            }
            else
            {
                window.location.replace("home.html");
            }
        }
        //Submit get request to connections endpoint to retrieve associated connections.
        fetch("api/associatedConnectionsEnd.php?username="+localStorage.getItem("username"), {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'Authorization': "Bearer " + localStorage.getItem("jwt")
        },
        })
        .then(response => response.json())
        .then(data => {
            console.log("Success:", data);
            if(data["Error"])
            {
                //Api has returned a validation error, redirect back to home.
                if(window.confirm(data["Error"]))
                {
                    localStorage.removeItem("jwt");
                    localStorage.removeItem("username");
                    window.location.replace("home.html");
                }
                else
                {
                    localStorage.removeItem("jwt");
                    localStorage.removeItem("username");
                    window.location.replace("home.html");
                }
            }
            else
            {
                //Api has returned a results json, display dynamically
                for(var i=0; i<data.length; i++)
                {
                    var flightid = document.createElement("h6");
                    flightid.innerHTML = "Flight ID: " + data[i]["id"];
                    document.body.appendChild(flightid);

                    var date = document.createElement("h6");
                    date.innerHTML = "Flight Date: " + data[i]["date"];
                    document.body.appendChild(date);
                    
                    var time = document.createElement("h6");
                    time.innerHTML = "Departure Time: " + data[i]["time"];
                    document.body.appendChild(time);

                    var seats = document.createElement("h6");
                    seats.innerHTML = "Available Seats: " + data[i]["available_seats"];
                    document.body.appendChild(seats);

                    var route = document.createElement("h6");
                    route.innerHTML = "Air Route ID: " + data[i]["route_id"];
                    document.body.appendChild(route);

                    var plane = document.createElement("h6");
                    plane.innerHTML = "Plane ID: " + data[i]["airplane_id"];
                    document.body.appendChild(plane);

                    var price = document.createElement("h6");
                    price.innerHTML = "Price: " + data[i]["price"];
                    document.body.appendChild(price);

                    var deleteconnection = document.createElement("button");
                    deleteconnection.innerHTML = "Remove Connection";
                    var id = data[i]["id"];
                    deleteconnection.onclick = function(){removeConnection(id)};
                    document.body.appendChild(deleteconnection);
                }
            }
        })
        .catch((error) => {
        console.error("Error:", error);
        });
    }
}

function removeConnection(id)
{
    //Submit get request to remove connections endpoint to delete the connection.
    const data = {"username": localStorage.getItem("username"), "connection_id": id};
    fetch("api/removeConnectionEnd.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        'Accept': 'application/json',
        'Authorization': "Bearer " + localStorage.getItem("jwt")
    },
    body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(data => {
        console.log("Success:", data);
        if(data["Error"])
        {
            //Api has returned a validation error, redirect back to home.
            if(window.confirm(data["Error"]))
            {
                localStorage.removeItem("jwt");
                localStorage.removeItem("username");
                localStorage.removeItem("manager");
                window.location.replace("home.html");
            }
            else    
            {
                localStorage.removeItem("jwt");
                localStorage.removeItem("username");
                localStorage.removeItem("manager");
                window.location.replace("home.html");
            }
        }
        else
        {
            //Api has returned a Success
            window.location.replace("connections.html");
        }
    })
    .catch((error) => {
    console.error("Error:", error);
    });
}