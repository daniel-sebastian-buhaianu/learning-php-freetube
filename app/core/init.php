<?php
/**
 * Init.php
 *
 * This file includes all the essential php files required
 * for the app to run.
 */

require 'config.php';
require 'helpers.php';

require 'traits/database.trait.php';
require 'traits/model.trait.php';
require 'traits/controller.trait.php';
require 'traits/sign-in-up.trait.php';

require 'app.class.php';
