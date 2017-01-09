<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vanilla Widget class.
 *
 * Implements a general-purpose widget, mainly (but not necessarily!) intended to be
 * used in combination with ACF plugin.
 *
 * @version 1.0
 * @author  Nevma - Creative know-how
 * @extends WP_Widget
 */
if ( ! class_exists( 'Vanilla_Widget' ) ) {

	abstract class Vanilla_Widget extends WP_Widget {

		/**
		 * Class constructor.
		 */
		function __construct() {

			// The name of the class that the user ended up creating by dynamically extending this class
			$child_class = get_called_class();

			$widget_id = strtolower( $child_class );
			$widget_name = $child_class;

			parent::__construct(
				$widget_id,
				str_ireplace( '_', ' ', $widget_name ),
				array( 'description' => __( 'A general purpose widget customisable via ACF.', 'nevma-theme' ), )
			);
		}

		/**
		 * Displays the widget's output on the front-end.
		 * 
		 * @param  array $args The widget args, passed by WordPress.
		 * @param  array $instance The widget's instance, passed by WordPress.
		 */
		public function widget( $args, $instance ) {

			// Before and after widget arguments are defined by themes
			echo $args['before_widget'];

			$title = apply_filters( 'widget_title', $instance['title'] );
			
			if ( ! empty( $title ) ) {

				// Before and after title arguments are defined by themes
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$user_callback = static::$vanilla_callback;

			$widget_id = $args['widget_id'];

			if ( function_exists( $user_callback) ) {

				call_user_func( $user_callback, $widget_id );

			} else {

				echo '<p>' . __( 'Callback function does not exist.', 'nevma-theme' ) . '</p>';
			}

			// Before and after widget arguments are defined by themes
			echo $args['after_widget'];
		}

		/**
		 * Displays the markup for the widget back-end.
		 * 
		 * @param  array $instance The widget instance.
		 */
		public function form( $instance ) {

			// Display the title if set, or a default one otherwise.
			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>

				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<?php
		}
		 
		/**
		 * Sanitizes the new widget settings during update.
		 * 
		 * @param  array $new_instance The new widget instance.
		 * @param  array $old_instance The old widget instance, prior to updating.
		 * @return array|bool The new instance, sanitized.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = array();

			$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';

			return $instance;
		}

		/**
		 * Registers the widget in WordPress.
		 */
		public static function register() {

			// Invoke the child class at registration!
			register_widget( get_called_class() );
		}
		
	} // Class definition

} // class_exists

/**
 * Registers a new Vanilla Widget
 * 
 * @param  string $widget_name A unique widget name, containing only alphanumeric
 * characters and underscores.
 * @param  string $callback A valid PHP callback to display the widget output. The
 * widget id will be passed to it.
 * @return bool True on success, or false if the class already exists, or the widget
 * name is invalid.
 */
function vanilla_widgets_register( $widget_name, $callback ) {

	$class_name = 'Vanilla_Widget_' . $widget_name;

	if ( class_exists( $class_name ) ) {

		return false;
	}

	/**
	 * @todo Make sure you've done some really damn good validation of the widget name
	 * at this point!
	 */
	
	// Get the actual Vanilla_Widget child-class declaration by customizing the boilerplate.
	$class_declaration = vanilla_widgets_get_class_declaration( $class_name, $callback );

	// Create the class by evaluating the declaration.
	eval( $class_declaration );

	// Schedule the registration of the widget.
	add_action( 'widgets_init', array( $class_name, 'register' ) );
}

/**
 * Creates and returns the proper declaration of a widget class that extends
 * Vanilla_Widget.
 * 
 * @param  string $class_name The class name.
 * @param  string $callback A valid PHP callback.
 * @return string The class declaration.
 */
function vanilla_widgets_get_class_declaration( $class_name, $callback ) {

	ob_start();

	?>

		if ( ! class_exists( '<?php echo $class_name; ?>' ) ) {

			class <?php echo $class_name; ?> extends Vanilla_Widget {

				// Hold the callback as a protected class member, used by Vanilla_Widget class.
				protected static $vanilla_callback = '<?php echo $callback; ?>';

				function __construct() {

					parent::__construct();
				}

			} // Class definition

		} // class_exists

	<?php

	return ob_get_clean();
}

?>