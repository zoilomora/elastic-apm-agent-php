<?php

namespace ZoiloMora\ElasticAPM\Helper;

final class DistributedTracing
{
    /**
     * Supporting Elastic's Traceparent Header until W3C goes GA
     *
     * @link https://www.w3.org/TR/trace-context/#header-name
     */
    const HEADER_NAME = 'ELASTIC-APM-TRACEPARENT';

    /**
     * @link https://www.w3.org/TR/trace-context/#version
     */
    const VERSION = '00';

    /**
     * @var DistributedTracing
     */
    private static $fakeDistributedTracing;

    /**
     * @var string
     */
    private $traceId;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $traceFlags;

    /**
     * @param DistributedTracing|null $fakeDistributedTracing
     *
     * @return void
     */
    public static function fakeDistributedTracing(DistributedTracing $fakeDistributedTracing = null)
    {
        self::$fakeDistributedTracing = $fakeDistributedTracing;
    }

    /**
     * @param string $traceId
     * @param string $parentId
     * @param string $traceFlags
     */
    public function __construct($traceId, $parentId, $traceFlags = '00')
    {
        $this->traceId = $traceId;
        $this->parentId = $parentId;
        $this->traceFlags = $traceFlags;
    }

    /**
     * @return string
     */
    public function traceId()
    {
        return $this->traceId;
    }

    /**
     * @return string
     */
    public function parentId()
    {
        return $this->parentId;
    }

    /**
     * @return string
     */
    public function traceFlags()
    {
        return $this->traceFlags;
    }

    /**
     * @return DistributedTracing|null
     *
     * @throws \Exception
     */
    public static function discoverDistributedTracing()
    {
        if (null !== self::$fakeDistributedTracing) {
            return self::$fakeDistributedTracing;
        }

        $traceHeader = self::traceHeader();
        if (null === $traceHeader) {
            return null;
        }

        return self::createFromHeader($traceHeader);
    }

    /**
     * @return string|null
     */
    private static function traceHeader()
    {
        $key = sprintf(
            'HTTP_%s',
            str_replace(
                '-',
                '_',
                self::HEADER_NAME
            )
        );

        if (false === array_key_exists($key, $_SERVER)) {
            return null;
        }

        return (string) $_SERVER[$key];
    }

    /**
     * Check if the Header Value is valid
     *
     * @link https://www.w3.org/TR/trace-context/#version-format
     *
     * @param string $header
     *
     * @return bool
     */
    private static function isValidHeader($header)
    {
        return 1 === preg_match('/^'.self::VERSION.'-[\da-f]{32}-[\da-f]{16}-[\da-f]{2}$/', $header);
    }

    /**
     * @param string $header
     *
     * @return DistributedTracing
     *
     * @throws \Exception
     */
    private static function createFromHeader($header)
    {
        if (false === self::isValidHeader($header)) {
            throw new \Exception('Invalid distributed trace header.');
        }

        $parsed = explode('-', $header);

        return new self($parsed[1], $parsed[2], $parsed[3]);
    }

    /**
     * Get Distributed Tracing Id
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s-%s-%s-%s',
            self::VERSION,
            $this->traceId,
            $this->parentId,
            $this->traceFlags
        );
    }
}
