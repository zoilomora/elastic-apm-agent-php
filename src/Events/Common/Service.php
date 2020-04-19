<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Service\Agent;
use ZoiloMora\ElasticAPM\Events\Common\Service\Framework;
use ZoiloMora\ElasticAPM\Events\Common\Service\Language;
use ZoiloMora\ElasticAPM\Events\Common\Service\Node;
use ZoiloMora\ElasticAPM\Events\Common\Service\Runtime;
use ZoiloMora\ElasticAPM\Helper\Encoding;

class Service implements \JsonSerializable
{
    /**
     * Name and version of the Elastic APM agent
     *
     * @var Agent|null
     */
    private $agent;

    /**
     * Name and version of the web framework used
     *
     * @var Framework|null
     */
    private $framework;

    /**
     * Name and version of the programming language used
     *
     * @var Language|null
     */
    private $language;

    /**
     * Immutable name of the service emitting this event
     *
     * @var string|null
     */
    private $name;

    /**
     * Environment name of the service, e.g. "production" or "staging"
     *
     * @var string|null
     */
    private $environment;

    /**
     * Name and version of the language runtime running this service
     *
     * @var Runtime|null
     */
    private $runtime;

    /**
     * Version of the service emitting this event
     *
     * @var string|null
     */
    private $version;

    /**
     * Unique meaningful name of the service node.
     *
     * @var Node|null
     */
    private $node;

    /**
     * @param Agent|null $agent
     * @param Framework|null $framework
     * @param Language|null $language
     * @param string|null $name
     * @param string|null $environment
     * @param Runtime|null $runtime
     * @param string|null $version
     * @param Node|null $node
     */
    public function __construct(
        Agent $agent = null,
        Framework $framework = null,
        Language $language = null,
        $name = null,
        $environment = null,
        Runtime $runtime = null,
        $version = null,
        Node $node = null
    ) {
        $this->agent = $this->validateAgent($agent);
        $this->framework = $framework;
        $this->language = $language;
        $this->name = $this->validateName($name);
        $this->environment = $environment;
        $this->runtime = $runtime;
        $this->version = $version;
        $this->node = $node;
    }

    /**
     * @return Agent|null
     */
    public function agent()
    {
        return $this->agent;
    }

    /**
     * @return Framework|null
     */
    public function framework()
    {
        return $this->framework;
    }

    /**
     * @return Language|null
     */
    public function language()
    {
        return $this->language;
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
    public function environment()
    {
        return $this->environment;
    }

    /**
     * @return Runtime|null
     */
    public function runtime()
    {
        return $this->runtime;
    }

    /**
     * @return string|null
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @return Node|null
     */
    public function node()
    {
        return $this->node;
    }

    /**
     * @param Agent|null $agent
     *
     * @return Agent
     */
    private function validateAgent($agent)
    {
        return null === $agent
            ? Agent::discover()
            : $agent;
    }

    /**
     * @param string|null $name
     *
     * @return string|null
     */
    private function validateName($name)
    {
        return 1 === preg_match('/^[a-zA-Z0-9 _-]+$/', $name)
            ? $name
            : null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'agent' => $this->agent,
            'framework' => $this->framework,
            'language' => $this->language,
            'name' => Encoding::keywordField($this->name),
            'environment' => Encoding::keywordField($this->environment),
            'runtime' => $this->runtime,
            'version' => Encoding::keywordField($this->version),
            'node' => $this->node,
        ];
    }
}
