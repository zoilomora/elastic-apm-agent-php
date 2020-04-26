<?php

namespace ZoiloMora\ElasticAPM\Utils\ControlGroup;

final class ControlGroup
{
    /**
     * @var string
     */
    private $hierarchyId;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $hierarchyId
     * @param string $controller
     * @param string $path
     */
    public function __construct(
        $hierarchyId,
        $controller,
        $path
    ) {
        $this->hierarchyId = $hierarchyId;
        $this->controller = $controller;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function hierarchyId()
    {
        return $this->hierarchyId;
    }

    /**
     * @return string
     */
    public function controller()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }
}
