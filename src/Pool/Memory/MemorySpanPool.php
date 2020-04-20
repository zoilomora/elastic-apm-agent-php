<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Pool\SpanPool;

final class MemorySpanPool extends MemoryPool implements SpanPool
{
    /**
     * @param Span $item
     *
     * @return void
     */
    public function put(Span $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return Span[]
     */
    public function findFinished()
    {
        return array_filter(
            $this->items,
            static function(Span $item) {
                return $item->isFinished();
            }
        );
    }

    /**
     * @return Span|null
     */
    public function findLastUnfinished()
    {
        $items = array_reverse($this->items);

        /** @var Span $item */
        foreach ($items as $item) {
            if (true === $item->isFinished()) {
                continue;
            }

            return $item;
        }

        return null;
    }

    /**
     * @return void
     */
    public function eraseAll()
    {
        $this->reset();
    }
}
