<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Helper\KeyHelper;

class KeyValueStore
{
    private $hashMap = [];
    private $reversedHashMap = [];

    private $normalizeKey = false;

    public function __construct(bool $normalizeKey = false)
    {
        $this->normalizeKey = $normalizeKey;
    }

    public function add($key, $value)
    {
        $this->reversedHashMap[$value] = $key;

        if ($this->normalizeKey) {
            $key = KeyHelper::formatKey((string)$key);
        }
        $this->hashMap[$key] = $value;

    }

    public function getValueByKey($key)
    {
        if ($this->normalizeKey) {
            $key = KeyHelper::formatKey((string)$key);
        }
        //TODO: isset or key_exists?
        if (!isset($this->hashMap[$key])) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap[$key];
    }

    public function getKeyByValue($value)
    {
        //TODO: isset or key_exists?
        if (!isset($this->reversedHashMap[$value])) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist');
        }

        return $this->reversedHashMap[$value];
    }

    public function removeByKey($key)
    {
        if ($this->normalizeKey) {
            $key = KeyHelper::formatKey((string)$key);
        }
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
        return \array_values($this->reversedHashMap);
    }

    public function hasKey($key): bool
    {
        if ($this->normalizeKey) {
            $key = KeyHelper::formatKey((string)$key);
        }

        return isset($this->hashMap[$key]);
    }
}


