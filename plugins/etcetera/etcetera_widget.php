<?php
class Etcetera_Real_Estate_Filter extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'etcetera-real-estate-filter',
			'Real Estate Filter'
		);
		
		add_action( 'widgets_init', function() {
			register_widget( 'Etcetera_Real_Estate_Filter' );
		});

		add_filter( 'acf/prepare_field', function( $field ) {
			if ( is_admin() ) return $field;
			
			$field['required'] = false;
			
			$name = $field['_name'];
			$field['name'] = "acf[$name]";

			if ( $name == 'square' ) {
// 				$field['type'] = 'range';
				$field['label'] = esc_html__('Square (m&#xb2;), up to', 'etc');
			}
			
			return $field;
		} );
	}

	private function get_form() {
		ob_start();
		acf_form( array(
			'id' => 'etcetera-form',
			'form_attributes' => array( 
				'class' => 'etcetera-form',
			),
			'field_groups' => array( 'group_67f0c7410fe37', 'group_67f0c6e0388f6' ),
			'submit_value' => esc_html__( 'Search', 'etc' ),
			'html_after_fields' => '<button id="clear-all">' . esc_html__( 'Clear', 'etc' ) . '</button>',
		) );
		return ob_get_clean();
	}
	
	public $args = array(
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget'  => '</div></div>',
	);

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		echo '<div class="etcetera-form-container">';
		echo esc_html__( $instance['text'], 'text_domain' );
		echo $this->get_form();

		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'etc' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}	
}
$etcetera_real_estate_widget = new Etcetera_Real_Estate_Filter();

class Estate_List {	
	public function __construct() {
		add_filter( 'estate_query', array( $this, 'ecology_first' ), 99 );

		add_action( 'wp_ajax_load_real_estate', array( $this, 'load_real_estate' ) );
		add_action( 'wp_ajax_nopriv_load_real_estate', array( $this, 'load_real_estate' ) );
		
		add_shortcode( 'estate_filter', array( $this, 'estate_shortcode' ) );
	}
	
	function ecology_first( $query ) {
		if ( $query['post_type'] == 'real_estate_object' ) {
			$query['meta_key'] = 'environmental';
			$query['orderby'] = 'meta_value_num';
		}
		return $query;
	}
	
	private function render( $query ) {		
		$estates = get_posts( $query );

		$query_for_all = $query;
		$query_for_all['numberposts'] = -1;
		unset ( $query_for_all['offset'] );
		$all_estates = get_posts( $query_for_all );
// 		echo '<pre>'.print_r($query_for_all,true).'</pre>';

		if ( empty( $estates ) ) {
			return json_encode( array( 
				'html' => esc_html__( 'No objects found', 'etc' ), 
				'total' => count($all_estates) 
			) );
		}
		
		foreach ( $estates as $item ) {
			$id = $item->ID;
			$name = get_field( 'name', $id );
			$permalink = get_permalink( $id );
			
			$html .= '<li>';
			$html .= wp_get_attachment_image( esc_attr( get_field( 'photo', $id ) ), 'thumbnail' );
			$html .= "<div class='estate-info'>";
			$html .= "<h4><a href='$permalink'>$name</a></h4>";
			$html .= "<div>{$item->post_excerpt}</div>";
			$html .= "<a class='read-more' href='$permalink'>" . esc_html( 'Read more', 'etc' ) . '</a>';
			$html .= "</div>";
			$html .= '</li>';
		}
		return json_encode( array( 'html' => $html, 'total' => count($all_estates) ) );
	}

