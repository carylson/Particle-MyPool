<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

//$scriptStartTime = time();
//var_dump('Script execution started at ' . date('Y-m-d h:i:s A', $scriptStartTime));

function curl($url) {
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000);
	$output = curl_exec($ch); 
	curl_close($ch);  
	return $output;
}

$data = curl('https://api.particle.io/v1/devices/34005b001851373237343331/temperature?access_token=7be634f544f6b0f8348308d6b62d01b588453f07');
$json = json_decode($data);

$text = 'The current temperature is unknown.  Please make sure the device is connected to wifi and ask again.';
if (!empty($json->result)) {
    $temperature = $json->result;
    $temperature = round($temperature, 1);
    $text = 'The current temperature is ' . $temperature . ' degrees.';
}

echo '{
    "version": "1.0",
    "response": {
        "outputSpeech": {
            "type": "PlainText",
            "text": "' . $text . '"
        },
        "card": {
            "type": "Simple",
            "title": "My Pool - Current Temperature",
            "content": "' . $text . '"
        },
        "shouldEndSession": true
    }
}';

//$scriptEndTime = time();
//var_dump('Script execution completed at ' . date('Y-m-d h:i:s A', $scriptEndTime) . ' and took ' . ($scriptEndTime - $scriptStartTime) . ' seconds');
?>