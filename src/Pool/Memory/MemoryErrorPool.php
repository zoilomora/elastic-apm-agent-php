<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Events\Error\Error;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;
use ZoiloMora\ElasticAPM\Pool\ErrorPool;

final class MemoryErrorPool extends MemoryPool implements ErrorPool
{
    /**
     * @param Error $item
     *
     * @return void
     */
    public function put(Error $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param Transaction $transaction
     *
     * @return Error[]
     */
    public function findAndDelete(Transaction $transaction)
    {
        $result = [];

        /** @var Error $item */
        foreach ($this->items as $key => $item) {
            if ($item->transactionId() !== $transaction->id()) {
                continue;
            }

            $result[] = $item;
            unset($this->items[$key]);
        }

        return $result;
    }
}
