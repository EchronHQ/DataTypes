<?php
declare(strict_types=1);

namespace Echron\DataTypes;

/**
 * @template-covariant TValue of mixed
 */
abstract class BasicCollection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    /**
     * @var array<int, TValue>
     */
    private array $collection = [];
    private int $index = 0;

    public function __construct()
    {
    }

    /**
     * @param TValue $data
     * @return int
     */
    final protected function addToCollection(mixed $data): int
    {
        $index = $this->index;
        $this->collection[$index] = $data;

        $this->index++;

        return $index;
    }

    final protected function removeFromCollection(int $index): void
    {
        unset($this->collection[$index]);
    }

    /**
     * @return TValue
     */
    final protected function getByIndex(int $index)
    {
        return $this->collection[$index];
    }

    final public function count(): int
    {
        return count($this->collection);
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
        return new \ArrayIterator($this->collection);
    }

}
