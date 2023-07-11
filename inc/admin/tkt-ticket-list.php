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
            // PROBLEM //
            // 'create_date' => 'تاریخ ایجاد',
            // 'reply_date' => 'تاریخ آخرین پاسخ'
            // PROBLEM //
        ];
        return $columns;
    }
    public function get_tickets()
    {
        $params = $_GET;
        $args = [];
        $sql = " WHERE 1=1";
        if (isset($params['department-id']) && $params['department-id'] !== '') {
            $sql .= " AND (department_id = %d)";
            $args[] = $params['department-id'];
        }
        if (isset($params['priority']) && $params['priority'] !== '') {
            $sql .= " AND (priority = %s)";
            $args[] = $params['priority'];
        }
        if (isset($params['status']) && $params['status'] !== '') {
            $sql .= " AND (status = %s)";
            $args[] = $params['status'];
        }
        if (isset($params['creator-id']) && $params['creator-id'] !== '') {
            $sql .= " AND (creator_id = %d)";
            $args[] = $params['creator-id'];
        }
        if (isset($params['search']) && $params['search'] !== '') {
            $sql .= " AND (title LIKE '%" . $params['search'] . "%' )";
        }
        switch($params['orderby']){
            case "create_date":
                $sql .= " ORDER BY create_date " . $params['order'];
                break;
            case "reply_date";
                $sql .= " ORDER BY reply_date " . $params['order'];
                break;
            default: 
                $sql .= " ORDER BY reply_date DESC";
        }
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM " . $this->table . $sql, $args), ARRAY_A);
    }
    public function record_count()
    {
        return count($this->get_tickets());
    }
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case "ID":
                return $item[$column_name];
                break;
            case "title":
                return $item[$column_name];
                break;
            case "department_id":
                return '<a href="admin.php?page=tkt-tickets&department-id=' . $item[$column_name] . '">' . get_department_html($item[$column_name]) . '</a>';
                break;
            case "creator_id":
                return $item[$column_name];
                break;
            case "status";
                return get_status_html($item[$column_name]);
                break;
            case "priority";
                return '<a href="admin.php?page=tkt-tickets&priority=' . $item[$column_name] . '" class="tkt-priority tkt-priority-' . $item[$column_name] . '">' . get_priority_name($item[$column_name]) . '</a>';
                break;
            case "create_date";
                return tkt_format_date(strtotime($item[$column_name]));
                break;
            case "reply_date";
                return tkt_format_date(strtotime($item[$column_name]));
                break;
        }
    }
    public function column_title($item)
    {
        $title = '<strong>' . $item['title'] . '</stron>';
        $action = [
            'id' => sprintf('<span>' . 'آیدی' . ': %d </span>', $item['ID']),
            'edit' => sprintf('<a href="">' . 'ویرایش' . '</a>'),
        ];
        return $title . $this->row_actions($action);
    }
    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s">', $item['ID']);
    }
    public function column_creator_id($item)
    {
        $user_data = get_userdata($item['creator_id']);
        $creator = '<a href="admin.php?page=tkt-tickets&creator-id=' . $item['creator_id'] . '">' . $user_data->display_name . '</a>';
        $action = ['edit' => '<a href="' . get_edit_user_link($item['creator_id']) . '" target="_blank">' . 'پروفایل' . '</a>'];
        return $creator . $this->row_actions($action);
    }
    // PROBLEM //
    // public function get_sortable_columns()
    // {
    //     return [
    //         'create_date' => ['create_date' , true],
    //         'reply_date' => ['reply_date' , true]
    //     ];
    // }
    // PROBLEM // 
    public function prepare_items()
    {
        $this->items = $this->get_tickets();

        $per_page = $this->get_items_per_page('tickets_per_page', 20);
        $current_page = $this->get_pagenum();
        $total_items = $this->record_count();

        $this->items = array_slice($this->items, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ]);
    }
}
