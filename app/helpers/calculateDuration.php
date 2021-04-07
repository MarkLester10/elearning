<?php

function calculateDuration($time1, $time2)
{

       $date1 = strtotime($time1);
       $date2 = strtotime($time2);

       // Formulate the Difference between two dates
       $diff = abs($date2 - $date1);


       // To get the year divide the resultant date into
       // total seconds in a year (365*60*60*24)
       $years = floor($diff / (365 * 60 * 60 * 24));


       // To get the month, subtract it with years and
       // divide the resultant date into
       // total seconds in a month (30*60*60*24)
       $months = floor(($diff - $years * 365 * 60 * 60 * 24)
              / (30 * 60 * 60 * 24));


       // To get the day, subtract it with years and
       // months and divide the resultant date into
       // total seconds in a days (60*60*24)
       $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
              $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


       // To get the hour, subtract it with years,
       // months & seconds and divide the resultant
       // date into total seconds in a hours (60*60)
       $hours = floor(($diff - $years * 365 * 60 * 60 * 24
              - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
              / (60 * 60));


       // To get the minutes, subtract it with years,
       // months, seconds and hours and divide the
       // resultant date into total seconds i.e. 60
       $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
              - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
              - $hours * 60 * 60) / 60);


       // To get the minutes, subtract it with years,
       // months, seconds, hours and minutes
       $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
              - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
              - $hours * 60 * 60 - $minutes * 60));

       // Print the result
       return array(
              $hours,
              $minutes,
              $seconds
       );
}


function getTotalDuration($timesArray)
{
       $all_seconds = 0;
       // loop throught all the times
       foreach ($timesArray as $time) {
              list($hour, $minute, $second) = explode(':', $time);
              $all_seconds += $hour * 3600;
              $all_seconds += $minute * 60;
              $all_seconds += $second;
       }


       $total_minutes = floor($all_seconds / 60);
       $seconds = $all_seconds % 60;
       $hours = floor($total_minutes / 60);
       $minutes = $total_minutes % 60;

       // returns the time already formatted
       return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
