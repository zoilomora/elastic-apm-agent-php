<?php

namespace ZoiloMora\ElasticAPM\Helper\MetadataExtractor;

use ZoiloMora\ElasticAPM\Utils\ControlGroup\ControlGroupRepository;
use ZoiloMora\ElasticAPM\Utils\ControlGroup\FileControlGroupRepository;

final class KubernetesAndContainer
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var ControlGroupRepository
     */
    private $controlGroupRepository;

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
            self::$instance = new self(
                new FileControlGroupRepository()
            );
        }

        return self::$instance;
    }

    /**
     * @param ControlGroupRepository $controlGroupRepository
     */
    public function __construct(ControlGroupRepository $controlGroupRepository)
    {
        $this->controlGroupRepository = $controlGroupRepository;

        $this->extractInfo();
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
     * @return void
     */
    private function extractInfo()
    {
        $cGroups = $this->controlGroupRepository->findAll();

        foreach ($cGroups as $cGroup) {
            $path = $cGroup->path();

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
            $output
        );

        if (0 !== count($output)) {
            return $output[0];
        }

        preg_match(
            '/^[[:xdigit:]]{8}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4,}$/',
            $basename,
            $output
        );

        if (0 !== count($output)) {
            return $output[0];
        }

        return null;
    }
}
