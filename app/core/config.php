<?php
/**
 * Config.php
 *
 * Defines global variables and constants.
 */
require 'confidential.php';

/**
 * Database-related constants
 */
define( 'DB_NAME', 'db_freetube' );
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'dsb99@localhost' );
define( 'DB_PASS', $db_pass );

/**
 * ROOT URL of the app
 */
define( 'ROOT', 'http://localhost/ftube/public' );

/**
 * Used for debugging
 *
 * If set to "true" it will display the errors to the client.
 * Othwerwise, it will hide all errors.
 */
define( 'IS_DEBUG_MODE_ON', true );
