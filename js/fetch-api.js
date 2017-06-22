
( function( window, $ ) {
	'use strict';
	var document = window.document;

    var api_data = {};
    
    api_data.init = function(){
        
            //cach this with init
            var init = this;
            
            //grab the DOM elements
            init.search_api = $('#search_api');
        
            init.record_title  = $('#record_title');
            init.record_author = $('#record_author');
            init.record_cover  = $('#record_cover');
            init.catalog_url   = $('#record_URL');
        
            init.isbn          = $("[name='record_isbn']");
        
        
        /*
                VARIABLES AND HTML OBJECTS 
        */
            //set up google API variables
            init.google_base = 'https://www.googleapis.com/books/v1/volumes?q=isbn%3A';
            init.google_key = '&key=' + RESOURCE_LISTS_SETTINGS.google_api;
            
            //build up img element
            init.preview_cover = $('<img />');
                init.preview_cover.attr('src', init.record_cover.val());
                init.preview_cover.attr('id', 'preview_image');
        
            //check to see if image exists
            if (init.record_cover.val().length !== 0) {
                console.log('image detected', init.record_cover.val());
        
                init.preview_cover
                    .hide()
                    .insertAfter(init.record_cover)
                    .fadeIn('700');
            }
        
            init.loading_image = $('<img />');
                init.loading_image.attr('id', 'loading-animation');
                init.loading_image.attr('src', RESOURCE_LISTS_SETTINGS.loading);
                init.loading_image.attr('alt', 'loading'); 
                
        /*
            FUNCTIONS
        */
            init.fetch_api_data = function() {
                //show loading image
                init.loading_image.show();
        
                //grad the value of isbn
                init.isbnValue = init.isbn.val();
                console.log(init.isbnValue);
        
                //setup catalog URL
                init.record_path = RESOURCE_LISTS_SETTINGS.catalog_url + init.isbnValue + RESOURCE_LISTS_SETTINGS.catalog_closing;
        
                init.google_api = init.google_base + init.isbnValue + init.google_key;
        
                $.ajax({
                    url: init.google_api,
                    type: 'GET',
                    dataType: 'jsonp',
                    success: function(data) {
                        //SUCCESS!
        
                        //hide loading image
                        init.loading_image.remove();
        
                        if (data.totalItems > 0) {
        
                            var author_array = data.items[0].volumeInfo.authors;
                            author_array.join(', ');
        
                            init.record_title.val(data.items[0].volumeInfo.title);
                            init.record_author.val(author_array);
                            init.record_cover.val(data.items[0].volumeInfo.imageLinks.thumbnail);
        
                            init.preview_cover
                                .attr('src', data.items[0].volumeInfo.imageLinks.thumbnail)
                                .hide()
                                .insertAfter(init.record_cover)
                                .fadeIn('1200');
        
                            //init.preview_cover.attr('src', data.items[0].volumeInfo.imageLinks.thumbnail );
                            init.catalog_url.val(init.record_path);
        
                        }
                        else {
                            //no results found
                            $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    "action": "test_function"
                                },
                                success: function(response) {
                                    var recordError = $('<div />', {
                                        'class': 'error',
                                        'text': 'Sorry no records were found. Bummer!',
                                        'css': {
                                            'padding': '10px'
                                        }
                                    });
        
                                    $('.wp-heading-inline').after(recordError);
                                    setTimeout(function() {
                                        recordError.fadeOut(700, function() {
                                            this.remove();
                                        });
                                    }, 3000);
                                }
                            });
                        }
        
                    },
                    //error with the search
                    fail: function(errorResponse) {
                        alert(errorResponse);
                    }
                });
            };//end of fetch api function
    
        /*
        EVENTS  
    */    
    
        //disable wordpress's enter to save function
        init.isbn.on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                //cancel carriage return
                e.preventDefault();
                
                init.fetch_api_data();
                return false;
                
    
            }
        });
    
        init.search_api.on('click', function() {
            init.fetch_api_data();
        });   

    console.log('this is working, success!!!');
    };


    //start the function
    $(document).ready(function(){
        api_data.init();
    });

} )( this, jQuery );
