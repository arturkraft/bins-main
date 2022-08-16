<?php


if( empty( $bins_main ) ) die("Cannot access this page directly!");
//

//define('__ROOT__', $up2);
define('__ROOT__', dirname(dirname(__FILE__)));



$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");

        $time = microtime(TRUE);
        $mem = memory_get_usage();

$current_bin = ['grey', 'blue', 'green', 'brown'];

$good_li = '<span class="fa-li green"><i class="fas fa-check-square"></i></span>';
$bad_li = '<span class="fa-li text-danger"><i class="fa-solid fa-square-xmark"></i></span>';

$grey_good = ['Non-recyclable waste', 'Plastic bags and polythene', 'Polystyrene', 'Crisp and sweet wrappers', 'Used tissues and paper towels', 'Cling film', 'Tinfoil', 'Lightbulbs', 'Pet litter', 'Nappies', 'Personal hygiene products', 'Food and drinks pouches', 'Hard plastics (toys, coat hangers, CD cases etc.)', 'Padded envelopes', 'Shredded paper'];
$grey_bad = ['Plastics, cans and glass', 'Paper, card and cardboard', 'Food waste', 'Garden waste', 'Electrical items', 'Textiles and shoes'];

$blue_good = ['Cardboard (flattened)', 'Cereal boxes', 'Large brown cardboard boxes', 'Corrugated cardboard', 'Toilet and kitchen roll tubes', 'Cardboard packaging', 'Paper (clean and dry)', 'Envelopes (with and without windows)', 'Magazines', 'Newspapers', 'Office paper', 'Telephone directories', 'Paperback books', 'Catalogues', 'Junk mail and takeaway menus'];
$blue_bad = ['Glass', 'Plastics and cans', 'Hardback books', 'Plastic carrier bags', 'Padded envelopes', 'Plastic wrapping and bubble wrap', 'Polystyrene', 'Packaging with food residue', 'Used tissues and kitchen roll', 'Foil wrapping paper', 'Tinfoil', 'Shredded paper'];

$green_good = ['Plastic bottles', 'Plastic pots, tubs and trays', 'Fruit and vegetable punnets', 'Clean takeaway containers', 'Cleaning product bottles', 'Drinks cans (empty and rinsed)', 'Food/pet food tins (empty and rinsed)', 'Biscuit/sweet tins', 'Aerosols', 'Glass bottles and jars', 'Cartons', 'Milk cartons'];
$green_bad = ['Paper, card and cardboard', 'Food residue', 'Carrier bags', 'Sweet and crisp wrappers', 'Plastic wrapping and bubble wrap', 'Polystyrene Food and drink pouches', 'Hard plastics (toys, coat hangers, CD case etc)', 'Food and drink pouches', 'Light bulbs', 'Pyrex or crockery', 'Mirrors', 'Tinfoil'];

$brown_good = ['Grass cuttings', 'Flowers and plants', 'Weeds', 'Leaves', 'Small branches and twigs', 'Cooked and uncooked food', 'Leftovers', 'Fruit and vegetable peelings', 'Tea bags and coffee grounds', 'Egg shells', 'Out of date food (remove packaging)', 'Bread, pasta and cakes', 'Meat, fish and small bones'];
$brown_bad = ['Plastic bags', 'Packaging', 'Liquids', 'Fats and oils', 'Rubble and soil', 'Plant pots', 'Wood and fencing', 'Garden furniture', 'Plastics, cans and glass', 'Paper, card and cardboard'];



for ($x = 0; $x <= 3; $x++) {

    ${$current_bin[$x].'_modal'}='
                            <div class="container">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <h5>These items can go in your '.$current_bin[$x].' bin:</h5>
                                        <ul class="fa-ul">
                                        ';
        foreach (${$current_bin[$x].'_good'} as $good_item) {
            ${$current_bin[$x].'_modal'}.='
                                            <li>'.$good_li.' '.$good_item.'</li>
                                            ';
        }

    ${$current_bin[$x].'_modal'}.='
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <h5>Do not put these items in your '.$current_bin[$x].' bin:</h5>
                                        <ul class="fa-ul">
                                        ';
        foreach (${$current_bin[$x].'_bad'} as $bad_item) {
            ${$current_bin[$x].'_modal'}.='
                                            <li>'.$bad_li.' '.$bad_item.'</li>
            ';
        }

    ${$current_bin[$x].'_modal'}.='
                                        </ul>
                                    </div>
                                </div>
                            </div>
        ';

}







