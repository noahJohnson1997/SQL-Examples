<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: config.php
 *   Description:
 */

return [
// Display error details in the development environment
'displayErrorDetails' => true,
    'db' => [
        'driver' => "mysql",
        'host' => 'localhost',
        'database' => 'safecar',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]
];

