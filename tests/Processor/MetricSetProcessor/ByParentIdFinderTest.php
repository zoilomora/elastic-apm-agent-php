<?php

namespace ZoiloMora\ElasticAPM\Tests\Processor\MetricSetProcessor;

use ZoiloMora\ElasticAPM\Events\TraceableEvent;
use ZoiloMora\ElasticAPM\Processor\MetricSetProcessor\ByParentIdFinder;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class ByParentIdFinderTest extends TestCase
{
    /**
     * @test
     */
    public function given_collection_of_events_when_search_parent_id_then_return_collection_with_objects()
    {
        $parentIdOk = '1990';
        $parentIdKo = '0991';

        $eventOne = $this->createEventMock($parentIdOk);
        $eventTwo = $this->createEventMock($parentIdKo);
        $eventThree = $this->createEventMock($parentIdOk);
        $eventFour = $this->createEventMock($parentIdKo);

        $events = [
            $eventOne,
            $eventTwo,
            $eventThree,
            $eventFour
        ];

        $expected = [
            $eventOne,
            $eventThree
        ];

        $service = new ByParentIdFinder();
        $result = $service->execute($parentIdOk, $events);

        self::assertSame($expected, $result);
    }

    /**
     * @param string $parentId
     *
     * @return TraceableEvent
     */
    private function createEventMock($parentId)
    {
        $event = self::getMockBuilder('ZoiloMora\ElasticAPM\Events\TraceableEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects(self::once())
            ->method('parentId')
            ->willReturn($parentId);

        return $event;
    }
}
