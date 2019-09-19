<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\Tools\Normalize\NormalizeConfig;
use Echron\Tools\Normalize\Normalizer;

class KeyValueStore
{
    private $hashMap = [];
    private $reversedHashMap = [];

    /** @var NormalizeConfig */
    private $normalizeConfig = null;

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
            $key = Normalizer::normalize((string)$key, $this->normalizeConfig);
        }

        return $key;
    }

    public function add($key, $value)
    {
        $this->reversedHashMap[$value] = $key;

        $key = $this->normalizeKey($key);

        $this->hashMap[$key] = $value;
    }

    public function getValueByKey($key)
    {
        $key = $this->normalizeKey($key);
        //TODO: isset or key_exists?
        if (!\key_exists($key, $this->hashMap)) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap[$key];
    }

    public function getKeyByValue($value)
    {
        //TODO: isset or key_exists?
        if (!\key_exists($value, $this->reversedHashMap)) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist (' . \implode(', ', $this->reversedHashMap) . ')');
        }

        return $this->reversedHashMap[$value];
    }

    public function removeByKey($key)
    {
        $key = $this->normalizeKey($key);
        $value = $this->getValueByKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function removeByValue($value)
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

        return \key_exists($key, $this->hashMap);
    }
}


