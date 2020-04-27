<?php

namespace ZoiloMora\ElasticAPM\Helper;

use ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame;

final class Stacktrace
{
    /**
     * Function to convert debug_backtrace results to an array of stack frames
     *
     * @param int $limit
     * @param int $skip
     *
     * @return array|null
     */
    public static function getDebugBacktrace($limit = 4, $skip = 1)
    {
        if (0 === $limit) {
            return null;
        }

        $debugBacktrace = array_slice(
            debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT),
            $skip
        );

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
