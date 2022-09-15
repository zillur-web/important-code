<?php
    // We define our address
    $address = 'West Rajabazar-Indira Road, Firmgate, Dhaka BN-1205';
    $array = array();
    $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=API_KEY');

    // We convert the JSON to an array
    $geo = json_decode($geo, true);

    // If everything is cool
    if ($geo['status'] = 'OK') {
        $latitude = $geo['results'][0]['geometry']['location']['lat'];
        $longitude = $geo['results'][0]['geometry']['location']['lng'];
        $coordinate = $latitude.','.$longitude;
    }
    echo $coordinate;
?>