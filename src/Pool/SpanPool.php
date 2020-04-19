<?php

namespace ZoiloMora\ElasticAPM\Pool;

use ZoiloMora\ElasticAPM\Events\Span\Span;

interface SpanPool
{
    /**
     * @param Span $item
     *
     * @return void
     */
    public function put(Span $item);

    /**
     * @return Span[]
     */
    public function findFinished();

    /**
     * @return Span|null
     */
    public function findLastUnfinished();

    /**
     * @return void
     */
    public function eraseAll();
}
