<?php
require 'variables.php';

$url='https://api.openweathermap.org/data/2.5/weather?q=Haninge&appid='.$APIkey.'&units=metric';

//Initializes a new cURL session
$curl=curl_init($url);

// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json'
]);
// Execute cURL request with all previous settings
$response = curl_exec($curl);
// Close cURL session
curl_close($curl);


$jsonData = json_decode($response);

$temp = $jsonData->main->temp;
$weather_main = $jsonData->weather[0]->main;
$weather_id = $jsonData->weather[0]->id;
$weather_description = $jsonData->weather[0]->description;
$weather_icon = $jsonData->weather[0]->icon;


// Brandbergens centrum
$brandbergens_centrum_url = "https://api.resrobot.se/v2/departureBoard?format=json&operators=275&id=740001171&maxJourneys=6&key=" . $ResRobotStolptidtabeller2APIKey;
// Skyttens gata
$skyttens_gata_url = "https://api.resrobot.se/v2/departureBoard?format=json&operators=275&id=740069366&maxJourneys=6&key=" . $ResRobotStolptidtabeller2APIKey;

$departures_urls = array(
    "skyttens" => $skyttens_gata_url,
    "brandbergen_centrum" => $brandbergens_centrum_url
);

$departures = array();

foreach ($departures_urls as $name => $url) {
    //Initializes a new cURL session
    $curl=curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Set custom headers for RapidAPI Auth and Content-Type header
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json'
    ]);
    // Execute cURL request with all previous settings
    $response = curl_exec($curl);
    curl_close($curl);

    $jsonData = json_decode($response);

    for ($i = 0; $i < count($jsonData->Departure); $i++) {
        $departures[$name][] = array(
            "bus" => $jsonData->Departure[$i]->transportNumber,
            "time" => $jsonData->Departure[$i]->time,
            "direction" => $jsonData->Departure[$i]->direction,
        );
    }
}

$data = array(
    "temp" => $temp,
    "weather_main" => $weather_main,
    "weather_id" => $weather_id,
    "weather_description" => $weather_description,
    "weather_icon" => $weather_icon,

    "departures_skyttens" => $departures["skyttens"],
    "departures_brandbergen" => $departures["brandbergen_centrum"],
);

header('Content-Type: application/json');
echo json_encode($data);

?>
