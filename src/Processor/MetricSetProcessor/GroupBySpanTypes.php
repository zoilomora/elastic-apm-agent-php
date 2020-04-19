<?php

namespace ZoiloMora\ElasticAPM\Processor\MetricSetProcessor;

final class GroupBySpanTypes
{
    /**
     * @param string $transactionId
     * @param Span[] $spans
     *
     * @return Span[]
     */
    public function execute($transactionId, array $spans)
    {
        $groupings = [];

        foreach ($spans as $span) {
            $type = $span->type();
            $subType = $span->subType();

            if (false === array_key_exists($type, $groupings)) {
                $groupings[$type] = [];
            }

            if (false === array_key_exists($subType, $groupings[$type])) {
                $groupings[$type][$subType] = [
                    'count' => 0,
                    'sum' => 0,
                ];
            }

            $groupings[$type][$subType]['count']++;
            $groupings[$type][$subType]['sum'] = $groupings[$type][$subType]['sum'] + $span->sum();
        }

        $result = [];
        foreach ($groupings as $type => $subtypes) {
            foreach ($subtypes as $subtype => $data) {
                $result[] = new Span(
                    $transactionId,
                    $type,
                    $this->getSubType($subtype),
                    $data['count'],
                    $data['sum']
                );
            }
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return string|null
     */
    private function getSubType($value)
    {
        return '' === $value
            ? null
            : $value;
    }
}
