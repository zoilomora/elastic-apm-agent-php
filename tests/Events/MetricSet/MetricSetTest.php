<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\MetricSet;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet;

class MetricSetTest extends TestCase
{
    /**
     * @test
     */
    public function given_minimum_data_when_instantiating_then_return_object()
    {
        $timestamp = 1;
        $samples = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Samples');
        $transaction = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Transaction');

        $object = new MetricSet($timestamp, $samples, $transaction);

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet', $object);
    }

    /**
     * @test
     */
    public function given_all_data_when_instantiating_then_return_object()
    {
        $timestamp = 1;
        $samples = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Samples');
        $transaction = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Transaction');
        $span = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\MetricSet\Span');
        $tags = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Tags');

        $object = new MetricSet(
            $timestamp,
            $samples,
            $transaction,
            $span,
            $tags
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\MetricSet\MetricSet', $object);
    }

    /**
     * @test
     */
    public function given_a_metric_set_when_serialize_then_right_serialization()
    {
        $timestamp = 1;
        $samplesValue = 'samples';
        $transactionValue = 'transaction';
        $spanValue = 'span';
        $tagsValue = 'tags';

        $samplesMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\MetricSet\Samples',
            $samplesValue
        );
        $transactionMock = $this->getMockSerializable(
            'ZoiloMora\ElasticAPM\Events\MetricSet\Transaction',
            $transactionValue
        );
        $spanMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\MetricSet\Span', $spanValue);
        $tagsMock = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Tags', $tagsValue);

        $object = new MetricSet(
            $timestamp,
            $samplesMock,
            $transactionMock,
            $spanMock,
            $tagsMock
        );

        $actual = json_decode(
            json_encode($object),
            true
        );

        $metricSet = $actual['metricset'];

        self::assertArrayHasKey('timestamp', $metricSet);
        self::assertArrayHasKey('samples', $metricSet);
        self::assertArrayHasKey('transaction', $metricSet);
        self::assertArrayHasKey('span', $metricSet);
        self::assertArrayHasKey('tags', $metricSet);

        self::assertSame($timestamp, $metricSet['timestamp']);
        self::assertSame($samplesValue, $metricSet['samples']);
        self::assertSame($transactionValue, $metricSet['transaction']);
        self::assertSame($spanValue, $metricSet['span']);
        self::assertSame($tagsValue, $metricSet['tags']);
    }
}
