<?php

if( empty( $bins_main ) ) die("Cannot access this page directly!");

echo 'dupa';
//define('__ROOT__', $up2);
define('__ROOT__', dirname(dirname(__FILE__)));



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



                
$filename = $up2.'/'.$folder_name.'/generated-bin-dates.csv';

echo $filename;
                


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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bins collection day - <?php echo $location_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="apple-mobile-web-app-capable" content="yes">
    
<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/12.9__iPad_Pro_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/11__iPad_Pro__10.5__iPad_Pro_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.9__iPad_Air_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.5__iPad_Air_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.2__iPad_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_14_Pro_Max__iPhone_14_Max__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_14_Pro__iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_11_Pro_Max__iPhone_XS_Max_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/iPhone_11__iPhone_XR_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/12.9__iPad_Pro_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/11__iPad_Pro__10.5__iPad_Pro_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.9__iPad_Air_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.5__iPad_Air_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.2__iPad_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_14_Pro_Max__iPhone_14_Max__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_14_Pro__iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/iPhone_11__iPhone_XR_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=b">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=b">
    <link rel="manifest" href="/site.webmanifest?v=b">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=b" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=b">
    <meta name="apple-mobile-web-app-title" content="<?php echo $location_name; ?> Bins">
    <meta name="application-name" content="<?php echo $location_name; ?> Bins">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="/bins-main/css/styles.css?v=2" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300;700&family=Raleway:wght@200&family=Zen+Loop&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.js"></script>

    
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
    
<?php

echo $gtag;

?>
<style>
        :root {
        --background-primary: #fff;
        --color-primary: #333;
    }

    html[data-theme='dark'] {
        --background-primary: #6f6f6f;
        --color-primary: #333;
    }

    @keyframes change-color {
  25% {
    opacity: 0.25;
  }
    33% {
    opacity: 0.33;
  }
  50% {
    opacity: 0.5;
  }
    66% {
    opacity: 0.66;
  }
  75% {
    opacity: 0.75;
  }
    86% {
    opacity: 0.86;
  }
  100% {
    opacity: 1;
  }
}



    html {
                background: var(--background-primary);
        color: var(--color-primary);
        transition: color 300ms, background-color 300ms;
          animation-name: change-color;
  animation-duration: 1s;

    }

    h1,
    h2,
    h3,
    h4,
    p {
        color: var(--color-primary);

    }

    html {
        transition: color 300ms, background-color 300ms !important;
    }

    html[data-theme='dark'] {
        background: #000;
        transition: color 300ms, background-color 300ms !important;
        filter: invert(1) hue-rotate(180deg);
        height: 100%;
        margin: 0;
        padding: 0;
    }

    html[data-theme='dark'] img {
        filter: invert(1) hue-rotate(180deg)
    }
    .grey {
        color: <?php echo $grey->getColour();
        ?>;
    }

    .blue {
        color: <?php echo $blue->getColour();
        ?>;
    }

    .green {
        color: <?php echo $green->getColour();
        ?>;
    }

    .brown {
        color: <?php echo $brown->getColour();
        ?>;
    }
</style>
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
        <h1 class="pt-5"><span class="bolder">Bin collection days</span> <span class="thinner">- <?php echo $location_name; ?></span></h1>
    
<div id="tabs" class="pt-3">
  <ul class="sticky">
    <li><a href="#tabs-1"><i class="fas fa-sort-amount-down"></i> Coming up</a></li>
    <li><a href="#tabs-2"><i class="far fa-calendar-alt"></i> Calendar</a></li>
  </ul>
  <div id="tabs-1">

    

    
    



    


        
<?php
    





    $smallest_one = strtotime('2030-12-12');
    
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
        }
        for($x=5; $x<=8; $x++){
            ${'date'.$x} = ${$current_bin[$x-5]}->getNextDatePlus();
        }


      
        $arr = array($date1, $date2, $date3, $date4, $date5, $date6, $date7, $date8);
        usort($arr, "compareByTimeStamp"); 

      
//end sorting
      
      
      

//preparing bin displays
      
   for($x=0; $x<=3; $x++){
        
        ${$current_bin[$x].'_image'}='
        <figure class="figure float-end">
          <img src="../../bins-main/img/'.$current_bin[$x].'.png" class="bin figure-img img-fluid" alt="'.$current_bin[$x].'">
          <figcaption class="bin figure-caption text-center '.$current_bin[$x].'">'.strtoupper($current_bin[$x]).'</figcaption>
        </figure>';
        
    }
      


//NEW WAY

echo '<div class="row"><h2>Your next collection:</h2></div>';
echo '<div class="row pl0">'; 
echo '<div class="col">
      <h4>' . date("l", strtotime($arr[0])) . ', <br/>
      <span id="thedate0">' . $arr[0] . '</span>
      </h4></div>';

for($i = 0; $i <= 3; $i++) 
{
    $current_bin_date=${$current_bin[$i]}->getNextDate();
    if($arr[0] == $current_bin_date)
    {
        echo '<div class="col col-md-auto">'.${$current_bin[$i].'_image'}.'</div>';
    }
}

echo '</div>';
echo '<br /><div class="row"><h2>Your future collections:</h2></div>';

$next_week = $arr[1];

if ($next_week == $arr[0])
{
    $next_week = $arr[2];
}

echo '<div class="row pl1">'; 
echo '<div class="col">
      <h4>' . date("l", strtotime($next_week)) . ', <br/>
      <span id="thedate1">' . $next_week . '</span>
      </h4></div>';

for($i = 0; $i <= 3; $i++) 
{
    $current_bin_date=${$current_bin[$i]}->getNextDate();
    $current_bin_date_plus=${$current_bin[$i]}->getNextDatePlus();
    if($next_week == $current_bin_date)
    {
        echo '<div class="col col-md-auto">'.${$current_bin[$i].'_image'}.'</div>';
    }
}
echo '</div><hr />';

//NEW WAY END
      


//OLD WAY
          /*
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
*/
//OLD WAY END

        
      

    
        ?>
        

  </div>     
          <div id="tabs-2">
          <div id="calendar"></div>
  </div>
        
<div class="d-flex justify-content-between">
    <button id="dark" class="btn btn-dark btn-sm" onclick="toggleTheme('dark');"><i class="fas fa-moon"></i>
 Dark mode</button>
    <button id="light" class="btn btn-dark btn-sm" onclick="toggleTheme('light');"><i class="fas fa-lightbulb"></i> Light mode</button>

    <a href="<?php echo $folder_name ?>.ics" class="btn btn-warning" tabindex="-1" role="button" aria-disabled="true"><i class="fas fa-calendar-alt"></i> Phone calendar</a>
</div>

</div>
    
    
    <?php 
if ($show_octopus == 1){

    ?>
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
          <img class="rounded-lg-3" src="../../bins-main/img/octopus.png" alt="" width="720">
      </div>
    </div>
  </div>
</div>
    
<!-- octopus -->
<?php
}
?>

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
        file_put_contents("get-log.txt", "Time: " . date("Y-m-d h:i:sa") . "; memory: ". (memory_get_usage() - $mem) / (1024 * 1024). "; seconds: ". microtime(TRUE) - $time  ." by ".$_SERVER["REMOTE_ADDR"] . "; ".$_SERVER["REMOTE_HOST"].";\n", FILE_APPEND | LOCK_EX);
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
    

