<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Service;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Service\Language;

class LanguageTest extends TestCase
{
    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Language();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Language', $object);
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Language::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Service\Language', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $name = 'name';
        $version = 'version';

        $object = new Language(
            $name,
            $version
        );

        self::assertSame($name, $object->name());
        self::assertSame($version, $object->version());
    }

    /**
     * @test
     */
    public function given_a_language_when_serialize_then_right_serialization()
    {
        $name = 'name';
        $version = 'version';

        $object = new Language(
            $name,
            $version
        );

        $expected = json_encode([
            'name' => $name,
            'version' => $version,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
