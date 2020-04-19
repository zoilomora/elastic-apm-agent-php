<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

final class GroupSpanByTransactionId
{
    /**
     * @param Span[] $spans
     *
     * @return array
     */
    public function execute(array $spans)
    {
        $result = [];

        foreach ($spans as $span) {
            $key = $span->transactionId();
            $result[$key][] = $span;
        }

        return $result;
    }
}
