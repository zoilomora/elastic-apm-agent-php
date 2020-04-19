<?php

namespace ZoiloMora\ElasticAPM\Pool;

use ZoiloMora\ElasticAPM\Events\Error\Error;

interface ErrorPool
{
    /**
     * @param Error $item
     *
     * @return void
     */
    public function put(Error $item);

    /**
     * @return Error[]
     */
    public function findAll();

    /**
     * @return void
     */
    public function eraseAll();
}