//class
class Bin{
    //Properties
    public $dates;
    public $colour;
    public $start_date;
    public $end_date;
    public $next_date;
    public $next_date_plus;
    public $already_posted;
    //Default end_date and already_posted
    public function __construct()
    {
        $this->already_posted="false";
    }
    //Methods
    function setEndDate($end_date){
        $this->end_date = $end_date;
    }
    function getEndDate(){
        return $this->end_date;
    }
    function setStartDate($start_date){
        $this->start_date = $start_date;
    }
    function getStartDate(){
        return $this->start_date;
    }
    function addDates($dates){
        $this->dates = $dates;
    }
    function getDates(){
        return $this->dates;
    }
    function setColour($colour){
        $this->colour = $colour;
    }
    function getColour(){
        return $this->colour;
    }
    function setNextDate($next_date){
        $this->next_date = $next_date;
    }
    function getNextDate(){
        return $this->next_date;
    }
    function setNextDatePlus($next_date_plus){
        $this->next_date_plus = $next_date_plus;
    }
    function getNextDatePlus(){
        return $this->next_date_plus;
    }
    function setAlreadyPosted($already_posted){
        $this->already_posted = $already_posted;
    }
    function getAlreadyPosted(){
        return $this->already_posted;
    }
}


$grey = new Bin();
$grey->setStartDate($greyStartDate);
$grey->setEndDate($greyEndDate);
$grey->setColour($greyColour);

$blue = new Bin();
$blue->setStartDate($blueStartDate);
$blue->setEndDate($blueEndDate);
$blue->setColour($blueColour);

$green = new Bin();
$green->setStartDate($greenStartDate);
$green->setEndDate($greenEndDate);
$green->setColour($greenColour);

$brown = new Bin();
$brown->setStartDate($brownStartDate);
$brown->setEndDate($brownEndDate);
$brown->setColour($brownColour);

//function for generating dates - used for CSV file and ICS calendar file
function generateDates($schedule_code, $weeks_added, $start_date, $end_date, $festive_deduction){
    $bin_dates=array(
        array('grey',$start_date[0]), 
        array('blue',$start_date[1]), 
        array('green',$start_date[2]), 
        array('brown',$start_date[3])
    );
    for($i=0;$i<=3;$i++){
        $incremented_date = $start_date[$i];
        $end_the_loop = 0;
        while($end_the_loop == 0){
            $incremented_date = strtotime($incremented_date.' + '.$weeks_added[$i].' weeks');
            if($incremented_date <= strtotime($end_date)){
                $incremented_date = date("Y-m-d", $incremented_date);
                if(substr($incremented_date,-5) == "12-25" || substr($incremented_date,-5) == "01-01"){
                    $festive_date = strtotime($incremented_date.' - '.$festive_deduction.' days');
                    $festive_date = date("Y-m-d", $festive_date);
                    array_push($bin_dates[$i], $festive_date);
                }else{
                    array_push($bin_dates[$i], $incremented_date);
                }
            }else{
                $end_the_loop = 1;
            }
        }
    }
    
    return $bin_dates; 

}



                
$filename = __ROOT__.'/'.$folder_name.'/generated-bin-dates.csv';


                


///THIS CODE TO GENERATE CSV DATES, CHECK CONFIG.PHP


if ($generate_dates == 1){
    require_once(__ROOT__.'/bins-main/generate-webapp-dates.php');
}


//THE END OF CSV GENERATOR

$filenameICS = $folder_name.".ics"; 

