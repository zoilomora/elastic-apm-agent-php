<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame;

class StacktraceFrameTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_throw_exception()
    {
        self::setExpectedException('InvalidArgumentException');

        new StacktraceFrame();
    }

    /**
     * @test
     */
    public function given_classname_data_when_instantiating_then_return_object()
    {
        $object = new StacktraceFrame(
            null,
            null,
            null,
            null,
            'classname'
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame', $object);
    }

    /**
     * @test
     */
    public function given_filename_data_when_instantiating_then_return_object()
    {
        $object = new StacktraceFrame(
            null,
            null,
            null,
            'filename'
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame', $object);
    }

    /**
     * @test
     */
    public function given_exception_trace_when_instantiating_then_return_object()
    {
        $trace = $this->getExceptionTrace();
        $object = StacktraceFrame::fromDebugBacktrace($trace);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame', $object);
    }

    /**
     * @test
     */
    public function given_exception_trace_without_args_when_instantiating_then_return_object()
    {
        $trace = $this->getExceptionTrace();
        unset($trace['args']);

        $object = StacktraceFrame::fromDebugBacktrace($trace);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame', $object);
    }

    /**
     * @test
     */
    public function given_args_without_utf8_encoding_when_instance_then_returns_error_message()
    {
        $debugBacktrace = [
            'file' => 'test.php',
            'class' => 'Test',
            'args' => [
                mb_convert_encoding('華夷譯語', 'UCS-4LE'),
            ],
        ];

        $result = StacktraceFrame::fromDebugBacktrace($debugBacktrace);

        $data = json_decode(
            json_encode($result),
            true
        );

        $expected = 'Malformed UTF-8 characters, possibly incorrectly encoded';

        self::assertSame($expected, $data['vars'][0]);
    }

    /**
     * @test
     */
    public function given_a_stacktrace_frame_when_serialize_then_right_serialization()
    {
        $file = '/var/app/tests/Events/Common/StacktraceFrameTest.php';
        $line = 94;
        $function = 'getExceptionTrace';
        $class = 'ZoiloMora\ElasticAPM\Tests\Events\Common\StacktraceFrameTest';
        $type = '->';
        $args = [];

        $trace = [
            'file' => $file,
            'line' => $line,
            'function' => $function,
            'class' => $class,
            'type' => $type,
            'args' => $args,
        ];

        $expected = json_encode([
            'abs_path' => $file,
            'colno' => null,
            'context_line' => null,
            'filename' => basename($file),
            'classname' => $class,
            'function' => $function,
            'library_frame' => null,
            'lineno' => $line,
            'module' => $class,
            'post_context' => null,
            'pre_context' => null,
            'vars' => null,
        ]);

        $object = StacktraceFrame::fromDebugBacktrace($trace);
        $actual = json_encode($object);

        self::assertSame($expected, $actual);
    }

    private function getExceptionTrace()
    {
        $exception = new \Exception();

        return $exception->getTrace()[0];
    }
}
