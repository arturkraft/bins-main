<?php

if( empty( $bins_main ) ) die("Cannot access this page directly");


//checking code's efficiency

//ini_set('display_errors','On');
//error_reporting(E_ALL);

$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");

        $time = microtime(TRUE);
        $mem = memory_get_usage();

$current_bin = ['grey', 'blue', 'green', 'brown'];




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

                
$filename = "generated-bin-dates.csv";
                


///THIS CODE TO BE RUN OCCASIONALLY

//require_once(__ROOT__.'../bins-main/generate-webapp-dates.php');

if ($generate_dates == 1){
    require_once(__ROOT__.'/generate-webapp-dates.php');
}


//THE END OF THE OCCASIONAL CODE



//THE SECOND OCCASIONAL CODE FOR GENERATING ICS

// $filenameICS = "weirs_wynd_bins.ics"; 

// $grey->setEndDate('2022-12-15');
// $blue->setEndDate('2022-12-15');
// $green->setEndDate('2022-12-15');
// $brown->setEndDate('2022-12-15');

// $bin_dates=generateDates('2132','3442',[$grey->getStartDate(),$blue->getStartDate(),$green->getStartDate(),$brown->getStartDate()],$grey->getEndDate(),2); 

// $fileICS = fopen($filenameICS,"w");

// $start_ics = "BEGIN:VCALENDAR
// VERSION:2.0
// METHOD:PUBLISH
// PRODID:-//weirswynd/arturkraft//EN
// CALSCALE:GREGORIAN";

// $end_ics='
// BEGIN:VEVENT
// DTEND;VALUE=DATE:20221217
// DTSTART;VALUE=DATE:20221212
// LOCATION:Weirs Wynd
// DESCRIPTION:DOWNLOAD A NEW BIN CALENDAR FROM www.artur.kr/weirswynd
// URL;VALUE=URI:https://artur.kr/weirswynd/
// SUMMARY:UPDATE BIN CALENDAR
// UID:'.md5('new').'
// SEQUENCE:0
// DTSTAMP:20220127T162901Z
// END:VEVENT
// END:VCALENDAR';

// $write_ics = $start_ics;

// foreach ($bin_dates as $line) {

//     for ($n=1;$n<=count($line);$n++){
//         $next_day_date = date('Y-m-d', strtotime($line[$n] . ' +1 day'));
//         $write_ics .= 
//         '
// BEGIN:VEVENT
// DTEND;VALUE=DATE:'.str_replace("-", "", $next_day_date).
// '
// DTSTART;VALUE=DATE:'.str_replace("-", "", $line[$n]).'
// LOCATION:Weirs Wynd
// DESCRIPTION:'.strtoupper($line[0]).' BIN COLLECTION
// SUMMARY:'.strtoupper($line[0]).' BIN
// UID:'.md5($line[$n].$line[0]).$line[$n].'
// SEQUENCE:0
// DTSTAMP:20220127T162901Z
// END:VEVENT';

//     }

// }

// $write_ics .= $end_ics;

// fwrite($fileICS, $write_ics);

// fclose($fileICS);


//END OF THE SECOND OCCASIONAL CODE FOR GENERATING ICS


