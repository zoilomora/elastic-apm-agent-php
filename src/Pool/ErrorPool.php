<?php

namespace ZoiloMora\ElasticAPM\Pool;

use ZoiloMora\ElasticAPM\Events\Error\Error;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

interface ErrorPool
{
    /**
     * @param Error $item
     *
     * @return void
     */
    public function put(Error $item);

    /**
     * @param Transaction $transaction
     *
     * @return Error[]
     */
    public function findAndDelete(Transaction $transaction);
}
