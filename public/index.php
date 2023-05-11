<?php
/**
 * Index.php
 *
 * This file is the entry point to the FreeTube app.
 *
 * @package none
 *
 * @since 0.0.1
 */

session_start();

require '../app/core/init.php';

/**
 * Start app.
 */
$app = new App();

$app->to_string();
