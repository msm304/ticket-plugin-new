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

    //
    // Create a section
    CSF::createSection($prefix, array(
        'title'  => 'Tab Title 1',
        'fields' => array(

            //
            // A text field
            array(
                'id'    => 'opt-text',
                'type'  => 'text',
                'title' => 'Simple Text',
            ),

        )
    ));

    //
    // Create a section
    CSF::createSection($prefix, array(
        'title'  => 'Tab Title 2',
        'fields' => array(

            // A textarea field
            array(
                'id'    => 'opt-textarea',
                'type'  => 'textarea',
                'title' => 'Simple Textarea',
            ),

        )
    ));
}
