<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db)
or die("Unable to connect to Database");

function k_to_f($temp) {
    if ( !is_numeric($temp) ) { return false; }
    return round((($temp - 273.15) * 1.8) + 32);
}

if ($_GET['location'])
{
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

    echo 'Latitude: '.$lat;
    echo "<br>";
    echo 'Longitude: '.$lng;
    echo "<br>";

    /**
     * Time to make our Instagram api request. We'll build the url using the
     * coordinate values returned by the google maps api
     */
    $weather_url =
        'http://api.openweathermap.org/data/2.5/forecast' .
        '?lat='.$lat.
        '&lon='.$lng.
        '&APPID=b6b9501f4b9d07e94ddaf093c41feeef'; //replace "CLIENT-ID"

    // get the json from the api call
    $weather_json = file_get_contents($weather_url);

    // convert json into array
    $weather_array = json_decode($weather_json, true);

    $temp = $weather_array['list'][0]['main']['temp'];
    echo 'Temperature: '.$temp;
    echo "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>geogram</title>
</head>
<body>
<form action="" method="get">
    Location: <input type="text" name="location"/>
    <button type="submit">Submit</button>
    <br>
    <?php
        if(!empty($weather_array))
        {
            $sky = $weather_array['list'][0]['weather'] [0]['description'];
            $temp = $weather_array['list'][0]['main']['temp'];
            $temp = k_to_f($temp);
            echo '<p> Temperature: '.$temp.'</p>';
            echo '<p> Weather: '.$sky.'</p>';
            echo '<br>';
        }
    ?>
</form>
</body>
</html>
