<?php

namespace VioletSun\MAX\Dto;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class BaseObject extends Collection
{
    // Определяется в наследниках:
    // protected static array $schema = [
    //     'key.path' => ClassName::class, // одиночный объект
    //     'key.list[]' => ClassName::class, // список объектов
    // ];
    public static function fromArray(array $data): static
    {
        $instance = new static($data);
        $instance->applySchema();
        return $instance;
    }

    protected function applySchema(): void
    {
        $schema = static::$schema ?? [];
        foreach ($schema as $path => $class) {
            $isList = str_ends_with($path, '[]');
            $cleanPath = $isList ? substr($path, 0, -2) : $path;

            if (!Arr::has($this->items, $cleanPath)) {
                continue;
            }

            $value = Arr::get($this->items, $cleanPath);

            if ($value === null) {
                continue;
            }

            if ($isList) {
                if (is_array($value)) {
                    $mapped = array_map(function ($v) use ($class) {
                        return is_array($v) ? $class::fromArray($v) : $v;
                    }, $value);
                    Arr::set($this->items, $cleanPath, $mapped);
                }
            } else {
                if (is_array($value)) {
                    Arr::set($this->items, $cleanPath, $class::fromArray($value));
                }
            }
        }
    }

// Хелперы для удобного доступа с типами
    public function getString(string $path, ?string $default = null): ?string
    {
        $v = Arr::get($this->items, $path, $default);
        return is_scalar($v) ? (string) $v : $default;
    }

    public function getInt(string $path, ?int $default = null): ?int
    {
        $v = Arr::get($this->items, $path, $default);
        return is_numeric($v) ? (int) $v : $default;
    }

    public function getBool(string $path, ?bool $default = null): ?bool
    {
        $v = Arr::get($this->items, $path, $default);
        return is_bool($v) ? $v : (is_numeric($v) ? (bool) $v : $default);
    }

    public function getObject(string $path): ?self
    {
        $v = Arr::get($this->items, $path);
        return $v instanceof self ? $v : null;
    }

    public function getList(string $path): array
    {
        $v = Arr::get($this->items, $path, []);
        return is_array($v) ? $v : [];
    }
}
