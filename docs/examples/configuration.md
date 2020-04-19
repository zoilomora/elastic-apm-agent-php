# Configuration

To configure the agent it is necessary to build the **CoreConfiguration** with an associative array.

```php
<?php

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;

$configuration = CoreConfiguration::create([
    // Required
    'appName' => 'service-name',

    // Optionals
    'active' => true,
    'appVersion' => '1.0',
    'frameworkName' => 'Symfony',
    'frameworkVersion' => '4.4',
    'environment' => 'prod',
    'stacktraceLimit' => 4,
    'metricSet' => true,
]);
```
