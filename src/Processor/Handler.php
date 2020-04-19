<?php

namespace ZoiloMora\ElasticAPM\Processor;

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByIdFinder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByParentIdFinder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\FromEventsSpanBuilder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupBySpanTypes;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\GroupSpanByTransactionId;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MeasurableEventsFinder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\MetricsSetBuilder;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\SelfDurationCalculator;

final class Handler
{
    /**
     * @var Processor[]
     */
    private $processors;

    /**
     * @param array $processors
     */
    public function __construct(array $processors)
    {
        $this->assertProcessors($processors);

        $this->processors = $processors;
    }

    /**
     * @param CoreConfiguration $coreConfiguration
     *
     * @return Handler
     */
    public static function create(CoreConfiguration $coreConfiguration)
    {
        $processors = [];

        if (true === $coreConfiguration->metricSet()) {
            $processors[] = new MetricSetProcessor(
                new MeasurableEventsFinder(),
                new FromEventsSpanBuilder(
                    new ByParentIdFinder(),
                    new SelfDurationCalculator()
                ),
                new GroupSpanByTransactionId(),
                new ByIdFinder(),
                new GroupBySpanTypes(),
                new MetricsSetBuilder()
            );
        }

        return new self($processors);
    }

    /**
     * @param array $events
     *
     * @return array
     */
    public function execute(array $events)
    {
        foreach ($this->processors as $processor) {
            $events = $processor($events);
        }

        return $events;
    }

    /**
     * @param array $processors
     *
     * @return void
     */
    private function assertProcessors(array $processors)
    {
        foreach ($processors as $processor) {
            if (false === $processor instanceof Processor) {
                throw new \InvalidArgumentException('All elements must be of type Processor.');
            }
        }
    }
}
