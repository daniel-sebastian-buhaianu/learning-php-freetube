<?php
/**
 * Controller Trait
 */
trait Controller {
	/**
	 * Displays the view to user
	 *
	 * @param string $view_name Name of the view to be displayed.
	 *
	 * @param array  $variables Associative array of variables to be passed down from controller to the view.
	 * Each key represents the variable name, whereas the value is the variable's value.
	 */
	public function display_view( $view_name, $variables ) {

		if ( ! empty( $variables ) ) {
			extract( $variables );
		}

		$filename = "../app/views/{$view_name}.view.php";
		if ( file_exists( $filename ) ) {

			require $filename;

		} else {

			$filename = '../app/views/page-not-found.view.php';

			require $filename;
		}
	}
}
