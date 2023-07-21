<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Menu extends Base_Menu
{

    public $ticket_object = NULL;

    private $wpdb;
    private $table;

    public function __construct()
    {
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
            ]
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
        if(isset($_POST['publish'])){
            if(!isset($_POST['ticket_nonce']) || wp_verify_nonce($_POST['ticket_nonce'] , 'ticket_security')){
                echo 'Sorry, nonce not verify';
                exit;
            }
            // create ticket
            
        }
        include TKT_VIEWS_PATH . 'admin/ticket/new.php';
    }
    public function departments_page()
    {
        $manager = new TKT_Admin_Department_Manager();
        $manager->page();
    }
}
