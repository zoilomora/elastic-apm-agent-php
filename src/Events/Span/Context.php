<?php

namespace ZoiloMora\ElasticAPM\Events\Span;

use ZoiloMora\ElasticAPM\Events\Common\Message;
use ZoiloMora\ElasticAPM\Events\Common\Tags;
use ZoiloMora\ElasticAPM\Events\Span\Context\Db;
use ZoiloMora\ElasticAPM\Events\Span\Context\Destination;
use ZoiloMora\ElasticAPM\Events\Span\Context\Http;

/**
 * Any other arbitrary data captured by the agent, optionally provided by the user
 */
final class Context implements \JsonSerializable
{
    /**
     * An object containing contextual data about the destination for spans
     *
     * @var Destination|null
     */
    private $destination;

    /**
     * An object containing contextual data for database spans
     *
     * @var Db|null
     */
    private $db;

    /**
     * An object containing contextual data of the related http request.
     *
     * @var Http|null
     */
    private $http;

    /**
     * A flat mapping of user-defined tags with string, boolean or number values.
     * "string", "boolean", "number", "null"
     *
     * @var Tags|null
     */
    private $tags;

    /**
     * Details related to message receiving and publishing if the captured event
     * integrates with a messaging system
     *
     * @var Message|null
     */
    private $message;

    /**
     * @param Destination|null $destination
     * @param Db|null $db
     * @param Http|null $http
     * @param Tags|null $tags
     * @param Message|null $message
     */
    public function __construct(
        Destination $destination = null,
        Db $db = null,
        Http $http = null,
        Tags $tags = null,
        Message $message = null
    ) {
        $this->destination = $destination;
        $this->db = $db;
        $this->http = $http;
        $this->tags = $tags;
        $this->message = $message;
    }

    /**
     * @param Db $db
     *
     * @return Context
     */
    public static function fromDb(Db $db)
    {
        return new self(null, $db);
    }

    /**
     * @param Http $http
     *
     * @return Context
     */
    public static function fromHttp(Http $http)
    {
        return new self(null, null, $http);
    }

    /**
     * @param Message $message
     *
     * @return Context
     */
    public static function fromMessage(Message $message)
    {
        return new self(null, null, null, null, $message);
    }

    /**
     * @return Destination|null
     */
    public function destination()
    {
        return $this->destination;
    }

    /**
     * @return Db|null
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * @return Http|null
     */
    public function http()
    {
        return $this->http;
    }

    /**
     * @return Tags|null
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * @return Message|null
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'destination' => $this->destination,
            'db' => $this->db,
            'http' => $this->http,
            'tags' => $this->tags,
            'message' => $this->message,
        ];
    }
}
