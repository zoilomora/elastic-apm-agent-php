<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

use ZoiloMora\ElasticAPM\Helper\Encoding;

class Process implements \JsonSerializable
{
    /**
     * Process ID of the service
     *
     * @var int
     */
    private $pid;

    /**
     * Parent process ID of the service
     *
     * @var int|null
     */
    private $ppid;

    /**
     * @var string|null
     */
    private $title;

    /**
     * Command line arguments used to start this process
     *
     * @var array|null
     */
    private $argv;

    /**
     * @param int $pid
     * @param int|null $ppid
     * @param string|null $title
     * @param array|null $argv
     */
    public function __construct($pid, $ppid = null, $title = null, array $argv = null)
    {
        $this->assertArgv($argv);

        $this->pid = $pid;
        $this->ppid = $ppid;
        $this->title = $title;
        $this->argv = $argv;
    }

    /**
     * @return int
     */
    public function pid()
    {
        return $this->pid;
    }

    /**
     * @return int|null
     */
    public function ppid()
    {
        return $this->ppid;
    }

    /**
     * @return string|null
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return array|null
     */
    public function argv()
    {
        return $this->argv;
    }

    /**
     * @return Process
     */
    public static function discover()
    {
        return new self(
            getmypid(),
            null,
            true === array_key_exists('_', $_SERVER)
                ? $_SERVER['_']
                : null,
            true === array_key_exists('argv', $_SERVER)
                ? $_SERVER['argv']
                : null
        );
    }

    /**
     * @param array|null $argv
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertArgv($argv)
    {
        if (null === $argv) {
            return;
        }

        foreach ($argv as $item) {
            if (false === is_string($item)) {
                throw new \InvalidArgumentException('All elements must be of string type.');
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'pid' => $this->pid,
            'ppid' => $this->ppid,
            'title' => Encoding::keywordField($this->title),
            'argv' => $this->argv,
        ];
    }
}
