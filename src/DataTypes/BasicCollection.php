<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Ds\Map;

/**
 * @template-covariant TValue of mixed
 */
abstract class BasicCollection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    /**
     * @var Map<int, TValue>
     */
    private Map $collection;
    private int $index = 0;

    public function __construct()
    {
        $this->collection = new Map();
    }

    final public function count(): int
    {
        return $this->collection->count();
    }

    function jsonSerialize(): array
    {
        //TODO: good idea to remove keys?
        $data = [];
        /** @var IdCodeObject $item */
        foreach ($this->collection as $item) {
            $data[] = $item->jsonSerialize();
        }

        return $data;
    }

    /**
     * @return \ArrayIterator<int, TValue>
     */
    public function getIterator(): \Traversable
    {
        //TODO: is it possible to not return a new iterator on every call? this is not working for nested iterations!
        //        if (\is_null($this->iterator)) {
        //            $this->iterator = new \ArrayIterator($this->collection);
        //        }
        //        $this->iterator->rewind();
        return $this->collection->getIterator();
    }

    /**
     * @param TValue $data
     * @return int
     */
    final protected function addToCollection(mixed $data): int
    {
        $index = $this->index;
        $this->collection->put($index, $data);

        $this->index++;

        return $index;
    }

    final protected function removeFromCollection(int $index): void
    {
        $this->collection->remove($index);
    }

    /**
     * @return TValue
     */
    final protected function getByIndex(int $index)
    {
        return $this->collection->get($index);
    }

}
