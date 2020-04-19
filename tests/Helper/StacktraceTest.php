<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Helper\Stacktrace;

class StacktraceTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_limit_of_zero_when_get_the_debug_backtrace_then_return_null()
    {
        $result = Stacktrace::getDebugBacktrace(0);

        self::assertNull($result);
    }

    /**
     * @test
     */
    public function given_a_limit_of_two_when_get_the_debug_backtrace_then_return_array()
    {
        $result = Stacktrace::getDebugBacktrace(2);

        self::assertCount(2, $result);
        self::assertContainsOnlyInstancesOf('ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame', $result);
    }
}
