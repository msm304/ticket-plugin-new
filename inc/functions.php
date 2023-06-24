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

    $style = is_admin() && !wp_doing_ajax() ? 'style="background:' . $status_color . '"' : '';

    return '<div class="tkt-status"' . $style . '>
                    <span class="tkt-status-name">' . $status_name . '</span>
                    <span class="tkt-status-color" style="background:' . $status_color . ';"></span>
                </div>';
}

function get_department_html($department_id)
{
    $department_manager = new TKT_Front_Department_Manager();
    $department = $department_manager->get_department($department_id);
    return '<span>' . esc_html($department->name) . '</span>';
}

function get_priority_name($priority)
{
    switch($priority){
        case 'low';
            return 'کم';
            break;
        case 'medium';
            return 'متوسط';
            break;
        case 'high';
            return 'زیاد';
            break;
    }
}
