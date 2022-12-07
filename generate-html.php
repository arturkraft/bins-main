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
    // Read the file


    
    file_put_contents($sw_file, $first_line);
}