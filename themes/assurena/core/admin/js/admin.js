(function( $ ) {
    'use strict';

    jQuery(document).ready(function(){
        

        stl_accordion();
    });

})( jQuery );

function stl_accordion(){
    jQuery('body').on('click', '.stl_accordion_heading', function(e){
        e.preventDefault();
        var parent = jQuery(this).parent('.stl_accordion_wrapper');
        var body =  jQuery(parent).children('.stl_accordion_body');

        if(jQuery(parent).hasClass('open'))
        {
            jQuery(body).slideUp('fast');
            jQuery(parent).removeClass('open').addClass('close');
        } else {
            jQuery(body).slideDown('fast');
            jQuery(parent).removeClass('close').addClass('open');
        }
    });
}
