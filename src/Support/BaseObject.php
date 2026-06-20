<?php

declare(strict_types=1);

namespace VioletSun\MAX\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class BaseObject extends Collection
{
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * Magically access collection data.
     *
     * @return mixed
     */
    public function __get($key)
    {
        return Arr::get($this->items, $key);
    }

    protected function str(string $key, ?string $default = null): ?string
    {
        $v = $this->get($key);
        return is_string($v) ? $v : $default;
    }

    protected function int(string $key, ?int $default = null): ?int
    {
        $v = $this->get($key);
        if (is_int($v)) return $v;
        if (is_numeric($v)) return (int)$v;
        return $default;
    }

    protected function bool(string $key, ?bool $default = null): ?bool
    {
        $v = $this->get($key);
        if (is_bool($v)) return $v;
        if (is_numeric($v)) return (bool)$v;
        if (is_string($v)) return in_array(strtolower($v), ['1', 'true', 'yes'], true);
        return $default;
    }

    protected function arr(string $key, ?array $default = null): ?array
    {
        $v = $this->get($key);
        return is_array($v) ? $v : $default;
    }
}
