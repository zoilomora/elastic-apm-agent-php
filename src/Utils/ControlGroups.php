<?php

namespace ZoiloMora\ElasticAPM\Utils;

final class ControlGroups
{
    const PATH = '/proc/self/cgroup';

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var string|null
     */
    private $podId = null;

    /**
     * @var string|null
     */
    private $containerId = null;

    /**
     * @return self
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        if (false === $this->isAllowedOperatingSystem()) {
            return;
        }

        $cGroups = $this->deserialize();
        $this->extractInfo($cGroups);
    }

    /**
     * @return string|null
     */
    public function podId()
    {
        return $this->podId;
    }

    /**
     * @return string|null
     */
    public function containerId()
    {
        return $this->containerId;
    }

    /**
     * @return bool
     */
    private function isAllowedOperatingSystem()
    {
        return 'Linux' === PHP_OS;
    }

    /**
     * @return array
     */
    private function deserialize()
    {
        if (false === is_readable(self::PATH)) {
            return [];
        }

        $cGroup = file_get_contents(self::PATH);
        $lines = explode(PHP_EOL, $cGroup);

        $result = [];
        foreach ($lines as $line) {
            list($hierarchyId, $controller, $path) = explode(':', $line);

            $result[] = [
                'hierarchy_id' => $hierarchyId,
                'controller' => $controller,
                'path' => $path,
            ];
        }

        return $result;
    }

    /**
     * @param array $cGroups
     */
    private function extractInfo(array $cGroups)
    {
        foreach ($cGroups as $cGroup) {
            $path = $cGroup['path'];

            $dirname = $this->getDirname($path);
            $basename = $this->getBasename($path);

            $podId = $this->extractPodId($dirname);
            if (null !== $podId) {
                $this->podId = $podId;
                $this->containerId = $basename;

                break;
            }

            $containerId = $this->extractContainerId($basename);
            if (null !== $containerId) {
                $this->containerId = $containerId;
            }
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getDirname($path)
    {
        $position = 1 + strrpos($path, '/');

        return substr($path, 0, $position);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getBasename($path)
    {
        $position = 1 + strrpos($path, '/');
        $basename = substr($path, $position);

        if ('.scope' === substr($basename, -6)) {
            $basename = substr($basename, 0, -6);
        }

        return $basename;
    }

    /**
     * @param string $dirname
     *
     * @return string|null
     */
    private function extractPodId($dirname)
    {
        preg_match(
            '/(?:^\/kubepods\/[^\/]+\/pod([^\/]+)\/$)/',
            $dirname,
            $output
        );

        if (0 !== count($output)) {
            return $output[1];
        }

        preg_match(
            '/(?:^\/kubepods\.slice\/kubepods-[^\/]+\.slice\/kubepods-[^\/]+-pod([^\/]+)\.slice\/$)/',
            $dirname,
            $output
        );

        if (0 !== count($output)) {
            return $output[1];
        }

        return null;
    }

    /**
     * @param string $basename
     *
     * @return string|null
     */
    private function extractContainerId($basename)
    {
        preg_match(
            '/^[[:xdigit:]]{64}$/',
            $basename,
            $output_array
        );

        if (0 !== count($output_array)) {
            return $output_array[0];
        }

        return null;
    }
}
