<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

use ZoiloMora\ElasticAPM\Events\Error\Error;
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
     * @return Error[]
     */
    public function findAll()
    {
        return $this->items;
    }

    /**
     * @return void
     */
    public function eraseAll()
    {
        $this->reset();
    }
}
