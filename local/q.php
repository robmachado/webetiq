<?php

$a = null;

if (!empty($a)) {
    echo "Empty <br>";
}

if (isset($a)) {
    echo "SETTED <br>";
}

if ($a !== null) {
    echo "NOT NULL <br>";
}

if (!is_null($a)) {
    echo "NOT NULL <br>";
}