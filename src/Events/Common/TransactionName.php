<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Transaction Name
 */
trait TransactionName
{
    /**
     * Generic designation of a transaction in the scope of a single service (eg: 'GET /users/:id')
     *
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    private function getEncodingName()
    {
        return Encoding::keywordField($this->name);
    }
}
