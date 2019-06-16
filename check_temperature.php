<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

// $scriptStartTime = time();
//var_dump('Script execution started at ' . date('Y-m-d h:i:s A', $scriptStartTime));

$deviceId = '34005b001851373237343331';
$fileName = 'temperature/' . $deviceId . '.txt';
//var_dump('$fileName=', $fileName);

$filePath = str_replace(basename(__FILE__), '', __FILE__);
//var_dump('$filePath=', $filePath);

$file = $filePath . $fileName;
//var_dump('$file=', $file);

$temperatureFile = file_get_contents($file);
//var_dump('$temperatureFile=', $temperatureFile);

$lastUpdatedTime = filemtime($file);
//var_dump('$lastUpdatedTime=', $lastUpdatedTime);

$currentTime = time();
//var_dump('$currentTime=', $currentTime);

$text = 'The current temperature is unknown.  Please make sure the device is connected to wifi and ask again.';
if (!empty($temperatureFile)) {
    $temperature = $temperatureFile;
    $temperature = round($temperature, 1);
    $text = 'The current temperature is ' . $temperature . ' degrees.';

    $difference = $currentTime-$lastUpdatedTime; // seconds
    //var_dump('$difference=', $difference);

    if ($difference > 300) { // 5 mins ago
        $text = 'The last temperature reading was ' . $temperature . ' degrees on ' . date('F j, g:i a', $lastUpdatedTime) . '.';
    }
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

// $scriptEndTime = time();
//var_dump('Script execution completed at ' . date('Y-m-d h:i:s A', $scriptEndTime) . ' and took ' . ($scriptEndTime - $scriptStartTime) . ' seconds');
?>