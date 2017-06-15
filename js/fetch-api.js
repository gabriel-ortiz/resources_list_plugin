jQuery(document).ready(function($){
    
    //cache global scoping
    var $this = this;
    
    //grab the DOM elements
    $this.search_api = $('#search_api');
    
    $this.record_title    = $('#record_title');
    $this.record_author   = $('#record_author');
    $this.record_cover    = $('#record_cover');
    $this.catalog_url     = $('#record_URL');    

    $this.isbn          = $("[name='record_isbn']");

    

    //set up google API variables
    $this.google_base = 'https://www.googleapis.com/books/v1/volumes?q=isbn%3A';
    $this.google_key = '&key=' + RESOURCE_LISTS_SETTINGS.google_api;
    
    
    //build up img element
    $this.preview_cover = $('<img />');
        $this.preview_cover.attr('src', $this.record_cover.val() );
        $this.preview_cover.attr('id', 'preview_image');    
    
    //check to see if image exists
    if( $this.record_cover != '') {
        //console.log('image detected', $this.record_cover);

        $this.preview_cover
            .hide()
            .insertAfter($this.record_cover)
            .fadeIn('1200');
    }

    //<img id="loading-animation" src="<?php echo esc_url( admin_url() . '/images/loading.gif' ); ?>" alt="loading"/>
    
    $this.loading_image = $('<img />');
        $this.loading_image.attr('id', 'loading-animation');
        $this.loading_image.attr('src', RESOURCE_LISTS_SETTINGS.loading);
        $this.loading_image.attr('alt', 'loading');
    
    
    $this.search_api.on('click', function(){
        //show loading image
        $this.loading_image.show();
        
        //grad the value of isbn
        $this.isbnValue = $this.isbn.val();
        console.log($this.isbnValue);     
        
        //setup catalog URL
        $this.record_path = RESOURCE_LISTS_SETTINGS.catalog_url + $this.isbnValue + RESOURCE_LISTS_SETTINGS.catalog_closing;
        
        $this.google_api = $this.google_base + $this.isbnValue + $this.google_key;
        
       $.ajax({
            url: $this.google_api,
            type: 'GET',
            dataType: 'jsonp',
            success: function(data){
                //hide loading image
                $this.loading_image.remove();
                
                if(data.totalItems > 0){
                    
                    var author_array = data.items[0].volumeInfo.authors;
                    author_array.join(', ');
                    
                    $this.record_title.val(data.items[0].volumeInfo.title);
                    $this.record_author.val(author_array);
                    $this.record_cover.val(data.items[0].volumeInfo.imageLinks.thumbnail);
                    $this.preview_cover.attr('src', data.items[0].volumeInfo.imageLinks.thumbnail );
                    $this.catalog_url.val($this.record_path);                
                    
                }else{
                    //alert('Sorry, no records found');
                    
                     $.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                "action": "test_function"
                            },
                            success: function(response){
                                var recordError = $('<div />',{
                                   'class': 'error',
                                   'text': 'Sorry no records were found. Bummer!',
                                   'css': {'padding': '10px'}
                                });
                                
                                $('.wp-heading-inline').after(recordError);
                                    setTimeout(function(){
                                        recordError.fadeOut(700, function(){
                                            this.remove();
                                        });
                                    }, 4000);
                            }
                        });                    
                }
                

                
            },
            fail: function(errorResponse){
                alert(errorResponse);
            }
       });
    });
});