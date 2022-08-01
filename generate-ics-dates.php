<?php

if( empty( $filenameICS ) ) die("Cannot access this page directly");

$grey->setEndDate($ics_end_date);
$blue->setEndDate($ics_end_date);
$green->setEndDate($ics_end_date);
$brown->setEndDate($ics_end_date);

$bin_dates=generateDates($schedule_code,$weeks_added,[$grey->getStartDate(),$blue->getStartDate(),$green->getStartDate(),$brown->getStartDate()],$grey->getEndDate(),2); 

$fileICS = fopen($filenameICS,"w");

$start_ics = "BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
PRODID:-//bins/arturkraft//EN
CALSCALE:GREGORIAN";

$end_ics='
BEGIN:VEVENT
DTEND;VALUE=DATE:20221217
DTSTART;VALUE=DATE:20221212
LOCATION:Weirs Wynd
DESCRIPTION:DOWNLOAD A NEW BIN CALENDAR FROM www.artur.kr/'.$folder_name.'
URL;VALUE=URI:https://artur.kr/'.$folder_name.'/
SUMMARY:UPDATE BIN CALENDAR
UID:'.md5('new').'
SEQUENCE:0
DTSTAMP:20220127T162901Z
END:VEVENT
END:VCALENDAR';

$write_ics = $start_ics;

foreach ($bin_dates as $line) {

    for ($n=1;$n<=count($line);$n++){
        $next_day_date = date('Y-m-d', strtotime($line[$n] . ' +1 day'));
        $write_ics .= 
        '
BEGIN:VEVENT
DTEND;VALUE=DATE:'.str_replace("-", "", $next_day_date).
'
DTSTART;VALUE=DATE:'.str_replace("-", "", $line[$n]).'
LOCATION:'.$location_name.'
DESCRIPTION:'.strtoupper($line[0]).' BIN COLLECTION
SUMMARY:'.strtoupper($line[0]).' BIN
UID:'.md5($line[$n].$line[0]).$line[$n].'
SEQUENCE:0
DTSTAMP:20220127T162901Z
END:VEVENT';

    }

}

$write_ics .= $end_ics;

fwrite($fileICS, $write_ics);

fclose($fileICS);