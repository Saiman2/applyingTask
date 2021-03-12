<?php
function addActive($route)
{
    return Request::route()->getName() == $route ? 'active' : '';
}

function setActive($route)
{
    return Request::route()->getName() == $route ? ' class=active' : '';
}

function getRangeTimeInDays($range)
{
    $exploded = explode('-', $range);
    $from = new DateTime($exploded[0]);
    $to = new DateTime($exploded[1]);
    $diff = $from->diff($to);
    if ($diff->days == 0) {
        return 'Около ден';
    } else {
        return $diff->days . ' дни';
    }
}

