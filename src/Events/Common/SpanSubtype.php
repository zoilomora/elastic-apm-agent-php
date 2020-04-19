<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Span Subtype
 */
trait SpanSubtype
{
    /**
     * A further sub-division of the type (e.g. postgresql, elasticsearch)
     *
     * @var string|null
     */
    private $subtype;

    /**
     * @return string|null
     */
    public function subtype()
    {
        return $this->subtype;
    }

    /**
     * @return string
     */
    private function getEncodingSubtype()
    {
        return Encoding::keywordField($this->subtype);
    }
}
