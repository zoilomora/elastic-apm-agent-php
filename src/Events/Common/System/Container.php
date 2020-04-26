<?php

namespace ZoiloMora\ElasticAPM\Events\Common\System;

use ZoiloMora\ElasticAPM\Helper\Encoding;
use ZoiloMora\ElasticAPM\Helper\MetadataExtractor\KubernetesAndContainer;

final class Container implements \JsonSerializable
{
    /**
     * Container ID
     *
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->assertId($id);

        $this->id = $id;
    }

    /**
     * @param mixed $id
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertId($id)
    {
        if (null !== $id && false === is_string($id)) {
            throw new \InvalidArgumentException('[id] must be one of these types: string or null.');
        }
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Container
     */
    public static function discover()
    {
        return new self(
            KubernetesAndContainer::instance()->containerId()
        );
    }

    /**
     * @return array|null
     */
    public function jsonSerialize()
    {
        if (null === $this->id) {
            return null;
        }

        return [
            'id' => Encoding::keywordField($this->id),
        ];
    }
}