//THE SECOND OCCASIONAL CODE FOR GENERATING ICS

if ($generate_ics_dates == 1){
    require_once(__ROOT__.'/bins-main/generate-ics-dates.php');
}

//END OF THE SECOND OCCASIONAL CODE FOR GENERATING ICS


//open generated dates in csv file

$file = fopen($filename,"r");
$bin_dates=array_map('str_getcsv', file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
fclose($file);



//assign bin dates to an appropriate object

for($i=0;$i<=3;$i++){
    ${$current_bin[$i]}->addDates($bin_dates[$i]);
}


//set today and tomorrow variables

$today = time();
$today = date("Y-m-d", $today);
$tomorrow = date("Y-m-d",strtotime("+1 days"));


//set next date and next date plus - two closest future dates

for($x = 0; $x <= 3; $x++)
{
    for( $i = 1; $i < count(${$current_bin[$x]}->getDates())-1; $i++ )
    {
        $current_date_to_compare = strtotime(${$current_bin[$x]}->getDates()[$i]);

        if($current_date_to_compare >= strtotime($today))
        {
            $next_one = ${$current_bin[$x]}->getDates()[$i];
            $next_one_plus = ${$current_bin[$x]}->getDates()[$i+1];
            ${$current_bin[$x]}->setNextDate($next_one);
            ${$current_bin[$x]}->setNextDatePlus($next_one_plus);
            break;
        }
    }
}





?>

<?php 

require_once(__ROOT__.'/bins-main/html-head.php');

?>

<body>
<div id ="content" class="container-lg pb-5" style="padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);">
        <h1 class="pt-5"><span class="bolder">Bin collection days</span> <span class="thinner">- <?php echo $location_name; ?></span></h1>
    
<div id="tabs" class="pt-3">
  <ul class="sticky">
    <li><a href="#tabs-1"><i class="fas fa-sort-amount-down"></i> Coming up</a></li>
    <li><a href="#tabs-2"><i class="far fa-calendar-alt"></i> Calendar</a></li>
  </ul>
  <div id="tabs-1">

    

    
    

<?php

//API for the weather
$weather_file = "../bins-main/brookfield-weather.json";
include_once "unversioned-a.php";

function weatherAPI($weather_file, $api_location, $api_key) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.tomorrow.io/v4/timelines?location='.$api_location.'&fields=temperature,temperatureApparent,precipitationProbability,precipitationIntensity,precipitationType,weatherCodeDay,windSpeed&timesteps=1d&units=metric&apikey='.$api_key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));


    //file_put_contents($weather_file, $curl);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response);

    if(isset($data->data->timelines[0]->intervals)){
        file_put_contents($weather_file, $response);
        return 0;
    }
    



    return 1;

}

$log_mode = '-w.cached';

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




    //close API






    
//sorting function
      
        function compareByTimeStamp($time1, $time2)
        {
            if (strtotime($time1) > strtotime($time2))
                return 1;
            else if (strtotime($time1) < strtotime($time2))
                return -1;
            else
                return 0;
        }

//assigning two future dates from each bin to a numbered date

        for($x=0; $x<=3; $x++){
            $y=$x+1;
            ${'date'.$y} = ${$current_bin[$x]}->getNextDate();
            $z=$x+5;
            ${'date'.$z} = ${$current_bin[$x]}->getNextDatePlus();
        }



      
        $arr = array($date1, $date2, $date3, $date4, $date5, $date6, $date7, $date8);
        usort($arr, "compareByTimeStamp"); 

      
//end sorting
      
      
      

//preparing bin displays
      
for($x=0; $x<=3; $x++){
    
    ${$current_bin[$x].'_image'}='
    <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#'.$current_bin[$x].'-modal">
    <figure class="figure float-end">
        <img src="../bins-main/img/'.$current_bin[$x].'.png" class="bin figure-img img-fluid" alt="'.$current_bin[$x].'">
        <figcaption class="bin figure-caption text-center '.$current_bin[$x].'"><i class="fa-solid fa-trash"></i> &nbsp;'.strtoupper($current_bin[$x]).'</figcaption>
    </figure>
    </a>';
    
}
      


