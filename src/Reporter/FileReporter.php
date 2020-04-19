<?php

namespace ZoiloMora\ElasticAPM\Reporter;

use ZoiloMora\ElasticAPM\Helper\Cryptography;
use ZoiloMora\ElasticAPM\Helper\NDJson;

final class FileReporter implements Reporter
{
    const FILE_NAME_SIZE = 128;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
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
        file_put_contents(
            $this->getFilename(),
            NDJson::convert($events),
            LOCK_EX
        );
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function getFilename()
    {
        return sprintf(
            '%s%s%s.json',
            $this->basePath,
            DIRECTORY_SEPARATOR,
            Cryptography::generateRandomBitsInHex(self::FILE_NAME_SIZE)
        );
    }
}
