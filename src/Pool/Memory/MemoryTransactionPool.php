<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;
use ZoiloMora\ElasticAPM\Pool\TransactionPool;

final class MemoryTransactionPool extends MemoryPool implements TransactionPool
{
    /**
     * @param Transaction $item
     *
     * @return void
     */
    public function put(Transaction $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return Transaction[]
     */
    public function findFinishedAndDelete()
    {
        $result = [];

        /** @var Transaction $item */
        foreach ($this->items as $key => $item) {
            if (false === $item->isFinished()) {
                continue;
            }

            $result[] = $item;
            unset($this->items[$key]);
        }

        return $result;
    }

    /**
     * @return Transaction|null
     */
    public function findLastUnfinished()
    {
        $items = array_reverse($this->items);

        /** @var Transaction $item */
        foreach ($items as $item) {
            if (true === $item->isFinished()) {
                continue;
            }

            return $item;
        }

        return null;
    }
}
