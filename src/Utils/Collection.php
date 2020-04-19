<?php

namespace ZoiloMora\ElasticAPM\Utils;

abstract class Collection implements \Iterator, \Countable, \JsonSerializable
{
    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items
     */
    final protected function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return \current($this->items);
    }

    /**
     * @return void
     */
    public function next()
    {
        \next($this->items);
    }

    /**
     * @return int|mixed|string|null
     */
    public function key()
    {
        return \key($this->items);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return \array_key_exists($this->key(), $this->items);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        \reset($this->items);
    }

    /**
     * @return int|void
     */
    public function count()
    {
        return \count($this->items);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return static
     */
    public static function from(array $items)
    {
        return new static($items);
    }
}
