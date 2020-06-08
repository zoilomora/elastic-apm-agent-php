<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;
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
     * @param Transaction $transaction
     *
     * @return Span[]
     */
    public function findFinishedAndDelete(Transaction $transaction)
    {
        $result = [];

        /** @var Span $item */
        foreach ($this->items as $key => $item) {
            if ($item->transactionId() !== $transaction->id()) {
                continue;
            }

            if (false === $item->isFinished()) {
                continue;
            }

            $result[] = $item;
            unset($this->items[$key]);
        }

        return $result;
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
}
