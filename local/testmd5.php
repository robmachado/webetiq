<?php

$m = [];
for ($x=1; $x<25000; $x++) {
    $cod = substr(md5($x), 1, 8);
    $m[] = $cod;
}

echo "<pre>";
print_r(array_count_values($m));
echo "</pre>";