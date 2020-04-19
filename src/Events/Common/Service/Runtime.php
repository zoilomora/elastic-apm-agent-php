<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Service;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Runtime implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $version;

    /**
     * @param string|null $name
     * @param string|null $version
     */
    public function __construct($name = null, $version = null)
    {
        $this->name = $name;
        $this->version = $version;
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
    public function version()
    {
        return $this->version;
    }

    /**
     * @return Runtime
     */
    public static function discover()
    {
        return new self(
            'php',
            (string) phpversion()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => Encoding::keywordField($this->name),
            'version' => Encoding::keywordField($this->version),
        ];
    }
}
