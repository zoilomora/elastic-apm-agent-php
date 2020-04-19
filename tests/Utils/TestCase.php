<?php

namespace ZoiloMora\ElasticAPM\Tests\Utils;

use PHPUnit\Framework\TestCase as TestCaseBase;

abstract class TestCase extends TestCaseBase
{
    protected function getMockWithoutConstructor($class)
    {
        return self::getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
            ;
    }

    protected function getMockSerializable($class, $value)
    {
        $mock = self::getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $mock
            ->expects(
                self::once()
            )
            ->method('jsonSerialize')
            ->willReturn($value)
        ;

        return $mock;
    }
}
