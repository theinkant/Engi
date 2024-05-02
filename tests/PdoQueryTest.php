<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests;

use Inkant\Engi\Compiler;
use Inkant\Engi\Escapers\PdoEscaper;
use Inkant\Engi\Query;
use PHPUnit\Framework\TestCase;

class PdoQueryTest extends TestCase
{

    public function setUp(): void
    {
        $this->markTestSkipped('not implemented');
    }

    protected function pdo(): \PDO
    {
        $dsn = "";
        return new \PDO($dsn);
    }

    public function testQuery(): void
    {
        $sql = "
SELECT #, #column
FROM #table
WHERE login = ?
    AND int_id = i?id
    AND string_id = ?id
    AND EXISTS(?subquery)
";

        $params = [
            'user_id',
            'column' => 'login',
            'table'  => 'users',
            'email@email.email',
            'id' => '100',
            'subquery' => new Query(
                'SELECT 1 FROM table WHERE id = ?id',
                ['id' => 42]
            )
        ];
        $result = "
SELECT user_id, login
FROM users
WHERE login = 'email@email.email'
    AND int_id = 100
    AND string_id = '100'
    AND EXISTS(SELECT 1 FROM table WHERE id = 42)
";
        $escaper  = new PdoEscaper($this->pdo());
        $compiler = new Compiler($escaper);
        $this->assertSame($result, $compiler->compile(
            new Query($sql, $params)
        ));
    }
}
