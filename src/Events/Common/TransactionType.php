<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Transaction Type
 */
trait TransactionType
{
    /**
     * Keyword of specific relevance in the service's domain (eg: 'request', 'backgroundjob', etc)
     *
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    private function getEncodingType()
    {
        return Encoding::keywordField($this->type);
    }
}
