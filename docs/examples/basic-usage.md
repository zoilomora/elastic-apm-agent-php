# Basic usage

## Transaction with minimum parameters

```php
<?php

use ZoiloMora\ElasticAPM\ElasticApmTracer;

$agent = ElasticApmTracer::instance();

$transaction = $agent->startTransaction('GET /data/123456', 'request');
// ...work...
$transaction->stop('HTTP 200');

$agent->flush();
```

## Transaction with context

```php
<?php

use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\Events\Common\Context\Response;

$agent = ElasticApmTracer::instance();

$transaction = $agent->startTransaction('GET /data/123456', 'request');
// ...
$transaction->context()->setResponse(
    new Response(
        '200'
    )
);
$transaction->stop('HTTP 200');

$agent->flush();
```
