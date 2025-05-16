<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Ds\Map;
use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;

class IdValueStore
{
    /** @var Map<int,mixed> */
    private Map $hashMap;
    /** @var Map<mixed,int> */
    private Map $reversedHashMap;


    public function __construct()
    {
        $this->hashMap = new Map();
        $this->reversedHashMap = new Map();
    }

    public function add(int $key, mixed $value, bool $overwriteIfExist = false): void
    {

        if (!$overwriteIfExist && $this->hashMap->hasKey($key)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with key "' . $key . '"');
        }
        $this->reversedHashMap->put($value, $key);

        $this->hashMap->put($key, $value);
    }

    public function getValueByKey(int $key): mixed
    {

        //TODO: isset or key_exists?
//        if (!\key_exists($key, $this->hashMap)) {
        if (!$this->hashMap->hasKey($key)) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap->get($key);
    }

    public function getKeyByValue(mixed $value): int
    {
        //TODO: isset or key_exists?
//        if (!\key_exists($value, $this->reversedHashMap)) {
        if (!$this->reversedHashMap->hasKey($value)) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist.');
        }

        return $this->reversedHashMap->get($value);
    }

    public function removeByKey(int $key): void
    {

        $value = $this->getValueByKey($key);

        $this->hashMap->remove($key);
        $this->reversedHashMap->remove($value);
    }

    public function removeByValue(mixed $value): void
    {
        $key = $this->getKeyByValue($value);

        $this->hashMap->remove($key);
        $this->reversedHashMap->remove($value);
    }

    /**
     * @return int[]
     */
    public function getKeys(): array
    {
        return $this->hashMap->keys()->toArray();
    }

    public function hasKey(int $key): bool
    {
        return $this->hashMap->hasKey($key);
    }
}


