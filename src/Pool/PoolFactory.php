<?php

namespace ZoiloMora\ElasticAPM\Pool;

interface PoolFactory
{
    /**
     * @return TransactionPool
     */
    public function createTransactionPool();

    /**
     * @return SpanPool
     */
    public function createSpanPool();

    /**
     * @return ErrorPool
     */
    public function createErrorPool();
}
