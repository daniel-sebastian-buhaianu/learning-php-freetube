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

		$this->controller        = get_controller_name();
		$this->controller_method = 'index';

		$this->load_controller();
	}

	/**
	 * Load Controller
	 *
	 * Loads the controller appropriate for the current URL
	 */
	private function load_controller() {

		$controller_filename = strtolower( join_words_with_string( $this->controller, '-' ) ) . '.controller.php';

		$filename = "../app/controllers/{$controller_filename}";
		if ( file_exists( $filename ) ) {

			require $filename;

		} else {

			$filename = '../app/controllers/page-not-found.controller.php';

			$this->controller = 'Page_Not_Found';

			require $filename;
		}

		$controller = new $this->controller();
		call_user_func( array( $controller, $this->controller_method ) );
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
