<?php
require_once 'core/init.php';

if (Input::get('function') !== '') {
    switch (Input::get('function')) {
        case 'delete':
            $controller = new DeleteController(Input::get('element'));
            $controller->toString();
            break;

        default:
            break;
    }
}

