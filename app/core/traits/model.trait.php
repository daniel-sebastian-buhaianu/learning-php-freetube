<?php
/**
 * Model trait which is used by classes inside ROOT/app/models
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
		'order'   => 'asc',
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
	 * Selects all specified columns from table.
	 *
	 * @param string $columns The columns to be selected from table.
	 *
	 * $columns = '*' => all columns will be selected
	 * $columns = 'name' => only the 'name' column will be selected
	 * $columns = 'col_1, col_2, col_3, ..., col_n' => all specified columns will be selected.
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function select( $columns ) {

		$query_string = "SELECT {$columns} FROM {$this->table}";

		return $this->query( $query_string );
	}

	/**
	 * Selects all specified columns from table and applies ORDER BY, LIMIT and OFFSET to the result.
	 *
	 * ORDER BY, LIMIT, and OFFSET are member variables and can be modified using $this->
	 *
	 * @param string $columns The columns to be selected from table.
	 *
	 * $columns = '*' => all columns will be selected
	 * $columns = 'name' => only the 'name' column will be selected
	 * $columns = 'col_1, col_2, col_3, ..., col_n' => all specified columns will be selected.
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function select_oblo( $columns ) {

		$order_by_columns = implode( ',', $this->order_by['columns'] );

		$query_string = "SELECT {$columns} FROM {$this->table}
								ORDER BY {$order_by_columns} {$this->order_by['order']} 
								LIMIT {$this->query_max_results} 
								OFFSET {$this->query_offset}";

		return $this->query( $query_string );
	}

	/**
	 * Selects all columns specified which fulfill the where clause from table.
	 *
	 * @param string $columns The columns to be selected from table.
	 *
	 * $columns = '*' => all columns will be selected
	 * $columns = 'name' => only the 'name' column will be selected
	 * $columns = 'col_1, col_2, col_3, ..., col_n' => all specified columns will be selected.
	 *
	 * @param string $where_clause A valid SQL WHERE Clause, where each variable's value is replaced by a '?'
	 * example: $where_clause = 'id = ? AND name LIKE ?'.
	 *
	 * @param array  $where_variables Array of $where_clause variables' value.
	 * example: if $where_clause = 'id = ? AND name LIKE?', $where_variables can be: array( 3, '%Mia%' ).
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function select_where( $columns, $where_clause, $where_variables ) {

		$query_string = "SELECT {$columns} FROM {$this->table} WHERE {$where_clause}";

		return $this->query( $query_string, $where_variables );
	}

	/**
	 * Selects all columns specified which fulfill the where clause from table,
	 * and applies ORDER BY, LIMIT and OFFSET to the result.
	 *
	 * ORDER BY, LIMIT, and OFFSET are member variables and can be modified using $this->
	 *
	 * @param string $columns The columns to be selected from table.
	 *
	 * $columns = '*' => all columns will be selected
	 * $columns = 'name' => only the 'name' column will be selected
	 * $columns = 'col_1, col_2, col_3, ..., col_n' => all specified columns will be selected.
	 *
	 * @param string $where_clause A valid SQL WHERE Clause, where each variable's value is replaced by a '?'
	 * example: $where_clause = 'id = ? AND name LIKE ?'.
	 *
	 * @param array  $where_variables Array of $where_clause variables' value.
	 * example: if $where_clause = 'id = ? AND name LIKE?', $where_variables can be: array( 3, '%Mia%' ).
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function select_where_oblo( $columns, $where_clause, $where_variables ) {

		$order_by_columns = implode( ',', $this->order_by['columns'] );

		$query_string = "SELECT {$columns} 
							FROM {$this->table} 
								WHERE {$where_clause}
									ORDER BY {$order_by_columns} {$this->order_by['order']} 
									LIMIT {$this->query_max_results} 
									OFFSET {$this->query_offset}";

		return $this->query( $query_string, $where_variables );
	}

	/**
	 * Inserts a new row in table.
	 *
	 * @param array $columns_and_values Associative array of column names and their values.
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	public function insert( $columns_and_values ) {

		// Remove columns which are not editable.
		if ( ! empty( $this->editable_columns ) ) {

			foreach ( $columns_and_values as $column_name => $column_value ) {

				if ( ! in_array( $column_name, $this->editable_columns, true ) ) {

					unset( $columns_and_values[ $column_name ] );
				}
			}
		}

		// Create column string, e.g: 'col_name1, col_name2, col_name3' from array.
		$column_names = array_keys( $columns_and_values );
		$columns_str  = implode( ',', $column_names );

		// Create string of question marks from column_values array.
		// If column_values array size is 3, then I need $question_marks = '?,?,?'.
		$column_values  = array_values( $columns_and_values );
		$question_marks = array();
		foreach ( $column_values as $value ) {

			$question_marks[] = '?';
		}
		$question_marks = implode( ',', $question_marks );

		$query_string = "INSERT INTO {$this->table} ({$columns_str}) VALUES ({$question_marks})";

		return $this->query( $query_string, $column_values );
	}
}
