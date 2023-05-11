<?php
/**
 * Index Page Controller
 */
class Index {

	use Controller;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->display_view( 'index' );
	}
}
