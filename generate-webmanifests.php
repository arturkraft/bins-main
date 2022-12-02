<?php

$url='https://bins.ren/';
$bin_locations = ['brookfield', 'brooklands', 'linwood', 'weirswynd'];
echo 'done!';

foreach($bin_locations as $bin_location) {

    $manifest = Array (
        "theme_color" => "#1e7a43",
        "background_color" => "#1e7a43",
        "display" => "standalone",
        "start_url" => $url.$bin_location."/",
        "scope" => $url.$bin_location."/",
        "name" => "Bin Collection Days bins.ren/".$bin_location,
        "short_name" => "Bin Days bins.ren/".$bin_location,
        "orientation" => "any",
        "description" => "Check when and what bin will be collected this week.",
        "icons" => Array (
            Array (
            "src" => $url."android-chrome-192x192.png",
            "sizes" => "192x192",
            "type" => "image/png"
            ),
            Array (
            "src" => $url."android-chrome-256x256.png",
            "sizes" => "256x256",
            "type" => "image/png"
            ),
        )
    );
    // encode array to json
    $json = json_encode($manifest, JSON_UNESCAPED_SLASHES);
    $bytes = file_put_contents("../".$bin_location."/manifest.webmanifest", $json); //generate json file
    echo "Here is the data";
    print_r($json);
}


