<?php
/**
 * Trait which stores common functionality of Sign_In and Sign_Up controllers.
 */
trait Sign_In_Up {

	/**
	 * $this->errors
	 *
	 * @var array $errors Associative array of errors, where each key represents the error type.
	 */
	protected $errors = array();

	/**
	 * $this->inputs
	 *
	 * @var array $inputs Associative array of inputs, where each key represents the input type.
	 */
	protected $inputs = array();

	/**
	 * Checks if any form input is empty.
	 */
	protected function is_any_input_empty() {

		$is_any_empty = false;

		foreach ( $this->inputs as $key => $value ) {

			if ( empty( $this->inputs[ $key ] ) ) {

				$this->errors[ $key ] = 'required';

				$is_any_empty = true;
			}
		}

		if ( $is_any_empty ) {

			$this->errors['alert'] = 'Please fill in the required fields!';
		}

		return $is_any_empty;
	}

	/**
	 * Checks if the email entered by user is valid.
	 */
	protected function is_email_valid() {

		if ( ! filter_var( $this->inputs['email'], FILTER_VALIDATE_EMAIL ) ) {

			$errors['email'] = 'invalid email address';
			$errors['alert'] = 'Please enter a valid email address!';

			return false;
		}

		return true;
	}

	/**
	 * Checks if the password entered by user is strong.
	 *
	 * Password must be at least 8 characters in length. It must include at least one upper case letter, one number and one special character.
	 */
	protected function is_password_strong() {

		$uppercase     = preg_match( '@[A-Z]@', $this->inputs['password'] );
		$lowercase     = preg_match( '@[a-z]@', $this->inputs['password'] );
		$number        = preg_match( '@[0-9]@', $this->inputs['password'] );
		$special_chars = preg_match( '@[^\w]@', $this->inputs['password'] );

		if ( ! $uppercase || ! $lowercase || ! $number || ! $special_chars || strlen( $this->inputs['password'] ) < 8 ) {

			$this->errors['password'] = 'password is not strong enough';
			$this->errors['alert']    = 'Password must be at least 8 characters in length. It must include at least one upper case letter, one number and one special character.';

			return false;
		}

		return true;
	}

	/**
	 * Renders the sign in/up page.
	 *
	 * @param string $page Which page to render: 'sign-in' for Sign In page, or 'sign-up' for Sign Up page.
	 */
	protected function render( $page ) {
		$variables                    = array();
		$variables['errors']          = $this->errors;
		$variables['inputs']          = $this->inputs;
		$variables['controller_name'] = $this->controller_name;

		$this->display_view( $page, $variables );
	}

}
