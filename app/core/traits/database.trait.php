<?php
/**
 * Database Trait
 */
trait Database {
	/**
	 * Connects to the database
	 */
	private function connect() {

		$string = 'mysql:hostname=' . DB_HOST . ';dbname=' . DB_NAME;
		$con    = new PDO( $string, DB_USER, DB_PASS );

		return $con;
	}

	/**
	 * Gets data from the database
	 *
	 * @param string $query_string An SQL query string to query the database.
	 *
	 * @param array  $query_string_variables Array of query string variable's values.
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch. If the query couldn't be executed, the return value will be false.
	 */
	private function query( $query_string, $query_string_variables = array() ) {

		$con  = $this->connect();
		$stmt = $con->prepare( $query_string );

		$check = $stmt->execute( $query_string_variables );
		if ( ! empty( $check ) ) {

			return $stmt->fetchAll( PDO::FETCH_OBJ );
		}

		return false;
	}
}
