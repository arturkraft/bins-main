<?php

if( empty( $filename ) ) die("Cannot access this page directly");


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





$bin_dates=generateDates('2132','3442',[$grey->getStartDate(),$blue->getStartDate(),$green->getStartDate(),$brown->getStartDate()],$grey->getEndDate(),2); //run it only once in a while with start_date and end_date defined

$file = fopen($filename,"w");
//
foreach ($bin_dates as $line) {
 fputcsv($file, $line);
}

fclose($file);