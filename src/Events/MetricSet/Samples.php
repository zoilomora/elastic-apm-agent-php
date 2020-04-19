<?php

namespace ZoiloMora\ElasticAPM\Events\MetricSet;

use ZoiloMora\ElasticAPM\Utils\Collection;

final class Samples extends Collection
{
    /**
     * @param array $items
     *
     * @return Samples
     */
    public static function from(array $items)
    {
        foreach ($items as $item) {
            if (false === $item instanceof Sample) {
                throw new \InvalidArgumentException('All elements must be of type Sample.');
            }
        }

        if (0 === count($items)) {
            throw new \InvalidArgumentException('There must be at least one element.');
        }

        return parent::from($items);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = [];

        $items = parent::jsonSerialize();

        /** @var Sample $item */
        foreach ($items as $item) {
            $result = array_merge(
                $result,
                (array) json_decode(
                    (string) json_encode($item),
                    true
                )
            );
        }

        return $result;
    }
}
