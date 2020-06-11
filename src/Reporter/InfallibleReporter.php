<?php

namespace ZoiloMora\ElasticAPM\Reporter;

final class InfallibleReporter implements Reporter
{
    /**
     * @var Reporter
     */
    private $baseReporter;

    /**
     * @param Reporter $reporter
     */
    public function __construct(Reporter $reporter)
    {
        $this->baseReporter = $reporter;
    }

    /**
     * @param array $events
     *
     * @return void
     */
    public function report(array $events)
    {
        try {
            $this->baseReporter->report($events);
        } catch (\Throwable $exception) {
            // Nothing
        }
    }
}
