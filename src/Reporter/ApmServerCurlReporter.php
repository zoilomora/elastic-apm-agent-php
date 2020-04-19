<?php

namespace ZoiloMora\ElasticAPM\Reporter;

use ZoiloMora\ElasticAPM\Events\Common\Service\Agent;
use ZoiloMora\ElasticAPM\Helper\NDJson;

final class ApmServerCurlReporter implements Reporter
{
    const URI = '/intake/v2/events';

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @param array $events
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(array $events)
    {
        if (false === $this->isActive()) {
            return;
        }

        $url = $this->getUrl();
        $body = NDJson::convert($events);
        $headers = $this->getHttpHeaders(
            $this->getHeaders($body)
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $httpStatusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (202 !== $httpStatusCode) {
            throw new ReporterException($response, $httpStatusCode);
        }
    }

    /**
     * @return bool
     */
    private function isActive()
    {
        $env = getenv('ELASTIC_APM_ACTIVE');
        if (false === $env) {
            return true;
        }

        return (bool) $env;
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        return sprintf(
            '%s%s',
            $this->baseUri,
            self::URI
        );
    }

    /**
     * @param array $headers
     *
     * @return void
     *
     * @return array
     */
    private function getHttpHeaders(array $headers)
    {
        return array_map(
            static function ($key, $value) {
                return sprintf(
                    '%s: %s',
                    $key,
                    $value
                );
            },
            array_keys($headers),
            array_values($headers)
        );
    }

    /**
     * @param string $body
     *
     * @return array
     */
    private function getHeaders($body)
    {
        return array_merge(
            $this->defaultRequestHeaders(),
            [
                'Content-Length' => strlen($body),
            ]
        );
    }

    /**
     * @return array
     */
    private function defaultRequestHeaders()
    {
        return [
            'Content-Type' => NDJson::contentType(),
            'User-Agent' => sprintf('%s/%s', Agent::NAME, Agent::VERSION),
            'Accept' => 'application/json',
        ];
    }
}
