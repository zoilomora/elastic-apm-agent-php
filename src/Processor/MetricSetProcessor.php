<?php

namespace ZoiloMora\ElasticAPM\Processor;

use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByIdFinder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\FromEventsSpanBuilder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupBySpanTypes;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MeasurableEventsFinder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MetricsSetBuilder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SpanGroupsByTransactionId;

final class MetricSetProcessor implements Processor
{
    /**
     * @var MeasurableEventsFinder
     */
    private $measurableEventsFinder;

    /**
     * @var FromEventsSpanBuilder
     */
    private $fromEventsSpanBuilder;

    /**
     * @var SpanGroupsByTransactionId
     */
    private $spanGroupsByTransactionId;

    /**
     * @var ByIdFinder
     */
    private $byIdFinder;

    /**
     * @var GroupBySpanTypes
     */
    private $groupBySpanTypes;

    /**
     * @var MetricsSetBuilder
     */
    private $metricsSetBuilder;


    /**
     * @param MeasurableEventsFinder $measurableEventsFinder
     * @param FromEventsSpanBuilder $fromEventsSpanBuilder
     * @param SpanGroupsByTransactionId $spanGroupsByTransactionId
     * @param ByIdFinder $byIdFinder
     * @param GroupBySpanTypes $groupBySpanTypes
     * @param MetricsSetBuilder $metricsSetBuilder
     */
    public function __construct(
        MeasurableEventsFinder $measurableEventsFinder,
        FromEventsSpanBuilder $fromEventsSpanBuilder,
        SpanGroupsByTransactionId $spanGroupsByTransactionId,
        ByIdFinder $byIdFinder,
        GroupBySpanTypes $groupBySpanTypes,
        MetricsSetBuilder $metricsSetBuilder
    ) {
        $this->measurableEventsFinder = $measurableEventsFinder;
        $this->fromEventsSpanBuilder = $fromEventsSpanBuilder;
        $this->spanGroupsByTransactionId = $spanGroupsByTransactionId;
        $this->byIdFinder = $byIdFinder;
        $this->groupBySpanTypes = $groupBySpanTypes;
        $this->metricsSetBuilder = $metricsSetBuilder;
    }

    /**
     * @param array $events
     *
     * @return array
     */
    public function __invoke(array $events)
    {
        $measurableEvents = $this->measurableEventsFinder->execute($events);

        $spans = [];
        /** @var Transaction|Span $event */
        foreach ($measurableEvents as $event) {
            $spans[] = $this->fromEventsSpanBuilder->execute($event, $measurableEvents);
        }

        $spanGroups = $this->spanGroupsByTransactionId->execute($spans);

        $metricSets = [];
        foreach ($spanGroups as $spanGroup) {
            /** @var Transaction $transaction */
            $transaction = $this->byIdFinder->execute(
                $spanGroup->transactionId(),
                $measurableEvents
            );

            $groupedBySpanTypes = $this->groupBySpanTypes->execute(
                $spanGroup->transactionId(),
                $spanGroup->spans()
            );

            $metricSets = array_merge(
                $metricSets,
                $this->metricsSetBuilder->execute($transaction, $groupedBySpanTypes)
            );
        }

        return array_merge($events, $metricSets);
    }
}
