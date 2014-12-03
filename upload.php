<?php
header('Content-Type: application/json');

require_once 'core/init.php';

$uploader = new Uploader($_FILES, 'upload/tmp', $_POST['ajax']);
