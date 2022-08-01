<?php

if( empty( $filename ) ) die("Cannot access this page directly");





$bin_dates=generateDates($schedule_code,$weeks_added,[$grey->getStartDate(),$blue->getStartDate(),$green->getStartDate(),$brown->getStartDate()],$grey->getEndDate(),2); //run it only once in a while with start_date and end_date defined

$file = fopen($filename,"w");

foreach ($bin_dates as $line) {
 fputcsv($file, $line);
}

fclose($file);

