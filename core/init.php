<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'bla'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user'
    )
);

/**
 * Lädt eine Klasse automatisch beim Aufruf $class = new Class();
 * Somit muss nicht ständig ein require auf die benötigte Klasse gemacht werden.
 * Stattdessen wird sie nur required, wenn sie auch tatsächlich benutzt wird.
 */
spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php';
});

/**
 * Kann leider nicht so wie oben gemacht werden, da functions keine Klasse ist.
 */
require_once 'functions/sanitize.php';
