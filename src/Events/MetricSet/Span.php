<?php

namespace ZoiloMora\ElasticAPM\Events\MetricSet;

use ZoiloMora\ElasticAPM\Events\Common\SpanSubtype;
use ZoiloMora\ElasticAPM\Events\Common\SpanType;

final class Span implements \JsonSerializable
{
    use SpanType;
    use SpanSubtype;

    /**
     * @param string $type
     * @param string|null $subtype
     */
    public function __construct($type, $subtype)
    {
        $this->assertType($type);
        $this->assertSubType($subtype);

        $this->type = (string) $type;
        $this->subtype = $subtype;
    }

    /**
     * @param mixed $type
     *
     * @return void
     */
    private function assertType($type)
    {
        if (false === is_string($type)) {
            throw new \InvalidArgumentException('The [type] must be of type string.');
        }
    }

    /**
     * @param mixed $subtype
     *
     * @return void
     */
    private function assertSubType($subtype)
    {
        if (null !== $subtype && false === is_string($subtype)) {
            throw new \InvalidArgumentException('The [subType] must be of type string or null.');
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $payload = [
            'type' => $this->getEncodingType(),
        ];

        if (null !== $this->subtype) {
            $payload['subtype'] = $this->getEncodingSubtype();
        }

        return $payload;
    }
}
