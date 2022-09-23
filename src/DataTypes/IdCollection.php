<?php
declare(strict_types=1);

namespace Echron\DataTypes;

class IdCollection extends BasicCollection
{
    private IdValueStore $idValueStore;

    public function __construct()
    {
        parent::__construct();
        $this->idValueStore = new IdValueStore();

    }

    public function add(int $id, $value)
    {
        $index = $this->addToCollection($value);
        $this->idValueStore->add($id, $index);

    }

    public function removeById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        return $this->getByIndex($index);
    }

    public function hasId(int $id): bool
    {
        return $this->idValueStore->hasKey($id);
    }

    public function getIds(): array
    {
        return $this->idValueStore->getKeys();
    }
}
