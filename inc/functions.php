<?php

function tkt_settings($key = '')
{
    $options = get_option('tkt_settings');

    return isset($options[$key]) ? $options[$key] : null;
}

function tkt_format_date($timestamp)
{
    return jdate($timestamp)->format("Y-m-d H:i");
}

function tkt_get_status()
{
    $status_array = [
        [
            'slug' => 'open',
            'name' => 'باز',
            'color' => '#d43306',
        ],
        [
            'slug' => 'answered',
            'name' => 'پاسخ داده شده',
            'color' => '#13ba5e',
        ],
        [
            'slug' => 'close',
            'name' => 'بسته شده',
            'color' => '#f28507',
        ],
        [
            'slug' => 'finished',
            'name' => 'پایان یافته',
            'color' => '#141414',
        ],
    ];
    return $status_array;
}
