<?php

declare(strict_types = 1);

namespace ThinkOut;

class RequestHelper
{
    /**
     * @param array<string, mixed> $params
     * @param string[] $allowedKeys
     *
     * @return array<string, mixed>
     */
    public static function prepareParameters(
        array $params = [],
        array $allowedKeys = []
    ): array {
        foreach ($params as $key => $param) {
            if (!\in_array($key, $allowedKeys, true)) {
                unset($params[$key]);
            }
            if ($param instanceof \DateTimeInterface) {
                $params[$key] = $param->format('Y-m-d');
            }
            if (\is_bool($param)) {
                $params[$key] = (int) $param;
            }
        }

        return $params;
    }
}
