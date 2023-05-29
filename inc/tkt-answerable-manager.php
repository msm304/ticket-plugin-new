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
            ['department_id' => $data['department_id'] , 'user_id' => $data['user_id']],
            ['%d' , '%d']
        );
    }
}
