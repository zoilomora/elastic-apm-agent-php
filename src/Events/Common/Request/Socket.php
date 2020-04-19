<?php

namespace ZoiloMora\ElasticAPM\Events\Common\Request;

/**
 * Socket
 */
final class Socket implements \JsonSerializable
{
    /**
     * Indicates whether request was sent as SSL/HTTPS request.
     *
     * @var bool|null
     */
    private $encrypted;

    /**
     * The network address sending the request.
     * Should be obtained through standard APIs and not parsed from any headers like 'Forwarded'.
     *
     * @var string|null
     */
    private $remoteAddress;

    /**
     * @param bool|null $encrypted
     * @param string|null $remoteAddress
     */
    public function __construct($encrypted = null, $remoteAddress = null)
    {
        $this->encrypted = $encrypted;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @return bool|null
     */
    public function encrypted()
    {
        return $this->encrypted;
    }

    /**
     * @return string|null
     */
    public function remoteAddress()
    {
        return $this->remoteAddress;
    }

    /**
     * @return Socket
     */
    public static function discover()
    {
        return new self(
            self::isEncrypted(),
            self::getRemoteAddress()
        );
    }

    /**
     * @return bool
     */
    private static function isEncrypted()
    {
        if (false === array_key_exists('HTTPS', $_SERVER)) {
            return false;
        }

        return 'off' !== $_SERVER['HTTPS'];
    }

    /**
     * @return string|null
     */
    private static function getRemoteAddress()
    {
        $remoteAddress = null;

        if (true === array_key_exists('REMOTE_ADDR', $_SERVER)) {
            $remoteAddress = $_SERVER['REMOTE_ADDR'];
        }

        if (true === array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $remoteAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return null === $remoteAddress
            ? null
            : (string) $remoteAddress;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'encrypted' => $this->encrypted,
            'remote_address' => $this->remoteAddress,
        ];
    }
}
