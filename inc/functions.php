<?php

function tkt_settings($key = '')
{
    $options = get_option('tkt_settings');

    return isset($options[$key]) ? $options[$key] : null;

}
