<?php

//class
class Bin{
    //Properties
    public $dates;
    public $colour;
    public $start_date;
    public $end_date;
    public $next_date;
    public $next_date_plus;
    //Default end_date and already_posted
    public function __construct()
    {
        $this->next_date;
        $this->next_date_plus;
        $this->dates;
        $this->colour;
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
    function setNextDate($next_date){
        $this->next_date = $next_date;
    }
    function setNextDatePlus($next_date_plus){
        $this->next_date_plus = $next_date_plus;
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


$weatherCodeDay = array(
      "0"=>"Weather Unknown",
      "10000"=>"Clear, Sunny",
      "11000"=>"Mostly Clear",
      "11010"=>"Partly Cloudy",
      "11020"=>"Mostly Cloudy",
      "10010"=>"Cloudy",
      "11030"=>"Partly Cloudy and Mostly Clear",
      "21000"=>"Light Fog",
      "21010"=>"Mostly Clear and Light Fog",
      "21020"=>"Partly Cloudy and Light Fog",
      "21030"=>"Mostly Cloudy and Light Fog",
      "21060"=>"Mostly Clear and Fog",
      "21070"=>"Partly Cloudy and Fog",
      "21080"=>"Mostly Cloudy and Fog",
      "20000"=>"Fog",
      "42040"=>"Partly Cloudy and Drizzle",
      "42030"=>"Mostly Clear and Drizzle",
      "42050"=>"Mostly Cloudy and Drizzle",
      "40000"=>"Drizzle",
      "42000"=>"Light Rain",
      "42130"=>"Mostly Clear and Light Rain",
      "42140"=>"Partly Cloudy and Light Rain",
      "42150"=>"Mostly Cloudy and Light Rain",
      "42090"=>"Mostly Clear and Rain",
      "42080"=>"Partly Cloudy and Rain",
      "42100"=>"Mostly Cloudy and Rain",
      "40010"=>"Rain",
      "42110"=>"Mostly Clear and Heavy Rain",
      "42020"=>"Partly Cloudy and Heavy Rain",
      "42120"=>"Mostly Cloudy and Heavy Rain",
      "42010"=>"Heavy Rain",
      "51150"=>"Mostly Clear and Flurries",
      "51160"=>"Partly Cloudy and Flurries",
      "51170"=>"Mostly Cloudy and Flurries",
      "50010"=>"Flurries",
      "51000"=>"Light Snow",
      "51020"=>"Mostly Clear and Light Snow",
      "51030"=>"Partly Cloudy and Light Snow",
      "51040"=>"Mostly Cloudy and Light Snow",
      "51220"=>"Drizzle and Light Snow",
      "51050"=>"Mostly Clear and Snow",
      "51060"=>"Partly Cloudy and Snow",
      "51070"=>"Mostly Cloudy and Snow",
      "50000"=>"Snow",
      "51010"=>"Heavy Snow",
      "51190"=>"Mostly Clear and Heavy Snow",
      "51200"=>"Partly Cloudy and Heavy Snow",
      "51210"=>"Mostly Cloudy and Heavy Snow",
      "51100"=>"Drizzle and Snow",
      "51080"=>"Rain and Snow",
      "51140"=>"Snow and Freezing Rain",
      "51120"=>"Snow and Ice Pellets",
      "60000"=>"Freezing Drizzle",
      "60030"=>"Mostly Clear and Freezing drizzle",
      "60020"=>"Partly Cloudy and Freezing drizzle",
      "60040"=>"Mostly Cloudy and Freezing drizzle",
      "62040"=>"Drizzle and Freezing Drizzle",
      "62060"=>"Light Rain and Freezing Drizzle",
      "62050"=>"Mostly Clear and Light Freezing Rain",
      "62030"=>"Partly Cloudy and Light Freezing Rain",
      "62090"=>"Mostly Cloudy and Light Freezing Rain",
      "62000"=>"Light Freezing Rain",
      "62130"=>"Mostly Clear and Freezing Rain",
      "62140"=>"Partly Cloudy and Freezing Rain",
      "62150"=>"Mostly Cloudy and Freezing Rain",
      "60010"=>"Freezing Rain",
      "62120"=>"Drizzle and Freezing Rain",
      "62200"=>"Light Rain and Freezing Rain",
      "62220"=>"Rain and Freezing Rain",
      "62070"=>"Mostly Clear and Heavy Freezing Rain",
      "62020"=>"Partly Cloudy and Heavy Freezing Rain",
      "62080"=>"Mostly Cloudy and Heavy Freezing Rain",
      "62010"=>"Heavy Freezing Rain",
      "71100"=>"Mostly Clear and Light Ice Pellets",
      "71110"=>"Partly Cloudy and Light Ice Pellets",
      "71120"=>"Mostly Cloudy and Light Ice Pellets",
      "71020"=>"Light Ice Pellets",
      "71080"=>"Mostly Clear and Ice Pellets",
      "71070"=>"Partly Cloudy and Ice Pellets",
      "71090"=>"Mostly Cloudy and Ice Pellets",
      "70000"=>"Ice Pellets",
      "71050"=>"Drizzle and Ice Pellets",
      "71060"=>"Freezing Rain and Ice Pellets",
      "71150"=>"Light Rain and Ice Pellets",
      "71170"=>"Rain and Ice Pellets",
      "71030"=>"Freezing Rain and Heavy Ice Pellets",
      "71130"=>"Mostly Clear and Heavy Ice Pellets",
      "71140"=>"Partly Cloudy and Heavy Ice Pellets",
      "71160"=>"Mostly Cloudy and Heavy Ice Pellets",
      "71010"=>"Heavy Ice Pellets",
      "80010"=>"Mostly Clear and Thunderstorm",
      "80030"=>"Partly Cloudy and Thunderstorm",
      "80020"=>"Mostly Cloudy and Thunderstorm",
      "80000"=>"Thunderstorm"
);


//FUNCTIONS

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

    //VIEW RENDER function

    function renderView($render_cache_file, $current_bin, Bin $grey, Bin $blue, Bin $green, Bin $brown, $precipitation_type, $data){
    

        $post_weather_modal = $post_js_events = "";


        //assigning two future dates from each bin to a numbered date
        for($x=0; $x<=3; $x++) {
            $y=$x+1;
            ${'date'.$y} = ${$current_bin[$x]}->next_date;
            $z=$x+5;
            ${'date'.$z} = ${$current_bin[$x]}->next_date_plus;
        }

        $arr = array($date1, $date2, $date3, $date4, $date5, $date6, $date7, $date8);
        usort($arr, "compareByTimeStamp"); 

        $bins_array =  [];

        for($i = 0; $i <= 7; $i++) {

            if(count($bins_array) < 4) {
                for($x=0; $x<=3; $x++) {
                    if($arr[$i] == ${$current_bin[$x]}->next_date || $arr[$i] == ${$current_bin[$x]}->next_date_plus) {
                        if(!isset($bins_array[$arr[$i]])  ) {
                            $bins_array[$arr[$i]] = $current_bin[$x];
                        } elseif(strpos($bins_array[$arr[$i]], $current_bin[$x])===false) {
                            $bins_array[$arr[$i]] = $bins_array[$arr[$i]] . ', ' . $current_bin[$x];
                        }   
                    }
                }
            } 
        }



        for($x=0; $x<=3; $x++) {
            foreach(${$current_bin[$x]}->dates as $datey) {
                if(is_numeric(substr($datey,-1))){
                            $post_js_events .= "{
                            start: '".$datey."',
                            end: '".$datey."',
                            title: '".$current_bin[$x]."',
                            display: 'block',
                            color: '".${$current_bin[$x]}->colour."'

                    },";  
                }
            }
        }

        $bins_array_str = var_export($bins_array, true);
        $post_js_events_str = var_export($post_js_events, true);
        $arr_str = var_export($arr, true);
        $var = "<?php\n\n\$bins_array = $bins_array_str;\n\$arr = $arr_str;\n\$post_js_events = $post_js_events_str;\n\n?>";
        file_put_contents($render_cache_file, $var);

        return 0;
        
    }

    //function for the weather API

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


    //weather function
    function weatherDisplay($data, $date, $precipitation_type, $weatherCodeDay, $offline) {
        $result = "no data";
        for($i = 0; $i<count($data->data->timelines[0]->intervals); $i++){

            if(substr($data->data->timelines[0]->intervals[$i]->startTime, 0, 10) == $date){
                echo '<a href="#" onclick="weatherModalOpened();" data-bs-toggle="modal" data-bs-target="#weather-modal">
                <div class="badge bg-secondary text-wrap align-bottom">';
                if ($offline != 1){
                    echo '<img src="https://bins.b-cdn.net/bins-main/img/'.$data->data->timelines[0]->intervals[$i]->values->weatherCodeDay.'.png" style="margin-bottom: 5px; margin-top: -10px" />';
                }
                echo '<br /><span class="weatherinfo">'.$weatherCodeDay[$data->data->timelines[0]->intervals[$i]->values->weatherCodeDay].'</span>
                            <br /><br /><span class="fs-4">' . trim(floor($data->data->timelines[0]->intervals[$i]->values->temperature)) . 
                '&#8451;</span><br /><br />';

                if( $data->data->timelines[0]->intervals[$i]->values->precipitationType != 0 ){
                            echo '<p><span class="icon-rainy"></span> Chance of ' . $precipitation_type[ $data->data->timelines[0]->intervals[$i]->values->precipitationType ] . ': ' . $data->data->timelines[0]->intervals[$i]->values->precipitationProbability . '%</p>';
                }else{
                            echo '<p><span class="icon-rainy"></span> 0% chance of rain</p>';
                }

                echo '<p><span class="icon-wind"></span> Wind speed: ' . $data->data->timelines[0]->intervals[$i]->values->windSpeed . 'mph</p>';

                echo '  
                

                        </div></a>'; 
                $result = 1;
                        break;   
            }

        }
        return $result;  
    }

    function displayBinModals($current_bin){

        $good_li = '<span class="fa-li green"><span class="icon-goodli"></span></span>';
        $bad_li = '<span class="icon-badli text-danger"></span>';

        $grey_good = ['Non-recyclable waste', 'Plastic bags and polythene', 'Polystyrene', 'Crisp and sweet wrappers', 'Used tissues and paper towels', 'Cling film', 'Tinfoil', 'Lightbulbs', 'Pet litter', 'Nappies', 'Personal hygiene products', 'Food and drinks pouches', 'Hard plastics (toys, coat hangers, CD cases etc.)', 'Padded envelopes', 'Shredded paper'];
        $grey_bad = ['Plastics, cans and glass', 'Paper, card and cardboard', 'Food waste', 'Garden waste', 'Electrical items', 'Textiles and shoes'];

        $blue_good = ['Cardboard (flattened)', 'Cereal boxes', 'Large brown cardboard boxes', 'Corrugated cardboard', 'Toilet and kitchen roll tubes', 'Cardboard packaging', 'Paper (clean and dry)', 'Envelopes (with and without windows)', 'Magazines', 'Newspapers', 'Office paper', 'Telephone directories', 'Paperback books', 'Catalogues', 'Junk mail and takeaway menus'];
        $blue_bad = ['Glass', 'Plastics and cans', 'Hardback books', 'Plastic carrier bags', 'Padded envelopes', 'Plastic wrapping and bubble wrap', 'Polystyrene', 'Packaging with food residue', 'Used tissues and kitchen roll', 'Foil wrapping paper', 'Tinfoil', 'Shredded paper'];

        $green_good = ['Plastic bottles', 'Plastic pots, tubs and trays', 'Fruit and vegetable punnets', 'Clean takeaway containers', 'Cleaning product bottles', 'Drinks cans (empty and rinsed)', 'Food/pet food tins (empty and rinsed)', 'Biscuit/sweet tins', 'Aerosols', 'Glass bottles and jars', 'Cartons', 'Milk cartons'];
        $green_bad = ['Paper, card and cardboard', 'Food residue', 'Carrier bags', 'Sweet and crisp wrappers', 'Plastic wrapping and bubble wrap', 'Polystyrene Food and drink pouches', 'Hard plastics (toys, coat hangers, CD case etc)', 'Food and drink pouches', 'Light bulbs', 'Pyrex or crockery', 'Mirrors', 'Tinfoil'];

        $brown_good = ['Grass cuttings', 'Flowers and plants', 'Weeds', 'Leaves', 'Small branches and twigs', 'Cooked and uncooked food', 'Leftovers', 'Fruit and vegetable peelings', 'Tea bags and coffee grounds', 'Egg shells', 'Out of date food (remove packaging)', 'Bread, pasta and cakes', 'Meat, fish and small bones'];
        $brown_bad = ['Plastic bags', 'Packaging', 'Liquids', 'Fats and oils', 'Rubble and soil', 'Plant pots', 'Wood and fencing', 'Garden furniture', 'Plastics, cans and glass', 'Paper, card and cardboard'];

        $brown_extra = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brown-modal-extra">How to use the brown bin?</button>';


        //generating modals
        for ($x = 0; $x <= 3; $x++) {

            ${$current_bin[$x].'_modal'}='
                                    <div class="container">
                                        <div class="row align-items-start">
                                            <div class="col">
                                                <h5>These items can go in your '.$current_bin[$x].' bin:</h5>
                                                <ul style="list-style: none;">
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
                                                <ul style="list-style: none;">
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

    return 1;

    }

//END FUNCTIONS


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