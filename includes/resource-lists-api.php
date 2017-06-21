<?php

//Exit if accessed directly
if(!defined( 'ABSPATH')){
    exit;
}

class resource_list_API{
    
    /**
     * Kick-in the class
     */
    public function __construct(){
        
        //adding custom fields to rest API
        add_action('rest_api_init', [$this,'register_custom_fields']);        
    }
    
    public function register_custom_fields(){
        register_rest_field(
              $object_type  = 'resource_list_item',
              $attribute    = 'record_title',
              $args         = array(
                                    'get_callback' => [$this, 'show_fields']
                                )
            );
            
            
        register_rest_field(
              $object_type  = 'resource_list_item',
              $attribute    = 'record_author',
              $args         = array(
                                    'get_callback' => [$this, 'show_fields']
                                )
            );
            
        register_rest_field(
              $object_type  = 'resource_list_item',
              $attribute    = 'record_cover',
              $args         = array(
                                    'get_callback' => [$this, 'show_fields']
                                )
            );
            
        register_rest_field(
              $object_type  = 'resource_list_item',
              $attribute    = 'record_URL',
              $args         = array(
                                    'get_callback' => [$this, 'show_fields']
                                )
            );  
            
        register_rest_field(
              $object_type  = 'resource_list_item',
              $attribute    = 'record_isbn',
              $args         = array(
                                    'get_callback' => [$this, 'show_fields']
                                )
            );              
    }
    
    public function show_fields($object, $field_name, $request){
        return get_post_meta($object['id'], $field_name, true );
    }    
    
    
}