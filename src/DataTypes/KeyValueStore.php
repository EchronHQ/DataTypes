<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Ds\Map;
use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;
use Echron\Tools\Normalize\NormalizeConfig;
use Echron\Tools\Normalize\Normalizer;

class KeyValueStore
{
    /** @var Map<string, mixed> */
    private Map $hashMap;
    /** @var Map<mixed,string> */
    private Map $reversedHashMap;
    /** @var Map<string, string> */
    private Map $cachedNormalizedKeys;

    private NormalizeConfig|null $normalizeConfig;

    public function __construct(NormalizeConfig $normalizeConfig = null, bool $skipNormalizer = false)
    {
        $this->hashMap = new Map();
        $this->reversedHashMap = new Map();
        $this->cachedNormalizedKeys = new Map();

        if (\is_null($normalizeConfig) && !$skipNormalizer) {
            $normalizeConfig = new NormalizeConfig();
        }
        $this->normalizeConfig = $normalizeConfig;
    }

    public function add(string $key, mixed $value, bool $overwriteIfExist = false): void
    {
        $normalizedKey = $this->normalizeKey($key);

        if (!$overwriteIfExist && $this->hashMap->hasKey($normalizedKey)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with key "' . $normalizedKey . '"');
        }
        $this->reversedHashMap->put($value, $key);

        $this->hashMap->put($normalizedKey, $value);
    }

    public function getValueByKey(string $key): mixed
    {
        $key = $this->normalizeKey($key);
        //TODO: isset or key_exists?
//        if (!\key_exists($key, $this->hashMap)) {
        if (!$this->hashMap->hasKey($key)) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap->get($key);
    }

    public function getKeyByValue(mixed $value): string
    {
        //TODO: isset or key_exists?
//        if (!\key_exists($value, $this->reversedHashMap)) {
        if (!$this->reversedHashMap->hasKey($value)) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist.');
        }

        return $this->reversedHashMap->get($value);
    }

    public function removeByKey(string $key): void
    {
        $key = $this->normalizeKey($key);
        $value = $this->getValueByKey($key);

        $this->hashMap->remove($key);
        $this->reversedHashMap->remove($value);
    }

    public function removeByValue(mixed $value): void
    {
        $key = $this->getKeyByValue($value);

        $key = $this->normalizeKey($key);

        $this->hashMap->remove($key);
        $this->reversedHashMap->remove($value);
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return $this->reversedHashMap->values()->toArray();
    }

    public function hasKey(string $key): bool
    {
        $key = $this->normalizeKey($key);

        return $this->hashMap->hasKey($key);
        // \key_exists($key, $this->hashMap);
    }

    protected function normalizeKey(string $key): string
    {
        if (!\is_null($this->normalizeConfig)) {
            if ($this->cachedNormalizedKeys->hasKey($key)) {
                return $this->cachedNormalizedKeys->get($key);
            }
            $normalizedKey = Normalizer::normalize($key, $this->normalizeConfig);
            $this->cachedNormalizedKeys->put($key, $normalizedKey);
            $key = $normalizedKey;
        }

        return $key;
    }
}


