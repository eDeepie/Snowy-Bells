jQuery(document).ready(function($){
function media_upload(button_class) {
            var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
            jQuery('body').on('click',button_class, function(e) {
            var button_id ='#'+jQuery(this).attr('id');
           // console.log(button_id);
            var self = jQuery(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = jQuery(button_id);
            var id = button.attr('id').replace('_button', '');
            //console.log(id);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if (_custom_media) {
                  //jQuery('#ctb_image_id').val(attachment.id);
                   jQuery('#video_url').val(attachment.url);
                   //jQuery('#ctb_image_pic').attr('src',attachment.url).css('display','block');                                              
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(button);
            return false;
        });
    }
    media_upload('#upload-btn'); 
});