$precipitation_type = ['rain', 'rain', 'snow', 'freezing rain', 'sleet'];


function weatherDisplay($data, $date, $precipitation_type){

    

    for($i = 0; $i<count($data->data->timelines[0]->intervals); $i++){

        if(substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10) == $date){
            echo  '<a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#weather-modal">
            <div class="badge bg-secondary text-wrap align-bottom">
                        <img src="../bins-main/img/'.$data->data->timelines[0]->intervals[$i]->values->weatherCodeDay.'.png" />
                        <br /><span class="fs-4">' . floor($data->data->timelines[0]->intervals[$i]->values->temperature) . 
            '           &#8451;</span><br /><br />';

            if( $data->data->timelines[0]->intervals[$i]->values->precipitationType != 0 ){
                        echo '<p>Chance of ' . $precipitation_type[ $data->data->timelines[0]->intervals[$i]->values->precipitationType ] . ': ' . $data->data->timelines[0]->intervals[$i]->values->precipitationProbability . '%</p>';
            }else{
                        echo '<p>0% chance of rain</p>';
            }

            echo '<p>Wind speed: ' . $data->data->timelines[0]->intervals[$i]->values->windSpeed . 'mph</p>';

            echo '  
            

                    </div></a>';    
        }

    }  
}

$var_good = 0;
//NEW WAY
echo '<div class="row">
        <h2>
            Your next collection:
        </h2>
      </div>';
echo '<div class="row pl0">'; 
echo '  <div class="col">
        <h4>' . date("l", strtotime($arr[0])) . ', <br/>
            <span id="thedate0">' . $arr[0] . '</span>
        </h4>';

        if(isset($data->data->timelines[0]->intervals)){
            weatherDisplay($data, $arr[0], $precipitation_type);
            $var_good = 1;
        }    
      
      
echo  '</div>';

//setting up binN and binN_date variables
for ($i=1; $i<=8; $i++){
    ${'bin' . $i} = 0;
    ${'bin' . $i . '_date'} = 0;
}



for ($i = 0; $i <= 3; $i++) {
    $current_bin_date=${$current_bin[$i]}->getNextDate();
    if ($arr[0] == $current_bin_date) {
        echo '<div class="col col-md-auto">'.${$current_bin[$i].'_image'}.'</div>';
        if ( $bin1 === 0 ) {
            $bin1 = $current_bin[$i];
            $bin1_date = $current_bin_date;

            $bins_array = array($current_bin_date => $current_bin[$i]);

        } else {
            $bin2 = $current_bin[$i];
            $bin2_date = $current_bin_date;

            $bins_array[$current_bin_date] = $bins_array[$current_bin_date] . ', ' . $current_bin[$i];
        }
    }
}




echo '</div>';
if ($bin2 === 0) {
    echo '<div class="alert alert-secondary" role="alert">
    Please put your <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#'.$bin1.'-modal"><strong class="'.$bin1.'"><i class="fa-solid fa-trash"></i> '.$bin1.'</strong></a> bin out for collection before 7.00<sup>am</sup>. Collection can take place until 6.30<sup>pm</sup>.
    </div><hr />';
} else {
    echo '<div class="alert alert-secondary" role="alert">
    Please put your <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#'.$bin1.'-modal"><strong class="'.$bin1.'"><i class="fa-solid fa-trash"></i> '.$bin1.'</strong></a> and <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#'.$bin2.'-modal"><strong class="'.$bin2.'"><i class="fa-solid fa-trash"></i> '.$bin2.'</strong></a> bin out for collection before 7.00<sup>am</sup>. Collections can take place until 6.30<sup>pm</sup>.
    </div><hr />';
}

echo '<br /><div class="row"><h2>Your futures collections:</h2></div>';


