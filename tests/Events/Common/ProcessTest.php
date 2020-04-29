<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Process;

class ProcessTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Process(1);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Process', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Process::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Process', $object);
    }

    /**
     * @test
     */
    public function given_invalid_argv_data_when_try_to_discover_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException', 'All elements must be of string type.');

        new Process(1, null, null, [1]);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $pid = 1;
        $ppid = 2;
        $title = 'test';
        $argv = [];

        $object = new Process(
            $pid,
            $ppid,
            $title,
            $argv
        );

        self::assertSame($pid, $object->pid());
        self::assertSame($ppid, $object->ppid());
        self::assertSame($title, $object->title());
        self::assertSame($argv, $object->argv());
    }

    /**
     * @test
     */
    public function given_a_process_when_serialize_then_right_serialization()
    {
        $pid = 1;
        $ppid = 2;
        $title = 'test';
        $argv = [];


        $object = new Process(
            $pid,
            $ppid,
            $title,
            $argv
        );

        $expected = json_encode([
            'pid' => $pid,
            'ppid' => $ppid,
            'title' => $title,
            'argv' => $argv,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
