<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Cloud\Account;
use ZoiloMora\ElasticAPM\Events\Common\Cloud\Instance;
use ZoiloMora\ElasticAPM\Events\Common\Cloud\Machine;
use ZoiloMora\ElasticAPM\Events\Common\Cloud\Project;
use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Cloud implements \JsonSerializable
{
    /**
     * @var Account|null
     */
    private $account;

    /**
     * Cloud availability zone name. e.g. us-east-1a
     *
     * @var string|null
     */
    private $availabilityZone;

    /**
     * @var Instance|null
     */
    private $instance;

    /**
     * @var Machine|null
     */
    private $machine;

    /**
     * @var Project|null
     */
    private $project;

    /**
     * Cloud provider name. e.g. aws, azure, gcp, digitalocean.
     *
     * @var string|null
     */
    private $provider;

    /**
     * Cloud region name. e.g. us-east-1
     *
     * @var string|null
     */
    private $region;

    /**
     * @param string|null $provider
     * @param Account|null $account
     * @param string|null $availabilityZone
     * @param Instance|null $instance
     * @param Machine|null $machine
     * @param Project|null $project
     * @param string|null $region
     */
    public function __construct(
        $provider = null,
        Account $account = null,
        $availabilityZone = null,
        Instance $instance = null,
        Machine $machine = null,
        Project $project = null,
        $region = null
    ) {
        $this->provider = $provider;
        $this->account = $account;
        $this->availabilityZone = $availabilityZone;
        $this->instance = $instance;
        $this->machine = $machine;
        $this->project = $project;
        $this->region = $region;
    }

    /**
     * @return Account
     */
    public function account()
    {
        return $this->account;
    }

    /**
     * @return string|null
     */
    public function availabilityZone()
    {
        return $this->availabilityZone;
    }

    /**
     * @return Instance
     */
    public function instance()
    {
        return $this->instance;
    }

    /**
     * @return Machine
     */
    public function machine()
    {
        return $this->machine;
    }

    /**
     * @return Project
     */
    public function project()
    {
        return $this->project;
    }

    /**
     * @return string|null
     */
    public function provider()
    {
        return $this->provider;
    }

    /**
     * @return string|null
     */
    public function region()
    {
        return $this->region;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'account' => $this->account,
            'availability_zone' => Encoding::keywordField($this->availabilityZone),
            'instance' => $this->instance,
            'machine' => $this->machine,
            'project' => $this->project,
            'provider' => Encoding::keywordField($this->provider),
            'region' => Encoding::keywordField($this->region),
        ];
    }
}
