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

        $answerable_manager = new TKT_Answerable_Manager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // add department
            if (isset($_POST['add_department_nonce'])) {
                if (!isset($_POST['add_department_nonce']) && !wp_verify_nonce($_POST['add_department_nonce'], 'delete_department_nonce')) {
                    exit('Sorry, your nonce did not verify');
                }
                $insert = $this->insert($_POST);

                if ($insert) {

                    // add user answerable
                    if ($_POST['answerable']) {
                        foreach ($_POST['answerable'] as $user) {
                            $answerable_manager->insert(['department_id' => $insert, 'user_id' => $user]);
                        }
                    }
                    TKT_Flash_Message::add_message('دپارتمان با موفقیت ایجاد شد');
                }
            }

            //update department
            if (isset($_POST['update_department_nonce'])) {
                if (!isset($_POST['update_department_nonce']) && !wp_verify_nonce($_POST['update_department_nonce'], 'update_department_nonce')) {
                    exit('Sorry, your nonce did not verify');
                }
                $update = $this->update($_POST['department_id'], $_POST);
                if ($update) {
                    TKT_Flash_Message::add_message('بروزرسانی دپارتمان با موفقیت انجام شد');
                }
                $answerable_manager->delete($_POST['department_id']);
                if ($_POST['answerable']) {
                    foreach ($_POST['answerable'] as $user) {
                        $answerable_manager->insert(['department_id' => $_POST['department_id'], 'user_id' => $user]);
                    }
                }
            }

            $departments = $this->get_departments();
            include TKT_VIEWS_PATH . 'admin/department/main.php';
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                if (isset($_GET['delete_department_nonce']) && !wp_verify_nonce($_GET['delete_department_nonce'], 'delete_department_nonce')) {
                    $this->delete($_GET['id']);

                    $answerable_manager->delete($_GET['id']);
                    TKT_Flash_Message::add_message('دپارتمان موردنظر با موفقیت حذف شد');

                    $departments = $this->get_departments();
                    include TKT_VIEWS_PATH . 'admin/department/main.php';
                }
            } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
                $departments = $this->get_departments();
                $department = $this->get_department($_GET['id']);
                $answerable = $answerable_manager->get_by_department($department->ID);
                include TKT_VIEWS_PATH . 'admin/department/edit.php';
            } else {
                $departments = $this->get_departments();
                include TKT_VIEWS_PATH . 'admin/department/main.php';
            }
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

    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }

    public function update($id, $data)
    {
        $data = [
            'name' => sanitize_text_field($data['name']),
            'parent' => $data['parent'] ? intval($data['parent']) : 0,
            'position' => $data['position'] ? intval($data['position']) : 1,
            'description' => $data['description'] ? sanitize_textarea_field($data['description']) : null,
        ];
        $where = ['ID' => $id];
        $data_format = ['%s', '%d', '%d', '%s'];
        $where_format = ['%d'];
        return $this->wpdb->update($this->table, $data, $where, $data_format, $where_format);
    }

    private function insert($data)
    {
        $data = [
            'name' => sanitize_text_field($data['name']),
            'parent' => $data['parent'] ? intval($data['parent']) : 0,
            'position' => $data['position'] ? intval($data['position']) : 1,
            'description' => $data['description'] ? sanitize_textarea_field($data['description']) : null,
        ];
        $data_format = ['%s', '%d', '%d', '%s'];
        $insert = $this->wpdb->insert($this->table, $data, $data_format);
        return $insert ? $this->wpdb->insert_id : null;
    }
}
