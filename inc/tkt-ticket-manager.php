<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Ticket_Manager
{
    private $wpdb;
    private $table;
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_tickets';
    }
    public function insert($data)
    {
        if (!intval($data['child_department'])) {
            $errors[] = 'لطفاابتدا نوع تیکت را انتخاب نمایید';
        }
        if (empty($data['body'])) {
            $errors[] = 'لطفا محتوا تیکت را وارد نمایید';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        $this->wpdb->insert(
            $this->table,
            [
                'title' => sanitize_text_field($data['title']),
                'body' => stripslashes_deep($data['body']),
                'creator_id' => $data['creator_id'] ? $data['creator_id'] : NULL,
                'user_id' => $data['user_id'] ? $data['user_id'] : NULL,
                'department_id' => $data['department_id'],
                'status' => $data['status'],
                'priority' => $data['priority'] ? $data['priority'] : 'medium',
                'create_data' => date("Y-m-d H:i:s"),
                'reply_date' =>
                date("Y-m-d H:i:s"),
                'file' => $data['file'] ? $data['file'] : NULL,
            ]
        );
    }
}
