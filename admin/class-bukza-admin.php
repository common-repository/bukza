<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bukza.com
 * @since      2.0.0
 *
 * @package    Bukza
 * @subpackage Bukza/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package    Bukza
 * @subpackage Bukza/admin
 * @author     Bukza <support@bukza.com>
 */
class Bukza_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 2.00
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Adds scripts for the admin area.
	 *
	 * @since    2.0.0
	 * @param string $hook The name of the page.
	 */
	public function enqueue_scripts( $hook ) {

		if ( 'toplevel_page_bukza' !== $hook ) {
			return;
		}

		// Styles.
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bukza-admin.css', array(), $this->version, 'all' );

		// Scripts.
		wp_register_script( 'bukza-admin', plugin_dir_url( __FILE__ ) . 'js/bukza-admin.js', array(), $this->version, true );

		wp_localize_script(
			'bukza-admin',
			'wpData',
			array(
				'rest_url'  => untrailingslashit( esc_url_raw( rest_url() ) ),
				'nonce'     => wp_create_nonce( 'wp_rest' ),
			)
		);

		wp_enqueue_script( 'bukza-admin' );

	}

	/**
	 * Adds options page.
	 *
	 * @since    2.0.0
	 */
	public function add_menu_item() {

		add_menu_page( 'Bukza', 'Bukza', 'manage_options', 'bukza', 'Bukza_Admin::menu_page', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAyNCIgaGVpZ2h0PSIxMDI0IiB2aWV3Qm94PSIwIDAgMTAyNCAxMDI0IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNNDU3LjI4NiA3NzUuMTM1QzQ2MC41MTggNzc1Ljk3NiA0NjMuNzUgNzc2LjgxOCA0NjcuMzQ4IDc3Ny43NDVDNDc4LjIwMyA3ODAuNDA2IDQ4OC44OTIgNzgxLjU3IDQ5OS42NDcgNzgxLjk5QzUxMi40MDYgNzgyLjQ4OSA1MjUuMTU4IDc4Mi4xNjQgNTM3Ljg0NSA3ODAuNTM2QzU0NS44NzQgNzc5LjUwNSA1NTMuODM1IDc3OC4xMTQgNTYxLjY1IDc3NS45NjJDNTY0LjgzMSA3NzUuMDI1IDU2OC4wMTIgNzc0LjA4NyA1NzEuNTQ0IDc3My4wMzlDNTc2LjcxMiA3NzEuMDUgNTgxLjYyNyA3NjkuMzkgNTg2LjMyOSA3NjcuMjU3QzYxMC43MTggNzU2LjE5NCA2MzAuMTI5IDczOS40MzMgNjQzLjk5MiA3MTYuMzk5QzY1My42MTggNzAwLjQwNiA2NTkuNjg4IDY4My4wNyA2NjMuMjc2IDY2NC44MzRDNjY3LjMyNSA2NDQuMjYxIDY2OC40OTIgNjIzLjQ4NSA2NjcuMzk2IDYwMi41NTNDNjY2LjgzNiA1OTEuODU5IDY2NS41MiA1ODEuMjc4IDY2My4yNTggNTcwLjgyMUM2NjEuNzc2IDU2My45NyA2NjAuMDggNTU3LjE2OCA2NTcuNDk2IDU1MC42MjZDNjU1LjA3OCA1NDMuMDQzIDY1MS44OTMgNTM1Ljc3MiA2NDcuOTQzIDUyOC44ODdDNjI3LjA2OSA0OTIuNTAzIDU5Ni42MTMgNDY4LjE2OCA1NTYuMjUyIDQ1Ni40NjlDNTQyLjMyMyA0NTIuNDMyIDUyOC4wNDMgNDUwLjQ4OSA1MTMuNTY2IDQ0OS43NTNDNTAxLjUyMyA0NDkuMTQyIDQ4OS41MjQgNDQ5LjUwNSA0NzcuNTcyIDQ1MC45NjdDNDQ3LjQ0MSA0NTQuNjU0IDQyMC4wNjIgNDY1LjMwMyAzOTUuNzYzIDQ4My42MzRDMzk1LjIzIDQ4NC4wMzYgMzk0LjY5MSA0ODQuNDMxIDM5NC4xNCA0ODQuODA2QzM5NC4wMTggNDg0Ljg4OSAzOTMuODMgNDg0Ljg3NiAzOTMuNDM1IDQ4NC45NTNDMzkzLjM3MSA0ODQuMjQxIDM5My4yNTIgNDgzLjU0MyAzOTMuMjUyIDQ4Mi44NDRDMzkzLjI0MyA0NTQuNDUyIDM5My4yNjEgNDI2LjA2IDM5My4yMDMgMzk3LjY2OEMzOTMuMiAzOTUuODkyIDM5My44NDYgMzk1LjAxMiAzOTUuMzQ3IDM5NC4yMTVDNDE4LjIzIDM4Mi4wNTMgNDQyLjM5MyAzNzMuNjM3IDQ2Ny45MjIgMzY5LjEzM0M0ODguNzQ3IDM2NS40NTkgNTA5LjcxNSAzNjQuNTc5IDUzMC43OSAzNjUuODE5QzUzNS43MDMgMzY2LjEwOCA1NDAuNjE5IDM2Ni41MTggNTQ1LjUgMzY3LjE0QzU1Mi40MTYgMzY4LjAyMiA1NTkuMzQ0IDM2OC45MiA1NjYuMTkyIDM3MC4yMTJDNjExLjA4OCAzNzguNjggNjUwLjE4NSAzOTguNTQ2IDY4My4zMjggNDMwLjA2OUM2OTUuNDY0IDQ0MS42MTIgNzA2LjYwNyA0NTMuOTk5IDcxNi4xMjcgNDY3LjgxMkM3MzIuMjM3IDQ5MS4xODYgNzQzLjMwMyA1MTYuNzk1IDc0OS44ODQgNTQ0LjM1NkM3NTEuNjA3IDU1MS41NzQgNzUzLjA3NCA1NTguODcyIDc1NC4yMyA1NjYuMjAyQzc1Ny42MzEgNTg3Ljc3OSA3NTguNjc5IDYwOS41MDYgNzU3LjU4NCA2MzEuMzE5Qzc1Ny4xODYgNjM5LjIzNiA3NTYuNjc4IDY0Ny4xNjIgNzU1LjgwMiA2NTUuMDM3Qzc1NC4yMzUgNjY5LjEzMiA3NTEuNzA0IDY4My4wNjQgNzQ3Ljk3IDY5Ni43NjhDNzM5LjY5MSA3MjcuMTQzIDcyNi4xNzQgNzU0Ljg1MSA3MDUuOTkxIDc3OS4xM0M2ODYuNDE1IDgwMi42NzkgNjYyLjc3NiA4MjEuMjUxIDYzNS44NCA4MzUuNjcxQzYxNS4zMjcgODQ2LjY1MiA1OTMuNTk2IDg1NC4zMjQgNTcwLjg4NCA4NTkuMzE3QzU0My45NzYgODY1LjIzMiA1MTYuNzMxIDg2Ny4xNyA0ODkuMjY4IDg2Ni4xMUM0NjQuODc0IDg2NS4xNjkgNDQwLjkyNCA4NjEuMzM4IDQxNy44MzEgODUzLjIxOUMzNjEuMzI3IDgzMy4zNTMgMzIwLjI2OCA3OTUuOTU1IDI5My40ODYgNzQyLjY1OUMyODIuMzQ0IDcyMC40ODUgMjc1LjU0NiA2OTYuODY5IDI3MS40NzUgNjcyLjQzNUMyNjguMzM4IDY1My42MTEgMjY3LjAwMiA2MzQuNjQ2IDI2Ny4wMDEgNjE1LjU3NkMyNjYuOTk5IDQ2My4wOTQgMjY3IDMxMC42MTIgMjY3IDE1OC4xMjlDMjY3IDE1Ny4xNDYgMjY3IDE1Ni4xNjQgMjY3IDE1NUMyOTcuMTI2IDE1NSAzMjYuOTU5IDE1NSAzNTcuMDM0IDE1NUMzNTcuMDg0IDE1Ni4yMjcgMzU3LjE3MSAxNTcuMzY2IDM1Ny4xNzEgMTU4LjUwNkMzNTcuMTc4IDIxOC44ODEgMzU3LjE3NyAyNzkuMjU2IDM1Ny4xNzcgMzM5LjYzMUMzNTcuMTc3IDQzMC41NjkgMzU3LjE4NiA1MjEuNTA4IDM1Ny4xNjYgNjEyLjQ0NkMzNTcuMTY0IDYyMy4yMjYgMzU3LjUzNCA2MzMuOTc5IDM1OC42NDUgNjQ0LjcwNkMzNjAuOTY4IDY2Ny4xMTYgMzY2LjM0IDY4OC42NyAzNzYuNTIyIDcwOC44ODVDMzc2LjkzMiA3MDkuNjk4IDM3Ny40NjQgNzEwLjQ1IDM3OC4wOTIgNzExLjUxQzM3OC41MDkgNzEyLjM5OSAzNzguNzI2IDcxMy4wMzUgMzc5LjA0NyA3MTMuNjEzQzM4NC41NDIgNzIzLjQ5NyAzOTEuMDA3IDczMi42ODggMzk4LjkxMyA3NDAuNzk1QzQxMC40NTggNzUyLjYzMiA0MjMuODc2IDc2MS44MTggNDM4Ljk1OCA3NjguNTU5QzQ0NC44OTUgNzcxLjIxMiA0NTAuOTM2IDc3My42MTQgNDU3LjI4NiA3NzUuMTM1WiIgZmlsbD0iI0FFQUVBRSIvPgo8cGF0aCBkPSJNNjQ1LjU4MiA1NTVDNjQ4LjExNSA1NjEuMDU2IDY0OS42MzEgNTY3LjM1OCA2NTAuOTU1IDU3My43MDZDNjUyLjk3NiA1ODMuMzk2IDY1NC4xNTIgNTkzLjIgNjU0LjY1MiA2MDMuMTA5QzY1NS42MzEgNjIyLjUwMyA2NTQuNTg4IDY0MS43NTMgNjUwLjk3MSA2NjAuODE2QzY0Ny43NjUgNjc3LjcxMyA2NDIuMzQyIDY5My43NzYgNjMzLjc0MiA3MDguNTk1QzYyMS4zNTcgNzI5LjkzNyA2MDQuMDE1IDc0NS40NjcgNTgyLjIyNCA3NTUuNzE4QzU3OC4wMjQgNzU3LjY5NCA1NzMuNjMyIDc1OS4yMzMgNTY5LjE2NCA3NjFDNTY4Ljk5OSA2OTMuNjQzIDU2OC45OTkgNjI2LjI1OCA1NjkgNTU4Ljg3M0M1NjkgNTU1LjAxOCA1NjkuMDA1IDU1NS4wMTIgNTcyLjY0MSA1NTUuMDEyQzU5Ni44OCA1NTUuMDA4IDYyMS4xMTkgNTU1LjAwNyA2NDUuNTgyIDU1NVoiIGZpbGw9IiNBRUFFQUUiLz4KPHBhdGggZD0iTTU1NiA3NjMuOTMyQzU0OS4wNjQgNzY2LjE2MyA1NDEuOTcxIDc2Ny40NjggNTM0LjgyIDc2OC40MzRDNTIzLjUxOCA3NjkuOTYyIDUxMi4xNiA3NzAuMjY2IDUwMC43OTQgNzY5Ljc5OUM0OTEuMjE0IDc2OS40MDQgNDgxLjY5MyA3NjguMzEzIDQ3Mi4yMSA3NjUuODAzQzQ3Mi4wNDkgNzY0LjYxNCA0NzIuMDA2IDc2My41MTggNDcyLjAwNiA3NjIuNDIyQzQ3Mi4wMDMgNzE5LjAzNCA0NzIuMDAxIDY3NS42NDUgNDcyLjAwNiA2MzIuMjU3QzQ3Mi4wMDYgNjI3Ljg1MiA0NzEuNjcyIDYyOCA0NzUuOTc1IDYyOC4wMDFDNTAxLjQwNyA2MjguMDAyIDUyNi44MzggNjI4LjAwMSA1NTIuMjY5IDYyOC4wMDJDNTU1Ljg5NSA2MjguMDAyIDU1NS44OTkgNjI4LjAwNyA1NTUuODk5IDYzMS45MTFDNTU1LjkgNjc0LjU5NSA1NTUuODk5IDcxNy4yNzkgNTU1LjkwMiA3NTkuOTYyQzU1NS45MDIgNzYxLjIxNSA1NTUuOTUgNzYyLjQ2NyA1NTYgNzYzLjkzMloiIGZpbGw9IiNBRUFFQUUiLz4KPHBhdGggZD0iTTQ1OC45ODYgNzYzQzQ1My4zNjIgNzYxLjc5NyA0NDguMDE0IDc1OS41NDIgNDQyLjc1OSA3NTcuMDUxQzQyOS40MDggNzUwLjcyMiA0MTcuNTI5IDc0Mi4wOTcgNDA3LjMxIDczMC45ODNDNDAwLjMxMSA3MjMuMzcyIDM5NC41ODcgNzE0Ljc0MyAzODkuNzIzIDcwNS40NjNDMzg5LjQzOSA3MDQuOTIxIDM4OS4yNDcgNzA0LjMyMyAzODkgNzAzLjU4MUMzODkuODUgNzAzLjI3NCAzOTAuNzEyIDcwMy4wMTggMzkxLjU3NSA3MDMuMDE4QzQxMy4wNTYgNzAyLjk5NSA0MzQuNTM3IDcwMyA0NTYuMDE4IDcwMy4wMDJDNDU2LjUzNSA3MDMuMDAyIDQ1Ny4wNTEgNzAzLjAxOCA0NTcuNTY3IDcwMy4wNDNDNDU4LjQ0NyA3MDMuMDg0IDQ1OC45MiA3MDMuNTc4IDQ1OC45NjEgNzA0LjUxNEM0NTguOTg0IDcwNS4wNjEgNDU5IDcwNS42MSA0NTkgNzA2LjE1N0M0NTguOTk4IDcyNS4wMyA0NTguOTk0IDc0My45MDMgNDU4Ljk4NiA3NjNaIiBmaWxsPSIjQUVBRUFFIi8+Cjwvc3ZnPgo=' );

	}

	/**
	 * Adds menu page.
	 *
	 * @since    2.0.0
	 */
	public static function menu_page() {

		$culture = 'en';

		if ( 'ru_RU' === get_locale() ) {
			$culture = 'ru';
		}

		$site_title = get_bloginfo( 'name' );

		if ( ! isset( $site_title ) || trim( $site_title ) === '' ) {
			$site_title = 'WordPress';
		}

		$ticks = number_format( microtime( true ) * 10000000, 0, '.', '' );

		$hash = '';

		$secret = get_option( 'bukza_secret' );

		if ( false !== $secret ) {
			$hash = md5( $secret . $ticks );
		}

		$bukza_url = 'https://public.bukza.com/api/wp/app?culture=' . $culture . '&userId=' . get_option( 'bukza_id' ) . '&wordPressSite=' . $site_title . '&ticks=' . $ticks . '&hash=' . $hash;
		include plugin_dir_path( __FILE__ ) . 'partials/bukza-admin-display.php';

	}

	/**
	 * Resgisters routes.
	 *
	 * @since    2.0.0
	 */
	public function init_rest() {

		require_once plugin_dir_path( __FILE__ ) . 'class-bukza-rest.php';
		register_rest_route(
			'bukza/v1',
			'/update',
			array(
				'methods'             => 'POST',
				'callback'            => 'Bukza_Rest::update',
				'permission_callback' => 'Bukza_Rest::permissions_check',
			)
		);

	}
}
