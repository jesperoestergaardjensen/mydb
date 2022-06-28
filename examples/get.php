<?php

require '../vendor/autoload.php';

use jesperoestergaardjensen\MyDB\DB;
use jesperoestergaardjensen\MyDB\DbEntity;

$link = DB::link([
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'dbname' => 'test_db'
]);

$table1 = new DbEntity('table1', $link);

print_r($table1->get());
