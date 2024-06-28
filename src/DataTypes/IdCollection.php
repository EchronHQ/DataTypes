<?php
declare(strict_types=1);

namespace Echron\DataTypes;
/**
 * @template TValue
 *
 * @extends BasicCollection<TValue>
 */
class IdCollection extends BasicCollection
{
    private IdValueStore $idValueStore;

    public function __construct()
    {
        parent::__construct();
        $this->idValueStore = new IdValueStore();

    }

    /**
     * @param int $id
     * @param TValue $value
     * @return void
     * @throws Exception\ObjectAlreadyInCollectionException
     */
    public function add(int $id, mixed $value): void
    {
        $index = $this->addToCollection($value);
        $this->idValueStore->add($id, $index);

    }

    public function removeById(int $id): void
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    /**
     * @param int $id
     * @return TValue
     * @throws Exception\NotInCollectionException
     */
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
