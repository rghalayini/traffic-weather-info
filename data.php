<?php

// We use environment variables instead when we run on heroku since they use that.
// It would be nice to use environment variables when developing locally as well
// (e.g. using a .env file) but that might be a bit too complex
// So if there is an environment variable LIVE and it set to true, we know we
// code running is deployed on heroku, and then we will use environment variables instead
if (isset($_ENV["LIVE"]) && $_ENV["LIVE"] == "TRUE") {
    $APIkey = $_ENV["OPEN_WEATHER_MAP_API_KEY"];
    $ResRobotStolptidtabeller2APIKey = $_ENV["RESROBOT_STT2_API_KEY"];
} else {
    require 'variables.php';
}

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



//-----------------------------------------------------------------------------------//
//-----------------------------DAILY WEATHER PREDICTION------------------------------//
//-----------------------------------------------------------------------------------//

$daily_forecast_url="https://api.openweathermap.org/data/2.5/onecall?lat=59.1783&lon=18.1564&exclude=current,minutely,hourly&appid=".$APIkey."&units=metric";

//--Initializes a new cURL session
$curl=curl_init($daily_forecast_url);
// Set custom headers for RapidAPI Auth and Content-Type header
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
    

//add weather temperature for each day
$day1_temp=$jsonData->daily[1]->temp->day;
$day2_temp=$jsonData->daily[2]->temp->day;
$day3_temp=$jsonData->daily[3]->temp->day;
$day4_temp=$jsonData->daily[4]->temp->day;
$day5_temp=$jsonData->daily[5]->temp->day;
$day6_temp=$jsonData->daily[6]->temp->day;
$day7_temp=$jsonData->daily[7]->temp->day;

//add weather description for each day
$day1_description = $jsonData->daily[1]->weather[0]->description;
$day2_description = $jsonData->daily[2]->weather[0]->description;
$day3_description = $jsonData->daily[3]->weather[0]->description;
$day4_description = $jsonData->daily[4]->weather[0]->description;
$day5_description = $jsonData->daily[5]->weather[0]->description;
$day6_description = $jsonData->daily[6]->weather[0]->description;
$day7_description = $jsonData->daily[7]->weather[0]->description;



//-----------------------------------------------------------------------------------//
//--------------------------------------BUS DATA-------------------------------------//
//-----------------------------------------------------------------------------------//

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
    "day1_temp" => $day1_temp,
    "day2_temp" => $day2_temp,
    "day3_temp" => $day3_temp,
    "day4_temp" => $day4_temp,
    "day5_temp" => $day5_temp,
    "day6_temp" => $day6_temp,
    "day7_temp" => $day7_temp,
    "day1_description" => $day1_description,
    "day2_description" => $day2_description,
    "day3_description" => $day3_description,
    "day4_description" => $day4_description,
    "day5_description" => $day5_description,
    "day6_description" => $day6_description,
    "day7_description" => $day7_description,


    "departures_skyttens" => $departures["skyttens"],
    "departures_brandbergen" => $departures["brandbergen_centrum"],
);

header('Content-Type: application/json');
echo json_encode($data);

?>
