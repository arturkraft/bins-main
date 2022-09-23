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
$render_cache_file = __ROOT__.'/'.$folder_name.'/view-render-cache.php';
$log_mode = '-w.cached';
$view_log_mode = '-v.cached';
$today = time();
$today = date('Y-m-d', $today);
$tomorrow = date('Y-m-d',strtotime('+1 days'));
$festivity = ['none', 'halloween', 'christmas'];
$current_festivity = $festivity[1];

//CONTROLLER
require_once(__ROOT__.'/bins-main/controller.php');

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
<div id ="content" class="container-lg pb-5" style="padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);">
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
    <?php if ($i == 0){ ?>
    <div class="row">
        <h2 id="next-collection">
            Next collection:
        </h2>
    </div>
    <?php } elseif($i==1){ ?>
    <div class="row">
        <h2>
            Future collections:
        </h2>
    </div>
    <?php } ?>
    <?php 
    $row_date = array_keys($bins_array)[$i];
    $exploded = explode(', ', $bins_array[$row_date]);
    ?>
    <div class="row pl<?php echo $i; ?>"> 
        <div class="col">
            <h4>
                <?php echo date("l", strtotime($row_date)) ?>, <br/>
                <span id="thedate<?php echo $i; ?>"><?php echo $row_date; ?></span>
            </h4>
            <?php
            if(isset($data->data->timelines[0]->intervals) && $i != 3) {
                echo weatherDisplay($data, $row_date, $precipitation_type);
            }  
            ?>
        </div>
        <div class="col col-md-auto">
            
            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin1 = $exploded[0]; ?>-modal">
                <figure class="figure float-end">
                    <img src="https://arturkraft.b-cdn.net/bins-main/img/<?php echo $row_bin1; ?>.png" class="bin bin<?php echo $row_bin1; ?> figure-img img-fluid" data-hover="../bins-main/img/<?php echo $current_festivity != $festivity[0] ? $current_festivity . '/' . $row_bin1 : $row_bin1; ?>-2.png" data-src="https://arturkraft.b-cdn.net/bins-main/img/<?php echo $row_bin1; ?>.png" alt="<?php echo $row_bin1; ?>">
                    <figcaption class="bin figure-caption text-center <?php echo $row_bin1; ?>"><?php echo strtoupper($row_bin1); ?></figcaption>
                </figure>
            </a>
        </div>
        <?php if (isset($exploded[1])) { ?>
        <div class="col col-md-auto">
            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#<?php echo $row_bin2 = $exploded[1]; ?>-modal">
                <figure class="figure float-end">
                    <img src="https://arturkraft.b-cdn.net/bins-main/img/<?php echo $row_bin2; ?>.png" class="bin bin<?php echo $row_bin2; ?> figure-img img-fluid" data-hover="../bins-main/img/<?php echo $current_festivity != $festivity[0] ? $current_festivity . '/' . $row_bin2 : $row_bin2; ?>-2.png" data-src="https://arturkraft.b-cdn.net/bins-main/img/<?php echo $row_bin2; ?>.png" alt="<?php echo $row_bin2; ?>">
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

    <a href="<?php echo $folder_name ?>.ics" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="true" style="color: #fff"><span class="icon-system_update"></span> Phone calendar</a>
</div>


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
            <img class="rounded-lg-3" src="https://arturkraft.b-cdn.net/bins-main/img/octopus.png" alt="" width="720">
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
                                    <div style="height: 4rem">
                                        <img src="https://arturkraft.b-cdn.net/bins-main/img/large/<?php echo $data->data->timelines[0]->intervals[$i]->values->weatherCodeDay ?>.png" />
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
                    </table>
                    <p>
                        <span style="padding-left: 8rem;">
                            Swipe left/right <span class="icon-one-finger-swipe-horizontally" style="font-size: 2em"></span>
                        </span>
                    </p>
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


        
<script>
    if (currentTheme) {
    htmlEl.dataset.theme = currentTheme;
    $('#light').removeClass('d-none');
    $('#'+currentTheme).addClass('d-none');

}else{
        $('#'+currentTheme).removeClass('d-none');
    $('#light').addClass('d-none');

}


<?php 
if ($show_octopus == 1) {
?>
if(dismisser){
    $('#octopus').addClass('d-none');
}else{
    $('#octopus').removeClass('d-none');
}
                
function dismiss(){
    localStorage.setItem('dismiss', 'yes');
    $('#octopus').addClass('d-none');
}
<?php 
}
?>



                

//today or tomorrow or date format


function ordinal_suffix_of(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}

var today = new Date().toDateString();
var tomorrow = new Date();
var yesterday = new Date();
tomorrow.setDate(tomorrow.getDate() + 1)
tomorrow = tomorrow.toDateString();
yesterday.setDate(yesterday.getDate() - 1)
yesterday = yesterday.toDateString();
                

for(var i=0; i<=3; i++){
    
var theDate = document.getElementById("thedate"+i).textContent;
var utcDate = new Date(theDate);
var date = new Date(utcDate.getTime() + utcDate.getTimezoneOffset() * 60000) //local Date
var date2 = date.toDateString();
  const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let formatted_date = ordinal_suffix_of(date.getDate()) + " " + months[date.getMonth()];
//let formatted_date = ordinal_suffix_of(date.getDate()) + " " + months[date.getMonth()] + " " + date.getFullYear();

  if(today === date2){
    document.getElementById("thedate"+i).textContent='today';
    document.getElementById("next-collection").textContent = "Today's collection: ";
  }else if(tomorrow === date2){
    document.getElementById("thedate"+i).textContent='tomorrow';
    document.getElementById("next-collection").textContent = "Tomorrow's collection: ";
  }else if(yesterday === date2){
    document.getElementById("thedate"+i).textContent='yesterday';
    document.getElementById("next-collection").textContent = "Yesterday's collection: ";
  }else{
    document.getElementById("thedate"+i).textContent=formatted_date;
    //document.getElementById("next-collection").textContent = "Collection this week: ";
  }
    
}

    </script>

        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js" defer></script>

<script defer>

$('img.bin').bind('touchstart touchend', function(e) {
    $(this).attr('src', $(this).data("hover"));
});

$("img.bin").mouseover(function() {
  $(this).attr('src', $(this).data("hover"));
}).mouseout(function() {
  $(this).attr('src', $(this).data("src"));
});


//tabs and calendar

$('#tabs').tabs({
  activate: function(event, ui) {
            var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          validRange: {
            start: '2022-05-01',
            end: '2023-12-31'
          },
          firstDay: 1,
        aspectRatio: 0.9,
         //themeSystem: 'bootstrap5',
            events: [                
                <?php
                /*
                if( $var_good == 1){
                        for($i = 0; $i<count($data->data->timelines[0]->intervals); $i++) {

                                                                                                        echo "{
                        start: '".substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10)."',
                        end: '".substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10)."',
                        title: '".floor($data->data->timelines[0]->intervals[$i]->values->temperature)." \'C, ".$precipitation_type[ $data->data->timelines[0]->intervals[$i]->values->precipitationType ].": ".$data->data->timelines[0]->intervals[$i]->values->precipitationProbability."%',
                        display: 'background',
                        textColor: '#999',
                        color: '#fff'},";  

                        
                        }
                }
                */
                echo $post_js_events;

                ?>
                    {
                            start: '2022-10-31',
                            end: '2022-10-31',
                            title: 'Halloween',
                            display: 'block',
                            color: '#E66C2C'

                    },
                    {
                            start: '2022-12-25',
                            end: '2022-12-25',
                            title: 'Christmas',
                            display: 'block',
                            color: '#C30F16'

                    }
            ]
        });
        calendar.render();
  }
});


    <?php
    if ($current_festivity == $festivity[1]){
    ?>
        ;(function () {
        var r=Math.random,n=0,d=document,w=window,
            i=d.createElement('img'),
            z=d.createElement('div'),
            zs=z.style,
            a=w.innerWidth*r(),b=w.innerHeight*r();
        zs.position="fixed";
        zs.left=0;
        zs.top=0;
        zs.opacity=0;
        zs.zIndex=999999999;
        z.appendChild(i);
        i.src='data:image/gif;base64,R0lGODlhMAAwAJECAAAAAEJCQv///////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQACACwAAAAAMAAwAAACdpSPqcvtD6NcYNpbr4Z5ewV0UvhRohOe5UE+6cq0carCgpzQuM3ut16zvRBAH+/XKQ6PvaQyCFs+mbnWlEq0FrGi15XZJSmxP8OTRj4DyWY1lKdmV8fyLL3eXOPn6D3f6BcoOEhYaHiImKi4yNjo+AgZKTl5WAAAIfkECQEAAgAsAAAAADAAMAAAAnyUj6nL7Q+jdCDWicF9G1vdeWICao05ciUVpkrZIqjLwCdI16s+5wfck+F8JOBiR/zZZAJk0mAsDp/KIHRKvVqb2KxTu/Vdvt/nGFs2V5Bpta3tBcKp8m5WWL/z5PpbtH/0B/iyNGh4iJiouMjY6PgIGSk5SVlpeYmZqVkAACH5BAkBAAIALAAAAAAwADAAAAJhlI+py+0Po5y02ouz3rz7D4biSJbmiabq6gCs4B5AvM7GTKv4buby7vsAbT9gZ4h0JYmZpXO4YEKeVCk0QkVUlw+uYovE8ibgaVBSLm1Pa3W194rL5/S6/Y7P6/f8vp9SAAAh+QQJAQACACwAAAAAMAAwAAACZZSPqcvtD6OctNqLs968+w+G4kiW5omm6ooALeCusAHHclyzQs3rOz9jAXuqIRFlPJ6SQWRSaIQOpUBqtfjEZpfMJqmrHIFtpbGze2ZywWu0aUwWEbfiZvQdD4sXuWUj7gPos1EAACH5BAkBAAIALAAAAAAwADAAAAJrlI+py+0Po5y02ouz3rz7D4ZiCIxUaU4Amjrr+rDg+7ojXTdyh+e7kPP0egjabGg0EIVImHLJa6KaUam1aqVynNNsUvPTQjO/J84cFA3RzlaJO2495TF63Y7P6/f8vv8PGCg4SFhoeIg4UQAAIfkEBQEAAgAsAAAAADAAMAAAAnaUj6nL7Q+jXGDaW6+GeXsFdFL4UaITnuVBPunKtHGqwoKc0LjN7rdes70QQB/v1ykOj72kMghbPpm51pRKtBaxoteV2SUpsT/Dk0Y+A8lmNZSnZlfH8iy93lzj5+g93+gXKDhIWGh4iJiouMjY6PgIGSk5eVgAADs=';
        d.body.appendChild(z);
        function R(o,m){return Math.max(Math.min(o+(r()-.5)*400,m-50),50)}
        function A(){
            var x=R(a,w.innerWidth),y=R(b,w.innerHeight),
                d=5*Math.sqrt((a-x)*(a-x)+(b-y)*(b-y));
            zs.opacity=n;n=1;
            zs.transition=zs.webkitTransition=d/1e3+'s linear';
            zs.transform=zs.webkitTransform='translate('+x+'px,'+y+'px)';
            i.style.transform=i.style.webkitTransform=(a>x)?'':'scaleX(-1)';
            a=x;b=y;
            setTimeout(A,d);
        };setTimeout(A,r()*3e3);
        })();

        ;(function () {
        var r=Math.random,n=0,d=document,w=window,
            i=d.createElement('img'),
            z=d.createElement('div'),
            zs=z.style,
            a=w.innerWidth*r(),b=w.innerHeight*r();
        zs.position="fixed";
        zs.left=0;
        zs.top=0;
        zs.opacity=0;
        zs.zIndex=999999999;
        z.appendChild(i);
        i.src='data:image/gif;base64,R0lGODlhMAAwAJECAAAAAEJCQv///////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQACACwAAAAAMAAwAAACdpSPqcvtD6NcYNpbr4Z5ewV0UvhRohOe5UE+6cq0carCgpzQuM3ut16zvRBAH+/XKQ6PvaQyCFs+mbnWlEq0FrGi15XZJSmxP8OTRj4DyWY1lKdmV8fyLL3eXOPn6D3f6BcoOEhYaHiImKi4yNjo+AgZKTl5WAAAIfkECQEAAgAsAAAAADAAMAAAAnyUj6nL7Q+jdCDWicF9G1vdeWICao05ciUVpkrZIqjLwCdI16s+5wfck+F8JOBiR/zZZAJk0mAsDp/KIHRKvVqb2KxTu/Vdvt/nGFs2V5Bpta3tBcKp8m5WWL/z5PpbtH/0B/iyNGh4iJiouMjY6PgIGSk5SVlpeYmZqVkAACH5BAkBAAIALAAAAAAwADAAAAJhlI+py+0Po5y02ouz3rz7D4biSJbmiabq6gCs4B5AvM7GTKv4buby7vsAbT9gZ4h0JYmZpXO4YEKeVCk0QkVUlw+uYovE8ibgaVBSLm1Pa3W194rL5/S6/Y7P6/f8vp9SAAAh+QQJAQACACwAAAAAMAAwAAACZZSPqcvtD6OctNqLs968+w+G4kiW5omm6ooALeCusAHHclyzQs3rOz9jAXuqIRFlPJ6SQWRSaIQOpUBqtfjEZpfMJqmrHIFtpbGze2ZywWu0aUwWEbfiZvQdD4sXuWUj7gPos1EAACH5BAkBAAIALAAAAAAwADAAAAJrlI+py+0Po5y02ouz3rz7D4ZiCIxUaU4Amjrr+rDg+7ojXTdyh+e7kPP0egjabGg0EIVImHLJa6KaUam1aqVynNNsUvPTQjO/J84cFA3RzlaJO2495TF63Y7P6/f8vv8PGCg4SFhoeIg4UQAAIfkEBQEAAgAsAAAAADAAMAAAAnaUj6nL7Q+jXGDaW6+GeXsFdFL4UaITnuVBPunKtHGqwoKc0LjN7rdes70QQB/v1ykOj72kMghbPpm51pRKtBaxoteV2SUpsT/Dk0Y+A8lmNZSnZlfH8iy93lzj5+g93+gXKDhIWGh4iJiouMjY6PgIGSk5eVgAADs=';
        d.body.appendChild(z);
        function R(o,m){return Math.max(Math.min(o+(r()-.5)*400,m-50),50)}
        function A(){
            var x=R(a,w.innerWidth),y=R(b,w.innerHeight),
                d=5*Math.sqrt((a-x)*(a-x)+(b-y)*(b-y));
            zs.opacity=n;n=1;
            zs.transition=zs.webkitTransition=d/1e3+'s linear';
            zs.transform=zs.webkitTransform='translate('+x+'px,'+y+'px)';
            i.style.transform=i.style.webkitTransform=(a>x)?'':'scaleX(-1)';
            a=x;b=y;
            setTimeout(A,d);
        };setTimeout(A,r()*3e3);
        })();

                ;(function () {
        var r=Math.random,n=0,d=document,w=window,
            i=d.createElement('img'),
            z=d.createElement('div'),
            zs=z.style,
            a=w.innerWidth*r(),b=w.innerHeight*r();
        zs.position="fixed";
        zs.left=0;
        zs.top=0;
        zs.opacity=0;
        zs.zIndex=999999999;
        z.appendChild(i);
        i.src='data:image/gif;base64,R0lGODlhMAAwAJECAAAAAEJCQv///////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQACACwAAAAAMAAwAAACdpSPqcvtD6NcYNpbr4Z5ewV0UvhRohOe5UE+6cq0carCgpzQuM3ut16zvRBAH+/XKQ6PvaQyCFs+mbnWlEq0FrGi15XZJSmxP8OTRj4DyWY1lKdmV8fyLL3eXOPn6D3f6BcoOEhYaHiImKi4yNjo+AgZKTl5WAAAIfkECQEAAgAsAAAAADAAMAAAAnyUj6nL7Q+jdCDWicF9G1vdeWICao05ciUVpkrZIqjLwCdI16s+5wfck+F8JOBiR/zZZAJk0mAsDp/KIHRKvVqb2KxTu/Vdvt/nGFs2V5Bpta3tBcKp8m5WWL/z5PpbtH/0B/iyNGh4iJiouMjY6PgIGSk5SVlpeYmZqVkAACH5BAkBAAIALAAAAAAwADAAAAJhlI+py+0Po5y02ouz3rz7D4biSJbmiabq6gCs4B5AvM7GTKv4buby7vsAbT9gZ4h0JYmZpXO4YEKeVCk0QkVUlw+uYovE8ibgaVBSLm1Pa3W194rL5/S6/Y7P6/f8vp9SAAAh+QQJAQACACwAAAAAMAAwAAACZZSPqcvtD6OctNqLs968+w+G4kiW5omm6ooALeCusAHHclyzQs3rOz9jAXuqIRFlPJ6SQWRSaIQOpUBqtfjEZpfMJqmrHIFtpbGze2ZywWu0aUwWEbfiZvQdD4sXuWUj7gPos1EAACH5BAkBAAIALAAAAAAwADAAAAJrlI+py+0Po5y02ouz3rz7D4ZiCIxUaU4Amjrr+rDg+7ojXTdyh+e7kPP0egjabGg0EIVImHLJa6KaUam1aqVynNNsUvPTQjO/J84cFA3RzlaJO2495TF63Y7P6/f8vv8PGCg4SFhoeIg4UQAAIfkEBQEAAgAsAAAAADAAMAAAAnaUj6nL7Q+jXGDaW6+GeXsFdFL4UaITnuVBPunKtHGqwoKc0LjN7rdes70QQB/v1ykOj72kMghbPpm51pRKtBaxoteV2SUpsT/Dk0Y+A8lmNZSnZlfH8iy93lzj5+g93+gXKDhIWGh4iJiouMjY6PgIGSk5eVgAADs=';
        d.body.appendChild(z);
        function R(o,m){return Math.max(Math.min(o+(r()-.5)*400,m-50),50)}
        function A(){
            var x=R(a,w.innerWidth),y=R(b,w.innerHeight),
                d=5*Math.sqrt((a-x)*(a-x)+(b-y)*(b-y));
            zs.opacity=n;n=1;
            zs.transition=zs.webkitTransition=d/1e3+'s linear';
            zs.transform=zs.webkitTransform='translate('+x+'px,'+y+'px)';
            i.style.transform=i.style.webkitTransform=(a>x)?'':'scaleX(-1)';
            a=x;b=y;
            setTimeout(A,d);
        };setTimeout(A,r()*3e3);
        })();
    <?php
    }
    ?>

</script>





<?php
    require_once(__ROOT__.'/bins-main/unversioned-b.php');
?>

</body>

</html>
    


