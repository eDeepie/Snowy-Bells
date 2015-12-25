<?php
/*
Plugin Name: Snowy Bells
Plugin URI: www.edeepie.com
Description: This plugin will enable a snowfall effect on your Wordpress website. Also, there's an option to upload a Christmas track to amuse visitors on your Wordpress website.
Version: 1.0
Author: eDeepie
Author URI: contact@edeepie.com
License: GPL2
*/
add_action('admin_menu','snowchristmas_menu');
add_action('wp_enqueue_scripts','wpb_adding_scripts'); 
add_action('admin_enqueue_scripts','load_wp_media_files');
add_filter('wp_footer','christmasPlayer');
add_filter('admin_footer_text','snowybells_footer');
if(!function_exists('snowybells_footer')){
function snowybells_footer(){
echo '<a href="#">Snowy Bells</a>version 1.0 by<a href="http://www.edeepie.com">eDeepie</a>&nbsp&nbsp
<a href="http://edeepie.com/contact">Contact Us</a>&nbsp&nbsp Follow on : 
<a href="https://www.facebook.com/myEdeepie/">Facebook</a>&nbsp&nbsp<a href="https://twitter.com/eDeepie">Twitter</a>&nbsp&nbsp
<a href="https://www.linkedin.com/company/edeepie">LinkedIn</a>&nbsp&nbsp<a href="https://plus.google.com/u/0/+Edeepie/about">Google+</a> ';
}   
}
function plugin_activate() {

   update_option('snow_enable', 1);
     update_option('audio_enable', 1 );
    update_option('sb_bgaudio', plugins_url('audio/jinglebell.mp3',__FILE__));
}
register_activation_hook( __FILE__, 'plugin_activate' );
register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
function myplugin_activate() {
    remove_option('snow_enable');
    remove_option('audio_enable');
    remove_option('sb_bgaudio');
}
function wpb_adding_scripts(){
    if(get_option('snow_enable') == 1){
       wp_register_script('snowstorm', plugins_url('js/snowstorm-min.js', __FILE__), array('jquery'),'1.0.0', true);
       wp_enqueue_script('snowstorm');
}
    if(get_option('audio_enable') == 1){
      wp_register_script('snowplugin', plugins_url('js/snowplugin.js', __FILE__), array('jquery'),'1.0.0', true);
      wp_enqueue_script('snowplugin');
   }
}
function load_wp_media_files(){
    wp_enqueue_media();
    wp_register_script('snowadmin',plugins_url('js/admin.js', __FILE__), array('jquery','thickbox','media-upload') ,'1.0.0', true);
    wp_enqueue_script('snowadmin');
}
//audio section of the front end
function christmasPlayer(){ 
    if(get_option('audio_enable') == 1){ 
       $playAuto = 'autoplay';
    }
    else{
        $playAuto="";
    }
?>
    <div>
        <?php if(get_option('audio_enable') == 1){ ?>
            <img id="player" style="position:fixed; bottom:0; z-index:200; left:0;" src="<?php echo plugins_url('/images/play.png', __FILE__); ?>" />
            <?php } ?>
                <audio loop id="audio" controls <?php echo $playAuto; ?> style="display:none !important ;">
                    <?php 
if(get_option('sb_bgaudio') && get_option('sb_bgaudio') != "") { 
  echo '<source src="'.get_option('sb_bgaudio').'" type="audio/mpeg">';
}else{
 echo "<source src='".plugins_url('audio/jinglebell.mp3',__FILE__)."' type='audio/mpeg'>";
} 
?>
                </audio>
    </div>
    <?php
}
function snowchristmas_menu(){
 add_menu_page('snowybells','Snowy Bells','manage_options','Snowy_Bells','snowchristmas_options_page');
}
function snow_enabled($check_state){

// if check box is checked
  if(get_option('snow_enable')){          
     if(get_option('snow_enable') == $check_state){ echo 'checked="checked"';}
      else{ echo ""; }
   }   
}
function audio_enabled($check_state){
 // if check box is checked
   if(get_option('audio_enable')){          
     if(get_option('audio_enable') == $check_state){ echo 'checked="checked"';}
      else{ echo ""; }
    }   
}
function getAudioFile(){
 if(get_option('sb_bgaudio') && get_option('sb_bgaudio') != ""){ echo get_option('sb_bgaudio');}
 else{ echo plugins_url('audio/jinglebell.mp3',__FILE__); }
}
// section to view setting page on admin panel
function snowchristmas_options_page(){
  if(current_user_can('manage_options')){       
?>
<div class="wrap">
<?php 
if(isset($_POST['save_settings'])){     
            $snow_state = $_POST['snowEffectEnable'];
            $audio_state = $_POST['audioeffectenable'];
           $audioFile = $_POST['video_url'];
           update_option('snow_enable',$snow_state);
           update_option('audio_enable',$audio_state);
           update_option('sb_bgaudio',$audioFile); 
?>    
<div style="width:100%; float:left; background-color:#FFFFFF; height:auto; padding:15px 5px; border-left:5px solid #00fa9a;" id="msg">
Settings saved Successfully !!! 
</div>
<script>
  setTimeout(function(){ 
      document.getElementById('msg').style.display='none';
   }, 3000);    
</script>    
 <?php } ?>           
            <div style="float:left; width:100%; height:auto;">
                <h1 style="color:#FF0000;">Merry Christmas!!!</h1>
                <br/>
                <h2>Welcome to Snowy Bells Plugin Settings</h2>
                <br/>
            </div>
            <div style="float:left; width:100%; height:auto;">
                <table class="widefat" style="background-color:transparent; width:auto;">
                    <form method="post">
                        <tr>
                            <th><strong>Snowfall Effect Settings</strong></th>
                        </tr>
                        <tr class="row">
                            <td>Enable Snow Effect</td>
                            <td>
                                <input type="checkbox" name="snowEffectEnable" value="1" <?php snow_enabled( '1'); ?>/></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <th><strong>Audio Player Settings</strong></th>
                        </tr>
                        <tr>
                            <td>Enable Audio Effect</td>
                            <td>
                                <input type="checkbox" name="audioeffectenable" value="1" <?php audio_enabled( '1'); ?>/></td>
                        </tr>
                        <tr>
                            <td>Upload New Audio*</td>
                            <td>
                                <input type="text" name="video_url" id="video_url" value="<?php getAudioFile(); ?>">
                                <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Audio">
                                <br>Supports only mp3 format.
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>*Note :- Use this option to override default audio track.</td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="save_settings" class="button button-primary" value="<?php esc_attr_e('Save'); ?>">
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
        <?php
}
} 
?>