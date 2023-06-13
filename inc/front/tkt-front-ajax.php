<?php

defined('ABSPATH') || exit('Not Access');
class TKT_Front_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_tkt_submit_ticket', [$this, 'submit_ticket']);
        add_action('wp_ajax_nopriv_tkt_submit_ticket', [$this, 'submit_ticket']);
    }
    public function submit_ticket()
    {
        var_dump($_FILES);
    }
}
