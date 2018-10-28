<?php

$db['db_host'] = getenv('DB_HOST');
$db['db_user'] = getenv('DB_USER');
$db['db_pass'] = getenv('DB_PASS');
$db['db_name'] = getenv('DB_NAME');

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}
$connection = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

//if ($connection) {
//    echo "We are connected";
//}
