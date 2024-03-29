<?php
if( empty( $bins_main ) ) die('Cannot access this page directly!');
//log and cache
$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");
$time = microtime(TRUE);
$mem = memory_get_usage();

//VARIABLES
define('__ROOT__', dirname(dirname(__FILE__)));
$current_bin = ['grey', 'blue', 'green', 'brown'];
$precipitation_type = ['rain', 'rain', 'snow', 'freezing rain', 'sleet'];
$filename = __ROOT__.'/'.$folder_name.'/generated-bin-dates.csv';
$weather_file = __ROOT__.'/bins-main/brookfield-weather.json';
$render_cache_file = __ROOT__.'/'.$folder_name.($offline == 1 ? '/view-render-cache-offline.php' : '/view-render-cache.php');
$log_mode = '-w.cached';
$view_log_mode = '-v.cached';
$today = time();
$today = date('Y-m-d', $today);
$tomorrow = date('Y-m-d',strtotime('+1 days'));
$festivity = ['none', 'halloween', 'christmas'];
$current_festivity = $festivity[0];
$bins_for_json = [];
$cdn_img_url = "https://bins.b-cdn.net/bins-main/img/";


//CONTROLLER
require_once(__ROOT__.'/bins-main/controller.php');


header('Access-Control-Allow-Origin: https://bins.b-cdn.net');


//HTML HEAD
require_once(__ROOT__.'/bins-main/html-head.php');




//weather cache
if( !file_exists($weather_file) ) {
    $API_result = weatherAPI($weather_file, $api_location, $api_key);
    $log_mode = ' | Running from API file creation, code: ' . $API_result . ' | ';
    echo '<!-- ' . $log_mode . ' -->';
} else {
    if(time() - filemtime($weather_file) >= 2 * 3600) { 
        $API_result = weatherAPI($weather_file, $api_location, $api_key);
        $log_mode = ' | Running from API file update, code: ' . $API_result . ' | ';
        echo '<!-- ' . $log_mode . ' -->';
    }
}
$text = file_get_contents($weather_file);
echo '<!-- File loaded -->';
$data = json_decode($text);



if($offline == 1){
include_once("bins-base64.php");
}


//!!! VIEW RENDER cache !!!
if( !file_exists($render_cache_file) ) {
    $render_result = renderView($render_cache_file, $current_bin, $grey, $blue, $green, $brown, $precipitation_type, $data);
    $view_log_mode = ' | Running from render file creation, code: ' . $render_result . ' | ';
    echo '<!-- ' . $view_log_mode . ' -->';
} else {
    if(time() - filemtime($render_cache_file) >= 8 * 3600 || date('l', strtotime('today')) == 'Monday' && date('H') < 11) { 
        $render_result = renderView($render_cache_file, $current_bin, $grey, $blue, $green, $brown, $precipitation_type, $data);
        $view_log_mode = ' | Running from render file update, code: ' . $render_result . ' | ';
        echo '<!-- ' . $view_log_mode . ' -->';
    }
}

    

        include $render_cache_file;


echo '<!-- Render view file loaded and bins are sorted -->';

?>

<body>


<div id="loading" class="loading">
  <!-- <img id="loading-image" src="path/to/ajax-loader.gif" alt="Loading..." /> -->
  <h1>Bins.ren/<?php 
      
      echo $folder_name;
      
      ?></h1>
</div>

<div id="content" class="container-lg pb-5" style="padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);">

<?php
if($offline == 1){
    echo '<div class="alert alert-secondary animated-box in" role="alert">
  <p><strong>Your device has lost internet connection</strong>, but you still can use this app. Press the button below once your connection is restored.</p>

        <a id="reload" class="btn btn-primary btn-sm" href="javascript:void();" role="button">Reload</a>
    </div>';
}
?>
        <h1 class="pt-5"><span class="bolder">Bin collection days</span> <span class="thinner">- <?php echo $location_name; ?></span></h1>
    
