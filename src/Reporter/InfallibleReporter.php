<?php

namespace ZoiloMora\ElasticAPM\Reporter;

final class InfallibleReporter implements Reporter
{
    /**
     * @var Reporter
     */
    private $reporter;

    /**
     * @param Reporter $reporter
     */
    public function __construct(Reporter $reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * @param array $events
     *
     * @return void
     */
    public function report(array $events)
    {
        try {
            $this->reporter->report($events);
        } catch (\Exception $exception) {
            // Nothing
        }
    }
}
