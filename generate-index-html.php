<?php
//$url='https://arturkraft-dev.10web.cloud';
$url='https://bins.ren';
$bin_locations = ['brookfield', 'brooklands', 'linwood', 'weirswynd'];
echo 'done!';

foreach($bin_locations as $bin_location) {
    copy($url."/".$bin_location."/indexphp.php", "../".$bin_location."/index.html");
}


