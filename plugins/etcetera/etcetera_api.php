<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

class Etcetera_API {
	private $url;
	private $user_id;
	private $user_login;
	private $user_password;
	
	function __construct( $post_type ) {
		$current_user = wp_get_current_user();
		
		if ( !( $current_user instanceof WP_User ) 
			|| !in_array( 'administrator', $current_user->roles ) ) {
			return false;
		}
		
		$api_credentials = unserialize( API_CREDENTIALS );
		if ( empty( $api_credentials[ $current_user->user_login ] ) ) {
			return false;
		}
		
		$this->user_id = $current_user->ID;
		$this->user_login = $current_user->user_login;
		$this->user_password = $api_credentials[ $current_user->user_login ];
		echo '<pre>'.print_r($this->user_password, true).'</pre>';
		
		$this->url = get_site_url() . "/wp-json/wp/v2/$post_type";
	}

	private function get_arguments( $args ) {
		$default_args = array(
			'method' => 'POST',
			'title' => 'default title',
			'content' => 'default content',
			'fields' => array(),
		);

		$full_args = array_merge( $default_args, $args );
// 				echo '<pre>'.print_r($full_args, true).'</pre>';

		$credentials = base64_encode( "{$this->user_login}:{$this->user_password}" );

		return array(
			'headers' => array(
				'Authorization' => 'Basic ' . $credentials,
			),
			'method' => $full_args['method'],
			'body' => array(
				'status'  => 'publish',
				'author' => $this->user_id,

				'title'   => wp_strip_all_tags( $full_args['title'] ),
				'content' => wp_kses_post( $full_args['content'] ),
				'fields' => array_map( 'sanitize_text_field', $full_args['fields'] ),
				// or we can do more thorough sanitizing for every field type
			),
		);		
	}
 	
	public function add( $args ) {
		$response = wp_remote_request( $this->url, $this->get_arguments( $args ) );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo __( 'Something is wrong: ', 'etc' ) . esc_html( $error_message );
			return false;
		} else {
			echo __( 'Response: ', 'etc' ) . esc_html( wp_remote_retrieve_response_code( $response ) ) . '<br>';
			return wp_remote_retrieve_body( $response );
		}
	}

	public function update( $args ) {
		$post_id = intval( $args['id'] );
		if ( !$post_id ) return;
		
		$args['method'] = 'PUT';
		
		$response = wp_remote_request( "{$this->url}/$post_id", $this->get_arguments( $args ) );
// echo '<pre>'.print_r($reauest_args, true),'</pre>';
		
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo __( 'Something is wrong: ', 'etc' ) . esc_html( $error_message );
		} else {
			echo __( 'Response: ', 'etc' ) . esc_html( wp_remote_retrieve_response_code( $response ) ) . '<br>';
			return wp_remote_retrieve_body( $response );
		}
	}
	
	public function delete( $args ) {
		$post_id = intval( $args['id'] );
		if ( !$post_id ) return;
		
		$args['method'] = 'DELETE';
		
		$response = wp_remote_request( "{$this->url}/$post_id", $this->get_arguments( $args ) );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo __( 'Something is wrong: ', 'etc' ) . esc_html( $error_message );
		} else {
			echo __( 'Response: ', 'etc' ) . esc_html( wp_remote_retrieve_response_code( $response ) ) . '<br>';
			return wp_remote_retrieve_body( $response );
		}
	}
	
	public function get( $args ) {
		$sanitized_args = map_deep( $args, 'sanitize_text_field' );
		
		$response = wp_remote_request( add_query_arg( $sanitized_args, $this->url ), 
									  $this->get_arguments( array( 'method' => 'GET' ) ) );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo __( 'Something is wrong: ', 'etc' ) . esc_html( $error_message );
		} else {
			echo __( 'Response: ', 'etc' ) . esc_html( wp_remote_retrieve_response_code( $response ) ) . '<br>';
			return wp_remote_retrieve_body( $response );
		}
	}	
};
