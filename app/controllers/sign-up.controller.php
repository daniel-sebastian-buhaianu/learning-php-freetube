<?php
/**
 * Sign Up Page Controller
 */
class Sign_Up {

	use Controller;
	use Sign_In_Up;

	/**
	 * $this->controller_name
	 *
	 * @var string $controller_name The controller's name.
	 */
	public $controller_name = 'Sign_Up';

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->inputs['email']            = '';
		$this->inputs['password']         = '';
		$this->inputs['re-type-password'] = '';
	}

	/**
	 * Index method
	 */
	public function index() {

		if ( is_user_logged_in() ) {

			redirect( 'home' );
			exit();

		} elseif ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {

			$this->render( 'sign-up' );

		} else {

			if ( true === $this->is_form_valid()
				&& true === $this->sign_up() ) {

				redirect( 'sign-in' );
				exit();

			} else {

				$this->render( 'sign-up' );

			}
		}
	}

	/**
	 * Validates the sign up form.
	 */
	private function is_form_valid() {

		$this->inputs['email']            = htmlentities( $_POST['email'], ENT_QUOTES );
		$this->inputs['password']         = htmlentities( $_POST['password'], ENT_QUOTES );
		$this->inputs['re-type-password'] = htmlentities( $_POST['re-type-password'], ENT_QUOTES );

		if ( $this->is_any_input_empty()
			|| ! $this->is_email_valid()
			|| ! $this->is_password_strong()
			|| ! $this->do_passwords_match() ) {

			return false;
		}

		return true;
	}

	/**
	 * Checks if password and re-type-password match.
	 */
	private function do_passwords_match() {

		if ( $this->inputs['password'] === $this->inputs['re-type-password'] ) {

			return true;
		}

		$this->errors['alert'] = 'Password and Re-type Password must be the same!';
		return false;
	}

	/**
	 * Attempts to sign user up.
	 *
	 * @return boolean Returns true if successful, false otherwise.
	 */
	private function sign_up() {

		require '../app/models/user.class.php';

		$user = new User();

		$result = $user->sign_up( $this->inputs['email'], $this->inputs['password'] );

		if ( 0 === $result ) {

			return true;

		} elseif ( 1 === $result ) {

			$this->errors['alert'] = 'Sorry, there was an error creating a new account. Please try again!';

			return false;

		} else {

			$this->errors['alert'] = 'Sorry, this email is already used by another user. Please choose a different one!';
			$this->errors['email'] = 'email already taken';

			return false;

		}
	}
}
