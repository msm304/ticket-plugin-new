<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Reply_Manager
{
    private $wpdb;
    private $table;
    private $ticket_id;

    public function __construct($ticket_id)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_replies';
        $this->ticket_id = $ticket_id;
    }

    public function insert($data)
    {

        $errors = [];

        if (empty($data['body'])) {
            $errors[] = 'لطفا محتوا پاسخ را وارد نمایید';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        $this->wpdb->insert(
            $this->table,
            [
                'ticket_id' => $this->ticket_id,
                'body' => stripslashes_deep($data['body']),
                'creator_id' => $data['creator_id'] ? $data['creator_id'] : NULL,
                'file' => $data['file'] ? $data['file'] : NULL,
            ],
            ['%d', '%s', '%d', '%s']
        );
        return $this->wpdb->insert_id;
    }
    public function get_replies()
    {
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ticket_id = %d ORDER BY create_date ASC", $this->ticket_id));
    }
}
