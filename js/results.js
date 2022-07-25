function displayResults()
{
    var results = JSON.parse(localStorage.getItem("results"));
    console.log(results);

    var sortPrice = document.createElement("button");
    sortPrice.innerHTML = "Sort By Price";
    sortPrice.onclick = function(){sortByPrice()};
    document.body.appendChild(sortPrice);

    var sortDuration = document.createElement("button");
    sortDuration.innerHTML = "Sort By Flight Duration";
    sortDuration.onclick = function(){sortByFlightDuration()};
    document.body.appendChild(sortDuration);

    var sortDistance = document.createElement("button");
    sortDistance.innerHTML = "Sort By Distance";
    sortDistance.onclick = function(){sortByDistance()};
    document.body.appendChild(sortDistance);

    for(var i=0; i<results.length; i++)
    {
        var flightid = document.createElement("h6");
        flightid.innerHTML = "Flight ID: " + results[i]["id"];
        document.body.appendChild(flightid);

        var departure = document.createElement("h6");
        departure.innerHTML = "Depart From: " + results[i]["departure_airport"];
        document.body.appendChild(departure);

        var arrival = document.createElement("h6");
        arrival.innerHTML = "Arrive At: " + results[i]["arrival_airport"];
        document.body.appendChild(arrival);

        var price = document.createElement("h6");
        price.innerHTML = "Price: $" + results[i]["price"];
        document.body.appendChild(price);

        var date = document.createElement("h6");
        date.innerHTML = "Flight Date: " + results[i]["date"];
        document.body.appendChild(date);
        
        var time = document.createElement("h6");
        time.innerHTML = "Departure Time: " + results[i]["time"];
        document.body.appendChild(time);

        var flightTime = document.createElement("h6");
        flightTime.innerHTML = "Flight Duration: " + results[i]["flight_time"] + " Minutes";
        document.body.appendChild(flightTime);

        var distance = document.createElement("h6");
        distance.innerHTML = "Flight Distance: " + results[i]["distance"] + " Miles";
        document.body.appendChild(distance);

        var seats = document.createElement("h6");
        seats.innerHTML = "Available Seats: " + results[i]["available_seats"];
        document.body.appendChild(seats);

        var space = document.createElement("p");
        document.body.appendChild(space);

    }
}

function sortByPrice()
{
    var results = JSON.parse(localStorage.getItem("results"));
    console.log(results);
    var sortedResults = results.sort(function(a, b) {
        return parseFloat(a.price) - parseFloat(b.price);
    });
    console.log(sortedResults);
    localStorage.removeItem("results");
    localStorage.setItem("results", JSON.stringify(sortedResults));
    location.href = "searchResult.html";
}

function sortByFlightDuration()
{
    var results = JSON.parse(localStorage.getItem("results"));
    console.log(results);
    var sortedResults = results.sort(function(a, b) {
        return parseFloat(a.flight_time) - parseFloat(b.flight_time);
    });
    console.log(sortedResults);
    localStorage.removeItem("results");
    localStorage.setItem("results", JSON.stringify(sortedResults));
    location.href = "searchResult.html";
}

function sortByDistance()
{
    var results = JSON.parse(localStorage.getItem("results"));
    console.log(results);
    var sortedResults = results.sort(function(a, b) {
        return parseFloat(a.distance) - parseFloat(b.distance);
    });
    console.log(sortedResults);
    localStorage.removeItem("results");
    localStorage.setItem("results", JSON.stringify(sortedResults));
    location.href = "searchResult.html";
}