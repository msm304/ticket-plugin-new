<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Menu extends Base_Menu
{
    public function __construct()
    {
        $this->page_title = 'تیکت پشتیبانی';
        $this->menu_title = 'تیکت پشتیبانی';
        $this->menu_slug = 'ticket-plugin';
        $this->icon = TKT_ADMIN_ASSETS . 'images/icon.png';
        $this->has_sub_menu = true;
        $this->sub_items = [
            'settings' => [
                'pageـtitle' => 'تنظیمات',
                'menu_title' => 'تنظیمات',
                'menu_slug' => 'tkt-settings',
                'callback' => '',
            ],
            'tickets' => [
                'pageـtitle' => 'لیست تیکت ها',
                'menu_title' => 'لیست تیکت ها',
                'menu_slug' => 'tkt-tickets',
                'callback' => 'tickets_page',
            ],
            'departments' => [
                'pageـtitle' => 'لیست دپارتمان ها',
                'menu_title' => 'لیست دپارتمان ها',
                'menu_slug' => 'tkt-departments',
                'callback' => 'departments_page',
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
        echo '<h2>لیست تیکت ها</h2>';
    }
    public function departments_page()
    {
        $manager = new TKT_Admin_Department_Manager();
        $manager->page();
    }
}
