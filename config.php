<?php
$con = mysqli_connect('localhost', 'root', '', 'formify');
if (!$con) {
    echo 'Database connection error';
    die();
}

define('BASE_URL', '/aayush/form-generator');
define('ROOT_PATH', __DIR__ . '/');