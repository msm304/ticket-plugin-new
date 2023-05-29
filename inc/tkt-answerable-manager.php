<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Answerable_Manager
{

    private $wpdb;
    private $table;
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_users';
    }

    public function insert($data)
    {
        return $this->wpdb->insert(
            $this->table,
            ['department_id' => sanitize_text_field($data['department_id']) , 'user_id' => sanitize_textarea_field($data['user_id'])],
            ['%d' , '%d']
        );
    }
}