<div id="tabs" class="pt-3">
  <ul class="sticky">
    <li><a href="#tabs-1"><span class="icon-sort-amount-desc"></span> Coming up</a></li>
    <li><a href="#tabs-2"><span class="icon-calendar"></span> Calendar</a></li>
  </ul>
  <div id="tabs-1">
    <?php
        for ($i=0; $i<4; $i++) {
    ?>
    <?php
    $row_date = array_keys($bins_array)[$i];
    $exploded = explode(', ', $bins_array[$row_date]);
    
    

    if($i == 0){



        $bins_for_json[$row_date] = $exploded[0];
        if (isset($exploded[1])) {
            $bins_for_json[$row_date]=array($exploded[0],$exploded[1]);
        } else {
            $bins_for_json[$row_date]=array($exploded[0]);
        }    

        $json_data = json_encode($bins_for_json);
        //!!! VIEW RENDER cache !!!
        if(!file_exists('bins-closest.json')) {
            file_put_contents('bins-closest.json', $json_data);
            echo '<!-- closest json created -->';
        } else {
            if(time() - filemtime('bins-closest.json') >= 8 * 3600 || date('l', strtotime('today')) == 'Monday' && date('H') < 11) { 
                file_put_contents('bins-closest.json', $json_data);
                echo '<!-- closest json updated -->';
            }
        }

        
    ?>
    <div class="row">
        <h2 id="next-collection">
            Next collection:
        </h2>
    </div>
<?php   } elseif($i == 1) { ?>
    <div class="row">
        <h2>
            Future collections:
        </h2>
    </div>
    <?php } ?>
    <div class="row pl<?php echo $i; ?>"> 
        <div class="col">
            <h4>
                <?php echo date("l", strtotime($row_date)) ?>, <br/>
                <span id="thedate<?php echo $i; ?>"><?php echo $row_date; ?></span>
            </h4>

            <?php
            if(isset($data->data->timelines[0]->intervals) && $i != 3) {
                $displayed = weatherDisplay($data, $row_date, $precipitation_type, $weatherCodeDay, $offline);
                //weatherDisplay($data, $row_date, $precipitation_type, $weatherCodeDay, $offline);
                if($i==0 && $displayed != "no data") {
                    echo '<br />
                    <div id="weather-tip" class="">
                        <div class="chcontainer">
                          <div class="chevron"></div>
                          <div class="chevron"></div>
                          <div class="chevron"></div>
                        </div><p class="text-muted">Tap to see weather</p>
                    </div>';
                }
            }  
            ?>
        </div>
        <div class="col col-md-auto">
            
            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin1 = $exploded[0]; ?>-modal">
                <figure class="figure float-end">
                    <img src="<?php echo ($offline == 1) ? $bins_base64[$row_bin1] : $cdn_img_url.$row_bin1.'.png'; ?>" class="bin bin<?php echo $row_bin1; ?> figure-img img-fluid" data-hover="<?php echo $current_festivity != $festivity[0] ? $cdn_img_url . $current_festivity . '/' .$row_bin1 : $cdn_img_url.$row_bin1; ?>-2.png" data-src="<?php echo ($offline == 1) ? $bins_base64[$row_bin1] : $cdn_img_url.$row_bin1.'.png'; ?>" alt="<?php echo $row_bin1; ?>">
                    <figcaption class="bin figure-caption text-center <?php echo $row_bin1; ?>"><?php echo strtoupper($row_bin1); ?></figcaption>
                </figure>
            </a>
        </div>
        <?php if (isset($exploded[1])) { ?>
        <div class="col col-md-auto">
            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin2 = $exploded[1]; ?>-modal">
                <figure class="figure float-end">
                    <img src="<?php echo ($offline == 1) ? $bins_base64[$row_bin2] : $cdn_img_url.$row_bin2.'.png'; ?>" class="bin bin<?php echo $row_bin2; ?> figure-img img-fluid" data-hover="<?php echo $current_festivity != $festivity[0] ? $cdn_img_url .$current_festivity . '/' .$row_bin2 : $cdn_img_url.$row_bin2; ?>-2.png" data-src="<?php echo ($offline == 1) ? $bins_base64[$row_bin2] : $cdn_img_url.$row_bin2.'.png'; ?>" alt="<?php echo $row_bin2; ?>">
                    <figcaption class="bin figure-caption text-center <?php echo $row_bin2; ?>"><?php echo strtoupper($row_bin2); ?></figcaption>
                </figure>
            </a>
        </div>
        <?php } ?>
        <?php if ($i != 0 && $i != 3){ ?>
        <hr />
        <?php } ?>
        <?php if ($i == 0){ ?>
        <div class="alert alert-secondary" role="alert">
            Please put your <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin1; ?>-modal"><strong class="<?php echo $row_bin1; ?>"><span class="icon-delete"></span><?php echo $row_bin1; ?></strong></a>
            <?php if(isset($exploded[1])) { ?>
            and <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin2; ?>-modal"><strong class="<?php echo $row_bin2; ?>"><span class="icon-delete"></span><?php echo $row_bin2; ?></strong></a> 
            <?php } ?>
            bin out for collection before 7.00am. Collections can take place until 6.30pm.
        </div>
              <?php 
      
                if ($ad == 1){
              ?>
                <div>
                    <div class="alert alert-secondary animated-box in" role="alert">
                        <h4 class="d-md-none">&#x1F9FC;&#x1FAE7; Sparkling Sundays in Brookfield!</h4>
                        <h4 class="d-none d-md-block">&#x1FAE7;&#x1F9FC; Sparkling Sundays in Brookfield! &#x1F9FC;&#x1FAE7;</h4><p> Banish grime, embrace freshness! &pound;2.50 per bin. Spotless, fragrant bins guaranteed. Join satisfied neighbours, message <strong style="font-size: 1.2em">A&C Cleaning Services</strong> on <a href="https://www.facebook.com/groups/774532133340547/">Facebook</a>.</p>
                        
                        
                    </div>
                </div>
              <?php
                }

              ?>
        <hr />
        <?php } ?>
    </div>
    <?php
    }
    ?>
    </div><br />  
        <div id="tabs-2">
        <div id="calendar"></div>
    </div>

