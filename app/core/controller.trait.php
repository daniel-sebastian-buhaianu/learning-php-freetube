<?php
/**
 * Controller Trait
 */
trait Controller {
	/**
	 * Displays the view to user
	 *
	 * @param string $view_name Name of the view to be displayed.
	 */
	public function display_view( $view_name ) {

		$filename = "../app/views/{$view_name}.view.php";
		if ( file_exists( $filename ) ) {

			require $filename;

		} else {

			$filename = '../app/views/page-not-found.view.php';

			require $filename;
		}
	}
}
