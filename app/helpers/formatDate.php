<?php
function formatDate($date)
{
    $d = new DateTime($date);
    return $d->format("F j \, Y \, g:ia \,\n l ");
}

function shortDate($date, $withTime = true)
{
    $d = new DateTime($date);
    if ($withTime) {
        return $d->format("F j \, Y \, g:ia");
    } else {
        return $d->format("F j \, Y");
    }
}

function defaultDate($date)
{
    $d = new DateTime($date);
    return $d->format("F j \, Y");
}
