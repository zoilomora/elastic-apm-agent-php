<?php

namespace ZoiloMora\ElasticAPM\Events;

use ZoiloMora\ElasticAPM\Helper\Cryptography;
use ZoiloMora\ElasticAPM\Helper\Encoding;

abstract class Event implements \JsonSerializable
{
    const EVENT_ID_BITS = 64;

    /**
     * Hex encoded 64 random bits ID of the transaction.
     *
     * @var string
     */
    protected $id;

    public function __construct()
    {
        $this->id = $this->generateId();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function generateId()
    {
        return Cryptography::generateRandomBitsInHex(self::EVENT_ID_BITS);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => Encoding::keywordField($this->id),
        ];
    }
}
