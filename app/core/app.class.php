<?php
/**
 * App Class
 */
class App {
	/**
	 * $this->controller
	 *
	 * @var string|null $controller The current controller.
	 */
	private $controller = null;

	/**
	 * $this->controller_method
	 *
	 * @var string|null $controller_method The method to call on the current controller.
	 */
	private $controller_method = null;


	/**
	 * Constructor
	 */
	public function __construct() {

		$url        = strtolower( get_query_string_value( 'url' ) ?? 'index' );
		$words      = get_words_from_path( $url );
		$first_word = $words[0];

		$this->controller        = ucfirst( $first_word );
		$this->controller_method = '__construct';

		$this->load_controller();
	}

	/**
	 * Load Controller
	 *
	 * Loads the controller appropriate for the current URL
	 */
	private function load_controller() {

		$controller = lcfirst( $this->controller );

		$filename = "../app/controllers/{$controller}.controller.php";
		if ( file_exists( $filename ) ) {

			require $filename;

		} else {

			$filename = '../app/controllers/page-not-found.controller.php';

			$this->controller = 'Page_Not_Found';

			require $filename;
		}
	}

	/**
	 * To String
	 *
	 * Displays the class members in a readable format.
	 */
	public function to_string() {

		display_data( $this->controller );
		display_data( $this->controller_method );
	}
}
