/**
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
jQuery(document).ready(function() {
	jQuery('.controls#singleapp-img-container li img').click(function(){
		jQuery('.controls#singleapp-img-container li').each(function(){
			jQuery(this).find('img').removeClass ('singleapp-radio-img-selected') ;
		});
		jQuery(this).addClass ('singleapp-radio-img-selected') ;
	});

    //social icon
    jQuery('input:checkbox').change(function(){
        if(jQuery(this).is(":checked")) {
            jQuery('div.tg-social-wrap').addClass("tg-social-show");
        } else {
            jQuery('div.tg-social-wrap').removeClass("tg-social-show");
        }
    });

    if(jQuery('input:checkbox').is(":checked")) {
            jQuery('div.tg-social-wrap').addClass("tg-social-show");
        } else {
            jQuery('div.tg-social-wrap').removeClass("tg-social-show");
        }
});

// image uploader
jQuery( document ).ready( function( $ ) {

    var file_frame;

    $( document.body ).on( 'click', '.custom_media_upload', function( event ) {
        var $el = $( this );

        var file_target_input   = $el.parent().find( '.custom_media_input' );
        var file_target_preview = $el.parent().find( '.custom_media_preview' );

        event.preventDefault();

        // Create the media frame.
        file_frame = wp.media.frames.media_file = wp.media({
            // Set the title of the modal.
            title: $el.data( 'choose' ),
            button: {
                text: $el.data( 'update' )
            },
            states: [
                new wp.media.controller.Library({
                    title: $el.data( 'choose' ),
                    library: wp.media.query({ type: 'image' })
                })
            ]
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // Get the attachment from the modal frame.
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();

            // Initialize input and preview change.
            file_target_input.val( attachment.url );
            file_target_preview.css({ display: 'none' }).find( 'img' ).remove();
            file_target_preview.css({ display: 'block' }).append( '<img src="' + attachment.url + '" style="max-width:100%">' );
        });

        // Finally, open the modal.
        file_frame.open();
    });

    // Media Uploader Preview
    $( 'input.custom_media_input' ).each( function() {
        var preview_image  = $( this ).val(),
            preview_target = $( this ).siblings( '.custom_media_preview' );

        // Initialize image previews.
        if ( preview_image !== '' ) {
            preview_target.find( 'img.custom_media_preview_default' ).remove();
            preview_target.css({ display: 'block' }).append( '<img src="' + preview_image + '" style="max-width:100%">' );
        }
    });
});


// color picker
(function ($) {
function initColorPicker(widget) {
   widget.find('.tg-color-picker').wpColorPicker({
      change: _.throttle(function () { // For Customizer
         $(this).trigger('change');
      }, 3000)
   });
}
function onFormUpdate(event, widget) {
   initColorPicker(widget);
}
$(document).on('widget-added widget-updated', onFormUpdate);

$(document).ready(function () {
   $('#widgets-right .widget:has(.tg-color-picker)').each(function () {
      initColorPicker($(this));
   });
});
}(jQuery));