<div class="d-flex justify-content-between">
    <button id="dark" class="btn btn-outline-light btn-sm active" onclick="toggleTheme('dark');"><span class="icon-toggle-off"></span>
 Dark mode </button>
    <button id="light" class="btn btn-outline-light btn-sm active" onclick="toggleTheme('light');"><span class="icon-toggle-on"></span> Dark mode </button>
    

    <?php
    if($offline != 1 && $ics_calendar == 1){
    ?>
    <a href="<?php echo $folder_name ?>.ics" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="true" style="color: #fff"><span class="icon-system_update"></span> <strong>2023</strong> Phone calendar</a>
    <?php
    }
    ?>
</div>


</div>

<?php
    if($offline == 1){
        echo "<p style=\"padding: 20px;\">Offline content saved on: " . date("Y-m-d h:i:sa") . "</p>";
    }
    ?>
<br /><br /><br />
<div class="d-flex justify-content-between">
<p class="bins-ren"><a href="<?php echo ($offline == 1) ? '#' : 'https://bins.ren'; ?>" target="_blank" aria-current="page" >BINS.REN</a></p>

<p class="bins-ren">&copy;<?php echo date("Y"); ?> Artur Kraft <a href="<?php echo ($offline == 1) ? '#' : 'https://artur.kr/'; ?>" data-type="URL" data-id="<?php echo ($offline == 1) ? '#' : 'https://artur.kr/'; ?>" style="text-decoration-color: #7bdcb5;" target="_blank" >artur.kr</a></p>
</div>
    
    
<?php 
if ($show_octopus == 1) {
?>
    <!-- octopus -->
    <div id="octopus">
        <div class="container my-5">
        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-4 fw-bold lh-1"><span class="icon-gift"></span> Get <strong>£50</strong> for switching to Octopus Energy</h1>
            <p class="lead">With energy prices going up so quickly, save some money by switching to Octopus Energy.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
            <a href="https://share.octopus.energy/tan-loris-643" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold"><span class="icon-gift"></span> Get £50</a>
            <button type="button" class="btn btn-outline-secondary btn-sm px-4" onclick="dismiss();"><span class="icon-heart-broken"></span> Dismiss</button>
            </div>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
            <img class="rounded-lg-3" src="https://bins.b-cdn.net/bins-main/img/octopus.png" alt="" width="720">
        </div>
        </div>
    </div>
    </div>
    <!-- octopus -->
<?php
}
?>

    </div>
    


