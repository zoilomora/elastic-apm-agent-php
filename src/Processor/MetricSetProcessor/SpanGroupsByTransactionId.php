<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

final class SpanGroupsByTransactionId
{
    /**
     * @param Span[] $spans
     *
     * @return SpanGroup[]
     */
    public function execute(array $spans)
    {
        $result = [];

        foreach ($spans as $span) {
            $key = $span->transactionId();
            $result[$key][] = $span;
        }

        return $this->transformToSpanGroups($result);
    }

    /**
     * @param array $spanGroups
     *
     * @return SpanGroup[]
     */
    private function transformToSpanGroups(array $spanGroups)
    {
        $result = [];

        foreach ($spanGroups as $transactionId => $spans) {
            $result[] = new SpanGroup($transactionId, $spans);
        }

        return $result;
    }
}
