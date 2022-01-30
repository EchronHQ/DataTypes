<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;
use Echron\Tools\Normalize\NormalizeConfig;
use Echron\Tools\Normalize\Normalizer;

class KeyValueStore
{
    private array $hashMap = [];
    private array $reversedHashMap = [];
    private array $cachedNormalizedKeys = [];

    private ?NormalizeConfig $normalizeConfig;

    public function __construct(NormalizeConfig $normalizeConfig = null, bool $skipNormalizer = false)
    {
        if (\is_null($normalizeConfig) && !$skipNormalizer) {
            $normalizeConfig = new NormalizeConfig();
        }
        $this->normalizeConfig = $normalizeConfig;
    }


    protected function normalizeKey($key)
    {
        if (!\is_null($this->normalizeConfig)) {
            if (isset($this->cachedNormalizedKeys[$key])) {
                return $this->cachedNormalizedKeys[$key];
            }
            $normalizedKey = Normalizer::normalize((string)$key, $this->normalizeConfig);
            $this->cachedNormalizedKeys[$key] = $normalizedKey;
            $key = $normalizedKey;
        }

        return $key;
    }

    public function add($key, $value, bool $overwriteIfExist = false): void
    {
        $normalizedKey = $this->normalizeKey($key);

        if (!$overwriteIfExist && \array_key_exists($normalizedKey, $this->hashMap)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with key "' . $normalizedKey . '"');
        }
        $this->reversedHashMap[$value] = $key;

        $this->hashMap[$normalizedKey] = $value;
    }

    public function getValueByKey($key)
    {
        $key = $this->normalizeKey($key);
        //TODO: isset or key_exists?
//        if (!\key_exists($key, $this->hashMap)) {
        if (!isset($this->hashMap[$key])) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap[$key];
    }

    public function getKeyByValue($value)
    {
        //TODO: isset or key_exists?
//        if (!\key_exists($value, $this->reversedHashMap)) {
        if (!isset($this->reversedHashMap[$value])) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist (' . \implode(', ', $this->reversedHashMap) . ')');
        }

        return $this->reversedHashMap[$value];
    }

    public function removeByKey($key): void
    {
        $key = $this->normalizeKey($key);
        $value = $this->getValueByKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function removeByValue($value): void
    {
        $key = $this->getKeyByValue($value);

        $key = $this->normalizeKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function getKeys(): array
    {
        return \array_values($this->reversedHashMap);
    }

    public function hasKey($key): bool
    {
        $key = $this->normalizeKey($key);

        return isset($this->hashMap[$key]);
        // \key_exists($key, $this->hashMap);
    }
}


