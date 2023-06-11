<?php

// Control core classes for avoid errors
if (class_exists('CSF')) {

    //
    // Set a unique slug-like ID
    $prefix = 'tkt_settings';

    //
    // Create options
    CSF::createOptions($prefix, array(
        'menu_title' => 'تیکت پشتیبانی',
        'menu_slug'  => 'tkt-settings',
        'menu_hidden' => true,
        'framework_title' => 'تیکت پشتیبانی',
    ));

    // Create a section
    CSF::createSection(
        $prefix,
        array(
            'title'  => 'عمومی',
            'fields' => array(
                array(
                    'id'      => 'new-ticket-alert',
                    'type'    => 'switcher',
                    'title'   => 'پیغام صفحه ارسال تیکت',
                    'label'   => 'آیا فعال باشد؟',
                    'default' => false
                ),
                array(
                    'id'      => 'new-ticket-alert-text',
                    'type'    => 'textarea',
                    'title'   => 'متن پیغام',
                    'default' => 'این متن پیش فرض جهت تست است',
                    'dependency' => array('new-ticket-alert', '==', 'true')
                ),
            )
        )
    );
    CSF::createSection(
        $prefix,
        array(
            'title'  => 'استایل',
            'fields' => array(
                array(
                    'id'      => 'opt-switcher-2',
                    'type'    => 'switcher',
                    'title'   => 'Switcher',
                    'label'   => 'Do you want activate it ?',
                    'default' => true
                ),
            )
        )
    );
}
