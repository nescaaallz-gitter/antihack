<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$client = $_SERVER['HTTP_USER_AGENT'];
$paths = "";

if(strcmp($client, 'PreLauncher') === 0){
    $paths = "(?:data$)";
}
else if(strcmp($client, 'Minecraft') === 0){
    $paths = "(?:mods$)";
}
else if(strcmp($client, 'Launcher') === 0){
    $paths = "(?:versions|libraries)";
}
else {
    echo ';)';
    return;
}


$files = [];
$di = new RecursiveDirectoryIterator('data');
foreach (new RecursiveIteratorIterator($di) as $filename) {
    if(preg_match('/.(?:jar|zip|litemod|json)$/', basename($filename))){
        if(preg_match('/' . $paths .'/', dirname($filename))){
            $hash = [
                'path' => dirname($filename) . '/',
                'name' => basename($filename),
                'md5' => md5_file($filename),
                'sha1' => sha1_file($filename),
            ];
            $files[] = $hash;
        }
    }
}

echo json_encode($files, JSON_PRETTY_PRINT);
?>