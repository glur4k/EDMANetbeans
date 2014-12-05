<?php
header('Content-Type: application/json');

require_once 'core/init.php';

$uploader = new Uploader($_FILES, $_POST['ajax']);
