<?php

namespace ZoiloMora\ElasticAPM\Events\Span\Context;

use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * An object containing contextual data for database spans
 */
final class Db implements \JsonSerializable
{
    /**
     * Database instance name
     *
     * @var string|null
     */
    private $instance;

    /**
     * Database link
     *
     * @var string|null
     */
    private $link;

    /**
     * A database statement (e.g. query) for the given database type
     *
     * @var string|null
     */
    private $statement;

    /**
     * Database type. For any SQL database, "sql".
     * For others, the lower-case database category, e.g. "cassandra", "hbase", or "redis"
     *
     * @var string|null
     */
    private $type;

    /**
     * Username for accessing database
     *
     * @var string|null
     */
    private $user;

    /**
     * Number of rows affected by the SQL statement (if applicable)
     *
     * @var string|null
     */
    private $rowsAffected;

    /**
     * @param string|null $instance
     * @param string|null $link
     * @param string|null $statement
     * @param string|null $type
     * @param string|null $user
     * @param string|null $rowsAffected
     */
    public function __construct(
        $instance = null,
        $link = null,
        $statement = null,
        $type = null,
        $user = null,
        $rowsAffected = null
    ) {
        $this->instance = $instance;
        $this->link = $link;
        $this->statement = $statement;
        $this->type = $type;
        $this->user = $user;
        $this->rowsAffected = $rowsAffected;
    }

    /**
     * @return string|null
     */
    public function instance()
    {
        return $this->instance;
    }

    /**
     * @return string|null
     */
    public function link()
    {
        return $this->link;
    }

    /**
     * @return string|null
     */
    public function statement()
    {
        return $this->statement;
    }

    /**
     * @return string|null
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function rowsAffected()
    {
        return $this->rowsAffected;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'instance' => $this->instance,
            'link' => Encoding::keywordField($this->link),
            'statement' => $this->statement,
            'type' => $this->type,
            'user' => $this->user,
            'rows_affected' => $this->rowsAffected,
        ];
    }
}
