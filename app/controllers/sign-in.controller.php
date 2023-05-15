<?php
/**
 * Sign In Page Controller
 */
class Sign_In {

	use Controller;
	use Sign_In_Up;

	/**
	 * $this->controller_name
	 *
	 * @var string $controller_name The controller's name.
	 */
	public $controller_name = 'Sign_In';
	/**
	 * Constructor
	 */
	public function __construct() {

		$this->inputs['email']    = '';
		$this->inputs['password'] = '';
	}

	/**
	 * Index method
	 */
	public function index() {

		if ( is_user_logged_in() ) {

			redirect( 'home' );
			exit();

		} elseif ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {

			$this->render( 'sign-in' );

		} else {

			if ( true === $this->is_form_valid()
				&& true === $this->sign_in() ) {

				redirect( 'home' );
				exit();

			} else {

				$this->render( 'sign-in' );

			}
		}
	}

	/**
	 * Validates the sign in form.
	 */
	private function is_form_valid() {

		$this->inputs['email']    = htmlentities( $_POST['email'], ENT_QUOTES );
		$this->inputs['password'] = htmlentities( $_POST['password'], ENT_QUOTES );

		if ( $this->is_any_input_empty()
			|| ! $this->is_email_valid()
			|| ! $this->is_password_strong() ) {

			return false;
		}

		return true;
	}

	/**
	 * Attempts to sign user in.
	 *
	 * @return boolean Returns true if successful, false otherwise.
	 */
	private function sign_in() {

		require '../app/models/user.class.php';

		$user = new User();

		$user_id = $user->check_email_and_password( $this->inputs['email'], $this->inputs['password'] );

		if ( ! $user_id > 0 ) {

			$this->errors['alert'] = 'The email/password you entered is incorrect!';

			return false;
		}

		$_SESSION['user_id'] = $user_id;

		return true;
	}
}
