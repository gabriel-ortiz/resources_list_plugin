        <table class="form-table">
            <tr valign="top">
            <th scope="row">ISBN</th>
            <td>
    			<div class="meta-td">
    				<!--Here we are also creating the meta_id...-->
    				<input type="text" name="record_isbn" id="record_isbn" class="record_fields" value="<?php go_check_for_meta($meta_field='record_isbn', $stored_meta=$dwwp_stored_meta) ?>"/>
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
    				<input type="text" class="record_fields" name="record_title" id="record_title" value="<?php go_check_for_meta($meta_field='record_title', $stored_meta=$dwwp_stored_meta); ?>"/>
    			</div>                
            </td>
            </tr>
            
            <tr valign="top">
            <th scope="row">Author(s)</th>
            <td>
    			<div class="meta-td">
    				<input type="text" class="record_fields" name="record_author" id="record_author" value="<?php go_check_for_meta($meta_field='record_author', $stored_meta=$dwwp_stored_meta); ?>"/>
    			</div>                
                
            </td>
            </tr>
        
            <tr valign="top">
            <th scope="row">Record Cover</th>
            <td>
    			<div class="meta-td">
    				<input type="text" class="record_fields" name="record_author" id="record_cover" value="<?php go_check_for_meta($meta_field='record_cover', $stored_meta=$dwwp_stored_meta); ?>"/>
    			</div>                
            </td>
            </tr>                                  
            
            <tr valign="top">
            <th scope="row">Catalog URL</th>
            <td>
    			<div class="meta-td">
    				<input type="text" class="record_fields" name="record_URL" id="record_URL" value="<?php go_check_for_meta($meta_field='record_URL', $stored_meta=$dwwp_stored_meta); ?>"/>
    			</div>                
            </td>
            </tr>
        </table>