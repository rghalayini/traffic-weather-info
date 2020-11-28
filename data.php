
<?php
require 'variables.php';

$url='https://api.openweathermap.org/data/2.5/weather?q=Haninge&appid='.$APIkey.'&units=metric';

$weather_status=array("raining", "foo", "bar");



//Initializes a new cURL session
$curl=curl_init($url);

// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Set the CURLOPT_POST option to true for POST request
//curl_setopt($curl, CURLOPT_GET, true);

// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json'
]);
// Execute cURL request with all previous settings
$response = curl_exec($curl);
//var_dump($response);
// Close cURL session
curl_close($curl);


$jsonData = json_decode($response);

$temp = $jsonData->main->temp;
$weather_main = $jsonData->weather[0]->main;
$weather_id = $jsonData->weather[0]->id;
$weather_description = $jsonData->weather[0]->description;
$weather_icon = $jsonData->weather[0]->icon;

$data = array(
    "temp" => $temp,
    "weather_main" => $weather_main,
    "weather_id" => $weather_id,
    "weather_description" => $weather_description,
    "weather_icon" => $weather_icon,

    "departures_skyttens" => array(
        array(
            "bus" => "809",
            "time" => "08:10"
        ),
        array(
            "bus" => "807",
            "time" => "08:11"
        ),
        array(
            "bus" => "832",
            "time" => "08:13"
        )
    ),
    "departures_brandbergen" => array(
        array(
            "bus" => "809",
            "time" => "08:15"
        ),
        array(
            "bus" => "807",
            "time" => "08:16"
        ),
        array(
            "bus" => "832",
            "time" => "08:17"
        )
    ),
);

header('Content-Type: application/json');
echo json_encode($data);

?>