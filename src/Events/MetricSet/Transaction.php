<?php

namespace ZoiloMora\ElasticAPM\Events\MetricSet;

use ZoiloMora\ElasticAPM\Events\Common\TransactionName;
use ZoiloMora\ElasticAPM\Events\Common\TransactionType;

final class Transaction implements \JsonSerializable
{
    use TransactionName;
    use TransactionType;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type)
    {
        $this->assertName($name);
        $this->assertType($type);

        $this->name = (string) $name;
        $this->type = (string) $type;
    }

    /**
     * @param mixed $name
     *
     * @return void
     */
    private function assertName($name)
    {
        if (false === is_string($name)) {
            throw new \InvalidArgumentException('The [name] must be of type string.');
        }
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->getEncodingName(),
            'type' => $this->getEncodingType(),
        ];
    }
}
