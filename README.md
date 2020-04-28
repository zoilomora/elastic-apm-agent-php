<h1 align="center">
    Elastic APM agent for PHP
    <br>
    <a href="#">
        <img src="docs/logo/logo.png" width="25%">
    </a>
</h1>

<p align="center">
<a href="https://github.com/zoilomora/elastic-apm-agent-php/actions?query=workflow%3A%22Build%22"><img src="https://img.shields.io/github/workflow/status/zoilomora/elastic-apm-agent-php/Build?cacheSeconds=86400" alt="Build Status"/></a>
<a href="https://scrutinizer-ci.com/g/zoilomora/elastic-apm-agent-php/?branch=master"><img src="https://img.shields.io/scrutinizer/coverage/g/zoilomora/elastic-apm-agent-php?cacheSeconds=86400" alt="Coverage Status"/></a>
<a href="https://scrutinizer-ci.com/g/zoilomora/elastic-apm-agent-php/?branch=master"><img src="https://img.shields.io/scrutinizer/quality/g/zoilomora/elastic-apm-agent-php?cacheSeconds=86400" alt="Quality Status"/></a>
<a href="https://packagist.org/packages/zoilomora/elastic-apm-agent-php"><img src="https://img.shields.io/packagist/php-v/zoilomora/elastic-apm-agent-php?cacheSeconds=86400" alt="PHP Version"/></a>
<a href="https://github.com/zoilomora/elastic-apm-agent-php/releases"><img src="https://img.shields.io/packagist/v/zoilomora/elastic-apm-agent-php?include_prereleases&cacheSeconds=86400" alt="Latest Version"/></a>
<a href="https://github.com/zoilomora/elastic-apm-agent-php/blob/master/LICENSE"><img src="https://img.shields.io/github/license/zoilomora/elastic-apm-agent-php?cacheSeconds=86400" alt="License"/></a>
</p>

This is an Agent written in PHP that implements the [Intake API v2] scheme to send tracking information to [Elastic APM].

## Why?

I couldn't find an [official APM Agent] for PHP.

I have searched for unofficial options but I have not found any with backwards compatibility of PHP version (>= 5.4).
I know [PHP 5.4] is very old (01 Mar 2012) but today there is still code working even with older versions.

I wanted to make it as easy as possible to develop new microservices and also to make it possible to help legacy code refactors be easier to accomplish.

I have based myself on the official [API reference of version 7.6].

## Installation

1) Install via [composer]

    ```shell script
    composer require zoilomora/elastic-apm-agent-php
    ```

## Usage

You can implement any **Reporter** to suit your communication infrastructure (sync, async, redis, amqp, etc...).

```php
<?php

class OwnerReporter implements \ZoiloMora\ElasticAPM\Reporter\Reporter
{
    /**
     * @param array $events
     *
     * @return void
     */
    public function report(array $events)
    {
        // TODO: Implement report() method.
    }
}
```

If you are using **Kubernetes**, it is recommended that you use the [official environment variables] to map **Nodes** and **Pods**.

## Examples

- [Configuration](docs/examples/configuration.md)
- [Metadata](docs/examples/metadata.md)
- [Transaction Context](docs/examples/transaction-context.md)
- [Agent Instantiate](docs/examples/agent-instantiate.md)
- [Basic Usage](docs/examples/basic-usage.md)
- [Distributed Tracing](docs/examples/distributed-tracing.md)

## Documentation used for development

- [Building an agent](https://github.com/elastic/apm/blob/master/docs/agents/agent-development.md)

## Credits
- [Zoilo Mora][link-author]
- [Verónica Expósito](https://www.linkedin.com/in/veronicaexpositocano/) (Logo)
- [All Contributors][link-contributors]

## License
Licensed under the [MIT license](http://opensource.org/licenses/MIT)

Read [LICENSE](LICENSE) for more information

[link-author]: https://github.com/zoilomora
[link-contributors]: https://github.com/zoilomora/elastic-apm-agent-php/contributors

[Intake API v2]: https://www.elastic.co/guide/en/apm/server/7.6/intake-api.html
[Elastic APM]: https://www.elastic.co/apm
[official APM Agent]: https://www.elastic.co/guide/en/apm/agent/index.html
[PHP 5.4]: https://www.php.net/ChangeLog-5.php#5.4.0
[API reference of version 7.6]: https://github.com/elastic/apm-server/tree/cd7a2425afa0f8d8726ea0905c03221d02322312/docs/spec
[composer]: https://getcomposer.org/
[official environment variables]: https://www.elastic.co/guide/en/apm/server/master/metadata-api.html#kubernetes-data
