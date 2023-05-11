<?php
/**
 * Model Trait
 */
trait Model {

	use Database;

	/**
	 * $this->order_by
	 *
	 * @var array $order_by The values of ORDER BY in an SQL query
	 */
	protected $order_by = array(
		'columns' => array( 'id' ),
		'order'  => 'asc',
	);
	/**
	 * $this->query_max_results
	 *
	 * @var int $query_max_results The value of LIMIT in an SQL query
	 */
	protected $query_max_results = 10;
	/**
	 * $this->query_offset
	 *
	 * @var int $query_offset The value of OFFSET in an SQL query
	 */
	protected $query_offset = 0;

	/**
	 * $this->errors
	 *
	 * @var array $errors An assoc. array containing all the errors related to the Model. Each item in the array is a key, value pair; the keys represent the error type and the values represent a description of the error.
	 */
	public $errors = array();

	/**
	 * Selects all columns from a table, and filters the result if required.
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function select_all() {

		$query_string = "SELECT * 
							FROM {$this->table}
								ORDER BY {$this->order_by['column']} {$this->order_by['order']} 
								LIMIT {$this->query_max_results} 
								OFFSET {$this->query_offset}";

		return $this->query( $query_string );
	}
}
