<?php

function getWeatherInformation($city) {
    // sample, not working, API key from openweathermap
    $apiKey = "699b5244030753188aa1eef4d7751ad2";
    // URL to get the weather forecast for a given city (in Celsius degrees)
    $weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$apiKey";

    // get the weather forecast for that city
    $weather = file_get_contents($weatherUrl);
    $weatherJson = json_decode($weather, true);

    // we are interested in temperature and in the short description
    $weatherTemperature = round($weatherJson["main"]["temp"]);
    $weatherDescription = $weatherJson["weather"][0]["description"];

    // preparing the response...
    $response = "It is $weatherTemperature degree with $weatherDescription in $city";

    $fulfillment = array(
        "fulfillmentText" => $response
    );

    // ... and send it back to Dialogflow
    echo json_encode($fulfillment);
}

// listen for the POST request coming from Dialogflow
$request = file_get_contents("php://input");
// decode it from JSON
$requestJson = json_decode($request, true);

// extract the name of the city
$city = $requestJson['queryResult']['parameters']['geo-city'];

if(isset($city)){
    getWeatherInformation($city);
}