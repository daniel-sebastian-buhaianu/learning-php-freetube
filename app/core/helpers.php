<?php
/**
 * Helpers.php
 *
 * Contains all the helper functions which are used in the app.
 *
 * @package none
 */

/**
 * Displays any data in a readable format;
 * mainly used for debugging.
 *
 * @param mixed $some_data Any data.
 */
function display_data( $some_data ) {
	echo '<pre>';
	print_r( $some_data );
	echo '</pre>';
}

/**
 * Redirects user to a specific page
 *
 * @param string $page_name The name of the page to redirect user to.
 */
function redirect( $page_name ) {
	header( 'Location: ' . ROOT . "/{$page_name}" );
}

/**
 * Gets the value of a query string, if exists.
 *
 * @param string $query_string_name The name of the query string variable.
 *
 * @return mixed Returns the value of a query string variable if it's set, or null.
 */
function get_query_string_value( $query_string_name ) {
	if ( ! isset( $_GET[ $query_string_name ] ) ) {
		return null;
	}

	return $_GET[ $query_string_name ];
}

/**
 * Gets the words from a path.
 *
 * If applied on "path/to/file" or "path/to/file/"
 * it returns an array of 3 values: ["path", "to", "file"]
 *
 * @param string $path_to_file The path to a file.
 */
function get_words_from_path( $path_to_file ) {
	return explode( '/', trim( $path_to_file, '/' ) );
}

/**
 * Gets the words from a string.
 *
 * @param str $str A string of characters.
 *
 * @return array All words from the string provided.
 */
function get_words_from_string( $str ) {

	$delimiters = "!@#$%^&*()\,/.?_=`~+[]{}:;|><'\" ";

	$words = array();

	$tok = strtok( $str, $delimiters );
	while ( false !== $tok ) {

		$words[] = $tok;

		$tok = strtok( $delimiters );
	}

	return $words;
}

/**
 * Gets the controller name from the URL path
 *
 * (Example) If the URL is: "https://localhost/sign-in/"
 * the function will return "Sign_In"
 *
 * @return string $controller_name The controller name in a valid format
 */
function get_controller_name() {

	$url        = strtolower( get_query_string_value( 'url' ) ?? 'home' );
	$words      = get_words_from_path( $url );
	$first_word = $words[0];
	$first_word = str_replace( '-', '_', $first_word );

	$controller_name = ucfirst_all_words( $first_word );

	return $controller_name;
}

/**
 * Joins the words in a string with another string.
 *
 * @param string $str The string to be modified.
 *
 * @param string $another_str The string to join the words with.
 *
 * @return string $new_string A new string of characters where each word is separated by the string given.
 */
function join_words_with_string( $str, $another_str ) {

	$words = get_words_from_string( $str );

	$new_string = '';

	foreach ( $words as $word ) {
		$new_string .= $word . $another_str;
	}

	return trim( $new_string, $another_str );
}

/**
 * Transforms the first letter in each word in a string to uppercase.
 *
 * @param string $str A string of characters.
 *
 * @return string $new_str A new string of characters where each word starts with an uppercase letter.
 */
function ucfirst_all_words( $str ) {

	$special_chars = "!@#$%^&*()\,/.?_=`~+[]{}:;|><'\" ";

	$new_string = '';
	$word       = '';
	$chars      = str_split( $str );
	foreach ( $chars as $char ) {

		if ( ! strstr( $special_chars, $char ) ) {

			$word .= $char;

		} else {

			if ( '' !== $word ) {

				$new_string .= ucfirst( $word );
				$word        = '';
			}

			$new_string .= $char;
		}
	}
	if ( '' !== $word ) {
		$new_string .= ucfirst( $word );
	}

	return $new_string;
}

/**
 * Checks if user is logged in
 *
 * @return boolean Returns true if user is logged in, and false otherwise.
 */
function is_user_logged_in() {

	if ( isset( $_SESSION['user_id'] ) ) {
		return true;
	}
	return false;
}