	function load_real_estate() {
		check_ajax_referer( 'etc_nonce', 'nonce' );
		
		$query = array(
			'post_type' => array( 'apartament', 'real_estate_object' ),
			'post_status' => 'publish',
			'numberposts' => intval( $_REQUEST['numberposts'] ),
		);
		
		if ( !empty( $_REQUEST['formData'] ) ) {
			$form_data = json_decode( stripslashes( sanitize_text_field( $_REQUEST['formData'] ) ) );
			$parsed_data = array_column( $form_data, 'value', 'name' );

			$meta_query = array(
				'relation'      => 'AND',
			);

			if ( !empty( $name = sanitize_text_field( $parsed_data['acf[name]'] ) ) ) {
				$query['post_type'] = 'real_estate_object';
				$meta_query[] = array(
					'key'       => 'name',
					'value'     => $name,
					'compare' => 'LIKE',
				);
			}
			
			if ( !empty( $location = sanitize_text_field( $parsed_data['acf[location]'] ) ) ) {
				$query['post_type'] = 'real_estate_object';
				$meta_query[] = array(
					'key'       => 'location',
					'value'     => $location,
					'compare' => 'LIKE',
				);
			}
			
			if ( !empty( $floors = sanitize_text_field( $parsed_data['acf[floors]'] ) ) ) {
				$query['post_type'] = 'real_estate_object';
				$meta_query[] = array(
					'key'       => 'floors',
					'value'     => $floors,
					'compare' => '=',
				);
			}
			
			if ( !empty( $type = sanitize_text_field( $parsed_data['acf[type]'] ) ) ) {
				$query['post_type'] = 'real_estate_object';
				$meta_query[] = array(
					'key'       => 'type',
					'value'     => $type,
					'compare' => '=',
				);
			}
			
			if ( !empty( $environmental = sanitize_text_field( $parsed_data['acf[environmental]'] ) ) ) {
				$query['post_type'] = 'real_estate_object';
				$meta_query[] = array(
					'key'       => 'environmental',
					'value'     => $environmental,
					'compare' => '=',
				);
			}
			
			if ( !empty( $square = intval( $parsed_data['acf[square]'] ) ) ) {
				$query['post_type'] = 'apartament';
				$meta_query[] = array(
					'key'       => 'square',
					'value'     => $square,
					'compare' => '<=',
				);
			}
			
			if ( !empty( $rooms = intval( $parsed_data['acf[rooms]'] ) ) ) {
				$query['post_type'] = 'apartament';
				$meta_query[] = array(
					'key'       => 'rooms',
					'value'     => $rooms,
					'compare' => '=',
				);
			}
			
			if ( !empty( $balcony = sanitize_text_field( $parsed_data['acf[balcony]'] ) ) ) {
				$query['post_type'] = 'apartament';
				$meta_query[] = array(
					'key'       => 'balcony',
					'value'     => $balcony,
					'compare' => '=',
				);
			}
			
			if ( !empty( $bathroom = sanitize_text_field( $parsed_data['acf[bathroom]'] ) ) ) {
				$query['post_type'] = 'apartament';
				$meta_query[] = array(
					'key'       => 'bathroom',
					'value'     => $bathroom,
					'compare' => '=',
				);
			}
			
			$query['meta_query'] = $meta_query;
			
// 			echo json_encode( $query );
// 			wp_die();
		}
		
		if ( !empty( $offset = intval( $_REQUEST['offset'] ) ) ) {
			$query['offset'] = $offset;
		}
		
		echo $this->render( apply_filters( 'estate_query', $query ) );
		wp_die();
	}	
	
	function estate_shortcode( $args ) {
		$post_number = intval( $args['items'] );
		if ( $post_number < 1 ) return;

// 		$query_serialized = serialize($query);

		$html = '<h2>' . esc_textarea( $args['title'] ) . '</h2>';
		$html .= "<section class='etcetera-real-estate-container' data-numberposts='$post_number' data-query=''>";
		$html .= '<ul>';
// 		$html .= $this->render( $query );
		$html .= '</ul>';
		$html .= '<button class="load-more">' . esc_html( 'Load more', 'etc' ) . '</button>';
		$html .= '</section>';
		echo $html;
	}
}
$estate_list = new Estate_List();
