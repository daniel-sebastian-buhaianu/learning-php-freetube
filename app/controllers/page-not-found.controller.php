<?php
/**
 * Page Not Found Page Controller
 */
class Page_Not_Found {

	use Controller;

	/**
	 * $this->controller_name
	 *
	 * @var string $controller_name The controller's name.
	 */
	public $controller_name = 'Page_Not_Found';

	/**
	 * Index method
	 */
	public function index() {

		$variables = array();

		$variables['controller_name'] = $this->controller_name;

		$this->display_view( 'page-not-found', $variables );
	}
}
