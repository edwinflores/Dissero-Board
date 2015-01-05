<?php
define('ENV_PRODUCTION', false);
define('APP_HOST', 'hello.example.com');
define('APP_BASE_PATH', '/');
define('APP_URL', 'http://hello.example.com/');

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set('error_log', LOGS_DIR.'php.log');
ini_set('session.auto_start', 0);

// MySQL:board
define('DB_DSN', 'mysql:host=localhost;dbname=board');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'brs');
define('DB_ATTR_TIMEOUT', 3);

//Character restrictions
define('MIN_USERNAME_CHARACTERS', 3);
define('MAX_USERNAME_CHARACTERS', 16);
define('MIN_BODY_CHARACTERS', 1);
define('MAX_BODY_CHARACTERS', 200);
define('MIN_TITLE_CHARACTERS', 1);
define('MAX_TITLE_CHARACTERS', 30);
define('MIN_PASSWORD_CHARACTERS', 8);
define('MAX_PASSWORD_CHARACTERS', 20);
define('MAX_ITEM_DISPLAY', 7);