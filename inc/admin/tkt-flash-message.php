<?php
defined('ABSPATH') || exit('Not Access');

class TKT_Flash_Message
{

    const ERROR = 1;
    const SUCCESS = 2;
    const WARNING = 3;
    const INFO = 4;

    public static function add_message($message, $type = self::SUCCESS)
    {
        if (!isset($_SESSION['tkt']['messages'])) {
            $_SESSION['tkt']['messages'] = [];
        }
        $_SESSION['tkt']['messages'][] = ['body' => $message, 'type' => $type];
    }

    public static function show_message(){
        if(isset($_SESSION['tkt']['messages']) && !empty($_SESSION['tkt']['messages'])){
            foreach ($_SESSION['tkt']['messages'] as $message) {
                echo '<div class="notice id-dismissable ' . self::get_type($message['type']) . '">';
                echo '<p>';
                echo $message['body'];
                echo '</p>';
                echo '</div>';
            }
            self::empty_session();
        }
    }

    public function get_type($type){
        switch($type){
            case 2:
                return 'notice-success';
                break;
            case 1:
                return 'notice-error';
                break;
            case 3:
                return 'notice-warning';
                break;
            case 4:
                return 'notice-info';
                break;
        }
    }

    public function empty_session(){
        $_SESSION['tkt']['messages'] = [];
    }
}
