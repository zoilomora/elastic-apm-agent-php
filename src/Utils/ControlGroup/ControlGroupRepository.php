<?php

namespace ZoiloMora\ElasticAPM\Utils\ControlGroup;

interface ControlGroupRepository
{
    /**
     * @return ControlGroup[]
     */
    public function findAll();
}
