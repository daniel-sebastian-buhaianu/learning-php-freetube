<?php
/**
 * User class
 */
class User {

	use Model;

	/**
	 * $this->table
	 *
	 * @var string $table The table name from database.
	 */
	protected $table = 'users';

	/**
	 * $this->editable_columns
	 *
	 * @var array $editable_columns The columns which can be updated in the database by user.
	 */
	protected $editable_columns = array(
		'username',
		'email',
		'password_hash',
	);

	/**
	 * Attempts to sign user up.
	 *
	 * @param string $email User's email address.
	 *
	 * @param string $password User's account password.
	 *
	 * @return 0|1|2 Returns 0 if successful, 1 if internal server error, 2 if email is already taken.
	 */
	public function sign_up( $email, $password ) {

		if ( true === $this->user_already_exists( $email ) ) {

			return 2;
		}

		$hash = password_hash( $password, PASSWORD_DEFAULT );

		$column_and_values = array(
			'email'         => $email,
			'password_hash' => $hash,
		);

		if ( false === $this->insert( $column_and_values ) ) {

			return 1;
		}

		return 0;
	}

	/**
	 * Checks if email and password given belong to a user.
	 *
	 * @param string $email User's email address.
	 *
	 * @param string $password User's account password.
	 *
	 * @return int Returns user's id if email and password belong to a user, or -1 otherwise.
	 */
	public function check_email_and_password( $email, $password ) {

		$user_id = $this->get_id( $email );

		if ( empty( $user_id ) ) {

			return -1;
		}

		if ( false === $this->is_password_correct( $user_id, $password ) ) {

			return -1;
		}

		return $user_id;
	}

	/**
	 * Checks if user already exists
	 *
	 * @param string $email User's email address.
	 *
	 * @return boolean Returns true if user already exists, or false otherwise.
	 */
	private function user_already_exists( $email ) {

		if ( false !== $this->get_id( $email ) ) {

			return true;
		}

		return false;
	}

	/**
	 * Gets user's id by email.
	 *
	 * @param string $email User's email address.
	 *
	 * @return int|false Returns user's id if it exists, or false otherwise.
	 */
	private function get_id( $email ) {

		$this->query_max_results = 1;

		$query_result = $this->select_where_oblo( 'id', 'email = ?', array( $email ) );

		if ( ! empty( $query_result ) ) {

			return $query_result[0]->id;
		}

		return false;
	}

	/**
	 * Gets user's password hash by id.
	 *
	 * @param int $user_id User's id.
	 *
	 * @return string|false Returns user's password_hash if it exists, or false otherwise.
	 */
	private function get_password_hash( $user_id ) {

		$this->query_max_results = 1;

		$query_result = $this->select_where_oblo( 'password_hash', 'id = ?', array( $user_id ) );

		if ( ! empty( $query_result ) ) {

			return $query_result[0]->password_hash;
		}

		return false;
	}

	/**
	 * Checks if a password is actually user's password.
	 *
	 * @param int    $user_id User's id.
	 *
	 * @param string $password Password to check.
	 *
	 * @return boolean Returns true if password is user's password, or false otherwise.
	 */
	private function is_password_correct( $user_id, $password ) {

		$hash = $this->get_password_hash( $user_id );

		if ( empty( $hash ) ) {

			return false;
		}

		return password_verify( $password, $hash );
	}
}
