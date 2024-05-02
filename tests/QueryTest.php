<?php

declare(strict_types=1);

namespace Tests;

use Inkant\Engi\Compiler;
use Inkant\Engi\Escapers\DummyEscaper;
use Inkant\Engi\Query;

class QueryTest extends \PHPUnit\Framework\TestCase
{
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
        $escaper  = new DummyEscaper();
        $compiler = new Compiler($escaper);
        $this->assertSame($result, $compiler->compile(
            new Query($sql, $params)
        ));
    }
}
