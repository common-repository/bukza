<?php
/**
 * Rest methods implementations.
 *
 * @link       https://bukza.com
 * @since      2.0.0
 *
 * @package    Bukza
 * @subpackage Bukza/admin
 */

/**
 * Rest methods implementations.
 *
 * @package    Bukza
 * @subpackage Bukza/admin
 * @author     Bukza <support@bukza.com>
 */
class Bukza_Rest {
	/**
	 * Updates bukza data
	 *
	 * @since    2.0.0
	 * @param string $data      Input data.
	 */
	public static function update( $data ) {

		update_option( 'bukza_secret', $data['secret'] );
		update_option( 'bukza_id', $data['id'] );
        return (object) array();
	}

	/**
	 * Check if a given request has access
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public static function permissions_check( $request ) {
		return current_user_can( 'install_plugins' );
	}
}
