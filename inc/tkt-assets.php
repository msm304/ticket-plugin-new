<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'front_assets']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
    }
    public function admin_assets()
    {
        //styles
        wp_enqueue_style('tkt-admin-style', TKT_ADMIN_ASSETS . 'css/style.css');
        wp_enqueue_style('tkt-select2', TKT_ADMIN_ASSETS . 'css/select2.min.css');
        // scripts
        wp_enqueue_script('tkt-select2', TKT_ADMIN_ASSETS . 'js/select2.min.js', ['jquery'], true);
        wp_enqueue_script('tkt-main', TKT_ADMIN_ASSETS . 'js/main.js', ['jquery'], TKT_VER, true);
        wp_localize_script('tkt-main', 'TKT_DATA', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
    public function front_assets()
    {
        wp_enqueue_style('tkt-style', TKT_FRONT_ASSETS . 'css/style.css', '', TKT_VER);
    }
}
