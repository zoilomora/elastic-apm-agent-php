<?php

namespace ZoiloMora\ElasticAPM\Tests\Helper;

use ZoiloMora\ElasticAPM\Helper\HttpHeaderSanitizer;
use ZoiloMora\ElasticAPM\Tests\Utils\TestCase;

class HttpHeaderSanitizerTest extends TestCase
{
    /**
     * @test
     * @dataProvider headerProvider
     *
     * @param string $header
     */
    public function given_secret_http_headers_when_sanitize_then_returns_empty($header)
    {
        $result = HttpHeaderSanitizer::sanitize([
            $header => '',
        ]);

        self::assertEmpty($result);
    }

    public function headerProvider()
    {
        return [
            [
                'password',
            ],
            [
                'passwd',
            ],
            [
                'pwd',
            ],
            [
                'secret',
            ],
            [
                'key',
            ],
            [
                'user-key',
            ],
            [
                'token',
            ],
            [
                'user-token',
            ],
            [
                'user-token-app',
            ],
            [
                'session',
            ],
            [
                'user-session',
            ],
            [
                'user-session-app',
            ],
            [
                'credit',
            ],
            [
                'app-credit',
            ],
            [
                'credit-visa',
            ],
            [
                'credit-card',
            ],
            [
                'card',
            ],
            [
                'app-card',
            ],
            [
                'app-card-game',
            ],
            [
                'authorization',
            ],
            [
                'Authorization',
            ],
            [
                'set-cookie',
            ],
        ];
    }
}
