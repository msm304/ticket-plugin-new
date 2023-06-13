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

        $user_id = get_current_user_id();

        $ticket_data = [];
        $ticket_data['title'] = !empty($_POST['title']) ? $_POST['title'] : 'بدون عنوان';
        $ticket_data['body'] = $_POST['body'];
        $ticket_data['creator_id'] = $user_id;
        $ticket_data['status'] = 'open';
        $ticket_data['priority'] = $_POST['priority'];
        $ticket_data['department_id'] = $_POST['child_department'];
        // create ticket
        if (is_array($upload_result)) {
            // create ticket with file
            if ($upload_result['success']) {
                if (isset($upload_result['url'])) {
                    $ticket_data['file'] = $upload_result['url'];
                }

                $ticket_manager = new TKT_Ticket_Manager();
                $ticket_id = $ticket_manager->insert($ticket_data);

                if ($ticket_id) {
                    $this->make_response(['__success' => true, 'results' => TKT_Ticket_Url::all()]);
                }
            } else {
                $this->make_response(['__success' => false, 'results' => $upload_result['message']]);
            }
        } else {
            //create ticket without file
            $ticket_manager = new TKT_Ticket_Manager();
            $ticket_id = $ticket_manager->insert($ticket_data);
            if ($ticket_id) {
                $this->make_response(['__success' => true, 'results' => '']);
            }
        }
    }
    public function make_response($result)
    {
        if (is_array($result)) {
            wp_send_json($result);
        } else {
            echo $result;
        }
        wp_die();
    }
}
