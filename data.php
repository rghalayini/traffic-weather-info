
<?php

$weather_status=array("raining", "foo", "bar");

$data = array(
    "temp" => "2",
    "weather_status" => "raining",
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
echo json_encode($data);

?>