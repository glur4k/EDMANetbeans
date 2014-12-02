<?php
header('Content-Type: application/json');

$uploaded = [];
$allowed = ['pdf'];

$succeeded = [];
$failed = [];

if (!empty($_FILES['files'])) {
    foreach ($_FILES['files']['name'] as $key => $name) {
        if ($_FILES['files']['error'][$key] === 0) {
            
           $temp = $_FILES['files']['tmp_name'][$key];
        }
    }
}
