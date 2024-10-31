<?php
// Creating the widget 
class rpz_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'rpz_widget', 

// Widget name will appear in UI
__('RPZ FB Like Box', 'rpz_widget_domain'), 

// Widget description
array( 'description' => __( 'Use this widget to add a facebook like box to your site.', 'rpz_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
$url =esc_attr(esc_url( get_option('rpz_url')) );
$fb_width =esc_attr(intval( get_option('rpz_fb_width') ));
$fb_height =esc_attr(intval( get_option('rpz_fb_height'))) ;
if ( function_exists('rpz_fb_form')){
echo rpz_fb_form($fb_width,$fb_height,$url);
}
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'facebook', 'rpz_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function rpz_load_widget() {
	register_widget( 'rpz_widget' );
}
add_action( 'widgets_init', 'rpz_load_widget' );
