<?php

namespace ZoiloMora\ElasticAPM\Events\MetricSet;

/**
 * A single metric sample.
 */
final class Sample implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var double
     */
    private $value;

    /**
     * @param string $name
     * @param double $value
     */
    public function __construct($name, $value)
    {
        $this->assertName($name);

        $this->name = $name;
        $this->value = (double) $value;
    }

    /**
     * @param string|null $name
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertName($name)
    {
        if (false === is_string($name)) {
            throw new \InvalidArgumentException('The [name] must be of type string.');
        }

        if (0 === preg_match('/^[^*"]*$/', $name)) {
            throw new \InvalidArgumentException('The [name] must match the regular expression /^[^*"]*$/');
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            $this->name => [
                'value' => $this->value,
            ]
        ];
    }
}
