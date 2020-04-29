<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\Event;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByIdFinder;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class ByIdFinderTest extends TestCase
{
    /**
     * @test
     */
    public function given_collection_of_events_when_search_existing_id_then_return_object()
    {
        $id = '56429';
        $event = $this->createEventMock($id);

        $events = [
            $this->createEventMock('1'),
            $event
        ];

        $service = new ByIdFinder();
        $result = $service->execute($id, $events);

        self::assertSame($event, $result);
    }

    /**
     * @test
     */
    public function given_collection_of_events_when_search_nonexistent_id_then_return_null()
    {
        $id = '56429';

        $events = [
            $this->createEventMock('1'),
        ];

        $service = new ByIdFinder();
        $result = $service->execute($id, $events);

        self::assertNull($result);
    }

    /**
     * @param string $id
     *
     * @return Event
     */
    private function createEventMock($id)
    {
        $event = self::getMock('ZoiloMora\ElasticAPM\Events\Event');

        $event
            ->expects(self::once())
            ->method('id')
            ->willReturn($id);

        return $event;
    }
}
