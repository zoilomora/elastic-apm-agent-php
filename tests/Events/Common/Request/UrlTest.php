<?php

namespace ZoiloMora\ElasticAPM\Tests\Events\Common\Request;

use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;
use ZoiloMora\ElasticAPM\Events\Common\Request\Url;

class UrlTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();

        unset($_SERVER['HTTPS']);
        unset($_SERVER['HTTP_HOST']);
        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['QUERY_STRING']);
    }

    /**
     * @test
     */
    public function given_no_data_when_instantiating_then_return_object()
    {
        $object = new Url();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request\Url', $object);
    }

    /**
     * @test
     */
    public function given_data_when_instantiating_then_can_get_properties()
    {
        $raw = 'raw';
        $protocol = 'protocol';
        $full = 'full';
        $hostname = 'hostname';
        $port = 'port';
        $pathname = 'pathname';
        $search = 'search';
        $hash = 'hash';

        $object = new Url(
            $raw,
            $protocol,
            $full,
            $hostname,
            $port,
            $pathname,
            $search,
            $hash
        );

        self::assertSame($raw, $object->raw());
        self::assertSame($protocol, $object->protocol());
        self::assertSame($full, $object->full());
        self::assertSame($hostname, $object->hostname());
        self::assertSame($port, $object->port());
        self::assertSame($pathname, $object->pathname());
        self::assertSame($search, $object->search());
        self::assertSame($hash, $object->hash());
    }

    /**
     * @test
     */
    public function given_no_data_when_try_to_discover_then_return_object()
    {
        $object = Url::discover();

        self::assertInstanceOf('ZoiloMora\ElasticAPM\Events\Common\Request\Url', $object);
    }

    /**
     * @test
     */
    public function given_https_environment_when_try_to_discover_then_return_object()
    {
        $_SERVER['HTTPS'] = 'on';

        $object = Url::discover();

        self::assertSame('https', $object->protocol());
    }

    /**
     * @test
     */
    public function given_http_request_when_try_to_discover_then_return_object_with_full_url()
    {
        $protocol = 'https';
        $host = 'example.com';
        $requestUri = '/index.php';

        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = $host;
        $_SERVER['REQUEST_URI'] = $requestUri;

        $expected = sprintf(
            '%s://%s%s',
            $protocol,
            $host,
            $requestUri
        );

        $object = Url::discover();

        self::assertSame($expected, $object->full());
    }

    /**
     * @test
     */
    public function given_query_http_request_when_try_to_discover_then_return_object_with_search()
    {
        $query = 'key=value';

        $_SERVER['QUERY_STRING'] = $query;

        $expected = sprintf('?%s', $query);

        $object = Url::discover();

        self::assertSame($expected, $object->search());
    }

    /**
     * @test
     */
    public function given_a_url_when_serialize_then_right_serialization()
    {
        $raw = 'raw';
        $protocol = 'protocol';
        $full = 'full';
        $hostname = 'hostname';
        $port = 'port';
        $pathname = 'pathname';
        $search = 'search';
        $hash = 'hash';

        $object = new Url(
            $raw,
            $protocol,
            $full,
            $hostname,
            $port,
            $pathname,
            $search,
            $hash
        );

        $expected = json_encode([
            'raw' => $raw,
            'protocol' => $protocol,
            'full' => $full,
            'hostname' => $hostname,
            'port' => $port,
            'pathname' => $pathname,
            'search' => $search,
            'hash' => $hash,
        ]);

        self::assertSame($expected, json_encode($object));
    }
}
