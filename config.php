<?php
$conf = json_decode(file_get_contents(__DIR__."/config.json"), true);

// HTTP
define('HTTP_SERVER', $conf[HTTP_SERVER]);
define('HTTP_IMAGE', $conf[HTTP_SERVER].'image/');
define('HTTP_ADMIN', $conf[HTTP_SERVER].'admin/');
define('HTTP_CATALOG', $conf[HTTP_SERVER]);


// HTTPS
define('HTTPS_SERVER', $conf[HTTP_SERVER]);
define('HTTPS_IMAGE', $conf[HTTP_SERVER].'image/');
define('HTTPS_CATALOG', $conf[HTTP_SERVER]);


// DIR
define('DIR_APPLICATION', __DIR__.'/catalog/');
define('DIR_SYSTEM', __DIR__.'/system/');
define('DIR_DATABASE', __DIR__.'/system/database/');
define('DIR_LANGUAGE', __DIR__.'/catalog/language/');
define('DIR_TEMPLATE', __DIR__.'/catalog/view/theme/');
define('DIR_CONFIG', __DIR__.'/system/config/');
define('DIR_IMAGE', __DIR__.'/image/');
define('DIR_CACHE', __DIR__.'/system/cache/');
define('DIR_DOWNLOAD', __DIR__.'/download/');
define('DIR_SUBSCRIPTION', __DIR__.'/subscription/');
define('DIR_LOGS', __DIR__.'/system/logs/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', $conf["MYSQL_HOST"]);
define('DB_USERNAME', $conf["MYSQL_USER"]);
define('DB_PASSWORD', $conf["MYSQL_PASSWORD"]);
define('DB_DATABASE', $conf["MYSQL_DATABASE"]);

define('DB_PREFIX', '');
?>
