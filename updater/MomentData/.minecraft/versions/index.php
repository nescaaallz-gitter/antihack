<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$client = $_SERVER['HTTP_USER_AGENT'];
if(strcmp($client, 'Launcher') !== 0){
//    echo ';)';
//    return;
}

$latest = [
    'release' => "MomentCraft"
];

$versions = [];
$di = new RecursiveDirectoryIterator('.');
foreach (new RecursiveIteratorIterator($di) as $filename) {
    if(preg_match('/.jar$/', basename($filename))){
        $time = filectime($filename) > filemtime($filename) ? filectime($filename) : filemtime($filename);
        $hash = [
            'id' => basename(dirname($filename)),
            'type' => "release",
            'time' => date("Y-m-d\TH:i:sP", $time),
            'releaseTime' => date("Y-m-d\TH:i:sP", $time),
            'sha1' => sha1_file($filename),
        ];
        $versions[] = $hash;
    }
}

echo json_encode(['latest' => $latest, 'versions' => $versions], JSON_PRETTY_PRINT);
?>