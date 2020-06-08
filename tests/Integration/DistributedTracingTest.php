<?php

namespace ZoiloMora\ElasticAPM\Tests\Integration;

use ZoiloMora\ElasticAPM\ElasticApmTracerSingleton;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\Events\Span\Context;
use ZoiloMora\ElasticAPM\Pool\Memory\MemoryPoolFactory;
use ZoiloMora\ElasticAPM\Reporter\ApmServerCurlReporter;

class DistributedTracingTest extends TestCase
{
    private $agent;

    protected function setUp()
    {
        parent::setUp();

        $this->agent = new ElasticApmTracer(
            CoreConfiguration::create([
                'appName' => 'service-one',
            ]),
            new ApmServerCurlReporter('http://apm-server:8200'),
            MemoryPoolFactory::create()
        );

        ElasticApmTracerSingleton::inject(
            new ElasticApmTracer(
                CoreConfiguration::create([
                    'appName' => 'service-two',
                ]),
                new ApmServerCurlReporter('http://apm-server:8200'),
                MemoryPoolFactory::create()
            )
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($_SERVER['HTTP_ELASTIC_APM_TRACEPARENT']);
    }

    /**
     * phpunit --filter testFullFlowInOneService tests/DistributedTracingTest.php
     */
    public function testFullFlowInOneService()
    {
        $transaction = $this->agent->startTransaction('GET /data/12345', 'request');

        $spanCache = $this->agent->startSpan(
            'DB User Lookup',
            'db',
            'redis',
            'query',
            Context::fromDb(
                new Context\Db(
                    'redis01.example.foo',
                    null,
                    'GET data_12345'
                )
            )
        );

        usleep(rand(2000, 150000));
        $spanCache->stop();

        usleep(rand(2000, 150000));

        $spanHttp = $this->agent->startSpan(
            'Query DataStore Service',
            'http',
            null,
            null,
            new Context()
        );

        // Simulate that it comes from a request
        $_SERVER['HTTP_ELASTIC_APM_TRACEPARENT'] = $spanCache->distributedTracing();
        $transaction2 = ElasticApmTracerSingleton::instance()->startTransaction('GET /data', 'request');

        usleep(rand(2000, 150000));
        $spanWms = ElasticApmTracerSingleton::instance()->startSpan('/orders/{uuid}', 'request');
        usleep(rand(2000, 150000));
        $spanWms->stop();

        $transaction2->stop();
        ElasticApmTracerSingleton::instance()->flush();

        usleep(rand(2000, 150000));


        $spanHttp->context()->setHttp(
            new Context\Http(
                'http://service-two/orders/23423423',
                200,
                'GET'
            )
        );
        $spanHttp->stop();

        usleep(rand(2000, 150000));

        $span = $this->agent->startSpan('do something', 'db', 'mysql', 'insert');
        usleep(rand(2000, 150000));

        $spanQ = $this->agent->startSpan('Save result', 'db', 'redis');
        usleep(rand(2000, 150000));
        $spanQ->stop();

        $span->stop();

        $this->agent->captureException(
            new \Exception('test!')
        );

        $transaction->stop();
        $this->agent->flush();

        $this->assertEquals(true, true);

        usleep(50000);
    }
}
