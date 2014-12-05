<?php

require_once 'classes/Parser.php';


echo "<br>";

$parser = new Parser('Hallo');
if ($parser->errors()) {
    echo 'Fehler beim Parsen der Datei!';
}
