<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Service;

use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Agent implements \JsonSerializable
{
    const NAME = 'zoilomora/elastic-apm-agent-php';
    const VERSION = '0.1.11';

    /**
     * Name of the Elastic APM agent, e.g. "Python"
     *
     * @var string|null
     */
    private $name;

    /**
     * Version of the Elastic APM agent, e.g."1.0.0"
     *
     * @var string|null
     */
    private $version;

    /**
     * Free format ID used for metrics correlation by some agents
     *
     * @var string|null
     */
    private $ephemeralId;

    /**
     * @param string|null $name
     * @param string|null $version
     * @param string|null $ephemeralId
     */
    private function __construct($name = null, $version = null, $ephemeralId = null)
    {
        $this->name = $name;
        $this->version = $version;
        $this->ephemeralId = $ephemeralId;
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
     * @return string|null
     */
    public function ephemeralId()
    {
        return $this->ephemeralId;
    }

    /**
     * @return Agent
     */
    public static function discover()
    {
        return new self(
            self::NAME,
            self::VERSION
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
            'ephemeral_id' => Encoding::keywordField($this->ephemeralId),
        ];
    }
}
