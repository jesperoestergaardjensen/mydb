<?php

require '../vendor/autoload.php';

use jesperoestergaardjensen\MyDB\DB;
use jesperoestergaardjensen\MyDB\Runner;

$runner = new Runner(
    DB::link(
        [
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'test_db'
        ]
    )
);

$runner->setErrorHandler(
    function ($mysqli, $sql) {
        //put your error handling code here
        print_r([$mysqli->error, $mysqli->errno, $sql]);
    }
);

$runner->runSQL("SELECT * FROM unknown_table");
