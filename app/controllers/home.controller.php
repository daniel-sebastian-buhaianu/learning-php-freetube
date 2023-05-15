<?php
/**
 * Home Page Controller
 */
class Home {

	use Controller;

	/**
	 * $this->controller_name
	 *
	 * @var string $controller_name The controller's name.
	 */
	public $controller_name = 'Home';

	/**
	 * $this->is_user_signed_in
	 *
	 * @var boolean $is_user_signed_in The user's signed in status.
	 *
	 * false = user is not signed in
	 * true  = user is signed in
	 */
	public $is_user_signed_in;

	public $data;

	/**
	 * Constructor
	 */
	public function __construct() {

		if ( true === isset( $_SESSION['user_id'] ) ) {

			$this->is_user_signed_in = true;

		} else {

			$this->is_user_signed_in = false;
		}
	}

	/**
	 * Index method
	 */
	public function index() {

		$this->handle_post_requests();

		$this->render();
	}

	/**
	 * Handles POST requests sent to the home page.
	 */
	private function handle_post_requests() {

		if ( isset( $_POST ) ) {

			// Get data from JSON file and store it.
			$data = file_get_contents( 'php://input' );
			$data = json_decode( $data, true );

			$this->data = $data;
		}

	}

	/**
	 * Renders the home page.
	 */
	private function render() {

		$variables = array();

		$variables['is_user_signed_in'] = $this->is_user_signed_in;
		$variables['controller_name']   = $this->controller_name;
		$variables['data'] = $this->data;

		$this->display_view( 'home', $variables );
	}
}
