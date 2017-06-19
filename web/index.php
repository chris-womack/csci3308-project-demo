<?php
// Setup
require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// REST API for Instagram
// check if the input from the form is empty, if not store in _GET array
if(!empty(_GET['location']))
{
    // url for the api, urlencode will encode any invalid characters that users input i.e. whitespace
    $map_url = 'https://'.
        'maps.googleapis.com/maps/api/geocode/json'. // google maps api interface
        '?address='. urlencode($_GET['location']); // query statement for the api

    // Processes the "GET" request and returns json. Note there are other methods for this function i.e. PUT POST
    $map_json = file_get_contents($map_url);

    // Now decode the json returned from the GET request into an array for users
    $map_array = json_decode($map_json, true);

    // Lets get the lat and long for the instagram api
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];

    $instagram_url = 'https://' .
        'api.instagram.com/v1/media/search' . // instagram query statement
        '?lat=' . $lat . // lat param for api
        '&lng=' . $lng . // long param for api
        '&client_id=812c81cd96b946c7a36d14d3373e85ccD';
        // you will need to get an access token if you wish to deploy this yourself

    // send GET request to get the images
    $instagram_json = file_get_contents($url);

    // decode the json and store in an array
    $instagram_array = json_decode($json, true);
}

// Our web handlers
$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig',
        array(
            'instagram_imgs' => $instagram_array
        )
    );
});

$app->run();
