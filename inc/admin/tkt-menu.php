<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Menu extends Base_Menu
{

    public $ticket_object = NULL;

    private $wpdb;
    private $table;
    private $ticket_id = null;

    public function __construct()
    {
        $this->ticket_id = $_GET['id'];
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'tkt_tickets';

        $this->page_title = 'تیکت پشتیبانی';
        $this->menu_title = 'تیکت پشتیبانی';
        $this->menu_slug = 'ticket-plugin';
        $this->icon = TKT_ADMIN_ASSETS . 'images/icon.png';
        $this->has_sub_menu = true;
        $this->sub_items = [
            'settings' => [
                'page_title' => __('تنظیمات', 'ticket-plugin'),
                'menu_title' => __('تنظیمات', 'ticket-plugin'),
                'menu_slug' => 'tkt-settings',
                'callback' => 'tickets_page',
                'load' =>  [
                    'status' => false,
                ]

            ],
            'tickets' => [
                'page_title' => __('تیکت ها', 'ticket-plugin'),
                'menu_title' => __('تیکت ها', 'ticket-plugin'),
                'menu_slug' => 'tkt-tickets',
                'callback' => 'tickets_page',
                'load' =>  [
                    'status' => true,
                    'callback' => 'tickets_screen_option'
                ]

            ],
            'departments' => [
                'page_title' => __('دپارتمان ها', 'ticket-plugin'),
                'menu_title' => __('دپارتمان ها', 'ticket-plugin'),
                'menu_slug' => 'tkt-departments',
                'callback' => 'departments_page',
                'load' =>  [
                    'status' => false,
                ]
            ],
            'new-ticket' => [
                'page_title' => 'ارسال تیکت',
                'menu_title' => 'ارسال تیکت',
                'menu_slug' => 'tkt-new-ticket',
                'callback' => 'new_ticket_page',
                'load' =>  [
                    'status' => false,
                ]
            ],
            'edit-ticket' => [
                'page_title' => 'ویرایش تیکت',
                'menu_title' => 'ویرایش تیکت',
                'menu_slug' => 'tkt-edit-ticket',
                'callback' => 'edit_ticket_page',
                'load' =>  [
                    'status' => false,
                ]
            ],

        ];

        parent::__construct();
    }
    public function page()
    {
        echo 'ticket plugin page';
    }
    public function tickets_page()
    {
        include TKT_VIEWS_PATH . 'admin/ticket/main.php';
    }
    public function tickets_screen_option()
    {
        // add screen option
        $args = [
            'label' => 'تعداد تیکت در هر صفحه',
            'default' => 20,
            'option' => 'tickets_per_page'
        ];
        add_screen_option('per_page', $args);

        $this->ticket_object = new TKT_Ticket_list();
    }
    public function new_ticket_page()
    {
        $is_edit = false;
        if (isset($_POST['publish'])) {
            if (!isset($_POST['ticket_nonce']) || !wp_verify_nonce($_POST['ticket_nonce'], 'ticket_security')) {
                echo 'Sorry, nonce not verify';
                exit;
            }
            $current_user = get_current_user_id();
            $data = $_POST;

            $ids = $this->create_ticket($current_user, $data);

            if (count($ids)) {
                foreach ($ids as $id) {
                    TKT_Flash_Message::add_message('تیکت با موفقیت ارسال شد.' . ' ' . ' شماره تیکت: ' . $id);
                }
            }
        }
        include TKT_VIEWS_PATH . 'admin/ticket/new.php';
    }
    public function create_ticket($creator_id, $data)
    {
        // create ticket
        $ids = [];
        if ($data['user-id'] && count($data['user-id'])) {
            foreach ($data['user-id'] as $user_id) {
                $insert = $this->wpdb->insert(
                    $this->table,
                    [
                        'title' => sanitize_text_field($data['title']),
                        'body' => stripslashes_deep($data['tkt-content']),
                        'status' => $data['status'],
                        'priority' => $data['priority'],
                        'creator_id' => $$creator_id,
                        'user_id' => $user_id,
                        'from_admin' => 1,
                        'department_id' => $data['department-id'],
                        'file' => $data['file'] ? sanitize_text_field($data['file']) : null,
                    ],
                    ['%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s']
                );
                if ($insert) {
                    $ids[] = $this->wpdb->insert_id;
                }
            }
        }
        return $ids;
    }
    public function edit_ticket_page()
    {
        $is_edit = true;
        $ticket = $this->get_ticket();

        $reply_manager = new TKT_Reply_Manager($this->ticket_id);
        $replies = $reply_manager->get_replies();

        include TKT_VIEWS_PATH . 'admin/ticket/new.php';
    }
    public function get_ticket()
    {
        if (!intval($this->ticket_id)) {
            return null;
        }
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ID = %d", $this->ticket_id));
    }
    public function departments_page()
    {
        $manager = new TKT_Admin_Department_Manager();
        $manager->page();
    }
}
