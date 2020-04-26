<?php

namespace ZoiloMora\ElasticAPM\Utils\ControlGroup;

final class FileControlGroupRepository implements ControlGroupRepository
{
    const ALLOWED_OS = 'Linux';
    const PATH = '/proc/self/cgroup';

    /**
     * @return ControlGroup[]
     */
    public function findAll()
    {
        if (false === $this->isAllowedOperatingSystem()) {
            return [];
        }

        return $this->deserializeFile(self::PATH);
    }

    /**
     * @return bool
     */
    private function isAllowedOperatingSystem()
    {
        return self::ALLOWED_OS === PHP_OS;
    }

    /**
     * @param string $path
     *
     * @return ControlGroup[]
     */
    private function deserializeFile($path)
    {
        if (false === is_readable($path)) {
            return [];
        }

        $cGroup = file_get_contents($path);
        $lines = explode(PHP_EOL, $cGroup);

        $result = [];
        foreach ($lines as $line) {
            $fields = explode(':', $line);
            if (3 !== count($fields)) {
                continue;
            }

            list($hierarchyId, $controller, $path) = $fields;

            $result[] = new ControlGroup(
                $hierarchyId,
                $controller,
                $path
            );
        }

        return $result;
    }
}