$file = fopen($filename,"r");
$bin_dates=array_map('str_getcsv', file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
fclose($file);





for($i=0;$i<=3;$i++){
    ${$current_bin[$i]}->addDates($bin_dates[$i]);
}




$today = time();
$today = date("Y-m-d", $today);
$tomorrow = date("Y-m-d",strtotime("+1 days"));

for($x=0; $x<=3; $x++){
    for($i=1;$i<count(${$current_bin[$x]}->getDates())-1;$i++){
        $current_date_to_compare=strtotime(${$current_bin[$x]}->getDates()[$i]);
        if($current_date_to_compare>=strtotime($today)){
            $next_one = ${$current_bin[$x]}->getDates()[$i];
            $next_one_plus = ${$current_bin[$x]}->getDates()[$i+1];
            ${$current_bin[$x]}->setNextDate($next_one);
            ${$current_bin[$x]}->setNextDatePlus($next_one_plus);
            break;
        }
    }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bins collection day - <?php echo $locationName; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=b">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=b">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=b">
    <link rel="manifest" href="/site.webmanifest?v=b">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=b" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=b">
    <meta name="apple-mobile-web-app-title" content="<?php echo $locationName; ?> Bins">
    <meta name="application-name" content="<?php echo $locationName; ?> Bins">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300;700&family=Raleway:wght@200&family=Zen+Loop&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.js"></script>
<style>
    
:root {
  --background-primary: #fff;
  --color-primary: #333;
}

html[data-theme='dark'] {
  --background-primary: #6f6f6f;
  --color-primary: #333;
}

html {
  transition: color 300ms, background-color 300ms;
  background: var(--background-primary);
  color: var(--color-primary);
}

h1, h2, h3, h4, p {
  color: var(--color-primary);

}
    h1{
    font-family: 'Open Sans Condensed', sans-serif;
    }
    h2{
    font-family: 'Raleway', sans-serif;
    }
    .bolder{
        font-weight:700;
    }
    .thinner{
        font-weight: 300;
    }
    html {
    transition: color 300ms, background-color 300ms;
}

html[data-theme='dark'] {
    background: #000;
    transition: color 300ms, background-color 300ms;
    filter: invert(1) hue-rotate(180deg);
    height: 100%;
    margin: 0;
    padding: 0;
}

html[data-theme='dark'] img {
  filter: invert(1) hue-rotate(180deg)
}
    
html, body {
    min-height: 100%;
    }
body{
    background-size: cover;
    }
    .fc-daygrid-day-number{
        text-decoration: none !important;
    }
.c-event-main{
    height: 50px;
}
    
.fc .fc-daygrid-day.fc-day-today {
    background-color: rgb(253 156 20 / 16%);
    background-color: var(--fc-today-bg-color,rgb(253 156 20 / 16%));
    }
    .figure-caption{
    font-family: 'Open Sans Condensed', sans-serif;
    font-size: 1.2em;
    font-weight: 700;
    }
.grey{
color:<?php echo $grey->getColour(); ?>;
}
.blue{
color:<?php echo $blue->getColour(); ?>;
}
.green{
color:<?php echo $green->getColour(); ?>;
}
.brown{
color:<?php echo $brown->getColour(); ?>;
}
.whitet{
color: #fff;
}
    
ul.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  padding: 50px;
  font-size: 17px;
    z-index: 9999 !important;
}
    
.fc-day-today a{
        color: #b7b322 !important;
        font-weight: 600;
    }
.fc .fc-toolbar-title {
    font-size: 1.4em !important;
    margin: 0;
}
    
    @media only screen and (max-width: 640px)  {
        .fc .fc-toolbar-title {
        font-size: 1em !important;
        margin: 0;
        }
        
        .bin{
            width: 80px;
        }
    }
    
 #tabs{
        padding: 0 !important;
    }


</style>
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CXT7N5997D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CXT7N5997D');
</script>
</head>

<body>
<?php
    
    
 

    
    

    



        function check_other_bins($compared, $tocompare)
        {
            $result = False;

            if (in_array($compared, $tocompare)) {
                $result = True;
            }

            return $result;
        }


        
?>
        
        
<div class="container-lg pb-5">
        <h1 class="pt-5"><span class="bolder">Bin collection days</span> <span class="thinner">- <?php echo $locationName; ?></span></h1>
    
<div id="tabs" class="pt-3">
  <ul class="sticky">
    <li><a href="#tabs-1"><i class="fas fa-sort-amount-down"></i> Coming up</a></li>
    <li><a href="#tabs-2"><i class="far fa-calendar-alt"></i> Calendar</a></li>
  </ul>
  <div id="tabs-1">

    

    
    



    


        
<?php
    





    $smallest_one = strtotime('2030-12-12');
    
//sorting
      
        function compareByTimeStamp($time1, $time2)
        {
            if (strtotime($time1) > strtotime($time2))
                return 1;
            else if (strtotime($time1) < strtotime($time2))
                return -1;
            else
                return 0;
        }

      
        for($x=0; $x<=3; $x++){
            $y=$x+1;
            ${'date'.$y} = ${$current_bin[$x]}->getNextDate();
        }
        for($x=5; $x<=8; $x++){
            ${'date'.$x} = ${$current_bin[$x-5]}->getNextDatePlus();
        }


      
        $arr = array($date1, $date2, $date3, $date4, $date5, $date6, $date7, $date8);
        usort($arr, "compareByTimeStamp"); 

      
//end sorting
      
      
      


      
   for($x=0; $x<=3; $x++){
        
        ${$current_bin[$x].'_image'}='
        <figure class="figure float-end">
          <img src="img/'.$current_bin[$x].'.png" class="bin figure-img img-fluid" alt="'.$current_bin[$x].'">
          <figcaption class="bin figure-caption text-center '.$current_bin[$x].'">'.strtoupper($current_bin[$x]).'</figcaption>
        </figure>';
        
    }
      


      



          
