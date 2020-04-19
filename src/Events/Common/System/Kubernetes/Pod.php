<?php

namespace ZoiloMora\ElasticAPM\Events\Common\System\Kubernetes;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Pod implements \JsonSerializable
{
    /**
     * Kubernetes pod name
     *
     * @var string|null
     */
    private $name;

    /**
     * Kubernetes pod uid
     *
     * @var string|null
     */
    private $uid;

    /**
     * @param string|null $name
     * @param string|null $uid
     */
    public function __construct($name = null, $uid = null)
    {
        $this->name = $name;
        $this->uid = $uid;
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function uid()
    {
        return $this->uid;
    }

    /**
     * @return Pod
     */
    public static function discover()
    {
        return new self(
            getenv('KUBERNETES_POD_NAME') ?: null,
            getenv('KUBERNETES_POD_UID') ?: null
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => Encoding::keywordField($this->name),
            'uid' => Encoding::keywordField($this->uid),
        ];
    }
}
