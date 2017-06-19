<?php
if (!empty($_GET['location'])) {
    /**
     * Here we build the url we'll be using to access the google maps api
     */
    $maps_url = 'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['location']);
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];
    /**
     * Time to make our Instagram api request. We'll build the url using the
     * coordinate values returned by the google maps api
     */
    $insta_url = 'https://' .
        'api.instagram.com/v1/media/search' .
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&client_id=812c81cd96b946c7a36d14d3373e85cc'; //replace "CLIENT-ID"
    $insta_json = file_get_contents($url);
    $insta_array = json_decode($json, true);
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
    <input type="text" name="location"/>
    <button type="submit">Submit</button>
    <?php
    //if (!empty($insta_array)) {
        foreach ($insta_array['data'] as $image) {
            echo '<img src="'
            .$image['images']['low_resolution']['url'].'"
            alt=""/><br/>';
        }
    //}
    ?>
</form>
</body>
</html>
