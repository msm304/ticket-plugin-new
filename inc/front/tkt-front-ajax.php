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
        if (!wp_verify_nonce($_POST['nonce'], 'tkt_ajax_nonce')) {
            wp_send_json_error();
        }
        // upload file
        $file = $_FILES['file'];
        if ($file) {
            $uploader = new TKT_Upload_Manager($file);
            $upload_result = $uploader->upload();
        }
        // create ticket
    }
}
