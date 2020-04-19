# Metadata

Metadata concerning the other objects in the stream.

## Minimum parameters

```php
<?php

use ZoiloMora\ElasticAPM\Events\Common\Service\Language;
use ZoiloMora\ElasticAPM\Events\Common\Service\Runtime;
use ZoiloMora\ElasticAPM\Events\Metadata\Metadata;
use ZoiloMora\ElasticAPM\Events\Metadata\Service;

$metadata = new Metadata(
    new Service(
        'example-project',
        Language::discover(),
        Runtime::discover()
    )
);
```

## All parameters

```php
<?php

use ZoiloMora\ElasticAPM\Events\Common\Process;
use ZoiloMora\ElasticAPM\Events\Common\Service\Framework;
use ZoiloMora\ElasticAPM\Events\Common\Service\Language;
use ZoiloMora\ElasticAPM\Events\Common\Service\Runtime;
use ZoiloMora\ElasticAPM\Events\Common\System;
use ZoiloMora\ElasticAPM\Events\Metadata\Metadata;
use ZoiloMora\ElasticAPM\Events\Metadata\Service;

$metadata = new Metadata(
    new Service(
        'example-project',
        Language::discover(),
        Runtime::discover(),
        new Framework(
            'Symfony',
            '4.4'
        ),
        'prod'
    ),
    Process::discover(),
    System::discover()
);
```
