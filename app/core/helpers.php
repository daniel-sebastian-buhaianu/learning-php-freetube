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
 * @param string $path_to_page The path to page.
 */
function redirect( $path_to_page ) {
	header( 'Location: ' . ROOT . "/{$path_to_page}" );
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
