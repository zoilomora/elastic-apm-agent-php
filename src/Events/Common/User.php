<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Helper\Encoding;

class User implements \JsonSerializable
{
    /**
     * Identifier of the logged in user, e.g. the primary key of the user
     *
     * @var string|int|null
     */
    private $id;

    /**
     * Email of the logged in user
     *
     * @var string|null
     */
    private $email;

    /**
     * The username of the logged in user
     *
     * @var string|null
     */
    private $username;

    /**
     * @param int|string|null $id
     * @param string|null $email
     * @param string|null $username
     */
    public function __construct($id = null, $email = null, $username = null)
    {
        $this->assertId($id);
        $this->assertEmail($email);
        $this->assertUsername($username);

        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    /**
     * @param mixed $id
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertId($id)
    {
        if (null !== $id && false === is_int($id) && false === is_string($id)) {
            throw new \InvalidArgumentException('[id] must be one of these types: integer, string or null.');
        }
    }

    /**
     * @param mixed $email
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertEmail($email)
    {
        if (null !== $email && false === is_string($email)) {
            throw new \InvalidArgumentException('[email] must be one of these types: string or null.');
        }
    }

    /**
     * @param mixed $username
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertUsername($username)
    {
        if (null !== $username && false === is_string($username)) {
            throw new \InvalidArgumentException('[username] must be one of these types: string or null.');
        }
    }

    /**
     * @return int|string|null
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => Encoding::keywordField($this->id),
            'email' => Encoding::keywordField($this->email),
            'username' => Encoding::keywordField($this->username),
        ];
    }
}
