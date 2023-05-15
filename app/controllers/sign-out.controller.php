<?php
/**
 * Sign Out Controller
 */
class Sign_Out {

	/**
	 * $this->controller_name
	 *
	 * @var string $controller_name The controller's name.
	 */
	public $controller_name = 'Sign_Out';

	/**
	 * Index method
	 */
	public function index() {

		if ( isset( $_SESSION['user_id'] ) ) {

			// Unset all the session variables.
			$_SESSION = array();

			// Destroy the session cookie.
			if ( isset( $_COOKIE[ session_name() ] ) ) {

				setcookie( session_name(), '', time() - 42000, '/' );
			}

			// Destroy the session.
			session_destroy();
		}

		// Redirect to home page.
		redirect( '' );
	}
}
