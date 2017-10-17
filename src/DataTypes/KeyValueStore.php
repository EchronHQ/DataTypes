<?php

namespace Echron\DataTypes;

class KeyValueStore
{
    private $hashMap = [];
    private $reversedHashMap = [];

    public function add($key, $value)
    {
        $this->hashMap[$key] = $value;
        $this->reversedHashMap[$value] = $key;
    }

    public function getValueByKey($key)
    {
        return $this->hashMap[$key];
    }

    public function getKeyByValue($value)
    {
        return $this->reversedHashMap[$value];
    }

    public function removeByKey($key)
    {
        $value = $this->getValueByKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function removeByValue($value)
    {
        $key = $this->getKeyByValue($value);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function getKeys(): array
    {
        return array_keys($this->hashMap);
    }

    public function hasKey($key): bool
    {
        return isset($this->hashMap[$key]);
    }
}