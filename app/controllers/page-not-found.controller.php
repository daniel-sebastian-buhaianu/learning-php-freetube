<?php
/**
 * Page Not Found Page Controller
 */
class Page_Not_Found {

	use Controller;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->display_view( 'page-not-found' );
	}
}
