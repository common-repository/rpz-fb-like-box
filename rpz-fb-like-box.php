<?php
/**
 * Plugin Name: rpz fb like box
 * Plugin URI: http://roopeshcheruvathur.in
 * Description: This plugin adds some Facebook like box in post,page, widgets etc.
 * Version: 1.0.0
 * Author: Roopesh Cheruvathur
 * Author URI: http://roopeshcheruvathur.in
 * License: RPZ_LICENSE
 */

 
 
define("RPZ_PLUGIN_DIR", __file__);
define("RPZ_PLUGIN_BASE", dirname(__file__));

 //Allows shortcodes in theme
 
 
add_filter('widget_text', 'do_shortcode');
add_action('admin_menu', 'rpz_fb_menu');


function rpz_fb_menu() {
	add_menu_page('RPZ fb like box', 'RPZ fb like box', 'administrator', 'RPZ_fb_like_box', 'rpz_settings_page',  plugin_dir_url(__FILE__) . 'images/icon.png');
}

function rpz_settings_page() {
?>
<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
<div class="wrap">
<h2><?php _e( 'RPZ Like BOX', 'rpz-fb-like-box' ) ?></h2>
<div id="postbox-container-1" class="postbox-container">
	<div class="postbox">
	<div class="inside">
	
	 <?php
                if (isset($_GET['settings-updated'])) {
                    echo '<div class="updated bellow-h2 notice notice-success is-dismissible"><p> Settings updated.</p></div>';
                }
                ?>

	<form method="post" action="options.php">
    <?php settings_fields( 'rpz_settings_group' ); ?>
    <?php do_settings_sections( 'rpz_settings_group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Url</th>
        <td><input type="text" name="rpz_url" value="<?php echo esc_attr(esc_url( get_option('rpz_url')) ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">width</th>
        <td><input type="text" name="rpz_fb_width" value="<?php echo esc_attr(intval( get_option('rpz_fb_width') )); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Height</th>
        <td><input type="text" name="rpz_fb_height" value="<?php echo esc_attr(intval( get_option('rpz_fb_height'))) ; ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
	
	
	
	</div>
</div>
<div class="postbox">
<div class="inside">
<div class="">
          <div id="icon-options-general" class="icon32"><br></div>
<h3 class="hndle ui-sortable-handle">Description</h3>
<p>Thank you for using the Rpz fb like box WordPress Plugin.
This is a very small and simple plugin which has one shortcode .
The shortcode is <b><code>[rpz-fb-like-box] </code></b>and you can specify the following parameters:
<ul>
<li>width - the width of the box</li>
<li>height - the height of the box</li>
<li>url - facebook page url</li>

</ul>
</p>1. Use this short code in your page, post etc.
<p><h4>shortcode : <b><code>[rpz-fb-like-box] </code></b></h4> 

2. Go to <b>Dashboard->Appearance->Widget.</b></br> From widget list choose "<b>RPZ FB Like Box</b>" and drag in to your widget or footer.</p>
</div></div></div></div>


</div></div></div>
<?php
}

add_action( 'admin_init', 'RPZ_fb_like_box' );

function RPZ_fb_like_box() {
	register_setting( 'rpz_settings_group', 'rpz_url' );
	register_setting( 'rpz_settings_group', 'rpz_fb_width' );
		register_setting( 'rpz_settings_group', 'rpz_fb_height' );
	
}
add_action('init', 'rpz_fb_shortcodes');
function rpz_fb_shortcodes() {
  add_shortcode('rpz-fb-like-box', 'rpz_code_html');
}
function rpz_code_html( $attr ){
	

$url =esc_attr(esc_url( get_option('rpz_url')) );
$fb_width =esc_attr(intval( get_option('rpz_fb_width') ));
$fb_height =esc_attr(intval( get_option('rpz_fb_height'))) ;

  extract(shortcode_atts(array('width' => $fb_width,'height' =>$fb_height,'link'=>$url), $atts, 'rpz-fb-like-box'));
  return rpz_fb_form($width, $height,$link);
}



function rpz_fb_form($width, $height,$link){
  $formwidth= $width - 50;

  $html ="
  <div id='fb-root'></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <div class='fb-page' data-href='" . $link."' data-tabs='timeline'data-height='" .$height . "' datawidth='" .$width . "' data-small-header='false' data-adapt-container-width='true' data-hide-cover='false' data-show-facepile='true'><blockquote cite='https://www.facebook.com/facebook' class='fb-xfbml-parse-ignore'><a href='https://www.facebook.com/facebook'>Facebook</a></blockquote></div>
  ";
  
 

  return $html;
}
include_once(RPZ_PLUGIN_BASE . '/widget/rpz_widget.php');
