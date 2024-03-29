<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Exception\ObjectAlreadyInCollectionException;
use Echron\Tools\Normalize\NormalizeConfig;

class IdCodeCollection extends BasicCollection
{

    private IdValueStore $idValueStore;
    private KeyValueStore $codeValueStore;

    public function __construct(NormalizeConfig $normalizeConfig = null)
    {
        parent::__construct();
        $this->idValueStore = new IdValueStore();
        $this->codeValueStore = new KeyValueStore($normalizeConfig);
    }

    public function add(int $id, string $code, mixed $value, bool $overwriteIfExist = false): int
    {
        // TODO: what if we add a duplicate id or code?
        // TODO: should we mark the collection as overridable instead of passing this as an argument?

        if (!$overwriteIfExist && $this->idValueStore->hasKey($id)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with id "' . $id . '"');
        }
        if (!$overwriteIfExist && !empty($code) && $this->codeValueStore->hasKey($code)) {
            throw new ObjectAlreadyInCollectionException('There is already a value with code "' . $code . '"');
        }

        $index = $this->addToCollection($value);
        //if (!empty($id)) {
        $this->idValueStore->add($id, $index, $overwriteIfExist);
        //}
        if (!empty($code)) {
            $this->codeValueStore->add($code, $index, $overwriteIfExist);
        }

        return $index;
    }

    public function removeByCode(string $code): void
    {
        $index = $this->codeValueStore->getValueByKey($code);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function removeById(int $id): void
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getByCode(string $code): mixed
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    public function getById(int $id): mixed
    {
        $index = $this->idValueStore->getValueByKey($id);

        return $this->getByIndex($index);
    }

    public function hasCode(string $code): bool
    {
        return $this->codeValueStore->hasKey($code);
    }

    public function hasId(int $id): bool
    {
        return $this->idValueStore->hasKey($id);
    }

    public function getIds(): array
    {
        return $this->idValueStore->getKeys();
    }

    public function getCodes(): array
    {
        return $this->codeValueStore->getKeys();
    }

}