for ($g = 1; $g <= 3; $g++)
{
    $next_week = $arr[$g];

    if ($next_week == $arr[$g-1])
    {
        $next_week = $arr[$g+1];
        array_splice($arr, $g, 1);
    }


    echo '<div class="row pl1">'; 
    echo '<div class="col">
        <h4>' . date("l", strtotime($next_week)) . ', <br/>
        <span id="thedate'.$g.'">' . $next_week . '</span>
        </h4>';
            if( $var_good == 1){
                weatherDisplay($data, $arr[$g], $precipitation_type);
            }    
        
    echo '</div>';

    for($i = 0; $i <= 3; $i++) 
    {
        $current_bin_date=${$current_bin[$i]}->getNextDate();
        $current_bin_date_plus=${$current_bin[$i]}->getNextDatePlus();
        $add_one = 0;
        if($next_week == $current_bin_date)
        {
            echo '<div class="col col-md-auto">'.${$current_bin[$i].'_image'}.'</div>';

            if( !isset($bins_array[$current_bin_date]) ){
                $bins_array += [ $current_bin_date => $current_bin[$i] ];
            } else {
                $bins_array[$current_bin_date] = $bins_array[$current_bin_date] . ', ' . $current_bin[$i];
            }

            

        }elseif($next_week == $current_bin_date_plus)
        {
            echo '<div class="col col-md-auto">'.${$current_bin[$i].'_image'}.'</div>';

            if( !isset($bins_array[$current_bin_date_plus]) ){
                $bins_array += [ $current_bin_date_plus => $current_bin[$i] ];
            } else {
                $bins_array[$current_bin_date_plus] = $bins_array[$current_bin_date_plus] . ', ' . $current_bin[$i];
            }

        }
    }
    echo '</div><hr />';
}

//NEW WAY END


        
      

    
        ?>
        

  </div>     
          <div id="tabs-2">
          <div id="calendar"></div>
  </div>

<div class="d-flex justify-content-between">
    <button id="dark" class="btn btn-outline-light btn-sm active" onclick="toggleTheme('dark');"><i class="fa-solid fa-toggle-off"></i>
 Dark mode </button>
    <button id="light" class="btn btn-outline-light btn-sm active" onclick="toggleTheme('light');"><i class="fa-solid fa-toggle-on"></i> Dark mode </button>

    <a href="<?php echo $folder_name ?>.ics" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="true" style="color: #fff"><i class="fas fa-calendar-alt"></i> Phone calendar</a>
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
        <h1 class="display-4 fw-bold lh-1"><i class="fa-solid fa-gift"></i> Get <strong>£50</strong> for switching to Octopus Energy</h1>
        <p class="lead">With energy prices going up so quickly, save some money by switching to Octopus Energy.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
          <a href="https://share.octopus.energy/tan-loris-643" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold"><i class="fa-solid fa-gift"></i> Get £50</a>
          <button type="button" class="btn btn-outline-secondary btn-sm px-4" onclick="dismiss();"><i class="fa-solid fa-heart-crack"></i> Dismiss</button>
        </div>
      </div>
      <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
          <img class="rounded-lg-3" src="../bins-main/img/octopus.png" alt="" width="720">
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

//preparing modal displays

$brown_extra = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brown-modal-extra">How to use the brown bin?</button>';




      
for ($x=0; $x<=3; $x++) {


    echo 
    '<div class="modal fade" id="'.$current_bin[$x].'-modal" style="z-index: 99969">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title '.$current_bin[$x].'">What goes in the '.$current_bin[$x].' bin?</h4>
                    <button type="button" class="btn-close '.$current_bin[$x].'" data-bs-dismiss="modal"></button>
                </div>


                <div class="modal-body">
                    '.${$current_bin[$x].'_modal'}.'
                </div>


                <div class="modal-footer">
                    '.${$current_bin[$x].'_extra'} = isset(${$current_bin[$x].'_extra'}) ? ${$current_bin[$x].'_extra'} : ' ';

    echo '
                    <button type="button" class="btn btn-outline-secondary '.$current_bin[$x].'" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>';
    
}
?>
    




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


