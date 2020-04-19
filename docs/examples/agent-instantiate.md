# Agent instantiate

```php
<?php

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\ElasticApmTracer;
use ZoiloMora\ElasticAPM\Pool\Memory\MemoryPoolFactory;
use ZoiloMora\ElasticAPM\Reporter\ApmServerCurlReporter;

$configuration = CoreConfiguration::create([
    'appName' => 'service-name',
]);

$reporter = new ApmServerCurlReporter(
    'http://apm-server:8200'
);

$poolFactory = MemoryPoolFactory::create();

$agent = new ElasticApmTracer(
    $configuration,
    $reporter,
    $poolFactory
);
```
