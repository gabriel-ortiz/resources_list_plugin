<?php
/*
Plugin Name: Custom Resource Lists Plugin
Plugin URI: www.gabrielortizart.com 
Description: Create custom lists for academic libraries
Version: 0.1.0
Author: Gabriel Ortiz
Author URI: www.gabrielortizart.com 
Text Domain: resource-list

*/

//Exit if accessed directly
if(!defined( 'ABSPATH')){
    exit;
}

class resource_list{
    //kick off the class with constructor to load all files, enqueue scripts, set up dependencies
    public function __construct(){
        require_once( plugin_dir_path(__FILE__). 'includes/resource-lists-cpt.php' );
        $init_booklist_CTP = new resource_list_CPT();
        
        require_once( plugin_dir_path(__FILE__). 'includes/resource-lists-admin.php' );
        $init_booklist_admin = new resource_list_admin();
        
        require_once( plugin_dir_path(__FILE__). 'includes/resource-lists-fields.php' );
        $init_booklist_fields = new resource_list_fields();
        
        //enqueue admin scripts
        add_action( 'admin_enqueue_scripts', [$this, 'add_admin_scripts' ] );
    }
    
    //enqueue scripts 
    
    public function add_admin_scripts(){
        //add globals
        global $pagenow, $typenow;        
        
        if( ($pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'resource_list_item' ){
        //add custom script
            wp_enqueue_script(
                $handle   = 'fetch-api', 
                $src        = plugins_url('js/fetch-api.js', __FILE__), 
                $deps       = array('jquery'), //this tells wordpress that our JS file needs jquery
                $ver        = '06052017', 
                $in_footer  = true
                );
            
            //creates a object to be loaded when a script is loaded, makes accessible to
            wp_localize_script(
                $handle     = 'fetch-api',
                $name       = 'RESOURCE_LISTS_SETTINGS',
                $data       = array(
                                'google_api'        => get_option('google_api') ,
                                'catalog_url'       => get_option('catalog_url'),
                                'catalog_closing'   => get_option('closing_catalog_url'),
                                'siteURL'           => get_blogInfo('url'),
                                'loading'           => esc_url( admin_url() . '/images/loading.gif' )
                            )
            );
            
            wp_enqueue_style(
                $handle    = 'dwwp-admin-css',
                $src        = plugins_url('css/admin-lists.css', __FILE__)
            ); 
        }
    }
    
    
}

$init_resource_plugin = new resource_list();