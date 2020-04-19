<?php

namespace ZoiloMora\ElasticAPM\Helper;

use ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame;

final class Stacktrace
{
    /**
     * Function to convert debug_backtrace results to an array of stack frames
     *
     * @param int $limit
     *
     * @return array|null
     */
    public static function getDebugBacktrace($limit = 4)
    {
        if (0 === $limit) {
            return null;
        }

        $debugBacktrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);

        $stacktraceFrames = [];
        foreach ($debugBacktrace as $trace) {
            if (false === array_key_exists('file', $trace)) {
                continue;
            }

            $stacktraceFrames[] = StacktraceFrame::fromDebugBacktrace($trace);

            if ($limit === count($stacktraceFrames)) {
                break;
            }
        }

        return $stacktraceFrames;
    }
}
