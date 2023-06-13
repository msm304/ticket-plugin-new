<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Upload_Manager
{
    public $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    public function upload()
    {
        add_filter('upload_dir', [$this, 'custom_upload_dir']);

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $upload_overrides = array('test_form' => false);
        $upload_file = wp_handle_upload($this->file, $upload_overrides);
        if ($upload_file && !isset($upload_file['error'])) {
            return ['success' => true, 'url' => $upload_file['url']];
        }
        return ['success' => false, 'message' => $upload_file['error']];
    }
    public function custom_upload_dir($args)
    {
        $year = date("Y", time());
        $month = date("m", time());
        $custom_dir = '/tkt-uploads' . '/' . $year . '/' . $month;

        $args['subdir'] = $custom_dir;
        $args['path'] = $args['basedir'] . $custom_dir;
        $args['url'] = $args['baseurl'] . $custom_dir;

        return $args;
    }
}
