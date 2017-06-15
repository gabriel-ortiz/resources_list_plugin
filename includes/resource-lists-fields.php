<?php

//Exit if accessed directly
if(!defined( 'ABSPATH')){
    exit;
}

//this class will set up and custom fields view to input record data

class resource_list_fields{
    
    /*
    HELPERS
    */
    
    //method that checks for data in the metapost, and then prints it if exists
    public static function go_check_for_meta($meta_field, $stored_meta){
    	if(!empty($stored_meta[$meta_field])){ 
    		echo esc_attr( $stored_meta[$meta_field][0]);
    	}
    }
    
  

    //initialize all the hooks into the core
    public function __construct(){

    //set up metaboxes
    add_action('add_meta_boxes', [$this, 'add_custom_metaboxes'] );  
    
    //update post title
    add_filter( 'wp_insert_post_data' , [$this, 'modify_post_title'] , '99', 1 );    
    
    //save fields
    add_action('save_post', [$this, 'resource_meta_save'] ); 
    
    //add alert message
    add_action('wp_ajax_test_function', [$this, 'resource_alert'] );
  
    }

    //set up meta box with title, post_type, and callback
    public function add_custom_metaboxes(){
        //add the action for setting up meta boxes
        add_meta_box(
            $id         = 'resource_meta',
            $title      = __('Resource Record'),
            $callback   = [$this, 'meta_resource_fields'],
            $post_type  = 'resource_list_item'
            );
    }
    
    public function meta_resource_fields($post){

	//pass in the post variable which gives us access to all Wordpress data
	//set up once
	wp_nonce_field(basename(__FILE__), 'resource_list_nonce');
	
	//get stored data for the metadata
	$record_stored_meta = get_post_meta($post->ID );
	
	//var_dump($record_stored_meta);
	//die();
	//if(!empty($record_stored_meta['job_id'])) { echo esc_attr( $record_stored_meta['job_id'][0] ); }
        ?>
        <div id="record_meta">
            <table class="form-table">
                <tr valign="top">
                <th scope="row">ISBN</th>
                <td>
        			<div class="meta-td">
        				<!--Here we are also creating the meta_id...-->
        				<input type="text" name="record_isbn" id="record_isbn" class="record_fields" value="<?php go_check_for_meta($meta_field='record_isbn', $stored_meta=$record_stored_meta) ?>"/> <button class="button btn" type="button" id="search_api">Search API</button>
        				<p>Insert an ISBN to retrieve bibliographic data for this record</p>
        			</div>  
        			
            		<div class="record-sep">
            		    <hr />
            		    <p>OR - Enter Bibliographic data manually</p>
            		</div>                
                </td>
                </tr>
                 
                <tr valign="top">
                <th scope="row">Title</th>
                <td>
        			<div class="meta-td">
        				<input type="text" class="record_fields" name="record_title" id="record_title" value="<?php go_check_for_meta($meta_field='record_title', $stored_meta=$record_stored_meta); ?>"/>
        			</div>                
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row">Author(s)</th>
                <td>
        			<div class="meta-td">
        				<input type="text" class="record_fields" name="record_author" id="record_author" value="<?php go_check_for_meta($meta_field='record_author', $stored_meta=$record_stored_meta); ?>"/>
        			</div>                
                    
                </td>
                </tr>
            
                <tr valign="top">
                <th scope="row">Record Cover</th>
                <td>
        			<div class="meta-td">
        				<input type="text" class="record_fields" name="record_cover" id="record_cover" value="<?php go_check_for_meta($meta_field='record_cover', $stored_meta=$record_stored_meta); ?>"/>
        			</div>                
                </td>
                </tr>                                  
                
                <tr valign="top">
                <th scope="row">Catalog URL</th>
                <td>
        			<div class="meta-td">
        				<input type="text" class="record_fields" name="record_URL" id="record_URL" value="<?php go_check_for_meta($meta_field='record_URL', $stored_meta=$record_stored_meta); ?>"/>
        			</div>                
                </td>
                </tr>
            </table>
        </div><!--end of div-->
        
        <?php
    }//end of meta_resource_fields
    
    //need to include $post_id
    public function resource_meta_save($post_id){
    	//checks save status
    	$is_autosave = wp_is_post_autosave( $post_id );
    	$is_revision = wp_is_post_revision( $post_id );
    	$is_valid_nonce = (isset( $_POST['resource_list_nonce'] ) && wp_verify_nonce( $_POST['resource_list_nonce'], basename(__FILE__) ) ) ? 'true': 'false';
    	
    	//exists script depending on save status
    	//if any of these are set, then it will exit
    	if( $is_autosave || $is_revision || !$is_valid_nonce){
    		return;
    	}
    	
    	// if(isset( $_POST['job_id'] ) ){
    	// 	update_post_meta( $post_id , 'job_id', sanitize_text_field( $_POST['job_id'] ) );
    	// }
    	
    	
    	if( isset($_POST['record_isbn'])){
        	update_post_meta($post_id=$post_id, $meta_id='record_isbn', sanitize_text_field($_POST['record_isbn'] ) );   	    
    	}

        if( isset( $_POST['record_title'] ) ){
     	    update_post_meta($post_id=$post_id, $meta_id='record_title', sanitize_text_field( $_POST['record_title'] ) );           
        }
    
        if( isset( $_POST['record_author'] ) ){
     	    update_post_meta($post_id=$post_id, $meta_id='record_author', sanitize_text_field( $_POST['record_author'] ) );           
        }

        if( isset($_POST['record_cover']) ){
        	update_post_meta($post_id=$post_id, $meta_id='record_cover', sanitize_text_field( $_POST['record_cover'] ) );            
        }
    	
        if( isset( $_POST['record_URL'] ) ){
    	    update_post_meta($post_id=$post_id, $meta_id='record_URL', sanitize_text_field( $_POST['record_URL'] ) );	            
        }
    	
    	
    }    
    
public function modify_post_title( $data ){
  if($data['post_type'] == 'resource_list_item' && isset($_POST['record_title'])) { // If the actual field name of the rating date is different, you'll have to update this.
    $data['post_title'] =  $_POST['record_title'];
  }
  return $data; // Returns the modified data.
}  


//alert message



function resource_alert() {
    add_action('admin_notices', 'my_error_notice');
}

function my_error_notice () {
    // global $my_admin_page;
    // $screen = get_current_screen();
    // if ( $screen->id == $my_admin_page ) {
    //         echo '<div class="error"><p>This is my error message.</p></div>';
    //     } else {
    //   return;
    //     }
    echo "this is an error message";
}

    
}//end of resource_list_fields class