<?php

namespace ZoiloMora\ElasticAPM\Pool\Memory;

abstract class MemoryPool implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @return void
     */
    protected function reset()
    {
        $this->items = [];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->items;
    }
}
