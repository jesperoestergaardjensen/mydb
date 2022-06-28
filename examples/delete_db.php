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
        ]
    )
);

$runner->runSQL("DROP DATABASE `test_db`;");
