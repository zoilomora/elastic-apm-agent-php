<?php

namespace ZoiloMora\ElasticAPM\Pool;

use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

interface TransactionPool
{
    /**
     * @param Transaction $item
     *
     * @return void
     */
    public function put(Transaction $item);

    /**
     * @return Transaction[]
     */
    public function findFinishedAndDelete();

    /**
     * @return Transaction|null
     */
    public function findLastUnfinished();
}
