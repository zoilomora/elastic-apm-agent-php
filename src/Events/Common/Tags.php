<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Utils\Collection;
use ZoiloMora\ElasticAPM\Helper\Encoding;

final class Tags extends Collection
{
    /**
     * @var array
     */
    private static $typesOfAllowedValues = [
        'string',
        'boolean',
        'double',
        'integer',
        'NULL',
    ];

    /**
     * @param array $items
     *
     * @return Tags
     */
    public static function from(array $items)
    {
        $filteredItems = [];

        foreach ($items as $name => $value) {
            if (0 === preg_match('/^[^.*\"]*$/', $name)) {
                throw new \InvalidArgumentException('The name must match the regular expression /^[^.*\"]*$/');
            }

            $typeValue = gettype($value);
            if (false === in_array($typeValue, self::$typesOfAllowedValues)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'The value is of an illegal type. Allowed types: %s. Given value: %s',
                        implode(', ', self::$typesOfAllowedValues),
                        $typeValue
                    )
                );
            }

            $filteredItems[$name] = true === is_string($value)
                ? Encoding::keywordField($value)
                : $value;
        }

        return parent::from($items);
    }
}
