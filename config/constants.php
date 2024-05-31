<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'database');

// Define root path
define('ROOT_PATH', realpath(dirname(__FILE__)) . '/');

// Define paths to commonly used directories
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('LOGS_PATH', ROOT_PATH . 'logs/');

?>