<div class="modal fade" id="weather-modal" style="z-index: 99969">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Weather forecast for <?php echo $location_name; ?></h4>
                <button type="button" class="btn-close brown" data-bs-dismiss="modal"></button>
            </div>


        <div class="modal-body">
            <div class="container">
                <div class="table-responsive">
                    <table class="table caption-top">
                    <tbody>
                        <tr>
<?php
$day_weather = [];
for($i = 0; $i<count($data->data->timelines[0]->intervals); $i++)
{
?>
                        <td>
<?php 
echo '<div class="alert alert-light text-wrap" style="width: 8rem;">';

$date_to_change = substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10);
$formatted_date = date("l", strtotime($date_to_change));  
echo $formatted_date.'<br />';
$formatted_date = date("M, jS", strtotime($date_to_change));  
echo $formatted_date;





echo '<br /><div style="height: 4rem"><img src="../bins-main/img/large/'.$data->data->timelines[0]->intervals[$i]->values->weatherCodeDay.'.png" /></div>
                        <br /><span class="fs-4">' . $data->data->timelines[0]->intervals[$i]->values->temperature . 
            '           &#8451;</span>';

            if( $data->data->timelines[0]->intervals[$i]->values->precipitationType != 0 ){
                        echo '<br />Chance of ' . $precipitation_type[ $data->data->timelines[0]->intervals[$i]->values->precipitationType ] . ': ' . $data->data->timelines[0]->intervals[$i]->values->precipitationProbability . '%';
            }else{
                        echo '<br />0% chance of rain';
            }

            echo '<br />Wind speed: ' . $data->data->timelines[0]->intervals[$i]->values->windSpeed . 'mph';

            echo '</div>';
            
            if( isset($bins_array[$date_to_change]) ){
                $exploded = explode(', ', $bins_array[$date_to_change]);

                echo '<p class="text-center text-uppercase fw-bold ' . $exploded[0] . '"><i class="fa-solid fa-trash"></i> ' . $exploded[0] . '</p>';

                if ( isset($exploded[1]) ){
                    echo '<p class="text-center text-uppercase fw-bold ' . $exploded[1] . '"><i class="fa-solid fa-trash"></i> ' . $exploded[1] . '</p>';
                }
            }
}
?>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
        



        
<script>

// Capture the current theme from local storage and adjust the page to use the current theme.
const htmlEl = document.getElementsByTagName('html')[0];
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
const dismisser = localStorage.getItem('dismiss') ? localStorage.getItem('dismiss') : null;

if (currentTheme) {
    htmlEl.dataset.theme = currentTheme;
    $('#'+currentTheme).addClass('d-none');
}else{
    $('#light').addClass('d-none');
}

// When the user changes the theme, we need to save the new value on local storage
const toggleTheme = (theme) => {
    htmlEl.dataset.theme = theme;
    localStorage.setItem('theme', theme);
    $('#'+theme).addClass('d-none');
    if (theme=='dark'){
        $('#light').removeClass('d-none');
        }else{
        $('#dark').removeClass('d-none');    
        }
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
          firstDay: 1,
        aspectRatio: 0.9,
         themeSystem: 'bootstrap5',
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
                for($x=0; $x<=3; $x++){
                            foreach(${$current_bin[$x]}->getDates() as $datey){
                                if(is_numeric(substr($datey,-1))){
                                            echo "{
                                            start: '".$datey."',
                                            end: '".$datey."',
                                            title: '".$current_bin[$x]."',
                                            display: 'block',
                                            color: '".${$current_bin[$x]}->getColour()."'

                                    },";  
                                }
                            }
                }

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
  }else if(tomorrow === date2){
      document.getElementById("thedate"+i).textContent='tomorrow';
  }else if(yesterday === date2){
      document.getElementById("thedate"+i).textContent='yesterday';
  }else{
      document.getElementById("thedate"+i).textContent=formatted_date;
  }
    
}



    </script>




<?php
    include_once "unversioned-b.php";
?>

</body>

</html>
    


