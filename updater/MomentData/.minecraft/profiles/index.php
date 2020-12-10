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

$profiles = [];
$di = new RecursiveDirectoryIterator('../versions');
foreach (new RecursiveIteratorIterator($di) as $filename) {
    if(preg_match('/.jar$/', basename($filename))){
        $time = filectime($filename) > filemtime($filename) ? filectime($filename) : filemtime($filename);
        $profile = [ 
            'name' => basename(dirname($filename)),
            'lastVersionId' => basename(dirname($filename)),
        ];
        $profiles += [
            basename(dirname($filename)) => $profile,
        ];
    }
}
ksort($profiles);
echo json_encode(['profiles' => (Object) $profiles, 'selectedProfile' => 'MomentCraft'], JSON_PRETTY_PRINT);
?>