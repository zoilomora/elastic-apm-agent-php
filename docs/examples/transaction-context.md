# Transaction Context

Any arbitrary contextual information about the event, captured by the agent or provided by the user.

## Context for command consuming worker example

```php
<?php

use ZoiloMora\ElasticAPM\Events\Common\Context;
use ZoiloMora\ElasticAPM\Events\Common\Message;
use ZoiloMora\ElasticAPM\Events\Common\Message\Queue;

$context = new Context(
    null, // custom
    null, // response
    null, // request
    null, // tags
    null, // user
    new Message(
        new Queue('commands')
    )
);
```

## Context for the http request example

```php
<?php

use ZoiloMora\ElasticAPM\Events\Common\Context;
use ZoiloMora\ElasticAPM\Events\Common\Context\Response;
use ZoiloMora\ElasticAPM\Events\Common\Request;
use ZoiloMora\ElasticAPM\Events\Common\User;

$context = new Context(
    null, // custom
    null, // response: not yet known
    Request::discover(),
    null, // tags
    new User(
        1234,
        'veronica@example.com',
        'veronica'
    )
);

// ...work...

$context->setResponse(
    new Response(
        200 // HttpStatusCode
    )
);
```
