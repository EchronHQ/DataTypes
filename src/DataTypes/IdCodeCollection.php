<?php
declare(strict_types=1);

namespace Echron\DataTypes;

class IdCodeCollection extends BasicCollection
{

    private $idValueStore;
    private $codeValueStore;

    public function __construct()
    {
        parent::__construct();
        $this->idValueStore = new KeyValueStore();
        $this->codeValueStore = new KeyValueStore();
    }

    public function add(int $id, string $code, $value): int
    {
        $index = $this->addToCollection($value);
        if (!empty($id)) {
            $this->idValueStore->add($id, $index);
        }
        if (!empty($code)) {
            $this->codeValueStore->add($code, $index);
        }

        return $index;
    }

    public function removeByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function removeById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    public function getById(int $id)
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
