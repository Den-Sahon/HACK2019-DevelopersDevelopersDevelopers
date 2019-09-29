<?php


header('Content-type: text/plain');

//$data = file_get_contents('php://input');


//$data = explode(':|:', $data);

$image_data = 'https://qrcode.website/t/cc30eb';//$data[0];
//$user_token = $data[1];

$image_data = file_get_contents($image_data);


$matches = null;

preg_match('/\*developersdevelopersdevelopers\*(.*)\*developersdevelopersdevelopers\*/i', $image_data, $matches);

print_r($matches[1]);

