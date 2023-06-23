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
            'slug' => 'closed',
            'name' => 'بسته شده',
            'color' => '#f28507',
        ],
        [
            'slug' => 'finished',
            'name' => 'پایان یافته',
            'color' => '#141414',
        ],
    ];
    if (is_admin()) {
        $status_array[] = [
            'slug' => 'trash',
            'name' => 'زباله دان',
            'color' => '#141414',
        ];
    }
    return $status_array;
}
function tkt_get_status_color($status)
{
    $statuses = tkt_get_status();
    foreach ($statuses as $item) {
        if ($status == $item['slug']) {
            return $item['color'];
        }
    }
}
function tkt_get_status_name($status)
{
    $statuses = tkt_get_status();
    foreach ($statuses as $item) {
        if ($status == $item['slug']) {
            return $item['name'];
        }
    }
}
function tkt_get_file_name($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    return basename($path);
}

function get_status_html($status)
{
    $status_name = tkt_get_status_name($status);
    $status_color = tkt_get_status_color($status);
    return '<div class="tkt-status">
                    <span class="tkt-status-name">' . $status_name . '</span>
                    <span class="tkt-status-color" style="background:' . $status_color . ';"></span>
                </div>';
}
