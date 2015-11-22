<?php
/*
Plugin Name: Bize RDStation Form
Description: Widget para Wordpress para criar um formulário de subscribe no wordpress.
*/

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
	parent::__construct(
        'bize_rdstation_form',
        __( 'Bize RDStation Form', 'bize_rdstation_form' ),
        array(
            'classname'   => 'bize_rdstation_form',
            'description' => __( 'Widget para Wordpress para criar um formulário de subscribe no wordpress.', 'bize_rdstation_form' )
        )
    );
}

// Front-end
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];

	echo '
	  <p>'.$instance['call_text'].'</p>
		<form class="bize-rdstation">
			<div class="input-group col-md-12">
				<label for="nome">Nome:</label>
				<input type="text" class="form-control nome" value="" name="nome" id="nome" placeholder="">
			</div>
			<div class="input-group col-md-12">
				<label for="email">E-mail:</label>
				<input type="email" class="form-control email" value="" name="email" id="email" placeholder="">
			</div>
			<div class="input-group col-md-12">
				<button type="button" class="submit btn btn-default">'.$instance['cta'].'</button>
			</div>
			<input type="hidden" class="token" value="'.$instance['integration_key'].'">
			<input type="hidden" class="conversion_id" value="'.$instance['conversion_id'].'">
		</form>
    ';

	echo $args['after_widget'];
}
		
// Widget settings (back-end)
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	}else {
		$title = __( 'Título', 'bize_rdstation_form' );
	}
	if ( isset( $instance[ 'call_text' ] ) ) {
		$call_text = $instance[ 'call_text' ];
	}else {
		$call_text = __( 'Cadastre seu e-mail para receber as nossas novidades.', 'bize_rdstation_form' );
	}
	if ( isset( $instance[ 'integration_key' ] ) ) {
		$integration_key = $instance[ 'integration_key' ];
	}else {
		$integration_key = __( '', 'bize_rdstation_form' );
	}
	if ( isset( $instance[ 'conversion_id' ] ) ) {
		$conversion_id = $instance[ 'conversion_id' ];
	}else {
		$conversion_id = __( '', 'conversion_id' );
	}
	if ( isset( $instance[ 'cta' ] ) ) {
		$cta = $instance[ 'cta' ];
	}else {
		$cta = __( 'Quero receber!', 'cta' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'call_text' ); ?>"><?php _e( 'Texto de chamada:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'call_text' ); ?>" name="<?php echo $this->get_field_name( 'call_text' ); ?>" type="text" value="<?php echo esc_attr( $call_text ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'integration_key' ); ?>"><?php _e( 'Token de Integração do RDStation:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'integration_key' ); ?>" name="<?php echo $this->get_field_name( 'integration_key' ); ?>" type="text" value="<?php echo esc_attr( $integration_key ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'conversion_id' ); ?>"><?php _e( 'Identificador da conversão:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'conversion_id' ); ?>" name="<?php echo $this->get_field_name( 'conversion_id' ); ?>" type="text" value="<?php echo esc_attr( $conversion_id ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'cta' ); ?>"><?php _e( 'Call to action (botão):' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'cta' ); ?>" name="<?php echo $this->get_field_name( 'cta' ); ?>" type="text" value="<?php echo esc_attr( $cta ); ?>" />
	</p>
<?php 
}
	
	// Updating widget settings replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['call_text'] = ( ! empty( $new_instance['call_text'] ) ) ? strip_tags( $new_instance['call_text'] ) : '';
		$instance['integration_key'] = ( ! empty( $new_instance['integration_key'] ) ) ? strip_tags( $new_instance['integration_key'] ) : '';
		$instance['conversion_id'] = ( ! empty( $new_instance['conversion_id'] ) ) ? strip_tags( $new_instance['conversion_id'] ) : '';
		$instance['cta'] = ( ! empty( $new_instance['cta'] ) ) ? strip_tags( $new_instance['cta'] ) : '';
		return $instance;
	}
}

	// Register and load the widget
	function wpb_load_widget() {
		register_widget( 'wpb_widget' );
	}
	add_action( 'widgets_init', 'wpb_load_widget' );

	function add_js(){
		wp_enqueue_script('rdstation', plugin_dir_url( __FILE__ ) . 'rd-js-integration.min.js', array(), '1.0.0', false);
		wp_enqueue_script('bize-rdstation-script', plugin_dir_url( __FILE__ ) . 'bize-rd.js', array('jquery', 'rdstation'));
	}
	add_action('wp_enqueue_scripts', 'add_js');
?>