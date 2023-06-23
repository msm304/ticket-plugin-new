<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Ticket_list extends WP_List_Table
{
    private $wpdb;
    private $table;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'ticket',
            'plural' => 'tickets'
        ]);
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_tickets';
    }
    public function get_columns()
    {
        $columns = [
            'cb' => '<input type="checkbox />"',
            'title' => 'عنوان',
            'department_id' => 'دپارتمان',
            'creator_id' => 'ایجاد کننده تیکت',
            'status' => 'وضعیت',
            'priority' => 'اهمیت',
            'create_date' => 'تاریخ ایجاد',
            'reply_date' => 'تاریخ آخرین پاسخ'
        ];
        return $columns;
    }
    public function get_tickets()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table , ARRAY_A);
    }
    public function prepare_items()
    {
        $this->items = $this->get_tickets();
    }
}
