<?php
function formatDate($date)
{
    $d = new DateTime($date);
    return $d->format("F j \, Y \, g:iA \,\n l ");
}
function formatDate2($date, $timeOnly = false)
{
    $d = new DateTime($date);
    if ($timeOnly) {
        return $d->format('H:i:s A');
    } else {
        return $d->format('Y-m-d H:i:s');
    }
}

function shortDate($date, $withTime = true)
{
    $d = new DateTime($date);
    if ($withTime) {
        return $d->format("F j \, Y \, g:iA");
    } else {
        return $d->format("F j \, Y");
    }
}


function defaultDate($date)
{
    $d = new DateTime($date);
    return $d->format("F j \, Y");
}

function getAverageDuration($timesArray)
{
    $times = $timesArray;
    $totaltime = '';
    foreach ($times as $time) {
        $timestamp = strtotime($time);
        $totaltime += $timestamp;
    }
    $average_time = ($totaltime / count($times));
    return date('H:i:s', $average_time);
}
// $times = array('0:30:53', '3:00:32', '5:30:01');
// $totaltime = '';
// foreach ($times as $time) {
//   $timestamp = strtotime($time);
//   $totaltime += $timestamp;
// }
// $average_time = ($totaltime / count($times));
// echo date('H:i:s', $average_time);
// die();