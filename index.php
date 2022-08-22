<?php
if( empty( $bins_main ) ) die("Cannot access this page directly!");

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
$weather_file = "../bins-main/brookfield-weather.json";
$render_cache_file = __ROOT__.'/'.$folder_name.'/view-render-cache.php';
$log_mode = '-w.cached';
$view_log_mode = '-v.cached';
$today = time();
$today = date("Y-m-d", $today);
$tomorrow = date("Y-m-d",strtotime("+1 days"));
$var_good = $post_bins_row1 = 0;

//CONTROLLER
require_once('controller.php');

//HTML HEAD
require_once(__ROOT__.'/bins-main/html-head.php');


//weather cache
if( !file_exists($weather_file) ) {
    $API_result = weatherAPI($weather_file, $api_location, $api_key);
    $log_mode = " | Running from API file creation, code: " . $API_result . ' | ';
    echo '<!-- ' . $log_mode . ' -->';
} else {
    if(time() - filemtime($weather_file) >= 2 * 3600) { 
        $API_result = weatherAPI($weather_file, $api_location, $api_key);
        $log_mode = " | Running from API file update, code: " . $API_result . ' | ';
        echo '<!-- ' . $log_mode . ' -->';
    }
}
$text = file_get_contents($weather_file);
echo '<!-- File loaded -->';
$data = json_decode($text);



//!!! VIEW RENDER cache !!!
if( !file_exists($render_cache_file) ) {
    $render_result = renderView($render_cache_file, $current_bin, $grey, $blue, $green, $brown, $precipitation_type, $data);
    $view_log_mode = " | Running from render file creation, code: " . $render_result . ' | ';
    echo '<!-- ' . $view_log_mode . ' -->';
} else {
    if(time() - filemtime($render_cache_file) >= 5 * 3600 || date("l", strtotime('today')) == 'Monday' && date("H") <= 8) { 
        $render_result = renderView($render_cache_file, $current_bin, $grey, $blue, $green, $brown, $precipitation_type, $data);
        $view_log_mode = " | Running from render file update, code: " . $render_result . ' | ';
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

    <div class="row">
            <h2 id="next-collection">
                Next collection:
            </h2>
    </div>
    <div class="row pl0"> 
        <div class="col">
            <h4>
                <?php echo date("l", strtotime($arr[0])) ?>, <br/>
                <span id="thedate0"><?php echo $arr[0] ?></span>
            </h4>
            <?php
            if(isset($data->data->timelines[0]->intervals)) {
                echo $weather = weatherDisplay($data, $arr[0], $precipitation_type);
            }  
            ?>
    </div>


<?php
echo $post_bins_row1;
?>

    </div><br />
    <div class="row">
        <h2>
            Future collections:
        </h2>
    </div>

<?php
echo $post_bins_rows;
?>
        

  </div>     
          <div id="tabs-2">
          <div id="calendar"></div>
  </div>

<div class="d-flex justify-content-between">
    <button id="dark" class="btn btn-outline-light btn-sm active" ontouchstart="toggleTheme('dark');" onclick="toggleTheme('dark');"><span class="icon-toggle-off"></span>
 Dark mode </button>
    <button id="light" class="btn btn-outline-light btn-sm active" ontouchstart="toggleTheme('light');" onclick="toggleTheme('light');"><span class="icon-toggle-on"></span> Dark mode </button>

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
displayBinModals($current_bin);
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
echo $post_weather_modal;
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

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
        
<script>



    if (currentTheme) {
    htmlEl.dataset.theme = currentTheme;
    $('#light').removeClass('d-none');
    $('#'+currentTheme).addClass('d-none');

}else{
        $('#'+currentTheme).removeClass('d-none');
    $('#light').addClass('d-none');

}



if(dismisser){
    $('#octopus').addClass('d-none');
}else{
    $('#octopus').removeClass('d-none');
}
                
function dismiss(){
    localStorage.setItem('dismiss', 'yes');
    $('#octopus').addClass('d-none');
}


//tabs

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

            ]
        });
        calendar.render();
  }
});
                

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
    document.getElementById("next-collection").textContent = "Collection this week: ";
  }
    
}



    </script>

<script defer>

$('img.bin').bind('touchstart touchend', function(e) {
    $(this).attr('src', $(this).data("hover"));
});

$("img.bin").mouseover(function() {
  $(this).attr('src', $(this).data("hover"));
}).mouseout(function() {
  $(this).attr('src', $(this).data("src"));
});

</script>


<?php
    include_once "unversioned-b.php";
?>

</body>

</html>
    


