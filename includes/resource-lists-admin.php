<?php

/**
 * Admin Menu
 * https://www.sitepoint.com/create-a-wordpress-theme-settings-page-with-the-settings-api/
 */
class resource_list_admin {

    /**
     * Kick-in the class
     */
    public function __construct() {
        if( is_admin() ){
            //add submenu page
        add_action( 'admin_menu', array( $this, 'add_resourcelist_submenu' ) );
        
        //register settings
        add_action( 'admin_init', function(){
            register_setting('resource_list_options', 'google_api');
            register_setting('resource_list_options', 'catalog_url');
            register_setting('resource_list_options', 'closing_catalog_url');
            register_setting('resource_list_options', 'default_img_cover');            
            register_setting('resource_list_options', 'inst_name');            
        });
        
        //show 
        //add_filter( 'custom_menu_order', [$this, 'submenu_order' ] );            
            
        }
        
    }

public function add_resourcelist_submenu(){
    add_submenu_page(
        $parent_slug    = 'edit.php?post_type=resource_list_item',  
        $page_title     = 'Manage Generator List Settings',  
        $menu_title     = 'Resource List Settings',  
        $capability     = 'manage_options',  
        $menu_slug      = 'resourcelist',  
        //callback function
        function(){

            //Here's the settings content
            ?>
        	    <div class="wrap">
        	    <h1>Resource Lists Settings</h1>
            	    <form method="post" action="options.php">
            	        <?php
            	            settings_fields("resource_list_options");
            	            do_settings_sections("resource_list_options");
            	            
                        ?>
                            <table class="form-table">
                                <tr valign="top">
                                <th scope="row">Google API Key</th>
                                <td><input type="text" name="google_api" value="<?php echo esc_attr( get_option('google_api') ); ?>" /></td>
                                </tr>
                                 
                                <tr valign="top">
                                <th scope="row">Discovery Beginning URL</th>
                                <td><input type="text" name="catalog_url" value="<?php echo esc_attr( get_option('catalog_url') ); ?>" /></td>
                                </tr>
                                
                                <tr valign="top">
                                <th scope="row">Closing Discovery URL (if any)</th>
                                <td><input type="text" name="closing_catalog_url" value="<?php echo esc_attr( get_option('closing_catalog_url') ); ?>" /></td>
                                </tr>
                            
                                <tr valign="top">
                                <th scope="row">Default Image URL</th>
                                <td><input type="text" name="default_img_cover" value="<?php echo esc_attr( get_option('default_img_cover') ); ?>" /></td>
                                </tr>                                  
                                
                                <tr valign="top">
                                <th scope="row">Institution Name</th>
                                <td><input type="text" name="inst_name" value="<?php echo esc_attr( get_option('inst_name') ); ?>" /></td>
                                </tr>
                            </table>        	            
            	            <?php submit_button(); ?>
            	    </form>
        		</div>
	            
	       <?php


        });
}


public function submenu_order( $menu_order ) {
    # Get submenu key location based on slug
    global $submenu;

    // Enable the next line to see all menu orders
    echo '<pre>'.print_r($submenu,true).'</pre>'; 

    
}



} //end of class resource_list_admin