$added_bin_round1 = 0;
$added_bin_round2 = 0;
$main_bin_round1 = array();
$main_bin_round2 = array();
$echoed = 0;

            
            for($n_date = 0; $n_date <= 7; $n_date++){
                
                if($echoed!=4){
                    
                        if ($n_date==0 && $already_posted != 1){
                            echo '<div class="row"><h2>Your next collection:</h2></div>';
                            $already_posted = 1;
                        }elseif($n_date==1 && $already_posted2 != 1){
                            echo '<br /><div class="row"><h2>Your future collections:</h2></div>';
                            $already_posted2 = 1;
                        }
                    
                        for($i = 3; $i >= 0; $i--) {
                        $current_bin_date=${$current_bin[$i]}->getNextDate();
                        $current_bin_date_plus=${$current_bin[$i]}->getNextDatePlus();

                            ///check what bin to post and post it
                            if($current_bin_date==$arr[$n_date] && !in_array($current_bin[$i],$main_bin_round1) && $current_bin[$i] != $added_bin_round1  && $current_bin[$i] != $added_bin_round2){
                                echo '<div class="row a pl' . $i . '">'; 
                                echo '<div class="col">
                                        <h4>' . date("l", strtotime($current_bin_date)) . ', <br/><span id="thedate'.$echoed.'">' . $current_bin_date . '</span></h4>
                                        </div>';
                                                        ///check if any other bin, too
                                for($s = 0; $s <= 3; $s++){
                                    if ($s != $i){
                                        $compare_bin_dates=${$current_bin[$s]}->getDates();
                                        if(check_other_bins($current_bin_date,$compare_bin_dates)){
                                            echo '<div class="col col-md-auto">'.${$current_bin[$s].'_image'}.'</div>';
                                            array_push($main_bin_round1, $current_bin[$i]);
                                            $added_bin_round1 = $current_bin[$s];
                                        }
                                    }

                                }
                                echo '<div class="col col-lg-2">'.${$current_bin[$i].'_image'}.'</div>';
                                echo '</div><hr />';
                                $echoed++;
                            }elseif($current_bin_date_plus==$arr[$n_date] && !in_array($current_bin[$i],$main_bin_round2) && $current_bin[$i] != $added_bin_round1 && $current_bin[$i] != $added_bin_round2){
                                echo '<div class="row b pl' . $i . '">'; 
                                echo '<div class="col">
                                        <h4>' . date("l", strtotime($current_bin_date_plus)) . ', <br/><span id="thedate'.$echoed.'">' . $current_bin_date_plus . '</span></h4>
                                        </div>';
                                                        ///check if any other bin, too
                                for($s = 0; $s <= 3; $s++){
                                    if ($s != $i){
                                        $compare_bin_dates=${$current_bin[$s]}->getDates();
                                        if(check_other_bins($current_bin_date_plus,$compare_bin_dates)){
                                            echo '<div class="col col-md-auto">'.${$current_bin[$s].'_image'}.'</div>';
                                            array_push($main_bin_round2, $current_bin[$i]);
                                            $added_bin_round2 = $current_bin[$s];

                                        }
                                    }

                                }
                                echo '<div class="col col-lg-2">'.${$current_bin[$i].'_image'}.'</div>';
                                echo '</div><hr />';
                                $echoed++;
                            }


                    }
                    
                }else{
                    break;
                }



            }

        
      

    
        ?>
        

  </div>     
          <div id="tabs-2">
          <div id="calendar"></div>
  </div>
        
<div class="d-flex justify-content-between">
    <button id="dark" class="btn btn-dark btn-sm" onclick="toggleTheme('dark');"><i class="fas fa-moon"></i>
 Dark mode</button>
    <button id="light" class="btn btn-dark btn-sm" onclick="toggleTheme('light');"><i class="fas fa-lightbulb"></i> Light mode</button>

    <a href="weirs_wynd_bins.ics" class="btn btn-warning" tabindex="-1" role="button" aria-disabled="true"><i class="fas fa-calendar-alt"></i> Phone calendar</a>
</div>

</div>
    
    
    
                <!-- octopus -->
    
<div id="octopus">
    <div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
        <h1 class="display-4 fw-bold lh-1">Get <strong>£50</strong> for switching to Octopus Energy</h1>
        <p class="lead">With energy prices going up so quickly, save some money by switching to Octopus Energy.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
          <a href="https://share.octopus.energy/tan-loris-643" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Get £50</a>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="dismiss();">Dismiss</button>
        </div>
      </div>
      <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
          <img class="rounded-lg-3" src="octopus.png" alt="" width="720">
      </div>
    </div>
  </div>
</div>
    
<!-- octopus -->


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
//          themeSystem: 'bootstrap',
            events: [                
                <?php
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
            $mt = microtime();
        file_put_contents("get-log.txt", $_SERVER["REMOTE_ADDR"] . "; ".$_SERVER["REMOTE_HOST"]." time: " . date("Y-m-d h:i:sa") . "; memory: ". (memory_get_usage() - $mem) / (1024 * 1024). "; seconds: ". microtime(TRUE) - $time  .";\n", FILE_APPEND | LOCK_EX);
        echo '<!--' . $mt . '<br />';
        print_r(array(
            'memory' => (memory_get_usage() - $mem) / (1024 * 1024),
            'seconds' => microtime(TRUE) - $time
        ));
      echo "Time now: " . date("Y-m-d h:i:sa");
        echo '-->';
    ?>

</body>

</html>
    