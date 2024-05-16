<?php

namespace Model;

use TestEntity;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

    public function testCreate()
    {
        $flag = true;
        self::assertEquals(true, $flag);
    }

}
