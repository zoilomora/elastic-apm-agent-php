<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Cloud;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class CloudTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Cloud();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Cloud', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $provider = 'Google';
        $account = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Cloud\Account');
        $availabilityZone = 'us-east-1a';
        $instance = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Cloud\Instance');
        $machine = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Cloud\Machine');
        $project = $this->getMockWithoutConstructor('ZoiloMora\ElasticAPM\Events\Common\Cloud\Project');
        $region = 'us-east-1';

        $object = new Cloud(
            $provider,
            $account,
            $availabilityZone,
            $instance,
            $machine,
            $project,
            $region
        );

        self::assertSame($provider, $object->provider());
        self::assertSame($account, $object->account());
        self::assertSame($availabilityZone, $object->availabilityZone());
        self::assertSame($instance, $object->instance());
        self::assertSame($machine, $object->machine());
        self::assertSame($project, $object->project());
        self::assertSame($region, $object->region());
    }

    /**
     * @test
     */
    public function given_a_cloud_when_serialize_then_right_serialization()
    {
        $accountValue = 'account';
        $instanceValue = 'instance';
        $machineValue = '$machine';
        $projectValue = 'project';

        $provider = 'Google';
        $account = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Cloud\Account', $accountValue);
        $availabilityZone = 'us-east-1a';
        $instance = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Cloud\Instance', $instanceValue);
        $machine = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Cloud\Machine', $machineValue);
        $project = $this->getMockSerializable('ZoiloMora\ElasticAPM\Events\Common\Cloud\Project', $projectValue);
        $region = 'us-east-1';

        $object = new Cloud(
            $provider,
            $account,
            $availabilityZone,
            $instance,
            $machine,
            $project,
            $region
        );

        $expected = json_encode([
            'account' => $accountValue,
            'availability_zone' => $availabilityZone,
            'instance' => $instanceValue,
            'machine' => $machineValue,
            'project' => $projectValue,
            'provider' => $provider,
            'region' => $region,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
