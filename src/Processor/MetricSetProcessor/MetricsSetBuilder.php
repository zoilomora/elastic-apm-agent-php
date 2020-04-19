<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet;
use ZoiloMora\ElasticAPM\Events\MetricSet\Sample;
use ZoiloMora\ElasticAPM\Events\MetricSet\Samples;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

final class MetricsSetBuilder
{
    /**
     * @param Transaction $transaction
     * @param Span[] $spans
     *
     * @return MetricSet[]
     */
    public function execute(Transaction $transaction, array $spans)
    {
        $result = [];

        $result[] = new MetricSet(
            $transaction->timestamp(),
            Samples::from([
                new Sample('transaction.duration.count', 1),
                new Sample('transaction.duration.sum.us', $transaction->duration()),
                new Sample('transaction.breakdown.count', 1)
            ]),
            new \ZoiloMora\ElasticAPM\Events\MetricSet\Transaction(
                $transaction->name(),
                $transaction->type()
            )
        );

        foreach ($spans as $span) {
            $result[] = new MetricSet(
                $transaction->timestamp(),
                Samples::from([
                    new Sample('span.self_time.count', $span->count()),
                    new Sample('span.self_time.sum.us', $span->sum())
                ]),
                new \ZoiloMora\ElasticAPM\Events\MetricSet\Transaction(
                    $transaction->name(),
                    $transaction->type()
                ),
                new \ZoiloMora\ElasticAPM\Events\MetricSet\Span(
                    $span->type(),
                    $span->subtype()
                )
            );
        }

        return $result;
    }
}