<?php
//bin modals
        $grey_good = ['Non-recyclable waste', 'Plastic bags and polythene', 'Polystyrene', 'Crisp and sweet wrappers', 'Used tissues and paper towels', 'Cling film', 'Tinfoil', 'Lightbulbs', 'Pet litter', 'Nappies', 'Personal hygiene products', 'Food and drinks pouches', 'Hard plastics (toys, coat hangers, CD cases etc.)', 'Padded envelopes', 'Shredded paper'];
        $grey_bad = ['Plastics, cans and glass', 'Paper, card and cardboard', 'Food waste', 'Garden waste', 'Electrical items', 'Textiles and shoes'];
        $blue_good = ['Cardboard (flattened)', 'Cereal boxes', 'Large brown cardboard boxes', 'Corrugated cardboard', 'Toilet and kitchen roll tubes', 'Cardboard packaging', 'Paper (clean and dry)', 'Envelopes (with and without windows)', 'Magazines', 'Newspapers', 'Office paper', 'Telephone directories', 'Paperback books', 'Catalogues', 'Junk mail and takeaway menus'];
        $blue_bad = ['Glass', 'Plastics and cans', 'Hardback books', 'Plastic carrier bags', 'Padded envelopes', 'Plastic wrapping and bubble wrap', 'Polystyrene', 'Packaging with food residue', 'Used tissues and kitchen roll', 'Foil wrapping paper', 'Tinfoil', 'Shredded paper'];
        $green_good = ['Plastic bottles', 'Plastic pots, tubs and trays', 'Fruit and vegetable punnets', 'Clean takeaway containers', 'Cleaning product bottles', 'Drinks cans (empty and rinsed)', 'Food/pet food tins (empty and rinsed)', 'Biscuit/sweet tins', 'Aerosols', 'Glass bottles and jars', 'Cartons', 'Milk cartons'];
        $green_bad = ['Paper, card and cardboard', 'Food residue', 'Carrier bags', 'Sweet and crisp wrappers', 'Plastic wrapping and bubble wrap', 'Polystyrene Food and drink pouches', 'Hard plastics (toys, coat hangers, CD case etc)', 'Food and drink pouches', 'Light bulbs', 'Pyrex or crockery', 'Mirrors', 'Tinfoil'];
        $brown_good = ['Grass cuttings', 'Flowers and plants', 'Weeds', 'Leaves', 'Small branches and twigs', 'Cooked and uncooked food', 'Leftovers', 'Fruit and vegetable peelings', 'Tea bags and coffee grounds', 'Egg shells', 'Out of date food (remove packaging)', 'Bread, pasta and cakes', 'Meat, fish and small bones'];
        $brown_bad = ['Plastic bags', 'Packaging', 'Liquids', 'Fats and oils', 'Rubble and soil', 'Plant pots', 'Wood and fencing', 'Garden furniture', 'Plastics, cans and glass', 'Paper, card and cardboard'];
        $brown_extra = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brown-modal-extra">How to use the brown bin?</button>';


        for ($x=0; $x<=3; $x++) {
?>

<div class="modal fade" id="<?php echo $current_bin[$x]; ?>-modal" style="z-index: 99969">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">


                        <div class="modal-header">
                            <h4 class="modal-title <?php echo $current_bin[$x]; ?>">What goes in the <?php echo $current_bin[$x]; ?> bin?</h4>
                            <button type="button" class="btn-close <?php echo $current_bin[$x]; ?>" data-bs-dismiss="modal"></button>
                        </div>


                        <div class="modal-body">
                            <div class="container">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <h5>These items can go in your <?php echo $current_bin[$x]; ?> bin:</h5>
                                        <ul style="list-style: none;">
                                        <?php foreach (${$current_bin[$x].'_good'} as $good_item) { ?>
                                            <li><span class="icon-goodli green"></span><?php echo $good_item; ?></li>                                
                                        <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <h5>Do not put these items in your <?php echo $current_bin[$x]; ?> bin:</h5>
                                        <ul style="list-style: none;">
                                        <?php foreach (${$current_bin[$x].'_bad'} as $bad_item) { ?>
                                            <li><span class="icon-badli text-danger"></span><?php echo $bad_item; ?></li>                                
                                        <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <?php echo ${$current_bin[$x].'_extra'} = isset(${$current_bin[$x].'_extra'}) ? ${$current_bin[$x].'_extra'} : ' '; ?>

                            <button type="button" class="btn btn-outline-secondary <?php echo $current_bin[$x]; ?>" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>

<?php
        }
?>



<div class="modal fade" id="weather-modal" style="z-index: 99969">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="icon-sun"></span> Weather forecast for <?php echo $location_name; ?></h4>
                <button type="button" class="btn-close brown" data-bs-dismiss="modal"></button>
            </div>


        <div class="modal-body">
            <div class="container">
                <div class="table-responsive">
                    <table class="table caption-top">
                    <tbody>
                        <tr>
<?php
for($i = 0; $i<count($data->data->timelines[0]->intervals); $i++) {
    $date_to_change = substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10);
    $formatted_date = date("l", strtotime($date_to_change));  
?>
                            <td>
                                <div class="alert alert-light text-wrap" style="width: 8rem;"><?php echo $formatted_date; ?>
                                    <br />
                                    <?php echo date("M, jS", strtotime($date_to_change)); ?>
                                    <br />
                                    <div style="margin-bottom: -30px">
                                    <?php
                                    if ($offline != 1){
                                    ?>
                                        <img src="https://bins.b-cdn.net/bins-main/img/large/<?php echo $data->data->timelines[0]->intervals[$i]->values->weatherCodeDay ?>.png" />
                                    <?php
                                    }
                                    ?>
                                        <p class="weatherinfo"><?php echo $weatherCodeDay[$data->data->timelines[0]->intervals[$i]->values->weatherCodeDay]; ?></p>
                                    </div>
                                    <br />
                                    <span class="fs-4">
                                        <?php echo trim(floor($data->data->timelines[0]->intervals[$i]->values->temperature)).'&#8451;'; ?>
                                    </span>
                                    <?php
                                    if($data->data->timelines[0]->intervals[$i]->values->precipitationType != 0) { ?>
                                        <br />
                                        <span class="icon-rainy"></span> 
                                        Chance of 
                                        <?php echo $precipitation_type[ $data->data->timelines[0]->intervals[$i]->values->precipitationType ] . ': ' . $data->data->timelines[0]->intervals[$i]->values->precipitationProbability . '%';
                                    } else { ?>
                                        <br />
                                        <span class="icon-rainy"></span> 
                                        Chance of rain: 0%
                                    <?php } ?>
                                        <br />
                                        <span class="icon-wind"></span> 
                                        Wind speed: 
                                        <?php echo $data->data->timelines[0]->intervals[$i]->values->windSpeed; ?> 
                                        mph 
                                </div>
                                <?php
                                if( isset($bins_array[$date_to_change]) ){
                                    $exploded = explode(', ', $bins_array[$date_to_change]);
                                ?>
                                <p class="text-center text-uppercase fw-bold <?php echo $exploded[0]; ?>">
                                    <span class="icon-delete"></span>
                                    <?php echo $exploded[0]; ?>
                                </p>

                                <?php
                                if ( isset($exploded[1]) ){
                                ?>
                                <p class="text-center text-uppercase fw-bold <?php echo $exploded[1] ?>">
                                    <span class="icon-delete"></span><?php echo $exploded[1] ?>
                                </p>
                                <?php
                                    }
                                } ?>
                            </td>

<?php
}
?>
                        </tr>
                    </tbody>
                    </table><!--
                    <p>
                        <span style="padding-left: 8rem;">
                            Swipe left/right <span class="icon-one-finger-swipe-horizontally" style="font-size: 2em"></span>
                        </span>
                    </p>-->
                </div>
            </div>
        </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
        
<div class="modal fade" id="brown-modal-extra" style="z-index: 99969">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title brown">How to use the brown bin?</h4>
                <button type="button" class="btn-close brown" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <div class="container">
                        <div class="row align-items-start">
                            <div class="col">
                                <ul><li>Don't put your food waste in plastic bags - only use the special recyclable food waste liners we provide, or put food directly into the bin.</li><li>Remove all packaging.</li><li>Don't put hot or cold liquids into your brown bin.</li><li>Use your brown bin to recycle as much food and garden waste as you can.</li><li>Make sure the lid is closed to minimise odour, deters vermin, prevents litter and protect the health and safety of our collection crews.</li></ul>
                            </div>
                            <div class="col">
                                <h4>Contamination sticker</h4>
                                If the wrong material is in your brown bin, we cannot empty it as it will contaminate the whole vehicle load. 

                                If your bin is contaminated with items that can't be recycled, we will attach a contamination sticker and your bin won't be emptied. If you remove the contaminants, the bin will be emptied on your next scheduled collection day.
                            </div>
                        </div>
            </div>
        </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brown-modal">What goes in the brown bin?</button>
                <button type="button" class="btn btn-outline-secondary brown" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




<?php 
    require_once(__ROOT__.'/bins-main/bottom-js.php'); 

    require_once(__ROOT__.'/bins-main/unversioned-b.php');
?>

</body>

</html>