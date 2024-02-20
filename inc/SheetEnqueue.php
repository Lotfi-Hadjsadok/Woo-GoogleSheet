<?php


namespace Inc;
class SheetEnqueue{
    public function init(){
        add_action('admin_enqueue_scripts',array($this,'enqueue_admin_scripts'));
    }


    public function enqueue_admin_scripts(){
        wp_enqueue_script( 'show_hide_google_sheet',plugin_dir_url(dirname(__FILE__)) . '/assets/show_hide_google_sheet_override.js' ,time(), true );
    }
}