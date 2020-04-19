<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Pool\PoolFactory;

final class MemoryPoolFactory implements PoolFactory
{
    /**
     * @return MemoryTransactionPool
     */
    public function createTransactionPool()
    {
        return new MemoryTransactionPool();
    }

    /**
     * @return MemorySpanPool
     */
    public function createSpanPool()
    {
        return new MemorySpanPool();
    }

    /**
     * @return MemoryErrorPool
     */
    public function createErrorPool()
    {
        return new MemoryErrorPool();
    }

    /**
     * @return MemoryPoolFactory
     */
    public static function create()
    {
        return new self();
    }
}
