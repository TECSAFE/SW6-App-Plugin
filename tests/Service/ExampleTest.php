<?php

declare(strict_types=1);

namespace Service;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        $foo = 'bar';
        $bar = $foo;
        $this->assertSame($foo, $bar);
    }
}
