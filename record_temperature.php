<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

// $scriptStartTime = time();
//var_dump('Script execution started at ' . date('Y-m-d h:i:s A', $scriptStartTime));

$deviceId = !empty($_POST['coreid']) ? $_POST['coreid'] : null ;
$currentTemperature = !empty($_POST['data']) ? $_POST['data'] : null ;

$fileName = 'temperature/' . $deviceId . '.txt';
//var_dump('$fileName=', $fileName);

$filePath = str_replace(basename(__FILE__), '', __FILE__);
//var_dump('$filePath=', $filePath);

$file = $filePath . $fileName;
//var_dump('$file=', $file);

if (!file_exists($file)) {
    file_put_contents($file, 0);
    //var_dump('Temperature file did not exist, creating!');
}

$temperatureFile = file_get_contents($file);
//var_dump('$temperatureFile=', $temperatureFile);

//var_dump('$currentTemperature=', $currentTemperature);

file_put_contents($file, $currentTemperature);
//var_dump('Temperature updated!');

// $scriptEndTime = time();
//var_dump('Script execution completed at ' . date('Y-m-d h:i:s A', $scriptEndTime) . ' and took ' . ($scriptEndTime - $scriptStartTime) . ' seconds');

echo 'Recorded temperature ' . $currentTemperature . ' from device ' . $deviceId . ' at path ' . $file . '.';
?>