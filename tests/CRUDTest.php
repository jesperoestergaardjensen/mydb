<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use jesperoestergaardjensen\MyDB\DB;
use jesperoestergaardjensen\MyDB\DbEntity;
use jesperoestergaardjensen\MyDB\Runner;

class CRUDTest extends TestCase
{
    /**
     * @var DbEntity
     */
    protected $table;

    protected function setUp(): void
    {
        $link = DB::link([
            'host' => $GLOBALS['mysql_host'],
            'username' => $GLOBALS['mysql_user'],
            'password' => $GLOBALS['mysql_pass']
        ]);

        $runner = new Runner($link);


        $this->table = new DbEntity(
            $GLOBALS['mysql_test_table'],
            $link
        );

        $this->table->runScript(<<<SQL

CREATE DATABASE IF NOT EXISTS `$GLOBALS[mysql_db]`;
USE `$GLOBALS[mysql_db]`;

CREATE TABLE IF NOT EXISTS `$GLOBALS[mysql_test_table]` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL
        );
    }

    public function testCRUD(): void
    {
        $this->assertIsArray(
            $this->table->get()
        );

        $this->assertIsInt(
            $id = $this->table->add([
                'name' => 'Alex',
                'description' => 'Manager'
            ])
        );

        $this->assertEquals(1, $id);

        $this->assertEquals(
            [0 => ['id' => $id, 'name' => 'Alex', 'description' => 'Manager']],
            $this->table->get(['id' => $id])
        );

        $this->assertEquals(
            1,
            $this->table->edit(
                ['id' => $id],
                ['name' => 'Peter', 'description' => 'Director']
            )
        );

        $this->assertEquals(
            [0 => ['id' => $id, 'name' => 'Peter', 'description' => 'Director']],
            $this->table->get(['id' => $id])
        );

        $this->assertEquals(
            1,
            $this->table->del(['id' => $id])
        );

        $this->assertEquals(
            [],
            $this->table->get(['id' => $id])
        );

        $this->assertIsInt(
            $id = $this->table->add([
                'name' => 'Alex',
                'description' => 'Manager'
            ])
        );

        $this->assertEquals(
            [0 => ['id' => $id, 'name' => 'Alex', 'description' => 'Manager']],
            $this->table->get(['id' => $id, 'name' => 'Alex'])
        );

        $this->assertEquals(
            0,
            $this->table->edit(
                ['name' => 'Peter', 'description' => 'Director'],
                ['name' => 'Alex', 'description' => 'Manager']
            )
        );

        $this->assertEquals(
            1,
            $this->table->edit(
                ['name' => 'Alex', 'description' => 'Manager'],
                ['name' => 'Peter', 'description' => 'Director']
            )
        );

        $this->assertEquals(
            1,
            $this->table->del(['name' => 'Peter', 'description' => 'Director'])
        );
    }

    protected function tearDown(): void
    {
        $this->table->runSQL("DROP DATABASE IF EXISTS `$GLOBALS[mysql_db]`;");
    }
}
