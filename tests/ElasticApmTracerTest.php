<?php

namespace ZoiloMora\ElasticAPM\Tests;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\Pool\Memory\MemoryPoolFactory;
use ZoiloMora\ElasticAPM\Tests\Reporter\ReporterMock;

class ElasticApmTracerTest extends TestCase
{
    /**
     * @var ReporterMock
     */
    private $reporterMock;

    /**
     * @var ElasticApmTracer
     */
    private $tracer;

    protected function setUp()
    {
        parent::setUp();

        $this->reporterMock = new ReporterMock();
        $this->tracer = $this->createTracer([]);
    }

    /**
     * @test
     */
    public function given_requirements_when_instantiate_tracer_then_return_object()
    {
        self::assertInstanceOf('ZoiloMora\ElasticAPM\ElasticApmTracer', $this->tracer);
    }

    /**
     * @test
     */
    public function given_a_tracer_when_start_transaction_then_return_object()
    {
        $transaction = $this->startTransaction();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Transaction\Transaction', $transaction);
    }

    /**
     * @test
     */
    public function given_a_tracer_without_transaction_started_when_start_span_then_throw_exception()
    {
        self::setExpectedException('Exception', 'To create a span, there must be a transaction started.');

        $this->tracer->startSpan('SQL query', 'db', 'postgresql', 'query');
    }

    /**
     * @test
     */
    public function given_a_tracer_with_transaction_started_when_start_span_then_return_object()
    {
        $this->startTransaction();
        $span = $this->tracer->startSpan('SQL query', 'db', 'postgresql', 'query');

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Span\Span', $span);
    }

    /**
     * @test
     */
    public function given_a_tracer_without_transaction_started_when_capture_exception_then_throw_exception()
    {
        self::setExpectedException('Exception', 'To capture exception, there must be a transaction started.');

        $this->tracer->captureException(new \Exception());
    }

    /**
     * @test
     */
    public function given_a_tracer_with_transaction_started_when_capture_exception_then_return_object()
    {
        $this->startTransaction();

        $this->tracer->captureException(new \Exception());

        self::assertTrue(true);
    }

    /**
     * @test
     */
    public function given_a_deactivated_tracer_when_flushed_then_no_events_is_sent()
    {
        $this->tracer = $this->createTracer([
            'active' => false,
        ]);

        $this->tracer->flush();

        self::assertCount(0, $this->reporterMock->events());
    }

    /**
     * @test
     */
    public function given_a_tracer_when_flushed_then_not_send_anything()
    {
        $this->tracer->flush();

        self::assertCount(0, $this->reporterMock->events());
    }

    /**
     * @test
     */
    public function given_a_tracer_without_metric_set_when_sending_a_transaction_then_sending_two_events()
    {
        $this->tracer = $this->createTracer([
            'metricSet' => false,
        ]);

        $transaction = $this->startTransaction();
        $transaction->stop();

        $this->tracer->flush();

        self::assertCount(2, $this->reporterMock->events());
    }

    /**
     * @test
     */
    public function given_a_transaction_when_create_a_span_then_the_parent_id_is_the_transaction_id()
    {
        $transaction = $this->startTransaction();
        $span = $this->tracer->startSpan('Handle message', 'message', 'domain_event');

        self::assertEquals($transaction->id(), $span->parentId());
    }

    /**
     * @test
     */
    public function given_a_span_when_create_a_transaction_then_the_parent_id_is_the_span_id()
    {
        $this->startTransaction();
        $span = $this->tracer->startSpan('Handle message', 'message', 'domain_event');

        $transaction = $this->startTransaction();

        self::assertEquals($span->id(), $transaction->parentId());
    }

    /**
     * @param array $config
     *
     * @return ElasticApmTracer
     */
    private function createTracer(array $config)
    {
        $config = array_merge(
            $config,
            [
                'appName' => 'test',
            ]
        );

        return new ElasticApmTracer(
            CoreConfiguration::create($config),
            $this->reporterMock,
            MemoryPoolFactory::create()
        );
    }

    /**
     * @return \ZoiloMora\ElasticAPM\Events\Transaction\Transaction
     *
     * @throws \Exception
     */
    private function startTransaction()
    {
        return $this->tracer->startTransaction('GET /users/:id', 'request');
    }
}
