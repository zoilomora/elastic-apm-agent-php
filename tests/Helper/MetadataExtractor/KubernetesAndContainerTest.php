<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper\MetadataExtractor;

use ZoiloMora\ElasticAPM\Helper\MetadataExtractor\KubernetesAndContainer;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Utils\ControlGroup\ControlGroup;
use ZoiloMora\ElasticAPM\Utils\ControlGroup\ControlGroupRepository;

class KubernetesAndContainerTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_instantiating_then_return_object()
    {
        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock()
        );

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Helper\MetadataExtractor\KubernetesAndContainer', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_call_the_singleton_then_return_object()
    {
        $object = KubernetesAndContainer::instance();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Helper\MetadataExtractor\KubernetesAndContainer', $object);
    }

    /**
     * @test
     */
    public function given_without_control_groups_when_instantiated_then_properties_are_null()
    {
        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock()
        );

        self::assertNull($object->podId());
        self::assertNull($object->containerId());
    }

    /**
     * @test
     */
    public function given_an_empty_group_control_when_instantiated_then_properties_are_null()
    {
        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(),
            ])
        );

        self::assertNull($object->podId());
        self::assertNull($object->containerId());
    }

    /**
     * @test
     */
    public function given_a_docker_group_control_when_instantiated_then_container_id_is_assigned()
    {
        $containerId = '3c3b189f51e751ee4ef53fbe91d11721769bc8c2852b1df73071b66f294825e2';

        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(
                    sprintf(
                        '/docker/%s',
                        $containerId
                    )
                ),
            ])
        );

        self::assertNull($object->podId());
        self::assertEquals($containerId, $object->containerId());
    }

    /**
     * @test
     */
    public function given_a_uuid_docker_group_control_when_instantiated_then_container_id_is_assigned()
    {
        $containerId = 'eb493a52-7e31-11ea-bb0c-0050';

        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(
                    sprintf(
                        '/docker/%s',
                        $containerId
                    )
                ),
            ])
        );

        self::assertNull($object->podId());
        self::assertEquals($containerId, $object->containerId());
    }

    /**
     * @test
     */
    public function given_a_kubernetes_group_control_when_instantiated_then_container_id_is_assigned()
    {
        $podId = 'eb493a52-7e31-11ea-bb0c-005056010147';
        $containerId = 'c67ce50acf3a23437f26eedea7428617195032f5a753dde2a42f2cbee4dfd297';

        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(
                    sprintf(
                        '/kubepods/burstable/pod%s/%s',
                        $podId,
                        $containerId
                    )
                ),
            ])
        );

        self::assertEquals($podId, $object->podId());
        self::assertEquals($containerId, $object->containerId());
    }

    /**
     * @test
     */
    public function given_a_kubernetes_group_control_with_scope_suffix_when_instantiated_then_container_id_is_assigned()
    {
        $podId = 'eb493a52-7e31-11ea-bb0c-005056010147';
        $containerId = 'c67ce50acf3a23437f26eedea7428617195032f5a753dde2a42f2cbee4dfd297';

        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(
                    sprintf(
                        '/kubepods/burstable/pod%s/%s.scope',
                        $podId,
                        $containerId
                    )
                ),
            ])
        );

        self::assertEquals($podId, $object->podId());
        self::assertEquals($containerId, $object->containerId());
    }

    /**
     * @test
     */
    public function given_a_kubernetes_group_control_with_slice_format_when_instantiated_then_container_id_is_assigned()
    {
        $podId = 'eb493a52-7e31-11ea-bb0c-005056010147';
        $containerId = 'c67ce50acf3a23437f26eedea7428617195032f5a753dde2a42f2cbee4dfd297';

        $object = new KubernetesAndContainer(
            $this->getControlGroupRepositoryMock([
                $this->getControlGroupMock(
                    sprintf(
                        '/kubepods.slice/kubepods-rand.slice/kubepods-rand-pod%s.slice/%s',
                        $podId,
                        $containerId
                    )
                ),
            ])
        );

        self::assertEquals($podId, $object->podId());
        self::assertEquals($containerId, $object->containerId());
    }

    /**
     * @param ControlGroup[] $controlGroups
     *
     * @return ControlGroupRepository
     */
    private function getControlGroupRepositoryMock(array $controlGroups = [])
    {
        $controlGroupRepository = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Utils\ControlGroup\ControlGroupRepository'
        );

        $controlGroupRepository
            ->expects(self::once())
            ->method('findAll')
            ->willReturn($controlGroups)
        ;

        return $controlGroupRepository;
    }

    /**
     * @param string $path
     *
     * @return ControlGroup
     */
    private function getControlGroupMock($path = '')
    {
        $controlGroup = $this->getMockWithoutConstructor(
            'ZoiloMora\ElasticAPM\Utils\ControlGroup\ControlGroup'
        );

        $controlGroup
            ->expects(self::once())
            ->method('path')
            ->willReturn($path)
        ;

        return $controlGroup;
    }
}
