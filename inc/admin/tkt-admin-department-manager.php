<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Admin_Department_Manager
{

    private $wpdb;
    private $table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_departments';
    }

    public function page()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // add department
            if (isset($_POST['add_department_nonce'])) {
                if (!isset($_POST['add_department_nonce']) && !wp_verify_nonce($_POST['add_department_nonce'], 'add_department')) {
                    exit('Sorry, your nonce did not verify');
                }
                $insert = $this->insert($_POST);

                if ($insert) {
                    $answerable_manager = new TKT_Answerable_Manager();
                    // add user answerable
                    if ($_POST['answerable']) {
                        foreach ($_POST['answerable'] as $user) {
                            $answerable_manager->insert(['department_id' => $insert, 'user_id' => $user]);
                        }
                    }
                    TKT_Flash_Message::add_message('دپارتمان با موفقیت ایجاد شد');
                }
            }
            //edit department
            if (isset($_POST['add_department_nonce'])) {
            }
            $departments = $this->get_departments();
            include TKT_VIEWS_PATH . 'admin/department/main.php';
        } else {
            $departments = $this->get_departments();
            include TKT_VIEWS_PATH . 'admin/department/main.php';
        }
    }

    private function get_departments()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table . " ORDER BY position");
    }

    private function get_department($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ID = %d", $id));
    }

    private function insert($data)
    {
        $data = [
            'name' => sanitize_text_field($data['name']),
            'parent' => $data['parent'] ? intval($data['parent']) : 0,
            'position' => $data['position'] ? intval($data['position']) : 0,
            'description' => $data['description'] ? sanitize_textarea_field($data['description']) : null,
        ];
        $data_format = ['%s', '%d', '%d', '%s'];
        $insert = $this->wpdb->insert($this->table, $data, $data_format);
        return $insert ? $this->wpdb->insert_id : null;
    }
}
