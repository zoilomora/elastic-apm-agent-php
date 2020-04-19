<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Events\Common\Context\Response;

/**
 * Any arbitrary contextual information regarding the event, captured by the agent, optionally provided by the user
 */
class Context implements \JsonSerializable
{
    /**
     * An arbitrary mapping of additional metadata to store with the event.
     *
     * @var array|null
     */
    private $custom;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * If a log record was generated as a result of a http request,
     * the http interface can be used to collect this information.
     *
     * @var Request|null
     */
    private $request;

    /**
     * A flat mapping of user-defined tags with string, boolean or number values.
     *
     * @var Tags|null
     */
    private $tags;

    /**
     * Describes the correlated user for this event.
     * If user data are provided here, all user related information from metadata is ignored,
     * otherwise the metadata's user information will be stored with the event.
     *
     * @var User|null
     */
    private $user;

    /**
     * @var Message|null
     */
    private $message;

    /**
     * @param array|null $custom
     * @param Response|null $response
     * @param Request|null $request
     * @param Tags|null $tags
     * @param User|null $user
     * @param Message|null $message
     */
    public function __construct(
        array $custom = null,
        Response $response = null,
        Request $request = null,
        Tags $tags = null,
        User $user = null,
        Message $message = null
    ) {
        $this->setCustom($custom);
        $this->setResponse($response);
        $this->setRequest($request);
        $this->setTags($tags);
        $this->setUser($user);
        $this->setMessage($message);
    }

    /**
     * @return array|null
     */
    public function custom()
    {
        return $this->custom;
    }

    /**
     * @param array|null $custom
     *
     * @return void
     */
    public function setCustom(array $custom = null)
    {
        $this->custom = $custom;
    }

    /**
     * @return Response|null
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @param Response|null $response
     *
     * @return void
     */
    public function setResponse(Response $response = null)
    {
        $this->response = $response;
    }

    /**
     * @return Request|null
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * @param Request|null $request
     *
     * @return void
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * @return array|Tags|null
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * @param Tags|null $tags
     *
     * @return void
     */
    public function setTags(Tags $tags = null)
    {
        $this->tags = $tags;
    }

    /**
     * @return User|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return void
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return Message|null
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return void
     */
    public function setMessage(Message $message = null)
    {
        $this->message = $message;
    }

    /**
     * @return Context
     */
    public static function discover()
    {
        return new self(
            null,
            null,
            Request::discover()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'custom' => $this->custom,
            'response' => $this->response,
            'request' => $this->request,
            'tags' => $this->tags,
            'user' => $this->user,
            'message' => $this->message,
        ];
    }
}
