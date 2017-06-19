<?php
if (!empty($_GET['location'])) {
    /**
     * Here we build the url we'll be using to access the google maps api
     * urlencode will encode any invalid characters that users input i.e. whitespace
     */
    $maps_url =
        'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['location']);

    /* Processes the "GET" request and returns json. Note there are other methods for this function
    * i.e. PUT POST
    */
    $maps_json = file_get_contents($maps_url);

    // Now decode the json returned from the GET request into an array for users
    $maps_array = json_decode($maps_json, true);

    // Lets get the lat and long for the instagram api
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];

    /**
     * Time to make our Instagram api request. We'll build the url using the
     * coordinate values returned by the google maps api
     */
    $insta_url =
        'http://api.openweathermap.org/data/2.5/forecast' .
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&client_id=812c81cd96b946c7a36d14d3373e85cc'; //replace "CLIENT-ID"

    // get the json from the api call
    $weather_json = file_get_contents($url);

    // convert json into array
    $weather_array = json_decode($json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>geogram</title>
</head>
<body>
<form action="<?php $_PHP_SELF ?>" method="GET">
    <input type="text" name="location"/>
    <button type="submit">Submit</button>
    <br>
    <?php
        echo '<p>'.$weather_array.'</p>';
        if(!empty($weather_array))
        {
            echo '<p>'.$weather_array['list']['main']['temp'].'</p>';
            echo '<br>';
        }
    ?>
</form>
</body>
</html>
