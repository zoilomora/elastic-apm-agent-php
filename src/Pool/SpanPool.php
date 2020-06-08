<?php

namespace ZoiloMora\ElasticAPM\Pool;

use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;

interface SpanPool
{
    /**
     * @param Span $item
     *
     * @return void
     */
    public function put(Span $item);

    /**
     * @param Transaction $transaction
     *
     * @return Span[]
     */
    public function findFinishedAndDelete(Transaction $transaction);

    /**
     * @return Span|null
     */
    public function findLastUnfinished();
}
