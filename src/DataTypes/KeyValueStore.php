<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;
use Echron\Tools\Normalize\NormalizeConfig;
use Echron\Tools\Normalize\Normalizer;

class KeyValueStore
{
    /** @var array<string, mixed> */
    private array $hashMap = [];
    /** @var array<mixed,string> */
    private array $reversedHashMap = [];
    /** @var array<string, string> */
    private array $cachedNormalizedKeys = [];

    private NormalizeConfig|null $normalizeConfig;

    public function __construct(NormalizeConfig $normalizeConfig = null, bool $skipNormalizer = false)
    {
        if (\is_null($normalizeConfig) && !$skipNormalizer) {
            $normalizeConfig = new NormalizeConfig();
        }
        $this->normalizeConfig = $normalizeConfig;
    }


    protected function normalizeKey(string $key): string
    {
        if (!\is_null($this->normalizeConfig)) {
            if (isset($this->cachedNormalizedKeys[$key])) {
                return $this->cachedNormalizedKeys[$key];
            }
            $normalizedKey = Normalizer::normalize($key, $this->normalizeConfig);
            $this->cachedNormalizedKeys[$key] = $normalizedKey;
            $key = $normalizedKey;
        }

        return $key;
    }

    public function add(string $key, mixed $value, bool $overwriteIfExist = false): void
    {
        $normalizedKey = $this->normalizeKey($key);

        if (!$overwriteIfExist && \array_key_exists($normalizedKey, $this->hashMap)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with key "' . $normalizedKey . '"');
        }
        $this->reversedHashMap[$value] = $key;

        $this->hashMap[$normalizedKey] = $value;
    }

    public function getValueByKey(string $key): mixed
    {
        $key = $this->normalizeKey($key);
        //TODO: isset or key_exists?
//        if (!\key_exists($key, $this->hashMap)) {
        if (!isset($this->hashMap[$key])) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap[$key];
    }

    public function getKeyByValue(mixed $value): string
    {
        //TODO: isset or key_exists?
//        if (!\key_exists($value, $this->reversedHashMap)) {
        if (!isset($this->reversedHashMap[$value])) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist (' . \implode(', ', $this->reversedHashMap) . ')');
        }

        return $this->reversedHashMap[$value];
    }

    public function removeByKey(string $key): void
    {
        $key = $this->normalizeKey($key);
        $value = $this->getValueByKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function removeByValue(mixed $value): void
    {
        $key = $this->getKeyByValue($value);

        $key = $this->normalizeKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return \array_values($this->reversedHashMap);
    }

    public function hasKey(string $key): bool
    {
        $key = $this->normalizeKey($key);

        return isset($this->hashMap[$key]);
        // \key_exists($key, $this->hashMap);
    }
}


