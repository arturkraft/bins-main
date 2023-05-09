<?php
//$url='https://arturkraft-dev.10web.cloud';
require_once 'bin-locations.php';



// $sw_file = $url."/".$bin_location."/sw.js";


foreach($bin_locations as $bin_location) {
    copy($url.$bin_location."/indexphp.php", "../".$bin_location."/index.html");
    copy($url.$bin_location."/offlinephp.php", "../".$bin_location."/offline.html");
    echo $url.$bin_location."/indexphp.php done <br />";

    $first_line = 'const OFFLINE_VERSION = '.gmdate("ymd").'-'.rand(1,999).'; const CACHE_NAME = \''.$bin_location.'-cache\';OFFLINE_URL="offline.html";self.addEventListener("install",e=>{e.waitUntil((async()=>{let e=await caches.open(CACHE_NAME);await e.add(new Request(OFFLINE_URL,{cache:"reload"}))})()),self.skipWaiting()}),self.addEventListener("activate",e=>{e.waitUntil((async()=>{"navigationPreload"in self.registration&&await self.registration.navigationPreload.enable()})()),self.clients.claim()}),self.addEventListener("fetch",e=>{"navigate"===e.request.mode&&e.respondWith((async()=>{try{let a=await e.preloadResponse;if(a)return a;let t=await fetch(e.request);return t}catch(i){console.log("Fetch failed; returning offline page instead.",i);let n=await caches.open(CACHE_NAME),r=await n.match(OFFLINE_URL);return r}})())});';
    
    echo $first_line.'<br />';

    $sw_file = "../".$bin_location."/sw.js";

    
    file_put_contents($sw_file, $first_line);

    $webmanifest_file = "../".$bin_location."/manifest.webmanifest";

    if (!file_exists($webmanifest_file)){
         $manifest = Array (
            "theme_color" => "#0C4622",
            "background_color" => "#0C4622",
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
}