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
        $errors = [];
        if (!intval($data['department_id'])) {
            $errors[] = 'لطفا ابتدا نوع تیکت را انتخاب نمایید';
        }
        if (empty($data['body'])) {
            $errors[] = 'لطفا محتوا تیکت را وارد نمایید';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        $insert = $this->wpdb->insert(
            $this->table,
            [
                'title' => sanitize_text_field($data['title']),
                'body' => stripslashes_deep($data['body']),
                'creator_id' => $data['creator_id'] ? $data['creator_id'] : NULL,
                'user_id' => $data['user_id'] ? $data['user_id'] : NULL,
                'department_id' => $data['department_id'],
                'status' => $data['status'],
                'priority' => $data['priority'] ? $data['priority'] : 'medium',
                'create_date' => date("Y-m-d H:i:s"),
                'reply_date' => date("Y-m-d H:i:s"),
                'file' => $data['file'] ? $data['file'] : NULL

            ],
            ['%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s']
        );
        $insert_id = $this->wpdb->insert_id;
        return ['ticket_id' => $insert_id];
    }

    public function get_tickes($user_id, $type = NULL, $status = NULL, $orderby = NULL)
    {
        if (!intval($user_id)) {
            return [];
        }

        $args = [];

        // type filter
        switch ($type) {
            case 'send':
                $type_where = "creator_id = %d";
                $args[] = $user_id;
                break;
            case 'received':
                $type_where = "user_id = %d AND from_admin = 1";
                $args[] = $user_id;
                break;
            default:
                $type_where = "user_id = %d OR creator_id = %d";
                $args[] = $user_id;
                $args[] = $user_id;
                break;
        }
        // status filter
        switch ($status) {
            case 'all':
                $status_where  = "";
                break;
            case NULL:
                $status_where = "";
                break;
            default:
                $status_where = "AND status = %s";
                $args[] = $status;
                break;
        }
        // orderby filter
        switch ($orderby) {
            case 'create-date':
                $orderby_sql = "ORDER BY create_date DESC";
                break;
            case 'reply-date':
                $orderby_sql = "ORDER BY reply_date DESC";
                break;
            default:
                $orderby_sql = "ORDER BY reply_date DESC";

                break;
        }
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE " . $type_where . ' ' . $status_where . ' ' . $orderby_sql, $args));
    }
    public function tickets_count($user_id, $type, $status)
    {
        return count($this->get_tickes($user_id, $type, $status));
    }
    public function get_ticket($ticket_id)
    {
        if (!intval($ticket_id)) {
            return NULL;
        }
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->table . " Where ID = %d", $ticket_id));
    }
    public function update_status($ticket_id, $status)
    {
        return $this->wpdb->update(
            $this->table,
            ['status' => $status],
            ['ID' => $ticket_id],
            ['%s'],
            ['%d']
        );
    }
    public function update_reply_date($ticket_id)
    {
        $data = date("Y-m-d H:i:s");
        return $this->wpdb->query($this->wpdb->prepare("UPDATE " . $this->table . " SET reply_date = '" . $data . "' WHERE ID = %d", $ticket_id));
    }
}
