<?php

defined('ABSPATH') || exit('Not Access');

class TKT_WC_Dashboard
{
    public function __construct()
    {
        add_filter('woocommerce_account_menu_items', [$this, 'tickets_account_menu']);
        add_action('init', [$this, 'add_tickets_endpoint']);
        add_action('woocommerce_account_tickets_endpoint', [$this, 'tickets_endpoint_page']);
    }
    public function tickets_account_menu($items)
    {
        $logout = NULL;
        if (isset($items['customer-logout'])) {
            $logout = $items['customer-logout'];
        }
        unset($items['customer-logout']);
        $items['tickets'] = 'تیکت پشتیبانی';
        if ($logout) {
            $items['customer-logout'] = $logout;
        }
        return $items;
    }
    public function add_tickets_endpoint()
    {
        add_rewrite_endpoint('tickets', EP_PAGES);
        flush_rewrite_rules();
    }
    public function tickets_endpoint_page()
    {
        include_once $this->get_view();
    }
    public function get_view()
    {
        return TKT_VIEWS_PATH . 'front/tickets.php';
    }
}
