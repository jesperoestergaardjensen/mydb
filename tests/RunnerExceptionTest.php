<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use jesperoestergaardjensen\MyDB\DB;
use jesperoestergaardjensen\MyDB\Runner;

class RunnerExceptionTest extends TestCase
{
    /**
     * @var mysqli
     */
    protected $mysqli;

    protected function setUp(): void
    {
        $this->mysqli = DB::link([
            'host' => $GLOBALS['mysql_host'],
            'username' => $GLOBALS['mysql_user'],
            'password' => $GLOBALS['mysql_pass']
        ]);
    }

    public function testSelect(): void
    {
        $this->expectException("Exception");
        $this->expectExceptionCode(1064);
        $this->expectExceptionMessageRegExp('/^MySql query error :/');

        (new Runner($this->mysqli))->runSQL("SELECT * FROM 123;");
    }

    public function testErrorHandler(): void
    {
        $this->assertSame(
            [],
            (new Runner($this->mysqli))
                ->setErrorHandler(function () {
                })
                ->runSQL("SELECT * FROM 456;")
        );
    }

}
