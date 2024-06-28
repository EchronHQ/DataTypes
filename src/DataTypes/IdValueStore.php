<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\NotInCollectionException;
use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;

class IdValueStore
{
    /** @var array<int, mixed> */
    private array $hashMap = [];
    /** @var array<mixed,int> */
    private array $reversedHashMap = [];


    public function __construct()
    {
    }

    public function add(int $key, mixed $value, bool $overwriteIfExist = false): void
    {

        if (!$overwriteIfExist && \array_key_exists($key, $this->hashMap)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with key "' . $key . '"');
        }
        $this->reversedHashMap[$value] = $key;

        $this->hashMap[$key] = $value;
    }

    public function getValueByKey(int $key): mixed
    {

        //TODO: isset or key_exists?
//        if (!\key_exists($key, $this->hashMap)) {
        if (!isset($this->hashMap[$key])) {
            throw new NotInCollectionException('Key "' . $key . '" does not exist');
        }

        return $this->hashMap[$key];
    }

    public function getKeyByValue(mixed $value): int
    {
        //TODO: isset or key_exists?
//        if (!\key_exists($value, $this->reversedHashMap)) {
        if (!isset($this->reversedHashMap[$value])) {
            throw new NotInCollectionException('Value "' . $value . '" does not exist (' . \implode(', ', $this->reversedHashMap) . ')');
        }

        return $this->reversedHashMap[$value];
    }

    public function removeByKey(int $key): void
    {

        $value = $this->getValueByKey($key);

        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    public function removeByValue(mixed $value): void
    {
        $key = $this->getKeyByValue($value);


        unset($this->hashMap[$key]);
        unset($this->reversedHashMap[$value]);
    }

    /**
     * @return int[]
     */
    public function getKeys(): array
    {
        return \array_values($this->reversedHashMap);
    }

    public function hasKey(int $key): bool
    {
        return isset($this->hashMap[$key]);
    }
}


